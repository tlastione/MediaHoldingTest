<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      */
//     public function up()
//     {
//         Schema::create('recipes', function (Blueprint $table) {
//             $table->id();
//             $table->string('name');
//             $table->json('ingredients');
//             $table->json('instructions');
//             $table->string('category')->nullable();
//             $table->unsignedInteger('servings')->nullable();
//             $table->unsignedInteger('prep_time_minutes')->nullable();
//             $table->unsignedInteger('cook_time_minutes')->nullable();
//             $table->timestamps();
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('recipes');
//     }
// };
