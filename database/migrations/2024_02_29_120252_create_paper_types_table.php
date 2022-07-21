<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaperTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paper_types', function (Blueprint $table) {
            $table->id();
            $table->string('paper_type');
            $table->boolean('is_renewing')->default(false);
            $table->unsignedBigInteger('email_id')->nullable();
            $table->foreign('email_id')
                ->references('id')
                ->on('mail_contents')
                ->onDelete('SET NULL');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paper_types');
    }
}
