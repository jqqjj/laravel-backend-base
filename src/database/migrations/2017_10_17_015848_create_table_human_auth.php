<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableHumanAuth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('handshake', function (Blueprint $table) {
            $table->char('handshake_id',32);
            $table->tinyInteger('remaining')->unsigned()->default(0);
            $table->timestamp('expired_time')->nullable();
            $table->primary('handshake_id');
        });
        Schema::create('attempt', function (Blueprint $table) {
            $table->char('handshake_id',32);
            $table->tinyInteger('status')->unsigned()->default(0);
            $table->timestamp('add_time')->nullable();
            $table->char('ip',15)->default("");
            $table->index('handshake_id');
            $table->index('status');
            $table->index('add_time');
            $table->index('ip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('handshake');
        Schema::dropIfExists('attempt');
    }
}
