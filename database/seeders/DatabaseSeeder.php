<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\ServiceOrder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        //Buat Role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $karyawanRole = Role::firstOrCreate(['name' => 'karyawan']);

        //Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
            ]
        );
        $admin->assignRole($adminRole);

        //Karyawan
        $acil = User::firstOrCreate(
            ['email' => 'acil@gmail.com'],
            [
                'name' => 'Acil',
                'password' => Hash::make('acil123'),
            ]
        );
        $acil->assignRole($karyawanRole);

        $jon = User::firstOrCreate(
            ['email' => 'jon@gmail.com'],
            [
                'name' => 'Jon',
                'password' => Hash::make('jon123'),
            ]
        );
        $jon->assignRole($karyawanRole);
    }
}
