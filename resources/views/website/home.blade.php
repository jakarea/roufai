@extends('layouts.website')

@section('title', 'আব্দুর রউফ - AI Creative Training Platform')
@section('description', 'বাংলাদেশের শীর্ষ এআই ক্রিয়েটিভ ট্রেনিং প্ল্যাটফর্ম')

@section('content')

<img src="{{ asset('website-images/hero-ellipse.svg') }}" alt="ellipse"
    class="absolute left-0 top-0 lg:object-contain lg:h-auto">
<!-- hero ellipse -->

<!-- hero slider section start -->
<section class="w-full relative overflow-hidden ">
    <div class="absolute inset-0 w-full h-full bg-[#000]/50">
        <!-- header section start -->
        <header class="w-full pt-5 lg:pt-10 relative z-9999">
            <div class="container-x">
                <div
                    class="w-full grid grid-cols-12 relative bg-[#000]/40 rounded-md p-2 lg:p-2.5 lg:rounded-[14px] lg:items-center lg:px-5">
                    <!-- logo -->
                    <div class="text-start col-span-2">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('website-images/logo.png') }}" alt="logo" class="max-w-20 md:max-w-[95px] lg:max-w-[110px]">
                        </a>
                    </div>
                    <!-- logo -->

                    <div class="navbar flex flex-col gap-y-4 justify-center items-center col-span-10 lg:flex-row">
                        <!-- menu -->
                        <div
                            class="w-full absolute left-0 top-10 min-h-[130px] bg-card z-50 flex justify-center p-4 rounded-md hidden lg:!flex lg:relative lg:bg-transparent lg:min-h-auto lg:left-auto lg:top-auto min-w-[75%]"
                            id="mobile-menu">
                            <ul class="flex flex-col lg:flex-row gap-y-3 lg:gap-y-0 lg:gap-x-[30px] text-center">
                                <li>
                                    <a href="{{ route('home') }}"
                                        class="block font-normal text-base lg:text-xl text-[#ABABAB] anim hover:text-[#fff] {{ request()->routeIs('home') ? 'text-[#fff]' : '' }}">
                                        হোম
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('courses') }}"
                                        class="block font-normal text-base lg:text-xl text-[#ABABAB] anim hover:text-[#fff] {{ request()->routeIs('courses') ? 'text-[#fff]' : '' }}">
                                        কোর্সসমূহ
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('expert.connection') }}"
                                        class="block font-normal text-base lg:text-xl text-[#ABABAB] anim hover:text-[#fff] {{ request()->routeIs('expert.connection') ? 'text-[#fff]' : '' }}">
                                        এক্সপার্ট কানেকশন
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('blog.index') }}"
                                        class="block font-normal text-base lg:text-xl text-[#ABABAB] anim hover:text-[#fff] {{ request()->routeIs('blog.*') ? 'text-[#fff]' : '' }}">
                                        AI আপডেট
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- menu -->

                        <!-- actions -->
                        <div class="w-full lg:min-w-[25%]">
                            <ul class="flex gap-x-3 lg:gap-x-[30px] text-center items-center justify-end">

                                <li>
                                    <button type="button" id="search-toggle"
                                        class="block text-[#ABABAB] hover:text-[#fff] anim cursor-pointer relative z-999">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" class="w-5 h-5 lg:w-6 lg:h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                        </svg>
                                    </button>
                                </li>
                                <li>
                                    <a href="{{ route('login') }}" class="block font-normal text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">
                                        লগইন
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="inline-flex shrink-0 lg:min-w-40 font-golos justify-center items-center bg-submit rounded-md lg:rounded-[10px] p-1.5 font-medium text-sm text-[#fff] gap-x-3 anim hover:!bg-lime md:text-base px-3 pr-2 lg:text-lg hover:text-primary group lg:my-0 lg:order-1 border border-[#9F93A7]/70 lg:py-3 lg:px-5 lg:pr-4">
                                        ফ্রি টুলস
                                        <svg class="w-5 lg:w-8" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect x="0.5" y="29.5" width="29" height="29" rx="14.5" transform="rotate(-90 0.5 29.5)"
                                                stroke="white" />
                                            <path
                                                d="M18.3154 16.9887L18.3154 11.6854M18.3154 11.6854L13.0121 11.6854M18.3154 11.6854L11.6862 18.3146"
                                                stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </li>
                                <li class="lg:hidden">
                                    <button type="button" id="mobile-menu-toggle">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor" class="size-6 text-[#fff]">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
                                        </svg>
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <!-- actions -->
                    </div>
                </div>
            </div>
        </header>
        <!-- header section end -->

        <!-- Search Overlay -->
        <div id="search-overlay"
            class="fixed inset-0 w-full h-full bg-[#0A0C19]/70 backdrop-blur-md z-9999 hidden opacity-0 transition-opacity duration-300">
            <div class="w-full h-full flex items-center justify-center p-4">
                <div class="w-full max-w-3xl">
                    <!-- Close Button -->
                    <div class="flex justify-end mb-8">
                        <button type="button" id="search-close"
                            class="text-[#fff] hover:text-[#E850FF] transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-8 h-8 lg:w-10 lg:h-10">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Search Form -->
                    <form action="{{ route('courses') }}" method="GET" class="w-full">
                        <div class="relative">
                            <input type="text" name="search" id="search-input" placeholder="কোর্স খুঁজুন..."
                                class="w-full bg-[#131620] border-2 border-[#E850FF]/30 rounded-lg lg:rounded-2xl py-4 lg:py-6 px-6 lg:px-8 text-[#fff] text-lg lg:text-2xl placeholder-[#ABABAB] focus:outline-none focus:border-[#E850FF] transition-all duration-300"
                                autocomplete="off">
                            <button type="submit"
                                class="absolute cursor-pointer right-4 lg:right-6 top-1/2 -translate-y-1/2 bg-[#E850FF] hover:bg-[#4941C8] text-[#fff] rounded-lg px-6 lg:px-8 py-2 lg:py-3 font-medium text-base lg:text-lg transition-all duration-300">
                                খুঁজুন
                            </button>
                        </div>
                    </form>

                    <!-- Popular Searches (Optional) -->
                    <div class="mt-8 lg:mt-12">
                        <p class="text-[#ABABAB] text-sm lg:text-base mb-4">জনপ্রিয় সার্চ:</p>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('courses') }}?search=AI"
                                class="px-4 py-2 bg-[#fff]/10 hover:bg-[#E850FF]/20 border border-[#fff]/20 hover:border-[#E850FF]/50 rounded-full text-[#fff] text-sm lg:text-base transition-all duration-300">
                                AI
                            </a>
                            <a href="{{ route('courses') }}?search=ভিডিও"
                                class="px-4 py-2 bg-[#fff]/10 hover:bg-[#E850FF]/20 border border-[#fff]/20 hover:border-[#E850FF]/50 rounded-full text-[#fff] text-sm lg:text-base transition-all duration-300">
                                ভিডিও এডিটিং
                            </a>
                            <a href="{{ route('courses') }}?search=ইমেজ"
                                class="px-4 py-2 bg-[#fff]/10 hover:bg-[#E850FF]/20 border border-[#fff]/20 hover:border-[#E850FF]/50 rounded-full text-[#fff] text-sm lg:text-base transition-all duration-300">
                                ইমেজ জেনারেশন
                            </a>
                            <a href="{{ route('courses') }}?search=মিউজিক"
                                class="px-4 py-2 bg-[#fff]/10 hover:bg-[#E850FF]/20 border border-[#fff]/20 hover:border-[#E850FF]/50 rounded-full text-[#fff] text-sm lg:text-base transition-all duration-300">
                                মিউজিক
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Hero Slider -->
    <div class="hero-slider relative w-full min-h-125 md:min-h-150 lg:min-h-screen ">

        <!-- Slide 1 -->
        <div class="hero-slide active absolute inset-0 w-full h-full">
            <div class="absolute inset-0 w-full h-full">
                <img src="{{ asset('website-images/hero-1.webp') }}" alt="Hero Image" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-[#000]/50"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/70 to-black/30"></div>
            </div>
            <div class="container-x relative h-full flex items-center">
                <div class="max-w-2xl py-20 md:py-28 lg:py-32">
                    <h1
                        class="font-bold text-3xl md:text-4xl lg:text-5xl xl:text-6xl text-[#E2E8F0] leading-[120%] mb-4 lg:mb-6">
                        ইন্ডাস্ট্রি এক্সপার্টদের গাইডলাইনে নিজেকে দক্ষ করে তুলুন
                    </h1>
                    <p class="font-normal text-base md:text-lg lg:text-xl text-[#ABABAB] leading-[140%] mb-6 lg:mb-8">
                        শুধু ভিডিও টিউটোরিয়াল নয়, পাচ্ছেন সরাসরি মেন্টরের সাপোর্ট এবং রিয়েল লাইফ প্রজেক্টের অভিজ্ঞতা।
                    </p>
                    <a href="{{ route('courses') }}"
                        class="inline-flex font-golos justify-center items-center bg-submit border border-[#9F93A7]/70 hover:!bg-lime rounded-md lg:rounded-[10px] p-1.5 font-medium text-sm md:text-base lg:text-lg text-[#fff] gap-x-3 anim hover:text-primary group lg:py-3 lg:px-6">
                        এখনই ভর্তি হোন 
                    </a>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->

                <div class="hero-slide absolute inset-0 w-full h-full">
            <div class="absolute inset-0 w-full h-full">
                <img src="{{ asset('website-images/hero-2.webp') }}" alt="Hero Image" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-[#000]/50"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/70 to-black/30"></div>
            </div>
            <div class="container-x relative h-full flex items-center">
                <div class="max-w-2xl py-20 md:py-28 lg:py-32">
                    <h1
                        class="font-bold text-3xl md:text-4xl lg:text-5xl xl:text-6xl text-[#E2E8F0] leading-[120%] mb-4 lg:mb-6">
                        AI - এর শক্তিতে গড়ুন আগামীর ক্যারিয়ার
                    </h1>
                    <p class="font-normal text-base md:text-lg lg:text-xl text-[#ABABAB] leading-[140%] mb-6 lg:mb-8">
                        সাধারণ দক্ষতা দিয়ে আর নয়, নিজেকে আপডেট করুন ফিউচার টেকনোলজির সাথে। আজই শুরু হোক আপনার AI জার্নি।
                    </p>
                    <a href="{{ route('courses') }}"
                        class="inline-flex font-golos justify-center items-center bg-submit border border-[#9F93A7]/70 hover:!bg-lime rounded-md lg:rounded-[10px] p-1.5 font-medium text-sm md:text-base lg:text-lg text-[#fff] gap-x-3 anim hover:text-primary group lg:py-3 lg:px-6">
                        ফ্রি ক্লাস করুন
                    </a>
                </div>
            </div>
        </div>
       

        <!-- Slide 3 -->

         <div class="hero-slide absolute inset-0 w-full h-full">
            <div class="absolute inset-0 w-full h-full">
                <img src="{{ asset('website-images/hero-3.webp') }}" alt="Hero Image" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-[#000]/50"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/70 to-black/30"></div>
            </div>
            <div class="container-x relative h-full flex items-center">
                <div class="max-w-2xl py-20 md:py-28 lg:py-32">
                    <h1
                        class="font-bold text-3xl md:text-4xl lg:text-5xl xl:text-6xl text-[#E2E8F0] leading-[120%] mb-4 lg:mb-6">
                        সঠিক সময়ে, সুবর্ণ সুযোগে - স্কিল ডেভেলপ হবে যেকোনো জায়গা থেকে।
                    </h1>
                    <p class="font-normal text-base md:text-lg lg:text-xl text-[#ABABAB] leading-[140%] mb-6 lg:mb-8">
                        পিসি বা ল্যাপটপে, ঘরে কিংবা বাইরে - স্মার্ট লার্নিং একটি প্ল্যাটফর্মে।
                    </p>
                    <a href="{{ route('courses') }}"
                        class="inline-flex font-golos justify-center items-center bg-submit border border-[#9F93A7]/70 hover:!bg-lime rounded-md lg:rounded-[10px] p-1.5 font-medium text-sm md:text-base lg:text-lg text-[#fff] gap-x-3 anim hover:text-primary group lg:py-3 lg:px-6">
                        ফ্রি ক্লাস করুন
                    </a>
                </div>
            </div>
        </div>

 
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
</section>
<!-- hero slider section end -->

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
                       এআই দিয়ে জিঙ্গেল, ব্যাকগ্রাউন্ড স্কোর, ভয়েসওভার ও সাউন্ড ইফেক্ট তৈরি করুন।

</p>
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
            <!-- card -->
            <div
                class="faq-item item bg-submit rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] faq-card-glow active"
                onclick="toggleFAQ(this)">
                <div class="w-full col-span-10">
                    <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl lg:pl-5">এই কোর্সে যোগ দেওয়ার
                        জন্য কি কোনো
                        বিশেষ যোগ্যতার প্রয়োজন আছে?</h5>

                    <p class="faq-answer text-sm text-secondary-200 lg:text-base active">আমি একজন ডিজাইনার। আগে
                        ডিজাইন করতে ঘন্টার পর ঘন্টা
                        লাগত, কিন্তু এআই শেখার পর কাজ অনেক সহজ হয়েছে। কালার প্যালেট, লেআউট আর ভিজ্যুয়াল তৈরিতে এখন
                        আর ঝামেলা
                        নেই। প্রতিদিনের কাজের গতি বেড়েছে এবং মানও উন্নত হয়েছে। আমার ক্লায়েন্টরা এখন আগের চেয়ে
                        অনেক বেশি
                        সন্তুষ্ট।</p>
                </div>
                <button type="button" class="col-span-2 flex justify-end cursor-pointer">
                    <img src="{{ asset('website-images/icons/angle-down-circle.svg') }}" alt="angle 1" class="w-5 lg:w-[26px] faq-icon">
                </button>
            </div>
            <!-- card -->
            <!-- card -->
            <div
                class="faq-item item bg-submit rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] faq-card-glow faq-card-glow-variant"
                onclick="toggleFAQ(this)">
                <div class="w-full col-span-10">
                    <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl lg:pl-5">কোর্সের সময়কাল কতদিন এবং
                        কীভাবে
                        ক্লাসগুলো পরিচালিত হয়?</h5>

                    <p class="faq-answer text-sm text-secondary-200 lg:text-base">এই কোর্সটি ৩ দিনের জন্য ডিজাইন
                        করা হয়েছে। প্রতিদিন ২-৩ ঘন্টা করে লাইভ ক্লাস থাকবে। ক্লাসগুলো জুম প্ল্যাটফর্মে অনুষ্ঠিত হবে
                        এবং সব ক্লাসের রেকর্ডিং পাবেন যাতে পরে আবার দেখতে পারেন।
                    </p>
                </div>
                <button type="button" class="col-span-2 flex justify-end cursor-pointer">
                    <img src="{{ asset('website-images/icons/angle-down-circle.svg') }}" alt="angle 1" class="w-5 lg:w-[26px] faq-icon">
                </button>
            </div>
            <!-- card -->
            <!-- card -->
            <div
                class="faq-item item bg-submit rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] faq-card-glow"
                onclick="toggleFAQ(this)">
                <div class="w-full col-span-10">
                    <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl lg:pl-5">কোর্স  কি কোনো
                        লুকানো চার্জ
                        আছে?</h5>

                    <p class="faq-answer text-sm text-secondary-200 lg:text-base">কোনো
                        লুকানো চার্জ নেই। একবার পেমেন্ট করলেই সমস্ত কন্টেন্ট, লাইভ ক্লাস, রেকর্ডেড ক্লাস, এবং
                        সাপোর্ট পাবেন। তাছাড়া বিকাশ, নগদ পেমেন্ট সুবিধাও পাবেন।
                    </p>
                </div>
                <button type="button" class="col-span-2 flex justify-end cursor-pointer">
                    <img src="{{ asset('website-images/icons/angle-down-circle.svg') }}" alt="angle 1" class="w-5 lg:w-[26px] faq-icon">
                </button>
            </div>
            <!-- card -->
            <!-- card -->
            <div
                class="faq-item item bg-submit rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] faq-card-glow faq-card-glow-variant"
                onclick="toggleFAQ(this)">
                <div class="w-full col-span-10">
                    <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl lg:pl-5">কোর্স শেষ করার পর কি কোনো
                        সার্টিফিকেট
                        পাওয়া যাবে?</h5>

                    <p class="faq-answer text-sm text-secondary-200 lg:text-base">হ্যাঁ, কোর্স সম্পন্ন করার পর
                        আপনার একটি ভেরিফাইড সার্টিফিকেট পাবেন যা আপনার LinkedIn এ শেয়ার করতে পারবেন অথবা চাকরির
                        ইন্টারভিউতে দেখাতে পারবেন। তাছাড়া প্রজেক্ট পোর্টফোলিও পাবেন।
                    </p>
                </div>
                <button type="button" class="col-span-2 flex justify-end cursor-pointer">
                    <img src="{{ asset('website-images/icons/angle-down-circle.svg') }}" alt="angle 1" class="w-5 lg:w-[26px] faq-icon">
                </button>
            </div>
            <!-- card -->
            <!-- card -->
            <div
                class="faq-item item bg-submit rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] faq-card-glow"
                onclick="toggleFAQ(this)">
                <div class="w-full col-span-10">
                    <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl lg:pl-5">আমি যদি একেবারে নতুন হই,
                        তাহলে কি
                        কোর্সটি বুঝতে পারব?</h5>

                    <p class="faq-answer text-sm text-secondary-200 lg:text-base">বিলকুল! এই কোর্সটি সম্পূর্ণভাবে
                        বিগিনার-ফ্রেন্ডলি। আমরা সমস্ত টুলস এবং প্রক্রিয়া শূন্য থেকে শেখাবো। কোনো পূর্ব অভিজ্ঞতার
                        প্রয়োজন নেই। প্রতিটি লেসন স্টেপ-বাই-স্টেপ সহজ ভাষায় করা হয়েছে।
                    </p>
                </div>
                <button type="button" class="col-span-2 flex justify-end cursor-pointer">
                    <img src="{{ asset('website-images/icons/angle-down-circle.svg') }}" alt="angle 1" class="w-5 lg:w-[26px] faq-icon">
                </button>
            </div>
            <!-- card -->
            <!-- card -->
            <div
                class="faq-item item bg-submit rounded-[10px] p-2.5 grid grid-cols-12 items-center lg:items-start gap-x-2.5 md:p-3.5 lg:p-5 border border-[#49484E] faq-card-glow faq-card-glow-variant"
                onclick="toggleFAQ(this)">
                <div class="w-full col-span-10">
                    <h5 class="text-[#E2E8F0] font-medium text-lg md:text-xl lg:text-2xl lg:pl-5">কোর্স শেষে আমি বাস্তবে কী
                        কী কাজে
                        লাগাতে পারব?</h5>

                    <p class="faq-answer text-sm text-secondary-200 lg:text-base">এই কোর্স শেষে আপনি প্রফেশনাল
                        মানের বিজ্ঞাপন, সোশ্যাল মিডিয়া কন্টেন্ট, প্রডাক্ট ভিজুয়াল, ভিডিও তৈরি, মিউজিক এবং ভয়েসওভার
                        তৈরি করতে পারবেন। ফ্রিল্যান্সার হিসেবে কাজ করতে পারবেন অথবা নিজের বিজনেসের জন্য ব্যবহার করতে
                        পারবেন।
                    </p>
                </div>
                <button type="button" class="col-span-2 flex justify-end cursor-pointer">
                    <img src="{{ asset('website-images/icons/angle-down-circle.svg') }}" alt="angle 1" class="w-5 lg:w-[26px] faq-icon">
                </button>
            </div>
            <!-- card -->
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
@if($bootcampConfig)
<section class="w-full pb-1 lg:pb-10 relative">
    <div class="container-x">
        <div class="w-full text-center mt-10 md:mt-14 lg:mt-[90px] relative z-[99]">
            <h1
                class="inline-flex items-center gap-x-3 bg-[#fff]/10 rounded-md lg:rounded-[10px] py-2 px-3 lg:py-2.5 lg:px-4 font-normal text-sm lg:text-lg text-[#E2E8F0]">
                <span class="block h-[2px] w-5 bg-line"></span>
                আপকামিং লাইভ বুটক্যাম্প
                <span class="block h-[2px] w-5 bg-line-2"></span>
            </h1>
            <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">
                {!! $bootcampConfig->title !!}
            </h2>
            @if($bootcampConfig->description)
            <p
                class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[60%] lg:mx-auto">
                {!! $bootcampConfig->description !!}
            </p>
            @endif

            <!-- Countdown Timer -->
            @if($bootcampConfig->countdown_target_date)
            <div class="flex justify-center gap-x-3 lg:gap-x-5 items-center mt-5 md:mt-10 lg:mt-11">
                <div
                    class="inline-flex font-golos justify-center items-center bg-submit border border-[#9F93A7]/70 rounded-md lg:rounded-[10px] p-1.5 font-medium text-sm text-[#fff] gap-x-3 anim md:text-base px-3 lg:text-lg lg:py-3 lg:px-5"
                    id="countdown-timer">
                    <span id="countdown-days">00</span> Days :
                    <span id="countdown-hours">00</span> Hours :
                    <span id="countdown-minutes">00</span> Minutes :
                    <span id="countdown-seconds">00</span> Seconds
                </div>
            </div>
            <script>
                (function() {
                    // Debug: Show what date we're using
                    const targetDateStr = '{{ $bootcampConfig->countdown_target_date->format('Y-m-d H:i:s') }}';
                    console.log('📅 Countdown Target Date:', targetDateStr);

                    const targetDate = new Date(targetDateStr).getTime();
                    const now = new Date().getTime();

                    console.log('🎯 Target Date (Object):', new Date(targetDate));
                    console.log('📅 Current Date:', new Date(now));
                    console.log('⏰ Difference (hours):', ((targetDate - now) / (1000 * 60 * 60)).toFixed(2));

                    const daysEl = document.getElementById('countdown-days');
                    const hoursEl = document.getElementById('countdown-hours');
                    const minutesEl = document.getElementById('countdown-minutes');
                    const secondsEl = document.getElementById('countdown-seconds');

                    function update() {
                        const currentTime = new Date().getTime();
                        const diff = targetDate - currentTime;

                        if (diff < 0) {
                            document.getElementById('countdown-timer').innerHTML = 'কোর্স শুরু হয়ে গেছে!';
                            return;
                        }

                        const d = Math.floor(diff / (1000 * 60 * 60 * 24));
                        const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                        const s = Math.floor((diff % (1000 * 60)) / 1000);

                        daysEl.textContent = String(d).padStart(2, '0');
                        hoursEl.textContent = String(h).padStart(2, '0');
                        minutesEl.textContent = String(m).padStart(2, '0');
                        secondsEl.textContent = String(s).padStart(2, '0');
                    }

                    update();
                    setInterval(update, 1000);
                })();
            </script>
            @endif


        </div>
        <div class="w-full mt-8 md:mt-12 lg:mt-[62px] lg:max-w-[80%] mx-auto">
            <!-- bootcamp thumbnail -->
            <div
                class="w-full bg-[#131620] border border-[#232323] p-3 lg:p-5 rounded-md lg:rounded-[20px]">
                <div class="w-full relative" id="video-player"
                    data-video-url="{{ $bootcampConfig->display_video_url ?? '' }}">
                    <img src="{{ !empty($bootcampConfig->thumbnail_image) ? (strpos($bootcampConfig->thumbnail_image, 'http') === 0 ? $bootcampConfig->thumbnail_image : Storage::url($bootcampConfig->thumbnail_image)) : ($bootcampConfig->course && $bootcampConfig->course->thumbnail_url ? $bootcampConfig->course->thumbnail_url : asset('website-images/speaking-person.webp')) }}"
                    alt="bootcamp thumbnail"
                    class="w-full h-[349px] object-cover rounded-md lg:rounded-[10px] lg:h-[700px]">
                    @if(!empty($bootcampConfig->display_video_url))
                    <div class="absolute left-0 top-0 w-full h-full flex items-center justify-center">
                        <button type="button" id="play-video-button"
                            class="w-12 h-12 lg:w-20 lg:h-20 rounded-full bg-[#fff]/40 flex items-center justify-center p-1 cursor-pointer animate-pulse anim">
                            <img src="{{ asset('website-images/icons/play.svg') }}" alt="play" class="w-4 lg:w-6">
                        </button>
                    </div>
                    <script>
                        (function() {
                            const btn = document.getElementById('play-video-button');
                            if (btn) {
                                btn.onclick = function(e) {
                                    e.preventDefault();
                                    const videoPlayer = document.getElementById('video-player');
                                    const videoUrl = videoPlayer.getAttribute('data-video-url');

                                    let videoId = '';
                                    if (videoUrl.includes('youtube.com/watch?v=')) {
                                        videoId = videoUrl.split('v=')[1].split('&')[0];
                                    } else if (videoUrl.includes('youtu.be/')) {
                                        videoId = videoUrl.split('youtu.be/')[1].split('?')[0];
                                    }

                                    if (videoId) {
                                        videoPlayer.innerHTML = '<iframe width="100%" height="700px" src="https://www.youtube.com/embed/' + videoId + '?autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                                    }
                                };
                            }
                        })();
                    </script>
                    @endif
                </div>
                <!-- video box -->
            </div>
        </div>
    </div>
</section>
@endif

<!-- payment section start -->
@if($bootcampConfig)
<section class="w-full py-10 lg:py-20">
    <div class="container-x">
        <div
            class="w-full bg-submit rounded-[10px] py-5 px-6 flex flex-col lg:flex-row justify-center items-center text-center lg:justify-between border border-[#49484E]/50">
            <div class="lg:text-start">
                <h5 class="font-medium text-lg white-70 lg:text-2xl">{!! $bootcampConfig->bootcamp_name ?? ($bootcampConfig->course ? $bootcampConfig->course->title : 'বুটক্যাম্প') !!}</h5>
                @if($bootcampConfig->start_date && $bootcampConfig->end_date)
                <p class="font-medium text-sm text-[#ABABAB] mt-1 lg:text-base">
                    {{ $bootcampConfig->start_date->format('d F') }} থেকে {{ $bootcampConfig->end_date->format('d F Y') }} |
                    প্রশিক্ষক: {{ $bootcampConfig->display_instructor_name }}</p>
                @endif
            </div>
            <h6 class="font-medium text-base text-[#C7C7C7] mt-6 lg:text-2xl lg:mt-0">কোর্স ফি:  <span
                    class="text-orange font-bold lg:text-3xl">{!! $bootcampConfig->display_price !!}</span> @if($bootcampConfig->display_price !== 'ফ্রি')@endif</h6>
        </div>

        <div
            class="w-full bg-card/80 rounded-[10px] py-5 px-4 mt-10 divide-y lg:divide-x lg:divide-y-0 divide-[#fff]/10 lg:p-10 lg:mt-12 grid grid-cols-1 lg:grid-cols-2 lg:gap-x-10 border border-[#49484E]/50">
            <div class="left pb-10 lg:pb-0">
                <h3 class="text-center font-medium text-2xl text-[#fff] lg:text-start lg:text-[32px]">এখনই সহজে
                    পেমেন্ট করুন</h3>
                <p class="font-medium text-sm text-[#ABABAB] mt-1 text-center lg:text-start lg:text-base lg:max-w-[80%]">
                    আমাদের কোর্সে ভর্তি হতে পেমেন্ট করা একেবারেই
                    সহজ। বিকাশ, নগদ বা রকেট দিয়ে পেমেন্ট করলেই সঙ্গে সঙ্গে কোর্স এক্সেস পাবেন।</p>

                <h4 class="mt-10 font-medium text-base white-70 text-center mb-2.5 lg:mt-[60px] lg:text-xl lg:text-start">
                    এই নম্বরে পেমেন্ট করুন</h4>
 
                <div
                    class="flex bg-[#011330] justify-between items-center max-w-[80%] rounded-[4px] mx-auto p-1.5 pl-4 lg:mx-0 lg:mr-auto lg:max-w-[46%] lg:rounded-lg">
                    <h5 class="font-bold text-xl text-gradient lg:text-2xl" id="phone-number-display">০১৭১২৩৪৫৬৭৮</h5>
                    <button type="button" onclick="copyPhoneNumber(); return false;"
                        class="bg-[#0B2042] rounded-[2px] py-2 px-3 font-normal text-xs text-blue lg:text-sm anim hover:bg-orange hover:text-primary cursor-pointer anim animate-pulse z-50 pointer-events-auto"
                        style="position: relative; z-index: 1000 !important; pointer-events: auto !important;">কপি
                        করুন</button>
                </div> 

                <h6 class="mt-6 font-medium white-70 text-base lg:mt-[30px] lg:text-lg">বিশেষ দ্রষ্টব্য</h6>

                <ul class="mt-2.5 flex flex-col gap-y-1">
                    <li class="flex items-center gap-x-2">
                        <span class="w-[2px] h-[2px] block bg-[#D9D9D9] lg:w-[3px] lg:h-[3px]"></span>
                        <p class="text-sm font-normal text-[#ABABAB] lg:text-base">
                            Transaction ID সংরক্ষণ করুন, ভুল নম্বরে পাঠালে দায়ভার আমাদের নয়।
                        </p>
                    </li>
                    <li class="flex items-center gap-x-2">
                        <span class="w-[2px] h-[2px] block bg-[#D9D9D9] lg:w-[3px] lg:h-[3px]"></span>
                        <p class="text-sm font-normal text-[#ABABAB] lg:text-base">
                            সফল পেমেন্টে SMS/ইমেইল পাবেন।
                        </p>
                    </li>
                    <li class="flex items-center gap-x-2">
                        <span class="w-[2px] h-[2px] block bg-[#D9D9D9] lg:w-[3px] lg:h-[3px]"></span>
                        <p class="text-sm font-normal text-[#ABABAB] lg:text-base">
                            টাকা ফেরতযোগ্য নয়, সমস্যায় <a href="#" class="text-orange underline">সাপোর্টে
                                যোগাযোগ করুন।</a>
                        </p>
                    </li>
                </ul>
            </div>
            <div class="right pt-10 lg:pt-0">
                <h5 class="font-medium text-base white-70 text-center mb-2.5 lg:text-lg lg:text-start">আপনার
                    পেমেন্ট করা মাধ্যমটি বেছে নিন</h5>

                <form id="bootcamp-enrollment-form" method="POST"
                    class="block mt-5 lg:mt-3 lg:grid lg:grid-cols-12 lg:gap-x-5">
                    @csrf

                    <!-- Hidden Fields -->
                    <input type="hidden" name="bootcamp_config_id" value="{{ $bootcampConfig->id }}">
                    <input type="hidden" name="course_id" value="{{ $bootcampConfig->course_id ?? '' }}">
                    <div
                        class="flex w-full justify-between items-center gap-x-2 lg:gap-x-5 lg:justify-start lg:gap-x-6 lg:mb-[60px] lg:col-span-12">
                        <label for="bootcamp_nagad" class="flex items-center  bg-card anim cursor-pointer px-2 gap-x-2 w-28 h-12">
                            <input type="radio" name="payment_method" id="bootcamp_nagad" value="nagad" checked>
                            <img src="{{ asset('website-images/icons/nagad.svg') }}" alt="nagad" class="max-w-14 lg:max-w-20">
                        </label>
                        <label for="bootcamp_bkash" class="flex items-center  bg-card anim cursor-pointer px-2 gap-x-2 w-28 h-12">
                            <input type="radio" name="payment_method" id="bootcamp_bkash" value="bkash">
                            <img src="{{ asset('website-images/icons/bkash.svg') }}" alt="bkash" class="max-w-14 lg:max-w-20">
                        </label>
                        <label for="bootcamp_rocket" class="flex items-center  bg-card anim cursor-pointer px-2 gap-x-2 w-24 h-12">
                            <input type="radio" name="payment_method" id="bootcamp_rocket" value="rocket">
                            <img src="{{ asset('website-images/icons/rocket.svg') }}" alt="rocket" class="max-w-10 lg:max-w-12.5">
                        </label>
                    </div>
                    <div class="w-full mt-5 lg:col-span-6">
                        <label for="bootcamp_name" class="font-medium text-base white-70 block w-full mb-2.5">আপনার
                            নাম</label>
                        <input type="text" name="name" id="bootcamp_name" placeholder="নাম"
                            class="bg-[#000] h-[38px] rounded-sm px-4 w-full text-[#fff] font-medium text-base placeholder:text-gray-400"
                            required>
                    </div>
                    <div class="w-full mt-5 lg:col-span-6">
                        <label for="bootcamp_email" class="font-medium text-base white-70 block w-full mb-2.5">আপনার
                            ইমেইল</label>
                        <input type="email" name="email" id="bootcamp_email" placeholder="ইমেইল"
                            class="bg-[#000] h-[38px] rounded-sm px-4 w-full text-[#fff] font-medium text-base placeholder:text-gray-400"
                            required>
                    </div>
                    <div class="w-full mt-5 lg:col-span-6">
                        <label for="bootcamp_payment_number" class="font-medium text-base white-70 block w-full mb-2.5">আপনার
                            পেমেন্ট নম্বর</label>
                        <input type="text" name="payment_number" id="bootcamp_payment_number" placeholder="পেমেন্ট নম্বর"
                            class="bg-[#000] h-[38px] rounded-sm px-4 w-full text-[#fff] font-medium text-base placeholder:text-gray-400"
                            required>
                    </div>
                    <div class="w-full mt-5 lg:col-span-6">
                        <label for="bootcamp_paid_amount" class="font-medium text-base white-70 block w-full mb-2.5">পেমেন্ট পরিমাণ (টাকা)</label>
                        <input type="number" name="paid_amount" id="bootcamp_paid_amount" placeholder="পরিমাণ"
                            class="bg-[#000] h-[38px] rounded-sm px-4 w-full text-[#fff] font-medium text-base placeholder:text-gray-400"
                            required>
                    </div>
                    <div class="w-full mt-5 lg:col-span-6">
                        <label for="bootcamp_transaction_id" class="font-medium text-base white-70 block w-full mb-2.5">পেমেন্ট ট্রানজেকশন
                            ID</label>
                        <input type="text" name="transaction_id" id="bootcamp_transaction_id" placeholder="ট্রানজেকশন ID"
                            class="bg-[#000] h-[38px] rounded-sm px-4 w-full text-[#fff] font-medium text-base placeholder:text-gray-400"
                            required>
                    </div>

                    <div class="w-full flex justify-center lg:col-span-12 lg:justify-end">
                        <button type="button" id="submit-enrollment-btn"
                            class="bg-submit hover:!bg-lime hover:text-primary py-2 px-4 font-medium text-base white-70 mt-5 anim cursor-pointer lg:text-xl lg:py-3.5 lg:px-6 rounded-[10px]">কনফার্ম
                            করুন</button>
                    </div>

                </form>

                <!-- Message Container -->
                <div id="enrollment-message" class="hidden mt-5 p-4 rounded-lg text-center"></div>

                <script>
                    function showMessage(message, isSuccess) {
                        const messageContainer = document.getElementById('enrollment-message');
                        messageContainer.classList.remove('hidden');

                        if (isSuccess) {
                            messageContainer.className = 'mt-5 p-4 rounded-lg text-center bg-green-500/20 border border-green-500/50';
                            messageContainer.innerHTML = `
                                <div class="flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-green-400 font-medium text-lg">${message}</p>
                                </div>
                            `;
                        } else {
                            messageContainer.className = 'mt-5 p-4 rounded-lg text-center bg-red-500/20 border border-red-500/50';
                            messageContainer.innerHTML = `
                                <div class="flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-red-400 font-medium text-lg">${message}</p>
                                </div>
                            `;
                        }

                        // Auto hide after 5 seconds
                        setTimeout(() => {
                            messageContainer.classList.add('hidden');
                        }, 5000);
                    }

                    document.getElementById('submit-enrollment-btn').addEventListener('click', function(e) {
                        e.preventDefault();

                        // Hide any previous message
                        document.getElementById('enrollment-message').classList.add('hidden');

                        const form = document.getElementById('bootcamp-enrollment-form');
                        const formData = new FormData(form);
                        const submitBtn = this;

                        // Get selected payment method
                        const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
                        if (!paymentMethod) {
                            showMessage('অনুগ্রহ করে পেমেন্টের মাধ্যম নির্বাচন করুন', false);
                            return;
                        }

                        // Validate required fields
                        const name = formData.get('name');
                        const email = formData.get('email');
                        const paymentNumber = formData.get('payment_number');
                        const transactionId = formData.get('transaction_id');
                        const paidAmount = formData.get('paid_amount');

                        if (!name || !email || !paymentNumber || !transactionId || !paidAmount) {
                            showMessage('অনুগ্রহ করে সকল তথ্য পূরণ করুন', false);
                            return;
                        }

                        // Disable submit button
                        submitBtn.disabled = true;
                        submitBtn.textContent = 'জমা হচ্ছে...';

                        // Convert FormData to object
                        const data = {
                            payment_method: paymentMethod.value,
                            name: name,
                            email: email,
                            payment_number: paymentNumber,
                            transaction_id: transactionId,
                            paid_amount: paidAmount,
                            course_id: formData.get('course_id') || null
                        };

                        fetch('{{ route("bootcamp.enroll") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (result.success) {
                                showMessage(result.message, true);
                                form.reset();
                                // Reset payment method selection to first option
                                document.getElementById('bootcamp_nagad').checked = true;
                            } else {
                                showMessage(result.message || 'দুঃখিত, আপনার রিকোয়েস্ট জমা দেওয়া যায়নি। অনুগ্রহ করে আবার চেষ্টা করুন।', false);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showMessage('দুঃখিত, একটি ত্রুটি হয়েছে। অনুগ্রহ করে পরে আবার চেষ্টা করুন।', false);
                        })
                        .finally(() => {
                            // Re-enable submit button
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'কনফার্ম করুন';
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</section>
@endif
<!-- payment section end -->

<!-- get start section start -->
<section class="w-full py-10 lg:py-20">
    <div class="container-x">

        <div class="text-center mb-10 md:mb-16 lg:mb-20">

            <h2 class="font-bold text-2xl md:text-4xl lg:text-[44px] text-[#E2E8F0] mt-5 lg:mt-[30px]">
                আপনার আইডিয়াকে বদলে দিন <span class="text-gradient"> এআই ক্রিয়েশনে </span></h2>
            <p
                class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[140%] mt-2 lg:mt-3.5 lg:max-w-[65%] lg:mx-auto">
                সঠিক পদ্ধতিতে, ধাপে ধাপে এবং কৌশল ব্যবহার করে আপনার স্কিলকে দ্রুত দক্ষ করে তুলুন
            </p>
        </div>

        <div class="get-bg relative py-12 px-8 lg:py-[94px] lg:px-[220px] rounded-[20px] lg:min-h-[365px]">
            <div class="absolute left-0 bottom-0 z-20 w-full h-full flex justify-between">
                <img src="{{ asset('website-images/get-start-bottom-left.svg') }}" alt="get left"
                    class="rounded-bl-[20px] lg:object-contain rounded-tl-[20px] max-w-[50%]">
                <img src="{{ asset('website-images/get-start-top-right.svg') }}" alt="get right"
                    class="rounded-tr-[20px] rounded-br-[20px] max-w-[50%] lg:object-contain">
            </div>
            <div class="text-center relative z-30 w-full">
                <h2 class="font-bold text-2xl lg:text-[44px] text-[#fff] leading-[120%] mb-1">ক্রিয়েটিভিটির ভবিষ্যৎ
                    <span class="text-gradient">এখন আপনার হাতে</span>
                </h2>
                <p class="font-normal text-sm md:text-base lg:text-xl text-[#ABABAB] leading-[120%]">RoufAI প্ল্যাটফর্মে এখনই যুক্ত হোন, হয়ে উঠুন এআই-চালিত ক্রিয়েটিভ প্রফেশনাল।</p>

                <div class="flex justify-center items-center gap-x-4  mt-5 lg:mt-10 lg:gap-x-5">
                    <a href="{{ route('courses') }}"
                        class="inline-flex font-golos justify-center items-center bg-submit rounded-[10px] p-1.5 font-medium text-sm text-[#fff] gap-x-2.5 anim
               hover:!bg-lime md:text-base px-2 lg:text-lg hover:text-primary group lg:my-0 lg:order-1 border border-[#9F93A7]/70 lg:py-3 lg:px-6">
                        এখনই এনরোল করুন
                    </a>
                    <a href="{{ route('courses') }}"
                        class="inline-flex font-golos justify-center items-center bg-black rounded-[10px] p-1.5 font-medium text-sm text-[#fff] gap-x-2.5 anim
                 md:text-base lg:text-lg hover:text-orange px-2 group lg:my-0 lg:order-1 border border-[#9F93A7]/70 lg:py-3 lg:px-6">
                        সার্টিফিকেট পান
                    </a>
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
<script>
    console.log('🚀 Scripts loading...');

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
