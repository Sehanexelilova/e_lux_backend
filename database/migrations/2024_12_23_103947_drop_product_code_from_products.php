<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropProductCodeFromProducts extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('product_code');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('product_code')->nullable();
        });
    }
}

