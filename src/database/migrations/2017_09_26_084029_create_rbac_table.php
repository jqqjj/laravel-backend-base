<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRbacTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->increments('admin_id');
            $table->string('name',255);
            $table->string('password',255);
            $table->string('nick_name',255)->default('');
            $table->string('email',255);
            $table->integer('enabled')->unsigned()->default(1);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('role_id');
            $table->string('role_name',255)->unique();
            $table->text('remark',255);
            $table->timestamps();
        });
        Schema::create('admin_roles', function (Blueprint $table) {
            $table->increments('admin_role_id');
            $table->integer('admin_id')->unsigned();
            $table->foreign('admin_id')->references('admin_id')->on('admin');
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('role_id')->on('roles');
            $table->timestamps();
        });
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->increments('role_permission_id');
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('role_id')->on('roles');
            $table->string('permission',255);
            $table->timestamps();
        });
        //change
        Schema::table('admin', function (Blueprint $table) {
            $table->string('last_login_ip')->default("")->after('remember_token');
            $table->timestamp('last_login_time')->nullable()->after('last_login_ip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //unchnage
        Schema::table('admin', function ($table) {
            $table->dropColumn(['last_login_ip', 'last_login_time']); 
        });
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('admin_roles');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('admin');
    }
}
