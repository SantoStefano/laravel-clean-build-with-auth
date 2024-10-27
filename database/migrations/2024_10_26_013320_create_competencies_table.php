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
        Schema::create('competencies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Заполняем тестовыми данными
        DB::table('competencies')->insert([
            ['name' => 'Web Technologies'],
            ['name' => 'Software Development'],
            ['name' => 'Network Administration'],
            ['name' => 'Mechanical Engineering'],
            ['name' => 'Electrical Engineering'],
            ['name' => 'Graphic Design'],
            ['name' => 'Fashion Design'],
            ['name' => 'Building Construction'],
            ['name' => 'Welding'],
            ['name' => 'Automobile Technology'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('competencies');
    }
};
