@extends('layouts.app')

@section('title', 'My Wishlist | Chestnut Travel')
@section('meta_description', 'Review the tours you have saved at Chestnut Travel to easily compare and plan your trip.')

@section('content')
<!-- ============================================================== -->
<!-- 1. BREADCRUMB & PAGE TITLE                                     -->
<!-- ============================================================== -->
<section class="bg-[#F8F9FA] border-b border-gray-200/80 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-gray-500 mb-3">
            <a href="{{ route('home') }}" class="hover:text-chestnut transition">Home</a>
            <span class="text-gray-300">/</span>
            <span class="text-gray-800 font-semibold">Wishlist</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">My Wishlist</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1.5">
            Save your favorite trips to easily compare and plan them anytime.
        </p>
    </div>
</section>

<!-- ============================================================== -->
<!-- 2. MAIN CONTENT & SIDEBAR (Chestnut Travel Style)              -->
<!-- ============================================================== -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start">

            <!-- LEFT COLUMN: WISHLIST CONTENT (8 Cols / ~68%) -->
            <main class="lg:col-span-8">
                <!-- Top Toolbar when has items -->
                <div id="wishlist-toolbar" class="hidden items-center justify-between pb-4 mb-6 border-b border-gray-100">
                    <div class="flex items-center gap-2">
                        <i class="fa-regular fa-heart text-gray-700 text-sm"></i>
                        <span id="wishlist-header-count" class="text-xs sm:text-sm font-bold text-gray-800">0 tours in your wishlist</span>
                    </div>
                    <button type="button" 
                            onclick="clearAllWishlist()" 
                            class="text-xs text-gray-400 hover:text-gray-900 font-semibold transition flex items-center gap-1.5 cursor-pointer">
                        <i class="fa-regular fa-trash-can"></i>
                        <span>Clear all</span>
                    </button>
                </div>

                <!-- Empty State (Matching Chestnut Travel wpte_empty-items-box) -->
                <div id="wishlist-page-empty" class="hidden py-16 px-6 text-center bg-[#FAF9F6]/80 rounded-3xl border border-gray-100">
                    <div class="w-20 h-20 rounded-full bg-white border border-gray-200 text-gray-400 flex items-center justify-center mx-auto mb-5 text-3xl shadow-sm">
                        <i class="fa-regular fa-heart"></i>
                    </div>
                    <h2 class="text-2xl font-black text-gray-900 tracking-tight mb-2">
                        Your Wishlist Is Empty
                    </h2>
                    <p class="text-sm text-gray-500 mb-8 max-w-md mx-auto leading-relaxed">
                        Explore spectacular routes and save the trips you love most!
                    </p>
                    <a href="{{ route('home') }}#tours-section" 
                       class="inline-flex items-center gap-2 bg-[#28B5A4] hover:bg-[#209C8D] text-white font-extrabold text-xs px-6 py-3.5 rounded-full shadow-lg shadow-[#28B5A4]/25 transition transform active:scale-95">
                        <i class="fa-solid fa-compass"></i>
                        <span>Explore trips</span>
                    </a>
                </div>

                <!-- Items Grid (Rendered by JS from LocalStorage) -->
                <div id="wishlist-grid" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Populated via JavaScript -->
                </div>
            </main>

            <!-- RIGHT COLUMN: SIDEBAR WIDGETS (4 Cols / ~32%) -->
            <aside class="lg:col-span-4 space-y-8">
                <!-- Widget 1: Search Box -->
                <div class="bg-gray-50/80 rounded-3xl p-6 border border-gray-200/80">
                    <h3 class="text-xs font-black uppercase tracking-wider text-gray-900 mb-3.5 flex items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass text-chestnut text-[11px]"></i>
                        <span>Search tours</span>
                    </h3>
                    <form action="{{ route('home') }}#tours-section" method="GET" class="relative">
                        <input type="text" 
                               name="s" 
                               placeholder="Search by tour name, destination..." 
                               class="w-full text-xs font-medium text-gray-800 bg-white border border-gray-200 rounded-xl px-4 py-3 pr-10 focus:outline-none focus:border-chestnut transition">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-chestnut transition">
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </form>
                </div>

                <!-- Widget 2: Destinations -->
                @if(isset($destinations) && $destinations->count() > 0)
                    <div class="bg-gray-50/80 rounded-3xl p-6 border border-gray-200/80">
                        <h3 class="text-xs font-black uppercase tracking-wider text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-location-dot text-chestnut text-[11px]"></i>
                            <span>Destinations</span>
                        </h3>
                        <ul class="space-y-2 text-xs font-semibold text-gray-700">
                            @foreach($destinations as $dest)
                                <li>
                                    <a href="{{ route('home') }}?destination={{ $dest->slug }}#tours-section" class="flex items-center justify-between p-2 rounded-xl hover:bg-white hover:text-chestnut transition">
                                        <span>{{ $dest->name }}</span>
                                        <span class="text-[10px] text-gray-400 font-normal bg-white px-2 py-0.5 rounded-full border border-gray-200">
                                            {{ $dest->tours_count }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Widget 3: Activities -->
                @if(isset($activities) && $activities->count() > 0)
                    <div class="bg-gray-50/80 rounded-3xl p-6 border border-gray-200/80">
                        <h3 class="text-xs font-black uppercase tracking-wider text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-person-biking text-chestnut text-[11px]"></i>
                            <span>Activities</span>
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($activities as $act)
                                <a href="{{ route('home') }}?activity={{ $act->slug }}#tours-section" class="text-xs bg-white hover:bg-orange-50 hover:text-chestnut hover:border-chestnut text-gray-700 px-3 py-1.5 rounded-xl border border-gray-200 transition font-medium">
                                    {{ $act->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Widget 4: Featured Trips -->
                @if(isset($featuredTours) && $featuredTours->count() > 0)
                    <div class="bg-gray-50/80 rounded-3xl p-6 border border-gray-200/80">
                        <h3 class="text-xs font-black uppercase tracking-wider text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-fire text-chestnut text-[11px]"></i>
                            <span>Recommended tours</span>
                        </h3>
                        <div class="space-y-4">
                            @foreach($featuredTours as $ft)
                                <div class="bg-white rounded-2xl p-3 border border-gray-100 flex items-center gap-3 hover:shadow-md transition group">
                                    <a href="{{ route('tour.show', $ft->slug) }}" class="w-16 h-16 rounded-xl overflow-hidden shrink-0 block relative">
                                        <img src="{{ Str::startsWith($ft->featured_image, 'http') ? $ft->featured_image : asset('storage/' . $ft->featured_image) }}" 
                                             alt="{{ $ft->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    </a>
                                    <div class="flex-1 min-w-0">
                                        <span class="text-[10px] text-gray-400 font-semibold block">
                                            {{ $ft->duration_days }}D / {{ $ft->duration_nights }}N
                                        </span>
                                        <a href="{{ route('tour.show', $ft->slug) }}" class="text-xs font-bold text-gray-900 group-hover:text-chestnut transition line-clamp-1 block leading-tight mt-0.5">
                                            {{ $ft->title }}
                                        </a>
                                        <span class="text-xs font-black text-chestnut block mt-1">
                                            ${{ number_format($ft->sale_price ?? $ft->price, 0) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Widget 5: 24/7 Support Assistance -->
                <div class="bg-gradient-to-br from-[#1E2329] to-[#2B313A] rounded-3xl p-6 text-white text-center">
                    <div class="w-11 h-11 rounded-2xl bg-white/10 flex items-center justify-center mx-auto mb-3 text-lg text-amber-400">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <h4 class="font-extrabold text-sm text-white mb-1">Need travel advice?</h4>
                    <p class="text-xs text-gray-300 mb-4 leading-relaxed">
                        Chestnut Travel's local experts are available 24/7 to help you.
                    </p>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', option('site_hotline', '+84867216850')) }}" class="inline-block w-full bg-chestnut hover:bg-orange-600 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition">
                        <i class="fa-solid fa-phone mr-1.5 text-[10px]"></i>
                        <span>{{ option('site_hotline', '+84 867 216 850') }}</span>
                    </a>
                </div>
            </aside>

        </div>
    </div>
</section>

<!-- ============================================================== -->
<!-- JAVASCRIPT: RENDER WISHLIST ITEMS ON DEDICATED PAGE            -->
<!-- ============================================================== -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        renderWishlistPage();
    });

    function renderWishlistPage() {
        const list = getWishlist();
        const emptyBox = document.getElementById('wishlist-page-empty');
        const toolbar = document.getElementById('wishlist-toolbar');
        const grid = document.getElementById('wishlist-grid');
        const countLabel = document.getElementById('wishlist-header-count');

        if (!grid) return;

        if (list.length === 0) {
            emptyBox.classList.remove('hidden');
            toolbar.classList.add('hidden');
            grid.innerHTML = '';
        } else {
            emptyBox.classList.add('hidden');
            toolbar.classList.remove('hidden');
            toolbar.classList.add('flex');
            countLabel.innerText = `${list.length} saved ${list.length === 1 ? 'trip' : 'trips'}`;

            grid.innerHTML = list.map(item => `
                <div class="bg-white rounded-3xl overflow-hidden border border-gray-200/90 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col group relative">
                    <!-- Thumbnail with duration and remove button -->
                    <div class="relative h-52 overflow-hidden bg-gray-100">
                        <a href="${item.url}" class="block w-full h-full">
                            <img src="${item.image}" alt="${item.title}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </a>

                        <!-- Remove from Wishlist button (top right) -->
                        <button type="button" 
                                onclick="removeWishlistItemAndRefresh(${item.id})" 
                                class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/90 hover:bg-white text-gray-600 hover:text-gray-900 shadow-md flex items-center justify-center transition active:scale-90 z-10 cursor-pointer" 
                                title="Remove from wishlist">
                            <i class="fa-solid fa-xmark text-xs"></i>
                        </button>
                    </div>

                    <!-- Card Body -->
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center text-amber-500 gap-1 font-bold text-xs mb-2">
                                <i class="fa-solid fa-star"></i>
                                <span class="text-gray-900">5.0</span>
                                <span class="text-gray-400 font-normal">(TripAdvisor)</span>
                            </div>
                            <h3 class="font-bold text-sm sm:text-base text-gray-900 group-hover:text-chestnut transition line-clamp-2 leading-snug mb-3">
                                <a href="${item.url}">${item.title}</a>
                            </h3>
                        </div>

                        <!-- Card Footer -->
                        <div class="pt-4 border-t border-gray-100 flex items-center justify-between mt-auto">
                            <div>
                                <span class="text-[10px] text-gray-400 uppercase font-semibold block">From</span>
                                <span class="text-lg font-black text-chestnut">$${Number(item.price).toLocaleString()}</span>
                            </div>
                            <a href="${item.url}" class="inline-flex items-center gap-1.5 bg-[#28B5A4] hover:bg-[#209C8D] text-white text-xs font-bold px-4 py-2 rounded-xl shadow-sm hover:shadow transition transform active:scale-95">
                                <span>View details</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            `).join('');
        }
    }

    function removeWishlistItemAndRefresh(id) {
        removeWishlistItem(id);
        renderWishlistPage();
    }

    // Override clearAllWishlist to refresh page grid too
    const originalClearAll = window.clearAllWishlist;
    window.clearAllWishlist = function() {
        if (confirm('Are you sure you want to remove all tours from your wishlist?')) {
            saveWishlist([]);
            renderWishlistPage();
        }
    };
</script>
@endsection
