<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StudentsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $students = [];
        $userId = 1;

        for ($i = 0; $i < 10000; $i++) {
            $students[] = [
                'name' => $faker->name,
                'matric_no' => $faker->unique()->numerify('A####'),
                'dob' => $faker->date,
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'faculty' => $faker->randomElement([
                    'Faculty of Civil Engineering',
                    'Faculty of Mechanical Engineering',
                    'Faculty of Electrical Engineering',
                    'Faculty of Chemical & Energy Engineering',
                    'Faculty of Computing',
                    'Faculty of Science',
                    'Faculty of Built Environment & Surveying',
                    'Faculty of Social Sciences & Humanities',
                    'Faculty of Management',
                    'Faculty of Artificial Intelligence',
                    'Malaysia-Japan International Institute of Technology',
                    'Azman Hashim International Business School'
                ]),
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert in chunks of 1000 to avoid hitting the MySQL limit
            if (count($students) === 1000) {
                DB::table('students')->insert($students);
                $students = []; // Clear the array after insertion
            }
        }

        // Insert any remaining students
        if (!empty($students)) {
            DB::table('students')->insert($students);
        }
    }
}