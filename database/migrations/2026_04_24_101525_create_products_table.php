<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('Имя - название товара');
            $table->text('description')->comment('Описание товара');
            $table->binary('photo')->comment('Фотография');
            $table->string('price', 50)->comment('Цена в виде строки с разделителем целой и дробной части .');
            $table->string('valprice', 3)->comment('Строковое наименование валюты');
            /* 
            https://habr.com/ru/articles/924838/
            Для обычной коммерции (интернет-магазины, простые платежи) часто выбирают String Base Units. 
            Доллары, евро, рубли удобно передавать как "10.95". 
            Это помогает избежать проблем с JavaScript на фронтенде.
            */
            $table->foreignId('category_id')->comment('Категория товара');
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
