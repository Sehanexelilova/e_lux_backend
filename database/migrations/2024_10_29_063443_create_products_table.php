<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();

            $table->integer('brand_id')->nullable();

            $table->string('product_name');
            $table->string('product_code');
            $table->json('product_color');
            $table->json('other_photos');
            $table->string('family_color');
            $table->json('product_size')->nullable();
            $table->string('group_code')->nullable();
            $table->float('product_price');
            $table->float('product_discount')->default(0);
            $table->boolean('free_shipping')->default(0);
            $table->boolean('free_changes_return')->default(0);
            $table->string('discount_type')->nullable();
            $table->float('final_price')->nullable();
            $table->text('description')->nullable();
            $table->text('wash_care')->nullable();
            $table->string('fabric')->nullable();
            $table->string('pattern')->nullable();
            $table->string('sleeve')->nullable();
            $table->string('origin')->nullable();
            $table->string('quantity')->nullable();

            $table->string('fit')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->enum('is_feature', ['Yes', 'No'])->default('No');
            $table->tinyInteger('status')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
