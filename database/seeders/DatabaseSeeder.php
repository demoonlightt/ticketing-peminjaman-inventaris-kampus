<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\MahasiswaProfile;
use App\Models\OfficerProfile;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\BorrowRequest;
use App\Models\BorrowRequestItem;
use App\Models\Handover;
use App\Models\ReturnRecord;
use App\Models\Fine;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign keys during truncation
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        // Truncate tables
        Fine::truncate();
        ReturnRecord::truncate();
        Handover::truncate();
        BorrowRequestItem::truncate();
        BorrowRequest::truncate();
        Inventory::truncate();
        Category::truncate();
        OfficerProfile::truncate();
        MahasiswaProfile::truncate();
        User::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        // Create Users
        $admin = User::create([
            'name' => 'Administrator SIPINJAM',
            'email' => 'admin@sipinjam.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $officer = User::create([
            'name' => 'Hendra Setiawan',
            'email' => 'officer@sipinjam.com',
            'password' => Hash::make('password'),
            'role' => 'officer',
            'status' => 'active',
        ]);

        OfficerProfile::create([
            'user_id' => $officer->id,
            'employee_number' => 'NIP198901022022031001',
            'division' => 'Bagian Perlengkapan & Inventaris',
        ]);

        $student1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@kampus.ac.id',
            'password' => Hash::make('password'),
            'role' => 'student',
            'status' => 'active',
        ]);

        MahasiswaProfile::create([
            'user_id' => $student1->id,
            'nim' => '12345601',
            'prodi' => 'Teknik Informatika',
            'fakultas' => 'Teknik',
            'angkatan' => 2023,
        ]);

        $student2 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@kampus.ac.id',
            'password' => Hash::make('password'),
            'role' => 'student',
            'status' => 'active',
        ]);

        MahasiswaProfile::create([
            'user_id' => $student2->id,
            'nim' => '12345602',
            'prodi' => 'Sistem Informasi',
            'fakultas' => 'Teknik',
            'angkatan' => 2023,
        ]);

        $student3 = User::create([
            'name' => 'Reza Rahadian',
            'email' => 'reza@kampus.ac.id',
            'password' => Hash::make('password'),
            'role' => 'student',
            'status' => 'suspended',
        ]);

        MahasiswaProfile::create([
            'user_id' => $student3->id,
            'nim' => '12345699',
            'prodi' => 'Kedokteran',
            'fakultas' => 'Kedokteran',
            'angkatan' => 2022,
        ]);

        // Create Categories
        $catElectronics = Category::create([
            'name' => 'Elektronik',
            'description' => 'Barang-barang elektronik penunjang perkuliahan dan kegiatan kampus.',
        ]);

        $catOffice = Category::create([
            'name' => 'Peralatan Kantor',
            'description' => 'Peralatan administrasi umum dan perkantoran.',
        ]);

        $catLab = Category::create([
            'name' => 'Laboratorium',
            'description' => 'Alat-alat praktikum laboratorium sains dan teknologi.',
        ]);

        // Create Inventories
        $invProyektor = Inventory::create([
            'category_id' => $catElectronics->id,
            'code' => 'INV-ELK-001',
            'name' => 'Proyektor Epson EB-X400',
            'description' => 'Proyektor 3LCD dengan tingkat kecerahan 3300 lumens, resolusi XGA.',
            'total_stock' => 10,
            'available_stock' => 8, // 2 currently borrowed/pending
            'location' => 'Gedung C Lantai 2',
            'image' => null,
            'condition' => 'baik',
        ]);

        $invLaptop = Inventory::create([
            'category_id' => $catElectronics->id,
            'code' => 'INV-ELK-002',
            'name' => 'Laptop ASUS ROG Strix',
            'description' => 'Laptop gaming dengan spesifikasi Intel Core i7, RAM 16GB, RTX 3060.',
            'total_stock' => 5,
            'available_stock' => 4, // 1 pending
            'location' => 'Gedung C Lantai 2',
            'image' => null,
            'condition' => 'baik',
        ]);

        $invKamera = Inventory::create([
            'category_id' => $catElectronics->id,
            'code' => 'INV-ELK-003',
            'name' => 'Kamera DSLR Canon EOS 80D',
            'description' => 'Kamera DSLR dengan lensa kit 18-135mm IS USM.',
            'total_stock' => 3,
            'available_stock' => 3,
            'location' => 'Gedung C Lantai 2',
            'image' => null,
            'condition' => 'baik',
        ]);

        $invSpeaker = Inventory::create([
            'category_id' => $catElectronics->id,
            'code' => 'INV-ELK-004',
            'name' => 'Speaker Portable JBL PartyBox',
            'description' => 'Speaker bluetooth outdoor dengan daya 100 Watt.',
            'total_stock' => 8,
            'available_stock' => 8,
            'location' => 'Gedung C Lantai 2',
            'image' => null,
            'condition' => 'baik',
        ]);

        $invMikrofon = Inventory::create([
            'category_id' => $catElectronics->id,
            'code' => 'INV-ELK-005',
            'name' => 'Mikrofon Wireless Shure SVX24',
            'description' => 'Sistem mikrofon genggam nirkabel UHF profesional.',
            'total_stock' => 12,
            'available_stock' => 12,
            'location' => 'Gedung C Lantai 2',
            'image' => null,
            'condition' => 'baik',
        ]);

        $invPrinter = Inventory::create([
            'category_id' => $catOffice->id,
            'code' => 'INV-OFF-001',
            'name' => 'Printer HP LaserJet Pro M404dn',
            'description' => 'Printer laser monokrom dengan fitur auto-duplex.',
            'total_stock' => 4,
            'available_stock' => 4,
            'location' => 'Gedung A Lantai 1',
            'image' => null,
            'condition' => 'baik',
        ]);

        $invMikroskop = Inventory::create([
            'category_id' => $catLab->id,
            'code' => 'INV-LAB-001',
            'name' => 'Mikroskop Binokuler Olympus CX23',
            'description' => 'Mikroskop laboratorium biologi dengan pencahayaan LED.',
            'total_stock' => 6,
            'available_stock' => 6,
            'location' => 'Gedung D Lantai 3',
            'image' => null,
            'condition' => 'baik',
        ]);

        // Create Borrow Requests

        // 1. Pending Request (Budi Santoso)
        $reqPending = BorrowRequest::create([
            'student_id' => $student1->id,
            'approved_by' => null,
            'request_date' => date('Y-m-d'),
            'borrow_date' => date('Y-m-d', strtotime('+1 day')),
            'return_date' => date('Y-m-d', strtotime('+3 days')),
            'purpose' => 'Presentasi Tugas Akhir Prodi Teknik Informatika',
            'attachment' => null,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        BorrowRequestItem::create([
            'borrow_request_id' => $reqPending->id,
            'inventory_id' => $invProyektor->id,
            'quantity' => 1,
        ]);

        BorrowRequestItem::create([
            'borrow_request_id' => $reqPending->id,
            'inventory_id' => $invLaptop->id,
            'quantity' => 1,
        ]);

        // 2. Active Borrowing (Siti Aminah)
        $reqBorrowed = BorrowRequest::create([
            'student_id' => $student2->id,
            'approved_by' => $officer->id,
            'request_date' => date('Y-m-d', strtotime('-3 days')),
            'borrow_date' => date('Y-m-d', strtotime('-2 days')),
            'return_date' => date('Y-m-d', strtotime('+2 days')),
            'purpose' => 'Kegiatan Seminar Himpunan Mahasiswa',
            'attachment' => null,
            'status' => 'borrowed',
            'created_at' => now()->subDays(3),
            'updated_at' => now()->subDays(2),
        ]);

        BorrowRequestItem::create([
            'borrow_request_id' => $reqBorrowed->id,
            'inventory_id' => $invProyektor->id,
            'quantity' => 1,
        ]);

        Handover::create([
            'borrow_request_id' => $reqBorrowed->id,
            'officer_id' => $officer->id,
            'handover_date' => date('Y-m-d', strtotime('-2 days')),
            'notes' => 'Proyektor dalam tas lengkap dengan kabel HDMI dan power adapter.',
        ]);

        // 3. Completed Borrowing (Budi Santoso)
        $reqReturned = BorrowRequest::create([
            'student_id' => $student1->id,
            'approved_by' => $officer->id,
            'request_date' => date('Y-m-d', strtotime('-7 days')),
            'borrow_date' => date('Y-m-d', strtotime('-6 days')),
            'return_date' => date('Y-m-d', strtotime('-4 days')),
            'purpose' => 'Praktikum Fotografi Mandiri',
            'attachment' => null,
            'status' => 'returned',
            'created_at' => now()->subDays(7),
            'updated_at' => now()->subDays(4),
        ]);

        BorrowRequestItem::create([
            'borrow_request_id' => $reqReturned->id,
            'inventory_id' => $invKamera->id,
            'quantity' => 1,
        ]);

        Handover::create([
            'borrow_request_id' => $reqReturned->id,
            'officer_id' => $officer->id,
            'handover_date' => date('Y-m-d', strtotime('-6 days')),
            'notes' => 'Kamera, strap, dan lensa dalam kondisi bersih. Baterai penuh.',
        ]);

        $retReturned = ReturnRecord::create([
            'borrow_request_id' => $reqReturned->id,
            'officer_id' => $officer->id,
            'return_date' => date('Y-m-d', strtotime('-4 days')),
            'item_condition' => 'baik',
            'late_days' => 0,
            'notes' => 'Kamera dikembalikan dengan selamat, lensa tidak berjamur, memori dikosongkan.',
        ]);

        // 4. Returned Request with Fines (Budi Santoso)
        // Late by 2 days, returned in "rusak_ringan" condition
        $reqFined = BorrowRequest::create([
            'student_id' => $student1->id,
            'approved_by' => $officer->id,
            'request_date' => date('Y-m-d', strtotime('-10 days')),
            'borrow_date' => date('Y-m-d', strtotime('-9 days')),
            'return_date' => date('Y-m-d', strtotime('-6 days')),
            'purpose' => 'Pengerjaan Proyek Pemrograman Matakuliah',
            'attachment' => null,
            'status' => 'returned',
            'created_at' => now()->subDays(10),
            'updated_at' => now()->subDays(4),
        ]);

        BorrowRequestItem::create([
            'borrow_request_id' => $reqFined->id,
            'inventory_id' => $invLaptop->id,
            'quantity' => 1,
        ]);

        Handover::create([
            'borrow_request_id' => $reqFined->id,
            'officer_id' => $officer->id,
            'handover_date' => date('Y-m-d', strtotime('-9 days')),
            'notes' => 'Laptop ROG dipinjamkan unit, charger, dan mouse berkabel.',
        ]);

        $retFined = ReturnRecord::create([
            'borrow_request_id' => $reqFined->id,
            'officer_id' => $officer->id,
            'return_date' => date('Y-m-d', strtotime('-4 days')), // 2 days late (due on -6 days)
            'item_condition' => 'rusak_ringan',
            'late_days' => 2,
            'notes' => 'Charger ada, mouse ada, laptop terlambat 2 hari. Ada lecet/goresan tipis di bagian penutup casing laptop.',
        ]);

        Fine::create([
            'return_id' => $retFined->id,
            'amount' => 50000.00, // Rp 10.000 (late fee for 2 days) + Rp 40.000 (light scratch fee)
            'reason' => 'Terlambat mengembalikan selama 2 hari (denda Rp 10.000) dan terdapat kerusakan ringan lecet pada body laptop (denda kerusakan Rp 40.000).',
            'paid_status' => 'unpaid',
        ]);
    }
}
