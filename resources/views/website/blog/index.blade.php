@extends('layouts.website')

@use('Illuminate\Support\Str')

@section('title', 'AI আপডেট - এআই খবর, টিপস ও ট্রেন্ডস | আব্দুর রউফ')
@section('description', 'এআই ইন্ডাস্ট্রির সর্বশেষ আপডেট, খবর, টিউটোরিয়াল এবং ট্রেন্ডস জানুন। ChatGPT, Midjourney, AI টুলস সম্পর্কে নিয়মিত আপডেট পান।')
@section('keywords', 'AI আপডেট, AI খবর, ChatGPT আপডেট, AI টিউটোরিয়াল, Midjourney গাইড, AI ট্রেন্ডস, AI টুলস বাংলাদেশ')

@section('content')

<!-- Include Header -->
@include('website.partials.header')

<!-- hero ellipse -->
<img src="{{ asset('website-images/hero-ellipse.svg') }}" alt="ellipse"
    class="absolute left-0 top-0 lg:object-contain lg:h-auto">

<!-- Blog Page Hero Section -->
<section class="w-full py-16 lg:py-24 relative">
    <div class="container-x">
        <div class="text-center">
            <h1 class="font-bold text-3xl md:text-4xl lg:text-5xl text-[#E2E8F0] mb-4">
                AI আপডেট
            </h1>
            <p class="font-normal text-base md:text-lg lg:text-xl text-[#ABABAB] max-w-2xl mx-auto">
                এআই ইন্ডাস্ট্রির সর্বশেষ খবর, টিপস, টিউটোরিয়াল এবং ট্রেন্ডস নিয়মিত জানুন
            </p>
        </div>
    </div>
</section>

<!-- Featured Posts Section -->
@if($featuredPosts->count() > 0)
<section class="w-full py-10 lg:py-16 relative">
    <div class="container-x">
        <div class="text-center mb-10 md:mb-12">
            <h6 class="inline-flex items-center gap-x-2 bg-[#fff]/10 rounded-md lg:rounded-[10px] py-2 px-3 lg:py-2.5 lg:px-4 font-normal text-sm lg:text-lg text-[#E2E8F0]">
                <span class="block h-[2px] w-5 bg-line"></span>
                ফিচার্ড পোস্ট
                <span class="block h-[2px] w-5 bg-line-2"></span>
            </h6>
        </div>

        <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredPosts as $post)
            <div class="w-full bg-[#131620] border border-[#232323] rounded-md lg:rounded-[20px] overflow-hidden hover:border-[#E850FF]/50 transition-all duration-300">
                <!-- Featured Image -->
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 bg-[#E850FF] text-white text-xs font-semibold rounded-full">
                            ফিচার্ড
                        </span>
                    </div>
                    @if($post->category)
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 bg-black/70 backdrop-blur-sm text-white text-xs font-medium rounded-full">
                            {{ $post->category }}
                        </span>
                    </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="p-5">
                    <h3 class="font-bold text-lg lg:text-xl text-[#E2E8F0] mb-3 line-clamp-2 hover:text-[#E850FF] transition-colors">
                        <a href="{{ route('blog.show', $post->slug) }}">
                            {{ $post->title }}
                        </a>
                    </h3>
                    <p class="text-sm text-[#ABABAB] mb-4 line-clamp-2">
                        {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}
                    </p>

                    <!-- Meta -->
                    <div class="flex items-center justify-between text-xs text-[#ABABAB] border-t border-[#232323] pt-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-6 h-6 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                                {{ $post->user->name ? substr($post->user->name, 0, 1) : 'A' }}
                            </div>
                            <span>{{ $post->user->name ?? 'Admin' }}</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span>{{ $post->published_at?->format('d M Y') }}</span>
                            <span class="flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>{{ $post->views_count }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Category Filter -->
@if($categories->count() > 0)
<section class="w-full py-8">
    <div class="container-x">
        <div class="flex flex-wrap items-center gap-3 justify-center">
            <a href="{{ route('blog.index') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ !$category ? 'bg-[#E850FF] text-white' : 'bg-[#232323] text-[#ABABAB] hover:bg-[#E850FF]/20 hover:text-white' }}">
                সকল
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('blog.index', ['category' => $cat]) }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ $category === $cat ? 'bg-[#E850FF] text-white' : 'bg-[#232323] text-[#ABABAB] hover:bg-[#E850FF]/20 hover:text-white' }}">
                {{ $cat }}
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- All Blog Posts Section -->
<section class="w-full py-10 lg:py-16 relative">
    <div class="container-x">
        <div class="text-center mb-10 md:mb-12">
            <h6 class="inline-flex items-center gap-x-2 bg-[#fff]/10 rounded-md lg:rounded-[10px] py-2 px-3 lg:py-2.5 lg:px-4 font-normal text-sm lg:text-lg text-[#E2E8F0]">
                <span class="block h-[2px] w-5 bg-line"></span>
                সব আপডেট
                <span class="block h-[2px] w-5 bg-line-2"></span>
            </h6>
            @if($search)
            <p class="text-sm text-[#ABABAB] mt-3">
                "{{ $search }}" এর জন্য {{ $blogPosts->total() }} টি ফলাফল পাওয়া গেছে
            </p>
            @endif
        </div>

        @if($blogPosts->count() > 0)
        <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($blogPosts as $post)
            <div class="w-full bg-[#131620] border border-[#232323] rounded-md lg:rounded-[20px] overflow-hidden hover:border-[#E850FF]/50 transition-all duration-300">
                <!-- Featured Image -->
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                    @if($post->category)
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 bg-black/70 backdrop-blur-sm text-white text-xs font-medium rounded-full">
                            {{ $post->category }}
                        </span>
                    </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="p-5">
                    <h3 class="font-bold text-lg lg:text-xl text-[#E2E8F0] mb-3 line-clamp-2 hover:text-[#E850FF] transition-colors">
                        <a href="{{ route('blog.show', $post->slug) }}">
                            {{ $post->title }}
                        </a>
                    </h3>
                    <p class="text-sm text-[#ABABAB] mb-4 line-clamp-2">
                        {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}
                    </p>

                    <!-- Meta -->
                    <div class="flex items-center justify-between text-xs text-[#ABABAB] border-t border-[#232323] pt-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-6 h-6 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                                {{ $post->user->name ? substr($post->user->name, 0, 1) : 'A' }}
                            </div>
                            <span>{{ $post->user->name ?? 'Admin' }}</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span>{{ $post->published_at?->format('d M Y') }}</span>
                            <span class="flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>{{ $post->views_count }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($blogPosts->hasPages())
        <div class="w-full flex justify-center mt-12">
            {{ $blogPosts->appends(request()->query())->links() }}
        </div>
        @endif
        @else
        <div class="text-center py-20">
            <svg class="w-16 h-16 mx-auto text-[#ABABAB] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
            </svg>
            <h3 class="text-xl font-semibold text-[#E2E8F0] mb-2">কোনো আপডেট পাওয়া যায়নি</h3>
            <p class="text-[#ABABAB]">এখনো কোনো ব্লগ পোস্ট প্রকাশিত হয়নি।</p>
        </div>
        @endif
    </div>
</section>

@stop
