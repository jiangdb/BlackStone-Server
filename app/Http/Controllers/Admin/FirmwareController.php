<?php

namespace App\Http\Controllers\Admin;

use App\Models\Firmware;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class FirmwareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $firmwares = Firmware::all();
        return view('admin.firmware.index', compact('firmwares'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.firmware.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'model_number' => 'required|string|max:255',
            'version' => 'required|string|size:7',
            'firmware' => 'required|file|mimes:bin',
        ]);

        $versionCode = Firmware::transVersionCode($request->version);
        $md5 = md5_file($request->file('firmware'));
        $path = $request->file('firmware')->store($request->model_number.'/'.$request->version);

        Firmware::create(array_merge($validatedData, [
            'path' => $path,
            'md5'  => $md5,
            'version_code' => $versionCode,
        ]));

        Session::flash('message', 'Successfully added firmware!');
        return redirect()->route('admin.firmware.index');
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
     * @param Firmware $firmware
     * @return \Illuminate\Http\Response
     */
    public function edit(Firmware $firmware)
    {
        return view('admin.firmware.edit', compact('firmware'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Firmware $firmware
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Firmware $firmware)
    {
        $validatedData = $request->validate([
            'model_number' => 'required|string|max:255',
            'version' => 'required|string|size:7',
            'version_code' => 'required|integer',
        ]);

        if ($request->has('firmware')) {
            $validatedData['md5'] = md5_file($request->file('firmware'));
            $validatedData['path'] = $request->file('firmware')->store($request->model_number.'/'.$request->version);
        }
        $firmware->fill($validatedData);
        $firmware->save();

        Session::flash('message', 'Successfully updated firmware!');
        return redirect()->route('admin.firmware.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Firmware $firmware
     * @return \Illuminate\Http\Response
     */
    public function destroy(Firmware $firmware)
    {
        // delete
        $firmware->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the firmware!');
        return redirect()->route('admin.firmware.index');
    }

    public function download($id)
    {
        $firmware = Firmware::findOrFail($id);
        return response()->download(storage_path('app/'.$firmware->path), $firmware->model_number.'_'.$firmware->version.'.bin');
    }
}
