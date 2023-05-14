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
            $table->unsignedBigInteger("it_asset_types_id");
            $table->string("make");
            $table->string("model");
            $table->string("oem_sl_no");
            $table->string("host_name")->unique();
            $table->string("ip_address")->unique();
            $table->string("asset_type");
            $table->string("os_ver");
            $table->string("asset_status");
            $table->timestamps();

            $table->foreign("it_asset_types_id")->on("it_asset_types")->references("id")->cascadeOnDelete()->cascadeOnUpdate();
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
