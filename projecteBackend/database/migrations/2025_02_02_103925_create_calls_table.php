<?php

use App\Enums\IncomingCallsType;
use App\Enums\OutgoingCallsType;
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
        Schema::create('calls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patientId');
            $table->unsignedBigInteger('operatorId')->nullable(); // Puede ser nulo en llamadas entrantes
            $table->text('details')->nullable();
            $table->timestamp('dateTime');
            $table->timestamps();
            
            $table->foreign('patientId')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('operatorId')->references('id')->on('users')->onDelete('set null');
        });
        
        Schema::create('incoming_calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('callId')->unique()->references('id')->on('calls')->constrained()->onDelete('cascade');
            $table->enum('type', IncomingCallsType::values());
        });
        
        Schema::create('outgoing_calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('callId')->unique()->references('id')->on('calls')->constrained()->onDelete('cascade');
            $table->enum('type', OutgoingCallsType::values());
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calls');
        Schema::dropIfExists('incoming_calls');
        Schema::dropIfExists('outgoing_calls');
    }
};
