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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guardian_id')->constrained('guardians')->onDelete('cascade');;
            $table->foreignId('classroom_id')->constrained('classrooms')->onDelete('cascade');;
            $table->string('icNum');
            $table->string('studentName');
            $table->string('gender');
            $table->string('race');
            $table->integer('age');
            $table->date('birthDate');
            $table->string('status');
            $table->string('averageResult');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};