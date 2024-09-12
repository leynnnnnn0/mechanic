<?php

use App\Models\Car;
use App\Models\User;
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
            $table->string('appointment_number')->unique();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Car::class)->constrained();
            $table->string('service_type');
            $table->string('description')->nullable();
            $table->string('additional_notes')->nullable();
            $table->boolean('is_emergency');
            $table->boolean('to_be_towed');
            $table->dateTime('date_and_time');
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
