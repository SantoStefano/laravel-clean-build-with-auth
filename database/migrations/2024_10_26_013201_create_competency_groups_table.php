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
        Schema::create('competency_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Заполняем тестовыми данными
        DB::table('competency_groups')->insert([
            ['name' => 'Computer Science'],
            ['name' => 'Engineering Technology'],
            ['name' => 'Creative Arts & Fashion'],
            ['name' => 'Construction & Building'],
            ['name' => 'Transport & Logistics'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('competency_groups');
    }
};
