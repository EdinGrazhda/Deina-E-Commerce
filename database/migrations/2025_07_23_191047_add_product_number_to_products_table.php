<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the column already exists
        if (!Schema::hasColumn('product', 'product_number')) {
            Schema::table('product', function (Blueprint $table) {
                $table->string('product_number')->unique()->after('id');
            });
        }

        // Generate product numbers for existing products that don't have them
        DB::statement("UPDATE `product` SET product_number = CONCAT('PRD-', YEAR(NOW()), '-', LPAD(id, 4, '0')) WHERE product_number IS NULL OR product_number = ''");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn('product_number');
        });
    }
};
