<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // AKUN ADMIN
        // =========================
        User::create([
            'name' => 'Admin HomeFix',
            'email' => 'admin@homefix.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // =========================
        // AKUN PENGGUNA
        // =========================
        User::create([
            'name' => 'Pengguna HomeFix',
            'email' => 'pengguna@homefix.test',
            'password' => Hash::make('password'),
            'role' => 'pengguna',
        ]);

        // =========================
        // AKUN TEKNISI
        // =========================
        User::create([
            'name' => 'Teknisi HomeFix',
            'email' => 'teknisi@homefix.test',
            'password' => Hash::make('password'),
            'role' => 'teknisi',
        ]);

        // =========================
        // KATEGORI
        // =========================
        $elektronik = Category::create([
            'name' => 'Elektronik',
            'description' => 'Perbaikan dan perawatan perangkat elektronik.',
            'is_active' => true,
        ]);

        $ac = Category::create([
            'name' => 'AC',
            'description' => 'Perawatan dan perbaikan AC.',
            'is_active' => true,
        ]);

        $air = Category::create([
            'name' => 'Air & Plumbing',
            'description' => 'Perbaikan saluran air dan plumbing rumah.',
            'is_active' => true,
        ]);

        $rumah = Category::create([
            'name' => 'Perawatan Rumah',
            'description' => 'Berbagai kebutuhan perawatan rumah.',
            'is_active' => true,
        ]);

        // =========================
        // LAYANAN
        // =========================
        Service::create([
            'category_id' => $elektronik->id,
            'name' => 'Perbaikan TV',
            'description' => 'Pengecekan dan perbaikan televisi.',
            'price' => 75000,
            'duration' => 60,
            'is_active' => true,
        ]);

        Service::create([
            'category_id' => $elektronik->id,
            'name' => 'Perbaikan Kulkas',
            'description' => 'Pengecekan dan perbaikan kulkas.',
            'price' => 100000,
            'duration' => 90,
            'is_active' => true,
        ]);

        Service::create([
            'category_id' => $ac->id,
            'name' => 'Cuci AC',
            'description' => 'Membersihkan AC agar tetap bekerja dengan baik.',
            'price' => 75000,
            'duration' => 60,
            'is_active' => true,
        ]);

        Service::create([
            'category_id' => $ac->id,
            'name' => 'Service AC',
            'description' => 'Pengecekan dan perbaikan AC.',
            'price' => 100000,
            'duration' => 90,
            'is_active' => true,
        ]);

        Service::create([
            'category_id' => $air->id,
            'name' => 'Perbaikan Keran',
            'description' => 'Perbaikan keran air yang bocor atau rusak.',
            'price' => 50000,
            'duration' => 45,
            'is_active' => true,
        ]);

        Service::create([
            'category_id' => $air->id,
            'name' => 'Perbaikan Pipa',
            'description' => 'Perbaikan pipa air dan kebocoran.',
            'price' => 100000,
            'duration' => 90,
            'is_active' => true,
        ]);

        Service::create([
            'category_id' => $rumah->id,
            'name' => 'Perbaikan Lampu',
            'description' => 'Pemasangan dan perbaikan lampu rumah.',
            'price' => 50000,
            'duration' => 45,
            'is_active' => true,
        ]);

        Service::create([
            'category_id' => $rumah->id,
            'name' => 'Perbaikan Furniture',
            'description' => 'Perbaikan furniture rumah yang rusak.',
            'price' => 100000,
            'duration' => 90,
            'is_active' => true,
        ]);
    }
}