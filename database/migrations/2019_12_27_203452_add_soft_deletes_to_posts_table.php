<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeletesToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

     // using  php artisan make:migration add_soft_deletes_to_posts_table --table=posts
     // to avoid php artisan migrate:refresh (which deletes all records) in case u wanna add a column
     // but u dont want to delete all records 
     // so make this then do  php artisan migrate so column added safely .. 
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            // adding column deleted_at ... 
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            // drop it
            $table->dropColumn('deleted_at');
        });
    }
}
