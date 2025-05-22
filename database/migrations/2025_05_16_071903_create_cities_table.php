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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('search_name')->nullable()->index();
            $table->string('mayor_name')->nullable();
            $table->string('city_hall_address')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->json('email')->nullable();
            $table->string('web')->nullable();
            $table->string('coat_of_arms_image')->nullable();
            $table->string('latitude', 25)->nullable();
            $table->string('longitude', 25)->nullable();
            $table->string('url');
            $table->foreignId('sub_district_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
