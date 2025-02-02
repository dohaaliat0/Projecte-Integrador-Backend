<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('patient_histories', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('operatorId')->constrained()->onDelete('cascade'); // Relación con el operador
        //     $table->foreignId('patientId')->constrained()->onDelete('cascade'); // Relación con el paciente
        //     $table->foreignId('callId')->nullable()->constrained('calls')->onDelete('set null'); // Relación con la llamada entrante
        //     $table->dateTime('dateTime');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('patient_histories');
    }
};