<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invemtory_models', function (Blueprint $table) {
            $table->id();
            $table->text('product_name');
            $table->date('purchase_date');
            $table->text('quantity');
            $table->text('quantity_type');
            $table->decimal('single_purchase_amount', 8, 2);
            $table->decimal('total_purchase_amount', 8, 2);
            $table->text('user_id');
            $table->text('catagory');
            $table->text('sub_catagory');
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
        Schema::dropIfExists('invemtory_models');
    }
};
