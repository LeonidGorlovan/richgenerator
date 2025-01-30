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
        Schema::create('rich_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('item');
            $table->json('html');
            $table->unsignedBigInteger('tmpl_id');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('lang_id');
            $table->string('slug')->unique();
            $table->string('status')->default(CfDigital\Delta\Core\Enums\PublishStatus::Published->value);
            $table->nestedSet();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rich_documents', function (Blueprint $table) {
            $table->drop();
        });
    }
};
