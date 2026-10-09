@extends('layouts.app')

@section('title', 'Chestnut Travel - Authentic Local Travel & Northern Vietnam Adventures')
@section('meta_description', 'Chestnut Travel specializes in Ha Giang Loop motorbike tours, Sa Pa local trekking, Lan Ha Bay - Cat Ba cruises, Ninh Binh and all-inclusive Northern Vietnam combos.')

@section('content')

@php
    $heroBanners = option_json('hero_banners', []);
    if (empty($heroBanners) || !is_array($heroBanners)) {
        $heroBanners = [
            [
                'image' => 'banners/hero-1.jpg',
                'image_url' => null,
                'badge' => '#1 Authentic Local Travel in Northern Vietnam',
                'title' => 'Your companion on every',
                'title_highlight' => 'journey of discovery',
                'subtitle' => 'Let Chestnut Travel be your trusted travel companion — conquering every spectacular road in Vietnam with you.',
                'button_text' => 'Explore now',
                'button_link' => '#tours-section',
            ],
            [
                'image' => 'banners/hero-2.jpg',
                'image_url' => null,
                'badge' => 'Legendary Roads',
                'title' => 'Discover the wonders of',
                'title_highlight' => 'Ha Giang & Sa Pa',
                'subtitle' => 'Conquer Ma Pi Leng Pass, the Nho Que River and breathtaking rice terraces.',
                'button_text' => 'See hot tours',
                'button_link' => '#tours-section',
            ],
        ];
    }
@endphp

<!-- ============================================================== -->
<!-- HERO SECTION & SEARCH FILTER BAR (CAROUSEL & KEN BURNS ZOOM)   -->
<!-- ============================================================== -->
<section id="hero-section" class="relative min-h-[580px] lg:min-h-[660px] flex flex-col justify-center bg-gray-900 overflow-hidden select-none">
    
    <!-- Slides Container -->
    <div class="absolute inset-0 z-0">
        @foreach($heroBanners as $index => $banner)
            @php
                $bgImg = !empty($banner['image']) 
                    ? (str_starts_with($banner['image'], 'http') ? $banner['image'] : asset('storage/' . $banner['image']))
                    : (!empty($banner['image_url']) ? $banner['image_url'] : asset('storage/banners/hero-1.jpg'));
            @endphp
            <div class="hero-slide absolute inset-0 transition-opacity duration-1000 ease-in-out {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none' }}" 
                 data-slide-index="{{ $index }}" 
                 {{ $index === 0 ? 'data-active=true' : '' }}>
                <!-- Background Image with Ken Burns Zoom Effect -->
                <div class="absolute inset-0 overflow-hidden">
                    <img src="{{ $bgImg }}" 
                         alt="{{ $banner['title'] ?? 'Chestnut Travel' }}" 
                         class="hero-zoom-img w-full h-full object-cover object-center transform">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/45 to-black/35"></div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Navigation arrows -->
    @if(count($heroBanners) > 1)
        <button id="hero-prev-btn" 
                type="button"
                aria-label="Previous Banner" 
                class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 z-30 w-11 h-11 sm:w-13 sm:h-13 rounded-full bg-black/35 hover:bg-chestnut text-white backdrop-blur-md flex items-center justify-center transition-all duration-300 border border-white/20 shadow-xl hover:scale-110 active:scale-95 group focus:outline-none">
            <i class="fa-solid fa-chevron-left text-base sm:text-lg group-hover:-translate-x-0.5 transition-transform"></i>
        </button>
        <button id="hero-next-btn" 
                type="button"
                aria-label="Next Banner" 
                class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 z-30 w-11 h-11 sm:w-13 sm:h-13 rounded-full bg-black/35 hover:bg-chestnut text-white backdrop-blur-md flex items-center justify-center transition-all duration-300 border border-white/20 shadow-xl hover:scale-110 active:scale-95 group focus:outline-none">
            <i class="fa-solid fa-chevron-right text-base sm:text-lg group-hover:translate-x-0.5 transition-transform"></i>
        </button>
    @endif

    <!-- Hero Content (Text + Search Bar + Trust Badges) -->
    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 text-center text-white w-full">
        <!-- Dynamic Text per Slide -->
        <div class="relative min-h-[160px] sm:min-h-[180px] flex items-center justify-center mb-6">
            @foreach($heroBanners as $index => $banner)
                <div class="hero-text-slide transition-all duration-700 ease-in-out {{ $index === 0 ? 'opacity-100 translate-y-0 relative' : 'opacity-0 translate-y-4 absolute inset-x-0 pointer-events-none' }}" 
                     data-text-index="{{ $index }}">
                    <!-- Badge -->
                    @if(!empty($banner['badge']))
                        <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-md px-4 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider mb-4 border border-white/20">
                            <i class="fa-solid fa-certificate text-amber-400"></i>
                            <span>{{ $banner['badge'] }}</span>
                        </div>
                    @endif

                    <!-- Headline -->
                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight max-w-4xl mx-auto leading-tight sm:leading-none mb-3">
                        {{ $banner['title'] ?? '' }} 
                        @if(!empty($banner['title_highlight']))
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 via-amber-300 to-yellow-200">{{ $banner['title_highlight'] }}</span>
                        @endif
                    </h1>

                    <!-- Subtitle -->
                    @if(!empty($banner['subtitle']))
                        <p class="text-sm sm:text-lg text-gray-200 font-medium max-w-2xl mx-auto mb-4">
                            {{ $banner['subtitle'] }}
                        </p>
                    @endif

                    @if(!empty($banner['button_text']))
                        <div class="mb-2">
                            <a href="{{ $banner['button_link'] ?? '#tours-section' }}" 
                               class="inline-flex items-center gap-2 bg-[#28B5A4] hover:bg-[#209C8D] text-white px-5 py-2.5 rounded-xl font-bold text-xs uppercase shadow-lg shadow-[#28B5A4]/30 transition transform hover:-translate-y-0.5">
                                <span>{{ $banner['button_text'] }}</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- SEARCH FILTER BAR (WP Travel Engine Style) -->
        <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-2xl p-3 sm:p-4 text-gray-800 text-left">
            <form action="{{ route('home') }}#tours-section" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
                <!-- 1. Destination Filter -->
                <div class="sm:col-span-1 lg:col-span-3 relative border-b sm:border-b-0 sm:border-r border-gray-200 pb-2 sm:pb-0 sm:pr-3">
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-location-dot text-chestnut"></i>
                        <span>Destination</span>
                    </label>
                    <select name="destination" class="w-full text-sm font-semibold text-gray-800 bg-transparent focus:outline-none cursor-pointer">
                        <option value="">All destinations</option>
                        @foreach($destinations as $dest)
                            <option value="{{ $dest->slug }}" {{ request('destination') == $dest->slug ? 'selected' : '' }}>
                                {{ $dest->name }} ({{ $dest->tours_count }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 2. Activity Filter -->
                <div class="sm:col-span-1 lg:col-span-3 relative border-b sm:border-b-0 lg:border-r border-gray-200 pb-2 sm:pb-0 sm:pr-3">
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-person-biking text-chestnut"></i>
                        <span>Activity</span>
                    </label>
                    <select name="activity" class="w-full text-sm font-semibold text-gray-800 bg-transparent focus:outline-none cursor-pointer">
                        <option value="">All activities</option>
                        @foreach($activities as $act)
                            <option value="{{ $act->slug }}" {{ request('activity') == $act->slug ? 'selected' : '' }}>
                                {{ $act->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 3. Price Filter -->
                <div class="sm:col-span-1 lg:col-span-3 relative border-b sm:border-b-0 sm:border-r border-gray-200 pb-2 sm:pb-0 sm:pr-3">
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-tags text-chestnut"></i>
                        <span>Price</span>
                    </label>
                    <select name="price_range" class="w-full text-sm font-semibold text-gray-800 bg-transparent focus:outline-none cursor-pointer">
                        <option value="">Any price</option>
                        <option value="0-100" {{ request('price_range') == '0-100' ? 'selected' : '' }}>Under $100 (Budget)</option>
                        <option value="100-200" {{ request('price_range') == '100-200' ? 'selected' : '' }}>$100 - $200 (Popular)</option>
                        <option value="200-300" {{ request('price_range') == '200-300' ? 'selected' : '' }}>$200 - $300 (Premium)</option>
                        <option value="300+" {{ request('price_range') == '300+' ? 'selected' : '' }}>Over $300 (Long trips/VIP)</option>
                    </select>
                </div>

                <!-- 4. Keyword / Submit -->
                <div class="sm:col-span-1 lg:col-span-3 flex items-center gap-2">
                    <div class="flex-1 min-w-0">
                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-magnifying-glass text-chestnut"></i>
                            <span>Keyword</span>
                        </label>
                        <input type="text" name="s" value="{{ request('s') }}" placeholder="Tour name, location..." class="w-full text-xs font-semibold text-gray-800 bg-transparent focus:outline-none truncate">
                    </div>
                    <button type="submit" class="bg-[#28B5A4] hover:bg-[#209C8D] text-white px-5 py-3 rounded-xl font-bold text-xs uppercase shadow-md shadow-[#28B5A4]/30 transition transform active:scale-95 flex items-center gap-1.5 whitespace-nowrap self-end shrink-0 cursor-pointer">
                        <i class="fa-solid fa-search"></i>
                        <span>FIND TOURS</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Trust badges under search -->
        <div class="mt-8 flex flex-wrap justify-center items-center gap-6 text-xs text-gray-300">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-star text-amber-400"></i>
                <i class="fa-solid fa-star text-amber-400"></i>
                <i class="fa-solid fa-star text-amber-400"></i>
                <i class="fa-solid fa-star text-amber-400"></i>
                <i class="fa-solid fa-star text-amber-400"></i>
                <span class="font-bold text-white ml-1">{{ option('hero_trust_rating', '5.0 / 5.0') }}</span>
                <span>{{ option('hero_trust_text_1', '(500+ five-star Tripadvisor reviews)') }}</span>
            </div>
            <div class="hidden sm:block text-gray-500">•</div>
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-shield-heart text-emerald-400"></i>
                <span>{{ option('hero_trust_text_2', 'Insurance & caring local guides') }}</span>
            </div>
        </div>

        <!-- Carousel Indicators (Dots) -->
        @if(count($heroBanners) > 1)
            <div class="flex justify-center items-center gap-2 mt-6">
                @foreach($heroBanners as $idx => $b)
                    <button type="button" 
                            class="hero-dot h-2.5 rounded-full transition-all duration-300 {{ $idx === 0 ? 'w-8 bg-chestnut' : 'w-2.5 bg-white/40 hover:bg-white/70' }}" 
                            data-slide-target="{{ $idx }}" 
                            aria-label="Go to banner {{ $idx + 1 }}">
                    </button>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- ============================================================== -->
<!-- SECTION: TRAVELLERS' CHOICE & VALUE PILLARS                    -->
<!-- ============================================================== -->
@php
    $awardBadgeImg = option_image('award_badge_image', option('award_badge_image_url', asset('storage/badges/tcbr-2025.webp')));
    $awardBadgeTitle = option('award_badge_title', "Travellers' Choice Award");
    $awardBadgeText = option('award_badge_text', "Chestnut Travel is proud to have been voted a Tripadvisor Travellers' Choice 2025 winner by travelers from Vietnam and around the world!");
    $awardBadgeLink = option('award_badge_link', 'https://www.tripadvisor.com/Attraction_Review-g293924-d25178538-Reviews-Chestnut_Travel-Hanoi.html');

    $feat1Title = option('feature_1_title', 'Local Travel Experts');
    $feat1Desc = option('feature_1_desc', 'Our professional team knows the local culture inside out and is always ready to craft the perfect, most unique itinerary just for you.');

    $feat2Title = option('feature_2_title', 'Best Price Guaranteed');
    $feat2Desc = option('feature_2_desc', 'Transparent, all-inclusive pricing and a commitment to the best possible price for consistently high-quality service.');

    $feat3Title = option('feature_3_title', '24/7 Customer Support');
    $feat3Desc = option('feature_3_desc', 'Our customer care team is on hand 24/7 to support you and answer any questions before, during and after your trip.');
@endphp

<section class="py-14 sm:py-20 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Top Row: Travellers' Choice Badge & Announcement (Centered) -->
        <div class="flex flex-col items-center justify-center text-center pb-14 border-b border-gray-100 max-w-3xl mx-auto">
            <div class="flex-shrink-0 mb-4">
                @if($awardBadgeLink)
                    <a href="{{ $awardBadgeLink }}" target="_blank" rel="noopener noreferrer" class="inline-block transition hover:scale-105 duration-300">
                @endif
                    <img src="{{ $awardBadgeImg }}" 
                         alt="{{ $awardBadgeTitle }}" 
                         class="w-28 h-28 sm:w-36 sm:h-36 object-contain rounded-full shadow-sm hover:shadow-md transition mx-auto">
                @if($awardBadgeLink)
                    </a>
                @endif
            </div>
            <div class="text-center">
                <span class="inline-block text-xs uppercase font-extrabold text-[#00AA6C] tracking-widest mb-2">
                    {{ $awardBadgeTitle }}
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-gray-900 tracking-tight mb-3">
                    {{ $awardBadgeTitle }}
                </h2>
                <p class="text-sm sm:text-base text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    {{ $awardBadgeText }}
                </p>
            </div>
        </div>

        <!-- Bottom Row: 3 Value Pillars -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 sm:gap-12 pt-14 text-center">
            <!-- Pillar 1: Local Travel Experts -->
            <div class="flex flex-col items-center">
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2.5">
                    {{ $feat1Title }}
                </h3>
                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed max-w-sm">
                    {{ $feat1Desc }}
                </p>
            </div>

            <!-- Pillar 2: Best Price Guaranteed -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center mb-3.5 text-base font-black shadow-sm">
                    <span class="tracking-tighter font-mono">$=</span>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2.5">
                    {{ $feat2Title }}
                </h3>
                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed max-w-sm">
                    {{ $feat2Desc }}
                </p>
            </div>

            <!-- Pillar 3: 24/7 Customer Service -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center mb-3.5 text-base shadow-sm">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2.5">
                    {{ $feat3Title }}
                </h3>
                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed max-w-sm">
                    {{ $feat3Desc }}
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================== -->
<!-- SECTION 1: POPULAR TRIPS (EXPLORE POPULAR TRIPS)                -->
<!-- ============================================================== -->
<section id="tours-section" class="py-20 bg-gray-50/70 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header (Centered as requested) -->
        <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="text-chestnut font-extrabold text-xs uppercase tracking-widest block mb-2">{{ option('popular_trips_badge', 'Popular Trips') }}</span>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">{{ option('popular_trips_title', 'Explore our most loved tours.') }}</h2>
            <p class="text-sm sm:text-base text-gray-600 mt-3 leading-relaxed">
                {{ option('popular_trips_subtitle', 'Our most popular trips with carefully optimized itineraries and high-quality all-inclusive service.') }}
            </p>
            @php
                $hasActiveFilters = request()->anyFilled(['destination', 'activity', 'price_range', 'min_price', 'max_price', 's', 'sort']);
                $priceRangeLabel = match(request('price_range')) {
                    '0-100' => 'Under $100',
                    '100-200' => '$100 - $200',
                    '200-300' => '$200 - $300',
                    '300+' => 'Over $300',
                    default => null,
                };
                if (!$priceRangeLabel && (request()->filled('min_price') || request()->filled('max_price'))) {
                    $priceRangeLabel = '$' . (request('min_price') ?: '0') . ' - $' . (request('max_price') ?: '∞');
                }
            @endphp

            @if($hasActiveFilters)
                <div class="mt-5 flex flex-wrap items-center justify-center gap-2">
                    <span class="text-xs text-gray-500 font-medium">Filtered by:</span>
                    
                    @if(request()->filled('destination'))
                        @php $activeDest = $destinations->firstWhere('slug', request('destination')); @endphp
                        <a href="{{ route('home', request()->except('destination')) }}#tours-section" 
                           class="inline-flex items-center gap-1.5 bg-teal-50 text-teal-700 hover:bg-teal-100 border border-teal-200 text-xs px-3 py-1 rounded-full font-semibold transition group">
                            <i class="fa-solid fa-location-dot text-[10px] text-teal-600"></i>
                            <span>{{ $activeDest ? $activeDest->name : request('destination') }}</span>
                            <i class="fa-solid fa-xmark text-[10px] text-teal-400 group-hover:text-teal-700"></i>
                        </a>
                    @endif

                    @if(request()->filled('activity'))
                        @php $activeAct = $activities->firstWhere('slug', request('activity')); @endphp
                        <a href="{{ route('home', request()->except('activity')) }}#tours-section" 
                           class="inline-flex items-center gap-1.5 bg-orange-50 text-orange-700 hover:bg-orange-100 border border-orange-200 text-xs px-3 py-1 rounded-full font-semibold transition group">
                            <i class="fa-solid fa-person-biking text-[10px] text-orange-500"></i>
                            <span>{{ $activeAct ? $activeAct->name : request('activity') }}</span>
                            <i class="fa-solid fa-xmark text-[10px] text-orange-400 group-hover:text-orange-700"></i>
                        </a>
                    @endif

                    @if($priceRangeLabel)
                        <a href="{{ route('home', request()->except(['price_range', 'min_price', 'max_price'])) }}#tours-section" 
                           class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 text-xs px-3 py-1 rounded-full font-semibold transition group">
                            <i class="fa-solid fa-tags text-[10px] text-emerald-600"></i>
                            <span>Price: {{ $priceRangeLabel }}</span>
                            <i class="fa-solid fa-xmark text-[10px] text-emerald-400 group-hover:text-emerald-700"></i>
                        </a>
                    @endif

                    @if(request()->filled('s'))
                        <a href="{{ route('home', request()->except('s')) }}#tours-section" 
                           class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 border border-blue-200 text-xs px-3 py-1 rounded-full font-semibold transition group">
                            <i class="fa-solid fa-magnifying-glass text-[10px] text-blue-500"></i>
                            <span>"{{ request('s') }}"</span>
                            <i class="fa-solid fa-xmark text-[10px] text-blue-400 group-hover:text-blue-700"></i>
                        </a>
                    @endif

                    <a href="{{ route('home') }}#tours-section" class="text-xs bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-1 rounded-full font-semibold transition flex items-center gap-1">
                        <i class="fa-solid fa-rotate-left text-[10px]"></i> Clear all
                    </a>
                </div>
            @endif
        </div>

        <!-- Quick Filter Pills: Price ranges & Sorting -->
        <div class="flex flex-wrap items-center justify-between gap-3 mb-8 pb-4 border-b border-gray-200/60">
            <!-- Price Range Quick Pills -->
            <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mr-1 hidden sm:inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-tags text-[#28B5A4]"></i> Price:
                </span>
                <a href="{{ route('home', array_merge(request()->except(['price_range', 'min_price', 'max_price']), [])) }}#tours-section" 
                   class="px-3 sm:px-3.5 py-1.5 rounded-full text-xs font-bold transition-all {{ !request()->filled('price_range') ? 'bg-[#28B5A4] text-white shadow-sm shadow-[#28B5A4]/20' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                    All
                </a>
                <a href="{{ route('home', array_merge(request()->except(['price_range', 'min_price', 'max_price']), ['price_range' => '0-100'])) }}#tours-section" 
                   class="px-3 sm:px-3.5 py-1.5 rounded-full text-xs font-bold transition-all {{ request('price_range') == '0-100' ? 'bg-[#28B5A4] text-white shadow-sm shadow-[#28B5A4]/20' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                    Under $100
                </a>
                <a href="{{ route('home', array_merge(request()->except(['price_range', 'min_price', 'max_price']), ['price_range' => '100-200'])) }}#tours-section" 
                   class="px-3 sm:px-3.5 py-1.5 rounded-full text-xs font-bold transition-all {{ request('price_range') == '100-200' ? 'bg-[#28B5A4] text-white shadow-sm shadow-[#28B5A4]/20' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                    $100 - $200
                </a>
                <a href="{{ route('home', array_merge(request()->except(['price_range', 'min_price', 'max_price']), ['price_range' => '200-300'])) }}#tours-section" 
                   class="px-3 sm:px-3.5 py-1.5 rounded-full text-xs font-bold transition-all {{ request('price_range') == '200-300' ? 'bg-[#28B5A4] text-white shadow-sm shadow-[#28B5A4]/20' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                    $200 - $300
                </a>
                <a href="{{ route('home', array_merge(request()->except(['price_range', 'min_price', 'max_price']), ['price_range' => '300+'])) }}#tours-section" 
                   class="px-3 sm:px-3.5 py-1.5 rounded-full text-xs font-bold transition-all {{ request('price_range') == '300+' ? 'bg-[#28B5A4] text-white shadow-sm shadow-[#28B5A4]/20' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                    Over $300
                </a>
            </div>

            <!-- Sort By Selector -->
            <div class="flex items-center gap-2 ml-auto">
                <span class="text-xs text-gray-400 font-medium hidden md:inline">Sort by:</span>
                <form action="{{ route('home') }}#tours-section" method="GET" id="sort-form">
                    @foreach(request()->except('sort') as $k => $v)
                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                    @endforeach
                    <select name="sort" onchange="document.getElementById('sort-form').submit()" class="text-xs font-bold text-gray-700 bg-white border border-gray-200 rounded-xl px-3 py-1.5 focus:outline-none focus:border-[#28B5A4] cursor-pointer shadow-xs">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest</option>
                        <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Price: Low to high</option>
                        <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Price: High to low</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Top rated</option>
                    </select>
                </form>
            </div>
        </div>

        @php
            $tourPages = $allTours->chunk(9);
            $totalPages = $tourPages->count();
        @endphp

        @if($allTours->isEmpty())
            <div class="col-span-3 text-center py-16 bg-white rounded-2xl border border-gray-200">
                <i class="fa-solid fa-compass text-4xl text-gray-300 mb-3"></i>
                <h4 class="text-base font-bold text-gray-700">No matching tours found</h4>
                <p class="text-xs text-gray-500 mt-1 mb-4">Try a different keyword or destination.</p>
                <a href="{{ route('home') }}#tours-section" class="inline-block bg-chestnut text-white text-xs font-bold px-4 py-2 rounded-lg">View all tours</a>
            </div>
        @else
            <!-- Tours Slider Container (3 rows of 3 cols = 9 tours per page) -->
            <div class="relative overflow-hidden" id="popular-trips-slider-container">
                <div id="popular-trips-track" class="flex transition-transform duration-700 ease-out" style="transform: translateX(0%);">
                    @foreach($tourPages as $pageIdx => $pageTours)
                        <div class="w-full flex-shrink-0" style="flex: 0 0 100%;">
                            <!-- 9 tours in 3 rows -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                @foreach($pageTours as $tour)
                                    <x-tour-card :tour="$tour" />
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Pagination & Navigation Controls (Only if > 9 tours / > 1 page) -->
            @if($totalPages > 1)
                <div class="mt-12 flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-gray-200/80">
                    <!-- Page Indicator & Auto-slide timer note -->
                    <div class="flex items-center gap-3">
                        <span class="text-xs sm:text-sm font-black text-gray-900 bg-white px-3.5 py-1.5 rounded-xl border border-gray-200 shadow-sm">
                            Page <span id="popular-current-num">1</span> / {{ $totalPages }}
                        </span>
                        <!-- <span class="text-xs text-gray-500 font-medium hidden sm:inline-flex items-center gap-1.5 bg-orange-50/80 text-orange-700 px-3 py-1 rounded-lg border border-orange-100">
                            <i class="fa-solid fa-clock-rotate-left text-[10px]"></i>
                            <span>Auto-advances every 10s</span>
                        </span> -->
                    </div>

                    <!-- Dots indicator -->
                    <div id="popular-page-dots" class="flex items-center gap-2">
                        @for($p = 0; $p < $totalPages; $p++)
                            <button type="button" 
                                    onclick="goToPopularPage({{ $p }})" 
                                    class="popular-dot transition-all duration-300 rounded-full cursor-pointer {{ $p === 0 ? 'w-8 h-2.5 bg-[#28B5A4]' : 'w-2.5 h-2.5 bg-gray-300 hover:bg-gray-400' }}" 
                                    aria-label="Page {{ $p + 1 }}"></button>
                        @endfor
                    </div>

                    <!-- Next & Prev Navigation Buttons -->
                    <div class="flex items-center gap-2">
                        <button type="button" 
                                id="popular-prev-btn" 
                                onclick="prevPopularPage()" 
                                class="w-10 h-10 rounded-xl bg-white hover:bg-gray-100 text-gray-700 hover:text-gray-900 border border-gray-200 shadow-sm flex items-center justify-center transition active:scale-95 cursor-pointer" 
                                aria-label="Previous page" 
                                title="Previous page">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </button>
                        <button type="button" 
                                id="popular-next-btn" 
                                onclick="nextPopularPage()" 
                                class="inline-flex items-center gap-2 bg-[#28B5A4] hover:bg-[#209C8D] text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-md shadow-[#28B5A4]/20 transition active:scale-95 cursor-pointer" 
                                aria-label="Next page" 
                                title="Next page">
                            <!-- <span>Next</span> -->
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </button>
                    </div>
                </div>
            @endif
        @endif
    </div>
</section>

<!-- ============================================================== -->
<!-- SECTION 2: POPULAR DESTINATIONS                                -->
<!-- ============================================================== -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-chestnut font-extrabold text-xs uppercase tracking-widest block mb-2">{{ option('destinations_badge', 'Popular Destination') }}</span>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">{{ option('destinations_title', 'Explore popular destination.') }}</h2>
            <p class="text-sm text-gray-600 mt-2">
                {{ option('destinations_subtitle', 'From the legendary bends of Ma Pi Leng to the emerald islands of Lan Ha Bay — discover the most beautiful places in Vietnam.') }}
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($destinations as $dest)
                <a href="{{ route('home') }}?destination={{ $dest->slug }}#tours-section" 
                   class="relative rounded-2xl overflow-hidden h-72 group block shadow-md hover:shadow-xl transition-all duration-300">
                    <img src="{{ $dest->image_url }}" 
                         alt="{{ $dest->name }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent"></div>
                    
                    <div class="absolute bottom-5 left-5 right-5 text-white">
                        <span class="text-[11px] font-bold text-amber-300 uppercase tracking-wider block mb-1">
                            {{ $dest->tours_count }} {{ Str::plural('Trip', $dest->tours_count) }} to explore
                        </span>
                        <h3 class="text-xl font-extrabold group-hover:text-amber-300 transition">{{ $dest->name }}</h3>
                        <p class="text-xs text-gray-300 line-clamp-2 mt-1 font-light leading-relaxed">
                            {{ strip_tags($dest->description) }}
                        </p>
                    </div>

                    <div class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white group-hover:bg-chestnut transition">
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- ============================================================== -->
<!-- SECTION 3: POPULAR ACTIVITIES (CHESTNUT TRAVEL OFFICIAL STYLE)  -->
<!-- ============================================================== -->
<section id="activities-section" class="py-20 bg-[#FBFBFA] border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header (Exact match to chestnuttravel.net) -->
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="font-serif-display italic text-[#28B5A4] text-xl sm:text-2xl block mb-1 font-semibold">
                {{ option('activities_badge', 'Popular Activities') }}
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight">
                {{ option('activities_title', 'Explore by activities.') }}
            </h2>
            <p class="text-sm sm:text-base text-gray-600 mt-2 font-medium">
                {{ option('activities_subtitle', 'Wide range of activities to involved in.') }}
            </p>
            <div class="flex justify-center mt-3">
                <svg width="48" height="10" viewBox="0 0 48 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 5L6 2L10 8L14 2L18 8L22 2L26 8L30 2L34 8L38 2L42 8L46 5" stroke="#28B5A4" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>

        <!-- Photo Cards Grid (3 Columns, matching Image 2) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @foreach($activities as $act)
                <a href="{{ route('activities.show', $act->slug) }}" 
                   class="group relative block rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-500 aspect-[16/10] bg-gray-900">
                    <!-- Background Photo -->
                    <img src="{{ $act->image_url }}" 
                         alt="{{ $act->name }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                    
                    <!-- Bottom Dark Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/25 to-transparent pointer-events-none"></div>

                    <!-- Bottom Title, Count & Orange Arrow -->
                    <div class="absolute bottom-4 left-5 right-5 sm:bottom-5 sm:left-6 sm:right-6 flex items-center justify-between text-white pointer-events-none">
                        <div class="flex items-baseline flex-wrap gap-2">
                            <h3 class="font-extrabold text-lg sm:text-xl text-white group-hover:text-[#28B5A4] transition-colors drop-shadow">
                                {{ $act->name }}
                            </h3>
                            <span class="text-xs sm:text-sm text-gray-300 font-medium">
                                ({{ $act->tours_count ?? count($act->tours) }} Trips)
                            </span>
                        </div>

                        <div class="w-8 h-8 rounded-full bg-black/20 group-hover:bg-[#28B5A4] flex items-center justify-center transition-all duration-300 transform group-hover:translate-x-1 shrink-0">
                            <i class="fa-solid fa-arrow-right text-[#E48E45] group-hover:text-white text-xs sm:text-sm transition-colors"></i>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- ============================================================== -->
<!-- SECTION 4: STATS BANNER (DYNAMIC NUMBER COUNTERS)              -->
<!-- ============================================================== -->
<section id="stats-section" class="py-16 bg-[#FEFAF6] border-y border-orange-100/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div class="space-y-1">
                <div class="text-3xl sm:text-5xl font-black text-chestnut tracking-tight counter-num"
                     data-target="{{ option('stat_1_number', '10000') }}" data-suffix="{{ option('stat_1_suffix', '+') }}" data-comma="{{ intval(option('stat_1_number', '10000')) >= 1000 ? 'true' : 'false' }}">0{{ option('stat_1_suffix', '+') }}</div>
                <div class="text-xs uppercase font-bold text-gray-700 tracking-wider">{{ option('stat_1_label', 'Happy travelers') }}</div>
            </div>
            <div class="space-y-1">
                <div class="text-3xl sm:text-5xl font-black text-chestnut tracking-tight counter-num"
                     data-target="{{ option('stat_2_number', '500') }}" data-suffix="{{ option('stat_2_suffix', '+') }}" data-comma="{{ intval(option('stat_2_number', '500')) >= 1000 ? 'true' : 'false' }}">0{{ option('stat_2_suffix', '+') }}</div>
                <div class="text-xs uppercase font-bold text-gray-700 tracking-wider">{{ option('stat_2_label', 'Successful trips') }}</div>
            </div>
            <div class="space-y-1">
                <div class="text-3xl sm:text-5xl font-black text-chestnut tracking-tight counter-num"
                     data-target="{{ option('stat_3_number', '100') }}" data-suffix="{{ option('stat_3_suffix', '%') }}" data-comma="{{ intval(option('stat_3_number', '100')) >= 1000 ? 'true' : 'false' }}">0{{ option('stat_3_suffix', '%') }}</div>
                <div class="text-xs uppercase font-bold text-gray-700 tracking-wider">{{ option('stat_3_label', 'Genuine 5-star reviews') }}</div>
            </div>
            <div class="space-y-1">
                <div class="text-3xl sm:text-5xl font-black text-chestnut tracking-tight counter-num"
                     data-target="{{ option('stat_4_number', '24') }}" data-suffix="{{ option('stat_4_suffix', '/7') }}" data-comma="{{ intval(option('stat_4_number', '24')) >= 1000 ? 'true' : 'false' }}">0{{ option('stat_4_suffix', '/7') }}</div>
                <div class="text-xs uppercase font-bold text-gray-700 tracking-wider">{{ option('stat_4_label', 'Dedicated customer support') }}</div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================== -->
<!-- SECTION 5: CLIENT TESTIMONIALS (CHESTNUT TRAVEL OFFICIAL STYLE)-->
<!-- ============================================================== -->
<section id="reviews-section" class="py-20 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header (Exact match to chestnuttravel.net) -->
        <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="font-serif-display italic text-[#28B5A4] text-xl sm:text-2xl block mb-1 font-semibold">
                {{ option('testimonials_badge', 'Testimonials') }}
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight">
                {{ option('testimonials_title', 'Client testimonials') }}
            </h2>
            <p class="text-sm sm:text-base text-gray-600 mt-2 font-medium">
                {{ option('testimonials_subtitle', 'Real travelers. Real stories. Real opinions to help you make the right choice.') }}
            </p>
            <div class="flex justify-center mt-3">
                <svg width="48" height="10" viewBox="0 0 48 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 5L6 2L10 8L14 2L18 8L22 2L26 8L30 2L34 8L38 2L42 8L46 5" stroke="#28B5A4" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>

        <!-- MAIN FEATURE TESTIMONIAL CAROUSEL (Dynamic from DB) -->
        <div class="relative max-w-5xl mx-auto px-3 sm:px-14">
            <!-- Left Circular Arrow Button -->
            <button type="button" 
                    id="feat-test-prev" 
                    class="absolute top-1/2 -translate-y-1/2 left-0 sm:-left-3 lg:-left-6 w-11 h-11 sm:w-12 sm:h-12 rounded-full border-2 border-[#28B5A4] text-[#28B5A4] hover:bg-[#28B5A4] hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm active:scale-90 cursor-pointer z-20 bg-white" 
                    aria-label="Previous Testimonial">
                <i class="fa-solid fa-arrow-left text-sm sm:text-base"></i>
            </button>

            <!-- Right Circular Arrow Button -->
            <button type="button" 
                    id="feat-test-next" 
                    class="absolute top-1/2 -translate-y-1/2 right-0 sm:-right-3 lg:-right-6 w-11 h-11 sm:w-12 sm:h-12 rounded-full border-2 border-[#28B5A4] text-[#28B5A4] hover:bg-[#28B5A4] hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm active:scale-90 cursor-pointer z-20 bg-white" 
                    aria-label="Next Testimonial">
                <i class="fa-solid fa-arrow-right text-sm sm:text-base"></i>
            </button>

            <!-- Carousel Slider Container -->
            <div id="feat-test-carousel" class="overflow-hidden rounded-3xl">
                <div id="feat-test-track" class="flex transition-transform duration-500 ease-in-out">
                    @forelse($testimonials as $idx => $testi)
                        <div class="w-full shrink-0 px-2 sm:px-6">
                            <div class="flex flex-col md:flex-row items-center gap-8 lg:gap-14 bg-white py-4">
                                <!-- Left Photo -->
                                <div class="w-full md:w-5/12 max-w-[280px] sm:max-w-[320px] aspect-[4/5] rounded-3xl overflow-hidden shadow-md shrink-0 bg-gray-100">
                                    <img src="{{ $testi->avatar_url }}" 
                                         alt="{{ $testi->author_name }}" 
                                         class="w-full h-full object-cover">
                                </div>

                                <!-- Right Content -->
                                <div class="md:w-7/12 text-left space-y-4">
                                    <div class="text-[#28B5A4] text-4xl sm:text-5xl font-serif font-black leading-none select-none">“</div>
                                    <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                                        {{ $testi->title ?? 'An amazing travel experience' }}
                                    </h3>
                                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed font-normal">
                                        {{ $testi->comment }}
                                    </p>
                                    <div class="pt-2 border-t border-gray-100">
                                        <h5 class="font-extrabold text-sm sm:text-base text-gray-900">{{ $testi->author_name }}</h5>
                                        <span class="text-xs text-gray-400 font-medium">{{ $testi->author_location ?? 'Traveler' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="w-full shrink-0 px-2 sm:px-6 text-center py-12">
                            <p class="text-gray-400">No approved reviews yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Dots indicator for Main Feature Carousel -->
            @if(count($testimonials) > 1)
                <div id="feat-test-dots" class="flex justify-center items-center gap-2 mt-6">
                    @foreach($testimonials as $idx => $testi)
                        <button type="button" 
                                onclick="goToFeatSlide({{ $idx }})" 
                                class="feat-dot {{ $idx === 0 ? 'w-8 h-2 rounded-full bg-[#28B5A4]' : 'w-2 h-2 rounded-full bg-gray-300 hover:bg-gray-400' }} transition-all cursor-pointer" 
                                aria-label="Slide {{ $idx + 1 }}"></button>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</section>

<!-- ============================================================== -->
<!-- SECTION 6: BLOG & TIPS (CHESTNUT TRAVEL OFFICIAL STYLE)       -->
<!-- ============================================================== -->
<section id="blog-section" class="py-20 bg-[#FAF7F2] border-y border-stone-200/70">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header (Exact match to chestnuttravel.net) -->
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="font-serif-display italic text-[#28B5A4] text-xl sm:text-2xl block mb-1 font-semibold">
                {{ option('blog_badge', 'Blog & Tips') }}
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight">
                {{ option('blog_title', 'Travel tips and blog') }}
            </h2>
            <p class="text-sm sm:text-base text-gray-600 mt-2 font-medium">
                {{ option('blog_subtitle', 'Latest travel tips and blog covering all travel experiences.') }}
            </p>
            <div class="flex justify-center mt-3">
                <svg width="48" height="10" viewBox="0 0 48 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 5L6 2L10 8L14 2L18 8L22 2L26 8L30 2L34 8L38 2L42 8L46 5" stroke="#28B5A4" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>

        <!-- 3-Column Blog Grid (Exact layout from chestnuttravel.net meafe-blog layout-2) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($latestPosts ?? [] as $post)
                <article class="bg-white rounded-3xl overflow-hidden shadow-xs hover:shadow-xl transition-all duration-300 border border-gray-200/80 flex flex-col group">
                    <!-- Media / Thumbnail -->
                    <div class="relative aspect-[16/10] overflow-hidden bg-gray-100">
                        <a href="{{ route('blog.show', $post->slug) }}" class="block w-full h-full">
                            <img src="{{ $post->image_url }}" 
                                 alt="{{ $post->title }}" 
                                 loading="lazy" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                        </a>
                        <div class="absolute top-3.5 left-3.5">
                            <span class="bg-[#28B5A4] text-white text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                                {{ $post->category ?? 'Travel Guide' }}
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <!-- Meta: Author & Date -->
                            <div class="flex items-center gap-2 text-xs text-gray-400 font-medium mb-2.5">
                                <span class="text-gray-600 font-semibold flex items-center gap-1">
                                    <i class="fa-regular fa-user text-[11px] text-[#28B5A4]"></i>
                                    {{ $post->author_name ?? 'admin' }}
                                </span>
                                <span>•</span>
                                <time datetime="{{ $post->published_at ? $post->published_at->toDateString() : '' }}">
                                    {{ $post->formatted_date }}
                                </time>
                            </div>

                            <!-- Title -->
                            <h3 class="text-lg sm:text-xl font-extrabold text-gray-900 group-hover:text-[#28B5A4] transition-colors leading-snug line-clamp-2 mb-3">
                                <a href="{{ route('blog.show', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h3>

                            <!-- Excerpt -->
                            <p class="text-xs sm:text-sm text-gray-600 line-clamp-3 leading-relaxed font-normal mb-5">
                                {{ $post->excerpt }}
                            </p>
                        </div>

                        <!-- Read More Button -->
                        <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                            <a href="{{ route('blog.show', $post->slug) }}" 
                               class="inline-flex items-center gap-2 text-xs font-extrabold text-gray-900 group-hover:text-[#28B5A4] uppercase tracking-wider transition-colors">
                                <span>READ MORE</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 11.249 7.741" class="transform group-hover:translate-x-1 transition-transform fill-current">
                                    <path d="M11.1,45.417,7.748,42.069a.523.523,0,0,0-.74.74l2.455,2.455H.523a.523.523,0,0,0,0,1.046h8.94L7.008,48.764a.523.523,0,0,0,.74.74L11.1,46.156A.523.523,0,0,0,11.1,45.417Z" transform="translate(0 -41.916)"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-12 text-gray-400">
                    No articles have been published yet.
                </div>
            @endforelse
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('blog.index') }}" 
               class="inline-flex items-center gap-2 border-2 border-[#28B5A4] text-[#28B5A4] hover:bg-[#28B5A4] hover:text-white px-7 py-3 rounded-full text-xs font-bold transition-all duration-300 shadow-xs">
                <span>View all articles</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>
    </div>
</section>


<style>
/* Smooth Ken Burns Zoom-in Animation for Hero Banner */
@keyframes heroKenBurns {
    0% {
        transform: scale(1.0);
    }
    100% {
        transform: scale(1.12);
    }
}

.hero-slide[data-active="true"] .hero-zoom-img {
    animation: heroKenBurns 8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
}

.hero-slide:not([data-active="true"]) .hero-zoom-img {
    transform: scale(1.0);
}

/* Hide scrollbars for review tracks */
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // -------------------------------------------------------------
    // 1. HERO BANNER SLIDER & ZOOM-IN (CAROUSEL & NAVIGATION)
    // -------------------------------------------------------------
    const heroSection = document.getElementById('hero-section');
    if (heroSection) {
        const slides = heroSection.querySelectorAll('.hero-slide');
        const textSlides = heroSection.querySelectorAll('.hero-text-slide');
        const dots = heroSection.querySelectorAll('.hero-dot');
        const prevBtn = document.getElementById('hero-prev-btn');
        const nextBtn = document.getElementById('hero-next-btn');

        if (slides.length > 0) {
            let currentIndex = 0;
            const totalSlides = slides.length;
            let slideInterval = null;
            const autoPlayDelay = 6500;

            function showSlide(index) {
                if (index < 0) index = totalSlides - 1;
                if (index >= totalSlides) index = 0;
                currentIndex = index;

                // Update Background Slides & Reset Ken Burns Zoom
                slides.forEach((slide, i) => {
                    const img = slide.querySelector('.hero-zoom-img');
                    if (i === currentIndex) {
                        slide.setAttribute('data-active', 'true');
                        slide.classList.remove('opacity-0', 'pointer-events-none', 'z-0');
                        slide.classList.add('opacity-100', 'z-10');
                        if (img) {
                            img.style.animation = 'none';
                            void img.offsetWidth; // Force CSS reflow to retrigger animation
                            img.style.animation = 'heroKenBurns 8s cubic-bezier(0.25, 1, 0.5, 1) forwards';
                        }
                    } else {
                        slide.removeAttribute('data-active');
                        slide.classList.remove('opacity-100', 'z-10');
                        slide.classList.add('opacity-0', 'pointer-events-none', 'z-0');
                        if (img) {
                            img.style.animation = 'none';
                        }
                    }
                });

                // Update Text Slides
                textSlides.forEach((textSlide, i) => {
                    if (i === currentIndex) {
                        textSlide.classList.remove('opacity-0', 'translate-y-4', 'absolute', 'pointer-events-none');
                        textSlide.classList.add('opacity-100', 'translate-y-0', 'relative');
                    } else {
                        textSlide.classList.remove('opacity-100', 'translate-y-0', 'relative');
                        textSlide.classList.add('opacity-0', 'translate-y-4', 'absolute', 'pointer-events-none');
                    }
                });

                // Update Dots Indicator
                dots.forEach((dot, i) => {
                    if (i === currentIndex) {
                        dot.classList.add('w-8', 'bg-chestnut');
                        dot.classList.remove('w-2.5', 'bg-white/40');
                    } else {
                        dot.classList.remove('w-8', 'bg-chestnut');
                        dot.classList.add('w-2.5', 'bg-white/40');
                    }
                });
            }

            function nextSlide() {
                showSlide(currentIndex + 1);
            }

            function prevSlide() {
                showSlide(currentIndex - 1);
            }

            function startTimer() {
                if (totalSlides <= 1) return;
                stopTimer();
                slideInterval = setInterval(nextSlide, autoPlayDelay);
            }

            function stopTimer() {
                if (slideInterval) {
                    clearInterval(slideInterval);
                    slideInterval = null;
                }
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    nextSlide();
                    startTimer();
                });
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    prevSlide();
                    startTimer();
                });
            }

            dots.forEach((dot, idx) => {
                dot.addEventListener('click', function(e) {
                    e.preventDefault();
                    showSlide(idx);
                    startTimer();
                });
            });

            // Pause on hover
            heroSection.addEventListener('mouseenter', stopTimer);
            heroSection.addEventListener('mouseleave', startTimer);

            // Touch swipe gesture for mobile devices
            let touchStartX = 0;
            heroSection.addEventListener('touchstart', function(e) {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });

            heroSection.addEventListener('touchend', function(e) {
                const diff = touchStartX - e.changedTouches[0].screenX;
                if (diff > 50) {
                    nextSlide();
                    startTimer();
                } else if (diff < -50) {
                    prevSlide();
                    startTimer();
                }
            }, { passive: true });

            // Initialize first slide
            showSlide(0);
            startTimer();
        }
    }

    // -------------------------------------------------------------
    // 2. STATS SECTION DYNAMIC NUMBER COUNTERS (INTERSECTION OBSERVER)
    // -------------------------------------------------------------
    const statsSection = document.getElementById('stats-section');
    if (statsSection) {
        const counters = statsSection.querySelectorAll('.counter-num');
        let hasAnimated = false;

        function runCounters() {
            if (hasAnimated) return;
            hasAnimated = true;

            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'), 10) || 0;
                const suffix = counter.getAttribute('data-suffix') || '';
                const useComma = counter.getAttribute('data-comma') === 'true';
                const duration = 2000;
                const startTime = performance.now();

                function step(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    // easeOutCubic deceleration curve
                    const ease = 1 - Math.pow(1 - progress, 3);
                    const currentVal = Math.floor(ease * target);

                    const formatted = useComma ? currentVal.toLocaleString('en-US') : currentVal;
                    counter.textContent = formatted + suffix;

                    if (progress < 1) {
                        requestAnimationFrame(step);
                    } else {
                        const finalVal = useComma ? target.toLocaleString('en-US') : target;
                        counter.textContent = finalVal + suffix;
                    }
                }

                requestAnimationFrame(step);
            });
        }

        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        runCounters();
                        observer.disconnect();
                    }
                });
            }, { threshold: 0.25 });

            observer.observe(statsSection);
        }
    }

    // -------------------------------------------------------------
    // 4. POPULAR TRIPS 9-ITEM 3-ROW CAROUSEL SLIDER (10S AUTO-SLIDE)
    // -------------------------------------------------------------
    const popularTrack = document.getElementById('popular-trips-track');
    const popularContainer = document.getElementById('popular-trips-slider-container');
    const totalPopularPages = {{ $totalPages ?? 1 }};
    let currentPopularPage = 0;
    let popularInterval = null;

    function updatePopularPageUI(pageIndex) {
        if (!popularTrack || totalPopularPages <= 1) return;
        currentPopularPage = (pageIndex + totalPopularPages) % totalPopularPages;
        popularTrack.style.transform = `translateX(-${currentPopularPage * 100}%)`;

        const numEl = document.getElementById('popular-current-num');
        if (numEl) numEl.textContent = currentPopularPage + 1;

        const dots = document.querySelectorAll('.popular-dot');
        dots.forEach((dot, idx) => {
            if (idx === currentPopularPage) {
                dot.className = 'popular-dot transition-all duration-300 rounded-full w-8 h-2.5 bg-[#28B5A4] cursor-pointer';
            } else {
                dot.className = 'popular-dot transition-all duration-300 rounded-full w-2.5 h-2.5 bg-gray-300 hover:bg-gray-400 cursor-pointer';
            }
        });
    }

    window.goToPopularPage = function(index) {
        updatePopularPageUI(index);
        restartPopularAutoSlide();
    };

    window.nextPopularPage = function() {
        updatePopularPageUI(currentPopularPage + 1);
        restartPopularAutoSlide();
    };

    window.prevPopularPage = function() {
        updatePopularPageUI(currentPopularPage - 1);
        restartPopularAutoSlide();
    };

    function startPopularAutoSlide() {
        if (totalPopularPages > 1 && !popularInterval) {
            popularInterval = setInterval(() => {
                updatePopularPageUI(currentPopularPage + 1);
            }, 10000); // Auto-advance every 10s
        }
    }

    function stopPopularAutoSlide() {
        if (popularInterval) {
            clearInterval(popularInterval);
            popularInterval = null;
        }
    }

    function restartPopularAutoSlide() {
        stopPopularAutoSlide();
        startPopularAutoSlide();
    }

    if (popularContainer && totalPopularPages > 1) {
        // Pause on mouse hover, resume on leave
        popularContainer.addEventListener('mouseenter', stopPopularAutoSlide);
        popularContainer.addEventListener('mouseleave', startPopularAutoSlide);

        // Mobile touch swipe gestures
        let touchStartX = 0;
        popularContainer.addEventListener('touchstart', e => {
            touchStartX = e.touches[0].clientX;
            stopPopularAutoSlide();
        }, { passive: true });

        popularContainer.addEventListener('touchend', e => {
            const touchEndX = e.changedTouches[0].clientX;
            if (touchStartX - touchEndX > 50) {
                window.nextPopularPage();
            } else if (touchEndX - touchStartX > 50) {
                window.prevPopularPage();
            } else {
                startPopularAutoSlide();
            }
        }, { passive: true });

        // Kick off 10s auto-slide timer
        startPopularAutoSlide();
    }

    // -------------------------------------------------------------
    // 4. MAIN FEATURE TESTIMONIAL CAROUSEL (Image 2 style)
    // -------------------------------------------------------------
    const featTrack = document.getElementById('feat-test-track');
    const featCarousel = document.getElementById('feat-test-carousel');
    const featPrevBtn = document.getElementById('feat-test-prev');
    const featNextBtn = document.getElementById('feat-test-next');
    const featDots = document.querySelectorAll('.feat-dot');
    const totalFeatSlides = {{ count($testimonials ?? []) > 0 ? count($testimonials) : 1 }};
    let currentFeatSlide = 0;
    let featInterval = null;

    function updateFeatSlide(index) {
        if (!featTrack || totalFeatSlides <= 1) return;
        currentFeatSlide = (index + totalFeatSlides) % totalFeatSlides;
        featTrack.style.transform = `translateX(-${currentFeatSlide * 100}%)`;

        featDots.forEach((dot, idx) => {
            if (idx === currentFeatSlide) {
                dot.className = 'feat-dot w-8 h-2 rounded-full bg-[#28B5A4] transition-all cursor-pointer';
            } else {
                dot.className = 'feat-dot w-2 h-2 rounded-full bg-gray-300 hover:bg-gray-400 transition-all cursor-pointer';
            }
        });
    }

    window.goToFeatSlide = function(index) {
        updateFeatSlide(index);
        restartFeatAutoSlide();
    };

    function nextFeatSlide() {
        updateFeatSlide(currentFeatSlide + 1);
    }

    function prevFeatSlide() {
        updateFeatSlide(currentFeatSlide - 1);
    }

    if (featNextBtn) {
        featNextBtn.addEventListener('click', () => {
            nextFeatSlide();
            restartFeatAutoSlide();
        });
    }

    if (featPrevBtn) {
        featPrevBtn.addEventListener('click', () => {
            prevFeatSlide();
            restartFeatAutoSlide();
        });
    }

    function startFeatAutoSlide() {
        if (!featInterval && totalFeatSlides > 1) {
            featInterval = setInterval(nextFeatSlide, 5000); // 5s auto-slide
        }
    }

    function stopFeatAutoSlide() {
        if (featInterval) {
            clearInterval(featInterval);
            featInterval = null;
        }
    }

    function restartFeatAutoSlide() {
        stopFeatAutoSlide();
        startFeatAutoSlide();
    }

    if (featCarousel) {
        featCarousel.addEventListener('mouseenter', stopFeatAutoSlide);
        featCarousel.addEventListener('mouseleave', startFeatAutoSlide);

        // Mobile swipe
        let fTouchStartX = 0;
        featCarousel.addEventListener('touchstart', e => {
            fTouchStartX = e.touches[0].clientX;
            stopFeatAutoSlide();
        }, { passive: true });

        featCarousel.addEventListener('touchend', e => {
            const fTouchEndX = e.changedTouches[0].clientX;
            if (fTouchStartX - fTouchEndX > 50) {
                nextFeatSlide();
            } else if (fTouchEndX - fTouchStartX > 50) {
                prevFeatSlide();
            }
            startFeatAutoSlide();
        }, { passive: true });

        startFeatAutoSlide();
    }
});
</script>

@endsection
