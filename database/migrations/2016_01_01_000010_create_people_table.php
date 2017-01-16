<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            /*Fields concerning creation and deletion of the record*/
            include 'includes/metafields.php';

            /*Fields containing the data*/
            $table->string('name_prefix')->nullable();
            $table->string('name_first');
            $table->string('name_last')->nullable();
            $table->string('name_middles')->nullable();
            $table->string('name_suffix')->nullable();
            $table->string('name_friendly')->nullable();
            $table->string('name_short')->nullable();
            $table->string('name_short_formal')->nullable();
            $table->string('name_full')->nullable();
            $table->string('address')->nullable();
            $table->string('appformlink')->nullable();
            $table->integer('membership_class_id');
            $table->integer('status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
