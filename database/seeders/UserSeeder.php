<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'user1',
            'email'=>'fake@fake.com',
            'password'=>bcrypt('user1'),
            'points'=>987,
        ]);

        User::create([
            'name'=>'user2',
            'email'=>'harry@potter.com',
            'password'=>bcrypt('user2'),
            'points'=>5867,
        ]);

        User::create([
            'name'=>'user3',
            'email'=>'gendalf@thegrey.com',
            'password'=>bcrypt('user3'),
            'points'=>98743,
        ]);

    }
}
