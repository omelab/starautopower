<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('users')->insert([
            'name' 			=> 'shamim',
            'email' 		=> 'shamim@gmail.com',
            'mobile'		=> '01758083458',
            'password' 		=> Hash::make('123456'),
            'isVerified'	=> 0,  
        ]);
    }
}
