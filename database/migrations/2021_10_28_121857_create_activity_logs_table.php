<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('SET NULL');
            $table->unsignedBigInteger('action_id')->nullable();
            $table->foreign('action_id')
                    ->references('id')
                    ->on('actions')
                    ->onDelete('SET NULL');
            $table->unsignedBigInteger('space_id')->nullable();
            $table->foreign('space_id')
                    ->references('id')
                    ->on('spaces')
                    ->onDelete('SET NULL');
            $table->string('service_name')->nullable();
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
        Schema::dropIfExists('activity_logs');
    }
}
