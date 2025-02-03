<?php

use App\Enums\AlertType;
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
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('operatorId');
            $table->unsignedBigInteger('zoneId')->nullable();
            $table->unsignedBigInteger('patientId')->nullable();
            $table->boolean('isActive')->default(true);
            $table->enum('type', AlertType::values());
            $table->boolean('isRecurring')->default(false);
            $table->date('date');
            $table->date('endDate')->nullable();
            $table->time('time');
            $table->string('dayOfWeek')->nullable()->default(null);
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('operatorId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('zoneId')->references('id')->on('zones')->onDelete('cascade');
            $table->foreign('patientId')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
