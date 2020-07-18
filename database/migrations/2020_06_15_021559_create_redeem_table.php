<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\RedeemStatus;

class CreateRedeemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redeems', function (Blueprint $table) {
            $table->char('id',36)->primary();
            $table->string('owner_id');
            $table->string('franchise_id');
            $table->string('bank_account_id');
            $table->string('admin_id')->nullable();
            $table->integer('amount');
            $table->enum('status',RedeemStatus::getAllKeys());
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
        Schema::dropIfExists('redeems');
    }
}
