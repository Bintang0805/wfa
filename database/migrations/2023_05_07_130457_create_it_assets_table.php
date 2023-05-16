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
        Schema::create('it_assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("location_id")->nullable();
            $table->unsignedBigInteger("facility_id")->nullable();
            $table->unsignedBigInteger("department_id");
            $table->unsignedBigInteger("it_asset_type_id");
            $table->string("make");
            $table->string("model");
            $table->string("oem_sl_no");
            $table->string("host_name")->unique();
            $table->string("ip_address")->unique();
            $table->enum("asset_type", ["GMP", "Non GMP"]);
            $table->string("os_ver");
            $table->enum("asset_status", ["Active", "Retired", "Stock"]);
            $table->string("owner_name");
            $table->timestamps();

            $table->foreign("it_asset_type_id")->on("it_asset_types")->references("id")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("location_id")->on("locations")->references("id")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("facility_id")->on("facilities")->references("id")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("department_id")->on("departments")->references("id")->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('it_assets');
    }
};
