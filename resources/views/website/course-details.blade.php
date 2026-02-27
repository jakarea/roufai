@extends('layouts.website')

@section('title', $course->title . ' - আব্দুর রউফ - AI Creative Training Platform')
@section('description', Str::limit(strip_tags($course->description), 160))

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

                <!-- Course Modules -->
                <div class="mb-8">
                    <h2 class="font-semibold text-xl text-[#E2E8F0] mb-4">কোর্স কারিকুলাম</h2>
                    <div class="space-y-4">
                        @foreach($course->modules as $module)
                        <div class="bg-white/5 border border-white/10 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="font-semibold text-[#E2E8F0]">{{ $module->title }}</h3>
                                <span class="text-sm text-[#ABABAB]">{{ $module->lessons->count() }} লেসন</span>
                            </div>
                            @if($module->description)
                            <p class="text-sm text-[#ABABAB] mb-3">{{ $module->description }}</p>
                            @endif
                            <div class="space-y-2">
                                @foreach($module->lessons as $lesson)
                                <div class="flex items-center gap-3 text-sm text-[#ABABAB]">
                                    <span class="text-lg">🎥</span>
                                    <span>{{ $lesson->title }}</span>
                                    @if($lesson->duration_in_minutes)
                                    <span class="ml-auto text-xs">{{ gmdate('H:i', $lesson->duration_in_minutes * 60) }}</span>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
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
                @if($course->reviews->count() > 0)
                <div>
                    <h2 class="font-semibold text-xl text-[#E2E8F0] mb-4">শিক্ষার্থীদের মতামত</h2>
                    <div class="space-y-4">
                        @foreach($course->reviews->take(5) as $review)
                        <div class="bg-white/5 border border-white/10 rounded-lg p-4">
                            <div class="flex items-center gap-3 mb-3">
                                @if($review->user && $review->user->avatar)
                                <img src="{{ $review->user->avatar }}" alt="{{ $review->user->name }}"
                                    class="w-10 h-10 rounded-full object-cover">
                                @else
                                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                                    <span class="text-[#ABABAB]">{{ $review->user->name[0] ?? 'U' }}</span>
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
                </div>
                @endif
            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-8">
                    <!-- Course Card -->
                    <div class="bg-white/5 border border-white/10 rounded-lg p-6 mb-6">
                        <!-- Course Thumbnail -->
                        <img src="{{ $course->thumbnail ?? asset('website-images/default-course-thumbnail.webp') }}" alt="{{ $course->title }}"
                            class="w-full h-48 object-cover rounded-lg mb-4">

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
                                class="block w-full bg-green-600 hover:bg-green-700 text-white font-semibold text-center py-3 px-6 rounded-lg mb-3">
                                কোর্সে যান →
                            </a>
                            @else
                            <form action="{{ route('courses.enroll', $course->id) }}" method="POST" class="mb-3">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-green-500 to-lime-500 hover:from-green-600 hover:to-lime-600 text-white font-semibold py-3 px-6 rounded-lg">
                                    এনরোল করুন
                                </button>
                            </form>
                            @endif
                        @else
                        <a href="{{ route('login') }}"
                            class="block w-full bg-gradient-to-r from-green-500 to-lime-500 hover:from-green-600 hover:to-lime-600 text-white font-semibold text-center py-3 px-6 rounded-lg mb-3">
                            এনরোল করুন
                        </a>
                        @endif

                        <!-- Course Stats -->
                        <div class="space-y-3 text-sm text-[#ABABAB] border-t border-white/10 pt-4">
                            <div class="flex items-center gap-3">
                                <span>⏰</span>
                                <span>সময়সীমা: {{ $hours > 0 ? $hours . ' ঘন্টা ' : '' }}{{ $minutes }} মিনিট</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span>📁</span>
                                <span>{{ $course->modules->count() }}টি মডিউল</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span>🎥</span>
                                <span>{{ $course->modules->sum(function($m) { return $m->lessons->count(); }) }}টি ভিডিও</span>
                            </div>
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

<!-- Include Footer -->
@include('website.partials.footer')

@endsection
