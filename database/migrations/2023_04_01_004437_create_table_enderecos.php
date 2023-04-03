<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('end_paciente_id')->nullable();
            $table->foreign('end_paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
            $table->string('end_cep');
            $table->string('end_endereco');
            $table->string('end_numero');
            $table->string('end_complemento');
            $table->string('end_bairro');
            $table->string('end_cidade');
            $table->string('end_estado');
            $table->nullableTimestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('enderecos');
    }
};
