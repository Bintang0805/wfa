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
            $table->unsignedBigInteger("instrument_type_id");
            $table->string("instrument_name");
            $table->string("instrument_make");
            $table->string("instrument_model");
            $table->enum("data_storage", ["yes", "no", "na"]);
            $table->enum("indirect_impact", ["yes", "no", "na"]);
            $table->enum("qualification_status", ["c", "o", "p", "na"]);
            $table->enum("csv_status", ["c", "o", "p", "na"]);
            $table->enum("computer_connected", ["yes", "no", "na"]);
            // $table->unsignedBigInteger("computer_asset_code");
            $table->string("intrument_asset_code");
            $table->boolean("status");
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
        Schema::dropIfExists('instruments');
    }
};
