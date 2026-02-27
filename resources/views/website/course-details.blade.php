@extends('layouts.website')

@section('title', $course->title . ' - AI কোর্স | আব্দুর রউফ')
@section('description', Str::limit(strip_tags($course->description), 160) . ' - এই কোর্সে শিখুন ' . $course->title . '। লাইভ ক্লাস, ভিডিও টিউটোরিয়াল এবং প্রজেক্ট সহ কমপ্লিট লার্নিং অভিজ্ঞতা।')
@section('keywords', $course->title . ', AI কোর্স, ' . ($course->category->name ?? 'AI ট্রেনিং') . ', ' . str_replace('-', ' ', $course->slug))

@section('content')

<!-- Include Header -->
@include('website.partials.header')

<!-- hero ellipse -->
<img src="{{ asset('website-images/hero-ellipse.svg') }}" alt="ellipse"
    class="absolute left-0 top-0 lg:object-contain lg:h-auto">

<!-- Course Details Section -->
<section class="w-full py-10 lg:py-16 relative">
    <div class="container-x">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center gap-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-[#ABABAB] hover:text-white">হোম</a></li>
                <li class="text-[#ABABAB]">/</li>
                <li><a href="{{ route('courses') }}" class="text-[#ABABAB] hover:text-white">কোর্সসমূহ</a></li>
                <li class="text-[#ABABAB]">/</li>
                <li class="text-white">{{ $course->title }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Content -->
            <div class="lg:col-span-2">
                <!-- Course Title -->
                <h1 class="font-bold text-2xl md:text-3xl lg:text-4xl text-[#E2E8F0] mb-4">
                    {{ $course->title }}
                </h1>

                <!-- Course Meta -->
                <div class="flex flex-wrap items-center gap-4 mb-6 text-sm text-[#ABABAB]">
                    @if($course->category)
                    <span class="bg-white/10 px-3 py-1 rounded-full">{{ $course->category->name }}</span>
                    @endif
                    <span>⭐ {{ number_format($avgRating, 1) }} ({{ $course->reviews->count() }} রিভিউ)</span>
                    <span>👥 {{ $course->enrollments_count }} শিক্ষার্থী</span>
                </div>

                <!-- Course Description -->
                <div class="mb-8">
                    <h2 class="font-semibold text-xl text-[#E2E8F0] mb-3">কোর্স সম্পর্কে</h2>
                    <div class="text-[#ABABAB] leading-relaxed">
                        {!! $course->description !!}
                    </div>
                </div>

                <!-- What You'll Learn -->
                @if($course->learning_outcomes)
                <div class="mb-8">
                    <h2 class="font-semibold text-xl text-[#E2E8F0] mb-4">আপনি যা শিখবেন</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @php $outcomes = explode("\n", $course->learning_outcomes); @endphp
                        @foreach($outcomes as $outcome)
                        @if(trim($outcome))
                        <div class="flex items-start gap-3">
                            <span class="text-green-500 mt-1">✓</span>
                            <span class="text-[#ABABAB]">{{ trim($outcome) }}</span>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Course Modules (Accordion) -->
                <div class="mb-8">
                    <h2 class="font-semibold text-xl text-[#E2E8F0] mb-4">কোর্স কারিকুলাম</h2>
                    <div class="space-y-4" id="curriculum-accordion">
                        @if(isset($course->modules) && $course->modules && $course->modules->count() > 0)
                            @foreach($course->modules as $moduleIndex => $module)
                                @php
                                    $moduleLessons = $module->lessons ?? collect();
                                @endphp
                                <div class="bg-white/5 border border-white/10 rounded-lg overflow-hidden module-item" data-module-index="{{ $moduleIndex }}">
                                    <!-- Module Header -->
                                    <button type="button"
                                            class="w-full flex items-center justify-between p-4 text-left module-header transition-all duration-300 hover:bg-white/5"
                                            onclick="toggleModule({{ $moduleIndex }})">
                                        <div class="flex items-center gap-3 flex-1">
                                            <svg class="w-5 h-5 text-[#E850FF] transform transition-transform duration-300 module-arrow {{ $moduleIndex === 0 ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                            <div class="text-left flex-1 min-w-0">
                                                <h3 class="font-semibold text-[#E2E8F0]">
                                                    {{ $module->title ?? 'মডিউল ' . ($moduleIndex + 1) }}
                                                </h3>
                                                @if($module->description)
                                                <p class="text-sm text-[#ABABAB] mt-2 mb-1 leading-relaxed break-words pr-4">{{ $module->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <span class="text-sm text-[#ABABAB] bg-white/10 px-3 py-1 rounded-full shrink-0">
                                            {{ $moduleLessons->count() }} লেসন
                                        </span>
                                    </button>

                                    <!-- Module Lessons -->
                                    <div class="module-content {{ $moduleIndex === 0 ? '' : 'hidden' }}" id="module-content-{{ $moduleIndex }}">
                                        @if($moduleLessons->count() > 0)
                                            <div class="p-4 pt-0 space-y-2">
                                                @foreach($moduleLessons as $lesson)
                                                    @php
                                                        $isFreePreview = $course->type === 'FREE' || ($lesson->is_free_preview ?? false);
                                                        $isEnrolled = auth()->check() && auth()->user()->enrollments()->where('course_id', $course->id)->exists();
                                                        $lessonVideoUrl = $lesson->video_url ?? '';
                                                    @endphp
                                                    <div class="flex items-center gap-3 p-3 rounded-lg bg-white/5 hover:bg-white/10 transition-all duration-300 lesson-item">
                                                        <!-- Lesson Icon -->
                                                        @if($lessonVideoUrl && $isFreePreview)
                                                            {{-- FREE PREVIDEO - CLICKABLE --}}
                                                            <button onclick="openVideoModal(
                                                                    {{ $lesson->id }},
                                                                    '{{ $lessonVideoUrl }}',
                                                                    '{{ addslashes($lesson->title ?? 'লেসন') }}',
                                                                    '{{ addslashes($lesson->description ?? '') }}',
                                                                    true
                                                                )"
                                                                    class="flex items-center gap-3 flex-1 group text-left w-full cursor-pointer">
                                                                <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center shrink-0">
                                                                    <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                                                        <path d="M8 5v14l11-7z"/>
                                                                    </svg>
                                                                </div>
                                                        @elseif($lessonVideoUrl && !$isFreePreview && !$isEnrolled)
                                                            {{-- PAID LESSON - LOCKED, NOT CLICKABLE --}}
                                                            <div class="flex items-center gap-3 flex-1 cursor-not-allowed">
                                                                <div class="w-8 h-8 rounded-full bg-[#E850FF]/20 flex items-center justify-center shrink-0">
                                                                    <svg class="w-4 h-4 text-[#E850FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                                    </svg>
                                                                </div>
                                                        @elseif($isEnrolled)
                                                            {{-- ENROLLED STUDENT - ALL LESSONS ACCESSIBLE --}}
                                                            @if($lessonVideoUrl)
                                                            <button onclick="openVideoModal(
                                                                        {{ $lesson->id }},
                                                                        '{{ $lessonVideoUrl }}',
                                                                        '{{ addslashes($lesson->title ?? 'লেসন') }}',
                                                                        '{{ addslashes($lesson->description ?? '') }}',
                                                                        true
                                                                    )"
                                                                    class="flex items-center gap-3 flex-1 group text-left w-full cursor-pointer">
                                                                    <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center shrink-0">
                                                                        <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                                                            <path d="M8 5v14l11-7z"/>
                                                                        </svg>
                                                                    </div>
                                                            @else
                                                            <div class="flex items-center gap-3 flex-1">
                                                                <div class="w-8 h-8 rounded-full bg-[#ABABAB]/20 flex items-center justify-center shrink-0">
                                                                    <svg class="w-4 h-4 text-[#ABABAB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.5a2 2 0 012 2v14a2 2 0 01-2 2z" />
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                        @else
                                                            {{-- NO VIDEO - NOT CLICKABLE --}}
                                                            <div class="flex items-center gap-3 flex-1 cursor-not-allowed">
                                                                <div class="w-8 h-8 rounded-full bg-[#ABABAB]/20 flex items-center justify-center shrink-0">
                                                                    <svg class="w-4 h-4 text-[#ABABAB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 01-1.7-7.27 6.5 6.5 0 017.27-1.7l.28.27h.79" />
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 21l4-4m0 0l-4 4m4-4h-4" />
                                                                    </svg>
                                                                </div>
                                                        @endif

                                                        <!-- Lesson Info -->
                                                        <div class="flex-1 min-w-0">
                                                            <h4 class="text-sm font-medium text-[#E2E8F0] truncate {{ ($lessonVideoUrl && ($isFreePreview || $isEnrolled)) ? 'group-hover:text-[#E850FF]' : '' }}">
                                                                {{ $lesson->title ?? 'লেসন' }}
                                                                @if($isFreePreview && $lessonVideoUrl)
                                                                    <span class="ml-2 text-xs bg-[#E850FF] px-2 py-0.5 rounded-full">ফ্রি প্রিভিউ</span>
                                                                @endif
                                                            </h4>
                                                            @if($lesson->description)
                                                            <p class="text-xs text-[#ABABAB] mt-1 leading-snug break-words line-clamp-2">{{ $lesson->description }}</p>
                                                            @endif
                                                        </div>

                                                        <!-- Duration -->
                                                        @if(isset($lesson->duration_in_minutes) && $lesson->duration_in_minutes)
                                                        <span class="text-xs text-[#ABABAB] shrink-0">
                                                            @if($lesson->duration_in_minutes >= 60)
                                                                {{ floor($lesson->duration_in_minutes / 60) }}ঘণ্টা {{ $lesson->duration_in_minutes % 60 }}মিনিট
                                                            @else
                                                                {{ $lesson->duration_in_minutes }}মিনিট
                                                            @endif
                                                        </span>
                                                        @endif

                                                        @if($lessonVideoUrl && ($isFreePreview || $isEnrolled))
                                                            </button>
                                                        @else
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="p-4 pt-4 text-center text-sm text-[#ABABAB]">
                                                এই মডিউলে কোনো লেসন নেই
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="bg-white/5 border border-white/10 rounded-lg p-6 text-center text-[#ABABAB]">
                                এখনো কোনো মডিউল যোগ করা হয়নি
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Requirements -->
                @if($course->requirements)
                <div class="mb-8">
                    <h2 class="font-semibold text-xl text-[#E2E8F0] mb-4">প্রয়োজনীয় যোগ্যতা</h2>
                    <div class="text-[#ABABAB]">
                        @php $requirements = explode("\n", $course->requirements); @endphp
                        <ul class="space-y-2">
                            @foreach($requirements as $requirement)
                            @if(trim($requirement))
                            <li class="flex items-start gap-2">
                                <span class="text-[#ABABAB]">•</span>
                                <span>{{ trim($requirement) }}</span>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <!-- Reviews -->
                <div class="mb-8">
                    <h2 class="font-semibold text-xl text-[#E2E8F0] mb-4">শিক্ষার্থীদের মতামত</h2>

                    @if(Auth::check() && $isEnrolled)
                        @if($userReview)
                            <!-- User's Existing Review -->
                            <div class="bg-white/5 border border-white/10 rounded-lg p-6 mb-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h3 class="font-semibold text-[#E2E8F0] mb-1">আপনার মতামত</h3>
                                        @if($userReview->status === 'pending')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                </svg>
                                                অনুমোদনের জন্য অপেক্ষারত
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                অনুমোদিত
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 mb-3">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="{{ $i <= $userReview->rating ? 'text-yellow-400' : 'text-gray-600' }} text-xl">★</span>
                                    @endfor
                                </div>

                                @if($userReview->comment)
                                <p class="text-[#ABABAB]">{{ $userReview->comment }}</p>
                                @endif
                            </div>
                        @else
                            <!-- Review Form -->
                            <div class="bg-white/5 border border-white/10 rounded-lg p-6 mb-6">
                                <h3 class="font-semibold text-[#E2E8F0] mb-4">আপনার মতামত দিন</h3>
                        <form id="review-form" class="space-y-4">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">

                            <!-- Rating -->
                            <div>
                                <label class="block text-sm font-medium text-[#E2E8F0] mb-2">রেটিং দিন</label>
                                <div class="flex items-center gap-2" id="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                    <button type="button"
                                            class="text-3xl star-btn transition-all duration-200 {{ $i <= 5 ? 'text-yellow-400' : 'text-gray-600' }}"
                                            data-rating="{{ $i }}"
                                            onclick="setRating({{ $i }})">
                                        ★
                                    </button>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="rating-input" value="5">
                            </div>

                            <!-- Comment -->
                            <div>
                                <label for="comment" class="block text-sm font-medium text-[#E2E8F0] mb-2">আপনার মতামত</label>
                                <textarea name="comment"
                                          id="comment"
                                          rows="4"
                                          placeholder="কোর্স সম্পর্কে আপনার অভিজ্ঞতা শেয়ার করুন..."
                                          class="w-full bg-[#131620] border border-white/20 rounded-lg px-4 py-3 text-white placeholder-[#ABABAB] focus:outline-none focus:border-[#E850FF] transition-all duration-300"></textarea>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                    class="bg-[#E850FF] hover:bg-[#4941C8] text-white font-semibold px-6 py-2.5 rounded-lg transition-all duration-300">
                                মতামত জমা দিন
                            </button>
                        </form>

                        <!-- Success/Error Message -->
                        <div id="review-message" class="hidden mt-4 p-4 rounded-lg"></div>
                            </div>
                        @endif
                    @endif

                    <!-- Existing Reviews -->
                    @if($course->reviews && $course->reviews->count() > 0)
                    <div class="space-y-4">
                        @foreach($course->reviews->take(5) as $review)
                        <div class="bg-white/5 border border-white/10 rounded-lg p-4">
                            <div class="flex items-center gap-3 mb-3">
                                @if($review->user && $review->user->avatar)
                                <img src="{{ $review->user->avatar }}" alt="{{ $review->user->name }}"
                                    class="w-10 h-10 rounded-full object-cover">
                                @else
                                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                                    <span class="text-[#ABABAB]">{{ substr($review->user->name ?? 'Anonymous', 0, 1) }}</span>
                                </div>
                                @endif
                                <div>
                                    <h4 class="font-medium text-[#E2E8F0]">{{ $review->user->name ?? 'Anonymous' }}</h4>
                                    <div class="flex items-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                        <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-600' }}">★</span>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            @if($review->comment)
                            <p class="text-[#ABABAB]">{{ $review->comment }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="bg-white/5 border border-white/10 rounded-lg p-6 text-center text-[#ABABAB]">
                        এখনো কোনো রিভিউ নেই
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-8">
                    <!-- Course Card -->
                    <div class="bg-white/5 border border-white/10 rounded-lg p-6 mb-6">
                        <!-- Course Thumbnail -->
                        <img src="{{ $course->thumbnail ?? asset('website-images/default-course-thumbnail.webp') }}"
                            alt="{{ $course->title }}"
                            class="w-full h-48 object-cover rounded-lg mb-4"
                            width="400" height="192"
                            loading="lazy">

                        <!-- Price -->
                        <div class="mb-4">
                            @if($course->type === 'FREE')
                            <span class="text-3xl font-bold text-[#E2E8F0]">ফ্রি</span>
                            @else
                            <div class="flex items-center gap-3">
                                <span class="text-3xl font-bold text-[#E2E8F0]">৳{{ number_format($course->price) }}</span>
                                @if($course->discount_price > 0)
                                <span class="text-xl text-[#ABABAB] line-through">৳{{ number_format($course->discount_price) }}</span>
                                @endif
                            </div>
                            @endif
                        </div>

                        <!-- Enroll Button -->
                        @if(Auth::check())
                            @if($isEnrolled)
                            <a href="{{ route('student.course', $course->id) }}"
                                class="block w-full bg-green-600 hover:bg-green-700 text-white font-semibold text-center py-3 px-6 rounded-lg mb-3 transition-all duration-300">
                                কোর্সে যান →
                            </a>
                            @elseif($hasPendingRequest)
                            <button disabled
                                class="block w-full bg-yellow-600/80 cursor-not-allowed text-white font-semibold text-center py-3 px-6 rounded-lg mb-3">
                                ⏳ রিকোয়েস্ট প্রক্রিয়াধীন
                            </button>
                            @else
                            <a href="{{ route('courses.enroll.page', $course->id) }}"
                                class="block w-full bg-gradient-to-r from-green-500 to-lime-500 hover:from-green-600 hover:to-lime-600 text-white font-semibold text-center py-3 px-6 rounded-lg mb-3 transition-all duration-300">
                                {{ $course->type === 'FREE' ? 'এনরোল করুন' : 'এনরোল করুন (পেমেন্ট)' }}
                            </a>
                            @endif
                        @else
                        <a href="javascript:void(0)" onclick="showLoginPopup()"
                            class="block w-full bg-gradient-to-r from-green-500 to-lime-500 hover:from-green-600 hover:to-lime-600 text-white font-semibold text-center py-3 px-6 rounded-lg mb-3 transition-all duration-300">
                            এনরোল করুন
                        </a>
                        @endif

                        <!-- Course Stats -->
                        <div class="space-y-3 text-sm text-[#ABABAB] border-t border-white/10 pt-4">
                            @if($hours > 0 || $minutes > 0)
                            <div class="flex items-center gap-3">
                                <span>⏰</span>
                                <span>সময়সীমা: {{ $hours > 0 ? $hours . ' ঘন্টা ' : '' }}{{ $minutes }} মিনিট</span>
                            </div>
                            @endif
                            @if($totalModules > 0)
                            <div class="flex items-center gap-3">
                                <span>📁</span>
                                <span>{{ $totalModules }}টি মডিউল</span>
                            </div>
                            @endif
                            @if($totalLessons > 0)
                            <div class="flex items-center gap-3">
                                <span>🎥</span>
                                <span>{{ $totalLessons }}টি ভিডিও</span>
                            </div>
                            @endif
                            <div class="flex items-center gap-3">
                                <span>♾️</span>
                                <span>লাইফটাইম এক্সেস</span>
                            </div>
                        </div>
                    </div>

                    <!-- Instructor Info -->
                    @if($course->instructor)
                    <div class="bg-white/5 border border-white/10 rounded-lg p-6">
                        <h3 class="font-semibold text-[#E2E8F0] mb-4">কোর্স ইন্সট্রাক্টর</h3>
                        <div class="flex items-center gap-4 mb-4">
                            @if($course->instructor->avatar)
                            <img src="{{ $course->instructor->avatar }}" alt="{{ $course->instructor->name }}"
                                class="w-16 h-16 rounded-full object-cover">
                            @else
                            <img src="{{ asset('website-images/user-avatar.webp') }}" alt="avatar"
                                class="w-16 h-16 rounded-full object-cover">
                            @endif
                            <div>
                                <h4 class="font-semibold text-[#E2E8F0]">{{ $course->instructor->name }}</h4>
                                @if($course->instructor->designation)
                                <p class="text-sm text-[#ABABAB]">{{ $course->instructor->designation }}</p>
                                @endif
                            </div>
                        </div>
                        @if($course->instructor->bio)
                        <p class="text-sm text-[#ABABAB]">{{ Str::limit($course->instructor->bio, 150) }}</p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

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
            <p class="text-[#ABABAB]">লেসন দেখতে আপনার অ্যাকাউন্টে লগইন করুন</p>
        </div>

        <div class="space-y-4">
            <a href="{{ route('login') }}"
               class="block w-full bg-[#E850FF] hover:bg-[#4941C8] text-white font-semibold text-center py-3 px-6 rounded-lg transition-all duration-300">
                লগইন করুন
            </a>
        </div>

        <p class="text-center text-sm text-[#ABABAB] mt-6">
            লগইন করার পর আপনি এই লেসন দেখতে পাবেন
        </p>
    </div>
</div>

@section('scripts')
<script>
    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Module Accordion Functionality
        window.toggleModule = function(moduleIndex) {
            const content = document.getElementById(`module-content-${moduleIndex}`);
            const arrow = document.querySelector(`.module-item[data-module-index="${moduleIndex}"] .module-arrow`);

            if (content && arrow) {
                if (content.classList.contains('hidden')) {
                    content.classList.remove('hidden');
                    arrow.classList.add('rotate-180');
                } else {
                    content.classList.add('hidden');
                    arrow.classList.remove('rotate-180');
                }
            }
        };

        // Login Popup Functions
        window.showLoginPopup = function() {
            const popup = document.getElementById('login-popup');
            if (popup) {
                popup.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        };

        window.hideLoginPopup = function() {
            const popup = document.getElementById('login-popup');
            if (popup) {
                popup.classList.add('hidden');
                document.body.style.overflow = '';
            }
        };

        // Close popup on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                window.hideLoginPopup();
            }
        });

        // Rating Stars Functionality
        let selectedRating = 5;

        window.setRating = function(rating) {
            selectedRating = rating;
            const ratingInput = document.getElementById('rating-input');
            if (ratingInput) {
                ratingInput.value = rating;
            }

            // Update star colors
            const stars = document.querySelectorAll('.star-btn');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('text-gray-600');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-600');
                }
            });
        };

        // Review Form Submission - Only if form exists
        const reviewForm = document.getElementById('review-form');
        if (reviewForm) {
            reviewForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const messageContainer = document.getElementById('review-message');

                // Disable submit button
                submitBtn.disabled = true;
                submitBtn.textContent = 'জমা হচ্ছে...';

                fetch('{{ route("student.courses.review", $course->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        rating: formData.get('rating'),
                        comment: formData.get('comment')
                    })
                })
                .then(response => response.json())
                .then(data => {
                    messageContainer.classList.remove('hidden');

                    if (data.success) {
                        messageContainer.className = 'mt-4 p-4 rounded-lg bg-green-500/20 border border-green-500/50';
                        messageContainer.innerHTML = `
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-green-400 font-medium">${data.message}</p>
                            </div>
                        `;

                        // Reset form
                        this.reset();
                        window.setRating(5);

                        // Reload page after 2 seconds to show new review
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    } else {
                        messageContainer.className = 'mt-4 p-4 rounded-lg bg-red-500/20 border border-red-500/50';
                        messageContainer.innerHTML = `
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-red-400 font-medium">${data.message || 'দুঃখিত, আপনার মতামত জমা দেওয়া যায়নি।'}</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (messageContainer) {
                        messageContainer.classList.remove('hidden');
                        messageContainer.className = 'mt-4 p-4 rounded-lg bg-red-500/20 border border-red-500/50';
                        messageContainer.innerHTML = `
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-red-400 font-medium">দুঃখিত, একটি ত্রুটি হয়েছে। অনুগ্রহ করে পরে আবার চেষ্টা করুন।</p>
                            </div>
                        `;
                    }
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'মতামত জমা দিন';
                });
            });
        }
    });
</script>

<!-- Video Modal -->
<div id="video-modal" class="fixed inset-0 z-[9999] hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" onclick="closeVideoModal()"></div>

    <!-- Modal Content -->
    <div class="relative z-10 flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-[#131620] rounded-2xl max-w-5xl w-full shadow-2xl border border-[#232323]">
            <!-- Close Button -->
            <button onclick="closeVideoModal()"
                    class="absolute -top-12 right-0 text-white hover:text-[#E850FF] transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Video Content -->
            <div id="modal-video-container" class="aspect-video w-full bg-black rounded-t-2xl overflow-hidden">
                <!-- Video iframe will be inserted here -->
            </div>

            <!-- Lesson Info -->
            <div class="p-6">
                <h3 id="modal-lesson-title" class="text-xl font-bold text-[#E2E8F0] mb-2"></h3>
                <p id="modal-lesson-description" class="text-sm text-[#ABABAB]"></p>

                <!-- Close button -->
                <button onclick="closeVideoModal()"
                        class="w-full mt-4 bg-white/10 hover:bg-white/20 text-white py-3 rounded-lg font-medium transition-colors">
                    বন্ধ করুন
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Video Modal Functions
function openVideoModal(lessonId, videoUrl, lessonTitle, lessonDescription) {
    const modal = document.getElementById('video-modal');
    const videoContainer = document.getElementById('modal-video-container');
    const titleEl = document.getElementById('modal-lesson-title');
    const descriptionEl = document.getElementById('modal-lesson-description');

    // Set lesson info
    titleEl.textContent = lessonTitle || 'লেসন';
    descriptionEl.textContent = lessonDescription || '';

    // Parse YouTube URL
    let videoId = '';
    if (videoUrl.includes('youtube.com/watch?v=')) {
        videoId = videoUrl.split('v=')[1].split('&')[0];
    } else if (videoUrl.includes('youtu.be/')) {
        videoId = videoUrl.split('youtu.be/')[1].split('?')[0];
    }

    // Embed YouTube video with autoplay
    videoContainer.innerHTML = '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/' + videoId + '?autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full"></iframe>';

    // Show modal
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeVideoModal() {
    const modal = document.getElementById('video-modal');
    const videoContainer = document.getElementById('modal-video-container');

    // Stop video by clearing the container
    videoContainer.innerHTML = '';

    // Hide modal
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal on Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeVideoModal();
    }
});
</script>

@endsection
