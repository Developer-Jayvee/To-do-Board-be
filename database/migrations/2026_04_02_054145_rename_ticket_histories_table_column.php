<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    CONST TABLE = "ticket_histories";
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(self::TABLE,function(Blueprint $table){
            $table->renameColumn("label_id","new_value");
            $table->renameColumn("prev_label_id","previous_value");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
