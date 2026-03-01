<!-- footer section start -->
<footer class="w-full pt-10 lg:pt-20 pb-3 lg:pb-5">
    <div class="container-x">

        <div class="w-full grid grid-cols-2 lg:grid-cols-12 gap-y-10 gap-x-5 lg:gap-x-16 mb-5 lg:mb-10">
            <!-- card -->
            <div class="w-full lg:col-span-4">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('website-images/logo.svg') }}" alt="logo white" class="w-full max-w-[108px]">
                </a>
                <p class="text-[#ABABAB] font-normal text-base mt-5 mb-3 lg:mt-[30px] lg:mb-5">{!! $siteSettings->company_tagline ?? 'বাংলাদেশের শীর্ষ এআই ক্রিয়েটিভ ট্রেনিং প্ল্যাটফর্ম' !!}</p>

                <p class="text-[#ABABAB] mt-[20px] lg:mt-7 font-normal text-sm font-golos">আমাদের সাথে যুক্ত হন</p>

                <ul class="flex items-center justify-center gap-x-2.5 mt-2.5 lg:justify-start">
                    @if(!empty($siteSettings->contact_phone))
                    <li>
                        <a href="tel:{{ $siteSettings->formatted_phone }}" class="block w-[30px] h-[30px] rounded-full anim hover:opacity-80">
                            <img src="{{ asset('website-images/icons/call.svg') }}" alt="call" class="w-full">
                        </a>
                    </li>
                    @endif
                    @if(!empty($siteSettings->contact_email))
                    <li>
                        <a href="mailto:{{ $siteSettings->contact_email }}" class="block w-[30px] h-[30px] rounded-full anim hover:opacity-80">
                            <img src="{{ asset('website-images/icons/mail.svg') }}" alt="email" class="w-full">
                        </a>
                    </li>
                    @endif
                    @if(!empty($siteSettings->linkedin_url))
                    <li>
                        <a href="{{ $siteSettings->linkedin_url }}" target="_blank" class="block w-[30px] h-[30px] rounded-full anim hover:opacity-80">
                            <img src="{{ asset('website-images/icons/linkedin.svg') }}" alt="linkedin" class="w-full">
                        </a>
                    </li>
                    @endif
                    @if(!empty($siteSettings->facebook_url))
                    <li>
                        <a href="{{ $siteSettings->facebook_url }}" target="_blank" class="block w-[30px] h-[30px] rounded-full anim hover:opacity-80">
                            <img src="{{ asset('website-images/icons/facebook.svg') }}" alt="facebook" class="w-full">
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
            <!-- card -->
            <!-- card -->
            <div class="w-full lg:col-span-2">
                <h6 class="font-medium text-base lg:text-lg text-[#ABABAB]">কুইক লিঙ্কস</h6>
                <ul class="mt-5 lg:mt-[30px] flex flex-col gap-y-2 lg:gap-y-5">
                    <li><a href="{{ route('home') }}"
                            class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">হোম</a>
                    </li>
                    <li><a href="{{ route('courses') }}"
                            class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">কোর্স
                            সমূহ </a></li>
                    <li><a href="{{ !empty($siteSettings->about_us_url) ? $siteSettings->about_us_url : '#' }}"
                            class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">আমাদের
                            সম্পর্কে</a></li>
                    <li><a href="{{ route('terms') }}"
                            class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">শর্তাবলী</a></li>
                </ul>
            </div>
            <!-- card -->
            <!-- card -->
            <div class="w-full lg:col-span-3">
                <h6 class="font-medium text-base lg:text-lg text-[#ABABAB]">যোগাযোগ করুন</h6>
                <ul class="mt-5 lg:mt-[30px] flex flex-col gap-y-2 lg:gap-y-5">
                    @if(!empty($siteSettings->contact_address))
                    <li><a href="#"
                            class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">{!! $siteSettings->contact_address !!}</a>
                    </li>
                    @endif
                    @if(!empty($siteSettings->contact_phone))
                    <li><a href="tel:{{ $siteSettings->formatted_phone }}"
                            class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">{{ $siteSettings->contact_phone }}</a>
                    </li>
                    @endif
                    @if(!empty($siteSettings->contact_email))
                    <li><a href="mailto:{{ $siteSettings->contact_email }}"
                            class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">{{ $siteSettings->contact_email }}</a>
                    </li>
                    @endif
                </ul>
            </div>
            <!-- card -->
            <!-- card -->
            <div class="w-full lg:col-span-3">
                <h6 class="font-medium text-base lg:text-lg text-[#ABABAB]">শীর্ষ কোর্সসমূহ</h6>
                <ul class="mt-5 lg:mt-[30px] flex flex-col gap-y-2 lg:gap-y-5">
                    @if($topCourses->count() > 0)
                        @foreach($topCourses as $course)
                        <li>
                            <a href="{{ route('courses.overview', $course->slug) }}"
                               class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff] truncate"
                               title="{{ $course->title }}">
                                {{ $course->title }}
                            </a>
                        </li>
                        @endforeach
                    @else
                        <li><a href="#"
                                class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">AI
                                Creative Mastery</a></li>
                        <li><a href="#"
                                class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">Prompt
                                Engineering Pro</a></li>
                        <li><a href="#"
                                class="block font-medium text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">AI
                                Video & Content Lab</a></li>
                    @endif
                </ul>
            </div>
            <!-- card -->
        </div>

        <div
            class="w-full border-t border-[#232323] flex justify-center flex-col items-center lg:flex-row lg:justify-between lg:items-center gap-y-4 lg:gap-x-4 lg:gap-y-0 mt-3 pt-3 lg:mt-4 lg:pt-4">
            <p class="font-normal text-sm lg:text-base text-[#ABABAB]">&copy; {{ date('Y') }} {!! $siteSettings->copyright_text ?? 'Rouf AI - সর্বস্বত্ব সংরক্ষিত।' !!}</p>
            <p class="font-normal text-sm lg:text-base text-[#ABABAB]">{!! $siteSettings->developer_credit_text ?? 'Developed with ❤️ by Giopio' !!}</p>
        </div>
    </div>
</footer>
<!-- footer section end -->
