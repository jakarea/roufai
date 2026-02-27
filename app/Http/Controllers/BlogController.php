<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Course;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of all published blog posts.
     */
    public function index(Request $request)
    {
        $category = $request->query('category');
        $search = $request->query('search');

        $query = BlogPost::published()
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc');

        // Filter by category
        if ($category) {
            $query->byCategory($category);
        }

        // Search by title or excerpt
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $blogPosts = $query->paginate(9);
        $featuredPosts = BlogPost::published()
            ->featured()
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        // Get all unique categories
        $categories = BlogPost::published()
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        // Get top 3 enrolled courses for footer
        $topCourses = Course::where('is_published', true)
            ->withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->take(3)
            ->get();

        // Get site settings if available
        $siteSettings = null;
        if (class_exists('App\Models\SiteSetting')) {
            $siteSettings = \App\Models\SiteSetting::first();
        }

        return view('website.blog.index', compact(
            'blogPosts',
            'featuredPosts',
            'categories',
            'siteSettings',
            'category',
            'search',
            'topCourses'
        ));
    }

    /**
     * Display the specified blog post.
     */
    public function show($slug)
    {
        $blogPost = BlogPost::where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Increment view count
        $blogPost->incrementViews();

        // Get related posts by category
        $relatedPosts = collect();
        if ($blogPost->category) {
            $relatedPosts = BlogPost::published()
                ->where('category', $blogPost->category)
                ->where('id', '!=', $blogPost->id)
                ->orderBy('published_at', 'desc')
                ->take(4)
                ->get();
        }

        // If no related posts by category, get recent posts
        if ($relatedPosts->isEmpty()) {
            $relatedPosts = BlogPost::published()
                ->where('id', '!=', $blogPost->id)
                ->orderBy('published_at', 'desc')
                ->take(4)
                ->get();
        }

        // Get top 3 enrolled courses for footer
        $topCourses = Course::where('is_published', true)
            ->withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->take(3)
            ->get();

        // Get site settings if available
        $siteSettings = null;
        if (class_exists('App\Models\SiteSetting')) {
            $siteSettings = \App\Models\SiteSetting::first();
        }

        return view('website.blog.show', compact(
            'blogPost',
            'relatedPosts',
            'siteSettings',
            'topCourses'
        ));
    }
}
