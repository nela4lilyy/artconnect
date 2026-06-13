<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// NOTE: cover_image is already included in the create_categories_table migration (000002).
// This migration is kept as a no-op to avoid breaking existing deployments that ran
// the original migration without the column.
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('categories', 'cover_image')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->string('cover_image')->nullable()->after('name');
            });
        }
    }

    public function down(): void
    {
        // Column managed by create_categories_table migration
    }
};
