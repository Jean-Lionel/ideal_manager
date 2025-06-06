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
        Schema::disableForeignKeyConstraints();

        Schema::create('versements', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('montant', 10, 2);
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->enum('banque', ['CRDB', 'BANCOBU','BCB','INTERBANK','KCB','BCAB','BBCI','BGEF', 'ECOBANK', 'FINBANK','OTHER']);
            $table->text('attachment')->nullable();// FIchier justificatif
            $table->foreignId('user_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('versements');
    }
};
