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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('publisher_id');
            $table->string('isbn', length: 20)
                ->comment('International Standard Book Number');
            $table->string('name');
            $table->json('authors');
            $table->year('year_publication');
            $table->string('detail_link')
                ->comment('External link with detail information about a book and buying it.');
            $table->timestamps();

            $table->unique(['publisher_id', 'isbn']);
            $table->rawIndex('(CAST(authors AS CHAR(255) ARRAY))', 'authors_index');
            $table->foreign('publisher_id')
                ->references('id')
                ->on('publishers')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
