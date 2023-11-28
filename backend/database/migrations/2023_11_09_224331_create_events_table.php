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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->dateTime('event_date');
            $table->string('title');
            $table->text('img')->nullable();
            $table->string('localization');
            $table->text('urlLocalization');
            $table->text('description');
            $table->integer('workload')->nullable();
            $table->foreignId('owner')->constrained('users');
            $table->dateTime('registration_validity')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
