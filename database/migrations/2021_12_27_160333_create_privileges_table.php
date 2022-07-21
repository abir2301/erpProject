<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivilegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('privileges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('SET NULL');
            $table->unsignedBigInteger('space_id')->nullable();
            $table->foreign('space_id')
                ->references('id')
                ->on('spaces')
                ->onDelete('SET NULL');
            $table->unsignedBigInteger('action_id')->nullable();
            $table->foreign('action_id')
                    ->references('id')
                    ->on('actions')
                    ->onDelete('SET NULL');
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
        Schema::dropIfExists('privileges');
    }
}
