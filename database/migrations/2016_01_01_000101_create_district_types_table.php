<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistrictTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('district_types', function (Blueprint $table) {
            /*Fields concerning creation and deletion of the record*/
            include 'includes/metafields.php';

            /*Fields containing the data*/
            $table->string('name_long');
            $table->string('name_short')->nullable();
            $table->integer('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('district_types');
    }
}
