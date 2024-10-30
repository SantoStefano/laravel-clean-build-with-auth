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
            $table->enum('participant_type', ['student', 'schoolchild', 'mentor', 'all'])->default('all');
            $table->enum('type', ['text', 'link', 'file', 'date', 'checkbox'])->default('text');
            $table->timestamps();
        });

        // Заполняем справочник атрибутов
        DB::table('participant_attribute_lists')->insert([
            ['name' => 'Образовательная организация', 'participant_type' => 'all', 'type' => 'text'],
            ['name' => 'Специальность', 'participant_type' => 'student', 'type' => 'text'],
            ['name' => 'Обучение по программе Профессионалы', 'participant_type' => 'student', 'type' => 'checkbox'],
            ['name' => 'Курс обучения', 'participant_type' => 'student', 'type' => 'text'],
            ['name' => 'Класс обучения', 'participant_type' => 'schoolchild', 'type' => 'text'],
            ['name' => 'Возраст', 'participant_type' => 'schoolchild', 'type' => 'text'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('participant_attribute_lists');
    }
};
