<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Local cache of events authored in Need Navigator — SiteHub never
        // edits these; events:sync is the only writer.
        Schema::create('events', function (Blueprint $table): void {
            $table->id();
            $table->string('external_id')->unique();
            $table->string('kind')->default('event'); // event | class
            $table->jsonb('title')->default('{}');        // translatable
            $table->jsonb('description')->default('{}');  // translatable
            $table->jsonb('location')->default('{}');     // translatable
            $table->timestampTz('starts_at');
            $table->timestampTz('ends_at')->nullable();
            $table->boolean('all_day')->default(false);
            $table->string('registration_url')->nullable();
            $table->jsonb('raw')->default('{}');
            $table->timestamp('synced_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
