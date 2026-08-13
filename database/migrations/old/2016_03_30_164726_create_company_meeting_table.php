<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanyMeetingTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('companies_meetings', function(Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 45);
            $table->string('client', 100)->nullable();
            $table->text('contact')->nullable();
            $table->text('content')->nullable();
            $table->integer('company_id');
            $table->integer('created_at');
            $table->integer('updated_at');
            $table->integer('started_at');
            $table->integer('ended_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('companies_meetings');
    }

}
