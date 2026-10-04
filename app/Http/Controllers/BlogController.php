<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Destination;
use App\Models\Post;
use App\Models\Tour;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of blog posts
     */
    public function index(Request $request)
    {
        $query = Post::published()->latest('published_at');

        if ($request->filled('s')) {
            $search = $request->get('s');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('tag')) {
            $tag = $request->tag;
            $query->whereJsonContains('tags', $tag);
        }

        $posts = $query->paginate(9)->withQueryString();

        $destinations = Destination::where('is_active', true)->withCount('tours')->get();
        $activities = Activity::where('is_active', true)->get();
        $featuredTours = Tour::where('is_active', true)->where('is_featured', true)->take(4)->get();
        $recentPosts = Post::published()->latest('published_at')->take(5)->get();

        return view('blog.index', compact('posts', 'destinations', 'activities', 'featuredTours', 'recentPosts'));
    }

    /**
     * Display a single blog article
     */
    public function show($slug)
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();

        // Increment view count
        $post->increment('views_count');

        // Related articles (matching category or recent, excluding current)
        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->where('category', $post->category)
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($relatedPosts->count() < 3) {
            $morePosts = Post::published()
                ->where('id', '!=', $post->id)
                ->whereNotIn('id', $relatedPosts->pluck('id'))
                ->latest('published_at')
                ->take(3 - $relatedPosts->count())
                ->get();
            $relatedPosts = $relatedPosts->merge($morePosts);
        }

        // Previous and Next posts for navigation
        $prevPost = Post::published()
            ->where('id', '<', $post->id)
            ->latest('id')
            ->first();

        $nextPost = Post::published()
            ->where('id', '>', $post->id)
            ->oldest('id')
            ->first();

        // Sidebar data
        $destinations = Destination::where('is_active', true)->withCount('tours')->orderBy('sort_order')->get();
        $activities = Activity::where('is_active', true)->get();
        $featuredTours = Tour::where('is_active', true)->where('is_featured', true)->take(3)->get();
        if ($featuredTours->isEmpty()) {
            $featuredTours = Tour::where('is_active', true)->take(3)->get();
        }

        return view('blog.show', compact(
            'post',
            'relatedPosts',
            'prevPost',
            'nextPost',
            'destinations',
            'activities',
            'featuredTours'
        ));
    }
}
