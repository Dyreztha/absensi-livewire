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
        Schema::create('attendances', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();

    $table->timestamp('clock_in_at')->nullable();
    $table->timestamp('clock_out_at')->nullable();

    $table->decimal('clock_in_lat', 10, 7)->nullable();
    $table->decimal('clock_in_lng', 10, 7)->nullable();

    $table->string('clock_in_photo_path')->nullable();
    $table->string('clock_out_photo_path')->nullable();

    $table->string('status')->default('ok'); // ok/outside_radius/late/etc
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
