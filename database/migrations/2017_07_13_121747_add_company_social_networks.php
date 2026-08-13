<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanySocialNetworks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('companies_social_networks', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('company_id');
        $table->string('facebook')->nullable();
        $table->string('twitter')->nullable();
        $table->string('google_plus')->nullable();
        $table->string('linkedin')->nullable();
        $table->string('youtube')->nullable();
        $table->string('instagram')->nullable();
        $table->string('pinterest')->nullable();
        $table->string('reddit')->nullable();
        $table->timestamps();
        $table->foreign('company_id')
          ->references('id')
          ->on('companies')
          ->onDelete("cascade");

      });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('companies_social_networks', function (Blueprint $table) {
        $table->dropForeign("companies_social_networks_company_id_foreign");
      });
      Schema::drop("companies_social_networks");

    }
}
