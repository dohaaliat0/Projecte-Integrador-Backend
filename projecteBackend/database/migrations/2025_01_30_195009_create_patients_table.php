<?php

use App\Enums\Language;
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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('fullName');
            $table->date('birthDate');
            $table->string('fullAddress');
            $table->string('dni')->unique();
            $table->string('healthCardNumber')->unique();
            $table->string('phone');
            $table->string('email')->unique();
            $table->foreignId('zoneId')->nullable()->constrained('zones')->onDelete('set null');


            $table->text('personalFamilySituation')->nullable();
            $table->text('healthSituation')->nullable();
            $table->text('housingSituation')->nullable();
            $table->text('personalAutonomy')->nullable();
            $table->text('economicSituation')->nullable();
            $table->unsignedBigInteger('operatorId')->nullable();
            $table->foreign('operatorId')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
