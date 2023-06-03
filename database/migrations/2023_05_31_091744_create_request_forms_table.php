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
    Schema::create('request_forms', function (Blueprint $table) {
      $table->id();
      $table->string("name");
      $table->unsignedBigInteger("workflow_id");
      $table->string("description")->nullable();
      $table->text("fields");
      $table->timestamps();

      $table->foreign("workflow_id")->on("workflows")->references("id")->cascadeOnDelete()->cascadeOnUpdate();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('request_forms');
  }
};
