<?php

use App\Models\Appointment;
use App\Models\Car;
use App\Models\Mechanic;
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
        Schema::create('service_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('service_job_id')->unique();
            $table->foreignIdFor(Appointment::class);
            $table->string(Car::class);
            $table->string(Mechanic::class);
            $table->string('status');
            $table->string('service_type');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->double('estimated_cost')->nullable();
            $table->double('final_cost')->nullable();
            $table->string('payment_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_jobs');
    }
};
