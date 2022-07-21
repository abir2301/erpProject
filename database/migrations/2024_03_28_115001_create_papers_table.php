<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papers', function (Blueprint $table) {
            $table->id();
            $table->string('paper_file')->nullable();
            $table->string('paper_name');
            $table->string('description')->nullable();
            $table->integer('status')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamp('alert_date')->nullable();
            $table->boolean('auto_email')->nullable()->default(false);
            $table->boolean('isReminded')->nullable()->default(false);
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('cascade');
            $table->unsignedBigInteger('paper_type')->nullable();
            $table->foreign('paper_type')
                ->references('id')
                ->on('paper_types')
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
        Schema::dropIfExists('papers');
    }
}
