@extends('layouts.website')

@section('title', 'এক্সপার্ট কানেকশন - AI শিল্পী ও ক্রিয়েটিভদের সাথে সংযুক্ত হন | আব্দুর রউফ')
@section('description', 'আব্দুর রউফ প্ল্যাটফর্মের অভিজ্ঞ AI শিল্পী, ভিজ্যুয়ালাইজার এবং ক্রিয়েটিভ এক্সপার্টদের সাথে পরিচিত হন। AI-চালিত ভিজ্যুয়াল স্টোরিটেলিং, ব্র্যান্ডিং এবং মোশন গ্রাফিক্সের বিশেষজ্ঞদের সাথে কানেক্ট হন।')
@section('keywords', 'AI এক্সপার্ট, ভিজ্যুয়াল আর্টিস্ট, AI শিল্পী, ক্রিয়েটিভ ডিজাইনার, AI ভিজ্যুয়ালাইজার, মোশন গ্রাফিক্স, AI স্টোরিটেলিং')

@section('content')

<!-- Include Header -->
@include('website.partials.header')

<!-- hero ellipse -->
<img src="{{ asset('website-images/hero-ellipse.svg') }}" alt="ellipse"
    class="absolute left-0 top-0 lg:object-contain lg:h-auto">

<!-- Expert Connection Page Hero Section -->
<section class="w-full py-16 lg:py-24 relative">
    <div class="container-x">
        <div class="text-center">
            <h1 class="font-bold text-3xl md:text-4xl lg:text-5xl text-[#E2E8F0] mb-4">
                এক্সপার্ট কানেকশন
            </h1>
            <p class="font-normal text-base md:text-lg lg:text-xl text-[#ABABAB] max-w-2xl mx-auto">
                আমাদের অভিজ্ঞ AI শিল্পী ও ক্রিয়েটিভ এক্সপার্টদের সাথে পরিচিত হন
            </p>
        </div>
    </div>
</section>

<!-- Experts Grid Section -->
<section class="w-full py-10 lg:py-16 relative">
    <div class="container-x">
        <div class="w-full grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-4 lg:gap-x-10 lg:gap-y-[64px]">
            @forelse($experts as $expert)
            <!-- card -->
            <div class="w-full">
                <div class="img">
                    <img src="{{ $expert->image_url }}" alt="{{ $expert->name }}" class="w-full lg:w-[90%] mx-auto">
                </div>
                <div class="txt mt-4 lg:mt-8 text-center">
                    <h5 class="font-medium text-base lg:text-xl text-[#fff]">{{ $expert->name }}</h5>
                    <h6 class="font-normal text-xs lg:text-sm text-[#fff]">{{ $expert->title }}</h6>
                    <p class="mt-2 lg:mt-3 font-normal text-xs lg:text-sm text-[#fff]">{{ $expert->bio }}</p>
                    <div class="social mt-4 lg:mt-5 flex items-center justify-center gap-x-2">
                        @if($expert->facebook_url)
                        <a href="{{ $expert->facebook_url }}" target="_blank" rel="noopener noreferrer">
                            <img src="{{ asset('website-images/icons/facebook.svg') }}" alt="facebook" class="w-5 lg:w-8">
                        </a>
                        @endif 
                        @if($expert->linkedin_url)
                        <a href="{{ $expert->linkedin_url }}" target="_blank" rel="noopener noreferrer">
                            <img src="{{ asset('website-images/icons/linkedin.svg') }}" alt="linkedin" class="w-5 lg:w-8">
                        </a>
                        @endif  
                    </div>
                </div>
            </div>
            <!-- card -->
            @empty
            <div class="col-span-full text-center py-20">
                <svg class="w-16 h-16 mx-auto text-[#ABABAB] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="text-xl font-semibold text-[#E2E8F0] mb-2">কোনো এক্সপার্ট পাওয়া যায়নি</h3>
                <p class="text-[#ABABAB]">এখনো কোনো এক্সপার্ট যোগ করা হয়নি।</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

@stop
