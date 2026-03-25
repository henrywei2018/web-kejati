<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add composite and missing indexes to improve query performance on low-resource servers.
 *
 * Key improvements:
 *  - blog_posts: composite (status, published_at) replaces two separate index scans
 *  - blog_posts: index on view_count for ORDER BY view_count DESC queries
 *  - employees: indexes on is_active, department, employment_status for filter queries
 *  - media: index on collection_name for media collection lookups
 */
return new class extends Migration
{
    public function up(): void
    {
        // Composite index for the most common published-posts query pattern:
        // WHERE status = 'published' AND published_at <= now()
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->index(['status', 'published_at'], 'blog_posts_status_published_at_idx');
            $table->index('view_count', 'blog_posts_view_count_idx');
        });

        // Employee filter indexes
        Schema::table('employees', function (Blueprint $table) {
            $table->index('is_active', 'employees_is_active_idx');
            $table->index('department', 'employees_department_idx');
            $table->index('employment_status', 'employees_employment_status_idx');
            $table->index('display_order', 'employees_display_order_idx');
        });

        // Media collection lookup index (used by infografis, pengumuman, publikasi queries)
        Schema::table('media', function (Blueprint $table) {
            $table->index('collection_name', 'media_collection_name_idx');
        });
    }

    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropIndex('blog_posts_status_published_at_idx');
            $table->dropIndex('blog_posts_view_count_idx');
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->dropIndex('employees_is_active_idx');
            $table->dropIndex('employees_department_idx');
            $table->dropIndex('employees_employment_status_idx');
            $table->dropIndex('employees_display_order_idx');
        });

        Schema::table('media', function (Blueprint $table) {
            $table->dropIndex('media_collection_name_idx');
        });
    }
};
