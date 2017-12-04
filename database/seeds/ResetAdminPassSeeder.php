<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admin = User::where('name','admin')->first();
//        $admin->password = Hash::make('Y?3&EHA^jzTARGyC');
        $admin->password = Hash::make('ABCabc01');
        $admin->save();
    }
}
