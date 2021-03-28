<?php

use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('portfolio_id');
            $table->string('name');
            $table->unsignedTinyInteger('type')->default(Transaction::TYPE_BUY);
            $table->unsignedBigInteger('coin_id');
            $table->unsignedDecimal('amount', 18, 6);
            $table->unsignedDecimal('price', 18, 6);
            $table->timestamp('date');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('portfolio_id')
                ->references('id')
                ->on('portfolios')
                ->onDelete('cascade');

            $table->foreign('coin_id')
                ->references('id')
                ->on('coins')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
