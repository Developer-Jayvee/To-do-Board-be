<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table("labels",function(Blueprint $table){
            $table->string("bgColor")->default("gray")->nullable()->after("sort");
            $table->string("textColor")->default("black")->nullable()->after("bgColor");
            // $table->string("inlineCSS")->default("bg-gray-200 text-black font-semibold")->after("sort");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns("labels","bgColor");
        Schema::dropColumns("labels","textColor");
    }
};
