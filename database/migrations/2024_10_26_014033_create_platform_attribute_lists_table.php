<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('platform_attribute_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['text', 'link', 'file', 'date'])->default('text');
            $table->timestamps();
        });

        // Заполняем справочник атрибутов
        DB::table('platform_attribute_lists')->insert([
            ['name' => 'Место', 'type' => 'text'],
            ['name' => 'Дата проведения', 'type' => 'date'],
            ['name' => 'Организаторский сбор', 'type' => 'text'],
            ['name' => 'Стоимость проживания', 'type' => 'text'],
            ['name' => 'Стоимость питания', 'type' => 'text'],
            ['name' => 'Ссылка на сайт', 'type' => 'link'],
            ['name' => 'Инфраструктурный лист', 'type' => 'file'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('platform_attribute_lists');
    }
};
