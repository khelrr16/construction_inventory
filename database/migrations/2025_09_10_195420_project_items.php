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
        Schema::create('project_items', function(Blueprint $table){
            $table->id();
            $table->foreignId('project_id')
                ->nullable()
                ->constrained('users')  // references id on users
                ->nullOnDelete();
            $table->foreignId('item_id')
                ->nullable()
                ->constrained('items')  // references id on users
                ->nullOnDelete();
            $table->integer('quantity');
            $table->string('status')->default('active');
            $table->timestamps();
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
