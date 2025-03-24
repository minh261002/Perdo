<?php

namespace Database\Seeders;

use App\Models\Admin;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Trần Công Minh',
            'email' => 'minhtc.dev@nextarea.vn',
            'password' => Hash::make('password'),
            'image' => 'https://letsenhance.io/static/03620c83508fc72c6d2b218c7e304ba5/11499/UpscalerAfter.jpg',
        ]);

        $this->call([
            ModuleSeeder::class,
        ]);
    }
}