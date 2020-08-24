<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('counter_number')->unique();
            $table->string('reference')->unique();
            $table->integer('distributor_id')->unsigned()->default(1);
            $table->date('date');
            $table->double('total',8,2);
            $table->timestamps();
        });

    }
    
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
