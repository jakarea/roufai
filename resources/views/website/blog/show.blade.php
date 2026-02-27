@extends('layouts.website')

@use('Illuminate\Support\Str')

@section('title', $blogPost->title . ' - AI আপডেট | আব্দুর রউফ')
@section('description', Str::limit(strip_tags($blogPost->excerpt ?? $blogPost->content), 160))
@section('keywords', $blogPost->title . ', AI আপডেট, ' . ($blogPost->category ?? 'AI খবর') . ', ' . str_replace('-', ' ', $blogPost->slug))

@section('content')

<!-- Include Header -->
@include('website.partials.header')

<!-- hero ellipse -->
<img src="{{ asset('website-images/hero-ellipse.svg') }}" alt="ellipse"
    class="absolute left-0 top-0 lg:object-contain lg:h-auto">

<!-- Blog Detail Section -->
<section class="w-full py-10 lg:py-16 relative min-h-screen">
    <div class="container-x">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center gap-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-[#ABABAB] hover:text-white">হোম</a></li>
                <li class="text-[#ABABAB]">/</li>
                <li><a href="{{ route('blog.index') }}" class="text-[#ABABAB] hover:text-white">AI আপডেট</a></li>
                <li class="text-[#ABABAB]">/</li>
                <li class="text-white">{{ Str::limit($blogPost->title, 30) }}</li>
            </ol>
        </nav>

        <div class="max-w-4xl mx-auto">
            <!-- Author Info -->
            <div class="flex items-center space-x-4 mb-8">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-xl font-semibold">
                    {{ $blogPost->user->name ? substr($blogPost->user->name, 0, 1) : 'A' }}
                </div>
                <div>
                    <p class="text-[#E2E8F0] font-semibold text-lg">{{ $blogPost->user->name ?? 'Admin' }}</p>
                    <p class="text-sm text-[#ABABAB] capitalize">{{ $blogPost->user->role ?? 'Admin' }}</p>
                </div>
            </div>

            <!-- Featured Image -->
            @if($blogPost->featured_image_url)
            <div class="relative h-64 md:h-96 rounded-xl overflow-hidden mb-8">
                <img src="{{ $blogPost->featured_image_url }}" alt="{{ $blogPost->title }}" class="w-full h-full object-cover">
                @if($blogPost->category)
                <div class="absolute top-4 left-4">
                    <span class="px-4 py-2 bg-[#E850FF] text-white text-sm font-semibold rounded-full">
                        {{ $blogPost->category }}
                    </span>
                </div>
                @endif
            </div>
            @endif

            <!-- Article Header -->
            <div class="mb-8">
                <h1 class="font-bold text-2xl md:text-3xl lg:text-4xl text-[#E2E8F0] mb-4">
                    {{ $blogPost->title }}
                </h1>

                <!-- Meta Info -->
                <div class="flex flex-wrap items-center gap-4 mb-6 text-sm text-[#ABABAB]">
                    <span>{{ $blogPost->published_at?->format('d F Y') }}</span>
                    <span>•</span>
                    <span class="flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span>{{ $blogPost->views_count }} বার পঠিত</span>
                    </span>
                </div>

                @if($blogPost->excerpt)
                <p class="text-lg text-[#E2E8F0] leading-relaxed mb-6 border-l-4 border-[#E850FF] pl-4">
                    {{ $blogPost->excerpt }}
                </p>
                @endif
            </div>

                <!-- Article Content -->
                <div class="prose prose-invert prose-lg max-w-none">
                    <div class="text-[#E2E8F0] leading-relaxed space-y-4">
                        {!! $blogPost->content !!}
                    </div>
                </div>

                <!-- Tags -->
                @if($blogPost->tags && count($blogPost->tags) > 0)
                <div class="mt-8 pt-8 border-t border-[#232323]">
                    <div class="flex flex-wrap gap-2">
                        @foreach($blogPost->tags as $tag)
                        <span class="px-3 py-1 bg-[#232323] text-[#ABABAB] text-sm rounded-full hover:bg-[#E850FF]/20 hover:text-white transition-colors">
                            #{{ $tag }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@stop
