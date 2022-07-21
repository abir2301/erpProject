<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->float('total_ttc',10,3);
            $table->float('ht_price',10,3);
            $table->float('rate_tva',10,3);
            $table->float('price_tva',10,3);
            $table->float('fiscal_timber',10,3);
            $table->string('billNum');
            $table->string('inWord')->nullable();
            $table->string('description')->nullable();
            $table->string('bill_file')->nullable();
            $table->timestamp('DateFacturation');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('SET NULL');
            $table->integer('status')->nullable()->default(false);
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
        Schema::dropIfExists('bills');
    }
}
