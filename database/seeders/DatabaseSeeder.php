<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create employee users
        $aniUser = User::create([
            'name' => 'Ani Wijaya',
            'email' => 'ani@example.com',
            'password' => bcrypt('password'),
            'role' => 'karyawan',
        ]);

        $budiUser = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => bcrypt('password'),
            'role' => 'karyawan',
        ]);

        $citraUser = User::create([
            'name' => 'Citra Dewi',
            'email' => 'citra@example.com',
            'password' => bcrypt('password'),
            'role' => 'karyawan',
        ]);

        // Create employees linked to users
        Employee::create([
            'name' => 'Ani Wijaya',
            'email' => 'ani@example.com',
            'phone' => '081234567890',
            'user_id' => $aniUser->id,
        ]);

        Employee::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567891',
            'user_id' => $budiUser->id,
        ]);

        Employee::create([
            'name' => 'Citra Dewi',
            'email' => 'citra@example.com',
            'phone' => '081234567892',
            'user_id' => $citraUser->id,
        ]);

        // Create services
        Service::create([
            'name' => 'Potong Rambut',
            'description' => 'Potong rambut profesional dengan gaya terbaru',
            'price' => 50000,
            'duration' => 30,
        ]);

        Service::create([
            'name' => 'Creambath',
            'description' => 'Perawatan rambut dengan produk kualitas premium',
            'price' => 75000,
            'duration' => 45,
        ]);

        Service::create([
            'name' => 'Facial Treatment',
            'description' => 'Perawatan wajah lengkap untuk kulit sehat bercahaya',
            'price' => 100000,
            'duration' => 60,
        ]);

        Service::create([
            'name' => 'Massage Relaksasi',
            'description' => 'Pijat tradisional untuk relaksasi tubuh',
            'price' => 80000,
            'duration' => 60,
        ]);

        Service::create([
            'name' => 'Manicure & Pedicure',
            'description' => 'Perawatan kuku tangan dan kaki',
            'price' => 60000,
            'duration' => 45,
        ]);
    }
}
