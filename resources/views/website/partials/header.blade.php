<!-- header section start -->
<header class="w-full pt-5 lg:pt-10 relative z-[9999]">
    <div class="container-x">
        <div class="w-full relative bg-[#000]/40 rounded-md p-2 lg:p-2.5 lg:rounded-[14px] lg:px-5">
            <div class="flex items-center justify-between gap-4">
                <!-- logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('website-images/logo.png') }}" alt="logo" class="max-w-20 md:max-w-[95px] lg:max-w-[110px]">
                    </a>
                </div>

                <!-- Navigation Menu - Same for mobile and desktop -->
                <nav class="flex-1 hidden lg:block" id="main-nav">
                    <ul class="flex items-center justify-center gap-x-[30px]">
                        <li>
                            <a href="{{ route('home') }}" class="block font-normal text-lg lg:text-xl text-[#ABABAB] anim hover:text-[#fff] {{ request()->routeIs('home') ? 'text-[#fff]' : '' }}">
                                হোম
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('courses') }}" class="block font-normal text-lg lg:text-xl text-[#ABABAB] anim hover:text-[#fff] {{ request()->routeIs('courses') ? 'text-[#fff]' : '' }}">
                                কোর্সসমূহ
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('expert.connection') }}" class="block font-normal text-lg lg:text-xl text-[#ABABAB] anim hover:text-[#fff] {{ request()->routeIs('expert.connection') ? 'text-[#fff]' : '' }}">
                                এক্সপার্ট কানেকশন
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('blog.index') }}" class="block font-normal text-lg lg:text-xl text-[#ABABAB] anim hover:text-[#fff] {{ request()->routeIs('blog.index') ? 'text-[#fff]' : '' }}">
                                AI আপডেট
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- Actions -->
                <div class="flex items-center gap-3">
                    {{-- Search Icon --}}
                    <button type="button" id="search-toggle" class="block text-[#ABABAB] hover:text-[#fff] anim cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 lg:w-6 lg:h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>

                    @auth
                        @if(auth()->user()->role === 'instructor')
                            <a href="{{ url('/instructor') }}" class="hidden md:block font-normal text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">
                                প্রশিক্ষক প্যানেল
                            </a>
                        @elseif(auth()->user()->role === 'student')
                            <a href="{{ route('student.dashboard') }}" class="hidden md:block font-normal text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">
                                ড্যাশবোর্ড
                            </a>
                        @elseif(auth()->user()->role === 'admin')
                            <a href="{{ url('/admin') }}" class="hidden md:block font-normal text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">
                                অ্যাডমিন প্যানেল
                            </a>
                        @endif
                    @else
                        <div class="hidden md:flex items-center gap-3">
                            <a href="{{ route('login') }}" class="font-normal text-sm lg:text-base text-[#ABABAB] anim hover:text-[#fff]">
                                লগইন
                            </a>
                            <a href="{{ route('register') }}" class="inline-flex font-golos justify-center items-center bg-submit rounded-md lg:rounded-[10px] p-1.5 font-medium text-sm text-[#fff] gap-x-2 anim hover:!bg-lime px-3 lg:text-base hover:text-primary group border border-[#9F93A7]/70">
                                রেজিস্টার
                            </a>
                        </div>
                    @endauth

                    {{-- Mobile Menu Toggle --}}
                    <button type="button" id="mobile-menu-toggle" class="lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-[#fff]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 4.5h16.5" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Menu (Dropdown) --}}
            <div class="lg:hidden hidden" id="mobile-menu-dropdown">
                <div class="mt-4 pt-4 border-t border-white/10">
                    <ul class="flex flex-col gap-y-3">
                        <li>
                            <a href="{{ route('home') }}" class="block font-normal text-base text-[#ABABAB] anim hover:text-[#fff] {{ request()->routeIs('home') ? 'text-[#fff]' : '' }}">
                                হোম
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('courses') }}" class="block font-normal text-base text-[#ABABAB] anim hover:text-[#fff] {{ request()->routeIs('courses') ? 'text-[#fff]' : '' }}">
                                কোর্সসমূহ
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('expert.connection') }}" class="block font-normal text-base text-[#ABABAB] anim hover:text-[#fff] {{ request()->routeIs('expert.connection') ? 'text-[#fff]' : '' }}">
                                এক্সপার্ট কানেকশন
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('blog.index') }}" class="block font-normal text-base text-[#ABABAB] anim hover:text-[#fff] {{ request()->routeIs('blog.index') ? 'text-[#fff]' : '' }}">
                                AI আপডেট
                            </a>
                        </li>
                        @auth
                            @if(auth()->user()->role === 'instructor')
                                <li class="pt-2 border-t border-white/10">
                                    <a href="{{ url('/instructor') }}" class="block font-normal text-base text-[#E850FF] anim hover:text-[#fff]">
                                        প্রশিক্ষক প্যানেল
                                    </a>
                                </li>
                            @elseif(auth()->user()->role === 'student')
                                <li class="pt-2 border-t border-white/10">
                                    <a href="{{ route('student.dashboard') }}" class="block font-normal text-base text-[#E850FF] anim hover:text-[#fff]">
                                        ড্যাশবোর্ড
                                    </a>
                                </li>
                            @elseif(auth()->user()->role === 'admin')
                                <li class="pt-2 border-t border-white/10">
                                    <a href="{{ url('/admin') }}" class="block font-normal text-base text-[#E850FF] anim hover:text-[#fff]">
                                        অ্যাডমিন প্যানেল
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="pt-2 border-t border-white/10 flex gap-3">
                                <a href="{{ route('login') }}" class="flex-1 inline-flex items-center justify-center bg-[#fff]/10 rounded-md p-2 font-medium text-sm text-[#ABABAB] anim hover:text-[#fff]">
                                    লগইন
                                </a>
                                <a href="{{ route('register') }}" class="flex-1 inline-flex items-center justify-center bg-submit rounded-md p-2 font-medium text-sm text-[#fff] gap-x-2 anim hover:!bg-lime">
                                    রেজিস্টার
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header section end -->

<!-- Search Overlay -->
<div id="search-overlay" class="fixed inset-0 w-full h-full bg-[#0A0C19]/70 backdrop-blur-md z-[99999] hidden opacity-0 transition-opacity duration-300">
    <div class="w-full h-full flex items-center justify-center p-4">
        <div class="w-full max-w-3xl">
            <!-- Close Button -->
            <div class="flex justify-end mb-8">
                <button type="button" id="search-close" class="text-[#fff] hover:text-[#E850FF] transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 lg:w-10 lg:h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Search Form -->
            <form action="{{ route('courses') }}" method="GET" class="w-full">
                <div class="relative">
                    <input
                        type="text"
                        name="search"
                        id="search-input"
                        placeholder="কোর্স খুঁজুন..."
                        class="w-full bg-[#131620] border-2 border-[#E850FF]/30 rounded-lg lg:rounded-2xl py-4 lg:py-6 px-6 lg:px-8 text-[#fff] text-lg lg:text-2xl placeholder-[#ABABAB] focus:outline-none focus:border-[#E850FF] transition-all duration-300"
                        autocomplete="off"
                    >
                    <button
                        type="submit"
                        class="absolute cursor-pointer right-4 lg:right-6 top-1/2 -translate-y-1/2 bg-[#E850FF] hover:bg-[#4941C8] text-[#fff] rounded-lg px-6 lg:px-8 py-2 lg:py-3 font-medium text-base lg:text-lg transition-all duration-300"
                    >
                        খুঁজুন
                    </button>
                </div>
            </form>

            <!-- Popular Searches -->
            <div class="mt-8 lg:mt-12">
                <p class="text-[#ABABAB] text-sm lg:text-base mb-4">জনপ্রিয় সার্চ:</p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('courses') }}?search=AI" class="px-4 py-2 bg-[#fff]/10 hover:bg-[#E850FF]/20 border border-[#fff]/20 hover:border-[#E850FF]/50 rounded-full text-[#fff] text-sm lg:text-base transition-all duration-300">
                        AI
                    </a>
                    <a href="{{ route('courses') }}?search=ভিডিও" class="px-4 py-2 bg-[#fff]/10 hover:bg-[#E850FF]/20 border border-[#fff]/20 hover:border-[#E850FF]/50 rounded-full text-[#fff] text-sm lg:text-base transition-all duration-300">
                        ভিডিও এডিটিং
                    </a>
                    <a href="{{ route('courses') }}?search=ইমেজ" class="px-4 py-2 bg-[#fff]/10 hover:bg-[#E850FF]/20 border border-[#fff]/20 hover:border-[#E850FF]/50 rounded-full text-[#fff] text-sm lg:text-base transition-all duration-300">
                        ইমেজ জেনারেশন
                    </a>
                    <a href="{{ route('courses') }}?search=মিউজিক" class="px-4 py-2 bg-[#fff]/10 hover:bg-[#E850FF]/20 border border-[#fff]/20 hover:border-[#E850FF]/50 rounded-full text-[#fff] text-sm lg:text-base transition-all duration-300">
                        মিউজিক
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    'use strict';

    // Mobile menu toggle
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuDropdown = document.getElementById('mobile-menu-dropdown');

    if (mobileMenuToggle && mobileMenuDropdown) {
        let isMenuOpen = false;

        mobileMenuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            isMenuOpen = !isMenuOpen;
            mobileMenuDropdown.classList.toggle('hidden', !isMenuOpen);
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (isMenuOpen && !mobileMenuDropdown.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                isMenuOpen = false;
                mobileMenuDropdown.classList.add('hidden');
            }
        });

        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isMenuOpen) {
                isMenuOpen = false;
                mobileMenuDropdown.classList.add('hidden');
            }
        });
    }

    // Search overlay
    const searchToggle = document.getElementById('search-toggle');
    const searchOverlay = document.getElementById('search-overlay');
    const searchClose = document.getElementById('search-close');
    const searchInput = document.getElementById('search-input');

    function openSearch() {
        if (!searchOverlay) return;
        searchOverlay.classList.remove('hidden');
        // Trigger reflow
        void searchOverlay.offsetWidth;
        searchOverlay.classList.remove('opacity-0');
        searchOverlay.classList.add('opacity-100');
        setTimeout(() => {
            if (searchInput) searchInput.focus();
        }, 300);
        document.body.style.overflow = 'hidden';
    }

    function closeSearch() {
        if (!searchOverlay) return;
        searchOverlay.classList.remove('opacity-100');
        searchOverlay.classList.add('opacity-0');
        setTimeout(() => {
            searchOverlay.classList.add('hidden');
        }, 300);
        document.body.style.overflow = '';
    }

    if (searchToggle) {
        searchToggle.addEventListener('click', openSearch);
    }

    if (searchClose) {
        searchClose.addEventListener('click', closeSearch);
    }

    if (searchOverlay) {
        // Close on overlay click
        searchOverlay.addEventListener('click', function(e) {
            if (e.target === searchOverlay) {
                closeSearch();
            }
        });

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !searchOverlay.classList.contains('hidden')) {
                closeSearch();
            }
        });
    }
})();
</script>
