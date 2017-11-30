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
        $works = Work::orderBy('created_at','desc')->select('id','bean_category','started_at')->paginate(20);
        return $this->responseSuccessWithExtrasAndMessage($works->toArray());
    }

    public function store(Request $request)
    {
        Log::info($this->tag.print_r($request->all(),true));

        $this->validate($request, [
            'device'        => 'required',
            'bean_category' => 'required',
            'bean_weight'   => 'required',
            'water_ratio'   => 'required',
            'water_weight'  => 'required',
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

        return $this->responseSuccess();
    }

}
