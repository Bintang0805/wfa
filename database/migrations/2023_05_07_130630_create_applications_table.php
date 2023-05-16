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
            $table->unsignedBigInteger("location_id")->nullable();
            $table->unsignedBigInteger("facility_id")->nullable();
            $table->unsignedBigInteger("department_id");
            $table->boolean("connected_to_server");
            $table->enum("application_role_type", ["Single", "Multiple"]);
            $table->string("privilages");
            $table->string("manufacturer");
            $table->enum("gamp_category", ["1", "2", "3", "4", "5"]);
            $table->enum("csv_status", ["Completed", "On Going", "Pending", "NA"]);
            $table->dateTime("csv_completed_on");
            $table->string("periodic_review");
            $table->enum("gxp_status", ["Yes", "No", "NA"]);
            $table->enum("backup_mode", ["Automatic", "Manual"]);
            $table->enum("data_type", ["Flat File", "Database", "NA"]);
            $table->string("vendor_details");
            $table->enum("status", ["Active", "Retired"]);
            $table->timestamps();

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
        Schema::dropIfExists('applications');
    }
};
