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
                ->constrained('users');
            $table->string('worker_id')->nullable();
            $table->string('project_name');
            $table->text('description')->nullable();
            $table->string('status')->default('draft');
            $table->string('remark')->nullable();
            $table->string('house')->nullable();
            $table->string('barangay')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('zipcode')->nullable();
            $table->timestamps(); // created_at and updated_at
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
