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
            $table->timestamps();
        });

        // Заполняем справочник атрибутов
        DB::table('platform_attribute_lists')->insert([
            ['name' => 'Место'],
            ['name' => 'Дата проведения'],
            ['name' => 'Организаторский сбор'],
            ['name' => 'Стоимость проживания'],
            ['name' => 'Стоимость питания'],
            ['name' => 'Ссылка на сайт'],
            ['name' => 'Инфраструктурный лист'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('platform_attribute_lists');
    }
};
