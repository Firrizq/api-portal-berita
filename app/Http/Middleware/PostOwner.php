<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PostOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd('danielle marsh');

        $currentuser = Auth::user();
        $post = Post::findOrFail($request->id);

        if($post->author != $currentuser->id){
            return response()->json([
                'message' => 'gada data',
            ]);
        }

        return $next($request);
    }
}
