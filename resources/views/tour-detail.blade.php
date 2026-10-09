@extends('layouts.app')

@section('title', $tour->title . ' | ' . option('site_name', 'Chestnut Travel'))
@section('meta_description', Str::limit(strip_tags($tour->overview), 160))

@section('content')
@php
    $images = $tour->all_images;
    if (empty($images)) {
        $images = [
            asset('storage/destinations/ha-giang.jpg'),
            asset('storage/destinations/sapa.jpg'),
            asset('storage/destinations/lan-ha-bay.jpg'),
            asset('storage/destinations/ninh-binh.jpg'),
            asset('storage/destinations/ta-xua.jpg'),
        ];
    }
    // Fill up to 5 if needed for clean grid
    while (count($images) < 5) {
        $images[] = $images[0];
    }
    $mainImage = $images[0];
    $gridImages = array_slice($images, 1, 4);

    $basePrice = $tour->sale_price ?? $tour->price;
    $awardBadgeImg = option_image('award_badge_image', option('award_badge_image_url', asset('storage/badges/tcbr-2025.webp')));
@endphp

<!-- ============================================================== -->
<!-- 1. BREADCRUMB & HEADER SECTION                                 -->
<!-- ============================================================== -->
<section class="bg-stone-50 border-b border-gray-200/80 pt-6 pb-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-gray-500 mb-4 overflow-x-auto whitespace-nowrap py-1">
            <a href="{{ route('home') }}" class="hover:text-chestnut transition">Home</a>
            <span class="text-gray-300">/</span>
            <a href="{{ route('home') }}#tours-section" class="hover:text-chestnut transition">Trips</a>
            @if($tour->destination)
                <span class="text-gray-300">/</span>
                <a href="{{ route('home') }}?destination={{ $tour->destination->slug }}#tours-section" class="hover:text-chestnut transition">
                    {{ $tour->destination->name }}
                </a>
            @endif
            <span class="text-gray-300">/</span>
            <span class="text-gray-800 font-semibold truncate max-w-sm">{{ $tour->title }}</span>
        </nav>

        <!-- Title & Duration Badge (Chestnut Travel Style) -->
        <div class="flex items-start justify-between gap-4 sm:gap-6">
            <div class="flex-1">
                @if($tour->tagline)
                    <span class="inline-block bg-[#28B5A4]/10 text-[#28B5A4] border border-[#28B5A4]/20 font-extrabold text-[11px] uppercase tracking-wider px-3 py-1 rounded-full mb-2">
                        {{ $tour->tagline }}
                    </span>
                @endif
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight leading-tight">
                    {{ $tour->title }}
                </h1>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <!-- Days Badge (Chestnut Travel exact style) -->
                <div class="flex flex-col items-center justify-center border-2 border-[#28B5A4] rounded-lg overflow-hidden w-14 sm:w-16 shadow-2xs">
                    <div class="w-full bg-[#28B5A4] text-white font-extrabold text-xl sm:text-2xl text-center py-1 leading-none">
                        {{ $tour->duration_days ?: 2 }}
                    </div>
                    <div class="w-full bg-white text-[#28B5A4] font-bold text-[11px] sm:text-xs text-center py-0.5 leading-none">
                        Days
                    </div>
                </div>

                <!-- Wishlist button -->
                <button type="button" 
                        onclick="toggleWishlist({{ $tour->id }}, '{{ addslashes($tour->title) }}', '{{ $mainImage }}', '{{ route('tour.show', $tour->slug) }}', {{ $basePrice }})" 
                        data-wishlist-id="{{ $tour->id }}"
                        title="Save to wishlist"
                        class="hidden sm:inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 hover:text-gray-900 border border-gray-200 px-3.5 py-2.5 rounded-xl text-xs font-bold shadow-sm transition active:scale-95 cursor-pointer">
                    <i class="fa-regular fa-heart text-sm"></i>
                </button>
            </div>
        </div>

        <!-- Meta specs bar -->
        <div class="flex flex-wrap items-center gap-4 sm:gap-8 mt-5 pt-4 border-t border-gray-200/60 text-xs text-gray-600 font-medium">
            <!-- TripAdvisor rating badge -->
            @php
                $actualReviews = $tour->reviews ?? collect();
                $actualReviewCount = $actualReviews->count();
                $avgRating = $actualReviewCount > 0 ? round($actualReviews->avg('rating'), 1) : (float) ($tour->rating ?? 5.0);
            @endphp
            <div class="flex items-center gap-2">
                <img src="{{ $awardBadgeImg }}" alt="TripAdvisor" class="w-5 h-5 rounded-full object-contain">
                <div class="flex items-center text-amber-500 gap-1 font-bold">
                    <i class="fa-solid fa-star"></i>
                    <span class="text-gray-900">{{ number_format($avgRating, 1) }}</span>
                </div>
                @if($actualReviewCount > 0)
                    <span class="text-gray-500">({{ $actualReviewCount }} {{ Str::plural('review', $actualReviewCount) }})</span>
                @else
                    <span class="text-gray-400">(No reviews yet)</span>
                @endif
            </div>

            <div class="hidden sm:block text-gray-300">•</div>

            <!-- Duration -->
            <div class="flex items-center gap-1.5">
                <i class="fa-regular fa-clock text-chestnut"></i>
                <span class="font-bold text-gray-800">{{ $tour->duration_days }} {{ Str::plural('Day', $tour->duration_days) }} {{ $tour->duration_nights }} {{ Str::plural('Night', $tour->duration_nights) }}</span>
            </div>

            <div class="hidden sm:block text-gray-300">•</div>

            <!-- Group Size -->
            <div class="flex items-center gap-1.5">
                <i class="fa-solid fa-users text-chestnut"></i>
                <span>{{ $tour->group_size ?? 'Max 10 people' }}</span>
            </div>

            <div class="hidden sm:block text-gray-300">•</div>

            <!-- Tour Type -->
            <div class="flex items-center gap-1.5">
                <i class="fa-solid fa-motorcycle text-chestnut"></i>
                <span>{{ $tour->trip_type ?? 'Easy Rider / Motorbike' }}</span>
            </div>

            <div class="hidden sm:block text-gray-300">•</div>

            <!-- Departure -->
            <div class="flex items-center gap-1.5">
                <i class="fa-solid fa-location-dot text-chestnut"></i>
                <span>Departs from: <b>{{ $tour->departure_from ?? 'Hanoi / Ha Giang' }}</b></span>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================== -->
<!-- 2. PHOTO GALLERY HORIZONTAL AUTO-SLIDER (FULL WIDTH)           -->
<!-- ============================================================== -->
<section class="w-full relative overflow-hidden bg-gray-950 group select-none" id="tour-banner-container">
    <!-- Slides Track -->
    <div id="tour-banner-track" class="flex transition-transform duration-700 ease-out h-[380px] sm:h-[480px] lg:h-[540px] xl:h-[580px]">
        @foreach($images as $idx => $img)
            <div class="w-full h-full flex-shrink-0 relative cursor-pointer" 
                 style="flex: 0 0 100%;" 
                 onclick="openLightbox({{ $idx }})">
                <img src="{{ $img }}" 
                     alt="{{ $tour->title }} - photo {{ $idx + 1 }}" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-transparent to-black/25 pointer-events-none"></div>
                
                <!-- Slide caption overlay -->
                <div class="absolute bottom-6 left-6 sm:bottom-8 sm:left-12 lg:left-16 text-white max-w-xl pointer-events-none">
                    <span class="inline-block bg-[#28B5A4] text-white text-[10px] sm:text-xs font-extrabold uppercase px-2.5 py-0.5 rounded-full mb-2 shadow">
                        Photo {{ $idx + 1 }} / {{ count($images) }}
                    </span>
                    <h3 class="text-base sm:text-2xl lg:text-3xl font-black line-clamp-1 drop-shadow-md">
                        {{ $tour->title }}
                    </h3>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Left / Prev arrow -->
    <button type="button" 
            id="slider-prev-btn" 
            class="absolute top-1/2 -translate-y-1/2 left-4 sm:left-6 lg:left-8 w-11 h-11 sm:w-13 sm:h-13 rounded-full bg-black/40 hover:bg-black/80 backdrop-blur-md text-white flex items-center justify-center transition active:scale-90 opacity-80 group-hover:opacity-100 z-10 cursor-pointer shadow-lg" 
            aria-label="Previous Slide">
        <i class="fa-solid fa-chevron-left text-sm sm:text-base"></i>
    </button>

    <!-- Right / Next arrow -->
    <button type="button" 
            id="slider-next-btn" 
            class="absolute top-1/2 -translate-y-1/2 right-4 sm:right-6 lg:right-8 w-11 h-11 sm:w-13 sm:h-13 rounded-full bg-black/40 hover:bg-black/80 backdrop-blur-md text-white flex items-center justify-center transition active:scale-90 opacity-80 group-hover:opacity-100 z-10 cursor-pointer shadow-lg" 
            aria-label="Next Slide">
        <i class="fa-solid fa-chevron-right text-sm sm:text-base"></i>
    </button>

    <!-- Bottom Right Controls: Gallery button -->
    <div class="absolute bottom-5 right-5 sm:bottom-7 sm:right-10 lg:right-16 flex items-center gap-3 z-10">
        <button type="button" 
                onclick="openLightbox(0)" 
                class="inline-flex items-center gap-2 bg-white/95 hover:bg-white text-gray-900 text-xs sm:text-sm font-extrabold px-4 sm:px-5 py-2.5 sm:py-3 rounded-2xl shadow-xl hover:scale-105 transition cursor-pointer backdrop-blur-md">
            <i class="fa-solid fa-images text-[#28B5A4]"></i>
            <span>Gallery ({{ count($images) }} photos)</span>
        </button>
    </div>

    <!-- Dots indicator center bottom -->
    <div id="slider-dots" class="absolute bottom-5 left-1/2 -translate-x-1/2 flex items-center gap-1.5 z-10">
        @foreach($images as $idx => $img)
            <button type="button" 
                    onclick="goToSlide({{ $idx }})" 
                    class="slider-dot w-2.5 h-2.5 rounded-full transition-all duration-300 {{ $idx === 0 ? 'w-7 bg-[#28B5A4]' : 'bg-white/60 hover:bg-white' }}" 
                    aria-label="Slide {{ $idx + 1 }}"></button>
        @endforeach
    </div>
</section>

<!-- ============================================================== -->
<!-- 3. STICKY SUB-NAVIGATION BAR (Overview, Itinerary, Cost...)    -->
<!-- ============================================================== -->
<div class="sticky top-16 sm:top-20 z-30 bg-white border-y border-gray-200 shadow-sm transition-all duration-200" style="transform: translateZ(0); will-change: transform;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <nav class="flex items-center gap-1 sm:gap-2 overflow-x-auto py-2.5 sm:py-3 text-xs sm:text-sm font-bold text-gray-600 no-scrollbar">
                <a href="#overview" class="tab-link px-3 sm:px-4 py-1.5 rounded-lg hover:text-chestnut hover:bg-orange-50 transition active text-chestnut bg-orange-50/80">
                    <i class="fa-solid fa-circle-info mr-1 text-[11px]"></i> Overview
                </a>
                <a href="#itinerary" class="tab-link px-3 sm:px-4 py-1.5 rounded-lg hover:text-chestnut hover:bg-orange-50 transition">
                    <i class="fa-solid fa-calendar-days mr-1 text-[11px]"></i> Itinerary
                </a>
                <a href="#cost" class="tab-link px-3 sm:px-4 py-1.5 rounded-lg hover:text-chestnut hover:bg-orange-50 transition">
                    <i class="fa-solid fa-receipt mr-1 text-[11px]"></i> Includes & Excludes
                </a>
                @if(!empty($tour->faqs) && is_array($tour->faqs) && count($tour->faqs) > 0)
                <a href="#faqs" class="tab-link px-3 sm:px-4 py-1.5 rounded-lg hover:text-chestnut hover:bg-orange-50 transition">
                    <i class="fa-solid fa-circle-question mr-1 text-[11px]"></i> FAQs
                </a>
                @endif
                <a href="#reviews" class="tab-link px-3 sm:px-4 py-1.5 rounded-lg hover:text-chestnut hover:bg-orange-50 transition">
                    <i class="fa-solid fa-star mr-1 text-[11px] text-amber-500"></i> Reviews{{ $actualReviewCount > 0 ? " ($actualReviewCount)" : '' }}
                </a>
            </nav>


        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- 4. MAIN DETAILS & STICKY BOOKING WIDGET                        -->
<!-- ============================================================== -->
<section class="py-12 bg-gray-50/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start">
            
            <!-- LEFT COLUMN: ARTICLE & CONTENT (8 Cols / ~66%) -->
            <div class="lg:col-span-8 space-y-12">

                <!-- SECTION: OVERVIEW -->
                <div id="overview" class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-200/80 shadow-sm scroll-mt-36">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-6">
                        <div>
                            <span class="text-chestnut font-extrabold text-xs uppercase tracking-widest block mb-1">About this trip</span>
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Overview & Experience</h2>
                        </div>
                        <div class="w-10 h-10 rounded-2xl bg-orange-50 text-chestnut flex items-center justify-center text-lg">
                            <i class="fa-solid fa-mountain-sun"></i>
                        </div>
                    </div>

                    <!-- Highlights bullet cards -->
                    @if(!empty($tour->highlights) && is_array($tour->highlights))
                        <div class="bg-gradient-to-br from-amber-50/60 to-orange-50/40 rounded-2xl p-6 border border-orange-100/80 mb-8">
                            <h3 class="text-sm font-extrabold text-gray-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-sparkles text-chestnut"></i>
                                <span>Trip highlights</span>
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 text-xs text-gray-800">
                                @foreach($tour->highlights as $hl)
                                    <div class="flex items-start gap-2.5">
                                        <i class="fa-solid fa-circle-check text-emerald-600 text-sm mt-0.5 flex-shrink-0"></i>
                                        <span class="leading-relaxed font-medium">{{ $hl }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Rich overview article -->
                    <div class="prose prose-stone max-w-none text-gray-700 leading-relaxed text-sm sm:text-base prose-headings:font-extrabold prose-headings:text-gray-900 prose-img:rounded-2xl prose-img:shadow-md prose-blockquote:border-l-4 prose-blockquote:border-chestnut prose-blockquote:bg-orange-50/50 prose-blockquote:py-2.5 prose-blockquote:px-5 prose-blockquote:rounded-r-xl prose-blockquote:text-gray-700 prose-blockquote:font-medium prose-blockquote:italic">
                        {!! $tour->overview !!}
                    </div>
                </div>

                <!-- SECTION: COMBO INCLUDED STAGES (COMBO PACKAGES ONLY) -->
                @if($tour->is_combo && $tour->comboItems && $tour->comboItems->count() > 0)
                    <div id="combo-stages" class="bg-gradient-to-br from-amber-50/40 via-white to-orange-50/30 rounded-3xl p-6 sm:p-10 border-2 border-orange-200/80 shadow-md scroll-mt-36">
                        <div class="flex items-center justify-between pb-4 border-b border-orange-100 mb-6">
                            <div>
                                <span class="text-chestnut font-black text-xs uppercase tracking-widest block mb-1">
                                    <i class="fa-solid fa-gift mr-1"></i> All-inclusive Combo Package
                                </span>
                                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Stages & Tours in This Combo</h2>
                            </div>
                            @if($tour->calculated_saving > 0)
                                <div class="hidden sm:block text-right">
                                    <span class="text-[10px] text-gray-500 block uppercase font-bold">Combo deal</span>
                                    <span class="inline-block bg-emerald-600 text-white font-extrabold text-xs px-3 py-1 rounded-full shadow-sm">
                                        Save ${{ round($tour->calculated_saving) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <p class="text-xs sm:text-sm text-gray-600 mb-6 leading-relaxed">
                            This combo brings together {{ $tour->comboItems->count() }} specialist tour stages, connected by premium inter-province transfers. No need to worry about booking your own transport between provinces.
                        </p>

                        <!-- Stages list -->
                        <div class="space-y-6 relative before:absolute before:left-4 before:top-6 before:bottom-6 before:w-0.5 before:bg-orange-200/80">
                            @foreach($tour->comboItems as $idx => $stage)
                                @php
                                    $child = $stage->childTour;
                                @endphp
                                <div class="relative pl-10">
                                    <!-- Stage Number Badge -->
                                    <div class="absolute left-0 top-1 w-8 h-8 rounded-full bg-chestnut text-white font-black text-xs flex items-center justify-center shadow-md">
                                        {{ $idx + 1 }}
                                    </div>

                                    <!-- Stage Content Card -->
                                    <div class="bg-white rounded-2xl border border-stone-200/90 p-5 shadow-xs hover:border-chestnut transition">
                                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-2">
                                            <div>
                                                <span class="text-[11px] font-black text-chestnut uppercase tracking-wider block">
                                                    {{ $stage->stage_title ?: ('Stage ' . ($idx + 1)) }}
                                                </span>
                                                <h3 class="text-base font-extrabold text-gray-900">
                                                    @if($child)
                                                        <a href="{{ route('tour.show', $child->slug) }}" target="_blank" class="hover:text-chestnut transition flex items-center gap-1.5">
                                                            <span>{{ $child->title }}</span>
                                                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-gray-400"></i>
                                                        </a>
                                                    @else
                                                        {{ $stage->stage_title }}
                                                    @endif
                                                </h3>
                                            </div>

                                            <div class="flex items-center gap-2 shrink-0">
                                                <span class="bg-stone-100 text-stone-700 text-[11px] font-bold px-2.5 py-1 rounded-full">
                                                    <i class="fa-regular fa-clock mr-1"></i> {{ $stage->stage_days }} {{ Str::plural('Day', $stage->stage_days) }}
                                                </span>
                                                @if($child && $child->destination)
                                                    <span class="bg-teal-50 text-[#28B5A4] text-[11px] font-bold px-2.5 py-1 rounded-full">
                                                        <i class="fa-solid fa-location-dot mr-1"></i> {{ $child->destination->name }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        @if($child)
                                            <p class="text-xs text-gray-500 line-clamp-2 mb-3">
                                                {{ $child->tagline ?? strip_tags($child->overview) }}
                                            </p>
                                        @endif

                                        @if($stage->transit_notes)
                                            <div class="bg-orange-50/70 border border-orange-200/60 rounded-xl p-3 text-xs text-orange-950 flex items-start gap-2.5">
                                                <i class="fa-solid fa-van-shuttle text-chestnut text-sm mt-0.5 shrink-0"></i>
                                                <div>
                                                    <span class="font-bold block text-[11px] uppercase tracking-wider text-chestnut">Transfer between stages:</span>
                                                    <span>{{ $stage->transit_notes }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Price Comparison Box -->
                        @if($tour->combo_original_price > $basePrice)
                            <div class="mt-8 pt-6 border-t border-orange-200/70 bg-white rounded-2xl p-5 border border-stone-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                                <div class="text-center sm:text-left">
                                    <span class="text-xs text-gray-500 font-semibold block">Price comparison when booking the combo:</span>
                                    <div class="flex items-center gap-2 mt-0.5 justify-center sm:justify-start">
                                        <span class="text-xs text-gray-400 line-through">Separate tours total: ${{ number_format($tour->combo_original_price, 0) }}</span>
                                        <span class="text-base font-black text-chestnut">➔ Combo price: ${{ number_format($basePrice, 0) }}</span>
                                    </div>
                                </div>
                                <div class="inline-flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-800 font-black text-xs px-4 py-2 rounded-xl">
                                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                                    <span>Save ${{ number_format($tour->calculated_saving, 0) }} instantly with this package!</span>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- SECTION: DETAILED DAY-BY-DAY ITINERARY -->
                <div id="itinerary" class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-200/80 shadow-sm scroll-mt-36">
                    <div class="flex items-center justify-between pb-6 border-b border-gray-100 mb-6">
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Itinerary</h2>
                        
                        <!-- Expand all toggle pill (Exact match to screenshot) -->
                        <div onclick="toggleExpandAllItineraries()" 
                             id="itinerary-expand-btn"
                             class="inline-flex items-center gap-2.5 px-3 py-1.5 border border-gray-200 rounded-lg bg-white shadow-2xs hover:border-gray-300 transition cursor-pointer select-none">
                            <span class="text-xs sm:text-sm font-semibold text-gray-600">Expand all</span>
                            <div id="itinerary-toggle-track" class="w-9 h-5 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out relative flex items-center px-0.5">
                                <div id="itinerary-toggle-thumb" class="w-4 h-4 bg-white rounded-full shadow-sm transition-transform duration-200 ease-in-out translate-x-0"></div>
                            </div>
                        </div>
                    </div>

                    @if($tour->itineraries && $tour->itineraries->count() > 0)
                        <div class="space-y-2" id="itinerary-list">
                            @foreach($tour->itineraries as $index => $iti)
                                @php
                                    $rawTitle = trim($iti->title);
                                    $hasPrefix = preg_match('/^(day|full\s*day)/i', $rawTitle);
                                    if ($hasPrefix) {
                                        $displayTitle = $rawTitle;
                                    } elseif (($tour->duration_days ?? 1) <= 1 && $tour->itineraries->count() <= 1) {
                                        $displayTitle = 'Full day : ' . $rawTitle;
                                    } else {
                                        $displayTitle = 'Day ' . $iti->day_number . ' : ' . $rawTitle;
                                    }
                                @endphp
                                <div class="itinerary-item py-3.5 border-b border-gray-100/80 last:border-b-0" data-itinerary-id="{{ $iti->id }}">
                                    <!-- Header Accordion Trigger -->
                                    <div onclick="toggleItinerary({{ $iti->id }})" 
                                         class="w-full flex items-center justify-between gap-4 cursor-pointer select-none group py-1">
                                        <div class="flex items-center gap-3.5 sm:gap-4 flex-1">
                                            <!-- Teal circular badge with white flag icon -->
                                            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#14b8a6] text-white flex items-center justify-center flex-shrink-0 shadow-xs">
                                                <i class="fa-solid fa-flag text-xs"></i>
                                            </div>
                                            <h3 class="font-bold text-gray-900 text-sm sm:text-base sm:text-[17px] group-hover:text-[#0d9488] transition-colors leading-snug">
                                                {{ $displayTitle }}
                                            </h3>
                                        </div>

                                        <div class="flex-shrink-0 text-gray-400 group-hover:text-gray-600 transition pl-2">
                                            <i id="iti-chevron-{{ $iti->id }}" class="fa-solid fa-chevron-down text-xs sm:text-sm iti-chevron transition-all duration-200"></i>
                                        </div>
                                    </div>

                                    <!-- Collapsible Content -->
                                    <div id="itinerary-content-{{ $iti->id }}" class="itinerary-content hidden pt-3 pb-3 pl-11 sm:pl-13 text-gray-700 leading-relaxed text-sm sm:text-[15px] space-y-3">
                                        @if($iti->meals || $iti->accommodation)
                                            <div class="flex flex-wrap items-center gap-2.5 pt-1 text-xs text-gray-500 font-medium">
                                                @if($iti->meals)
                                                    <span class="inline-flex items-center gap-1.5 bg-gray-50 border border-gray-200/80 px-2.5 py-1 rounded-md">
                                                        <i class="fa-solid fa-utensils text-[#14b8a6]"></i>
                                                        <span>Meals: <strong class="text-gray-800">{{ $iti->meals }}</strong></span>
                                                    </span>
                                                @endif
                                                @if($iti->accommodation)
                                                    <span class="inline-flex items-center gap-1.5 bg-gray-50 border border-gray-200/80 px-2.5 py-1 rounded-md">
                                                        <i class="fa-solid fa-bed text-[#14b8a6]"></i>
                                                        <span>Accommodation: <strong class="text-gray-800">{{ $iti->accommodation }}</strong></span>
                                                    </span>
                                                @endif
                                            </div>
                                        @endif

                                        <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed text-sm sm:text-[15px] prose-p:my-2.5 prose-strong:font-bold prose-strong:text-gray-900">
                                            {!! $iti->description !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 py-4">The detailed itinerary is being updated. Please contact our travel consultants for the latest schedule!</p>
                    @endif
                </div>

                <!-- SECTION: INCLUSIONS & EXCLUSIONS (COST) -->
                <div id="cost" class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-200/80 shadow-sm scroll-mt-36">
                    <div class="pb-4 border-b border-gray-100 mb-8">
                        <span class="text-chestnut font-extrabold text-xs uppercase tracking-widest block mb-1">Services & Costs</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">What's included & excluded</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- INCLUSIONS CARD -->
                        <div class="bg-emerald-50/60 rounded-3xl p-6 sm:p-7 border border-emerald-200/80">
                            <div class="flex items-center gap-3 mb-6 pb-3 border-b border-emerald-200/60">
                                <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-sm shadow-sm">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <h3 class="text-base font-extrabold text-emerald-950 uppercase tracking-wider">
                                    What's Included
                                </h3>
                            </div>

                            <ul class="space-y-3.5 text-xs sm:text-sm text-emerald-950">
                                @if(!empty($tour->inclusions) && is_array($tour->inclusions))
                                    @foreach($tour->inclusions as $inc)
                                        <li class="flex items-start gap-3">
                                            <i class="fa-solid fa-circle-check text-emerald-600 text-base mt-0.5 flex-shrink-0"></i>
                                            <span class="leading-relaxed font-medium">{{ $inc }}</span>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="flex items-start gap-3">
                                        <i class="fa-solid fa-circle-check text-emerald-600 text-base mt-0.5 flex-shrink-0"></i>
                                        <span>Round-trip premium sleeper bus Hanoi – Ha Giang.</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <i class="fa-solid fa-circle-check text-emerald-600 text-base mt-0.5 flex-shrink-0"></i>
                                        <span>Professional Easy Rider driver who doubles as your local guide.</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <i class="fa-solid fa-circle-check text-emerald-600 text-base mt-0.5 flex-shrink-0"></i>
                                        <span>All homestay / hotel accommodation with full amenities.</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <i class="fa-solid fa-circle-check text-emerald-600 text-base mt-0.5 flex-shrink-0"></i>
                                        <span>All meals in the program featuring local cuisine.</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <i class="fa-solid fa-circle-check text-emerald-600 text-base mt-0.5 flex-shrink-0"></i>
                                        <span>Entrance tickets to attractions and the Tu San Canyon – Nho Que River boat trip.</span>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        <!-- EXCLUSIONS CARD -->
                        <div class="bg-rose-50/60 rounded-3xl p-6 sm:p-7 border border-rose-200/80">
                            <div class="flex items-center gap-3 mb-6 pb-3 border-b border-rose-200/60">
                                <div class="w-9 h-9 rounded-xl bg-rose-600 text-white flex items-center justify-center text-sm shadow-sm">
                                    <i class="fa-solid fa-xmark"></i>
                                </div>
                                <h3 class="text-base font-extrabold text-rose-950 uppercase tracking-wider">
                                    What's Excluded
                                </h3>
                            </div>

                            <ul class="space-y-3.5 text-xs sm:text-sm text-rose-950">
                                @if(!empty($tour->exclusions) && is_array($tour->exclusions))
                                    @foreach($tour->exclusions as $exc)
                                        <li class="flex items-start gap-3">
                                            <i class="fa-solid fa-circle-xmark text-rose-500 text-base mt-0.5 flex-shrink-0"></i>
                                            <span class="leading-relaxed font-medium">{{ $exc }}</span>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="flex items-start gap-3">
                                        <i class="fa-solid fa-circle-xmark text-rose-500 text-base mt-0.5 flex-shrink-0"></i>
                                        <span>Personal drinks (beer, wine, soft drinks) outside the set menu.</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <i class="fa-solid fa-circle-xmark text-rose-500 text-base mt-0.5 flex-shrink-0"></i>
                                        <span>Tips for drivers and guides (at your discretion).</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <i class="fa-solid fa-circle-xmark text-rose-500 text-base mt-0.5 flex-shrink-0"></i>
                                        <span>Personal travel insurance and souvenir shopping.</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <i class="fa-solid fa-circle-xmark text-rose-500 text-base mt-0.5 flex-shrink-0"></i>
                                        <span>VAT (if you require an official invoice).</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- SECTION: FAQS -->
                @if(!empty($tour->faqs) && is_array($tour->faqs) && count($tour->faqs) > 0)
                <div id="faqs" class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-200/80 shadow-sm scroll-mt-36">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-6">
                        <div>
                            <span class="text-chestnut font-extrabold text-xs uppercase tracking-widest block mb-1">Your questions answered</span>
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Frequently Asked Questions</h2>
                        </div>
                        <div class="w-10 h-10 rounded-2xl bg-orange-50 text-chestnut flex items-center justify-center text-lg">
                            <i class="fa-solid fa-circle-question"></i>
                        </div>
                    </div>

                    <div class="space-y-3.5" id="faq-accordion-list">
                        @foreach($tour->faqs as $fIndex => $faq)
                            @if(!empty($faq['question']) && !empty($faq['answer']))
                                <div class="border border-gray-200 rounded-2xl overflow-hidden transition-all duration-300 hover:border-orange-200">
                                    <button type="button" 
                                            onclick="toggleFaq({{ $fIndex }})" 
                                            class="w-full text-left p-4 sm:p-5 bg-white hover:bg-stone-50/70 flex items-center justify-between gap-4 transition cursor-pointer">
                                        <div class="flex items-center gap-3">
                                            <span class="w-7 h-7 rounded-xl bg-orange-100 text-chestnut text-xs font-black flex items-center justify-center shrink-0">
                                                Q{{ $fIndex + 1 }}
                                            </span>
                                            <h3 class="text-sm sm:text-base font-extrabold text-gray-900 leading-snug">
                                                {{ $faq['question'] }}
                                            </h3>
                                        </div>
                                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 text-xs transition duration-300 faq-chevron {{ $fIndex === 0 ? 'rotate-180 bg-orange-100 text-chestnut' : '' }}" id="faq-icon-{{ $fIndex }}">
                                            <i class="fa-solid fa-chevron-down"></i>
                                        </div>
                                    </button>
                                    <div id="faq-content-{{ $fIndex }}" class="faq-content {{ $fIndex === 0 ? 'block' : 'hidden' }} px-5 sm:px-6 pb-5 pt-1 bg-stone-50/50 border-t border-gray-100 text-xs sm:text-sm text-gray-700 leading-relaxed">
                                        {!! nl2br(e($faq['answer'])) !!}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- SECTION: REVIEWS (TRIPADVISOR) -->
                <div id="reviews" class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-200/80 shadow-sm scroll-mt-36">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-gray-100 mb-8 gap-4">
                        <div>
                            <span class="text-chestnut font-extrabold text-xs uppercase tracking-widest block mb-1">Traveler feedback</span>
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Reviews from real travelers</h2>
                        </div>
                        <!-- Big Rating Card -->
                        <div class="flex items-center gap-3 bg-amber-50 border border-amber-200 px-4 py-3 rounded-2xl">
                            <img src="{{ $awardBadgeImg }}" alt="TripAdvisor" class="w-8 h-8 rounded-full object-contain">
                            <div>
                                <div class="flex items-center gap-1 text-amber-500 font-black text-lg leading-none">
                                    <span>{{ number_format($avgRating, 1) }}</span>
                                    <div class="flex text-xs">
                                        @for($s = 1; $s <= 5; $s++)
                                            <i class="fa-solid fa-star {{ $s <= round($avgRating) ? 'text-amber-500' : 'text-gray-200' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <span class="text-[10px] text-gray-500 font-semibold block mt-0.5">
                                    {{ $actualReviewCount > 0 ? $actualReviewCount . ' verified ' . Str::plural('review', $actualReviewCount) : 'No reviews yet' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews List (Dynamic from MySQL Database & Admin Panel) -->
                    <div class="space-y-6">
                        @if($tour->reviews && $tour->reviews->count() > 0)
                            @foreach($tour->reviews as $rev)
                                @php
                                    $words = explode(' ', trim($rev->author_name));
                                    $initials = '';
                                    if (count($words) >= 2) {
                                        $initials = mb_strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[count($words) - 1], 0, 1));
                                    } else {
                                        $initials = mb_strtoupper(mb_substr($rev->author_name, 0, 2));
                                    }
                                @endphp
                                <div class="p-5 sm:p-6 rounded-2xl bg-stone-50 border border-gray-100 hover:border-orange-200 transition">
                                    <div class="flex items-center justify-between mb-3.5">
                                        <div class="flex items-center gap-3">
                                            @if($rev->author_avatar)
                                                <img src="{{ Str::startsWith($rev->author_avatar, 'http') ? $rev->author_avatar : asset('storage/' . $rev->author_avatar) }}" 
                                                     alt="{{ $rev->author_name }}" 
                                                     class="w-10 h-10 rounded-full object-cover shadow-2xs">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-orange-100 text-chestnut font-bold text-xs flex items-center justify-center shadow-2xs">
                                                    {{ $initials }}
                                                </div>
                                            @endif
                                            <div>
                                                <h4 class="font-extrabold text-sm text-gray-900">{{ $rev->author_name }}</h4>
                                                <span class="text-[11px] text-gray-400">
                                                    {{ $rev->author_location ? $rev->author_location . ' • ' : '' }}{{ $rev->review_date ?? 'Recently' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <div class="flex text-amber-400 text-xs">
                                                @for($s = 1; $s <= 5; $s++)
                                                    <i class="fa-solid fa-star {{ $s <= $rev->rating ? 'text-amber-400' : 'text-gray-200' }}"></i>
                                                @endfor
                                            </div>
                                            @if($rev->source)
                                                <span class="text-[10px] text-gray-400 bg-white border border-gray-200 px-2 py-0.5 rounded-full font-medium ml-1">
                                                    {{ $rev->source }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="text-xs sm:text-sm text-gray-700 leading-relaxed italic">
                                        "{!! nl2br(e($rev->comment)) !!}"
                                    </p>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-8 text-gray-400 text-xs sm:text-sm">
                                <i class="fa-regular fa-comment-dots text-2xl text-gray-300 block mb-2"></i>
                                <span>There are no reviews for this trip yet. Contact us and be the first to experience it!</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- ============================================================== -->
                <!-- ENQUIRY FORM (Chestnut Travel: You can send your enquiry via the form below) -->
                <!-- ============================================================== -->
                <div id="enquiry" class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200/90 shadow-sm mt-10">
                    <div class="mb-6">
                        <span class="text-xs font-extrabold text-chestnut uppercase tracking-widest block mb-1">Free consultation</span>
                        <h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight">
                            You can send your enquiry via the form below.
                        </h2>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1.5 leading-relaxed">
                            Send us your details and Chestnut Travel's local experts will reply with a detailed itinerary and the best quote within 15-30 minutes.
                        </p>
                    </div>

                    @if(session('enquiry_success'))
                        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center gap-3">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                            <div>
                                <span class="font-bold block">Enquiry sent successfully!</span>
                                <span>{{ session('enquiry_success') }}</span>
                            </div>
                        </div>
                    @endif

                    <div id="enquiry-status" class="hidden mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center gap-3" role="status">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                        <div>
                            <span class="font-bold block">Enquiry sent successfully!</span>
                            <span data-message></span>
                        </div>
                    </div>

                    <form action="{{ route('tour.enquiry') }}" method="POST" id="tour-enquiry-form" novalidate class="space-y-4 text-xs">
                        @csrf
                        <input type="hidden" name="tour_id" value="{{ $tour->id }}">

                        <!-- Trip Name -->
                        <div>
                            <label class="block font-bold text-gray-700 mb-1">
                                Trip name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   value="{{ $tour->title }}" 
                                   readonly 
                                   class="w-full bg-gray-100 border border-gray-200 text-gray-800 font-semibold rounded-xl px-4 py-3 cursor-not-allowed">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Your name -->
                            <div>
                                <label for="enquiry_name" class="block font-bold text-gray-700 mb-1">
                                    Your name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="enquiry_name" 
                                       name="enquiry_name" 
                                       required data-required-message="Please enter your name." 
                                       placeholder="Enter Your Name *" 
                                       value="{{ Auth::user()->name ?? old('enquiry_name') }}"
                                       class="w-full bg-white border border-gray-200 focus:border-chestnut rounded-xl px-4 py-3 outline-none transition font-medium">
                            </div>

                            <!-- Your email -->
                            <div>
                                <label for="enquiry_email" class="block font-bold text-gray-700 mb-1">
                                    Your email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="enquiry_email" 
                                       name="enquiry_email" 
                                       required data-required-message="Please enter your email address." 
                                       placeholder="Enter Your Email *" 
                                       value="{{ Auth::user()->email ?? old('enquiry_email') }}"
                                       class="w-full bg-white border border-gray-200 focus:border-chestnut rounded-xl px-4 py-3 outline-none transition font-medium">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Country -->
                            <div>
                                <label for="enquiry_country" class="block font-bold text-gray-700 mb-1">
                                    Country
                                </label>
                                <select id="enquiry_country" 
                                        name="enquiry_country" 
                                        class="w-full bg-white border border-gray-200 focus:border-chestnut rounded-xl px-4 py-3 outline-none transition font-medium text-gray-700">
                                    <option value="Vietnam">Vietnam</option>
                                    <option value="United States">United States</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Germany">Germany</option>
                                    <option value="France">France</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Other">Other Country</option>
                                </select>
                            </div>

                            <!-- Contact number -->
                            <div>
                                <label for="enquiry_contact" class="block font-bold text-gray-700 mb-1">
                                    Contact number / WhatsApp <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="enquiry_contact" 
                                       name="enquiry_contact" 
                                       required data-required-message="Please enter your contact number or WhatsApp." 
                                       placeholder="Enter Your Contact Number *" 
                                       value="{{ Auth::user()->phone ?? old('enquiry_contact') }}"
                                       class="w-full bg-white border border-gray-200 focus:border-chestnut rounded-xl px-4 py-3 outline-none transition font-medium">
                            </div>
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="enquiry_message" class="block font-bold text-gray-700 mb-1">
                                Message / Special requests
                            </label>
                            <textarea id="enquiry_message" 
                                      name="enquiry_message" 
                                      rows="4" 
                                      placeholder="Let us know if you need changes to the itinerary, group size, departure date, hotels..." 
                                      class="w-full bg-white border border-gray-200 focus:border-chestnut rounded-xl p-4 outline-none transition font-medium resize-none"></textarea>
                        </div>

                        <div>
                            <button type="submit" 
                                    class="w-full sm:w-auto bg-[#28B5A4] hover:bg-[#209C8D] text-white font-extrabold text-xs px-8 py-3.5 rounded-xl shadow-lg shadow-[#28B5A4]/25 transition active:scale-95 flex items-center justify-center gap-2 cursor-pointer">
                                <i class="fa-solid fa-paper-plane"></i>
                                <span>Send Enquiry</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>

            <!-- RIGHT COLUMN: STICKY BOOKING WIDGET (Chestnut Travel Style) -->
            <div id="booking-card" class="lg:col-span-4 lg:sticky lg:top-36 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 p-6 relative">
                    <!-- Discount Percent Badge (Yellow) -->
                    @php
                        $discountPercent = 8;
                        if ($tour->price > 0 && $tour->sale_price && $tour->sale_price < $tour->price) {
                            $discountPercent = round((1 - $tour->sale_price / $tour->price) * 100);
                        }
                        $originalPrice = ($tour->price && $tour->price > $basePrice) ? $tour->price : round($basePrice / (1 - $discountPercent / 100));
                    @endphp
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="inline-block bg-[#F59E0B] text-white text-[11px] font-bold px-2.5 py-0.5 rounded-full">
                            {{ $discountPercent }}% OFF
                        </span>
                        @if($tour->is_combo)
                            <span class="inline-block bg-chestnut text-white text-[11px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                {{ $tour->combo_badge ?: 'COMBO PACKAGE' }}
                            </span>
                            @if($tour->calculated_saving > 0)
                                <span class="inline-block bg-emerald-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                                    Save ${{ round($tour->calculated_saving) }}
                                </span>
                            @endif
                        @endif
                    </div>

                    <!-- Price from strikethrough -->
                    <div class="mt-2 text-xs text-gray-500 font-medium">
                        From <del class="line-through text-gray-400 font-normal">${{ number_format($originalPrice, 0) }}</del>
                    </div>

                    <!-- Main Price / Adult -->
                    <div class="text-2xl sm:text-3xl font-black text-gray-900 mt-0.5 mb-4">
                        ${{ number_format($basePrice, 0) }} <span class="text-xs sm:text-sm font-normal text-gray-500">/ person</span>
                    </div>

                    <!-- Checkboxes & Guarantees -->
                    <div class="space-y-2.5 pt-4 border-t border-gray-100 text-xs text-gray-700">
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 rounded border border-[#28B5A4] text-[#28B5A4] flex items-center justify-center text-[10px] shrink-0 font-bold">
                                <i class="fa-solid fa-check"></i>
                            </span>
                            <span class="font-medium text-gray-800">Best price guaranteed</span>
                            <span class="w-3.5 h-3.5 rounded bg-[#28B5A4] text-white text-[9px] font-bold flex items-center justify-center cursor-pointer shrink-0" title="Guaranteed quality service at the best price">?</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 rounded border border-[#28B5A4] text-[#28B5A4] flex items-center justify-center text-[10px] shrink-0 font-bold">
                                <i class="fa-solid fa-check"></i>
                            </span>
                            <span class="font-medium text-gray-800">No hidden fees</span>
                            <span class="w-3.5 h-3.5 rounded bg-[#28B5A4] text-white text-[9px] font-bold flex items-center justify-center cursor-pointer shrink-0" title="Transparent all-inclusive pricing, no hidden fees">?</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 rounded border border-[#28B5A4] text-[#28B5A4] flex items-center justify-center text-[10px] shrink-0 font-bold">
                                <i class="fa-solid fa-check"></i>
                            </span>
                            <span class="font-medium text-gray-800">Knowledgeable local guides</span>
                        </div>
                    </div>

                    <!-- Check Availability CTA Button -->
                    <div class="mt-5">
                        <button type="button" 
                                onclick="openBookingFromWidget()" 
                                class="w-full bg-[#E88024] hover:bg-[#d6721b] text-white font-bold py-3.5 px-6 rounded-lg text-sm sm:text-base shadow-sm transition active:scale-98 flex items-center justify-center cursor-pointer">
                            Check Availability & Book
                        </button>
                    </div>

                    <!-- Need help with booking footer text -->
                    <div class="mt-4 text-center text-xs text-gray-500 font-medium">
                        Need help with booking? <a href="#enquiry" class="text-[#28B5A4] hover:underline">Send us a message</a>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- WIDGET: TRIP INFO (Chestnut Travel Style)   -->
                <!-- ========================================== -->
                <div class="bg-white rounded-3xl shadow-md border border-gray-200/90 p-6 sm:p-7">
                    <h3 class="text-base font-extrabold text-gray-900 mb-5 flex items-center gap-2.5 pb-4 border-b border-gray-100">
                        <span class="w-8 h-8 rounded-xl bg-orange-100 text-chestnut flex items-center justify-center text-sm">
                            <i class="fa-solid fa-circle-info"></i>
                        </span>
                        <span>Trip information</span>
                    </h3>
                    <ul class="space-y-3.5 text-xs">
                        <li class="flex items-start gap-3">
                            <span class="w-8 h-8 rounded-xl bg-stone-100 text-gray-700 flex items-center justify-center shrink-0 text-sm">
                                <i class="fa-solid fa-language"></i>
                            </span>
                            <div>
                                <span class="text-gray-400 block font-semibold text-[10px] uppercase tracking-wider">Languages</span>
                                <span class="font-bold text-gray-800 text-xs sm:text-sm">{{ $tour->languages ?? 'English / Vietnamese' }}</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-8 h-8 rounded-xl bg-stone-100 text-gray-700 flex items-center justify-center shrink-0 text-sm">
                                <i class="fa-regular fa-clock"></i>
                            </span>
                            <div>
                                <span class="text-gray-400 block font-semibold text-[10px] uppercase tracking-wider">Duration</span>
                                <span class="font-bold text-gray-800 text-xs sm:text-sm">{{ $tour->duration_days }} {{ Str::plural('Day', $tour->duration_days) }} - {{ $tour->duration_nights }} {{ Str::plural('Night', $tour->duration_nights) }}</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-8 h-8 rounded-xl bg-stone-100 text-gray-700 flex items-center justify-center shrink-0 text-sm">
                                <i class="fa-solid fa-hotel"></i>
                            </span>
                            <div>
                                <span class="text-gray-400 block font-semibold text-[10px] uppercase tracking-wider">Accommodation</span>
                                <span class="font-bold text-gray-800 text-xs sm:text-sm">Local homestay / Comfortable hotel</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-8 h-8 rounded-xl bg-stone-100 text-gray-700 flex items-center justify-center shrink-0 text-sm">
                                <i class="fa-regular fa-id-card"></i>
                            </span>
                            <div>
                                <span class="text-gray-400 block font-semibold text-[10px] uppercase tracking-wider">Required documents</span>
                                <span class="font-bold text-gray-800 text-xs sm:text-sm">ID card / Passport (driving licence if self-riding)</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-8 h-8 rounded-xl bg-stone-100 text-gray-700 flex items-center justify-center shrink-0 text-sm">
                                <i class="fa-solid fa-plane-departure"></i>
                            </span>
                            <div>
                                <span class="text-gray-400 block font-semibold text-[10px] uppercase tracking-wider">Pickup point</span>
                                <span class="font-bold text-gray-800 text-xs sm:text-sm">{{ $tour->departure_from ?? 'Hanoi' }}</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-8 h-8 rounded-xl bg-stone-100 text-gray-700 flex items-center justify-center shrink-0 text-sm">
                                <i class="fa-solid fa-bus"></i>
                            </span>
                            <div>
                                <span class="text-gray-400 block font-semibold text-[10px] uppercase tracking-wider">Transportation</span>
                                <span class="font-bold text-gray-800 text-xs sm:text-sm">{{ $tour->transportation ?? 'VIP Limousine / Touring motorbike' }}</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-8 h-8 rounded-xl bg-stone-100 text-gray-700 flex items-center justify-center shrink-0 text-sm">
                                <i class="fa-solid fa-person-hiking"></i>
                            </span>
                            <div>
                                <span class="text-gray-400 block font-semibold text-[10px] uppercase tracking-wider">Trip type</span>
                                <span class="font-bold text-gray-800 text-xs sm:text-sm">{{ $tour->trip_type ?? 'Local experience / Easy Rider' }}</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-8 h-8 rounded-xl bg-stone-100 text-gray-700 flex items-center justify-center shrink-0 text-sm">
                                <i class="fa-solid fa-users"></i>
                            </span>
                            <div>
                                <span class="text-gray-400 block font-semibold text-[10px] uppercase tracking-wider">Group size</span>
                                <span class="font-bold text-gray-800 text-xs sm:text-sm">{{ $tour->group_size ?? 'Small group of 6 - 10 people' }}</span>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- ========================================== -->
                <!-- WIDGET: FEATURED TRIPS (Chestnut Travel)   -->
                <!-- ========================================== -->
                @if(isset($featuredTours) && $featuredTours->count() > 0)
                    <div class="bg-white rounded-3xl shadow-md border border-gray-200/90 p-6 sm:p-7">
                        <h3 class="text-base font-extrabold text-gray-900 mb-5 flex items-center gap-2.5 pb-4 border-b border-gray-100">
                            <span class="w-8 h-8 rounded-xl bg-orange-100 text-chestnut flex items-center justify-center text-sm">
                                <i class="fa-solid fa-fire"></i>
                            </span>
                            <span>Other featured tours</span>
                        </h3>
                        <div class="space-y-4">
                            @foreach($featuredTours as $ft)
                                @php
                                    $ftPrice = $ft->sale_price ?? $ft->price;
                                    $hasDiscount = $ft->sale_price && $ft->sale_price < $ft->price;
                                    $discountPct = $hasDiscount ? round((($ft->price - $ft->sale_price) / $ft->price) * 100) : 0;
                                @endphp
                                <div class="rounded-2xl border border-gray-200/80 overflow-hidden bg-stone-50/50 hover:bg-white hover:shadow-md transition duration-300 flex flex-col group">
                                    <div class="relative h-36 overflow-hidden">
                                        <a href="{{ route('tour.show', $ft->slug) }}" class="block w-full h-full">
                                            <img src="{{ Str::startsWith($ft->featured_image, 'http') ? $ft->featured_image : asset('storage/' . $ft->featured_image) }}" 
                                                 alt="{{ $ft->title }}" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                        </a>
                                        @if($hasDiscount)
                                            <span class="absolute top-2.5 left-2.5 bg-red-600 text-white font-black text-[10px] uppercase px-2 py-0.5 rounded-full shadow">
                                                {{ $discountPct }}% OFF
                                            </span>
                                        @endif
                                        <div class="absolute bottom-2.5 right-2.5 bg-black/75 backdrop-blur-sm text-white text-xs font-black px-2.5 py-1 rounded-xl">
                                            @if($hasDiscount)
                                                <span class="line-through text-gray-400 text-[10px] mr-1">${{ number_format($ft->price, 0) }}</span>
                                            @endif
                                            <span class="text-white">${{ number_format($ftPrice, 0) }}</span>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <h4 class="font-bold text-xs sm:text-sm text-gray-900 group-hover:text-chestnut transition line-clamp-2 leading-snug mb-2.5">
                                            <a href="{{ route('tour.show', $ft->slug) }}">{{ $ft->title }}</a>
                                        </h4>
                                        <div class="flex items-center justify-between text-[11px] text-gray-500 font-medium pt-2 border-t border-gray-100">
                                            <span class="flex items-center gap-1">
                                                <i class="fa-solid fa-location-dot text-chestnut text-[10px]"></i>
                                                <span>{{ $ft->destination->name ?? 'Vietnam' }}</span>
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <i class="fa-regular fa-clock text-gray-400 text-[10px]"></i>
                                                <span>{{ $ft->duration_days }}D - {{ $ft->duration_nights }}N</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>

<!-- ============================================================== -->
<!-- 4. RELATED TRIPS SECTION (Chestnut Travel Style)               -->
<!-- ============================================================== -->
@if(isset($relatedTours) && $relatedTours->count() > 0)
<section class="py-16 bg-[#F8F9FA] border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <span class="text-xs font-extrabold text-chestnut uppercase tracking-widest block mb-1">Explore more</span>
                <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">Related tours</h2>
            </div>
            <a href="{{ route('home') }}#tours-section" class="text-xs font-bold text-chestnut hover:underline flex items-center gap-1.5 self-start sm:self-end">
                <span>View all other trips</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @foreach($relatedTours as $rel)
                <x-tour-card :tour="$rel" />
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ============================================================== -->
<!-- 5. LIGHTBOX GALLERY MODAL                                      -->
<!-- ============================================================== -->
<div id="lightbox-modal" class="fixed inset-0 z-50 bg-black/95 backdrop-blur-md hidden flex flex-col justify-between p-4 sm:p-6 transition-opacity duration-300">
    <!-- Top Bar -->
    <div class="flex items-center justify-between text-white max-w-7xl mx-auto w-full pb-4">
        <div>
            <span class="text-xs text-gray-400 uppercase font-bold tracking-widest block">{{ $tour->title }}</span>
            <span class="text-sm font-extrabold text-white" id="lightbox-counter">1 / {{ count($images) }}</span>
        </div>
        <button type="button" onclick="closeLightbox()" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition text-lg cursor-pointer">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <!-- Main Image Stage with Nav Arrows -->
    <div class="relative flex-1 flex items-center justify-center max-w-6xl mx-auto w-full my-auto overflow-hidden">
        <!-- Prev Button -->
        <button type="button" 
                onclick="prevLightboxImage()" 
                class="absolute left-2 sm:left-4 z-10 w-11 h-11 rounded-full bg-black/50 hover:bg-black/80 text-white flex items-center justify-center transition border border-white/20 hover:scale-105 cursor-pointer">
            <i class="fa-solid fa-chevron-left text-sm"></i>
        </button>

        <!-- Current Active Large Image -->
        <img id="lightbox-active-img" 
             src="{{ $mainImage }}" 
             alt="{{ $tour->title }}" 
             class="max-h-[72vh] max-w-full object-contain rounded-2xl shadow-2xl transition duration-300">

        <!-- Next Button -->
        <button type="button" 
                onclick="nextLightboxImage()" 
                class="absolute right-2 sm:right-4 z-10 w-11 h-11 rounded-full bg-black/50 hover:bg-black/80 text-white flex items-center justify-center transition border border-white/20 hover:scale-105 cursor-pointer">
            <i class="fa-solid fa-chevron-right text-sm"></i>
        </button>
    </div>

    <!-- Bottom Thumbnails Strip -->
    <div class="max-w-4xl mx-auto w-full pt-4 overflow-x-auto">
        <div class="flex items-center justify-center gap-2 pb-2">
            @foreach($images as $idx => $thumb)
                <button type="button" 
                        onclick="showLightboxImage({{ $idx }})" 
                        class="lightbox-thumb w-14 h-14 sm:w-16 sm:h-16 rounded-xl overflow-hidden border-2 transition-all flex-shrink-0 {{ $idx === 0 ? 'border-[#28B5A4] scale-105' : 'border-transparent opacity-60 hover:opacity-100' }}"
                        data-thumb-index="{{ $idx }}">
                    <img src="{{ $thumb }}" alt="Thumbnail {{ $idx + 1 }}" class="w-full h-full object-cover">
                </button>
            @endforeach
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- JAVASCRIPT LOGIC FOR GALLERY & WIDGET CALCULATOR               -->
<!-- ============================================================== -->
<script>
    const tourImages = @json($images);
    let currentLightboxIdx = 0;
    let currentAdultPrice = {{ (float) $basePrice }};
    let guestAdults = 1;
    let guestChildren = 0;

    function openLightbox(index = 0) {
        currentLightboxIdx = index;
        updateLightboxUI();
        const modal = document.getElementById('lightbox-modal');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeLightbox() {
        const modal = document.getElementById('lightbox-modal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function showLightboxImage(index) {
        if (index < 0) index = tourImages.length - 1;
        if (index >= tourImages.length) index = 0;
        currentLightboxIdx = index;
        updateLightboxUI();
    }

    function nextLightboxImage() {
        showLightboxImage(currentLightboxIdx + 1);
    }

    function prevLightboxImage() {
        showLightboxImage(currentLightboxIdx - 1);
    }

    function updateLightboxUI() {
        const img = document.getElementById('lightbox-active-img');
        const counter = document.getElementById('lightbox-counter');
        if (img && tourImages[currentLightboxIdx]) {
            img.src = tourImages[currentLightboxIdx];
        }
        if (counter) {
            counter.innerText = `${currentLightboxIdx + 1} / ${tourImages.length}`;
        }
        document.querySelectorAll('.lightbox-thumb').forEach((thumb, idx) => {
            if (idx === currentLightboxIdx) {
                thumb.classList.add('border-[#28B5A4]', 'scale-105');
                thumb.classList.remove('border-transparent', 'opacity-60');
            } else {
                thumb.classList.remove('border-[#28B5A4]', 'scale-105');
                thumb.classList.add('border-transparent', 'opacity-60');
            }
        });
    }

    // Keyboard support for Lightbox (Esc, Left, Right)
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('lightbox-modal');
        if (modal && !modal.classList.contains('hidden')) {
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') nextLightboxImage();
            if (e.key === 'ArrowLeft') prevLightboxImage();
        }
    });

    // Accordion for Itineraries (matching screenshot toggle switch & chevron behavior)
    let allItinerariesExpanded = false;

    function updateExpandAllSwitchState() {
        const contents = document.querySelectorAll('.itinerary-content');
        if (contents.length === 0) return;
        
        let allOpen = true;
        contents.forEach(c => {
            if (c.classList.contains('hidden')) {
                allOpen = false;
            }
        });
        
        allItinerariesExpanded = allOpen;
        const track = document.getElementById('itinerary-toggle-track');
        const thumb = document.getElementById('itinerary-toggle-thumb');
        
        if (track && thumb) {
            if (allOpen) {
                track.className = 'w-9 h-5 bg-[#14b8a6] rounded-full transition-colors duration-200 ease-in-out relative flex items-center px-0.5';
                thumb.className = 'w-4 h-4 bg-white rounded-full shadow-sm transition-transform duration-200 ease-in-out translate-x-4';
            } else {
                track.className = 'w-9 h-5 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out relative flex items-center px-0.5';
                thumb.className = 'w-4 h-4 bg-white rounded-full shadow-sm transition-transform duration-200 ease-in-out translate-x-0';
            }
        }
    }

    function toggleItinerary(id) {
        const content = document.getElementById(`itinerary-content-${id}`);
        const chevron = document.getElementById(`iti-chevron-${id}`);
        if (content) {
            const isHidden = content.classList.contains('hidden');
            if (isHidden) {
                content.classList.remove('hidden');
                if (chevron) {
                    chevron.classList.add('rotate-180', 'text-[#14b8a6]');
                    chevron.classList.remove('text-gray-400');
                }
            } else {
                content.classList.add('hidden');
                if (chevron) {
                    chevron.classList.remove('rotate-180', 'text-[#14b8a6]');
                    chevron.classList.add('text-gray-400');
                }
            }
            updateExpandAllSwitchState();
        }
    }

    function toggleExpandAllItineraries() {
        allItinerariesExpanded = !allItinerariesExpanded;
        const track = document.getElementById('itinerary-toggle-track');
        const thumb = document.getElementById('itinerary-toggle-thumb');
        
        if (track && thumb) {
            if (allItinerariesExpanded) {
                track.className = 'w-9 h-5 bg-[#14b8a6] rounded-full transition-colors duration-200 ease-in-out relative flex items-center px-0.5';
                thumb.className = 'w-4 h-4 bg-white rounded-full shadow-sm transition-transform duration-200 ease-in-out translate-x-4';
            } else {
                track.className = 'w-9 h-5 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out relative flex items-center px-0.5';
                thumb.className = 'w-4 h-4 bg-white rounded-full shadow-sm transition-transform duration-200 ease-in-out translate-x-0';
            }
        }

        document.querySelectorAll('.itinerary-content').forEach(el => {
            if (allItinerariesExpanded) {
                el.classList.remove('hidden');
            } else {
                el.classList.add('hidden');
            }
        });

        document.querySelectorAll('.iti-chevron').forEach(chevron => {
            if (allItinerariesExpanded) {
                chevron.classList.add('rotate-180', 'text-[#14b8a6]');
                chevron.classList.remove('text-gray-400');
            } else {
                chevron.classList.remove('rotate-180', 'text-[#14b8a6]');
                chevron.classList.add('text-gray-400');
            }
        });
    }

    // Open booking modal prefilled with current tour info
    function openBookingFromWidget() {
        const customPackages = @json($tour->prices ?? []);
        const firstPkg = (customPackages && customPackages.length > 0) ? customPackages[0].option_name : '';
        const initialPrice = {{ (float) $basePrice }};
        const tourAddons = @json($tour->available_addons ?? []);

        if (typeof openQuickBookingModal === 'function') {
            openQuickBookingModal(
                {{ $tour->id }}, 
                '{{ addslashes($tour->title) }}', 
                initialPrice, 
                firstPkg, 
                '', 
                1, 
                0, 
                customPackages,
                tourAddons
            );
        } else if (typeof window.openQuickBookingModal === 'function') {
            window.openQuickBookingModal(
                {{ $tour->id }}, 
                '{{ addslashes($tour->title) }}', 
                initialPrice, 
                firstPkg, 
                '', 
                1, 
                0, 
                customPackages,
                tourAddons
            );
        } else {
            const modal = document.getElementById('booking-modal');
            if (modal) modal.classList.remove('hidden');
        }
    }

    // Sub-nav tab active state on scroll (Optimized with requestAnimationFrame & passive listener)
    (function() {
        const sectionIds = ['overview', 'itinerary', 'cost', 'faqs', 'reviews'];
        let cachedItems = null;
        let activeTabId = '';
        let isTicking = false;

        function getItems() {
            if (!cachedItems) {
                cachedItems = sectionIds.map(id => ({
                    id: id,
                    el: document.getElementById(id),
                    link: document.querySelector(`.tab-link[href="#${id}"]`)
                })).filter(item => item.el && item.link);
            }
            return cachedItems;
        }

        function updateActiveTab() {
            const items = getItems();
            if (!items.length) {
                isTicking = false;
                return;
            }

            const scrollPos = window.scrollY + 220;
            let currentId = '';

            for (let i = items.length - 1; i >= 0; i--) {
                const item = items[i];
                if (item.el.offsetTop <= scrollPos) {
                    currentId = item.id;
                    break;
                }
            }
            if (!currentId && items.length > 0) {
                currentId = items[0].id;
            }

            if (currentId && currentId !== activeTabId) {
                activeTabId = currentId;
                document.querySelectorAll('.tab-link').forEach(link => {
                    link.classList.remove('text-chestnut', 'bg-orange-50/80');
                });
                const activeItem = items.find(item => item.id === currentId);
                if (activeItem) {
                    activeItem.link.classList.add('text-chestnut', 'bg-orange-50/80');
                }
            }
            isTicking = false;
        }

        window.addEventListener('scroll', function() {
            if (!isTicking) {
                requestAnimationFrame(updateActiveTab);
                isTicking = true;
            }
        }, { passive: true });

        document.addEventListener('DOMContentLoaded', updateActiveTab);
    })();

    // Toggle FAQ Accordion
    function toggleFaq(index) {
        const content = document.getElementById(`faq-content-${index}`);
        const icon = document.getElementById(`faq-icon-${index}`);
        if (content) {
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                content.classList.add('block');
                if (icon) {
                    icon.classList.add('rotate-180', 'bg-orange-100', 'text-chestnut');
                }
            } else {
                content.classList.remove('block');
                content.classList.add('hidden');
                if (icon) {
                    icon.classList.remove('rotate-180', 'bg-orange-100', 'text-chestnut');
                }
            }
        }
    }

    // ==============================================================
    // HORIZONTAL BANNER AUTO-SLIDER
    // ==============================================================
    let currentSlide = 0;
    const totalSlides = {{ count($images) }};
    const track = document.getElementById('tour-banner-track');
    const dots = document.querySelectorAll('.slider-dot');
    let sliderInterval = null;

    function goToSlide(index) {
        if (!track || totalSlides <= 0) return;
        currentSlide = (index + totalSlides) % totalSlides;
        track.style.transform = `translateX(-${currentSlide * 100}%)`;
        dots.forEach((dot, idx) => {
            if (idx === currentSlide) {
                dot.className = 'slider-dot w-7 h-2.5 rounded-full transition-all duration-300 bg-[#28B5A4]';
            } else {
                dot.className = 'slider-dot w-2.5 h-2.5 rounded-full transition-all duration-300 bg-white/60 hover:bg-white';
            }
        });
    }

    function nextSlide() {
        goToSlide(currentSlide + 1);
    }

    function prevSlide() {
        goToSlide(currentSlide - 1);
    }

    function startAutoSlide() {
        stopAutoSlide();
        if (totalSlides > 1) {
            sliderInterval = setInterval(nextSlide, 3500);
        }
    }

    function stopAutoSlide() {
        if (sliderInterval) clearInterval(sliderInterval);
    }

    const sliderContainer = document.getElementById('tour-banner-container');
    if (sliderContainer) {
        sliderContainer.addEventListener('mouseenter', stopAutoSlide);
        sliderContainer.addEventListener('mouseleave', startAutoSlide);

        // Touch swipe support for mobile
        let touchStartX = 0;
        sliderContainer.addEventListener('touchstart', e => {
            touchStartX = e.touches[0].clientX;
            stopAutoSlide();
        }, { passive: true });

        sliderContainer.addEventListener('touchend', e => {
            const touchEndX = e.changedTouches[0].clientX;
            if (touchStartX - touchEndX > 40) {
                nextSlide();
            } else if (touchEndX - touchStartX > 40) {
                prevSlide();
            }
            startAutoSlide();
        }, { passive: true });
    }

    document.getElementById('slider-prev-btn')?.addEventListener('click', () => {
        prevSlide();
        startAutoSlide();
    });

    document.getElementById('slider-next-btn')?.addEventListener('click', () => {
        nextSlide();
        startAutoSlide();
    });

    // Start auto slide on page load
    startAutoSlide();

    // Enquiry form AJAX submit handler with inline validation
    const enquiryForm = document.getElementById('tour-enquiry-form');
    if (enquiryForm) {
        enquiryForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const statusBox = document.getElementById('enquiry-status');
            if (statusBox) statusBox.classList.add('hidden');

            const firstInvalid = validateFields(enquiryForm);
            if (firstInvalid) {
                showToast('Please complete the highlighted fields to send your enquiry.', 'error');
                focusField(firstInvalid);
                return;
            }

            const btn = enquiryForm.querySelector('button[type="submit"]');
            const originalBtnHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i><span>Sending your enquiry...</span>';

            let result;
            try {
                const response = await fetch(enquiryForm.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: new FormData(enquiryForm),
                });
                result = await readJsonResponse(response);
            } catch (err) {
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
                showToast(NETWORK_ERROR_MESSAGE, 'error');
                return;
            }

            btn.disabled = false;
            btn.innerHTML = originalBtnHtml;

            if (result.ok) {
                const message = result.data.message || 'Thank you! Your enquiry has been sent successfully.';
                showToast(message, 'success', 7000);
                if (statusBox) {
                    statusBox.querySelector('[data-message]').textContent = message;
                    statusBox.classList.remove('hidden');
                }
                enquiryForm.querySelectorAll('textarea').forEach(t => t.value = '');
                return;
            }

            focusField(applyServerErrors(enquiryForm, result.data.errors));
            showToast(result.message || 'Something went wrong. Please try again or contact our hotline.', 'error');
        });
    }
</script>
@endsection
