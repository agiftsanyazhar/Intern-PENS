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
        Schema::create('opportunity_states', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')
                ->constrained('customers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('opportunity_status_id')
                ->default(1)
                ->comment('
                1: Inquiry (Customer/sales just found the opportunity); 
                2: Follow Up (Sales in progress acquiring detail); 
                3: Stale (Customer/sales haven\'t give response for more than 5 working days); 
                4: Completed (PO issued by customer); 
                5: Failed (Customer cancel the opportunity/no reponse for more than 15 working days); 
            ');
            $table->integer('opportunity_value');
            $table->string('title');
            $table->longText('description');
            $table->foreignId('created_by')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('deleted_by')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunity_states');
    }
};
