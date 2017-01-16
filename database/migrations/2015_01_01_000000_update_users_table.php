<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'users', function ($table) {

            $table->boolean('is_new')->default( true );
            $table->boolean('is_disabled')->default( false );
            $table->integer('role')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'users', function ($table) {
            $table->dropColumn('is_new');
            $table->dropColumn('is_disabled');
        });           
    }
}
