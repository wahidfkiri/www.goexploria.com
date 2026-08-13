<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPermissionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('permissions',
            function(Blueprint $table) {
            $table->foreign('type_id', 'fk_perm_type')->references('id')->on('users_types')->onDelete('cascade');
            $table->foreign('module_id', 'fk_perm_module')->references('id')->on('modules')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('permissions',
            function(Blueprint $table) {
            $table->dropForeign('fk_perm_type');
            $table->dropForeign('fk_perm_module');

        });
    }

}
