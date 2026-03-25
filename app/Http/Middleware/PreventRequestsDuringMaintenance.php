<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * The URIs that should be reachable while maintenance mode is enabled.
     * Keep the admin panel accessible so you can disable maintenance mode.
     *
     * @var array<int, string>
     */
    protected $except = [
        'admin',
        'admin/*',
    ];

    /**
     * Tell crawlers and browsers to retry after 60 seconds (reduces hammering
     * a low-resource server during maintenance).
     */
    protected $retryAfter = 60;
}
