<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('username',30)->unique()->comment('用户名');
            $table->string('password')->comment('密码');
            $table->tinyInteger('sex')->default(0)->comment('性别');
            $table->tinyInteger('age')->default(1)->comment('年龄');
            $table->integer('tz')->default(0);
            $table->integer('gg')->default(0);
            $table->integer('wx')->default(0);
            $table->integer('fy')->default(0);
            $table->tinyInteger('is_created')->default(0)->comment('是否创建;0否 1是');
            $table->tinyInteger('is_admin')->default(0)->comment('0否 1是');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
