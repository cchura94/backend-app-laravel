<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->dateTime("fecha_pedido");
            $table->integer("estado")->default(1);
            $table->decimal("monto_total")->default(0);
            $table->string("cod_factura")->nullable();
            $table->bigInteger("persona_id")->unsigned();
            $table->bigInteger("personal_id")->unsigned();
            
            $table->foreign("persona_id")->references("id")->on("personas");
            $table->foreign("personal_id")->references("id")->on("personals");
            
            $table->softDeletes();
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
        Schema::dropIfExists('pedidos');
    }
}
