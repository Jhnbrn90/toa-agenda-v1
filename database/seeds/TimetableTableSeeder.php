<?php

use Illuminate\Database\Seeder;

class TimetableTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('timetable')->insert([
            'school_hour' => 1,
            'starttime' => '08:30',
            'endtime' => '09:30',
        ]);

        DB::table('timetable')->insert([
            'school_hour' => 2,
            'starttime' => '09:30',
            'endtime' => '10:30',
        ]);

        DB::table('timetable')->insert([
            'school_hour' => 3,
            'starttime' => '10:50',
            'endtime' => '11:50',
        ]);

        DB::table('timetable')->insert([
            'school_hour' => 4,
            'starttime' => '11:50',
            'endtime' => '12:50',
        ]);

        DB::table('timetable')->insert([
            'school_hour' => 5,
            'starttime' => '13:20',
            'endtime' => '14:20',
        ]);

        DB::table('timetable')->insert([
            'school_hour' => 6,
            'starttime' => '14:20',
            'endtime' => '15:20',
        ]);

        DB::table('timetable')->insert([
            'school_hour' => 7,
            'starttime' => '15:30',
            'endtime' => '16:30',
        ]);
    }
}
