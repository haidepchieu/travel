@props(['tour'])

@php
    $tourImg = Str::startsWith($tour->featured_image, 'http') ? $tour->featured_image : asset('storage/' . $tour->featured_image);
    $tourPrice = $tour->sale_price ?? $tour->price;
    $hasDiscount = $tour->sale_price && $tour->sale_price < $tour->price;

    // Activity count & names
    $actNames = '';
    if ($tour->relationLoaded('activities') && $tour->activities && $tour->activities->count() > 0) {
        $actNames = $tour->activities->pluck('name')->join(' • ');
        $actCount = $tour->activities->count();
    } elseif ($tour->activities && $tour->activities()->count() > 0) {
        $actNames = $tour->activities->pluck('name')->join(' • ');
        $actCount = $tour->activities->count();
    } elseif (!empty($tour->highlights) && is_array($tour->highlights)) {
        $actNames = implode(' • ', array_slice($tour->highlights, 0, 3));
        $actCount = count($tour->highlights);
    } else {
        $actNames = ($tour->destination->name ?? 'Vietnam') . ' • ' . ($tour->trip_type ?? 'Adventure');
        $actCount = 3;
    }
@endphp

<div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-200/80 flex flex-col group relative">
    <!-- Top Image Container -->
    <div class="relative h-60 sm:h-64 overflow-hidden rounded-t-3xl bg-gray-100">
        <a href="{{ route('tour.show', $tour->slug) }}" class="block w-full h-full">
            <img src="{{ $tourImg }}" 
                 alt="{{ $tour->title }}" 
                 loading="lazy" 
                 decoding="async" 
                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500 ease-out">
        </a>

        <!-- Combo Badge Top Left -->
        @if($tour->is_combo)
            <div class="absolute top-3.5 left-3.5 z-10 flex flex-col gap-1 items-start">
                <span class="bg-chestnut text-white text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full shadow-md flex items-center gap-1">
                    <i class="fa-solid fa-gift text-[9px]"></i>
                    <span>{{ $tour->combo_badge ?: 'PACKAGE COMBO' }}</span>
                </span>
                @if($tour->calculated_saving > 0)
                    <span class="bg-emerald-600 text-white text-[9px] font-black uppercase px-2 py-0.5 rounded-full shadow-md">
                        Tiết kiệm ${{ round($tour->calculated_saving) }}
                    </span>
                @endif
            </div>
        @endif
        
        <!-- Wishlist Button Top Right (Rounded circular with subtle dark translucent bg) -->
        <button type="button" 
                onclick="event.preventDefault(); event.stopPropagation(); toggleWishlist({{ $tour->id }}, '{{ addslashes($tour->title) }}', '{{ $tourImg }}', '{{ route('tour.show', $tour->slug) }}', {{ $tourPrice }})" 
                data-wishlist-id="{{ $tour->id }}"
                class="absolute top-3.5 right-3.5 w-9 h-9 rounded-full bg-black/35 hover:bg-black/55 backdrop-blur-xs text-white shadow-sm flex items-center justify-center transition active:scale-90 z-10 cursor-pointer" 
                title="Lưu vào danh sách yêu thích">
            <i class="fa-regular fa-heart text-base text-white"></i>
        </button>

        <!-- Price Overlay Bottom Right (e.g. $159) -->
        <div class="absolute bottom-3 right-3 bg-black/60 backdrop-blur-xs text-white text-base sm:text-lg font-black px-3.5 py-1.5 rounded-xl shadow-md pointer-events-none flex items-baseline gap-1">
            @if($hasDiscount)
                <span class="text-xs line-through text-gray-300 font-semibold">${{ number_format($tour->price, 0) }}</span>
            @endif
            <span>${{ number_format($tourPrice, 0) }}</span>
        </div>
    </div>

    <!-- Card Body -->
    <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between">
        <div>
            <!-- Activity / Category tags line separated by dots -->
            <div class="text-[12px] text-gray-400 font-medium line-clamp-1 mb-2">
                {{ $actNames }}
            </div>

            <!-- Tour Title -->
            <h3 class="font-extrabold text-base sm:text-lg text-gray-900 group-hover:text-chestnut transition duration-200 line-clamp-2 leading-snug mb-5">
                <a href="{{ route('tour.show', $tour->slug) }}">{{ $tour->title }}</a>
            </h3>
        </div>

        <!-- 3 Metadata Columns: Duration, Difficulty, Activity (Replaces description & stars) -->
        <div class="pt-4 border-t border-gray-100 grid grid-cols-3 gap-2 mt-auto">
            <!-- 1. Duration -->
            <div class="flex items-center gap-2 sm:gap-2.5">
                <i class="fa-regular fa-calendar-days text-gray-400 text-lg sm:text-xl shrink-0"></i>
                <div class="min-w-0">
                    <span class="text-[10px] text-gray-400 font-medium block leading-tight">Thời gian</span>
                    <span class="font-bold text-xs sm:text-sm text-gray-900 block leading-tight truncate">
                        {{ $tour->duration_days }} Ngày {{ $tour->duration_nights ? $tour->duration_nights . ' Đêm' : '' }}
                    </span>
                </div>
            </div>

            <!-- 2. Difficulty -->
            <div class="flex items-center gap-2 sm:gap-2.5">
                <i class="fa-solid fa-gauge-high text-gray-400 text-lg sm:text-xl shrink-0"></i>
                <div class="min-w-0">
                    <span class="text-[10px] text-gray-400 font-medium block leading-tight">Độ khó</span>
                    <span class="font-bold text-xs sm:text-sm text-gray-900 block leading-tight truncate">
                        {{ $tour->difficulty ?: 'Dễ' }}
                    </span>
                </div>
            </div>

            <!-- 3. Activity -->
            <div class="flex items-center gap-2 sm:gap-2.5">
                <i class="fa-solid fa-person-hiking text-gray-400 text-lg sm:text-xl shrink-0"></i>
                <div class="min-w-0">
                    <span class="text-[10px] text-gray-400 font-medium block leading-tight">Hoạt động</span>
                    <span class="font-bold text-xs sm:text-sm text-gray-900 block leading-tight truncate">
                        {{ $actCount }} Trải nghiệm
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
