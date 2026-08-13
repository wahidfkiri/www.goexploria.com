<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocationTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('locations',
            function(Blueprint $table) {
            $table->integer('id', true);
            $table->integer('parent_id')->nullable()->index('fk_parent_id_idx');
            $table->integer('type_id')->index('l_type_id_idx');
            $table->string('name', 45);
            $table->string('slug', 45);
            $table->boolean('is_activated')->default(true);
            $table->integer('population')->default(0);
            $table->float('superficie')->nullable();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->string('gentile', 45)->nullable();
            $table->string('drapeau', 150)->nullable();
            $table->date('fondation')->nullable();
            $table->text('description')->nullable();
            $table->integer('coordinate_id')->nullable();
            
            $table->integer('created_at');
        $table->integer('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('locations');
    }

}
