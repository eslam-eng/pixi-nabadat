<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(\App\Models\Center::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->date('check_date');
            $table->enum('period', ['am','pm'])->nullable();
            $table->string('qr_code')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
};