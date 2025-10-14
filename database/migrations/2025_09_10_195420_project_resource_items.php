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
        Schema::create('project_resource_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')
                ->constrained('projects');
            $table->foreignId('resource_id')
                ->constrained('project_resources');
            $table->foreignId('item_id')
                ->constrained('items');
            $table->integer('quantity');
            $table->integer('supplied')
            ->nullable();
            $table->integer('completed')
            ->nullable();
            $table->integer('missing')
            ->nullable();
            $table->integer('broken')
            ->nullable();
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
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
