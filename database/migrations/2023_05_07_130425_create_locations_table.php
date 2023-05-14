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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("company_id");
            $table->string("location_name");
            // $table->string("facility");
            // $table->string("address");
            // $table->string("pin_code");
            // $table->string("city");
            // $table->string("state");
            // $table->string("country");
            $table->timestamps();

            $table->foreign("company_id")->on("companies")->references("id")->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
};
