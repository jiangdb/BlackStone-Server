<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Device;
use App\Models\Firmware;
use Illuminate\Http\Request;

class DeviceController extends ApiController
{
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

        return $this->responseSuccessWithExtrasAndMessage(['download_url' => route('api.v1.device.ota.download', $firmware->id)]);
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
