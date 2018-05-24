<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\ChallengeCollection;
use App\Models\Device;
use App\Models\Challenge;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ChallengeController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function leaderBoard()
    {
        $challenges = Challenge::with(['user','user.wx_user'])->orderBy('score','desc')->paginate(5);

        $user = JWTAuth::parseToken()->authenticate();
        $bestChallenge = $user->challenges()->orderBy('score', 'desc')->first();
        $userBest = [];
        if ($bestChallenge) {
            $userBest['rank'] = $bestChallenge->rank;
            $userBest['score'] = $bestChallenge->score;
        }
        return (new ChallengeCollection($challenges))->additional(['userBest' => $userBest]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'device' => 'nullable',
            'score'         => 'required',
        ]);

        $user = JWTAuth::parseToken()->authenticate();
        $practice = $user->challenges()->create($request->only([
            'score',
        ]));
        $device = Device::where('serial_number', $request->device)->first();
        if ($device) {
            $practice->device()->associate($device);
            $practice->save();
        }

        $max = $user->challenges()->max('score');
        $rank = $practice->rank;

        return $this->responseSuccessWithExtrasAndMessage([
            'max' => $max,
            'rank' => $rank,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
