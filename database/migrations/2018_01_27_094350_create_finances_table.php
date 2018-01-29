<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finances', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bank_account_id');
            $table->unsignedInteger('category_id');
            $table->string('description');
            $table->char('dc', 1);
            $table->date('date');
            $table->float('amount');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['bank_account_id', 'date']);
            $table->index('category_id');

            $table->foreign('bank_account_id')->references('id')->on('bank_accounts');
            $table->foreign('category_id')->references('id')->on('categories');
        });

        Schema::create('balances', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bank_account_id');
            $table->date('date');
            $table->float('balance');

            $table->index(['bank_account_id', 'date']);

            $table->foreign('bank_account_id')->references('id')->on('bank_accounts');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finances');
        Schema::dropIfExists('balances');
    }
}
