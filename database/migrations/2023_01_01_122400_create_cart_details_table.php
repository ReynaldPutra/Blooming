<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_details', function (Blueprint $table) {
            $table->char('item_id', 5)->foreignId()->restricted('items', 'id')->onDelete('cascade');
            $table->foreignId('cart_id')->restricted('cart_headers', 'id')->onDelete('cascade');
            $table->primary(['cart_id', 'item_id']);
            $table->integer('qty');
            $table->json('detail_item')->nullable();
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
        Schema::dropIfExists('cart_details');
    }
}
