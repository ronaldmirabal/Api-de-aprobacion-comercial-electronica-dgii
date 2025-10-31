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
        Schema::create('recepcion_facturas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();
            $table->bigInteger('proveedor_id')->unsigned();
            $table->integer('estado')->nullable();
            $table->integer('codigo_motivo_rechazo')->nullable();
            $table->decimal('monto_total',18,2)->default(0.00);
            $table->decimal('total_itbis',18,2)->default(0.00);
            $table->string('url_xml')->nullable();
            $table->timestamps();

            $table->foreign('proveedor_id')
            ->references('id')->on('proveedores')
            ->onDelete('cascade');

             $table->foreign('empresa_id')
            ->references('id')->on('empresas')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recepcion_facturas');
    }
};
