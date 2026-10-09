@extends('layouts.app')

@section('title', 'Blog & Travel Tips - ' . option('site_name', 'Chestnut Travel'))
@section('meta_description', 'Travel guides, trekking tips and how-tos for exploring Ha Giang, Sa Pa and Northern Vietnam from Chestnut Travel.')

@section('content')
<!-- ============================================================== -->
<!-- 1. BREADCRUMBS BAR                                             -->
<!-- ============================================================== -->
<div class="bg-[#F8F9FA] border-b border-gray-200/80 py-3.5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs text-gray-500 overflow-x-auto whitespace-nowrap" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-chestnut transition flex items-center gap-1 font-medium">
                <span>Home</span>
            </a>
            <svg width="12" height="12" viewBox="0 0 20 20" class="text-gray-400 shrink-0 fill-current">
                <path d="M7.7,20c-0.3,0-0.5-0.1-0.7-0.3c-0.4-0.4-0.4-1.1,0-1.5l8.1-8.1L6.7,1.8c-0.4-0.4-0.4-1.1,0-1.5 c0.4-0.4,1.1-0.4,1.5,0l9.1,9.1c0.4,0.4,0.4,1.1,0,1.5l-8.8,8.9C8.2,19.9,7.9,20,7.7,20z"/>
            </svg>
            <span class="text-gray-800 font-semibold">Blog &amp; Tips</span>
        </nav>
    </div>
</div>

<!-- ============================================================== -->
<!-- 2. SECTION HEADER (Exact match to chestnuttravel.net)          -->
<!-- ============================================================== -->
<section class="py-12 bg-[#FAF7F2] border-b border-stone-200/80 text-center">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="font-serif-display italic text-[#28B5A4] text-xl sm:text-2xl block mb-1 font-semibold">
            Blog &amp; Tips
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-gray-900 tracking-tight">
            Travel tips and blog
        </h1>
        <p class="text-sm sm:text-base text-gray-600 mt-2 font-medium">
            Latest travel tips and blog covering all travel experiences.
        </p>
        <div class="flex justify-center mt-3">
            <svg width="48" height="10" viewBox="0 0 48 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 5L6 2L10 8L14 2L18 8L22 2L26 8L30 2L34 8L38 2L42 8L46 5" stroke="#28B5A4" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
    </div>
</section>

<!-- ============================================================== -->
<!-- 3. MAIN BLOG LISTING & SIDEBAR                                 -->
<!-- ============================================================== -->
<section class="py-12 lg:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <!-- LEFT COLUMN: POSTS GRID (~68%) -->
            <div class="lg:col-span-8">
                <!-- Search or active filter banner -->
                @if(request()->filled('s') || request()->filled('category') || request()->filled('tag') || request()->filled('destination'))
                    <div class="mb-8 p-4 rounded-2xl bg-emerald-50/70 border border-emerald-100 flex items-center justify-between">
                        <span class="text-xs sm:text-sm text-gray-700">
                            Search results: 
                            <strong>{{ request('s') ?? request('category') ?? request('tag') ?? ($activeDestination->name ?? request('destination')) }}</strong> 
                            ({{ $posts->total() }} {{ Str::plural('article', $posts->total()) }})
                        </span>
                        <a href="{{ route('blog.index') }}" class="text-xs text-chestnut font-bold hover:underline">
                            Clear filter
                        </a>
                    </div>
                @endif

                @if($posts->isEmpty())
                    <div class="text-center py-16 bg-gray-50 rounded-3xl border border-gray-200">
                        <i class="fa-regular fa-newspaper text-4xl text-gray-300 mb-3"></i>
                        <h4 class="text-base font-bold text-gray-700">No articles found</h4>
                        <p class="text-xs text-gray-500 mt-1 mb-4">Try searching with a different keyword.</p>
                        <a href="{{ route('blog.index') }}" class="inline-block bg-[#28B5A4] text-white text-xs font-bold px-5 py-2.5 rounded-full">
                            View all articles
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        @foreach($posts as $post)
                            <article class="bg-white rounded-3xl overflow-hidden shadow-xs hover:shadow-xl transition-all duration-300 border border-gray-200/80 flex flex-col group">
                                <!-- Thumbnail -->
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

                                <!-- Body -->
                                <div class="p-6 flex-1 flex flex-col justify-between">
                                    <div>
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

                                        <h3 class="text-lg font-extrabold text-gray-900 group-hover:text-[#28B5A4] transition-colors leading-snug line-clamp-2 mb-3">
                                            <a href="{{ route('blog.show', $post->slug) }}">
                                                {{ $post->title }}
                                            </a>
                                        </h3>

                                        <p class="text-xs text-gray-600 line-clamp-3 leading-relaxed mb-5">
                                            {{ $post->excerpt }}
                                        </p>
                                    </div>

                                    <div class="pt-4 border-t border-gray-100">
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
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>

            <!-- RIGHT COLUMN: SIDEBAR (~32%) -->
            <aside class="lg:col-span-4 space-y-8">
                <!-- Search Widget -->
                <div class="bg-gray-50/80 rounded-3xl p-6 border border-gray-200/80">
                    <form action="{{ route('blog.index') }}" method="GET" class="relative flex items-center">
                        <input type="text" name="s" value="{{ request('s') }}" placeholder="Search articles..." 
                               class="w-full bg-white rounded-2xl border border-gray-200 pl-4 pr-12 py-3 text-sm focus:border-chestnut focus:ring-1 focus:ring-chestnut transition outline-none">
                        <button type="submit" class="absolute right-2 w-9 h-9 rounded-xl bg-[#28B5A4] text-white flex items-center justify-center hover:bg-[#209C8D] transition" aria-label="Search">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </button>
                    </form>
                </div>

                <!-- Destinations Widget -->
                <div class="bg-white rounded-3xl p-6 border border-gray-200/80 shadow-xs">
                    <h3 class="text-base font-extrabold text-gray-900 pb-3 mb-4 border-b border-gray-100 flex items-center justify-between">
                        <span>Destinations</span>
                        <i class="fa-solid fa-location-dot text-chestnut text-sm"></i>
                    </h3>
                    <ul class="space-y-2.5">
                        @foreach($destinations as $dest)
                            <li>
                                <a href="{{ route('home') }}?destination={{ $dest->slug }}#tours-section" 
                                   class="flex items-center justify-between text-xs sm:text-sm text-gray-600 hover:text-chestnut py-1 transition group">
                                    <span class="group-hover:translate-x-1 transition-transform flex items-center gap-2">
                                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-300 group-hover:text-chestnut"></i>
                                        {{ $dest->name }}
                                    </span>
                                    <span class="text-[11px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full group-hover:bg-emerald-50 group-hover:text-chestnut transition">
                                        {{ $dest->tours_count }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Activities Widget -->
                <div class="bg-white rounded-3xl p-6 border border-gray-200/80 shadow-xs">
                    <h3 class="text-base font-extrabold text-gray-900 pb-3 mb-4 border-b border-gray-100 flex items-center justify-between">
                        <span>Activities</span>
                        <i class="fa-solid fa-compass text-chestnut text-sm"></i>
                    </h3>
                    <ul class="space-y-2.5">
                        @foreach($activities as $act)
                            <li>
                                <a href="{{ route('activities.show', $act->slug) }}" 
                                   class="flex items-center justify-between text-xs sm:text-sm text-gray-600 hover:text-chestnut py-1 transition group">
                                    <span class="group-hover:translate-x-1 transition-transform flex items-center gap-2">
                                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-300 group-hover:text-chestnut"></i>
                                        {{ $act->name }}
                                    </span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-gray-300 group-hover:text-chestnut"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Featured Trips Widget -->
                @if($featuredTours->isNotEmpty())
                    <div class="bg-white rounded-3xl p-6 border border-gray-200/80 shadow-xs">
                        <h3 class="text-base font-extrabold text-gray-900 pb-3 mb-5 border-b border-gray-100 flex items-center justify-between">
                            <span>Featured Trips</span>
                            <span class="text-xs text-amber-500 font-bold flex items-center gap-1">
                                <i class="fa-solid fa-star"></i> Hot
                            </span>
                        </h3>
                        <div class="space-y-6">
                            @foreach($featuredTours as $ftTour)
                                @php
                                    $ftPrice = $ftTour->sale_price ?? $ftTour->price;
                                    $ftImg = $ftTour->all_images[0] ?? asset('storage/destinations/ha-giang.jpg');
                                    $discountPct = ($ftTour->sale_price && $ftTour->sale_price < $ftTour->price) 
                                        ? round((($ftTour->price - $ftTour->sale_price) / $ftTour->price) * 100) 
                                        : 0;
                                @endphp
                                <div class="rounded-2xl border border-gray-200/90 overflow-hidden shadow-xs group hover:shadow-md transition">
                                    <div class="relative h-40 overflow-hidden bg-gray-100">
                                        <a href="{{ route('tour.show', $ftTour->slug) }}" class="block w-full h-full">
                                            <img src="{{ $ftImg }}" 
                                                 alt="{{ $ftTour->title }}" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                                        </a>
                                        @if($discountPct > 0)
                                            <div class="absolute top-2.5 left-2.5 bg-[#E48E45] text-white font-black text-[10px] px-2 py-0.5 rounded-full uppercase tracking-wider">
                                                {{ $discountPct }}% Off
                                            </div>
                                        @endif
                                        <div class="absolute bottom-2.5 right-2.5 bg-black/65 backdrop-blur-xs text-white text-xs font-black px-2.5 py-1 rounded-lg">
                                            ${{ number_format($ftPrice, 0) }}
                                        </div>
                                    </div>
                                    <div class="p-3.5 bg-white">
                                        <h4 class="font-bold text-xs text-gray-900 group-hover:text-chestnut transition line-clamp-2 leading-snug mb-1">
                                            <a href="{{ route('tour.show', $ftTour->slug) }}">
                                                {{ $ftTour->title }}
                                            </a>
                                        </h4>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>

        </div>
    </div>
</section>
@endsection
