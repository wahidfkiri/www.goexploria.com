<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('permissions',
            function(Blueprint $table) {
            $table->string('key', 20);
            $table->integer('type_id');
            $table->integer('module_id');
            $table->primary(array('type_id', 'key', 'module_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('permissions');
    }

}
