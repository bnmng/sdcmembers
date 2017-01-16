<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            /*Fields concerning creation and deletion of the record*/
            include 'includes/metafields.php';

            /*Fields containing the data*/
            $table->integer('person_id');
            $table->string('number');
            $table->string('instructions')->nullable();
            $table->boolean('can_text')->default(false);
            $table->boolean('is_primary')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phones');
    }
}
