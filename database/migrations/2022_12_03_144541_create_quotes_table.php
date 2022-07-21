<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->float('total_ttc',10,3);
            $table->integer('ht_price');
            $table->integer('rate_tva');
            $table->integer('price_tva');
            $table->float('fiscal_timber',10,3);
            $table->string('QuoteNum');
            $table->string('inWord')->nullable();
            $table->string('description')->nullable();
            $table->timestamp('DateFacturation');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
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
        Schema::dropIfExists('quotes');
    }
}
