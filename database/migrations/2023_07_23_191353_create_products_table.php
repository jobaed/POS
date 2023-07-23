<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create( 'products', function ( Blueprint $table ) {
            $table->id();

            // Relationship
            $table->foreignId( 'user_id' )
                ->constrained()
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId( 'category_id' )
                ->constrained()
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            // Normal Field
            $table->string( 'name', 100 );
            $table->float( 'price', 10, 2 );
            $table->string( 'unit', 100 );
            $table->string( 'img_url', 200 );

            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{
        Schema::dropIfExists( 'products' );
    }
};
