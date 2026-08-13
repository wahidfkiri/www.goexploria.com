<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users',
            function(Blueprint $table) {
            $table->integer('id', true);
            $table->integer('type_id')->index('fk_u_type_id_idx');
            $table->boolean('is_admin')->default(false);
            $table->string('email',150)->unique('email_UNIQUE');
            $table->string('pass_secure', 100);
            $table->boolean('is_news_enabled')->default(false);

            $table->string('name', 45);
            $table->string('first_name', 45);
            $table->string('last_name', 45);
            $table->integer('coordinate_id');

            $table->boolean('is_activated')->default(false);
            $table->integer('activation_time')->default(0);
            $table->string('activation_token', 200)->unique()->nullable();

            $table->integer('pass_reset_time')->default(0);
            $table->string('pass_reset_token', 200)->unique()->nullable();
            $table->string('reseted_password', 100)->nullable();

            $table->string('remember_token', 200)->nullable();
            $table->string('token', 200)->nullable();
            $table->integer('created_at')->default(0);
            $table->integer('updated_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('users');
    }

}
