@extends('layouts.app')

@section('title', $post->title . ' - ' . option('site_name', 'Chestnut Travel'))
@section('meta_description', Str::limit(strip_tags($post->excerpt ?: $post->content), 160))

@section('content')
<!-- ============================================================== -->
<!-- 1. BREADCRUMBS BAR (Exact match to chestnuttravel.net)          -->
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
            <a href="{{ route('blog.index') }}" class="hover:text-chestnut transition font-medium">
                <span>Blog</span>
            </a>
            <svg width="12" height="12" viewBox="0 0 20 20" class="text-gray-400 shrink-0 fill-current">
                <path d="M7.7,20c-0.3,0-0.5-0.1-0.7-0.3c-0.4-0.4-0.4-1.1,0-1.5l8.1-8.1L6.7,1.8c-0.4-0.4-0.4-1.1,0-1.5 c0.4-0.4,1.1-0.4,1.5,0l9.1,9.1c0.4,0.4,0.4,1.1,0,1.5l-8.8,8.9C8.2,19.9,7.9,20,7.7,20z"/>
            </svg>
            <a href="{{ route('blog.index', ['category' => $post->category]) }}" class="hover:text-chestnut transition font-medium">
                <span>{{ $post->category ?? 'Travel Guide' }}</span>
            </a>
            <svg width="12" height="12" viewBox="0 0 20 20" class="text-gray-400 shrink-0 fill-current">
                <path d="M7.7,20c-0.3,0-0.5-0.1-0.7-0.3c-0.4-0.4-0.4-1.1,0-1.5l8.1-8.1L6.7,1.8c-0.4-0.4-0.4-1.1,0-1.5 c0.4-0.4,1.1-0.4,1.5,0l9.1,9.1c0.4,0.4,0.4,1.1,0,1.5l-8.8,8.9C8.2,19.9,7.9,20,7.7,20z"/>
            </svg>
            <span class="text-gray-800 font-semibold truncate max-w-[280px] sm:max-w-none">{{ $post->title }}</span>
        </nav>
    </div>
</div>

<!-- ============================================================== -->
<!-- 2. MAIN BLOG DETAIL LAYOUT: 2 COLUMNS (CONTENT + SIDEBAR)      -->
<!-- ============================================================== -->
<section class="py-10 lg:py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <!-- LEFT COLUMN: ARTICLE MAIN CONTENT (~68%) -->
            <main class="lg:col-span-8">
                <article class="space-y-6">
                    <!-- Featured Image -->
                    <div class="rounded-3xl overflow-hidden shadow-sm bg-gray-100 aspect-[16/10] sm:aspect-[16/9]">
                        <img src="{{ $post->image_url }}" 
                             alt="{{ $post->title }}" 
                             class="w-full h-full object-cover">
                    </div>

                    <!-- Category Badge -->
                    <div>
                        <a href="{{ route('blog.index', ['category' => $post->category]) }}" 
                           class="inline-block text-xs font-extrabold uppercase tracking-widest text-[#28B5A4] hover:underline">
                            {{ $post->category ?? 'Travel Guide' }}
                        </a>
                    </div>

                    <!-- Article Title -->
                    <header>
                        <h1 class="text-2xl sm:text-4xl lg:text-[42px] font-black text-gray-900 tracking-tight leading-tight">
                            {{ $post->title }}
                        </h1>
                    </header>

                    <!-- Meta Information: Author & Date -->
                    <div class="flex items-center gap-3 text-xs sm:text-sm text-gray-400 font-medium pb-6 border-b border-gray-100">
                        <span class="text-gray-700 font-bold flex items-center gap-1.5">
                            <i class="fa-solid fa-user-circle text-chestnut text-sm"></i>
                            {{ $post->author_name ?? 'admin' }}
                        </span>
                        <span>•</span>
                        <span class="text-gray-500">
                            Updated on <time datetime="{{ $post->published_at ? $post->published_at->toDateString() : '' }}">{{ $post->formatted_date }}</time>
                        </span>
                        @if($post->views_count > 0)
                            <span>•</span>
                            <span class="text-gray-400 flex items-center gap-1">
                                <i class="fa-regular fa-eye text-xs"></i>
                                {{ number_format($post->views_count) }} lượt xem
                            </span>
                        @endif
                    </div>

                    <!-- Article Content Body -->
                    <div class="article-content text-gray-800 text-sm sm:text-base leading-relaxed space-y-5 pt-2">
                        {!! $post->content !!}
                    </div>

                    <!-- Article Share Bar -->
                    @php
                        $shareUrl = urlencode(request()->url());
                        $shareTitle = urlencode($post->title);
                    @endphp
                    <div class="pt-8 pb-4 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <span class="text-xs font-black uppercase tracking-wider text-gray-800">SHARE THIS ARTICLE:</span>
                        <div class="flex items-center gap-2">
                            <!-- Facebook -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" 
                               target="_blank" rel="noopener noreferrer" 
                               class="w-9 h-9 rounded-full bg-blue-600 hover:bg-blue-700 text-white flex items-center justify-center transition shadow-xs" 
                               title="Share on Facebook">
                                <i class="fa-brands fa-facebook-f text-xs"></i>
                            </a>
                            <!-- Twitter / X -->
                            <a href="https://twitter.com/intent/tweet?text={{ $shareTitle }}&url={{ $shareUrl }}" 
                               target="_blank" rel="noopener noreferrer" 
                               class="w-9 h-9 rounded-full bg-black hover:bg-gray-800 text-white flex items-center justify-center transition shadow-xs" 
                               title="Share on Twitter / X">
                                <i class="fa-brands fa-x-twitter text-xs"></i>
                            </a>
                            <!-- Pinterest -->
                            <a href="https://pinterest.com/pin/create/button/?url={{ $shareUrl }}&description={{ $shareTitle }}" 
                               target="_blank" rel="noopener noreferrer" 
                               class="w-9 h-9 rounded-full bg-red-600 hover:bg-red-700 text-white flex items-center justify-center transition shadow-xs" 
                               title="Pin on Pinterest">
                                <i class="fa-brands fa-pinterest-p text-xs"></i>
                            </a>
                            <!-- LinkedIn -->
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ $shareUrl }}&title={{ $shareTitle }}" 
                               target="_blank" rel="noopener noreferrer" 
                               class="w-9 h-9 rounded-full bg-[#0077b5] hover:bg-[#005e93] text-white flex items-center justify-center transition shadow-xs" 
                               title="Share on LinkedIn">
                                <i class="fa-brands fa-linkedin-in text-xs"></i>
                            </a>
                            <!-- WhatsApp -->
                            <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" 
                               target="_blank" rel="noopener noreferrer" 
                               class="w-9 h-9 rounded-full bg-[#25D366] hover:bg-[#1ebc57] text-white flex items-center justify-center transition shadow-xs" 
                               title="Share on WhatsApp">
                                <i class="fa-brands fa-whatsapp text-sm"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Tags Links -->
                    @if(!empty($post->tags) && is_array($post->tags))
                        <div class="py-4 border-t border-gray-100 flex flex-wrap items-center gap-2">
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider mr-1">Tagged In:</span>
                            @foreach($post->tags as $tag)
                                <a href="{{ route('blog.index', ['tag' => $tag]) }}" 
                                   class="text-xs font-medium bg-gray-100 hover:bg-emerald-50 hover:text-chestnut text-gray-700 px-3 py-1 rounded-full transition">
                                    {{ $tag }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <!-- Previous & Next Navigation -->
                    @if($prevPost || $nextPost)
                        <div class="py-6 border-y border-gray-100 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @if($prevPost)
                                <a href="{{ route('blog.show', $prevPost->slug) }}" class="group block p-4 rounded-2xl bg-gray-50 hover:bg-emerald-50/50 transition border border-gray-100">
                                    <span class="text-[11px] font-bold text-gray-400 group-hover:text-chestnut uppercase tracking-wider block mb-1">
                                        <i class="fa-solid fa-arrow-left text-[10px] mr-1"></i> Previous Article
                                    </span>
                                    <h4 class="text-sm font-bold text-gray-900 group-hover:text-chestnut line-clamp-1 transition">
                                        {{ $prevPost->title }}
                                    </h4>
                                </a>
                            @else
                                <div></div>
                            @endif

                            @if($nextPost)
                                <a href="{{ route('blog.show', $nextPost->slug) }}" class="group block p-4 rounded-2xl bg-gray-50 hover:bg-emerald-50/50 transition border border-gray-100 text-right sm:ml-auto w-full">
                                    <span class="text-[11px] font-bold text-gray-400 group-hover:text-chestnut uppercase tracking-wider block mb-1">
                                        Next Article <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i>
                                    </span>
                                    <h4 class="text-sm font-bold text-gray-900 group-hover:text-chestnut line-clamp-1 transition">
                                        {{ $nextPost->title }}
                                    </h4>
                                </a>
                            @endif
                        </div>
                    @endif

                    <!-- Related Articles (Exact match to chestnuttravel.net layout) -->
                    @if($relatedPosts->isNotEmpty())
                        <div class="pt-8">
                            <h2 class="text-xl sm:text-2xl font-black text-gray-900 mb-6">
                                Related Articles
                            </h2>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                @foreach($relatedPosts as $relPost)
                                    <div class="group flex flex-col">
                                        <div class="aspect-[16/10] rounded-2xl overflow-hidden mb-3 bg-gray-100 shadow-xs">
                                            <a href="{{ route('blog.show', $relPost->slug) }}" class="block w-full h-full">
                                                <img src="{{ $relPost->image_url }}" 
                                                     alt="{{ $relPost->title }}" 
                                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                                            </a>
                                        </div>
                                        <h3 class="text-sm font-extrabold text-gray-900 group-hover:text-chestnut transition line-clamp-2 leading-snug">
                                            <a href="{{ route('blog.show', $relPost->slug) }}">
                                                {{ $relPost->title }}
                                            </a>
                                        </h3>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Leave a Reply / Comments Area -->
                    <div id="comments" class="pt-10 mt-6 border-t border-gray-100">
                        <div class="bg-gray-50/70 rounded-3xl p-6 sm:p-8 border border-gray-200/80">
                            <h3 class="text-xl sm:text-2xl font-black text-gray-900 mb-2">Leave a Reply</h3>
                            <p class="text-xs text-gray-500 mb-6">
                                Your email address will not be published. Required fields are marked <span class="text-red-500">*</span>
                            </p>

                            <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Cảm ơn bạn đã gửi bình luận! Bình luận của bạn đang được kiểm duyệt.'); this.reset();" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="comment-text" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                        Comment <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="comment-text" name="comment" rows="5" required 
                                              placeholder="Write your thoughts here..." 
                                              class="w-full bg-white rounded-xl border border-gray-200 p-3 text-sm focus:border-chestnut focus:ring-1 focus:ring-chestnut transition"></textarea>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="author-name" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                            Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="author-name" name="author" required 
                                               placeholder="Your name" 
                                               class="w-full bg-white rounded-xl border border-gray-200 p-3 text-sm focus:border-chestnut focus:ring-1 focus:ring-chestnut transition">
                                    </div>
                                    <div>
                                        <label for="author-email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                            Email <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" id="author-email" name="email" required 
                                               placeholder="Your email" 
                                               class="w-full bg-white rounded-xl border border-gray-200 p-3 text-sm focus:border-chestnut focus:ring-1 focus:ring-chestnut transition">
                                    </div>
                                </div>

                                <div>
                                    <label for="author-website" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                        Website
                                    </label>
                                    <input type="url" id="author-website" name="url" 
                                           placeholder="https://example.com" 
                                           class="w-full bg-white rounded-xl border border-gray-200 p-3 text-sm focus:border-chestnut focus:ring-1 focus:ring-chestnut transition">
                                </div>

                                <div class="pt-2">
                                    <button type="submit" 
                                            class="bg-[#28B5A4] hover:bg-[#209C8D] text-white font-extrabold text-xs uppercase tracking-wider px-8 py-3.5 rounded-full transition shadow-md shadow-[#28B5A4]/20 active:scale-95 cursor-pointer">
                                        Post Comment
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </article>
            </main>

            <!-- RIGHT COLUMN: SIDEBAR (~32%) -->
            <aside class="lg:col-span-4 space-y-8">
                
                <!-- WIDGET 1: SEARCH WIDGET -->
                <div class="bg-gray-50/80 rounded-3xl p-6 border border-gray-200/80">
                    <form action="{{ route('blog.index') }}" method="GET" class="relative flex items-center">
                        <input type="text" name="s" placeholder="Search articles..." 
                               class="w-full bg-white rounded-2xl border border-gray-200 pl-4 pr-12 py-3 text-sm focus:border-chestnut focus:ring-1 focus:ring-chestnut transition outline-none">
                        <button type="submit" class="absolute right-2 w-9 h-9 rounded-xl bg-[#28B5A4] text-white flex items-center justify-center hover:bg-[#209C8D] transition" aria-label="Search">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </button>
                    </form>
                </div>

                <!-- WIDGET 2: DESTINATIONS WIDGET -->
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

                <!-- WIDGET 3: ACTIVITIES WIDGET -->
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

                <!-- WIDGET 4: FEATURED TRIPS (Exact match to chestnuttravel.net category-trips-widget) -->
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
                                    <!-- Image with Price Overlay & Discount Badge -->
                                    <div class="relative h-44 overflow-hidden bg-gray-100">
                                        <a href="{{ route('tour.show', $ftTour->slug) }}" class="block w-full h-full">
                                            <img src="{{ $ftImg }}" 
                                                 alt="{{ $ftTour->title }}" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                                        </a>
                                        @if($discountPct > 0)
                                            <div class="absolute top-3 left-3 bg-[#E48E45] text-white font-black text-[10px] px-2.5 py-1 rounded-full uppercase tracking-wider shadow-xs">
                                                {{ $discountPct }}% Off
                                            </div>
                                        @endif
                                        <div class="absolute bottom-3 right-3 bg-black/65 backdrop-blur-xs text-white text-xs font-black px-3 py-1.5 rounded-xl shadow-xs flex items-baseline gap-1.5">
                                            @if($discountPct > 0)
                                                <span class="line-through text-gray-400 font-normal text-[11px]">${{ number_format($ftTour->price, 0) }}</span>
                                            @endif
                                            <span>${{ number_format($ftPrice, 0) }}</span>
                                        </div>
                                    </div>

                                    <!-- Body -->
                                    <div class="p-4 bg-white">
                                        <h4 class="font-extrabold text-sm text-gray-900 group-hover:text-chestnut transition leading-snug line-clamp-2 mb-2">
                                            <a href="{{ route('tour.show', $ftTour->slug) }}">
                                                {{ $ftTour->title }}
                                            </a>
                                        </h4>
                                        <div class="flex items-center justify-between text-[11px] text-gray-400 font-medium pt-2 border-t border-gray-100">
                                            <span class="flex items-center gap-1 text-gray-600">
                                                <i class="fa-solid fa-location-dot text-chestnut text-[10px]"></i>
                                                {{ $ftTour->destination->name ?? 'Vietnam' }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <i class="fa-regular fa-clock text-[10px]"></i>
                                                {{ $ftTour->duration_days }}D{{ $ftTour->duration_nights }}N
                                            </span>
                                        </div>
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
