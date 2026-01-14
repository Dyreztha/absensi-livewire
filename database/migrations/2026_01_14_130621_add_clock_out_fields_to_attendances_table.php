<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('attendances', function (Blueprint $table) {
        if (!Schema::hasColumn('attendances', 'clock_out_at')) {
            $table->timestamp('clock_out_at')->nullable()->after('clock_in_at');
            $table->decimal('clock_out_lat', 10, 7)->nullable()->after('clock_in_lng');
            $table->decimal('clock_out_lng', 10, 7)->nullable()->after('clock_out_lat');
            $table->string('clock_out_photo_path')->nullable()->after('clock_in_photo_path');
        }
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            //
        });
    }
};
