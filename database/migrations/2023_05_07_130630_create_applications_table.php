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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string("application_name");
            $table->string("application_ver");
            $table->boolean("connected_to_computer");
            $table->boolean("connected_to_server");
            $table->enum("application_role_type", ["single", "multiple"]);
            $table->string("privilages");
            $table->string("manufacturer");
            $table->enum("csv_status", ["yes", "no", "ongoing", "na"]);
            $table->string("csv_completed_on");
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
        Schema::dropIfExists('applications');
    }
};
