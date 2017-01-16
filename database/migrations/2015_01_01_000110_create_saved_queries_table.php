<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSavedQueriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saved_queries', function (Blueprint $table) {
            /*Fields concerning creation and deletion of the record*/
            include 'includes/metafields.php';

            /*Fields containing the data*/
            $table->integer('user_id');
            $table->string('name');
            $table->string('querystring', 1000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saved_queries');
    }
}
