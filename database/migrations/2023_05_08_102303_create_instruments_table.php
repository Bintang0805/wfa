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
        Schema::create('instruments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("location_id");
            $table->unsignedBigInteger("facility_id");
            $table->unsignedBigInteger("department_id");
            $table->unsignedBigInteger("instrument_type_id");
            $table->string("instrument_name");
            $table->string("instrument_make");
            $table->string("instrument_model");
            $table->enum("data_storage", ["Yes", "No", "NA"]);
            $table->enum("indirect_impact", ["Yes", "No", "NA"]);
            $table->enum("qualification_status", ["Completed", "On Going", "Pending", "NA"]);
            $table->enum("csv_status", ["Completed", "On Going", "Pending", "NA"]);
            $table->enum("computer_connected", ["Yes", "No", "NA"]);
            // $table->unsignedBigInteger("computer_asset_code");
            $table->string("instrument_asset_code");
            $table->boolean("status");
            $table->timestamps();

            $table->foreign("location_id")->on("locations")->references("id")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("facility_id")->on("facilities")->references("id")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("department_id")->on("departments")->references("id")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("instrument_type_id")->on("instrument_types")->references("id")->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instruments');
    }
};
