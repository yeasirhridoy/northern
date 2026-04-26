<?php

use function Livewire\Volt\{state};

state([
    'images' => [
        ['url' => '/images/gallery/1.png', 'title' => 'Academic Excellence', 'desc' => 'Our state-of-the-art campus architecture.'],
        ['url' => '/images/gallery/2.png', 'title' => 'Vibrant Student Life', 'desc' => 'Diversity and friendship in every corner.'],
        ['url' => '/images/gallery/3.png', 'title' => 'Innovation Hub', 'desc' => 'Empowering students with the latest technology.'],
        ['url' => '/images/gallery/4.png', 'title' => 'Knowledge Center', 'desc' => 'A peaceful environment for research and study.'],
        ['url' => '/images/gallery/5.png', 'title' => 'Hands-on Learning', 'desc' => 'Cutting-edge engineering laboratories.'],
        ['url' => '/images/gallery/6.png', 'title' => 'Champion Spirit', 'desc' => 'Excellence in sports and physical wellness.'],
        ['url' => '/images/gallery/7.png', 'title' => 'Inspiring Lectures', 'desc' => 'Learning from industry-leading experts.'],
        ['url' => '/images/gallery/8.png', 'title' => 'Campus Community', 'desc' => 'Modern social spaces for student interaction.'],
        ['url' => '/images/gallery/9.png', 'title' => 'Success Stories', 'desc' => 'Celebrating the achievement of our graduates.'],
        ['url' => '/images/gallery/10.png', 'title' => 'Northern Nights', 'desc' => 'A beautiful view of our campus after dark.'],
    ]
]);

?>

<div class="py-24 bg-white dark:bg-zinc-900 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12 text-center">
        <h2 class="text-4xl font-black text-zinc-900 dark:text-white mb-4 tracking-tight">Campus Life in Focus</h2>
        <p class="text-zinc-500 dark:text-zinc-400 max-w-2xl mx-auto text-lg">Take a glimpse into the vibrant environment, world-class facilities, and the inspiring community at Northern University.</p>
    </div>

    <!-- Swiper Container -->
    <div class="relative px-4">
        <div class="swiper campus-swiper !pb-16 !px-4">
            <div class="swiper-wrapper">
                @foreach($images as $image)
                    <div class="swiper-slide !w-[300px] sm:!w-[450px] group">
                        <div class="relative aspect-4/3 overflow-hidden rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-800 transition-all duration-500 group-hover:scale-[1.02]">
                            <img src="{{ $image['url'] }}" alt="{{ $image['title'] }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-500"></div>
                            
                            <div class="absolute bottom-0 left-0 p-6 w-full transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                                <h3 class="text-xl font-bold text-white mb-1">{{ $image['title'] }}</h3>
                                <p class="text-zinc-300 text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">{{ $image['desc'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="swiper-pagination !-bottom-2"></div>
            
            <!-- Navigation Arrows -->
            <div class="swiper-button-next !text-white/50 hover:!text-white after:!text-2xl transition-colors hidden sm:flex"></div>
            <div class="swiper-button-prev !text-white/50 hover:!text-white after:!text-2xl transition-colors hidden sm:flex"></div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <style>
            .campus-swiper .swiper-pagination-bullet {
                @apply bg-zinc-400 dark:bg-zinc-600 opacity-50 transition-all duration-300;
                width: 8px;
                height: 8px;
            }
            .campus-swiper .swiper-pagination-bullet-active {
                @apply bg-blue-600 opacity-100;
                width: 24px;
                border-radius: 4px;
            }
            .swiper-slide {
                transition: opacity 0.5s;
            }
            .swiper-slide:not(.swiper-slide-active) {
                opacity: 0.6;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script>
            document.addEventListener('livewire:init', () => {
                const swiper = new Swiper('.campus-swiper', {
                    effect: 'coverflow',
                    grabCursor: true,
                    centeredSlides: true,
                    slidesPerView: 'auto',
                    initialSlide: 2,
                    coverflowEffect: {
                        rotate: 5,
                        stretch: 0,
                        depth: 100,
                        modifier: 2,
                        slideShadows: false,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    autoplay: {
                        delay: 4000,
                        disableOnInteraction: false,
                    },
                    loop: true,
                });
            });
        </script>
    @endpush
</div>
