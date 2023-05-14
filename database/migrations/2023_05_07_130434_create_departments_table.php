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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("location_id")->nullable();
            $table->unsignedBigInteger("facility_id");
            $table->string("department");
            $table->timestamps();

            $table->foreign("facility_id")->on("facilities")->references("id")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("location_id")->on("locations")->references("id")->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
};
