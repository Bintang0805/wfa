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
            $table->unsignedBigInteger("location_id")->nullable();
            $table->unsignedBigInteger("facility_id")->nullable();
            $table->unsignedBigInteger("department_id");
            $table->unsignedBigInteger("equipment_type_id");
            $table->string("equipment_name");
            $table->string("equipment_make");
            $table->string("equipment_model");
            $table->enum("data_storage", ["Yes", "No", "NA"]);
            $table->enum("indirect_impact", ["Yes", "No", "NA"]);
            $table->enum("qualification_status", ["Completed", "On Going", "Pending", "NA"]);
            $table->enum("csv_status", ["Completed", "On Going", "Pending", "NA"]);
            $table->string("equipment_number");
            $table->boolean("status");
            $table->timestamps();

            $table->foreign("location_id")->on("locations")->references("id")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("facility_id")->on("facilities")->references("id")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("department_id")->on("departments")->references("id")->cascadeOnDelete()->cascadeOnUpdate();
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
