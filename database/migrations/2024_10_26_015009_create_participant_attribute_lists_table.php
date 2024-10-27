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
        Schema::create('participant_attribute_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['student', 'schoolchild', 'mentor', 'all'])->default('all');
            $table->timestamps();
        });

        // Заполняем справочник атрибутов
        DB::table('participant_attribute_lists')->insert([
            ['name' => 'Образовательная организация', 'type' => 'all'],
            ['name' => 'Специальность', 'type' => 'student'],
            ['name' => 'Обучение по программе Профессионалы', 'type' => 'student'],
            ['name' => 'Курс обучения', 'type' => 'student'],
            ['name' => 'Класс обучения', 'type' => 'schoolchild'],
            ['name' => 'Возраст', 'type' => 'schoolchild'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('participant_attribute_lists');
    }
};
