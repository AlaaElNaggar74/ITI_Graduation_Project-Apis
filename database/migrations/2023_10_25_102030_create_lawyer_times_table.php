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
        Schema::create('lawyer_times', function (Blueprint $table) {
            $table->id();
            $table->string('day');
            $table->double('start_hour', 8, 2);
            $table->double('end_hour', 8, 2);
            $table->foreignId('lawyer_id')->references('id')->on('lawyers')->onUpdate("cascade")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyer_times');
    }
};
