<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_identifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            $table->string('card_code');
            $table->string('card_type');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_identifications');
    }
};
