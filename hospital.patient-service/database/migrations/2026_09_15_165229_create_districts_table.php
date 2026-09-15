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
        Schema::create('districts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->increments('id');
            $table->unsignedInteger('province_id');
            $table->string('code', 10);
            $table->string('name');
            $table->string('name_other')->nullable();
            $table->dateTime('created')->useCurrent();
            $table->unsignedInteger('created_by')->nullable();
            $table->boolean('is_active')->default(true);

            $table->foreign('province_id')
                ->references('id')
                ->on('provinces')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->unique(['province_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('districts');
    }
};
