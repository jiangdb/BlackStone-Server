<?php

namespace App\Http\Controllers\Api\V2;

use App\Jobs\QueryLocation;
use App\Models\Device;
use App\Models\Firmware;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeviceController extends ApiController
{
    public function index(Request $request)
    {
        if ($request->has('date')) {
            $date = new Carbon($request->input('date'));
            $devices = Device::whereDate('created_at', $date)
                ->orderBy('created_at','desc')->paginate(10);
        }else{
            $devices = Device::select(DB::raw('date(created_at) as dates'), DB::raw('count(*) as count'))
                ->groupBy('dates')->orderBy('dates', 'desc')->simplePaginate(1);
        }

        return $this->responseSuccessWithExtrasAndMessage($devices->toArray());
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'model_number'  => 'required|max:255',
            'serial_number' => 'required|unique:devices|string|size:12',
            'fw_version'    => 'required|string|size:7',
            'ip_address'    => 'nullable|ip',
            'latitude'      => 'nullable|numeric|min:-90|max:90',
            'longitude'     => 'nullable|numeric|min:-180|max:180',
        ]);

        Device::create($request->only([
            'model_number',
            'serial_number',
            'fw_version',
            'ip_address',
            'latitude',
            'longitude'
        ]));

        $count = Device::whereDate('created_at', Carbon::today())->count();
        return $this->responseSuccessWithExtrasAndMessage(['total' => $count]);
    }

    public function online(Request $request)
    {
        $this->validate($request, [
            'model_number'  => 'required|max:255',
            'serial_number' => 'required|string|size:12',
            'fw_version'    => 'required|string|size:7',
            'ip_address'    => 'nullable',
        ]);

        $device = Device::where('serial_number', $request->serial_number)->first();
        if ($device == NULL) {
            return $this->responseNotFoundWithMessage();
        }

        if ($request->ip_address && $request->ip_address != $device->ip_address)  {
            QueryLocation::dispatch($device);
        }
        $device->model_number = $request->model_number;
        $device->fw_version = $request->fw_version;
        $device->ip_address = $request->ip_address??$device->ip_address;
        if ($device->isDirty()) {
            $device->save();
        }else{
            $device->touch();
        }
        return $this->responseSuccess();
    }

    public function getOta(Request $request, $model)
    {
        $this->validate($request, [
            'version'   => 'required|string|size:7',
        ]);

        $versionCode = Firmware::transVersionCode($request->version);
        $firmware = Firmware::where('model_number',$model)->where('version_code','>', $versionCode)->orderBy('version_code', 'desc')->first();
        if ($firmware == null) {
            return $this->responseNotFoundWithMessage();
        }

        return $this->responseSuccessWithExtrasAndMessage([
            'id' => $firmware->id,
            'version' => $firmware->version,
            'download_url' => route('api.v2.device.ota.download', $firmware->id),
            'description' => $firmware->description,
        ]);
    }

    public function downloadOta($id)
    {
        $firmware = Firmware::find($id);
        if ($firmware == null) {
            return $this->responseNotFoundWithMessage();
        }
        return response()->download(storage_path('app/'.$firmware->path), $firmware->model_number.'_'.$firmware->version.'.bin');
    }
}
