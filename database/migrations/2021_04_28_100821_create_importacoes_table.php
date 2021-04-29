<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('importacoes', function (Blueprint $table) {
            $table->id();
            $table->string('model_type');
            $table->boolean('started')->default(false);
            $table->boolean('success')->nullable();
            $table->integer('requisicoes')->default(0);
            $table->integer('processados')->default(0);
            $table->integer('importados')->default(0);
            $table->integer('ignorados')->default(0);
            $table->dateTime('started_at')->nullable();
            $table->dateTime('finished_at')->nullable();
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
        Schema::dropIfExists('importacoes');
    }
}
