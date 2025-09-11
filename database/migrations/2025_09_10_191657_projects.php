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
        Schema::create('projects', function(Blueprint $table) {
            $table->id(); // Primary key (bigint unsigned, auto-increment)

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')  // references id on users
                ->nullOnDelete();       // if user is deleted, set null

            $table->string('project_name');
            $table->string('status')->default('active'); // or 'active', etc.
            $table->timestamps(); // created_at and updated_at
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
