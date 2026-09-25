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
        $pattern = DB::escape('\\"|\\[|\\]|\\{"|":"[^}]*\\}');
        DB::statement("ALTER TABLE books ADD COLUMN authors_text VARCHAR(510) GENERATED ALWAYS AS (regexp_replace(authors, $pattern, '')) STORED AFTER authors;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
