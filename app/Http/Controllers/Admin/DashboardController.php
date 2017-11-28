<?php

namespace App\Http\Controllers\Admin;

use App\Models\Device;
use App\Models\Firmware;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $devices = Device::count();
        $firmwares = Firmware::count();
        $users = User::count();
        return view('admin.dashboard', compact('devices', 'firmwares', 'users'));
    }
}
