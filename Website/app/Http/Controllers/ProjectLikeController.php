<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class ProjectLikeController extends Controller
{
    /**
     * Like a project
     *
     * @param  string  $slug  Project slug
     * @return \Illuminate\Http\Response
     */
    public function store($slug)
    {
        try {
            $project = Project::where('slug', $slug)->firstOrFail();
            $project->incrementLikes();
            
            return Response::json([
                'success' => true,
                'likes' => $project->fresh()->likes,
                'message' => 'Project liked successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error liking project: ' . $e->getMessage());
            
            return Response::json([
                'success' => false,
                'message' => 'Failed to like project.'
            ], 500);
        }
    }
}
