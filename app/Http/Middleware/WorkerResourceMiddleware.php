<?php

namespace App\Http\Middleware;

use App\Models\ProjectResource;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Projects;

class WorkerResourceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $resource = ProjectResource::with('project')->findOrFail($request->route('resource_id'));

        // Admin can view all projects
        if (auth()->guard()->user()->role === 'admin') {
            return $next($request);
        }
        // Workers can only view their assigned projects
        if (auth()->guard()->user()->role === 'site_worker' && $resource->project->worker_id == auth()->guard()->id()) {
            return $next($request);
        }
        
        abort(403, 'Unauthorized access to this project.');
    }
}
