@extends('layouts.website')

@section('title', 'কোর্সসমূহ - আব্দুর রউফ - AI Creative Training Platform')
@section('description', 'বিগিনার থেকে অ্যাডভান্সড, প্রতিটি কোর্স সাজানো হয়েছে বর্তমান মার্কেটের চাহিদা অনুযায়ী।')

@section('content')

<!-- Include Header -->
@include('website.partials.header')

<!-- hero ellipse -->
<img src="{{ asset('website-images/hero-ellipse.svg') }}" alt="ellipse"
    class="absolute left-0 top-0 lg:object-contain lg:h-auto">

<!-- courses page hero section -->
<section class="w-full py-16 lg:py-24 relative">
    <div class="container-x">
        <div class="text-center">
            <h1 class="font-bold text-3xl md:text-4xl lg:text-5xl text-[#E2E8F0] mb-4">
                আমাদের সকল কোর্স
            </h1>
            <p class="font-normal text-base md:text-lg lg:text-xl text-[#ABABAB] max-w-2xl mx-auto">
                বিগিনার থেকে অ্যাডভান্সড, প্রতিটি কোর্স সাজানো হয়েছে বর্তমান মার্কেটের চাহিদা অনুযায়ী।
                আপনার পছন্দের স্কিল বেছে নিন এবং আজই শুরু করুন।
            </p>
        </div>
    </div>
</section>

<!-- courses section with filters start -->
<section class="w-full py-10 lg:py-16">
    <div class="container-x">
        <div class="text-center mb-10 md:mb-12 lg:mb-16">
            <h6
                class="inline-flex items-center gap-x-2 bg-[#fff]/10 rounded-md lg:rounded-[10px] py-2 px-3 lg:py-2.5 lg:px-4 font-normal text-sm lg:text-lg text-[#E2E8F0]">
                <span class="block h-[2px] w-5 bg-line"></span>
                আমাদের কোর্স সমূহ
                <span class="block h-[2px] w-5 bg-line-2"></span>
            </h6>
            <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">
                ফিউচার রেডি হতে বেছে নিন <span class="text-gradient">আপনার পছন্দের স্কিল </span></h2>
            <p
                class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[65%] lg:mx-auto">
                বিগিনার থেকে অ্যাডভান্সড, প্রতিটি কোর্স সাজানো হয়েছে বর্তমান মার্কেটের চাহিদা অনুযায়ী।</p>
        </div>

        <!-- Filters Section -->
        <div class="mb-8 lg:mb-12">
            <form action="{{ route('courses') }}" method="GET" class="w-full">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search by Title -->
                    <div class="w-full">
                        <label for="search" class="block text-sm font-medium text-[#E2E8F0] mb-2">কোর্স খুঁজুন</label>
                        <input type="text"
                            name="search"
                            id="search"
                            value="{{ request('search') }}"
                            placeholder="কোর্সের নাম লিখুন..."
                            class="w-full bg-[#131620] border border-[#232323] rounded-lg px-4 py-3 text-[#fff] placeholder-[#ABABAB] focus:outline-none focus:border-[#E850FF] transition-all duration-300">
                    </div>

                    <!-- Filter by Category -->
                    <div class="w-full">
                        <label for="category" class="block text-sm font-medium text-[#E2E8F0] mb-2">ক্যাটাগরি</label>
                        <select name="category"
                            id="category"
                            class="w-full bg-[#131620] border border-[#232323] rounded-lg px-4 py-3 text-[#fff] focus:outline-none focus:border-[#E850FF] transition-all duration-300">
                            <option value="">সকল ক্যাটাগরি</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter by Type -->
                    <div class="w-full">
                        <label for="type" class="block text-sm font-medium text-[#E2E8F0] mb-2">কোর্সের ধরন</label>
                        <select name="type"
                            id="type"
                            class="w-full bg-[#131620] border border-[#232323] rounded-lg px-4 py-3 text-[#fff] focus:outline-none focus:border-[#E850FF] transition-all duration-300">
                            <option value="">সকল ধরন</option>
                            <option value="FREE" {{ request('type') == 'FREE' ? 'selected' : '' }}>ফ্রি</option>
                            <option value="PAID" {{ request('type') == 'PAID' ? 'selected' : '' }}>পেইড</option>
                        </select>
                    </div>

                    <!-- Filter by Price -->
                    <div class="w-full">
                        <label for="price" class="block text-sm font-medium text-[#E2E8F0] mb-2">সর্বোচ্চ মূল্য</label>
                        <input type="number"
                            name="price"
                            id="price"
                            value="{{ request('price') }}"
                            placeholder="সর্বোচ্চ মূল্য (টাকা)"
                            min="0"
                            class="w-full bg-[#131620] border border-[#232323] rounded-lg px-4 py-3 text-[#fff] placeholder-[#ABABAB] focus:outline-none focus:border-[#E850FF] transition-all duration-300">
                    </div>
                </div>

                <!-- Filter Actions -->
                <div class="flex flex-wrap items-center justify-between gap-4 mt-6">
                    <div class="flex items-center gap-3">
                        <button type="submit"
                            class="bg-submit hover:!bg-lime hover:text-primary border border-[#9F93A7]/70 rounded-md lg:rounded-[10px] px-6 py-2.5 font-medium text-sm text-[#fff] anim transition-all duration-300">
                            ফিল্টার প্রয়োগ করুন
                        </button>
                        <a href="{{ route('courses') }}"
                            class="inline-flex items-center gap-x-2 text-[#ABABAB] hover:text-[#fff] font-medium text-sm anim transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                            ফিল্টার মুছুন
                        </a>
                    </div>

                    <!-- Active Filters Display -->
                    @if(request()->hasAny(['search', 'category', 'type', 'price']))
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-sm text-[#ABABAB]">সক্রিয় ফিল্টার:</span>
                        @if(request('search'))
                        <span class="inline-flex items-center gap-x-1 bg-[#E850FF]/20 border border-[#E850FF]/50 rounded-full px-3 py-1 text-xs text-[#fff]">
                            খোঁজ: {{ request('search') }}
                            <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="hover:text-[#E850FF] ml-1">×</a>
                        </span>
                        @endif
                        @if(request('category'))
                        <span class="inline-flex items-center gap-x-1 bg-[#E850FF]/20 border border-[#E850FF]/50 rounded-full px-3 py-1 text-xs text-[#fff]">
                            ক্যাটাগরি: {{ $categories->find(request('category'))->name ?? '' }}
                            <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="hover:text-[#E850FF] ml-1">×</a>
                        </span>
                        @endif
                        @if(request('type'))
                        <span class="inline-flex items-center gap-x-1 bg-[#E850FF]/20 border border-[#E850FF]/50 rounded-full px-3 py-1 text-xs text-[#fff]">
                            ধরন: {{ request('type') == 'FREE' ? 'ফ্রি' : 'পেইড' }}
                            <a href="{{ request()->fullUrlWithQuery(['type' => null]) }}" class="hover:text-[#E850FF] ml-1">×</a>
                        </span>
                        @endif
                        @if(request('price'))
                        <span class="inline-flex items-center gap-x-1 bg-[#E850FF]/20 border border-[#E850FF]/50 rounded-full px-3 py-1 text-xs text-[#fff]">
                            সর্বোচ্চ: ৳{{ request('price') }}
                            <a href="{{ request()->fullUrlWithQuery(['price' => null]) }}" class="hover:text-[#E850FF] ml-1">×</a>
                        </span>
                        @endif
                    </div>
                    @endif
                </div>
            </form>
        </div>

        <!-- Course Count -->
        @if($courses->count() > 0)
        <div class="mb-6">
            <p class="text-sm text-[#ABABAB]">
                মোট <span class="text-[#E850FF] font-semibold">{{ $courses->total() }}</span> টি কোর্স পাওয়া গেছে
            </p>
        </div>
        @endif

        @if($courses->count() > 0)
        <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-4 md:gap-5 lg:gap-x-6">
            @foreach($courses as $course)
            <div
                class="w-full border-[1px] border-[#fff] rounded-lg lg:rounded-[21px] bg-[#232323] anim effect-card relative flex flex-col justify-between">
                <div class="w-full">
                    <div class="absolute right-3 top-4 z-30 flex items-center gap-x-2">
                        @if($course->reviews_count > 0)
                        <p
                            class="rounded-lg py-1 px-2 text-[#000] bg-orange text-xs font-normal h-5 flex justify-center items-center">
                            {{ $course->reviews_count }} রিভিউ
                        </p>
                        @endif

                        @if($course->enrollments_count > 0)
                        <p
                            class="rounded-lg py-1 px-2 text-[#000] bg-lime text-xs font-normal h-5 flex justify-center items-center">
                            {{ $course->enrollments_count }} এনরোল
                        </p>
                        @endif
                    </div>
                    <div class="w-full h-[220px] lg:h-[297px] relative">
                        <img src="{{ $course->thumbnail_url ?? asset('website-images/course-01.png') }}"
                            alt="{{ $course->title }}"
                            class="w-full rounded-t-lg lg:rounded-t-[21px] h-full object-cover">
                    </div>
                </div>

                <div class="p-5 lg:p-7">
                    <div class="relative z-40">
                        <a href="{{ route('courses.overview', $course->slug) }}"
                            class="font-semibold text-sm lg:text-lg leading-[140%] text-[#E2E8F0] mb-2 lg:mb-2.5 block">
                            {{ $course->title }}</a>
                        <p class="text-xs font-normal text-[#ababab]">
                        @php
                            $totalVideos = $course->modules->sum(function($module) {
                                return $module->lessons->count();
                            });
                        @endphp

                        <ul class="flex items-center gap-x-2 mt-2 lg:mt-2.5">
                            @if($totalVideos > 0)
                            <li>
                                <span class="text-xs font-normal text-[#ababab] block">
                                    🎥 {{ $totalVideos }}টি ভিডিও
                                </span>
                            </li>
                            @if($course->modules->count() > 0)
                            <li>
                                <span class="text-xs font-normal text-[#ababab] block">
                                    |
                                </span>
                            </li>
                            <li>
                                <span class="text-xs font-normal text-[#ababab] block">
                                    📁 {{ $course->modules->count() }}টি মডিউল
                                </span>
                            </li>
                            @endif
                            @endif
                            <li>
                                <span class="text-xs font-normal text-[#ababab] block">
                                    |
                                </span>
                            </li>
                            <li>
                                <span class="text-xs font-normal text-[#ababab] block">
                                    ⏰ লাইফটাইম এক্সেস
                                </span>
                            </li>
                        </ul>
                        </p>

                        <div class="flex items-center justify-between mt-3 lg:mt-5">
                            <div class="w-full flex items-center gap-x-2 lg:gap-x-3">
                                @if($course->instructor && $course->instructor->avatar)
                                <img src="{{ $course->instructor->avatar }}" alt="{{ $course->instructor->name }}"
                                    class="w-8 h-8 lg:w-[42px] lg:h-[42px] rounded-full object-fill border border-[#fff] shrink-0">
                                @else
                                <img src="{{ asset('website-images/avatar.webp') }}" alt="avatar"
                                    class="w-8 h-8 lg:w-[42px] lg:h-[42px] rounded-full object-fill border border-[#fff] shrink-0">
                                @endif
                                <p class="text-xs font-normal text-[#ababab]">
                                    {{ $course->instructor->name ?? 'Instructor' }} <br>
                                    @if($course->category)
                                    {{ $course->category->name }}
                                    @endif
                                </p>
                            </div>
                            <p class="text-xs font-normal text-[#ababab] shrink-0">
                                ⭐ {{ number_format($course->average_rating, 1) }}
                            </p>
                        </div>
                    </div>

                    <div class="w-full relative z-40 mt-5 flex items-center justify-between">
                        @if($course->type === 'FREE')
                        <div class="mb-3 lg:mb-4">
                            <span class="price-current text-[#E2E8F0] font-bold text-lg lg:text-xl">
                                ফ্রি
                            </span>
                        </div>
                        @else
                        <div class="flex items-center gap-x-2">
                            <span class="price-current text-[#fff] font-semibold text-base lg:text-lg">৳{{ number_format($course->price) }}</span>
                        </div>
                        @endif

                        <div class="flex items-center gap-x-3">
                            <a href="{{ route('courses.overview', $course->slug) }}" class="text-[#fff] font-normal text-xs">
                                বিস্তারিত দেখুন
                            </a>
                            <a href="{{ route('courses.overview', $course->slug) }}"
                                class="inline-flex font-golos justify-center items-center bg-submit border border-[#9F93A7]/70 hover:!bg-lime rounded-md lg:rounded-[10px] p-1 lg:p-1.5 px-2 lg:px-4 font-medium text-xs text-[#fff] anim hover:text-primary group">
                                এনরোল করুন
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($courses->hasPages())
        <div class="w-full flex justify-center mt-12 lg:mt-16">
            {{ $courses->appends(request()->query())->links() }}
        </div>
        @endif
        @else
        <div class="text-center py-20">
            <p class="text-[#ABABAB] text-xl mb-4">কোনো কোর্স পাওয়া যায়নি</p>
            <p class="text-[#ABABAB] text-base mb-6">আপনার ফিল্টার পরিবর্তন করে চেষ্টা করুন অথবা সকল কোর্স দেখুন।</p>
            <a href="{{ route('courses') }}"
                class="inline-flex font-golos justify-center items-center bg-submit border border-[#9F93A7]/70 hover:!bg-lime rounded-md lg:rounded-[10px] px-6 py-3 font-medium text-sm text-[#fff] anim hover:text-primary group transition-all duration-300">
                সকল কোর্স দেখুন
            </a>
        </div>
        @endif
    </div>
</section>
<!-- courses section end -->

<!-- Include Footer -->
@include('website.partials.footer')

@stop
