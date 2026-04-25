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
        Schema::create('categorys', function (Blueprint $table) {
            $table->id('cat_id');
            $table->string('name', 255)->comment('Имя - название категории');
            $table->text('description')->comment('Описание категории');
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorys');
    }
};
