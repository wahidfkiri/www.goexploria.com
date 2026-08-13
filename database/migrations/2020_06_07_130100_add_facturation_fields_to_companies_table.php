<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFacturationFieldsToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('achats_no_tps')->after('products')->nullable();
            $table->string('achats_no_tvq')->after('achats_no_tps')->nullable();
            $table->string('achats_neq')->after('achats_no_tvq')->nullable();
            $table->string('achats_succursale')->after('achats_neq')->nullable();
            $table->string('achats_transit')->after('achats_succursale')->nullable();
            $table->string('achats_compte')->after('achats_transit')->nullable();
            $table->text('achats_payment_button')->after('achats_compte')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('achats_no_tps');
            $table->dropColumn('achats_no_tvq');
            $table->dropColumn('achats_neq');
            $table->dropColumn('achats_succursale');
            $table->dropColumn('achats_transit');
            $table->dropColumn('achats_compte');
            $table->dropColumn('achats_payment_button');
        });
    }
}
