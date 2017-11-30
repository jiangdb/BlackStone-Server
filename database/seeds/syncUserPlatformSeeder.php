<?php

use App\User;
use Illuminate\Database\Seeder;

class syncUserPlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $platforms = array_keys(User::$support_platforms);
        $users = User::with($platforms)->get();
        foreach ($users as $user) {
            $p = [];
            foreach ($platforms as $platform) {
                if ($user->$platform) {
                    $p[] = $platform;
                }
            }
            $user->platforms = implode(';', $p);
            $user->save();
        }
    }
}
