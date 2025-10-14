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
        Schema::create('project_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')
                ->constrained('projects');

            $table->foreignId('created_by')
                ->constrained('users');

            $table->foreignId('warehouse_id')
                ->nullable()
                ->constrained('warehouses');

            $table->foreignId('prepared_by')
                ->nullable()
                ->constrained('users');

            $table->foreignId('driver_id')
                ->nullable()
                ->constrained('users');

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users');
                
            $table->text('remark')->nullable();
            $table->date('schedule')->nullable();
            $table->string('status')->nullable();
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
