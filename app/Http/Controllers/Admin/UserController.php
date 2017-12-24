<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('wx_user')->get();
        return view('admin.user.index', compact('users'));
    }

    public function getUsers(Request $request)
    {
        $total = User::count();

        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $order = $request->input('order');
        $columns = $request->input('columns');
        $search = $request->input('search');

        $users = User::offset($start)->limit($length)
            ->with(User::PLATFORM_WEIXIN)
            ->when($order, function ($query) use ($order, $columns) {
                return $query->orderBy($columns[$order[0]['column']]['name'], $order[0]['dir']);
            })
            ->when($search['value'], function ($query) use ($search) {
                return $query->where('id', 'like', '%'.$search['value'].'%')
                    ->orWhere('name', 'like', '%'.$search['value'].'%')
                    ->orWhere('platforms', 'like', '%'.$search['value'].'%');
            })
            ->get();

        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'avatar'    => '<img class="img-circle img-responsive" src="'.($user->wx_user!=null?($user->wx_user->avatar_url??'/images/default_avatar.png"'):'/images/default_avatar.png"').'">',
                'name'      => $user->name,
                'platforms' => $user->hasPlatform(User::PLATFORM_WEIXIN)?'<img class="user-platforms" src="/images/weixin.png">':'',
                'created_at'=> $user->created_at->toDateTimeString(),
                'updated_at'=> $user->updated_at->toDateTimeString(),
                'actions'   => '
                    <a class="btn btn-small btn-success hoffset1" href="'.route('admin.user.show', $user->id).'">
                        <i class="fa fa-info fa-fw" aria-hidden="true"></i>
                    </a>'
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('wx_user')->findOrFail($id);
        return view('admin.user.show', compact('user'));
    }


}
