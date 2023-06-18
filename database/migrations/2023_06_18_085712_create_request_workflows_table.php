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
        Schema::create('request_workflows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("workflow_id");
            $table->text("request_workflow");
            $table->unsignedBigInteger("user_id");
            $table->enum("status", ["pending", "approved", "rejected"])->default("pending");
            $table->timestamps();

            $table->foreign("workflow_id")->references("id")->on("workflows")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("user_id")->references("id")->on("users")->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_workflows');
    }
};
