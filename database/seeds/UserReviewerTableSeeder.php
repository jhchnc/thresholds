<?php

use Illuminate\Database\Seeder;

class UserReviewerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Reviewer',
            'email' => 'your@email.com',
            'password' => bcrypt('secret'),
        ]);
    }
}
