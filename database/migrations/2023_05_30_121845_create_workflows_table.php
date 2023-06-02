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
        Schema::create('workflows', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("description");
            $table->unsignedBigInteger("initiation_role");
            $table->integer("level_of_approvers")->nullable();
            $table->unsignedBigInteger("approver_roles");
            $table->unsignedBigInteger("worker_roles");
            $table->enum("status", ["active", "inactive"])->default("inactive");
            $table->boolean("email_reminder")->default(false)->nullable();
            $table->boolean("web_notification")->default(false)->nullable();
            $table->unsignedBigInteger("associated_form")->nullable();
            $table->timestamps();

            $table->foreign("initiation_role")->references("id")->on("roles")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("approver_roles")->on("roles")->references("id")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("worker_roles")->on("roles")->references("id")->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workflows');
    }
};
