<?php

use App\Models\Work;
use Illuminate\Database\Seeder;

class setTempDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $works = Work::whereNull('temperature')->get();
        foreach ($works as $work) {
            $work->temperature = 98;
            $work->save();
        }
    }
}
