/**
 * Common JavaScript Functions
 * Reusable components across all pages
 */

(function() {
  'use strict';

  // =============================================
  // Mobile Menu Toggle
  // =============================================
  const initMobileMenu = function() {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    if (!mobileMenuToggle || !mobileMenu) return;

    mobileMenuToggle.addEventListener('click', function() {
      mobileMenu.classList.toggle('hidden');
    });
  };

  // =============================================
  // Search Overlay Toggle
  // =============================================
  const initSearchOverlay = function() {
    const searchToggle = document.getElementById('search-toggle');
    const searchOverlay = document.getElementById('search-overlay');
    const searchClose = document.getElementById('search-close');
    const searchInput = document.getElementById('search-input');

    if (!searchToggle || !searchOverlay || !searchClose) return;

    function openSearch() {
      searchOverlay.classList.remove('hidden');
      // Trigger reflow to enable transition
      searchOverlay.offsetHeight;
      searchOverlay.classList.remove('opacity-0');
      searchOverlay.classList.add('opacity-100');

      // Focus on input after animation
      if (searchInput) {
        setTimeout(() => searchInput.focus(), 300);
      }

      // Prevent body scroll
      document.body.style.overflow = 'hidden';
    }

    function closeSearch() {
      searchOverlay.classList.remove('opacity-100');
      searchOverlay.classList.add('opacity-0');
      setTimeout(() => {
        searchOverlay.classList.add('hidden');
      }, 300);
      // Restore body scroll
      document.body.style.overflow = '';
    }

    searchToggle.addEventListener('click', openSearch);
    searchClose.addEventListener('click', closeSearch);

    // Close on overlay click (outside search box)
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
  };

  // =============================================
  // FAQ Accordion
  // =============================================
  const initFAQ = function() {
    window.toggleFAQ = function(element) {
      const faqItems = document.querySelectorAll('.faq-item');
      const answer = element.querySelector('.faq-answer');
      const isCurrentlyActive = element.classList.contains('active');

      // Close all FAQ items first
      faqItems.forEach(item => {
        const itemAnswer = item.querySelector('.faq-answer');
        item.classList.remove('active');
        if (itemAnswer) itemAnswer.classList.remove('active');
      });

      // If the clicked item wasn't active, open it
      if (!isCurrentlyActive && answer) {
        element.classList.add('active');
        answer.classList.add('active');
      }
    };
  };

  // =============================================
  // Hero Slider
  // =============================================
  const initHeroSlider = function() {
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.slider-dot');
    const prevBtn = document.querySelector('.slider-prev');
    const nextBtn = document.querySelector('.slider-next');

    if (!slides.length) return;

    let currentSlide = 0;
    let slideInterval;

    function showSlide(index) {
      // Remove active class from all slides and dots
      slides.forEach(slide => {
        slide.classList.remove('active');
        slide.style.opacity = '0';
        slide.style.zIndex = '1';
      });

      dots.forEach(dot => {
        dot.classList.remove('active', 'bg-[#E850FF]');
        dot.classList.add('bg-[#fff]/30');
      });

      // Add active class to current slide and dot
      if (slides[index] && dots[index]) {
        slides[index].classList.add('active');
        slides[index].style.opacity = '1';
        slides[index].style.zIndex = '10';

        dots[index].classList.add('active', 'bg-[#E850FF]');
        dots[index].classList.remove('bg-[#fff]/30');
      }

      currentSlide = index;
    }

    function nextSlide() {
      let next = (currentSlide + 1) % slides.length;
      showSlide(next);
    }

    function prevSlide() {
      let prev = (currentSlide - 1 + slides.length) % slides.length;
      showSlide(prev);
    }

    function startAutoPlay() {
      slideInterval = setInterval(nextSlide, 5000);
    }

    function stopAutoPlay() {
      clearInterval(slideInterval);
    }

    // Event listeners for navigation buttons
    if (nextBtn) {
      nextBtn.addEventListener('click', function() {
        stopAutoPlay();
        nextSlide();
        startAutoPlay();
      });
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', function() {
        stopAutoPlay();
        prevSlide();
        startAutoPlay();
      });
    }

    // Event listeners for dots
    dots.forEach((dot, index) => {
      dot.addEventListener('click', function() {
        stopAutoPlay();
        showSlide(index);
        startAutoPlay();
      });
    });

    // Pause auto-play on hover
    const heroSlider = document.querySelector('.hero-slider');
    if (heroSlider) {
      heroSlider.addEventListener('mouseenter', stopAutoPlay);
      heroSlider.addEventListener('mouseleave', startAutoPlay);
    }

    // Initialize slider
    showSlide(0);
    startAutoPlay();
  };

  // =============================================
  // Initialize All Components
  // =============================================
  const init = function() {
    initMobileMenu();
    initSearchOverlay();
    initFAQ();
    initHeroSlider();
  };

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
