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
        //Eliminar una llave foranea
        Schema::table('personas', function (Blueprint $table) {
            $table->dropForeign(['ducumento_id']);
            $table->dropColumn('documento_id');
        });

        //Crear una llave foranea
        Schema::table('personas', function (Blueprint $table) {
            $table->foreignId('documento_id')->after('estado')->constrained('documentos')->onDelete('cascade');
        });

        //crear el campo numero_documento
        Schema::table('personas', function (Blueprint $table) {
            $table->string('numero_documento', 20)->after('documento_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //eliminar una llave foranea
        Schema::table('personas', function (Blueprint $table) {
            $table->dropForeign(['ducumento_id']);
            $table->dropColumn(['ducumento_id']);
        });

        //crear una llave foranea
        Schema::table('personas', function (Blueprint $table) {
            $table->foreignId('documento_id')->after('estado')->unique()->constrained('documentos')->onDelete('cascade');
        });

        //eliminar el campo numero_documento
        Schema::table('personas', function (Blueprint $table) {
            $table->dropColumn(['numero_ducumento']);
        });
    }
};
