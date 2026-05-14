<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('guitars', function (Blueprint $table) {
        $table->id();
        $table->string('brand');          // Field 1
        $table->string('model_name');     // Field 2
        $table->string('guitar_type');    // Field 3 (Electric/Acoustic)
        $table->decimal('price', 10, 2);  // Field 4
        $table->integer('stock_quantity');// Field 5
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guitars');
    }
};
