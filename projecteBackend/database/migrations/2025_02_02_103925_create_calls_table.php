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
        Schema::create('calls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('operatorId')->nullable(); // Puede ser nulo en llamadas entrantes
            $table->text('details')->nullable();
            $table->timestamp('call_time');
            $table->timestamps();
            
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('operatorId')->references('id')->on('operators')->onDelete('set null');
        });
        
        Schema::create('incoming_calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('callId')->constrained()->onDelete('cascade');
            $table->enum('call_type', ['emergency', 'follow_up', 'general_inquiry']);
        });
        
        Schema::create('outgoing_calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('callId')->constrained()->onDelete('cascade');
            $table->enum('call_type', ['alert', 'reminder', 'check_in']);
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
