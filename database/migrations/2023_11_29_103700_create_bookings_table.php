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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->nullable()->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->bigInteger('event_id')->unsigned();
            $table->foreign('event_id')->nullable()->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->dateTime('booked_at', $precision = 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
