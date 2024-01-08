<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('types')->insert([
            ['title' => 'Maintenance', 'type' => 'expense'],
            ['title' => 'Loyer', 'type' => 'expense'],
            ['title' => 'Frais', 'type' => 'expense'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Supprimer les données insérées si nécessaire
        DB::table('types')->whereIn('title', ['Maintenance', 'Loyer', 'Frais'])->delete();
    }
};
