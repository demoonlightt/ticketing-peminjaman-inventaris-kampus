<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mahasiswa_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nim')->unique();
            $table->string('prodi');
            $table->string('fakultas');
            $table->integer('angkatan');
        });

        Schema::create('officer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('employee_number')->unique();
            $table->string('division');
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
        });

        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('total_stock');
            $table->integer('available_stock');
            $table->string('location');
            $table->string('image')->nullable();
            $table->string('condition')->default('baik');
            $table->timestamps();
        });

        Schema::create('borrow_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->date('request_date');
            $table->date('borrow_date');
            $table->date('return_date');
            $table->text('purpose');
            $table->string('attachment')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        Schema::create('borrow_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrow_request_id')->constrained('borrow_requests')->onDelete('cascade');
            $table->foreignId('inventory_id')->constrained('inventories')->onDelete('cascade');
            $table->integer('quantity');
        });

        Schema::create('handovers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrow_request_id')->constrained('borrow_requests')->onDelete('cascade');
            $table->foreignId('officer_id')->constrained('users')->onDelete('cascade');
            $table->date('handover_date');
            $table->text('notes')->nullable();
        });

        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrow_request_id')->constrained('borrow_requests')->onDelete('cascade');
            $table->foreignId('officer_id')->constrained('users')->onDelete('cascade');
            $table->date('return_date');
            $table->string('item_condition');
            $table->integer('late_days');
            $table->text('notes')->nullable();
        });

        Schema::create('fines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('return_id')->constrained('returns')->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->text('reason');
            $table->string('paid_status')->default('unpaid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fines');
        Schema::dropIfExists('returns');
        Schema::dropIfExists('handovers');
        Schema::dropIfExists('borrow_request_items');
        Schema::dropIfExists('borrow_requests');
        Schema::dropIfExists('inventories');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('officer_profiles');
        Schema::dropIfExists('mahasiswa_profiles');
    }
};
