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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('user_name');
            $table->string('password');
            $table->string('phone')->unique();
            $table->tinyInteger('type')->default(\App\Models\User::CUSTOMERTYPE);
            $table->boolean('is_active')->default(\App\Models\User::ACTIVE);
            $table->foreignIdFor(\app\Models\Center::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
           
            $table->foreignIdFor(\App\Models\Location::class)->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->date('date_of_birth');
            $table->string('description')->nullable();
            $table->timestamp('last_login')->nullable();
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
        Schema::dropIfExists('users');
    }
};
