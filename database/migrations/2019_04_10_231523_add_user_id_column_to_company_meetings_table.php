<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdColumnToCompanyMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies_meetings', function (Blueprint $table) {
            if (!Schema::hasColumn('companies_meetings', 'user_id')) {
                $table->unsignedInteger('user_id')->nullable();
            }

            //  $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies_meetings', function (Blueprint $table) {
            //     $table->dropForeign('companies_meetings_user_id_foreign');
            if (Schema::hasColumn('companies_meetings', 'user_id')) {
                $table->dropColumn('user_id');            }

        });
    }
}
