<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_pic_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('opportunity_state_id')
                ->constrained('opportunity_states')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('customer_name');
            $table->string('company_name');
            $table->string('company_address');
            $table->string('company_email')->unique();
            $table->string('company_phone')->unique();
            $table->string('company_pic_name');
            $table->string('company_pic_address');
            $table->string('company_pic_email')->unique();
            $table->string('company_pic_phone')->unique();
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
