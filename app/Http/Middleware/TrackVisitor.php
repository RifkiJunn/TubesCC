<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('GET') && !$request->ajax()) {
            $ignoredPaths = [
                'admin/*', 
                'api/*', 
                'sanctum/*', 
                '_debugbar/*', 
                'build/*', 
                'vendor/*',
                'livewire/*',
                'storage/*',
                'favicon.ico',
                '*.png',
                '*.jpg',
                '*.jpeg',
                '*.gif',
                '*.svg',
                '*.css',
                '*.js',
            ];

            if (!$request->is($ignoredPaths)) {
                try {
                    \App\Models\Visit::create([
                        'ip_hash' => hash('sha256', $request->ip()),
                        'url' => $request->fullUrl(),
                        'user_id' => auth()->id(),
                    ]);
                } catch (\Exception $e) {
                    // Silently fail to not disrupt user experience
                    \Log::error('Visit tracking failed: ' . $e->getMessage());
                }
            }
        }

        return $next($request);
    }
}
