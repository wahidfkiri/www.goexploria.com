<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PopulatePermissionEntreprise extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permissions')->insert([
          [
            "key" => "edit",
            "type_id" => 1, //user_types: entreprise
            "module_id" => 7, //entreprise
          ],
          [
            "key" => "read",
            "type_id" => 1, //user_types: entreprise
            "module_id" => 7, //entreprise
          ],
          [
            "key" => "add",
            "type_id" => 1, //user_types: entreprise
            "module_id" => 7, //entreprise
          ],
          [
            "key" => "delete",
            "type_id" => 1, //user_types: entreprise
            "module_id" => 7, //entreprise
          ],
          [
            "key" => "edit",
            "type_id" => 1, //user_types: Entreprise
            "module_id" => 12, //company/page
          ],
          [
            "key" => "read",
            "type_id" => 1, //entreprise
            "module_id" => 12, //company/page
          ],
          [
            "key" => "add",
            "type_id" => 1, //user_types: Entreprise
            "module_id" => 12, //company/page
          ],
          [
            "key" => "delete",
            "type_id" => 1, //entreprise
            "module_id" => 12, //company/page
          ],

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('permissions')
        ->where("type_id", 1)
        ->delete();
    }
}
