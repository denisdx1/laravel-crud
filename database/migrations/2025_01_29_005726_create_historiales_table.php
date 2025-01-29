<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('historiales', function (Blueprint $table) {
            $table->id(); 
            
            // Campo que referencia la PK 'dni' en la tabla 'pacientes'
            $table->string('dni'); 

            // Definimos la clave foránea
            $table->foreign('dni')
                  ->references('dni')
                  ->on('pacientes')
                  ->onDelete('cascade')   // acción al eliminar paciente
                  ->onUpdate('cascade');  // acción al actualizar dni en paciente

            // Otros campos de la tabla historiales...
            $table->text('descripcion')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('historiales');
    }
};
