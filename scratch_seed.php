<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\OfficerProfile;
use Illuminate\Support\Facades\Hash;

$admin = User::firstOrCreate([
    'email' => 'admin@sipinjam.com'
], [
    'name' => 'Administrator SIPINJAM',
    'password' => Hash::make('password'),
    'role' => 'admin',
    'status' => 'active',
]);

echo "Admin user: " . ($admin->wasRecentlyCreated ? 'Created' : 'Already exists') . "\n";

$officer = User::firstOrCreate([
    'email' => 'officer@sipinjam.com'
], [
    'name' => 'Hendra Setiawan',
    'password' => Hash::make('password'),
    'role' => 'officer',
    'status' => 'active',
]);

echo "Officer user: " . ($officer->wasRecentlyCreated ? 'Created' : 'Already exists') . "\n";

$profile = OfficerProfile::firstOrCreate([
    'user_id' => $officer->id
], [
    'employee_number' => 'NIP198901022022031001',
    'division' => 'Bagian Perlengkapan & Inventaris',
]);

echo "Officer profile: " . ($profile->wasRecentlyCreated ? 'Created' : 'Already exists') . "\n";
