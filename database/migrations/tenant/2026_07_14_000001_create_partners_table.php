<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->jsonb('description')->default('{}');   // translatable: {"en": ..., "es": ...}
            $table->jsonb('programs')->default('[]');      // list of {name: {...}, description: {...}}
            $table->string('website_url')->nullable();
            $table->string('phone')->nullable();
            $table->string('logo_path')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
