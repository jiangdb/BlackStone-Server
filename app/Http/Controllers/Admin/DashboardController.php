<?php

namespace App\Http\Controllers\Admin;

use App\Models\Device;
use App\Models\Firmware;
use App\Models\Work;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $devices = Device::count();
        $firmwares = Firmware::count();
        $users = User::count();
        $works = Work::count();


        $last15day = Carbon::now()->subDays(15)->startOfDay();
        $user_counts_perday = User::where('created_at', '>', $last15day)
            ->select(DB::raw('count(id), Date(created_at)'))
            ->groupBy('Date(created_at)')
            ->orderBy('Date(created_at)', 'desc')
            ->get();
        $work_counts_perday = Work::where('created_at', '>', $last15day)
            ->select(DB::raw('count(id), Date(created_at)'))
            ->groupBy('Date(created_at)')
            ->orderBy('Date(created_at)', 'desc')
            ->get();

        $counts_perday = [];
        for ($date = $last15day; $date <= Carbon::now(); $date = $date->addDay() ) {
            $user_count = $user_counts_perday->where('Date(created_at)',$date->toDateString())->first();
            $work_count = $work_counts_perday->where('Date(created_at)',$date->toDateString())->first();

            $counts_perday[$date->toDateString()] = [
                'user' => $user_count?$user_count->getAttributeValue('count(id)'):'0',
                'work' => $work_count?$work_count->getAttributeValue('count(id)'):'0',
            ];
        }

        return view('admin.dashboard', compact('devices', 'firmwares', 'users', 'counts_perday', 'works'));
    }
}
