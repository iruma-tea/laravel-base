<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::factory()->create([
            'name' => 'sana',
            'login_id' => 'sano_id',
            'password' => Hash::make('hogehoge'),
        ]);

        Admin::factory()->create([
            'name' => 'sato',
            'login_id' => 'sato_id',
            'password' => Hash::make('fugafuga'),
        ]);
    }
}
