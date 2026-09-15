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
            $table->string('surname')->nullable();
            $table->string('name');
            $table->string('sex', 10);
            $table->date('birthdate');

            $table->string('phone', 30);
            $table->string('nationality')->nullable();
            $table->string('occupation')->nullable();
            $table->string('marital_status', 50)->nullable();

            $table->date('death_date')->nullable();

            $table->string('spid', 50)->nullable()->unique();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
