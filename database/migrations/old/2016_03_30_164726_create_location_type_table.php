<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocationTypeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('locations_types',
            function(Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 45);
            $table->integer('parent_id')->nullable()->index('fk_l_t_parent_id_idx');
            $table->integer('country_id')->index('fk_l_t_country_id_idx');
            $table->integer('created_at')->default(0);
            $table->integer('updated_at')->nullable();
            $table->integer('level')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('locations_types');
    }

    /* manually : 
        DROP TRIGGER IF EXISTS `locations_types_AFTER_INSERT`;
        DELIMITER //
        CREATE TRIGGER `locations_types_AFTER_INSERT` BEFORE INSERT ON `locations_types`
         FOR EACH ROW BEGIN
            IF NEW.parent_id IS NULL THEN
                SET NEW.level = 0;
            ELSE
                SET NEW.level = (SELECT level FROM locations_types WHERE id = NEW.parent_id) + 1;
            END IF;
        END

        DROP TRIGGER IF EXISTS `locations_types_BEFORE_UPDATE`;
        DELIMITER //
        CREATE TRIGGER `locations_types_BEFORE_UPDATE` BEFORE UPDATE ON `locations_types`
         FOR EACH ROW BEGIN
            IF NEW.parent_id IS NULL THEN
                SET NEW.level = 0;
            ELSE
                SET NEW.level = (SELECT level FROM locations_types WHERE id = NEW.parent_id) + 1;
            END IF;
        END*/

}
