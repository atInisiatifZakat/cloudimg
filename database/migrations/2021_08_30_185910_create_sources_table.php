<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('sources', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('user_id')->constrained();

            $table->string('name');

            $table->string('domain')->unique();

            $table->string('provider');
            $table->longText('provider_key')->nullable();
            $table->longText('provider_secret')->nullable();

            $table->string('aws_region')->nullable();
            $table->string('aws_bucket')->nullable();
            $table->string('aws_end_point')->nullable();

            $table->boolean('is_active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sources');
    }
};
