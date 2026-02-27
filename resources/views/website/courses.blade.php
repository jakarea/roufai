@extends('layouts.website')

@section('title', 'AI কোর্সসমূহ - AI ইমেজ, ভিডিও ও মিউজিক জেনারেশন শিখুন | আব্দুর রউফ')
@section('description', 'এআই ইমেজ জেনারেশন, এআই ভিডিও এডিটিং, এআই মিউজিক ক্রিয়েশন এবং এআই ভয়েস জেনারেশন কোর্স। বিগিনার থেকে অ্যাডভান্সড লেভেল পর্যন্ত শিখুন এবং ফ্রিল্যান্সিং ক্যারিয়ার গড়ুন।')
@section('keywords', 'AI কোর্স, AI ইমেজ জেনারেশন, AI ভিডিও এডিটিং, AI মিউজিক, ChatGPT কোর্স, Midjourney কোর্স, AI টুলস, ফ্রিল্যান্সিং কোর্স')

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
<section class="w-full py-10 lg:py-16 relative z-999">
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
                <div class="flex flex-wrap items-center gap-4">
                    <!-- Search by Title -->
                    <div class="flex-1 min-w-[200px]">
                        <label for="search" class="block text-sm font-medium text-[#E2E8F0] mb-2">কোর্স খুঁজুন</label>
                        <input type="text"
                            name="search"
                            id="search"
                            value="{{ request('search') }}"
                            placeholder="কোর্সের নাম লিখুন..."
                            class="w-full bg-[#131620] border border-[#232323] rounded-lg px-4 py-2.5 text-white placeholder-[#ABABAB] focus:outline-none focus:border-[#E850FF] transition-all duration-300 text-sm">
                    </div>

                    <!-- Filter by Category -->
                    <div class="w-auto min-w-[140px]">
                        <label for="category" class="block text-sm font-medium text-[#E2E8F0] mb-2">ক্যাটাগরি</label>
                        <select name="category"
                            id="category"
                            class="w-full bg-[#131620] border border-[#232323] rounded-lg px-3 py-2.5 text-white focus:outline-none focus:border-[#E850FF] transition-all duration-300 text-sm">
                            <option value="">সকল ক্যাটাগরি</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter by Type -->
                    <div class="w-auto min-w-[120px]">
                        <label for="type" class="block text-sm font-medium text-[#E2E8F0] mb-2">ধরন</label>
                        <select name="type"
                            id="type"
                            class="w-full bg-[#131620] border border-[#232323] rounded-lg px-3 py-2.5 text-white focus:outline-none focus:border-[#E850FF] transition-all duration-300 text-sm">
                            <option value="">সকল ধরন</option>
                            <option value="FREE" {{ request('type') == 'FREE' ? 'selected' : '' }}>ফ্রি</option>
                            <option value="PAID" {{ request('type') == 'PAID' ? 'selected' : '' }}>পেইড</option>
                        </select>
                    </div>

                    <!-- Filter by Price -->
                    <div class="w-auto min-w-[140px]">
                        <label for="price" class="block text-sm font-medium text-[#E2E8F0] mb-2">সর্বোচ্চ মূল্য</label>
                        <input type="number"
                            name="price"
                            id="price"
                            value="{{ request('price') }}"
                            placeholder="সর্বোচ্চ মূল্য"
                            min="0"
                            class="w-full bg-[#131620] border border-[#232323] rounded-lg px-3 py-2.5 text-white placeholder-[#ABABAB] focus:outline-none focus:border-[#E850FF] transition-all duration-300 text-sm">
                    </div>

                    <!-- Submit Button -->
                    <div class="w-auto">
                        <label class="block text-sm font-medium text-[#E2E8F0] mb-2">&nbsp;</label>
                        <button type="submit"
                            class="bg-submit hover:bg-lime! hover:text-primary border border-[#9F93A7]/70 rounded-md lg:rounded-[10px] px-5 py-2.5 font-medium text-sm text-white anim transition-all duration-300">
                            ফিল্টার প্রয়োগ করুন
                        </button>
                    </div>

                    <!-- Clear Filter Button -->
                    <div class="w-auto">
                        <label class="block text-sm font-medium text-[#E2E8F0] mb-2">&nbsp;</label>
                        <a href="{{ route('courses') }}"
                            class="inline-flex items-center justify-center gap-x-2 text-[#ABABAB] hover:text-white font-medium text-sm anim transition-all duration-300 border border-[#232323] rounded-lg px-5 py-2.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                            মুছুন
                        </a>
                    </div>
                </div>

                <!-- Active Filters Display -->
                @if(request()->hasAny(['search', 'category', 'type', 'price']))
                <div class="flex items-center gap-2 flex-wrap mt-4">
                    <span class="text-sm text-[#ABABAB]">সক্রিয় ফিল্টার:</span>
                    @if(request('search'))
                    <span class="inline-flex items-center gap-x-1 bg-[#E850FF]/20 border border-[#E850FF]/50 rounded-full px-3 py-1 text-xs text-white">
                        খোঁজ: {{ request('search') }}
                        <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="hover:text-[#E850FF] ml-1">×</a>
                    </span>
                    @endif
                    @if(request('category'))
                    <span class="inline-flex items-center gap-x-1 bg-[#E850FF]/20 border border-[#E850FF]/50 rounded-full px-3 py-1 text-xs text-white">
                        ক্যাটাগরি: {{ $categories->find(request('category'))->name ?? '' }}
                        <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="hover:text-[#E850FF] ml-1">×</a>
                    </span>
                    @endif
                    @if(request('type'))
                    <span class="inline-flex items-center gap-x-1 bg-[#E850FF]/20 border border-[#E850FF]/50 rounded-full px-3 py-1 text-xs text-white">
                        ধরন: {{ request('type') == 'FREE' ? 'ফ্রি' : 'পেইড' }}
                        <a href="{{ request()->fullUrlWithQuery(['type' => null]) }}" class="hover:text-[#E850FF] ml-1">×</a>
                    </span>
                    @endif
                    @if(request('price'))
                    <span class="inline-flex items-center gap-x-1 bg-[#E850FF]/20 border border-[#E850FF]/50 rounded-full px-3 py-1 text-xs text-white">
                        সর্বোচ্চ: ৳{{ request('price') }}
                        <a href="{{ request()->fullUrlWithQuery(['price' => null]) }}" class="hover:text-[#E850FF] ml-1">×</a>
                    </span>
                    @endif
                </div>
                @endif
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
                <x-course-card :course="$course" :enrolledCourseIds="$enrolledCourseIds" :pendingRequestCourseIds="$pendingRequestCourseIds" />
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

<!-- Login Popup Modal -->
<div id="login-popup" class="fixed inset-0 z-[9999] hidden">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="hideLoginPopup()"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#131620] border border-white/20 rounded-xl p-8 max-w-md w-full mx-4 shadow-2xl">
        <button onclick="hideLoginPopup()" class="absolute top-4 right-4 text-[#ABABAB] hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="text-center mb-6">
            <div class="w-16 h-16 rounded-full bg-[#E850FF]/20 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-[#E850FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">লগইন করুন</h3>
            <p class="text-[#ABABAB]">কোর্সে এনরোল করতে আপনার অ্যাকাউন্টে লগইন করুন</p>
        </div>

        <div class="space-y-4">
            <a href="{{ route('login') }}"
               class="block w-full bg-[#E850FF] hover:bg-[#4941C8] text-white font-semibold text-center py-3 px-6 rounded-lg transition-all duration-300">
                লগইন করুন
            </a>
        </div>

        <p class="text-center text-sm text-[#ABABAB] mt-6">
            লগইন করার পর আপনি কোর্সে এনরোল করতে পারবেন
        </p>
    </div>
</div>

<script>
    // Login Popup Functions
    function showLoginPopup() {
        document.getElementById('login-popup').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function hideLoginPopup() {
        document.getElementById('login-popup').classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Close popup on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideLoginPopup();
        }
    });
</script>

@stop
