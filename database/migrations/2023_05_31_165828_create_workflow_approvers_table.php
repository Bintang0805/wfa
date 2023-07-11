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
        Schema::create('workflow_approvers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("workflow_id");
            $table->unsignedBigInteger("approver_roles")->nullable();
            $table->timestamps();

            $table->foreign("workflow_id")->on("workflows")->references("id")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("approver_roles")->on("roles")->references("id")->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workflow_approvers');
    }
};
