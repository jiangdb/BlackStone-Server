<?php

namespace App\Http\Controllers\Admin;

use App\Models\Device;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.device.index');
    }

    public function getDevices(Request $request)
    {
        $total = Device::count();

        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $order = $request->input('order');
        $columns = $request->input('columns');
        $search = $request->input('search');

        $devices = Device::offset($start)->limit($length)
            ->when($order, function ($query) use ($order, $columns) {
                return $query->orderBy($columns[$order[0]['column']]['name'], $order[0]['dir']);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where('model_number', 'like', '%'.$search['value'].'%')
                    ->orWhere('serial_number', 'like', '%'.$search['value'].'%')
                    ->orWhere('fw_version', 'like', '%'.$search['value'].'%')
                    ->orWhere('ip_address', 'like', '%'.$search['value'].'%')
                    ->orWhere('created_at', 'like', '%'.$search['value'].'%');
            })
            ->get();

        $data = [];
        foreach ($devices as $device) {
            $data[] = [
                'id'        => $device->id,
                'model'     => $device->model_number,
                'serial'    => $device->serial_number,
                'version'   => $device->fw_version,
                'ip'        => $device->ip_address,
                'created_at'=> $device->created_at->toDateTimeString(),
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
     * @param Device $device
     * @return \Illuminate\Http\Response
     */
    public function edit(Device $device)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Device $device
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Device $device)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Device $device
     * @return \Illuminate\Http\Response
     * @internal param Firmware $firmware
     */
    public function destroy(Device $device)
    {
    }
}
