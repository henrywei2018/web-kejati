<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

/**
 * Server-side full-page response cache for public, read-only pages.
 *
 * How it works:
 *  - Only caches GET requests for guest (unauthenticated) users
 *  - Skips pages that have query strings (search, filters, pagination)
 *  - Stores the rendered HTML in the Laravel cache store for 10 minutes
 *  - Subsequent requests within the TTL get the cached HTML with zero DB queries
 *  - Admin panel (/admin/*) and Livewire AJAX calls are never cached
 *
 * This is the single biggest improvement for a low-resource server because it
 * eliminates PHP/DB work entirely for the most common case: anonymous visitors
 * browsing public content pages.
 */
class CachePublicResponse
{
    /** Pages that should never be cached (dynamic/interactive) */
    private array $excludedPrefixes = [
        'admin',
        'livewire',
        'kontak',
    ];

    /** Default cache TTL in seconds */
    private int $ttl = 600; // 10 minutes

    public function handle(Request $request, Closure $next, int $ttl = 600): Response
    {
        $this->ttl = $ttl;

        // Only cache simple GET requests from guests with no query string
        if (!$this->isCacheable($request)) {
            return $next($request);
        }

        $cacheKey = $this->buildCacheKey($request);

        // Serve from cache if available
        if (Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            return response($cached['content'], 200)
                ->header('Content-Type', $cached['content_type'] ?? 'text/html; charset=UTF-8')
                ->header('X-Cache', 'HIT');
        }

        // Process the request normally
        $response = $next($request);

        // Only store successful, full HTML responses
        if ($this->isCacheableResponse($response)) {
            Cache::put($cacheKey, [
                'content'      => $response->getContent(),
                'content_type' => $response->headers->get('Content-Type', 'text/html; charset=UTF-8'),
            ], $this->ttl);

            $response->headers->set('X-Cache', 'MISS');
        }

        return $response;
    }

    private function isCacheable(Request $request): bool
    {
        // Only GET requests
        if (!$request->isMethod('GET')) {
            return false;
        }

        // Never cache authenticated users (they may see personalised content)
        if (Auth::check()) {
            return false;
        }

        // Skip Livewire AJAX updates
        if ($request->hasHeader('X-Livewire')) {
            return false;
        }

        // Skip pages with query strings (search, pagination, filters)
        if ($request->getQueryString()) {
            return false;
        }

        // Skip excluded path prefixes
        $path = ltrim($request->path(), '/');
        foreach ($this->excludedPrefixes as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return false;
            }
        }

        return true;
    }

    private function isCacheableResponse(Response $response): bool
    {
        return $response->isSuccessful()
            && str_contains($response->headers->get('Content-Type', ''), 'text/html');
    }

    private function buildCacheKey(Request $request): string
    {
        return 'page_cache_' . md5($request->url());
    }
}
