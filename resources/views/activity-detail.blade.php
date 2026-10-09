@extends('layouts.app')

@section('title', $activity->name . ' - ' . option('site_name', 'Chestnut Travel'))
@section('meta_description', 'Discover unique ' . $activity->name . ' tours with Chestnut Travel. Best price guaranteed and high-quality local service.')

@section('content')
<!-- ============================================================== -->
<!-- 1. BREADCRUMB & PAGE HEADER (CHESTNUT TRAVEL STYLE)            -->
<!-- ============================================================== -->
<section class="bg-[#F8FAF9] border-b border-gray-200/80 pt-8 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-gray-500 mb-4 overflow-x-auto whitespace-nowrap py-1">
            <a href="{{ route('home') }}" class="hover:text-[#28B5A4] transition font-medium">Home</a>
            <span class="text-gray-300">/</span>
            <a href="{{ route('home') }}#activities-section" class="hover:text-[#28B5A4] transition font-medium">Activities</a>
            <span class="text-gray-300">/</span>
            <span class="text-gray-900 font-bold truncate">{{ $activity->name }}</span>
        </nav>

        <!-- Page Title & Activity Count -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="inline-block bg-[#28B5A4]/10 text-[#28B5A4] border border-[#28B5A4]/20 font-extrabold text-[11px] uppercase tracking-wider px-3 py-1 rounded-full mb-2">
                    Featured activity
                </span>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight">
                    {{ $activity->name }}
                </h1>
                @if($activity->description)
                    <p class="text-sm text-gray-600 mt-2 max-w-2xl leading-relaxed">
                        {{ $activity->description }}
                    </p>
                @endif
            </div>

            <div class="flex items-center gap-2 text-xs font-semibold text-gray-500 bg-white border border-gray-200 px-4 py-2.5 rounded-2xl shadow-xs self-start sm:self-auto">
                <i class="fa-solid fa-map-location-dot text-[#28B5A4]"></i>
                <span>Found <strong class="text-gray-900 font-bold">{{ $tours->total() }}</strong> {{ Str::plural('trip', $tours->total()) }}</span>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================== -->
<!-- 2. MAIN SECTION: 2-COLUMN FILTER SIDEBAR & TOURS LISTING       -->
<!-- ============================================================== -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- LEFT COLUMN: FILTER SIDEBAR (4 COLS / ~33%) -->
            <aside class="lg:col-span-4 bg-white rounded-3xl p-6 sm:p-7 border border-gray-200 shadow-xs space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <h2 class="text-lg font-extrabold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-sliders text-[#28B5A4]"></i>
                        <span>Filter By</span>
                    </h2>
                    @if(request()->hasAny(['keyword', 'destinations', 'difficulties', 'min_price', 'max_price', 'min_duration', 'max_duration', 'sort']))
                        <a href="{{ route('activities.show', $activity->slug) }}" 
                           class="text-xs font-bold text-red-600 hover:text-red-700 hover:underline">
                            Clear all
                        </a>
                    @endif
                </div>

                <form id="activity-filter-form" method="GET" action="{{ route('activities.show', $activity->slug) }}" class="space-y-6">
                    <input type="hidden" name="view" value="{{ $viewMode }}">

                    <!-- Keyword Search inside sidebar -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Search Trips</label>
                        <div class="relative">
                            <input type="text" 
                                   name="keyword" 
                                   value="{{ request('keyword') }}" 
                                   placeholder="Search by tour name..." 
                                   class="w-full text-xs bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-3 py-2.5 focus:outline-none focus:border-[#28B5A4] focus:ring-1 focus:ring-[#28B5A4] transition">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-3.5 text-xs text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Destination Filter -->
                    <div class="border-t border-gray-100 pt-5">
                        <h3 class="text-sm font-extrabold text-gray-900 mb-3 flex items-center justify-between">
                            <span>Destination</span>
                            <i class="fa-solid fa-location-dot text-xs text-gray-400"></i>
                        </h3>
                        <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                            @foreach($allDestinations as $dest)
                                <label class="flex items-center justify-between text-xs text-gray-700 hover:text-gray-900 cursor-pointer group py-0.5">
                                    <span class="flex items-center gap-2.5">
                                        <input type="checkbox" 
                                               name="destinations[]" 
                                               value="{{ $dest->slug }}" 
                                               {{ in_array($dest->slug, (array)request('destinations', [])) ? 'checked' : '' }}
                                               onchange="this.form.submit()"
                                               class="rounded border-gray-300 text-[#28B5A4] focus:ring-[#28B5A4] w-4 h-4">
                                        <span class="group-hover:text-[#28B5A4] transition">{{ $dest->name }}</span>
                                    </span>
                                    <span class="text-[11px] text-gray-400 font-medium">({{ $dest->tours_count }})</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Filter -->
                    <div class="border-t border-gray-100 pt-5">
                        <h3 class="text-sm font-extrabold text-gray-900 mb-3 flex items-center justify-between">
                            <span>Price Range</span>
                            <span class="text-xs text-[#28B5A4] font-bold">
                                ${{ request('min_price', 0) }} - ${{ request('max_price', 800) }}
                            </span>
                        </h3>
                        <div class="grid grid-cols-2 gap-3 mb-2">
                            <div>
                                <span class="text-[10px] text-gray-400 block mb-1">Min ($)</span>
                                <input type="number" 
                                       name="min_price" 
                                       value="{{ request('min_price', 0) }}" 
                                       min="0" 
                                       max="1000" 
                                       step="10"
                                       class="w-full text-xs bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:border-[#28B5A4]">
                            </div>
                            <div>
                                <span class="text-[10px] text-gray-400 block mb-1">Max ($)</span>
                                <input type="number" 
                                       name="max_price" 
                                       value="{{ request('max_price', 800) }}" 
                                       min="0" 
                                       max="1000" 
                                       step="10"
                                       class="w-full text-xs bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:border-[#28B5A4]">
                            </div>
                        </div>
                    </div>

                    <!-- Duration Filter -->
                    <div class="border-t border-gray-100 pt-5">
                        <h3 class="text-sm font-extrabold text-gray-900 mb-3 flex items-center justify-between">
                            <span>Duration</span>
                            <span class="text-xs text-gray-400 font-medium">
                                {{ request('min_duration', 1) }} - {{ request('max_duration', 14) }} Days
                            </span>
                        </h3>
                        <div class="grid grid-cols-2 gap-3 mb-2">
                            <div>
                                <span class="text-[10px] text-gray-400 block mb-1">Min (Days)</span>
                                <input type="number" 
                                       name="min_duration" 
                                       value="{{ request('min_duration', 1) }}" 
                                       min="1" 
                                       max="30" 
                                       class="w-full text-xs bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:border-[#28B5A4]">
                            </div>
                            <div>
                                <span class="text-[10px] text-gray-400 block mb-1">Max (Days)</span>
                                <input type="number" 
                                       name="max_duration" 
                                       value="{{ request('max_duration', 14) }}" 
                                       min="1" 
                                       max="30" 
                                       class="w-full text-xs bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:border-[#28B5A4]">
                            </div>
                        </div>
                    </div>

                    <!-- Activities List Filter -->
                    <div class="border-t border-gray-100 pt-5">
                        <h3 class="text-sm font-extrabold text-gray-900 mb-3 flex items-center justify-between">
                            <span>All Activities</span>
                            <i class="fa-solid fa-person-hiking text-xs text-gray-400"></i>
                        </h3>
                        <div class="space-y-2">
                            @foreach($allActivities as $actItem)
                                <a href="{{ route('activities.show', $actItem->slug) }}" 
                                   class="flex items-center justify-between text-xs py-1 px-2 rounded-lg transition {{ $actItem->id === $activity->id ? 'bg-[#28B5A4]/10 text-[#28B5A4] font-bold' : 'text-gray-700 hover:text-[#28B5A4] hover:bg-gray-50' }}">
                                    <span class="flex items-center gap-2">
                                        <i class="fa-solid {{ $actItem->id === $activity->id ? 'fa-circle-check text-[#28B5A4]' : 'fa-circle text-gray-300' }} text-[10px]"></i>
                                        <span>{{ $actItem->name }}</span>
                                    </span>
                                    <span class="text-[11px] {{ $actItem->id === $activity->id ? 'text-[#28B5A4]' : 'text-gray-400' }} font-medium">({{ $actItem->tours_count }})</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Difficulties Filter -->
                    <div class="border-t border-gray-100 pt-5">
                        <h3 class="text-sm font-extrabold text-gray-900 mb-3 flex items-center justify-between">
                            <span>Difficulty</span>
                            <i class="fa-solid fa-gauge-high text-xs text-gray-400"></i>
                        </h3>
                        <div class="space-y-2">
                            @foreach(['Easy', 'Medium', 'Challenging'] as $diff)
                                <label class="flex items-center gap-2.5 text-xs text-gray-700 hover:text-gray-900 cursor-pointer">
                                    <input type="checkbox" 
                                           name="difficulties[]" 
                                           value="{{ $diff }}" 
                                           {{ in_array($diff, (array)request('difficulties', [])) ? 'checked' : '' }}
                                           onchange="this.form.submit()"
                                           class="rounded border-gray-300 text-[#28B5A4] focus:ring-[#28B5A4] w-4 h-4">
                                    <span>{{ $diff }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" 
                            class="w-full bg-[#28B5A4] hover:bg-[#209C8D] text-white text-xs font-bold py-3 rounded-xl shadow-sm transition active:scale-95 cursor-pointer">
                        Apply filters
                    </button>
                </form>
            </aside>

            <!-- RIGHT COLUMN: TOURS LISTING (8 COLS / ~66%) -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- TOOLBAR (Search, Sort & View Mode) -->
                <div class="bg-gray-50/80 border border-gray-200/90 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="text-xs text-gray-600 font-medium">
                        Showing <strong class="text-gray-900 font-bold">{{ $tours->count() }}</strong> of <strong class="text-gray-900 font-bold">{{ $tours->total() }}</strong> tours
                    </div>

                    <div class="flex items-center gap-4 self-end sm:self-auto">
                        <!-- Sort Dropdown -->
                        <div class="flex items-center gap-2 text-xs">
                            <span class="text-gray-500 font-medium">Sort:</span>
                            <select onchange="updateSort(this.value)" 
                                    class="bg-white border border-gray-200 rounded-xl px-3 py-1.5 text-xs font-semibold text-gray-800 focus:outline-none focus:border-[#28B5A4] cursor-pointer">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Recently Added</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Top Rated</option>
                                <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Lowest Price First</option>
                                <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Highest Price First</option>
                                <option value="days" {{ request('sort') == 'days' ? 'selected' : '' }}>Shortest Duration</option>
                                <option value="days-desc" {{ request('sort') == 'days-desc' ? 'selected' : '' }}>Longest Duration</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>A to Z</option>
                            </select>
                        </div>

                        <!-- Grid / List View Toggle -->
                        <div class="flex items-center gap-1 bg-white border border-gray-200 p-1 rounded-xl">
                            <a href="{{ request()->fullUrlWithQuery(['view' => 'list']) }}" 
                               class="w-7 h-7 flex items-center justify-center rounded-lg text-xs {{ $viewMode === 'list' ? 'bg-[#28B5A4] text-white shadow-2xs' : 'text-gray-500 hover:text-gray-900' }}" 
                               title="List View">
                                <i class="fa-solid fa-list"></i>
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['view' => 'grid']) }}" 
                               class="w-7 h-7 flex items-center justify-center rounded-lg text-xs {{ $viewMode === 'grid' ? 'bg-[#28B5A4] text-white shadow-2xs' : 'text-gray-500 hover:text-gray-900' }}" 
                               title="Grid View">
                                <i class="fa-solid fa-table-cells-large"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- TOURS RESULTS -->
                @if($tours->count() > 0)
                    @if($viewMode === 'grid')
                        <!-- Grid Layout (2 cols) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($tours as $tour)
                                <x-tour-card :tour="$tour" />
                            @endforeach
                        </div>
                    @else
                        <!-- List Layout (Matching Chestnut Travel horizontal card) -->
                        <div class="space-y-6">
                            @foreach($tours as $tour)
                                @php
                                    $tourImages = $tour->all_images;
                                    $thumb = $tourImages[0] ?? asset('storage/destinations/ha-giang.jpg');
                                    $price = $tour->sale_price ?? $tour->price;
                                    $acts = $tour->activities->pluck('name')->join(' • ');
                                @endphp
                                <div class="bg-white rounded-3xl border border-gray-200/90 overflow-hidden shadow-xs hover:shadow-xl hover:border-[#28B5A4]/40 transition-all duration-300 flex flex-col md:flex-row group">
                                    <!-- Thumbnail (Left ~38%) -->
                                    <div class="relative md:w-5/12 aspect-[16/10] md:aspect-auto overflow-hidden">
                                        <a href="{{ route('tour.show', $tour->slug) }}" class="block w-full h-full">
                                            <img src="{{ $thumb }}" 
                                                 alt="{{ $tour->title }}" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                                        </a>

                                        <!-- Wishlist toggle button -->
                                        <button type="button" 
                                                onclick="toggleWishlist({{ $tour->id }}, '{{ addslashes($tour->title) }}', '{{ $thumb }}', '{{ route('tour.show', $tour->slug) }}', {{ $price }})"
                                                data-wishlist-id="{{ $tour->id }}"
                                                class="absolute top-3 right-3 w-9 h-9 rounded-full bg-black/35 hover:bg-black/60 backdrop-blur-md text-white flex items-center justify-center transition active:scale-90 z-10 cursor-pointer shadow-md">
                                            <i class="fa-regular fa-heart text-sm"></i>
                                        </button>
                                    </div>

                                    <!-- Content (Right ~62%) -->
                                    <div class="p-6 md:w-7/12 flex flex-col justify-between space-y-4">
                                        <div>
                                            <!-- Dot-separated activities -->
                                            @if($acts)
                                                <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider mb-2 line-clamp-1">
                                                    {{ $acts }}
                                                </div>
                                            @endif

                                            <!-- Title -->
                                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-[#28B5A4] transition-colors leading-snug line-clamp-2">
                                                <a href="{{ route('tour.show', $tour->slug) }}">
                                                    {{ $tour->title }}
                                                </a>
                                            </h3>

                                            <!-- Short Description snippet -->
                                            @if($tour->overview)
                                                <p class="text-xs text-gray-600 line-clamp-2 mt-2 leading-relaxed font-normal">
                                                    {{ Str::limit(strip_tags($tour->overview), 130) }}
                                                </p>
                                            @endif

                                            <!-- Meta row: Destination, Difficulty, Group -->
                                            <div class="flex flex-wrap items-center gap-3 mt-4 text-[11px] text-gray-500">
                                                @if($tour->destination)
                                                    <span class="inline-flex items-center gap-1 font-semibold text-gray-700">
                                                        <i class="fa-solid fa-location-dot text-[#28B5A4]"></i>
                                                        <span>{{ $tour->destination->name }}</span>
                                                    </span>
                                                    <span class="text-gray-300">•</span>
                                                @endif
                                                <span class="inline-flex items-center gap-1 font-semibold text-gray-700">
                                                    <i class="fa-solid fa-gauge-high text-[#28B5A4]"></i>
                                                    <span>{{ $tour->difficulty ?? 'Easy' }}</span>
                                                </span>
                                                <span class="text-gray-300">•</span>
                                                <span class="inline-flex items-center gap-1">
                                                    <i class="fa-regular fa-calendar-days text-[#28B5A4]"></i>
                                                    <span>{{ $tour->duration_days }} Days</span>
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Price & View Details Action -->
                                        <div class="pt-4 border-t border-gray-100 flex items-center justify-between gap-4">
                                            <div>
                                                <span class="text-[10px] text-gray-400 uppercase font-semibold block">From</span>
                                                <span class="text-xl font-black text-gray-900">${{ number_format($price, 0) }}</span>
                                            </div>

                                            <a href="{{ route('tour.show', $tour->slug) }}" 
                                               class="inline-flex items-center gap-2 bg-[#28B5A4] hover:bg-[#209C8D] text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-xs transition active:scale-95">
                                                <span>View Details</span>
                                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Pagination -->
                    <div class="pt-6">
                        {{ $tours->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-gray-50 rounded-3xl p-12 text-center border border-gray-200 space-y-4">
                        <div class="w-16 h-16 rounded-full bg-orange-100/60 text-[#28B5A4] flex items-center justify-center text-2xl mx-auto">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">No trips found</h3>
                        <p class="text-xs text-gray-500 max-w-md mx-auto">
                            There are no {{ $activity->name }} tours matching your filters. Please remove some filters or choose another activity.
                        </p>
                        <a href="{{ route('activities.show', $activity->slug) }}" 
                           class="inline-block bg-[#28B5A4] hover:bg-[#209C8D] text-white text-xs font-bold px-6 py-2.5 rounded-xl transition">
                            Clear filters
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function updateSort(sortValue) {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', sortValue);
        window.location.href = url.toString();
    }
</script>
@endpush
@endsection
