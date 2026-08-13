<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->integer('company_id');       
            $table->string('config', 25);
            $table->text('value')->nullable();
            $table->string('description', 100);
            $table->integer('created_at');
            $table->integer('updated_at');
            
            $table->index(['company_id', 'config'], 'company_id_config_index');
        });
        
        Schema::table('sites', function (Blueprint $table) {
            $table->foreign('company_id', 'fk_sites_company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->dropIndex('company_id_config_index');
            $table->dropForeign('fk_sites_company_id');
        });
        
        Schema::drop('sites');
    }
}
