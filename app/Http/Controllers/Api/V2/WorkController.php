<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\Device;
use App\Models\Work;
use Illuminate\Http\Request;
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
           'rate'          => $work->rating,
           'flavor'        => $work->flavor,
           'accessories'   => $work->accessories,
           'feeling'       => $work->feeling,
           'bean'          => $work->bean_category,
           'bean_weight'   => $work->bean_weight,
           'water_ratio'   => $work->water_ratio,
           'water_weight'  => $work->water_weight,
           'grand_size'    => $work->grand_size,
           'temperature'   => $work->temperature,
           'work_time'     => $work->work_time,
           'data'          => $work->data
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'device'        => 'nullable',
            'bean_category' => 'required',
            'bean_weight'   => 'required',
            'water_ratio'   => 'required',
            'water_weight'  => 'required',
            'grand_size'    => 'nullable',
            'temperature'   => 'required',
            'work_time'     => 'required|numeric',
            'rating'        => 'required|numeric',
            'flavor'        => 'nullable',
            'accessories'   => 'nullable',
            'feeling'       => 'nullable',
            'data'          => 'required',
            'started_at'    => 'required',
        ]);

        $user = JWTAuth::parseToken()->authenticate();
        $work = $user->works()->create($request->only([
            'bean_category',
            'bean_weight',
            'water_ratio',
            'water_weight',
            'grand_size',
            'temperature',
            'work_time',
            'rating',
            'flavor',
            'accessories',
            'feeling',
            'data',
            'started_at',
        ]));
        $device = Device::where('serial_number', $request->device)->first();
        if ($device) {
            $work->device()->associate($device);
            $work->save();
        }

        return $this->responseSuccessWithExtrasAndMessage([
            'id' => $work->id,
            'shareUrl' => route('share', $work->id),
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
