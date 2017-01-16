<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembershipClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership_classes', function (Blueprint $table) {
            /*Fields concerning creation and deletion of the record*/
            include 'includes/metafields.php';

            /*Fields containing the data*/
            $table->string('name');
            $table->boolean('is_voter');
            $table->boolean('is_quorum');
            $table->boolean('is_duespayer');
            $table->boolean('has_status');
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
        Schema::dropIfExists('membership_classes');
    }
}
