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
        // Set default values for JSON columns
        \DB::statement("ALTER TABLE `media` 
            MODIFY `manipulations` json DEFAULT (JSON_OBJECT()),
            MODIFY `custom_properties` json DEFAULT (JSON_OBJECT()),
            MODIFY `generated_conversions` json DEFAULT (JSON_OBJECT()),
            MODIFY `responsive_images` json DEFAULT (JSON_OBJECT()),
            MODIFY `dimensions` json DEFAULT (JSON_OBJECT()),
            MODIFY `is_visible` boolean DEFAULT TRUE,
            MODIFY `is_featured` boolean DEFAULT FALSE,
            MODIFY `size` bigint UNSIGNED DEFAULT 0,
            MODIFY `order_column` int UNSIGNED DEFAULT 0;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
