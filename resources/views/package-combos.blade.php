@extends('layouts.app')

@section('title', 'Northern Vietnam Combo Tours - Chestnut Travel')
@section('meta_description', 'Discover all-inclusive combo packages in Northern Vietnam: Ha Giang, Sa Pa, Ninh Binh and Ha Long Bay with seamless transfers and maximum savings.')

@section('content')
<!-- ========================================== -->
<!-- HERO BANNER (Chestnut Travel Style)        -->
<!-- ========================================== -->
<div class="relative bg-gradient-to-r from-[#183935] via-[#21544e] to-[#26786e] text-white pt-24 pb-16 overflow-hidden">
    <!-- Subtle Background Pattern -->
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-white/70 mb-4" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span class="text-white font-semibold">Combo Packages</span>
        </nav>

        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-2 bg-white/10 text-orange-300 border border-white/15 px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
                <i class="fa-solid fa-gift text-xs"></i> All-inclusive savings & seamless transfers
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight mb-4">
                Northern Vietnam Combo Tours
            </h1>
            <p class="text-sm sm:text-base text-white/85 leading-relaxed">
                Journeys combining Vietnam's most famous destinations into one seamless trip. Inter-province transfers, local guides and the best all-inclusive prices are included.
            </p>
        </div>

        <!-- Filter Tabs (North / Central / All) -->
        <div class="flex flex-wrap items-center gap-2.5 mt-8 pt-6 border-t border-white/15">
            <a href="{{ route('package.index') }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition {{ !request('region') ? 'bg-chestnut text-white shadow-md' : 'bg-white/10 hover:bg-white/20 text-white' }}">
                All Combos
            </a>
            <a href="{{ route('package.index', ['region' => 'north']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition {{ request('region') === 'north' ? 'bg-chestnut text-white shadow-md' : 'bg-white/10 hover:bg-white/20 text-white' }}">
                <i class="fa-solid fa-mountain mr-1"></i> Northern Vietnam (Ha Giang, Sa Pa, Ninh Binh...)
            </a>
            <a href="{{ route('package.index', ['region' => 'central']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition {{ request('region') === 'central' ? 'bg-chestnut text-white shadow-md' : 'bg-white/10 hover:bg-white/20 text-white' }}">
                <i class="fa-solid fa-umbrella-beach mr-1"></i> Central Vietnam (Hue, Hoi An, Phong Nha...)
            </a>

            <!-- Search in page -->
            <form action="{{ route('package.index') }}" method="GET" class="ml-auto w-full sm:w-auto mt-2 sm:mt-0">
                @if(request('region'))
                    <input type="hidden" name="region" value="{{ request('region') }}">
                @endif
                <div class="relative">
                    <input type="text" name="s" value="{{ request('s') }}" placeholder="Search combos..." 
                           class="w-full sm:w-64 pl-9 pr-4 py-2 rounded-xl text-xs bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:bg-white focus:text-gray-900 focus:placeholder-gray-400 transition">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-xs text-white/60 pointer-events-none"></i>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- COMBO TOURS LISTING                        -->
<!-- ========================================== -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($combos->isEmpty())
        <div class="text-center py-16 bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
            <div class="w-16 h-16 rounded-full bg-orange-100 text-chestnut flex items-center justify-center text-2xl mx-auto mb-4">
                <i class="fa-solid fa-gift"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">No matching combo packages found</h3>
            <p class="text-xs text-gray-500 max-w-md mx-auto mb-6">You can create your own itinerary with Chestnut Travel's exclusive Customize Tour feature.</p>
            <a href="{{ route('customized-tour') }}" class="inline-flex items-center gap-2 bg-[#28B5A4] hover:bg-[#209C8D] text-white font-bold text-xs px-6 py-3 rounded-full shadow transition">
                <i class="fa-solid fa-sliders"></i> Customize your own tour
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
            @foreach($combos as $tour)
                @php
                    $isCombo = (bool) ($tour->is_combo || str_contains($tour->trip_type ?? '', 'Combo') || str_contains($tour->trip_type ?? '', 'Package'));
                    $badgeText = $tour->combo_badge ?: 'PACKAGE COMBO';
                    $savingAmount = $tour->calculated_saving ?? 0;
                    $origPrice = $tour->combo_original_price ?? ($tour->price * 1.15);
                    $finalPrice = $tour->sale_price ?? $tour->price;
                    $stages = $tour->comboItems ?? collect([]);
                @endphp
                <div class="bg-white rounded-3xl border border-gray-200/80 shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col group relative">
                    
                    <!-- Image & Badge Container -->
                    <div class="relative aspect-[16/10] overflow-hidden bg-stone-100">
                        @if($tour->featured_image)
                            <img src="{{ str_starts_with($tour->featured_image, 'http') ? $tour->featured_image : asset('storage/' . ltrim($tour->featured_image, '/')) }}" 
                                 alt="{{ $tour->title }}"
                                 loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-stone-200 text-stone-400">
                                <i class="fa-regular fa-image text-3xl"></i>
                            </div>
                        @endif

                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

                        <!-- Top Badges -->
                        <div class="absolute top-3.5 left-3.5 flex flex-wrap gap-1.5 items-center z-10">
                            <span class="bg-chestnut text-white text-[10px] font-black uppercase px-2.5 py-1 rounded-full shadow-md flex items-center gap-1">
                                <i class="fa-solid fa-gift text-[9px]"></i>
                                <span>{{ $badgeText }}</span>
                            </span>

                            @if($savingAmount > 0)
                                <span class="bg-emerald-600 text-white text-[10px] font-black uppercase px-2 py-0.5 rounded-full shadow-md">
                                    Save ${{ round($savingAmount) }}
                                </span>
                            @endif
                        </div>

                        <!-- Duration Badge Bottom Right -->
                        <div class="absolute bottom-3 right-3 z-10 bg-black/65 backdrop-blur-xs text-white text-[11px] font-extrabold px-3 py-1 rounded-full border border-white/20 flex items-center gap-1.5">
                            <i class="fa-regular fa-clock text-[10px] text-orange-300"></i>
                            <span>{{ $tour->duration_days }} {{ Str::plural('Day', $tour->duration_days) }} {{ $tour->duration_nights }} {{ Str::plural('Night', $tour->duration_nights) }}</span>
                        </div>

                        <!-- Destination Name Bottom Left -->
                        @if($tour->destination)
                            <div class="absolute bottom-3 left-3 z-10 text-white text-xs font-bold drop-shadow flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-chestnut text-xs"></i>
                                <span>{{ $tour->destination->name }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Card Body -->
                    <div class="p-5 sm:p-6 flex flex-col flex-1">
                        <!-- Rating & Review Count -->
                        <div class="flex items-center gap-2 mb-2 text-xs">
                            <div class="flex items-center text-amber-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star text-[11px]"></i>
                                @endfor
                            </div>
                            <span class="font-extrabold text-gray-900 text-xs">{{ number_format($tour->average_rating, 1) }}</span>
                            <span class="text-gray-400 text-[11px]">({{ $tour->review_count }} {{ Str::plural('review', $tour->review_count) }})</span>
                        </div>

                        <!-- Title -->
                        <h2 class="text-base sm:text-lg font-black text-gray-900 line-clamp-2 group-hover:text-chestnut transition leading-snug mb-2">
                            <a href="{{ route('tour.show', $tour->slug) }}">{{ $tour->title }}</a>
                        </h2>

                        <!-- Overview / Tagline -->
                        <p class="text-xs text-gray-600 line-clamp-2 leading-relaxed mb-4">
                            {{ $tour->tagline ?? strip_tags($tour->overview) }}
                        </p>

                        <!-- Included Stages Chips (If defined) -->
                        @if($stages->count() > 0)
                            <div class="mb-4 pt-3 border-t border-gray-100">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider block mb-1.5">Stages in this combo:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($stages as $stage)
                                        <span class="inline-flex items-center gap-1 bg-stone-50 border border-stone-200 text-stone-700 px-2 py-0.5 rounded-lg text-[10px] font-bold">
                                            <i class="fa-solid fa-check text-emerald-600 text-[9px]"></i>
                                            <span class="line-clamp-1">{{ $stage->stage_title ?: ($stage->childTour->title ?? 'Tour stage') }}</span>
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @elseif($tour->highlights && is_array($tour->highlights) && count($tour->highlights) > 0)
                            <div class="mb-4 pt-3 border-t border-gray-100">
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach(array_slice($tour->highlights, 0, 3) as $hl)
                                        <span class="inline-flex items-center gap-1 bg-orange-50/60 text-chestnut px-2 py-0.5 rounded-lg text-[10px] font-bold">
                                            <i class="fa-solid fa-check text-[9px]"></i> {{ $hl }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Footer: Price & CTA -->
                        <div class="mt-auto pt-4 border-t border-gray-100 flex items-end justify-between gap-3">
                            <div>
                                <span class="text-[10px] text-gray-400 uppercase font-bold block">All-inclusive from</span>
                                <div class="flex items-baseline gap-1.5">
                                    <span class="text-xl sm:text-2xl font-black text-chestnut">${{ number_format($finalPrice, 0) }}</span>
                                    @if($origPrice > $finalPrice)
                                        <span class="text-xs text-gray-400 line-through font-semibold">${{ number_format($origPrice, 0) }}</span>
                                    @endif
                                </div>
                            </div>

                            <a href="{{ route('tour.show', $tour->slug) }}" 
                               class="bg-[#28B5A4] hover:bg-[#209C8D] text-white px-4 py-2.5 rounded-xl text-xs font-bold shadow-md shadow-teal-500/20 transition transform active:scale-95 flex items-center gap-1.5">
                                <span>View details</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            {{ $combos->links() }}
        </div>
    @endif
</div>

<!-- ========================================== -->
<!-- WHY BOOK A PACKAGE COMBO SECTION           -->
<!-- ========================================== -->
<div class="bg-stone-50 border-t border-stone-200/80 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-chestnut font-extrabold text-xs uppercase tracking-widest block mb-1">A superior experience</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Why choose a Chestnut Travel Package Combo?</h2>
            <p class="text-xs sm:text-sm text-gray-600 mt-2">Designed for travelers who want to experience the full beauty of Vietnam in the most cost- and time-efficient way.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-stone-200/90 shadow-xs">
                <div class="w-12 h-12 rounded-xl bg-orange-100 text-chestnut flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-tags"></i>
                </div>
                <h3 class="text-sm font-extrabold text-gray-900 mb-1.5">Significant savings</h3>
                <p class="text-xs text-gray-600 leading-relaxed">Combo prices are always 15% - 25% cheaper than booking each tour stage separately.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-stone-200/90 shadow-xs">
                <div class="w-12 h-12 rounded-xl bg-teal-100 text-[#28B5A4] flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-van-shuttle"></i>
                </div>
                <h3 class="text-sm font-extrabold text-gray-900 mb-1.5">Seamless inter-province transfers</h3>
                <p class="text-xs text-gray-600 leading-relaxed">Premium sleeper limousines with door-to-door pickup between provinces (Hanoi - Sa Pa - Ha Giang - Ninh Binh), no bus station hassle.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-stone-200/90 shadow-xs">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <h3 class="text-sm font-extrabold text-gray-900 mb-1.5">24/7 support throughout your trip</h3>
                <p class="text-xs text-gray-600 leading-relaxed">Chestnut Travel's operations team closely monitors every stage and supports you via WhatsApp/hotline at any time.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-stone-200/90 shadow-xs">
                <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-sliders"></i>
                </div>
                <h3 class="text-sm font-extrabold text-gray-900 mb-1.5">Flexible adjustments</h3>
                <p class="text-xs text-gray-600 leading-relaxed">Easily upgrade rooms, change vehicles or adjust the length of stay to your personal preferences.</p>
            </div>
        </div>
    </div>
</div>
@endsection
