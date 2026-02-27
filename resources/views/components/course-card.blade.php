@props(['course'])

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
            <img src="{{ $course->thumbnail_url ?? asset('website-images/default-course-thumbnail.webp') }}"
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
                    <img src="{{ asset('website-images/user-avatar.webp') }}" alt="avatar"
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
