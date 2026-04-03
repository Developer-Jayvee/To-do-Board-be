<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    CONST TABLE = "tickets";
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        if(!Schema::hasColumn(self::TABLE,"category_id")){
            Schema::table(self::TABLE, function(Blueprint $table){
                $table->integer("category_id")->after("label_id");
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
