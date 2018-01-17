<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Device;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class WorkController extends ApiController
{
    protected $tag = '[WorkController]: ';

    public function index(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $works = $user->works()->orderBy('created_at','desc')->select('id','bean_category','started_at')->paginate(20);
        return $this->responseSuccessWithExtrasAndMessage($works->toArray());
    }

    public function show($id)
    {
        $work = Work::find($id);
        if (!$work) {
            return $this->responseNotFoundWithMessage();
        }

        return $this->responseSuccessWithExtrasAndMessage([
           'rate'   => $work->rating,
           'flavor' => $work->flavor,
           'feeling' => $work->feeling,
           'bean'   => $work->bean_category,
           'bean_weight'   => $work->bean_weight,
           'water_ratio'   => $work->water_ratio,
           'water_weight'  => $work->water_weight,
           'grand_size'    => $work->grand_size,
           'temperature'   => $work->temperature,
           'work_time'     => $work->work_time,
           'data' => $work->data
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'device'        => 'required',
            'bean_category' => 'required',
            'bean_weight'   => 'required',
            'water_ratio'   => 'required',
            'water_weight'  => 'required',
            'grand_size'    => 'nullable',
            'temperature'   => 'required',
            'work_time'     => 'required|numeric',
            'rating'        => 'required|numeric',
            'flavor'        => 'nullable',
            'feeling'       => 'nullable',
            'data'          => 'required',
            'started_at'    => 'required',
        ]);

        $user = JWTAuth::parseToken()->authenticate();
        $work = $user->works()->create($request->all());
        $device = Device::where('serial_number', $request->device)->first();
        if ($device) {
            $work->device()->associate($device);
            $work->save();
        }

        return $this->responseSuccessWithExtrasAndMessage([
            'id' => $work->id,
        ]);
    }

    public function destroy($id)
    {
        $work = Work::find($id);
        if (!$work) {
            return $this->responseNotFoundWithMessage();
        }
        // delete
        $work->delete();

        return $this->responseSuccess();
    }
}
