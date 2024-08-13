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
        Schema::create('opportunity_state_details', function (Blueprint $table) {
            $table->id();
            $table->string('opportunity_name');
            $table->foreignId('opportunity_state_id')
                ->constrained('opportunity_states')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->longText('description')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunity_state_details');
    }
};
