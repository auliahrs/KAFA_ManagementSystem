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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kafa_id');
            $table->string('activityName');
            $table->date('dateStart');
            $table->date('dateEnd');
            $table->time('timeStart');
            $table->time('timeEnd');
            $table->string('venue');
            $table->string('organizerName');
            $table->string('attendees');
            $table->string('description');
            $table->string('status');
            $table->string('feedback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
