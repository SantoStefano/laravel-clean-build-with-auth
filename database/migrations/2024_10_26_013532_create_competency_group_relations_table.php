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
        Schema::create('competency_group_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competency_id')->constrained()->onDelete('cascade');
            $table->foreignId('group_id')->constrained('competency_groups')->onDelete('cascade');
            $table->timestamps();
        });

        // Заполняем тестовыми данными
        DB::table('competency_group_relations')->insert([
            ['competency_id' => 1, 'group_id' => 1],
            ['competency_id' => 2, 'group_id' => 1],
            ['competency_id' => 3, 'group_id' => 1],
            ['competency_id' => 4, 'group_id' => 2],
            ['competency_id' => 5, 'group_id' => 2],
            ['competency_id' => 6, 'group_id' => 3],
            ['competency_id' => 7, 'group_id' => 3],
            ['competency_id' => 8, 'group_id' => 4],
            ['competency_id' => 9, 'group_id' => 4],
            ['competency_id' => 10, 'group_id' => 5],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('competency_group_relations');
    }
};
