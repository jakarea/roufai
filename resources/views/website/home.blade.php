@extends('layouts.website')

@section('title', 'RoufAi Academy | Home')
@section('description', 'AI দিয়ে ইমেজ, ভিডিও, মিউজিক ও ভয়েস তৈরি শিখুন। বিগিনার থেকে অ্যাডভান্সড লেভেল, লাইভ ক্লাস এবং রিয়েল প্রজেক্ট সহ কমপ্লিট কোর্স। আজই শুরু করুন!')
@section('keywords', 'AI কোর্স, AI ট্রেনিং, আব্দুর রউফ, Midjourney কোর্স, AI ভিডিও এডিটিং, AI মিউজিক জেনারেশন, ChatGPT কোর্স, AI টুলস বাংলাদেশ')

@section('content')

<!-- hero ellipse -->
<img src="{{ asset('website-images/hero-ellipse.svg') }}" alt="ellipse"
    class="absolute left-0 top-0 lg:object-contain lg:h-auto">
<!-- hero ellipse -->

<!-- hero section start -->
@if($siteSettings->hero_display_mode === 'video')
<!-- Video Mode: Single Full-Screen Video -->
@php
    $activeVideo = $heroSlides->firstWhere('type', 'video');
@endphp
@if($activeVideo && $activeVideo->video_url)
<section class="w-full relative overflow-hidden" style="height: 100vh; padding: 0; margin: 0; max-width: none; left: 0; right: 0;">
    <!-- Include Header -->
    @include('website.partials.header')

    <!-- YouTube Video Background - No Container -->
    <div class="absolute inset-0 w-full h-full" style="width: 100vw; left: 0; right: 0; margin: 0; padding: 0;">
        @php
            // Extract YouTube video ID
            $videoId = '';
            $videoUrl = $activeVideo->video_url;

            if (strpos($videoUrl, 'youtube.com/watch?v=') !== false) {
                $videoId = explode('v=', $videoUrl)[1] ?? '';
                $videoId = explode('&', $videoId)[0] ?? '';
            } elseif (strpos($videoUrl, 'youtu.be/') !== false) {
                $videoId = explode('youtu.be/', $videoUrl)[1] ?? '';
                $videoId = explode('?', $videoId)[0] ?? '';
            }
        @endphp

        <iframe
            src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1&mute=1&loop=1&playlist={{ $videoId }}&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1&fs=0&iv_load_policy=3&disablekb=1&cc_load_policy=0&hl=en&widget_referrer={{ request()->getSchemeAndHttpHost() }}&enablejsapi=0"
            class="w-full h-full absolute inset-0 object-cover"
            frameborder="0"
            style="width: 100%; height: 100%; position: absolute; top: 0; left: 0; pointer-events: none; min-width: 100%; min-height: 100%; transform: scale(1.01);"
            allow="autoplay; encrypted-media"
            allowfullscreen>
        </iframe>

        <!-- Additional overlay to catch any YouTube UI -->
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 100; pointer-events: none;"></div>

        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-[#000]/60"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/70 to-black/30"></div>
    </div>

    @if($activeVideo->show_content)
    <!-- Content Overlay -->
    <div class="container-x relative h-full flex items-center">
        <div class="max-w-2xl py-20 md:py-28 lg:py-32">
            <h1
                class="font-bold text-3xl md:text-4xl lg:text-5xl xl:text-6xl text-[#E2E8F0] leading-[120%] mb-4 lg:mb-6">
                {{ $activeVideo->title }}
            </h1>
            <p class="font-normal text-base md:text-lg lg:text-xl text-[#ABABAB] leading-[140%] mb-6 lg:mb-8">
                {{ $activeVideo->description }}
            </p>
            <a href="{{ $activeVideo->button_url ?: route('courses') }}"
                class="inline-flex font-golos justify-center items-center bg-submit border border-[#9F93A7]/70 hover:!bg-lime rounded-md lg:rounded-[10px] p-1.5 font-medium text-sm md:text-base lg:text-lg text-[#fff] gap-x-3 anim hover:text-primary group lg:py-3 lg:px-6">
                {{ $activeVideo->button_text }}
            </a>
        </div>
    </div>
    @endif

    <!-- Bottom Gradient Mask for smooth transition -->
    <div
        class="absolute bottom-0 left-0 right-0 h-48 md:h-64 lg:h-80 bg-gradient-to-t from-[#0a0a0a] via-[#000]/50 to-transparent z-40 pointer-events-none">
    </div>
</section>
@endif

@else
<!-- Slider Mode: Image Slider with Multiple Slides -->
@section('hero_section')
<section class="w-full relative overflow-hidden" style="height: 100vh;">

    <!-- Include Header -->
    @include('website.partials.header')
    <div class="absolute inset-0 w-full h-full bg-[#000]/50">
    <!-- Hero Slider -->
    <div class="hero-slider relative w-full h-full">

        @foreach($heroSlides as $index => $slide)
        @if($slide->type === 'image')
        <!-- Slide {{ $index + 1 }} -->
        <div class="hero-slide {{ $index === 0 ? 'active' : '' }} absolute inset-0 w-full h-full" style="opacity: {{ $index === 0 ? '1' : '0' }}; z-index: {{ $index === 0 ? '10' : '0' }};">
            <div class="absolute inset-0 w-full h-full">
                <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-[#000]/50"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/70 to-black/30"></div>
            </div>
            <div class="container-x relative h-full flex items-center">
                <div class="max-w-2xl py-20 md:py-28 lg:py-32">
                    <h1
                        class="font-bold text-3xl md:text-4xl lg:text-5xl xl:text-6xl text-[#E2E8F0] leading-[120%] mb-4 lg:mb-6">
                        {{ $slide->title }}
                    </h1>
                    <p class="font-normal text-base md:text-lg lg:text-xl text-[#ABABAB] leading-[140%] mb-6 lg:mb-8">
                        {{ $slide->description }}
                    </p>
                    <a href="{{ $slide->button_url ?: route('courses') }}"
                        class="inline-flex font-golos justify-center items-center bg-submit border border-[#9F93A7]/70 hover:!bg-lime rounded-md lg:rounded-[10px] p-1.5 font-medium text-sm md:text-base lg:text-lg text-[#fff] gap-x-3 anim hover:text-primary group lg:py-3 lg:px-6">
                        {{ $slide->button_text }}
                    </a>
                </div>
            </div>
        </div>
        @endif
        @endforeach

        <!-- Slider Controls -->
        <div class="absolute bottom-8 left-0 right-0 z-50">
            <div class="container-x">
                <div class="flex items-center justify-between">
                    <!-- Navigation Dots -->
                    <div class="flex gap-3">
                        <button
                            class="slider-dot active w-3 h-3 rounded-full bg-[#E850FF] transition-all duration-300"
                            data-slide="0"></button>
                        <button
                            class="slider-dot w-3 h-3 rounded-full bg-[#fff]/30 hover:bg-[#fff]/50 transition-all duration-300"
                            data-slide="1"></button>
                        <button
                            class="slider-dot w-3 h-3 rounded-full bg-[#fff]/30 hover:bg-[#fff]/50 transition-all duration-300"
                            data-slide="2"></button>
                    </div>
                    <!-- Arrow Navigation -->
                    <div class="flex gap-3">
                        <button
                            class="slider-prev cursor-pointer w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-[#fff]/10 hover:bg-[#E850FF] border border-[#fff]/20 flex items-center justify-center transition-all duration-300 group">
                            <svg class="w-5 h-5 text-[#fff] transform rotate-180" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                        <button
                            class="slider-next cursor-pointer w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-[#fff]/10 hover:bg-[#E850FF] border border-[#fff]/20 flex items-center justify-center transition-all duration-300 group">
                            <svg class="w-5 h-5 text-[#fff]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Gradient Mask for smooth transition -->
        <div
            class="absolute bottom-0 left-0 right-0 h-48 md:h-64 lg:h-80 bg-gradient-to-t from-[#0a0a0a] via-[#000]/50 to-transparent z-40 pointer-events-none">
        </div>
    </div>
    </div>
</section>
@show
@endif
<!-- hero section end -->

<!-- feature section start -->
<section class="w-full py-10 lg:py-20">
    <div class="container-x">
        <div class="text-center mb-10 md:mb-16 lg:mb-20">
            <h6
                class="inline-flex items-center gap-x-3 bg-[#fff]/10 rounded-md lg:rounded-[10px] py-2 px-3 lg:py-2.5 lg:px-4 font-normal text-sm lg:text-lg text-[#E2E8F0]">
                <span class="block h-[2px] w-5 bg-line"></span>
                আপনার আইডিয়াকে বদলে দিন

                <span class="block h-[2px] w-5 bg-line-2"></span>
            </h6>
            <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">
               আপনার আইডিয়াকে বদলে দিন  <span class="text-gradient">এআই ক্রিয়েশনে</span>
            </h2>
            <p
                class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[60%] lg:mx-auto">
                শিখুন কীভাবে আকর্ষণীয় ইমেজ, এনগেজিং ভিডিও ও প্রফেশনাল মিউজিক/ভয়েসওভার তৈরি করা যায় মুহূর্তেই।
            </p>
        </div>

        <!-- feat card -->
        <div class="w-full grid grid-cols-1 gap-y-5 md:grid-cols-2 gap-5 lg:grid-cols-3 lg:gap-x-6 ">
            <div class="w-full rounded-md lg:rounded-[20px] p-5 md:p-7 lg:p-[34px] border border-[#232323] relative">
                <img src="{{ asset('website-images/feat-card.svg') }}" alt="feat card"
                    class="w-full h-full absolute left-0 top-0 rounded-md lg:rounded-[20px] object-cover">

                <div
                    class="w-[100px] h-[100px] lg:w-[166px] lg:h-[160px] border-2 lg:border-[20px] border-[#21253B] rounded-full mx-auto bg-[#0A0C19] flex justify-center relative items-center">
                    <div
                        class="bg-[#000] w-20 h-20 lg:w-[100px] lg:h-[100px] rounded-full border-3 border-[#171A2C] lg:border-[12px] flex justify-center items-center">
                        <img src="{{ asset('website-images/icons/b-camp-01.svg') }}" alt="icons" class="w-6 md:w-8 lg:w-10">
                        <img src="{{ asset('website-images/icons/curve.svg') }}" alt="curve 1" class="w-[86%] absolute left-1 top-4">
                    </div>
                </div>

                <div class="mt-10 lg:mt-[60px]">
                    <h5 class="font-semibold text-sm lg:text-lg leading-[140%] text-[#E2E8F0] mb-2 lg:mb-2.5">
                       এআই ইমেজ জেনারেশন ও প্রম্পটিং care

                    </h5>
                    <p class="font-normal text-xs lg:text-sm leading-[140%] text-[#ABABAB] lg:max-w-[85%]">
                       টেক্সট প্রম্পট থেকে ভিজ্যুয়াল, পোস্টার, ক্যারেক্টার ডিজাইন ও ফেস এডিট শিখুন।</p>
                </div>
            </div>
             <div class="w-full rounded-md lg:rounded-[20px] p-5 md:p-7 lg:p-[34px] border border-[#232323] relative">
                <img src="{{ asset('website-images/feat-card.svg') }}" alt="feat card"
                    class="w-full h-full absolute left-0 top-0 rounded-md lg:rounded-[20px] object-cover">

                <div
                    class="w-[100px] h-[100px] lg:w-[166px] lg:h-[160px] border-2 lg:border-[20px] border-[#21253B] rounded-full mx-auto bg-[#0A0C19] flex justify-center relative items-center">
                    <div
                        class="bg-[#000] w-20 h-20 lg:w-[100px] lg:h-[100px] rounded-full border-3 border-[#171A2C] lg:border-[12px] flex justify-center items-center">
                        <img src="{{ asset('website-images/icons/b-camp-01.svg') }}" alt="icons" class="w-6 md:w-8 lg:w-10">
                        <img src="{{ asset('website-images/icons/curve.svg') }}" alt="curve 1" class="w-[86%] absolute left-1 top-4">
                    </div>
                </div>

                <div class="mt-10 lg:mt-[60px]">
                    <h5 class="font-semibold text-sm lg:text-lg leading-[140%] text-[#E2E8F0] mb-2 lg:mb-2.5">
                      এআই ভিডিও ক্রিয়েশন


                    </h5>
                    <p class="font-normal text-xs lg:text-sm leading-[140%] text-[#ABABAB] lg:max-w-[85%]">
                     টেক্সট/ইমেজ থেকে ভিডিও, লিপ-সিঙ্ক, ভয়েস ও ইফেক্টসহ বিজ্ঞাপন ও শর্টস তৈরি করুন।

</p>
                </div>
            </div>
             <div class="w-full rounded-md lg:rounded-[20px] p-5 md:p-7 lg:p-[34px] border border-[#232323] relative">
                <img src="{{ asset('website-images/feat-card.svg') }}" alt="feat card"
                    class="w-full h-full absolute left-0 top-0 rounded-md lg:rounded-[20px] object-cover">

                <div
                    class="w-[100px] h-[100px] lg:w-[166px] lg:h-[160px] border-2 lg:border-[20px] border-[#21253B] rounded-full mx-auto bg-[#0A0C19] flex justify-center relative items-center">
                    <div
                        class="bg-[#000] w-20 h-20 lg:w-[100px] lg:h-[100px] rounded-full border-3 border-[#171A2C] lg:border-[12px] flex justify-center items-center">
                        <img src="{{ asset('website-images/icons/b-camp-01.svg') }}" alt="icons" class="w-6 md:w-8 lg:w-10">
                        <img src="{{ asset('website-images/icons/curve.svg') }}" alt="curve 1" class="w-[86%] absolute left-1 top-4">
                    </div>
                </div>

                <div class="mt-10 lg:mt-[60px]">
                    <h5 class="font-semibold text-sm lg:text-lg leading-[140%] text-[#E2E8F0] mb-2 lg:mb-2.5">
                       এআই মিউজিক ও ভয়েস জেনারেশন


                    </h5>
                    <p class="font-normal text-xs lg:text-sm leading-[140%] text-[#ABABAB] lg:max-w-[85%]">
                       এআই দিয়ে জিঙ্গেল, ব্যাকগ্রাউন্ড স্কোর, ভয়েসওভার ও সাউন্ড ইফেক্ট তৈরি করুন।</p>
                </div>
            </div>
        </div>
        <!-- feat card -->
        
    </div>
</section>
<!-- feature section end -->



<!-- border line -->
<div class="container-x">
    <img src="{{ asset('website-images/line.svg') }}" alt="line" class="w-full mx-auto">
</div>
<!-- border line -->

<!-- our courses section start -->
<section class="w-full py-10 lg:py-20">
    <div class="container-x">
        <div class="text-center mb-10 md:mb-16 lg:mb-20">
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
        <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-4 md:gap-5 lg: gap-x-6">
            @forelse($featuredCourses as $course)
                <x-course-card :course="$course" />
            @empty
            <div class="col-span-12 text-center py-10">
                <p class="text-[#ABABAB] text-lg">এখনো কোনো কোর্স নেই</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
<!-- our courses section end -->

<section class="w-full py-10 lg:py-20">
    <div class="container-x">
        <!-- common title start -->
        <div class="text-center mb-10 md:mb-16 lg:mb-20">
            <h6
                class="inline-flex items-center gap-x-2 bg-[#fff]/10 rounded-md lg:rounded-[10px] py-2 px-3 lg:py-2.5 lg:px-4 font-normal text-sm lg:text-lg text-[#E2E8F0]">
                <span class="block h-[2px] w-5 bg-line"></span>
                প্রশ্ন উত্তর
                <span class="block h-[2px] w-5 bg-line-2"></span>
            </h6>
            <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">
                সচরাচর জানতে চাওয়া <span class="text-gradient"> প্রশ্নের উত্তর </span></h2>
            <p
                class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[65%] lg:mx-auto">
                আমাদের বুটক্যাম্প থেকে শেখা শিক্ষার্থীদের রিয়েল রিভিউ – যা আপনাকেও এগিয়ে যেতে উৎসাহ দেবে।
            </p>
        </div>
        <!-- common title end -->

        <div class="w-full grid grid-cols-1 gap-y-1 lg:gap-y-4">
            @foreach($faqs as $index => $faq)
            <div
                class="faq-item item bg-submit rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] {{ $index % 2 === 0 ? 'faq-card-glow' : 'faq-card-glow faq-card-glow-variant' }} {{ $index === 0 ? 'active' : '' }}"
                onclick="toggleFAQ(this)">
                <div class="w-full col-span-10">
                    <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl lg:pl-5">{{ $faq->question }}</h5>

                    <p class="faq-answer text-sm text-secondary-200 lg:text-base {{ $index === 0 ? 'active' : '' }}">{{ $faq->answer }}</p>
                </div>
                <button type="button" class="col-span-2 flex justify-end cursor-pointer">
                    <img src="{{ asset('website-images/icons/angle-down-circle.svg') }}" alt="angle" class="w-5 lg:w-[26px] faq-icon">
                </button>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- review section start -->
<section class="w-full py-10 lg:py-20">
    <div class="container-x">
        <div class="text-center mb-10 md:mb-16 lg:mb-20">
            <h6
                class="inline-flex items-center gap-x-2 bg-[#fff]/10 rounded-md lg:rounded-[10px] py-2 px-3 lg:py-2.5 lg:px-4 font-normal text-sm lg:text-lg text-[#E2E8F0]">
                <span class="block h-[2px] w-5 bg-line"></span>
                অভিজ্ঞতা সমূহ
                <span class="block h-[2px] w-5 bg-line-2"></span>
            </h6>
            <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">যারা শিখেছেন,
                <span class="text-gradient">তারাই বলছেন</span>
            </h2>
            <p
                class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[50%] lg:mx-auto">
                আমাদের বুটক্যাম্প থেকে শেখা শিক্ষার্থীদের রিয়েল রিভিউ – যা আপনাকেও এগিয়ে যেতে উৎসাহ দেবে।</p>
        </div>

        <div class="w-full grid grid-cols-12 gap-y-5 gap-5 lg:gap-6">
            @forelse($reviews as $review)
            <!-- review card -->
            <div
                class="w-full rounded-md lg:rounded-[10px] p-5 md:p-7 lg:p-[30px] border border-[#232323] relative bg-[#131620] col-span-12 md:col-span-6 lg:col-span-4 review-card">
                <!-- Quote Icon at Top -->
                <div class="absolute top-4 right-4 flex items-center justify-center w-8 h-8 lg:w-10 lg:h-10 rounded-full bg-quote p-1 anim">
                    <img src="{{ asset('website-images/icons/quote.svg') }}" alt="quote" class="w-4 lg:w-5">
                </div>

                <p class="font-normal text-[#ABABAB] text-xs lg:text-sm leading-[140%]">
                    {{ $review->comment ?? '' }}
                </p>

                <hr class="border-0 w-full h-[1px] bg-[#232323] block my-5 lg:my-[30px]">

                <div class="w-full flex items-center justify-between">
                    <div class="flex items-center gap-x-3">
                        @if($review->user && $review->user->avatar)
                        <img src="{{ $review->user->avatar }}" alt="{{ $review->user->name ?? 'User' }}"
                            class="w-10 h-10 rounded-full object-contain">
                        @else
                        <img src="{{ asset('website-images/user-avatar.webp') }}" alt="User"
                            class="w-10 h-10 rounded-full object-contain">
                        @endif

                        <div>
                            <h5 class="font-medium text-sm text-[#E2E8F0] flex items-center gap-x-2">
                                {{ $review->user?->name ?? 'Anonymous' }}
                            </h5>
                            <h6 class="common-para !text-xs text-secondary-200">
                                {{ $review->user?->role ?? 'Student' }}
                            </h6>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-1">
                        @if($review->rating)
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($review->rating))
                                    <span class="text-lg lg:text-xl text-[#E2E8F0]">⭐</span>
                                @else
                                    <span class="text-lg lg:text-xl text-[#232323]">☆</span>
                                @endif
                            @endfor
                        @else
                            <span class="text-sm text-[#ABABAB]">No rating</span>
                        @endif
                    </div>
                </div>
            </div>
            <!-- review card -->
            @empty
            <div class="col-span-12 text-center py-10">
                <p class="text-[#ABABAB] text-lg">এখনো কোনো রিভিউ নেই</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
<!-- review section end -->

<!-- border line -->
<div class="container-x">
    <img src="{{ asset('website-images/line.svg') }}" alt="line" class="w-full mx-auto">
</div>
<!-- border line -->

<!-- upcommin course section -->
@if($bootcampCourses && $bootcampCourses->count() > 0)
<section class="w-full py-10 lg:py-20 relative">
    <div class="container-x">
        <div class="text-center mb-10 md:mb-16">
            <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0]">
                বুটক্যাম্প কোর্সসমূহ
            </h2>
            <p class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5">
                আমাদের বিশেষ বুটক্যাম্প কোর্সগুলোতে এনরোল করুন এবং দ্রুত দক্ষ হয়ে উঠুন
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($bootcampCourses as $bootcampCourse)
            <a href="{{ route('course.details', $bootcampCourse->slug) }}"
               class="block bg-card/80 border border-[#49484E]/50 rounded-[10px] overflow-hidden hover:border-orange/50 transition-all duration-300 group">
                <!-- Bootcamp Feature Image -->
                <div class="relative w-full h-[200px] md:h-[250px] overflow-hidden">
                    <img src="{{ $bootcampCourse->bootcamp_feature_image_url ?: $bootcampCourse->thumbnail_url }}"
                         alt="{{ $bootcampCourse->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute top-3 right-3 bg-orange text-primary px-3 py-1 rounded-full text-sm font-bold">
                        বুটক্যাম্প
                    </div>
                </div>

                <!-- Course Info -->
                <div class="p-5">
                    <h3 class="font-bold text-lg lg:text-xl text-[#E2E8F0] mb-2 line-clamp-2">
                        {{ $bootcampCourse->title }}
                    </h3>

                    @if($bootcampCourse->short_description)
                    <p class="font-normal text-sm text-[#ABABAB] mb-4 line-clamp-2">
                        {{ $bootcampCourse->short_description }}
                    </p>
                    @endif

                    <!-- Instructor & Price -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            @if($bootcampCourse->instructor && $bootcampCourse->instructor->avatar_url)
                            <img src="{{ $bootcampCourse->instructor->avatar_url }}"
                                 alt="{{ $bootcampCourse->instructor->name }}"
                                 class="w-8 h-8 rounded-full object-cover">
                            @else
                            <div class="w-8 h-8 rounded-full bg-[#232323] flex items-center justify-center">
                                <span class="text-xs text-[#ABABAB]">{{ substr($bootcampCourse->instructor?->name ?? 'I', 0, 1) }}</span>
                            </div>
                            @endif
                            <span class="text-sm text-[#E2E8F0]">{{ $bootcampCourse->instructor?->name ?? 'প্রশিক্ষক' }}</span>
                        </div>

                        @if($bootcampCourse->price && $bootcampCourse->price > 0)
                        <span class="text-lg font-bold text-orange">৳{{ number_format($bootcampCourse->price) }}</span>
                        @else
                        <span class="text-lg font-bold text-green-400">ফ্রি</span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- get start section start -->
<section class="w-full py-10 lg:py-20">
    <div class="container-x">

        <div class="text-center mb-10 md:mb-16 lg:mb-20">

            <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">
                @if($siteSettings->cta_outer_title)
                    {!! $siteSettings->cta_outer_title !!}
                @else
                    আপনার আইডিয়াকে বদলে দিন <span class="text-gradient"> এআই ক্রিয়েশনে </span>
                @endif
            </h2>
            @if($siteSettings->cta_outer_subtitle)
            <p
                class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[65%] lg:mx-auto">
                {!! $siteSettings->cta_outer_subtitle !!}
            </p>
            @else
            <p
                class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[65%] lg:mx-auto">
                সঠিক পদ্ধতিতে, ধাপে ধাপে এবং কৌশল ব্যবহার করে আপনার স্কিলকে দ্রুত দক্ষ করে তুলুন
            </p>
            @endif
        </div>

        <div class="get-bg relative py-12 px-8 lg:py-[94px] lg:px-[220px] rounded-[20px] lg:min-h-[365px]">
            <div class="absolute left-0 bottom-0 z-20 w-full h-full flex justify-between">
                <img src="{{ asset('website-images/get-start-bottom-left.svg') }}" alt="get left"
                    class="rounded-bl-[20px] lg:object-contain rounded-tl-[20px] max-w-[50%]">
                <img src="{{ asset('website-images/get-start-top-right.svg') }}" alt="get right"
                    class="rounded-tr-[20px] rounded-br-[20px] max-w-[50%] lg:object-contain">
            </div>
            <div class="text-center relative z-30 w-full">
                @if($siteSettings->cta_inner_title)
                <h2 class="font-bold text-2xl lg:text-[44px] text-[#fff] leading-[120%] mb-1">{!! $siteSettings->cta_inner_title !!}</h2>
                @else
                <h2 class="font-bold text-2xl lg:text-[44px] text-[#fff] leading-[120%] mb-1">ক্রিয়েটিভিটির ভবিষ্যৎ
                    <span class="text-gradient">এখন আপনার হাতে</span>
                </h2>
                @endif
                @if($siteSettings->cta_inner_subtitle)
                <p class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[120%]">{!! $siteSettings->cta_inner_subtitle !!}</p>
                @else
                <p class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[120%]">RoufAI প্ল্যাটফর্মে এখনই যুক্ত হোন, হয়ে উঠুন এআই-চালিত ক্রিয়েটিভ প্রফেশনাল।</p>
                @endif

                <div class="flex justify-center items-center gap-x-4  mt-5 lg:mt-10 lg:gap-x-5">
                    @if($siteSettings->cta_button1_text)
                    <a href="{{ $siteSettings->cta_button1_url ?: route('courses') }}"
                        class="inline-flex font-golos justify-center items-center bg-submit rounded-[10px] p-1.5 font-medium text-sm text-[#fff] gap-x-2.5 anim
               hover:!bg-lime md:text-base px-2 lg:text-lg hover:text-primary group lg:my-0 lg:order-1 border border-[#9F93A7]/70 lg:py-3 lg:px-6">
                        {!! $siteSettings->cta_button1_text !!}
                    </a>
                    @else
                    <a href="{{ route('courses') }}"
                        class="inline-flex font-golos justify-center items-center bg-submit rounded-[10px] p-1.5 font-medium text-sm text-[#fff] gap-x-2.5 anim
               hover:!bg-lime md:text-base px-2 lg:text-lg hover:text-primary group lg:my-0 lg:order-1 border border-[#9F93A7]/70 lg:py-3 lg:px-6">
                        এখনই এনরোল করুন
                    </a>
                    @endif
                    @if($siteSettings->cta_button2_text)
                    <a href="{{ $siteSettings->cta_button2_url ?: route('courses') }}"
                        class="inline-flex font-golos justify-center items-center bg-black rounded-[10px] p-1.5 font-medium text-sm text-[#fff] gap-x-2.5 anim
                 md:text-base lg:text-lg hover:text-orange px-2 group lg:my-0 lg:order-1 border border-[#9F93A7]/70 lg:py-3 lg:px-6">
                        {!! $siteSettings->cta_button2_text !!}
                    </a>
                    @else
                    <a href="{{ route('courses') }}"
                        class="inline-flex font-golos justify-center items-center bg-black rounded-[10px] p-1.5 font-medium text-sm text-[#fff] gap-x-2.5 anim
                 md:text-base lg:text-lg hover:text-orange px-2 group lg:my-0 lg:order-1 border border-[#9F93A7]/70 lg:py-3 lg:px-6">
                        সার্টিফিকেট পান
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- get start section end -->

<!-- border line -->
<div class="container-x">
    <img src="{{ asset('website-images/line.svg') }}" alt="line" class="w-full mx-auto">
</div>
<!-- border line -->

@stop

@push('scripts')
<style>
    .hero-slide {
        opacity: 0 !important;
        transition: opacity 1s ease-in-out;
        pointer-events: none;
        z-index: 0;
    }
    .hero-slide.active {
        opacity: 1 !important;
        pointer-events: auto;
        z-index: 10;
    }

    /* Hide YouTube UI elements */
    iframe[src*="youtube"] {
        border: none !important;
    }

    /* Hide any YouTube overlays or suggestions */
    .ytp-gradient-top,
    .ytp-gradient-bottom,
    .ytp-chrome-top,
    .ytp-chrome-bottom,
    .html5-video-player .ytp-title,
    .html5-video-player .ytp-share-button,
    .html5-video-player .ytp-share-title,
    .html5-video-player .ytp-share-icon,
    .ytp-large-play-button,
    .ytp-preview-ad,
    .ytp-cards-teaser,
    .iv-branding,
    .ytp-videowall-still-info {
        display: none !important;
        opacity: 0 !important;
        visibility: hidden !important;
    }
</style>
<script>
    console.log('🚀 Scripts loading...');

    // Hero Slider
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🎠 Hero slider script loaded');

        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.slider-dot');
        const prevBtn = document.querySelector('.slider-prev');
        const nextBtn = document.querySelector('.slider-next');
        let currentSlide = 0;
        let autoPlayInterval;

        function goToSlide(index) {
            // Hide current slide
            slides[currentSlide].classList.remove('active');
            slides[currentSlide].style.opacity = '0';
            slides[currentSlide].style.zIndex = '0';

            dots[currentSlide].classList.remove('bg-[#E850FF]');
            dots[currentSlide].classList.add('bg-[#fff]/30');

            // Update current slide index
            currentSlide = index;

            // Show new slide
            slides[currentSlide].classList.add('active');
            slides[currentSlide].style.opacity = '1';
            slides[currentSlide].style.zIndex = '10';

            dots[currentSlide].classList.remove('bg-[#fff]/30');
            dots[currentSlide].classList.add('bg-[#E850FF]');

            console.log(`🎠 Slide ${currentSlide + 1} activated`);
        }

        function nextSlide() {
            const nextIndex = (currentSlide + 1) % slides.length;
            goToSlide(nextIndex);
        }

        function prevSlide() {
            const prevIndex = (currentSlide - 1 + slides.length) % slides.length;
            goToSlide(prevIndex);
        }

        function startAutoPlay() {
            autoPlayInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
        }

        function stopAutoPlay() {
            clearInterval(autoPlayInterval);
        }

        // Dot navigation
        dots.forEach((dot, index) => {
            dot.addEventListener('click', function() {
                stopAutoPlay();
                goToSlide(index);
                startAutoPlay();
            });
        });

        // Arrow navigation
        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                stopAutoPlay();
                prevSlide();
                startAutoPlay();
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                stopAutoPlay();
                nextSlide();
                startAutoPlay();
            });
        }

        // Start auto-play
        startAutoPlay();
        console.log('✅ Hero slider started!');
    });

    // Countdown Timer - Simple and Direct
    document.addEventListener('DOMContentLoaded', function() {
        console.log('⏰ Countdown script loaded');

        if (typeof window.bootcampTargetDate === 'undefined') {
            console.log('⚠️ No bootcamp target date set');
            return;
        }

        console.log('📅 Target date:', new Date(window.bootcampTargetDate));
        console.log('📅 Current date:', new Date());

        const targetDate = window.bootcampTargetDate;
        const countdownElement = document.getElementById('countdown-timer');

        if (!countdownElement) {
            console.error('❌ Countdown element not found');
            return;
        }

        const daysEl = document.getElementById('countdown-days');
        const hoursEl = document.getElementById('countdown-hours');
        const minutesEl = document.getElementById('countdown-minutes');
        const secondsEl = document.getElementById('countdown-seconds');

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetDate - now;

            if (distance < 0) {
                countdownElement.innerHTML = 'কোর্স শুরু হয়ে গেছে!';
                console.log('✅ Course started!');
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            daysEl.textContent = String(days).padStart(2, '0');
            hoursEl.textContent = String(hours).padStart(2, '0');
            minutesEl.textContent = String(minutes).padStart(2, '0');
            secondsEl.textContent = String(seconds).padStart(2, '0');

            console.log(`⏰ ${days}d ${hours}h ${minutes}m ${seconds}s`);
        }

        // Start countdown
        updateCountdown();
        setInterval(updateCountdown, 1000);
        console.log('✅ Countdown started!');
    });

    // Video Player - Simple and Direct
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🎬 Video script loaded');

        const playButton = document.getElementById('play-video-button');

        if (!playButton) {
            console.log('⚠️ No play button found');
            return;
        }

        console.log('✅ Play button found!');

        playButton.onclick = function(e) {
            e.preventDefault();
            console.log('▶️ Button clicked!');

            const videoPlayer = document.getElementById('video-player');
            const videoUrl = videoPlayer ? videoPlayer.getAttribute('data-video-url') : '';

            console.log('📹 Video URL:', videoUrl);

            if (!videoUrl) {
                alert('No video URL found!');
                return;
            }

            // Extract video ID
            let videoId = '';
            if (videoUrl.includes('youtube.com/watch?v=')) {
                videoId = videoUrl.split('v=')[1].split('&')[0];
            } else if (videoUrl.includes('youtu.be/')) {
                videoId = videoUrl.split('youtu.be/')[1].split('?')[0];
            }

            console.log('🎞️ Video ID:', videoId);

            if (videoId) {
                videoPlayer.innerHTML = '<iframe width="100%" height="700px" src="https://www.youtube.com/embed/' + videoId + '?autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                console.log('✅ Video loaded!');
            } else {
                alert('Invalid YouTube URL!');
            }
        };
    });
</script>
@endpush
