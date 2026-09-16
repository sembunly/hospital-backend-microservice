<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            $table->string('patient_code')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('gender', 20)->nullable();
            $table->date('date_of_birth')->nullable();

            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();

            $table->string('identification_type', 100)->nullable();
            $table->string('identification_number', 100)->nullable();

            $table->string('disability')->nullable();
            $table->string('photo', 500)->nullable();

            $table->unsignedInteger('province_id')->nullable();
            $table->unsignedInteger('district_id')->nullable();
            $table->unsignedInteger('commune_id')->nullable();
            $table->unsignedInteger('village_id')->nullable();

            $table->string('address', 500)->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();

            $table->tinyInteger('is_active')
                ->default(1)
                ->comment('0=Deleted, 1=Active, 2=Edited');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
