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
        Schema::create('navigations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('navigations')->onDelete('cascade');
            $table->string('label'); // Menu label
            $table->string('type')->default('custom'); // custom, page, external, dropdown
            $table->string('url')->nullable(); // For external/custom links
            $table->foreignId('page_id')->nullable()->constrained('pages')->onDelete('cascade'); // Link to Page
            $table->string('icon')->nullable(); // Optional icon class
            $table->string('target')->default('_self'); // _self, _blank
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('meta')->nullable(); // Additional metadata
            $table->timestamps();
            $table->softDeletes();

            $table->index(['parent_id', 'order']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navigations');
    }
};
