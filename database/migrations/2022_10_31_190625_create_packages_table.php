<?php

use App\Models\Package;
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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Center::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->integer('num_nabadat');
            $table->double('price');
            $table->date('start_date');
            $table->date('end_date');
            $table->double('discount_percentage')->default(0.0);
            $table->integer('status')->default(\App\Enum\PackageStatusEnum::UNDERACHIEVING);
            $table->boolean('is_active')->default(\App\Enum\ActivationStatusEnum::ACTIVE);
            $table->foreignIdFor(\App\Models\PackageCategory::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('packages');
    }
};
