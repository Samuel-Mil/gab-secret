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
        Schema::create('gabs_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("patient_id");
            $table->unsignedBigInteger("clinic_id");
            $table->foreign('patient_id')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('clinic_id')->references('id')->on('users')->onUpdate('cascade');          
            $table->text("description");
            $table->integer("gab_quant");
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
