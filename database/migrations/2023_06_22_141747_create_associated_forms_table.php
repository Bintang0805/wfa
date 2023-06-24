<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
    Schema::create('associated_forms', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger("request_form_id");
      $table->unsignedBigInteger("workflow_id");
      $table->timestamps();

      $table->foreign("request_form_id")->on("request_forms")->references("id")->cascadeOnDelete()->cascadeOnUpdate();
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
    // DB::table("request_forms")->delete();
    // DB::table("workflows")->delete();

    // Schema::table('request_forms', function (Blueprint $table) {
    //   // Hapus foreign key
    //   $table->dropForeign(['workflow_id']);
    // });

    // Schema::table('workflows', function (Blueprint $table) {
    //   // Hapus foreign key
    //   $table->dropForeign(['associated_form']);
    // });

    Schema::dropIfExists('associated_form');
  }
};
