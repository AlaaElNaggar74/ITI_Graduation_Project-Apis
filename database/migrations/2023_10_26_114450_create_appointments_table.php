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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_phone');
            $table->string('client_email');
            $table->enum('payment_method',['cash','visa'])->default('cash');
            $table->date('appointment_date');
            


            $table->foreignId('user_id')->references('id')->on('users')->onUpdate("cascade")->onDelete("cascade");
            $table->foreignId('lawyer_time_id')->references('id')->on('lawyer_times')->onUpdate("cascade")->onDelete("cascade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
