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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger("location_id");
            $table->unsignedBigInteger("department_id");
            $table->unsignedBigInteger("equipment_type_id");
            $table->string("equipment_name");
            $table->string("equipment_make");
            $table->string("equipment_model");
            $table->enum("data_storage", ["yes", "no", "na"]);
            $table->enum("indirect_impact", ["yes", "no", "na"]);
            $table->enum("qualification_status", ["c", "o", "p", "na"]);
            $table->enum("csv_status", ["c", "o", "p", "na"]);
            $table->string("equipment_number");
            $table->boolean("status");
            $table->timestamps();

            $table->foreign("equipment_type_id")->on("equipment_types")->references("id")->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipments');
    }
};
