<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedirectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redirect', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('hash', 12);
            $table->smallInteger('counter');
            $table->string('payload', 1745); // https://stackoverflow.com/a/33733386/8700211
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('redirect');
    }
}
