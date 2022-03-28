<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->string('type_name');
            $table->string('type_expense');
            $table->string('amount');
            $table->string('duration')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('Note')->nullable();

            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->bigInteger('bank_id')->unsigned();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade');


            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('incomes');
    }
}
