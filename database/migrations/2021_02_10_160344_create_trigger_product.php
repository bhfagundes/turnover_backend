<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateTriggerProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE  TRIGGER `product_AFTER_UPDATE` AFTER UPDATE ON `product` FOR EACH ROW
        BEGIN
         IF(NEW.quantity <> OLD.quantity)
         THEN
            INSERT INTO log_product (id_product,quantity,price,created_at,updated_at)
                VALUES
                (NEW.id, NEW.quantity,NEW.price,current_timestamp, current_timestamp);
         END IF;
        END');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `product_AFTER_UPDATE`');
    }
}
