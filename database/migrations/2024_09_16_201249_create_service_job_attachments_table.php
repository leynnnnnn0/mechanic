<?php

use App\Models\ServiceJob;
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
        Schema::create('service_job_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ServiceJob::class)->constrained()->cascadeOnDelete();
            $table->string('attachment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_job_attachments');
    }
};
