<?php

namespace App\Http\Controllers\Admin;

use App\Models\Challenge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.challenge.index');
    }

    public function leaderBoard(Request $request)
    {
        $total = Challenge::count();
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $order = $request->input('order');
        $columns = $request->input('columns');
        $search = $request->input('search');

        $challenges = Challenge::offset($start)->limit($length)
            ->with('user.wx_user')
            ->orderBy('score', 'desc')
            ->get();
        $data = [];
        foreach ($challenges as $index=>$challenge) {
            $data[] = [
                'rank'      => $start+$index+1,
                'avatar'    => '<img class="img-circle img-responsive" src="'.($challenge->user->wx_user!=null?($challenge->user->wx_user->avatar_url??'/images/default_avatar.png"'):'/images/default_avatar.png"').'">',
                'name'      => $challenge->user->name,
                'score'     => $challenge->score,
                'created_at'=> $challenge->created_at->toDateTimeString(),
            ];
        }
        $result = [
            'draw'              =>$draw,
            'recordsTotal'      =>$total,
            'recordsFiltered'   =>$total,
            'data'              =>$data
        ];
        return response()->json($result);
    }

    public function clear()
    {
        Challenge::where('id','>', '0')->delete();
        return redirect()->route('admin.challenge.index');
    }
}
