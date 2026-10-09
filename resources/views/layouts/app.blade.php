<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', option('site_name', 'Chestnut Travel') . ' - ' . option('site_tagline', 'Handling all your travel issues'))</title>
    <meta name="description" content="@yield('meta_description', 'Chestnut Travel - Trusted and comfortable authentic travel experiences in Vietnam. Explore the Ha Giang Loop, Sa Pa, Lan Ha Bay and Ninh Binh.')">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/x-icon" href="{{ option_image('site_favicon', asset('storage/site/favicon.png')) }}">
    <link rel="shortcut icon" href="{{ option_image('site_favicon', asset('storage/site/favicon.png')) }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CDN for 100% reliable zero-dependency rendering -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        chestnut: '#28B5A4', // Chestnut Travel brand teal
                        'chestnut-hover': '#209C8D',
                        'chestnut-dark': '#17786C',
                        'chestnut-orange': '#E48E45',
                        primary: '#28B5A4',
                        'primary-hover': '#209C8D',
                        'primary-dark': '#17786C',
                        secondary: '#E48E45',
                    }
                }
            }
        }
    </script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        :root {
            --primary: #28B5A4; /* Chestnut Travel brand teal */
            --primary-hover: #209C8D;
            --primary-dark: #17786C;
            --secondary: #E48E45; /* Secondary orange (badges, prices, arrows) */
            --secondary-hover: #D27B32;
            --dark: #1E2329;
            --dark-surface: #2B313A;
            --text-muted: #6B7280;
            --border-color: #E5E7EB;
            --bg-light: #F9FAFB;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1E2329;
            background-color: #ffffff;
            overflow-x: hidden;
        }

        .font-heading {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-serif-display {
            font-family: 'Playfair Display', serif;
        }

        /* Chestnut Primary Color Utilities */
        .bg-chestnut { background-color: var(--primary); }
        .bg-chestnut:hover { background-color: var(--primary-hover); }
        .text-chestnut { color: var(--primary); }
        .border-chestnut { border-color: var(--primary); }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c5c5c5; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #a0a0a0; }

        /* Dropdown Menu - Hover bridge and smooth transitions */
        .dropdown-menu {
            display: none;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.15s ease, transform 0.15s ease, visibility 0.15s ease;
            transform: translateY(4px);
        }

        /* Invisible bridge extending upwards into trigger button so hover is never lost */
        .dropdown-menu::before {
            content: '';
            position: absolute;
            top: -16px;
            left: 0;
            right: 0;
            height: 18px;
            background: transparent;
            z-index: 10;
        }

        /* Keep dropdown open whenever parent group OR the dropdown itself is hovered */
        .group:hover > .dropdown-menu,
        .dropdown-menu:hover {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
            pointer-events: auto !important;
            transform: translateY(0) !important;
        }

        /* Glassmorphism */
        .glass-header {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            transform: translateZ(0);
            will-change: transform;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
    @stack('styles')
</head>
<body class="antialiased flex flex-col min-h-screen">

    <!-- TOP BAR (Clean Light Harmonious Theme) -->
    <div class="bg-[#F8F9FA] text-gray-600 text-xs py-2 border-b border-gray-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap justify-between items-center gap-2">
            <!-- Left Contact Info & Socials -->
            <div class="flex items-center space-x-6">
                <!-- Social Icons -->
                <div class="flex items-center space-x-3">
                    @if(option('social_facebook'))
                    <a href="{{ option('social_facebook') }}" target="_blank" rel="noopener" class="text-gray-500 hover:text-blue-500 transition" title="Facebook">
                        <i class="fa-brands fa-facebook-f text-xs"></i>
                    </a>
                    @endif
                    @if(option('social_instagram'))
                    <a href="{{ option('social_instagram') }}" target="_blank" rel="noopener" class="text-gray-500 hover:text-pink-500 transition" title="Instagram">
                        <i class="fa-brands fa-instagram text-xs"></i>
                    </a>
                    @endif
                    @if(option('site_whatsapp_link') || option('site_whatsapp'))
                    <a href="{{ option('site_whatsapp_link', 'https://wa.me/' . preg_replace('/[^0-9]/', '', option('site_whatsapp', '84867216850'))) }}" target="_blank" rel="noopener" class="text-gray-500 hover:text-green-600 transition" title="WhatsApp">
                        <i class="fa-brands fa-whatsapp text-xs"></i>
                    </a>
                    @endif
                    @if(option('social_tripadvisor'))
                    <a href="{{ option('social_tripadvisor') }}" target="_blank" rel="noopener" class="text-gray-500 hover:text-emerald-600 transition" title="TripAdvisor">
                        <i class="fa-solid fa-feather-pointed text-xs"></i>
                    </a>
                    @endif
                    @if(option('social_tiktok'))
                    <a href="{{ option('social_tiktok') }}" target="_blank" rel="noopener" class="text-gray-500 hover:text-black transition" title="TikTok">
                        <i class="fa-brands fa-tiktok text-xs"></i>
                    </a>
                    @endif
                </div>

                <div class="hidden sm:flex items-center space-x-4 border-l border-gray-300 pl-4">
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', option('site_hotline', '+84867216850')) }}" class="hover:text-chestnut flex items-center gap-1.5 transition text-gray-700 font-medium">
                        <i class="fa-solid fa-phone text-chestnut text-[11px]"></i>
                        <span>{{ option('site_hotline', '+84 867 216 850') }}</span>
                    </a>
                    <a href="mailto:{{ option('site_email', 'info@chestnuttravel.net') }}" class="hover:text-chestnut flex items-center gap-1.5 transition text-gray-700 font-medium">
                        <i class="fa-solid fa-envelope text-chestnut text-[11px]"></i>
                        <span>{{ option('site_email', 'info@chestnuttravel.net') }}</span>
                    </a>
                </div>
            </div>

            <!-- Right Actions: Wishlist (Always available for both Guest & Auth), Booking Lookup & Auth Modal -->
            <div class="flex items-center space-x-4">
                <!-- Wishlist (always visible for guests and members, links to /wishlist) -->
                <a href="{{ route('wishlist') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-1.5 transition font-medium text-xs cursor-pointer group" title="Wishlist">
                    <i class="fa-regular fa-heart text-xs text-gray-500 group-hover:text-gray-900 transition"></i>
                    <span>Wishlist</span>
                    <span id="topbar-wishlist-count" class="bg-gray-800 text-white text-[10px] font-bold px-1.5 py-0.2 rounded-full hidden leading-none">0</span>
                </a>

                @auth
                    <!-- Booking lookup (signed-in users only) -->
                    <a href="{{ route('booking.lookup') }}" class="hover:text-chestnut text-gray-600 flex items-center gap-1 transition font-medium text-xs">
                        <i class="fa-solid fa-magnifying-glass text-[11px] text-gray-400"></i>
                        <span>Find my booking</span>
                    </a>

                    <!-- Logged in user dropdown -->
                    <div class="relative group">
                        <button class="flex items-center gap-2 text-gray-800 hover:text-chestnut transition font-semibold focus:outline-none py-1">
                            <span class="w-6 h-6 rounded-full bg-chestnut text-white flex items-center justify-center text-[11px] font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span class="max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                            <i class="fa-solid fa-chevron-down text-[9px] text-gray-400"></i>
                        </button>
                        <div class="dropdown-menu absolute right-0 top-full pt-1.5 w-48 z-50">
                            <div class="bg-white text-gray-800 rounded-xl shadow-xl py-2 border border-gray-100 ring-1 ring-black/5">
                                <div class="px-4 py-2 border-b border-gray-100 text-xs text-gray-500">
                                    Hello, <span class="font-bold text-gray-900 block truncate">{{ Auth::user()->name }}</span>
                                </div>
                                <a href="{{ route('my-account') }}" class="block px-4 py-2 hover:bg-orange-50 hover:text-chestnut transition text-xs flex items-center gap-2">
                                    <i class="fa-solid fa-ticket text-chestnut"></i> My bookings
                                </a>
                                <a href="{{ route('wishlist') }}" class="block px-4 py-2 hover:bg-gray-50 hover:text-gray-900 transition text-xs flex items-center gap-2 cursor-pointer">
                                    <i class="fa-regular fa-heart text-gray-500"></i> Wishlist
                                </a>
                                <a href="{{ route('booking.lookup') }}" class="block px-4 py-2 hover:bg-orange-50 hover:text-chestnut transition text-xs flex items-center gap-2">
                                    <i class="fa-solid fa-magnifying-glass text-gray-500"></i> Find my booking
                                </a>
                                <a href="{{ route('my-account') }}#profile" class="block px-4 py-2 hover:bg-orange-50 hover:text-chestnut transition text-xs flex items-center gap-2">
                                    <i class="fa-solid fa-user-gear text-gray-500"></i> Account settings
                                </a>
                                @if(Auth::user()->email === 'admin@chestnuttravel.net' || Auth::user()->email === 'admin@gmail.com')
                                    <a href="{{ url('/admin') }}" target="_blank" class="block px-4 py-2 hover:bg-amber-50 text-amber-700 transition text-xs flex items-center gap-2 font-semibold">
                                        <i class="fa-solid fa-shield-halved"></i> Admin panel
                                    </a>
                                @endif
                                <form action="{{ route('customer.logout') }}" method="POST" class="border-t border-gray-100 mt-1">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-red-50 text-red-600 transition text-xs flex items-center gap-2">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Guest: open auth modal (booking lookup hidden until signed in) -->
                    <button onclick="openAuthModal('login')" class="text-gray-700 hover:text-chestnut flex items-center gap-1.5 transition font-semibold">
                        <i class="fa-regular fa-user text-chestnut"></i>
                        <span>Sign in / Register</span>
                    </button>
                @endauth
            </div>
        </div>
    </div>


    <!-- MAIN STICKY HEADER -->
    <header class="sticky top-0 z-40 glass-header shadow-sm transition-all duration-300 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- LOGO -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    @if(option_image('site_logo'))
                        <img src="{{ option_image('site_logo') }}" alt="{{ option('site_name', 'Chestnut Travel') }}" class="h-10 sm:h-12 w-auto max-w-[220px] object-contain">
                    @else
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#28B5A4] to-[#209C8D] flex items-center justify-center text-white shadow-md shadow-teal-500/20 group-hover:scale-105 transition">
                            <i class="fa-solid fa-compass text-xl"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xl font-extrabold tracking-tight text-gray-900 leading-none">
                                {{ strtoupper(option('site_name', 'CHESTNUT TRAVEL')) }}
                            </span>
                            <span class="text-[10px] text-gray-500 uppercase tracking-widest font-semibold mt-1">{{ option('site_tagline', 'Vietnam Authentic Adventures') }}</span>
                        </div>
                    @endif
                </a>

                <!-- DESKTOP NAVIGATION (Dynamic from Menu Model or Default Fallback) -->
                @php
                    $headerMenu = \App\Models\Menu::getByCode('header');
                    $navDestinations = \App\Models\Destination::where('is_active', true)->orderBy('sort_order', 'asc')->get();
                    $navActivities = \App\Models\Activity::where('is_active', true)->get();
                @endphp

                <nav class="hidden lg:flex items-center space-x-1 font-semibold text-sm text-gray-700">
                    @if($headerMenu && !empty($headerMenu->items))
                        @foreach($headerMenu->items as $mItem)
                            @if(isset($mItem['is_active']) && !$mItem['is_active'])
                                @continue
                            @endif

                            @if(($mItem['type'] ?? 'link') === 'destinations_dropdown')
                                <!-- Destination Dropdown (Auto-loaded from Destinations Database) -->
                                <div class="relative group">
                                    <button class="px-3 py-2 rounded-lg hover:text-chestnut hover:bg-teal-50 transition flex items-center gap-1">
                                        <span>{{ $mItem['title'] ?? 'Destinations' }}</span>
                                        <i class="fa-solid fa-chevron-down text-[10px] text-gray-400 group-hover:rotate-180 transition"></i>
                                    </button>
                                    <div class="dropdown-menu absolute left-0 top-full pt-1.5 w-64 z-50">
                                        <div class="bg-white rounded-2xl shadow-2xl py-3 border border-gray-100 ring-1 ring-black/5 max-h-96 overflow-y-auto">
                                            <div class="px-4 py-1 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Top destinations</div>
                                            @foreach($navDestinations as $d)
                                                <a href="{{ route('home') }}?destination={{ $d->slug }}#tours-section" class="flex items-center justify-between px-4 py-2 hover:bg-teal-50 hover:text-chestnut transition">
                                                    <span class="flex items-center gap-2"><i class="fa-solid fa-location-dot text-[#28B5A4] text-xs"></i> {{ $d->name }}</span>
                                                    @if($loop->iteration <= 2)
                                                        <span class="text-[10px] bg-teal-100 text-[#28B5A4] px-2 py-0.5 rounded-full font-bold">Hot</span>
                                                    @endif
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            @elseif(($mItem['type'] ?? 'link') === 'activities_dropdown')
                                <!-- Activities Dropdown (Auto-loaded from Activities Database) -->
                                <div class="relative group">
                                    <button class="px-3 py-2 rounded-lg hover:text-chestnut hover:bg-teal-50 transition flex items-center gap-1">
                                        <span>{{ $mItem['title'] ?? 'Activities' }}</span>
                                        <i class="fa-solid fa-chevron-down text-[10px] text-gray-400 group-hover:rotate-180 transition"></i>
                                    </button>
                                    <div class="dropdown-menu absolute left-0 top-full pt-1.5 w-64 z-50">
                                        <div class="bg-white rounded-2xl shadow-2xl py-3 border border-gray-100 ring-1 ring-black/5 max-h-96 overflow-y-auto">
                                            <div class="px-4 py-1 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Travel activities</div>
                                            @foreach($navActivities as $act)
                                                <a href="{{ route('activities.show', $act->slug) }}" class="flex items-center justify-between px-4 py-2 hover:bg-teal-50 hover:text-chestnut transition">
                                                    <span class="flex items-center gap-2">
                                                        <i class="fa-solid fa-compass text-[#28B5A4] text-xs"></i>
                                                        {{ $act->name }}
                                                    </span>
                                                    @if($loop->first)
                                                        <span class="text-[10px] bg-teal-100 text-[#28B5A4] px-2 py-0.5 rounded-full font-bold">Hot</span>
                                                    @endif
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            @elseif(($mItem['type'] ?? 'link') === 'custom_dropdown' && !empty($mItem['children']))
                                @php
                                    $parentUrl = (!empty($mItem['url']) && $mItem['url'] !== '#') 
                                        ? $mItem['url'] 
                                        : (str_contains(strtolower($mItem['title'] ?? ''), 'combo') ? route('package.index') : ($mItem['children'][0]['url'] ?? '#'));
                                @endphp
                                <!-- Custom Dropdown -->
                                <div class="relative group">
                                    <a href="{{ $parentUrl }}" class="px-3 py-2 rounded-lg hover:text-chestnut hover:bg-teal-50 transition flex items-center gap-1.5 {{ request()->is(trim($parentUrl, '/')) || (str_contains(strtolower($mItem['title'] ?? ''), 'combo') && request()->routeIs('package.*')) ? 'text-chestnut bg-teal-50/50' : '' }}">
                                        <span>{{ $mItem['title'] }}</span>
                                        @if(!empty($mItem['badge']))
                                            <span class="text-[9px] bg-red-100 text-red-600 px-1.5 py-0.2 rounded-full font-bold uppercase">{{ $mItem['badge'] }}</span>
                                        @endif
                                        <i class="fa-solid fa-chevron-down text-[10px] text-gray-400 group-hover:rotate-180 transition"></i>
                                    </a>
                                    <div class="dropdown-menu absolute left-0 top-full pt-1.5 w-72 z-50">
                                        <div class="bg-white rounded-2xl shadow-2xl py-3 border border-gray-100 ring-1 ring-black/5">
                                            @foreach($mItem['children'] as $child)
                                                <a href="{{ $child['url'] ?? '#' }}" target="{{ $child['target'] ?? '_self' }}" class="block px-4 py-2 hover:bg-teal-50 hover:text-chestnut transition">
                                                    <div class="font-bold text-xs">{{ $child['title'] ?? '' }}</div>
                                                    @if(!empty($child['subtitle']))
                                                        <div class="text-[11px] text-gray-500">{{ $child['subtitle'] }}</div>
                                                    @endif
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            @else
                                <!-- Standard Link -->
                                <a href="{{ $mItem['url'] ?? '#' }}" target="{{ $mItem['target'] ?? '_self' }}"
                                   class="px-3 py-2 rounded-lg hover:text-chestnut hover:bg-teal-50 transition flex items-center gap-1.5 {{ request()->is(trim($mItem['url'] ?? '', '/')) ? 'text-chestnut bg-teal-50/50' : '' }}">
                                    <span>{{ $mItem['title'] ?? '' }}</span>
                                    @if(!empty($mItem['badge']))
                                        <span class="text-[9px] bg-red-500 text-white px-1.5 py-0.2 rounded-full font-bold uppercase">{{ $mItem['badge'] }}</span>
                                    @endif
                                </a>
                            @endif
                        @endforeach
                    @else
                        <!-- Fallback Static Nav if Menu is not configured yet -->
                        <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg text-chestnut hover:bg-teal-50 transition">Home</a>

                        <!-- Package Combo (Matching https://chestnuttravel.net/package/) -->
                        <div class="relative group">
                            <a href="{{ route('package.index') }}" class="px-3 py-2 rounded-lg hover:text-chestnut hover:bg-teal-50 transition flex items-center gap-1.5 {{ request()->routeIs('package.*') ? 'text-chestnut bg-teal-50/50' : '' }}">
                                <span>Package Combo</span>
                                <span class="text-[9px] bg-orange-100 text-orange-600 px-1.5 py-0.2 rounded-full font-bold uppercase">Save</span>
                                <i class="fa-solid fa-chevron-down text-[10px] text-gray-400 group-hover:rotate-180 transition"></i>
                            </a>
                            <div class="dropdown-menu absolute left-0 top-full pt-1.5 w-64 z-50">
                                <div class="bg-white rounded-2xl shadow-2xl py-3 border border-gray-100 ring-1 ring-black/5">
                                    <div class="px-4 py-1 text-[11px] font-bold text-gray-400 uppercase tracking-wider">All-inclusive combo packages</div>
                                    <a href="{{ route('package.index') }}" class="flex items-center justify-between px-4 py-2 hover:bg-teal-50 hover:text-chestnut transition">
                                        <span class="flex items-center gap-2"><i class="fa-solid fa-gift text-chestnut text-xs"></i> All package combos</span>
                                        <span class="text-[10px] bg-red-100 text-red-600 px-2 py-0.5 rounded-full font-bold">Hot</span>
                                    </a>
                                    <a href="{{ route('package.index', ['region' => 'north']) }}" class="flex items-center justify-between px-4 py-2 hover:bg-teal-50 hover:text-chestnut transition">
                                        <span class="flex items-center gap-2"><i class="fa-solid fa-mountain text-[#28B5A4] text-xs"></i> Northern Vietnam Combo</span>
                                    </a>
                                    <a href="{{ route('package.index', ['region' => 'central']) }}" class="flex items-center justify-between px-4 py-2 hover:bg-teal-50 hover:text-chestnut transition">
                                        <span class="flex items-center gap-2"><i class="fa-solid fa-umbrella-beach text-[#28B5A4] text-xs"></i> Middle Vietnam Combo</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('customized-tour') }}" class="px-3 py-2 rounded-lg hover:text-chestnut hover:bg-teal-50 transition flex items-center gap-1">
                            <span>Customize Tour</span>
                            <span class="text-[9px] bg-red-500 text-white px-1.5 py-0.2 rounded-full font-bold uppercase">Hot</span>
                        </a>
                        <a href="{{ route('blog.index') }}" class="px-3 py-2 rounded-lg hover:text-chestnut hover:bg-teal-50 transition">Blog & Tips</a>
                        <a href="#reviews-section" class="px-3 py-2 rounded-lg hover:text-chestnut hover:bg-teal-50 transition">Reviews</a>
                        <a href="#contact-footer" class="px-3 py-2 rounded-lg hover:text-chestnut hover:bg-teal-50 transition">Contact</a>
                    @endif
                </nav>

                <!-- HEADER RIGHT BUTTONS -->
                <div class="flex items-center space-x-3">
                    <!-- Quick Search Button -->
                    <button onclick="toggleSearchModal()" class="w-10 h-10 rounded-full border border-gray-200 text-gray-600 hover:text-chestnut hover:border-chestnut transition flex items-center justify-center">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>

                    <!-- Wishlist quick button (links to /wishlist) -->
                    <a href="{{ route('wishlist') }}" class="w-10 h-10 rounded-full border border-gray-200 text-gray-600 hover:text-gray-900 hover:border-gray-400 transition flex items-center justify-center relative cursor-pointer group" title="Wishlist">
                        <i class="fa-regular fa-heart text-base text-gray-500 group-hover:text-gray-900 transition"></i>
                        <span id="nav-wishlist-badge" class="absolute -top-1 -right-1 bg-gray-800 text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center hidden leading-none">0</span>
                    </a>

                    <!-- CTA Customize Tour (links to /customized-tour) -->
                    <a href="{{ route('customized-tour') }}" class="bg-[#28B5A4] hover:bg-[#209C8D] text-white px-5 py-2.5 rounded-full text-xs font-bold shadow-md shadow-teal-500/20 transition transform active:scale-95 flex items-center gap-2">
                        <i class="fa-solid fa-sliders"></i>
                        <span>Customize Tour</span>
                    </a>

                    <!-- Mobile Menu Hamburger -->
                    <button onclick="toggleMobileMenu()" class="lg:hidden w-10 h-10 rounded-lg border border-gray-200 text-gray-700 flex items-center justify-center focus:outline-none">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- MOBILE MENU DRAWER -->
        <div id="mobile-menu" class="hidden lg:hidden bg-white border-b border-gray-200 px-4 pt-2 pb-6 space-y-2">
            <a href="{{ route('home') }}" class="block px-3 py-2 text-base font-semibold text-chestnut">Home</a>
            <a href="{{ route('customized-tour') }}" class="block px-3 py-2 text-base font-semibold text-gray-800 hover:text-chestnut flex items-center justify-between">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-[#28B5A4]"></i>
                    <span>Customize Tour</span>
                </span>
                <span class="text-[10px] bg-red-100 text-red-600 px-2 py-0.5 rounded-full font-bold uppercase">Hot</span>
            </a>

            <!-- Package combos in mobile -->
            <a href="{{ route('package.index') }}" class="block px-3 py-2 text-base font-semibold text-gray-800 hover:text-chestnut flex items-center justify-between">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-gift text-orange-500"></i>
                    <span>Package Combos</span>
                </span>
                <span class="text-[10px] bg-red-100 text-red-600 px-2 py-0.5 rounded-full font-bold uppercase">HOT</span>
            </a>
            
            <!-- Destinations in Mobile -->
            <div class="border-t border-gray-100 my-1 pt-2">
                <p class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Destinations</p>
                @foreach(($navDestinations ?? \App\Models\Destination::where('is_active', true)->orderBy('sort_order', 'asc')->get()) as $d)
                    <a href="{{ route('home') }}?destination={{ $d->slug }}#tours-section" class="block px-4 py-1.5 text-sm text-gray-700 hover:text-chestnut">{{ $d->name }}</a>
                @endforeach
            </div>

            <!-- Activities in Mobile -->
            <div class="border-t border-gray-100 my-1 pt-2">
                <p class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Activities</p>
                @foreach(($navActivities ?? \App\Models\Activity::where('is_active', true)->get()) as $act)
                    <a href="{{ route('activities.show', $act->slug) }}" class="block px-4 py-1.5 text-sm text-gray-700 hover:text-chestnut">{{ $act->name }}</a>
                @endforeach
            </div>

            <!-- Blog & Tips in Mobile -->
            <div class="border-t border-gray-100 my-1 pt-2">
                <a href="{{ route('blog.index') }}" class="block px-3 py-1.5 text-sm font-semibold text-gray-700 hover:text-chestnut flex items-center justify-between">
                    <span>Blog & Tips</span>
                    <i class="fa-solid fa-arrow-right text-xs text-gray-400"></i>
                </a>
            </div>

            <div class="border-t border-gray-100 my-1 pt-2">
                <!-- Wishlist (all users) -->
                <a href="{{ route('wishlist') }}" class="block px-3 py-2 text-sm font-semibold text-gray-700 hover:text-gray-900 flex items-center gap-2">
                    <i class="fa-regular fa-heart text-gray-500"></i> Wishlist
                </a>

                @auth
                    <a href="{{ route('booking.lookup') }}" class="block px-3 py-2 text-sm font-semibold text-gray-700 flex items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass text-gray-400"></i> Find my booking
                    </a>
                    <a href="{{ route('my-account') }}" class="block px-3 py-2 text-sm font-semibold text-chestnut">My account</a>
                @else
                    <button onclick="openAuthModal('login')" class="w-full text-left px-3 py-2 text-sm font-semibold text-chestnut">Sign in / Register</button>
                @endauth
            </div>
        </div>
    </header>

    <!-- FLASH MESSAGES -->
    @if(session('success'))
        <div id="flash-alert" class="bg-emerald-600 text-white text-sm py-3 px-4 shadow-lg fixed bottom-6 right-6 z-50 rounded-xl flex items-center gap-3 animate-bounce">
            <i class="fa-solid fa-circle-check text-lg"></i>
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('flash-alert').remove()" class="ml-2 text-white/80 hover:text-white">✕</button>
        </div>
    @endif
    @if(session('info'))
        <div id="flash-alert" class="bg-blue-600 text-white text-sm py-3 px-4 shadow-lg fixed bottom-6 right-6 z-50 rounded-xl flex items-center gap-3">
            <i class="fa-solid fa-circle-info text-lg"></i>
            <span>{{ session('info') }}</span>
            <button onclick="document.getElementById('flash-alert').remove()" class="ml-2 text-white/80 hover:text-white">✕</button>
        </div>
    @endif

    @if($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                showToast(@json($errors->first()), 'error', 7000);
            });
        </script>
    @endif

    <!-- MAIN CONTENT -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- FOOTER (EXACT MATCH TO CHESTNUTTRAVEL.NET) -->
    <footer id="contact-footer" class="site-footer bg-[#26786e] text-white pt-16 border-t border-[#1e5f57]" itemtype="https://schema.org/WPFooter" itemscope>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-10 pb-14">
                
                <!-- Col 1: Contact Info -->
                <div class="space-y-4">
                    <h3 class="text-white font-bold text-lg tracking-tight mb-4">Contact Info</h3>
                    <div class="contact-info text-xs sm:text-sm text-white/90 space-y-3">
                        <p class="leading-relaxed text-white/85">Open from 9 AM to 10 PM every day.</p>
                        
                        <ul class="space-y-2.5">
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-phone text-white/80 text-xs w-4"></i>
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', option('site_hotline', '+84 867 216 850')) }}" class="hover:text-white/80 transition font-medium">
                                    {{ option('site_hotline', '+84 867 216 850') }}
                                </a>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <i class="fa-solid fa-envelope text-white/80 text-xs w-4"></i>
                                <a href="mailto:{{ option('site_email', 'info@chestnuttravel.net') }}" class="hover:text-white/80 transition">
                                    {{ option('site_email', 'info@chestnuttravel.net') }}
                                </a>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <i class="fa-solid fa-location-dot text-white/80 text-xs w-4 mt-0.5"></i>
                                <span class="leading-snug">
                                    {{ option('site_address', '95h Ly Nam De St, Cua Dong, Hoan Kiem, Hanoi, Vietnam') }}
                                </span>
                            </li>
                        </ul>

                        <!-- Social Networks -->
                        <ul class="flex items-center gap-2.5 pt-2">
                            <li>
                                <a target="_blank" rel="noopener noreferrer" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', option('site_whatsapp', '84867216850')) }}" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white hover:text-[#26786e] text-white flex items-center justify-center transition-all duration-300" title="WhatsApp">
                                    <i class="fa-brands fa-whatsapp text-sm"></i>
                                </a>
                            </li>
                            <li>
                                <a target="_blank" rel="noopener noreferrer" href="{{ option('tripadvisor_url', 'https://www.tripadvisor.com.vn/Attraction_Review-g293924-d25178538-Reviews-Chestnut_Travel-Hanoi.html') }}" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white hover:text-[#26786e] text-white flex items-center justify-center transition-all duration-300" title="TripAdvisor">
                                    <i class="fa-solid fa-feather text-xs"></i>
                                </a>
                            </li>
                            <li>
                                <a target="_blank" rel="noopener noreferrer" href="{{ option('instagram_url', 'https://www.instagram.com/chestnut.travel/') }}" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white hover:text-[#26786e] text-white flex items-center justify-center transition-all duration-300" title="Instagram">
                                    <i class="fa-brands fa-instagram text-xs"></i>
                                </a>
                            </li>
                        </ul>

                        <!-- Company & Policy Links -->
                        <div class="pt-4 border-t border-white/15 space-y-1.5 text-xs text-white/80">
                            <div><a href="{{ route('home') }}#tours-section" class="hover:text-white hover:underline transition">Cancelation Policies</a></div>
                            <div><a href="{{ route('home') }}#tours-section" class="hover:text-white hover:underline transition">Data Protection Policies</a></div>
                            <div><a href="{{ route('home') }}#reviews-section" class="hover:text-white hover:underline transition">About Us</a></div>
                            <div><a href="{{ route('home') }}#tours-section" class="hover:text-white hover:underline transition">Affiliate Program</a></div>
                        </div>
                    </div>
                </div>

                <!-- Col 2: Destinations -->
                <div>
                    <h3 class="text-white font-bold text-lg tracking-tight mb-4">Destinations</h3>
                    <ul class="space-y-2.5 text-xs sm:text-sm text-white/85">
                        @php
                            $footerDestinations = ($navDestinations ?? \App\Models\Destination::where('is_active', true)->orderBy('sort_order', 'asc')->get())->take(6);
                        @endphp
                        @forelse($footerDestinations as $dest)
                            <li>
                                <a href="{{ route('home') }}?destination={{ $dest->slug }}#tours-section" class="hover:text-white hover:underline transition">
                                    {{ $dest->name }}
                                </a>
                            </li>
                        @empty
                            <li><a href="{{ route('home') }}#tours-section" class="hover:text-white hover:underline transition">Vietnam Tours</a></li>
                        @endforelse
                    </ul>
                </div>

                <!-- Col 3: Activities -->
                <div>
                    <h3 class="text-white font-bold text-lg tracking-tight mb-4">Activities</h3>
                    <ul class="space-y-2.5 text-xs sm:text-sm text-white/85">
                        @php
                            $footerActivities = ($navActivities ?? \App\Models\Activity::where('is_active', true)->get())->take(6);
                        @endphp
                        @forelse($footerActivities as $act)
                            <li>
                                <a href="{{ route('activities.show', $act->slug) }}" class="hover:text-white hover:underline transition">
                                    {{ $act->name }}
                                </a>
                            </li>
                        @empty
                            <li><a href="{{ route('home') }}#tours-section" class="hover:text-white hover:underline transition">All activities</a></li>
                        @endforelse
                    </ul>
                </div>

                <!-- Col 4: Trip Types -->
                <div>
                    <h3 class="text-white font-bold text-lg tracking-tight mb-4">Trip Types</h3>
                    <ul class="space-y-2.5 text-xs sm:text-sm text-white/85">
                        <li><a href="{{ route('package.index') }}" class="hover:text-white hover:underline transition font-bold text-orange-300 flex items-center gap-1.5"><i class="fa-solid fa-gift text-xs"></i> All-inclusive Combo Tours</a></li>
                        <li><a href="{{ route('home') }}?s=Budget#tours-section" class="hover:text-white hover:underline transition">Budget Tours</a></li>
                        <li><a href="{{ route('home') }}?s=Cultural#tours-section" class="hover:text-white hover:underline transition">Local Culture</a></li>
                        <li><a href="{{ route('home') }}?s=Child-friendly#tours-section" class="hover:text-white hover:underline transition">Family Friendly</a></li>
                        <li><a href="{{ route('home') }}?s=Adventure#tours-section" class="hover:text-white hover:underline transition">Adventure & Discovery</a></li>
                    </ul>
                </div>

            </div>

            <!-- Bottom Copyright & Secured Payment (Matching chestnuttravel.net footer-b) -->
            <div class="border-t border-white/15 py-6 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-white/85">
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-1.5 text-center md:text-left">
                    <span>&copy; Copyright {{ date('Y') }} <a href="{{ route('home') }}" class="font-semibold text-white hover:underline">{{ option('site_name', 'Chestnut Travel') }}</a>.</span>
                    <span class="text-white/70">Developed by <a href="https://chestnuttravel.net/" rel="nofollow" target="_blank" class="hover:underline text-white">Chestnut Travel.</a></span>
                    <span class="mx-1 text-white/40">•</span>
                    <a href="#" class="privacy-policy-link hover:underline text-white/90">Privacy Policy</a>
                    @auth
                        <span class="mx-1 text-white/40">•</span>
                        <a href="{{ route('booking.lookup') }}" class="hover:underline text-white/90">Find my booking</a>
                    @endauth
                </div>

                <div class="payments-showcase flex items-center gap-2">
                    <span class="font-medium text-white/90">Secure payment:</span>
                    <img width="196" height="26" src="{{ option_image('footer_payment_image', asset('images/footer-payment.png')) }}" class="attachment-full size-full inline-block" alt="Secured Payment" decoding="async">
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating Back to Top Button (Chestnut Travel Style) -->
    <button id="back-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed bottom-6 right-6 z-40 w-11 h-11 rounded-full bg-[#26786e] text-white shadow-xl hover:bg-[#209C8D] transition-all duration-300 items-center justify-center hidden opacity-0 translate-y-2 cursor-pointer border border-white/20 active:scale-95" aria-label="Back to top" title="Back to top">
        <i class="fa-solid fa-chevron-up text-sm"></i>
    </button>

    <script>
        (function() {
            const btn = document.getElementById('back-to-top');
            if (!btn) return;
            let isVisible = false;
            let ticking = false;

            function updateBackToTop() {
                const shouldShow = window.scrollY > 400;
                if (shouldShow !== isVisible) {
                    isVisible = shouldShow;
                    if (isVisible) {
                        btn.classList.remove('hidden');
                        requestAnimationFrame(() => {
                            btn.classList.remove('opacity-0', 'translate-y-2');
                            btn.classList.add('opacity-100', 'translate-y-0', 'flex');
                        });
                    } else {
                        btn.classList.add('opacity-0', 'translate-y-2');
                        btn.classList.remove('opacity-100', 'translate-y-0');
                        setTimeout(() => {
                            if (!isVisible) btn.classList.add('hidden');
                        }, 300);
                    }
                }
                ticking = false;
            }

            window.addEventListener('scroll', function() {
                if (!ticking) {
                    requestAnimationFrame(updateBackToTop);
                    ticking = true;
                }
            }, { passive: true });
        })();
    </script>

    <!-- ========================================== -->
    <!-- AUTH MODAL (Sign in / Register)          -->
    <!-- ========================================== -->
    <div id="auth-modal" class="fixed inset-0 z-50 hidden bg-black/70 flex items-center justify-center p-4 overscroll-contain">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden relative animate-fadeIn" onclick="event.stopPropagation()">
            <!-- Close Button -->
            <button onclick="closeAuthModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>

            <!-- Modal Header / Tabs -->
            <div class="bg-gray-50 px-6 pt-6 pb-0 border-b border-gray-100 text-center">
                <div class="w-12 h-12 rounded-xl bg-orange-100 text-chestnut mx-auto flex items-center justify-center text-xl mb-3">
                    <i class="fa-solid fa-user-circle"></i>
                </div>
                <h3 class="text-xl font-extrabold text-gray-900" id="auth-modal-title">Chestnut Travel Account</h3>
                <p class="text-xs text-gray-500 mt-1 mb-4">Sign in to track your bookings and get exclusive offers</p>

                <!-- Tab switcher -->
                <div id="auth-modal-tabs" class="flex border-b border-gray-200">
                    <button id="tab-btn-login" onclick="switchAuthTab('login')" class="flex-1 py-2.5 font-bold text-xs border-b-2 border-chestnut text-chestnut transition">
                        SIGN IN
                    </button>
                    <button id="tab-btn-register" onclick="switchAuthTab('register')" class="flex-1 py-2.5 font-bold text-xs border-b-2 border-transparent text-gray-500 hover:text-gray-900 transition">
                        CREATE ACCOUNT
                    </button>
                </div>
            </div>

            <!-- Tab Content: LOGIN -->
            <div id="tab-content-login" class="p-6">
                <!-- Login Success State -->
                <div id="login-success" class="hidden text-center py-4 animate-fadeIn">
                    <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3.5 text-2xl shadow-lg shadow-emerald-500/20">
                        <i class="fa-solid fa-circle-check text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-black text-gray-900 mb-1">Signed In Successfully!</h3>
                    <p class="text-xs text-gray-600 leading-relaxed mb-4">
                        Welcome back to Chestnut Travel, <strong id="login-success-name" class="text-gray-900 font-bold">traveler</strong>.
                    </p>
                    <div class="flex items-center gap-2 bg-emerald-50 text-emerald-700 px-4 py-2.5 rounded-xl text-xs font-bold border border-emerald-200 justify-center">
                        <i class="fa-solid fa-circle-notch fa-spin text-sm"></i>
                        <span>Loading your account...</span>
                    </div>
                </div>

                <form id="form-login" onsubmit="handleAuthSubmit(event, '{{ route('customer.login') }}', 'login')" novalidate class="space-y-4">
                    @csrf
                    <div id="login-error" class="hidden bg-red-50 text-red-600 text-xs p-3 rounded-lg border border-red-200"></div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email or phone number</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i class="fa-regular fa-envelope text-xs"></i></span>
                            <input type="text" name="email" required data-required-message="Please enter your email or phone number." autocomplete="username" placeholder="name@example.com or phone number" class="w-full pl-9 pr-3 py-2.5 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-chestnut focus:ring-1 focus:ring-chestnut transition">
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label class="block text-xs font-bold text-gray-700 uppercase">Password</label>
                            <a href="#" onclick="event.preventDefault(); showToast('Please contact our hotline {{ option('site_hotline', '+84 867 216 850') }} to quickly reset your password.', 'info')" class="text-[11px] text-chestnut hover:underline font-medium">Forgot password?</a>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><i class="fa-solid fa-lock text-xs"></i></span>
                            <input type="password" name="password" required data-required-message="Please enter your password." autocomplete="current-password" placeholder="Enter your password..." class="w-full pl-9 pr-3 py-2.5 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-chestnut focus:ring-1 focus:ring-chestnut transition">
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-chestnut border-gray-300 rounded focus:ring-chestnut">
                        <label for="remember" class="ml-2 text-xs text-gray-600">Remember me</label>
                    </div>

                    <button type="submit" id="btn-login-submit" class="w-full bg-chestnut hover:bg-orange-600 text-white font-bold py-2.5 rounded-xl text-xs shadow-md shadow-orange-500/20 transition flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-arrow-right-to-bracket text-xs"></i>
                        <span id="btn-login-text">Sign in</span>
                    </button>
                </form>
            </div>

            <!-- Tab Content: REGISTER -->
            <div id="tab-content-register" class="p-6 hidden">
                <!-- Register Success State -->
                <div id="register-success" class="hidden text-center py-4 animate-fadeIn">
                    <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3.5 text-2xl shadow-lg shadow-emerald-500/20 animate-bounce">
                        <i class="fa-solid fa-circle-check text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-black text-gray-900 mb-1">🎉 Registration Successful!</h3>
                    <p class="text-xs text-gray-600 leading-relaxed mb-3">
                        Welcome to Chestnut Travel, <strong id="register-success-name" class="text-gray-900 font-bold">traveler</strong>!<br>
                        You have been <span class="text-emerald-700 font-bold">signed in automatically</span> and we have <span class="text-emerald-700 font-bold">sent a welcome email</span> to:
                    </p>
                    <div class="bg-gray-50 border border-gray-200 rounded-xl py-2 px-3 mb-4 inline-block max-w-full">
                        <span id="register-success-email" class="font-mono text-xs text-emerald-800 font-bold flex items-center justify-center gap-1.5 break-all">
                            <i class="fa-regular fa-envelope text-emerald-600"></i> user@email.com
                        </span>
                    </div>
                    <div class="flex items-center gap-2 bg-emerald-50 text-emerald-700 px-4 py-2.5 rounded-xl text-xs font-bold border border-emerald-200 justify-center">
                        <i class="fa-solid fa-circle-notch fa-spin text-sm"></i>
                        <span>Taking you to your account in a moment...</span>
                    </div>
                </div>

                <form id="form-register" onsubmit="handleAuthSubmit(event, '{{ route('customer.register') }}', 'register')" novalidate class="space-y-3">
                    @csrf
                    <div id="register-error" class="hidden bg-red-50 text-red-600 text-xs p-3 rounded-lg border border-red-200"></div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Your full name</label>
                        <input type="text" name="name" required data-required-message="Please enter your full name." autocomplete="name" placeholder="e.g. John Smith" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-chestnut focus:ring-1 focus:ring-chestnut transition">
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email</label>
                            <input type="email" name="email" required data-required-message="Please enter your email address." autocomplete="email" placeholder="name@email.com" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-chestnut focus:ring-1 focus:ring-chestnut transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Phone number</label>
                            <input type="tel" name="phone" placeholder="0987654321" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-chestnut focus:ring-1 focus:ring-chestnut transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Password (min. 6 characters)</label>
                        <input type="password" name="password" required minlength="6" data-required-message="Please create a password." autocomplete="new-password" placeholder="Create a secure password..." class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-chestnut focus:ring-1 focus:ring-chestnut transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Confirm password</label>
                        <input type="password" name="password_confirmation" required data-match="password" data-required-message="Please confirm your password." autocomplete="new-password" placeholder="Re-enter your password..." class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-chestnut focus:ring-1 focus:ring-chestnut transition">
                    </div>

                    <button type="submit" id="btn-register-submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-xl text-xs shadow-md shadow-emerald-600/20 transition flex items-center justify-center gap-2 mt-2 cursor-pointer">
                        <i class="fa-solid fa-user-plus text-xs"></i>
                        <span id="btn-register-text">Create account</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- QUICK BOOKING MODAL (for both guests and members) -->
    <!-- ========================================== -->
    <!-- ========================================== -->
    <!-- ADVANCED 4-STEP TOUR BOOKING & CHECKOUT MODAL -->
    <!-- ========================================== -->
    <div id="booking-modal" class="fixed inset-0 z-50 hidden bg-black/75 flex items-center justify-center p-3 sm:p-4 overflow-y-auto overscroll-contain">
        <div class="bg-white rounded-3xl shadow-2xl max-w-3xl w-full overflow-hidden relative animate-fadeIn my-6 border border-stone-200" onclick="event.stopPropagation()">
            <!-- Close Button -->
            <button onclick="closeQuickBookingModal()" class="absolute top-4 right-4 text-stone-400 hover:text-stone-700 w-8 h-8 rounded-full bg-stone-100 hover:bg-stone-200 flex items-center justify-center transition z-20 cursor-pointer">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>

            <!-- Modal Header with Tour Info & Step Stepper -->
            <div class="bg-[#181C20] text-white p-5 sm:p-6 border-b border-white/10">
                <div class="flex items-center gap-2 mb-2">
                    <span class="inline-block bg-chestnut text-white text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full tracking-wider">CHESTNUT BOOKING ENGINE</span>
                    <span class="text-xs text-stone-400 flex items-center gap-1"><i class="fa-solid fa-shield-halved text-emerald-400"></i> Best price guaranteed</span>
                </div>
                <h3 class="text-base sm:text-xl font-black text-white line-clamp-1" id="modal-tour-title">Book Your Tour</h3>
                
                <!-- Stepper Tabs -->
                <div class="grid grid-cols-4 gap-2 mt-5 text-[11px] font-bold">
                    <button type="button" onclick="switchBookingStep(1)" id="step-tab-1" class="step-tab flex items-center gap-1.5 py-2 px-2.5 rounded-xl border border-chestnut bg-chestnut/20 text-white transition text-left cursor-pointer">
                        <span class="w-5 h-5 rounded-full bg-chestnut text-white flex items-center justify-center text-[10px] shrink-0 font-mono">1</span>
                        <span class="hidden sm:inline truncate">1. Date & Package</span>
                    </button>
                    <button type="button" onclick="switchBookingStep(2)" id="step-tab-2" class="step-tab flex items-center gap-1.5 py-2 px-2.5 rounded-xl border border-white/10 bg-white/5 text-stone-400 transition text-left cursor-pointer">
                        <span class="w-5 h-5 rounded-full bg-white/10 text-stone-300 flex items-center justify-center text-[10px] shrink-0 font-mono">2</span>
                        <span class="hidden sm:inline truncate">2. Guests & Extras</span>
                    </button>
                    <button type="button" onclick="switchBookingStep(3)" id="step-tab-3" class="step-tab flex items-center gap-1.5 py-2 px-2.5 rounded-xl border border-white/10 bg-white/5 text-stone-400 transition text-left cursor-pointer">
                        <span class="w-5 h-5 rounded-full bg-white/10 text-stone-300 flex items-center justify-center text-[10px] shrink-0 font-mono">3</span>
                        <span class="hidden sm:inline truncate">3. Your Details</span>
                    </button>
                    <button type="button" onclick="switchBookingStep(4)" id="step-tab-4" class="step-tab flex items-center gap-1.5 py-2 px-2.5 rounded-xl border border-white/10 bg-white/5 text-stone-400 transition text-left cursor-pointer">
                        <span class="w-5 h-5 rounded-full bg-white/10 text-stone-300 flex items-center justify-center text-[10px] shrink-0 font-mono">4</span>
                        <span class="hidden sm:inline truncate">4. Payment</span>
                    </button>
                </div>
            </div>

            <!-- Booking Form -->
            <form id="form-quick-booking" onsubmit="handleBookingSubmit(event)" novalidate class="p-5 sm:p-7 space-y-5">
                @csrf
                <input type="hidden" name="tour_id" id="modal-tour-id" value="">
                <input type="hidden" name="package_price" id="modal-package-price" value="199">
                <input type="hidden" name="package_option" id="modal-package-option" value="Easy Rider (With local driver)">
                <input type="hidden" name="extra_services" id="modal-extra-services-json" value="[]">

                <div id="booking-error" class="hidden bg-red-50 text-red-600 text-xs p-3 rounded-xl border border-red-200"></div>

                <!-- STEP 1: DATE & PACKAGE -->
                <div id="step-content-1" class="step-content space-y-4">
                    <div class="bg-orange-50/70 border border-orange-200/80 rounded-2xl p-3.5 flex items-start gap-2.5 text-xs text-stone-700">
                        <i class="fa-solid fa-circle-info text-chestnut text-sm mt-0.5"></i>
                        <div>
                            <span class="font-bold text-gray-900">Daily departures from Hanoi & Ha Giang!</span> Choose your departure date and experience type.
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-800 uppercase mb-1.5">
                            <i class="fa-regular fa-calendar text-chestnut mr-1"></i> Departure date *
                        </label>
                        <input type="date" name="departure_date" id="modal-date" required data-required-message="Please choose your departure date." min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d', strtotime('+2 days')) }}" onchange="calculateBookingTotal()" class="w-full px-3.5 py-2.5 border border-stone-300 rounded-xl text-xs focus:outline-none focus:border-chestnut transition font-medium">
                        <input type="hidden" name="departure_time" id="modal-time" value="">
                    </div>

                    <!-- Package Options -->
                    <div>
                        <label class="block text-xs font-bold text-gray-800 uppercase mb-2">Choose your package:</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="modal-package-container">
                            <label class="package-option-card flex items-start gap-3 p-3.5 rounded-2xl border-2 border-chestnut bg-orange-50/40 cursor-pointer transition" onclick="selectModalPackage('Easy Rider (With local driver)', currentTourPrice, this)">
                                <input type="radio" name="modal_pkg_radio" checked class="mt-1 text-chestnut focus:ring-chestnut">
                                <div class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs font-extrabold text-gray-900">Easy Rider (With driver)</span>
                                        <span class="text-xs font-black text-chestnut" id="modal-pkg-price-1">$199</span>
                                    </div>
                                    <p class="text-[11px] text-gray-500 mt-0.5">An experienced local driver rides you safely throughout the journey.</p>
                                </div>
                            </label>

                            <label class="package-option-card flex items-start gap-3 p-3.5 rounded-2xl border-2 border-stone-200 hover:border-chestnut bg-white cursor-pointer transition" onclick="selectModalPackage('Self-Drive (Ride your own motorbike)', Math.max(99, currentTourPrice - 50), this)">
                                <input type="radio" name="modal_pkg_radio" class="mt-1 text-chestnut focus:ring-chestnut">
                                <div class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs font-extrabold text-gray-900">Self-Drive (Ride yourself)</span>
                                        <span class="text-xs font-black text-chestnut" id="modal-pkg-price-2">$149</span>
                                    </div>
                                    <p class="text-[11px] text-gray-500 mt-0.5">For riders with an international licence and experience on steep mountain passes.</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="button" onclick="switchBookingStep(2)" class="px-6 py-2.5 bg-chestnut hover:bg-orange-600 text-white text-xs font-extrabold rounded-xl transition flex items-center gap-1.5 cursor-pointer">
                            <span>Next: Guests & Extras</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- STEP 2: TRAVELERS & EXTRA SERVICES -->
                <div id="step-content-2" class="step-content hidden space-y-4">
                    <!-- Passengers Count -->
                    <div>
                        <label class="block text-xs font-bold text-gray-800 uppercase mb-2">Number of travelers:</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-stone-50 p-4 rounded-2xl border border-stone-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-xs font-extrabold text-gray-900 block">Adults (age 10+)</span>
                                    <span class="text-[10px] text-gray-500" id="modal-adult-rate-label">$199 / person</span>
                                </div>
                                <div class="flex items-center gap-2 bg-white border border-stone-200 rounded-xl px-2 py-1 shadow-2xs">
                                    <button type="button" onclick="changeModalGuests('adults', -1)" class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-chestnut font-bold text-sm cursor-pointer">-</button>
                                    <input type="number" name="adults" id="modal-adults" min="1" max="50" value="1" readonly class="w-7 text-center font-extrabold text-xs text-gray-900 border-none p-0 focus:outline-none bg-transparent">
                                    <button type="button" onclick="changeModalGuests('adults', 1)" class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-chestnut font-bold text-sm cursor-pointer">+</button>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-xs font-extrabold text-gray-900 block">Children (age 4 - 9)</span>
                                    <span class="text-[10px] text-emerald-600 font-semibold" id="modal-child-rate-label">25% off the adult price</span>
                                </div>
                                <div class="flex items-center gap-2 bg-white border border-stone-200 rounded-xl px-2 py-1 shadow-2xs">
                                    <button type="button" onclick="changeModalGuests('children', -1)" class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-chestnut font-bold text-sm cursor-pointer">-</button>
                                    <input type="number" name="children" id="modal-children" min="0" max="30" value="0" readonly class="w-7 text-center font-extrabold text-xs text-gray-900 border-none p-0 focus:outline-none bg-transparent">
                                    <button type="button" onclick="changeModalGuests('children', 1)" class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-chestnut font-bold text-sm cursor-pointer">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Extra Addon Services (Dynamic from Database & Filament Admin) -->
                    <div>
                        <label class="block text-xs font-bold text-gray-800 uppercase mb-2">Optional extra services:</label>
                        <div class="space-y-2.5" id="modal-extra-services-list">
                            @php
                                try {
                                    $extraAddons = \App\Models\TourAddon::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();
                                } catch (\Throwable $e) {
                                    $extraAddons = collect([]);
                                }
                            @endphp

                            @foreach($extraAddons as $srv)
                                @php
                                    $srvId = is_array($srv) ? ($srv['code'] ?? $srv['id']) : ($srv->code ?: 'addon_' . $srv->id);
                                    $srvName = is_array($srv) ? $srv['name'] : $srv->name;
                                    $srvPrice = is_array($srv) ? (float) $srv['price'] : (float) $srv->price;
                                    $srvUnit = is_array($srv) ? ($srv['price_unit'] ?? '') : ($srv->price_unit ?? '');
                                    $srvCalc = is_array($srv) ? ($srv['calculation_type'] ?? 'fixed') : ($srv->calculation_type ?? 'per_booking');
                                    $srvDesc = is_array($srv) ? ($srv['description'] ?? '') : ($srv->description ?? '');
                                @endphp
                                <label class="flex items-center justify-between p-3 rounded-2xl border border-stone-200 hover:border-chestnut bg-white transition cursor-pointer">
                                    <div class="flex items-center gap-3">
                                        <input type="checkbox" 
                                               data-addon-id="{{ $srvId }}" 
                                               data-addon-name="{{ $srvName }}" 
                                               data-addon-price="{{ $srvPrice }}" 
                                               data-addon-calc="{{ $srvCalc }}"
                                               onchange="calculateBookingTotal()" 
                                               class="extra-addon-checkbox text-chestnut focus:ring-chestnut rounded">
                                        <div>
                                            <span class="text-xs font-bold text-gray-900 block">{{ $srvName }}</span>
                                            @if($srvDesc)
                                                <span class="text-[10px] text-gray-500">{{ $srvDesc }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="text-xs font-black text-chestnut">+${{ number_format($srvPrice, 0) }}{{ $srvUnit }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-2">
                        <button type="button" onclick="switchBookingStep(1)" class="px-4 py-2 border border-stone-300 text-stone-600 hover:text-stone-900 text-xs font-bold rounded-xl transition cursor-pointer">
                            <i class="fa-solid fa-arrow-left mr-1"></i> Back
                        </button>
                        <button type="button" onclick="switchBookingStep(3)" class="px-6 py-2.5 bg-chestnut hover:bg-orange-600 text-white text-xs font-extrabold rounded-xl transition flex items-center gap-1.5 cursor-pointer">
                            <span>Next: Your Details</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- STEP 3: TRAVELER CONTACT & PICKUP INFO -->
                <div id="step-content-3" class="step-content hidden space-y-3.5">
                    <p class="text-xs text-stone-500">Lead traveler details so Chestnut Travel can issue your e-ticket and pickup information:</p>

                    <div>
                        <label class="block text-xs font-bold text-gray-800 uppercase mb-1">Full name *</label>
                        <input type="text" name="customer_name" id="modal-name" required data-required-message="Please enter your full name." autocomplete="name" value="{{ Auth::user()->name ?? '' }}" placeholder="e.g. David Miller" class="w-full px-3.5 py-2.5 border border-stone-300 rounded-xl text-xs focus:outline-none focus:border-chestnut transition">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-800 uppercase mb-1">Email for confirmation *</label>
                            <input type="email" name="customer_email" id="modal-email" required data-required-message="Please enter your email address so we can send your confirmation." autocomplete="email" value="{{ Auth::user()->email ?? '' }}" placeholder="email@example.com" class="w-full px-3.5 py-2.5 border border-stone-300 rounded-xl text-xs focus:outline-none focus:border-chestnut transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-800 uppercase mb-1">Phone / WhatsApp *</label>
                            <input type="tel" name="customer_phone" id="modal-phone" required data-required-message="Please enter your phone / WhatsApp number." autocomplete="tel" value="{{ Auth::user()->phone ?? '' }}" placeholder="+84 987 654 321" class="w-full px-3.5 py-2.5 border border-stone-300 rounded-xl text-xs focus:outline-none focus:border-chestnut transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-800 uppercase mb-1">Pickup hotel (optional)</label>
                        <input type="text" name="hotel_pickup" id="modal-hotel" placeholder="Hotel name & address in Hanoi Old Quarter..." class="w-full px-3.5 py-2.5 border border-stone-300 rounded-xl text-xs focus:outline-none focus:border-chestnut transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-800 uppercase mb-1">Dietary requirements / Special requests</label>
                        <textarea name="special_requests" id="modal-notes" rows="2" placeholder="Vegetarian, food allergies, large helmet size..." class="w-full px-3.5 py-2.5 border border-stone-300 rounded-xl text-xs focus:outline-none focus:border-chestnut transition"></textarea>
                    </div>

                    <div class="flex justify-between items-center pt-2">
                        <button type="button" onclick="switchBookingStep(2)" class="px-4 py-2 border border-stone-300 text-stone-600 hover:text-stone-900 text-xs font-bold rounded-xl transition cursor-pointer">
                            <i class="fa-solid fa-arrow-left mr-1"></i> Back
                        </button>
                        <button type="button" onclick="switchBookingStep(4)" class="px-6 py-2.5 bg-chestnut hover:bg-orange-600 text-white text-xs font-extrabold rounded-xl transition flex items-center gap-1.5 cursor-pointer">
                            <span>Next: Payment & Confirmation</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- STEP 4: PAYMENT OPTIONS & SUBMIT (2 OPTIONS: VIETQR OR PAY ON ARRIVAL) -->
                <div id="step-content-4" class="step-content hidden space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-800 uppercase mb-1">Payment method:</label>
                        <p class="text-xs text-stone-500 mb-3">Please choose the most convenient payment method:</p>

                        <div class="space-y-3">
                            <!-- Option 1: VietQR bank transfer -->
                            <label class="payment-method-card flex flex-col p-4 rounded-2xl border-2 border-chestnut bg-orange-50/40 cursor-pointer transition" onclick="selectPaymentMethod('vietqr', this)">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="modal_pay_radio" value="vietqr" checked class="text-chestnut focus:ring-chestnut">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs sm:text-sm font-extrabold text-gray-900">1. Bank transfer (Scan VietQR code)</span>
                                                <span class="bg-red-100 text-red-700 text-[10px] font-black px-2 py-0.5 rounded-full uppercase">Recommended</span>
                                            </div>
                                            <span class="text-[11px] text-gray-500 block mt-0.5">Scan the QR code with any banking app for an instant 24/7 transfer</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1.5 shrink-0">
                                        <span class="px-2 py-0.5 bg-red-600 text-white text-[10px] font-black rounded uppercase tracking-wider">VietQR</span>
                                        <i class="fa-solid fa-qrcode text-gray-700 text-xl"></i>
                                    </div>
                                </div>

                                <!-- VietQR info box -->
                                <div id="vietqr-form" class="mt-4 pt-3 border-t border-orange-200/60">
                                    <div class="bg-white rounded-xl p-3.5 border border-orange-200 flex flex-col sm:flex-row gap-4 items-center">
                                        <div class="w-32 h-32 shrink-0 bg-stone-100 rounded-xl p-1 border border-stone-200 flex items-center justify-center overflow-hidden">
                                            <img id="vietqr-modal-image" 
                                                 src="{{ option('site_bank_qr_image') ? asset('storage/' . option('site_bank_qr_image')) : ('https://img.vietqr.io/image/' . option('site_bank_bin', 'MB') . '-' . option('site_bank_account', '0348788668') . '-compact2.png?amount=0&addInfo=DATTOUR&accountName=' . urlencode(option('site_bank_owner', 'CHESTNUT TRAVEL VN'))) }}" 
                                                 alt="VietQR Transfer" 
                                                 class="w-full h-full object-contain">
                                        </div>
                                        <div class="flex-1 space-y-1.5 text-xs text-stone-700 w-full">
                                            <div class="flex justify-between items-center pb-1 border-b border-stone-100">
                                                <span class="text-stone-500">Bank:</span>
                                                <strong class="text-gray-900">{{ option('site_bank_name', 'MB Bank (Military Commercial Joint Stock Bank)') }}</strong>
                                            </div>
                                            <div class="flex justify-between items-center pb-1 border-b border-stone-100">
                                                <span class="text-stone-500">Account number:</span>
                                                <div class="flex items-center gap-2">
                                                    <span class="font-mono font-bold text-chestnut text-sm tracking-wide">{{ option('site_bank_account', '0348788668') }}</span>
                                                    <button type="button" onclick="event.stopPropagation(); navigator.clipboard.writeText('{{ option('site_bank_account', '0348788668') }}'); showToast('Account number copied!', 'success')" class="text-[10px] px-1.5 py-0.5 bg-stone-100 hover:bg-stone-200 rounded font-semibold text-stone-600">
                                                        <i class="fa-regular fa-copy"></i> Copy
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="flex justify-between items-center pb-1 border-b border-stone-100">
                                                <span class="text-stone-500">Account holder:</span>
                                                <strong class="text-gray-900 uppercase">{{ option('site_bank_owner', 'CHESTNUT TRAVEL VN') }}</strong>
                                            </div>
                                            <p class="text-[11px] text-stone-500 italic mt-1 leading-snug">
                                                {{ option('site_bank_note', 'Scan the QR code or make a bank transfer. Your booking will be reviewed by our team and a confirmation email will be sent as soon as payment is received.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- Option 2: Pay later (on pickup) -->
                            <label class="payment-method-card flex flex-col p-4 rounded-2xl border-2 border-stone-200 hover:border-chestnut bg-white cursor-pointer transition" onclick="selectPaymentMethod('pay_on_arrival', this)">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="modal_pay_radio" value="pay_on_arrival" class="text-chestnut focus:ring-chestnut">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs sm:text-sm font-extrabold text-gray-900">2. Pay later (Pay on arrival)</span>
                                                <span class="bg-blue-100 text-blue-800 text-[10px] font-black px-2 py-0.5 rounded-full uppercase">Reserve now</span>
                                            </div>
                                            <span class="text-[11px] text-gray-500 block mt-0.5">No prepayment needed - pay directly when your guide picks you up</span>
                                        </div>
                                    </div>
                                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-base shrink-0">
                                        <i class="fa-solid fa-hand-holding-dollar"></i>
                                    </div>
                                </div>
                                <div id="pay-later-note" class="hidden mt-3 pt-3 border-t border-stone-100 text-xs text-blue-900 bg-blue-50/60 p-3 rounded-xl leading-relaxed">
                                    <i class="fa-solid fa-circle-info text-blue-600 mr-1"></i>
                                    <strong>Reservation policy:</strong> Your booking will be received as pending. Our team will review it and send you a booking confirmation email.
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Hidden inputs for submission -->
                    <input type="hidden" name="payment_method" id="modal-payment-method" value="vietqr">
                    <input type="hidden" name="payment_type" id="modal-payment-type" value="full">

                    <div class="flex justify-between items-center pt-2">
                        <button type="button" onclick="switchBookingStep(3)" class="px-4 py-2 border border-stone-300 text-stone-600 hover:text-stone-900 text-xs font-bold rounded-xl transition cursor-pointer">
                            <i class="fa-solid fa-arrow-left mr-1"></i> Back
                        </button>
                    </div>
                </div>

                <!-- LIVE SUMMARY FOOTER & SUBMIT BUTTON -->
                <div class="border-t border-stone-200 pt-4 bg-stone-50 -mx-5 -mb-5 sm:-mx-7 sm:-mb-7 p-5 sm:p-7 rounded-b-3xl">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="w-full sm:w-auto space-y-1 text-center sm:text-left">
                            <div class="flex items-center gap-2 justify-center sm:justify-start">
                                <span class="text-[11px] text-gray-500 uppercase font-bold">Package total:</span>
                                <span class="text-xs font-bold text-gray-900" id="modal-grand-total">$0.00</span>
                            </div>
                            <div class="flex items-baseline gap-2 justify-center sm:justify-start">
                                <span class="text-[11px] text-chestnut font-black uppercase tracking-wider" id="modal-payable-label">PAY BY VIETQR (100%):</span>
                                <span class="text-xl sm:text-2xl font-black text-chestnut" id="modal-payable-display">$0.00</span>
                                <span class="text-xs font-bold text-stone-400" id="modal-payable-vnd">~ 0 VND</span>
                            </div>
                            <div class="text-[10px] text-stone-500 hidden" id="modal-remaining-notice">
                                Pay your guide on pickup: <strong class="text-gray-900" id="modal-remaining-display">$0.00</strong>
                            </div>
                        </div>

                        <button type="submit" id="btn-submit-booking" class="w-full sm:w-auto bg-[#E48E45] hover:bg-[#D27B32] text-white font-extrabold px-8 py-3.5 rounded-2xl text-xs shadow-lg shadow-orange-500/25 transition transform active:scale-95 flex items-center justify-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-bolt"></i>
                            <span id="btn-submit-text">PAY & COMPLETE BOOKING</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- SEARCH MODAL (Quick search)               -->
    <!-- ========================================== -->
    <div id="search-modal" class="fixed inset-0 z-50 hidden bg-black/75 flex items-start justify-center pt-24 px-4 overscroll-contain">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-6 relative animate-fadeIn" onclick="event.stopPropagation()">
            <button onclick="toggleSearchModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <h4 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-magnifying-glass text-chestnut"></i>
                <span>Search for your next adventure</span>
            </h4>
            <form action="{{ route('home') }}#tours-section" method="GET" class="flex gap-2">
                <input type="text" name="s" placeholder="Enter a tour name or place (Ha Giang, Sa Pa, Lan Ha Bay...)" class="flex-1 px-4 py-3 border border-gray-300 rounded-xl text-sm focus:outline-none focus:border-chestnut transition">
                <button type="submit" class="bg-chestnut hover:bg-orange-600 text-white font-bold px-6 py-3 rounded-xl text-sm transition">Search</button>
            </form>
            <div class="mt-4 flex flex-wrap gap-2 text-xs text-gray-500">
                <span class="font-bold text-gray-700">Popular searches:</span>
                <a href="{{ route('home') }}?s=Ha+Giang#tours-section" class="bg-gray-100 hover:bg-orange-50 hover:text-chestnut px-2.5 py-1 rounded-full transition">Ha Giang Loop</a>
                <a href="{{ route('home') }}?s=Sapa#tours-section" class="bg-gray-100 hover:bg-orange-50 hover:text-chestnut px-2.5 py-1 rounded-full transition">Sa Pa Trekking</a>
                <a href="{{ route('home') }}?s=Lan+Ha#tours-section" class="bg-gray-100 hover:bg-orange-50 hover:text-chestnut px-2.5 py-1 rounded-full transition">Lan Ha Bay</a>
                <a href="{{ route('home') }}?s=Ninh+Binh#tours-section" class="bg-gray-100 hover:bg-orange-50 hover:text-chestnut px-2.5 py-1 rounded-full transition">Ninh Binh</a>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- WISHLIST MODAL                             -->
    <!-- ========================================== -->
    <div id="wishlist-modal" class="fixed inset-0 z-50 hidden bg-black/70 flex items-center justify-center p-4 overscroll-contain">
        <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden relative animate-fadeIn flex flex-col max-h-[85vh]" onclick="event.stopPropagation()">
            <!-- Header -->
            <div class="p-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/70">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-gray-100 text-gray-700 flex items-center justify-center">
                        <i class="fa-regular fa-heart text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-gray-900">Your Wishlist</h3>
                        <p class="text-[11px] text-gray-500">Tours you have saved for later</p>
                    </div>
                </div>
                <button onclick="closeWishlistModal()" class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-700 flex items-center justify-center text-xs transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Body list -->
            <div id="modal-wishlist-items" class="p-5 overflow-y-auto flex-1 divide-y divide-gray-100 space-y-3">
                <!-- Rendered by JS -->
            </div>

            <!-- Empty State -->
            <div id="modal-wishlist-empty" class="p-8 text-center hidden">
                <div class="w-16 h-16 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mx-auto mb-3 text-2xl">
                    <i class="fa-regular fa-heart"></i>
                </div>
                <h4 class="font-bold text-gray-800 text-sm mb-1">No saved tours yet</h4>
                <p class="text-xs text-gray-500 mb-4">Tap the heart icon on any tour to save your favorite trips!</p>
                <a href="{{ route('home') }}#tours-section" onclick="closeWishlistModal()" class="inline-block bg-chestnut hover:bg-orange-600 text-white font-bold text-xs px-4 py-2 rounded-xl transition">
                    Explore tours
                </a>
            </div>

            <!-- Footer -->
            <div class="p-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between text-xs">
                <button onclick="clearAllWishlist()" class="text-gray-400 hover:text-gray-700 font-medium transition cursor-pointer">
                    Clear all
                </button>
                <a href="{{ route('wishlist') }}" class="text-chestnut hover:underline font-bold">
                    View full wishlist &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- TOAST NOTIFICATIONS CONTAINER -->
    <div id="toast-container" class="fixed top-4 right-4 left-4 sm:left-auto z-[60] flex flex-col items-end gap-2 pointer-events-none" aria-live="polite"></div>

    <!-- JAVASCRIPT LOGIC FOR MODALS & BOOKINGS -->
    <script>
        // -------------------------------------------------------------
        // FORM FEEDBACK HELPERS (toasts, inline field errors, server responses)
        // -------------------------------------------------------------
        const TOAST_STYLES = {
            error: { bg: 'bg-red-600', icon: 'fa-circle-exclamation' },
            success: { bg: 'bg-emerald-600', icon: 'fa-circle-check' },
            info: { bg: 'bg-sky-600', icon: 'fa-circle-info' },
        };

        function showToast(message, type = 'error', timeout = 5000) {
            const container = document.getElementById('toast-container');
            if (!container || !message) return;
            const style = TOAST_STYLES[type] || TOAST_STYLES.error;
            // Replace an identical toast instead of stacking duplicates on repeated clicks
            container.querySelectorAll('[data-toast-message]').forEach(el => {
                if (el.dataset.toastMessage === message) el.remove();
            });
            const toast = document.createElement('div');
            toast.dataset.toastMessage = message;
            toast.className = `${style.bg} text-white text-xs sm:text-sm px-4 py-3 rounded-xl shadow-2xl flex items-start gap-3 max-w-sm w-full sm:w-auto pointer-events-auto transition-all duration-300 opacity-0 translate-y-[-8px]`;
            toast.setAttribute('role', type === 'error' ? 'alert' : 'status');
            toast.innerHTML = `<i class="fa-solid ${style.icon} text-base mt-0.5 shrink-0"></i><span class="flex-1 leading-snug"></span><button type="button" class="text-white/80 hover:text-white shrink-0" aria-label="Close">✕</button>`;
            toast.querySelector('span').textContent = message;
            const remove = () => {
                toast.classList.add('opacity-0');
                setTimeout(() => toast.remove(), 300);
            };
            toast.querySelector('button').addEventListener('click', remove);
            container.appendChild(toast);
            requestAnimationFrame(() => toast.classList.remove('opacity-0', 'translate-y-[-8px]'));
            if (timeout) setTimeout(remove, timeout);
        }

        function fieldErrorAnchor(input) {
            // Inputs wrapped with an icon sit inside a .relative div; show the error below that wrapper
            const parent = input.parentElement;
            return parent && parent.classList.contains('relative') ? parent : input;
        }

        function setFieldError(input, message) {
            if (!input) return;
            clearFieldError(input);
            input.classList.add('!border-red-500', 'ring-1', 'ring-red-500');
            input.setAttribute('aria-invalid', 'true');
            const err = document.createElement('p');
            err.className = 'field-error text-[11px] text-red-600 font-semibold mt-1 flex items-center gap-1';
            err.innerHTML = '<i class="fa-solid fa-circle-exclamation text-[10px]"></i><span></span>';
            err.querySelector('span').textContent = message;
            fieldErrorAnchor(input).insertAdjacentElement('afterend', err);
            if (!input.dataset.errorListener) {
                input.dataset.errorListener = '1';
                const clear = () => clearFieldError(input);
                input.addEventListener('input', clear);
                input.addEventListener('change', clear);
            }
        }

        function clearFieldError(input) {
            if (!input) return;
            input.classList.remove('!border-red-500', 'ring-1', 'ring-red-500');
            input.removeAttribute('aria-invalid');
            const next = fieldErrorAnchor(input).nextElementSibling;
            if (next && next.classList.contains('field-error')) next.remove();
        }

        function clearFieldErrors(container) {
            if (!container) return;
            container.querySelectorAll('input, select, textarea').forEach(clearFieldError);
        }

        function fieldLabel(input) {
            if (input.dataset.label) return input.dataset.label;
            const wrapper = input.closest('div');
            const label = (input.id && document.querySelector(`label[for="${input.id}"]`)) || (wrapper && wrapper.querySelector('label')) || (wrapper && wrapper.parentElement && wrapper.parentElement.querySelector('label'));
            const text = label ? label.textContent.replace(/\*/g, '').replace(/\(.*?\)/g, '').trim() : '';
            return text ? text.charAt(0).toUpperCase() + text.slice(1).toLowerCase() : 'This field';
        }

        // Validates the visible rules of every field inside `container`; returns the first invalid input (or null)
        function validateFields(container) {
            if (!container) return null;
            let firstInvalid = null;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
            container.querySelectorAll('input, select, textarea').forEach(input => {
                if (input.type === 'hidden' || input.disabled || input.name === '_token') return;
                clearFieldError(input);
                const value = (input.value || '').trim();
                let message = null;

                if (input.required && !value) {
                    message = input.dataset.requiredMessage || `${fieldLabel(input)} is required.`;
                } else if (value && input.type === 'email' && !emailPattern.test(value)) {
                    message = 'Please enter a valid email address (e.g. name@example.com).';
                } else if (value && input.type === 'tel' && value.replace(/[^0-9]/g, '').length < 7) {
                    message = 'Please enter a valid phone number (at least 7 digits).';
                } else if (value && input.minLength > 0 && value.length < input.minLength) {
                    message = `Must be at least ${input.minLength} characters.`;
                } else if (value && input.type === 'number' && ((input.min !== '' && Number(value) < Number(input.min)) || (input.max !== '' && Number(value) > Number(input.max)))) {
                    message = `Please enter a number between ${input.min || 0} and ${input.max || '∞'}.`;
                } else if (value && input.type === 'date' && input.min && value < input.min) {
                    message = 'Please choose a date from today onwards.';
                } else if (input.dataset.match) {
                    const other = container.querySelector(`[name="${input.dataset.match}"]`);
                    if (other && other.value !== input.value) message = 'Passwords do not match.';
                }

                if (message) {
                    setFieldError(input, message);
                    if (!firstInvalid) firstInvalid = input;
                }
            });
            return firstInvalid;
        }

        function focusField(input) {
            if (!input) return;
            input.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(() => input.focus({ preventScroll: true }), 250);
        }

        // Shows Laravel validation errors next to the matching inputs; returns the first matched input
        function applyServerErrors(form, errors) {
            let first = null;
            if (!form || !errors) return first;
            Object.entries(errors).forEach(([field, messages]) => {
                const input = form.querySelector(`[name="${field}"]`) || form.querySelector(`[name="${field}[]"]`);
                if (input && input.type !== 'hidden') {
                    setFieldError(input, Array.isArray(messages) ? messages[0] : messages);
                    if (!first) first = input;
                }
            });
            return first;
        }

        function firstServerError(data) {
            if (data && data.errors && typeof data.errors === 'object') {
                const firstKey = Object.keys(data.errors)[0];
                const msgs = firstKey ? data.errors[firstKey] : null;
                if (Array.isArray(msgs) && msgs.length) return msgs[0];
            }
            return null;
        }

        // Reads a fetch response safely (non-JSON error pages included) and returns a friendly message
        async function readJsonResponse(response) {
            let data = {};
            try {
                data = await response.json();
            } catch (e) {
                data = {};
            }
            let message = firstServerError(data) || data.message || null;
            if (!response.ok) {
                if (response.status === 419) {
                    message = 'Your session has expired. Please refresh the page and try again.';
                } else if (response.status === 429) {
                    message = 'Too many attempts. Please wait a minute and try again.';
                } else if (response.status >= 500) {
                    message = 'Something went wrong on our side. Please try again in a moment or contact our hotline {{ option("site_hotline", "+84 867 216 850") }}.';
                } else if (response.status === 422 && data.errors) {
                    message = message || 'Please check the highlighted fields.';
                }
            }
            return { ok: response.ok && data.success !== false, status: response.status, data, message };
        }

        const NETWORK_ERROR_MESSAGE = 'Unable to connect. Please check your internet connection and try again.';

        // Helper to lock body scroll when modal is open
        function setBodyScrollLock(locked) {
            if (locked) {
                document.body.classList.add('overflow-hidden');
            } else {
                const anyOpen = document.querySelector('#auth-modal:not(.hidden), #booking-modal:not(.hidden), #search-modal:not(.hidden), #wishlist-modal:not(.hidden)');
                if (!anyOpen) {
                    document.body.classList.remove('overflow-hidden');
                }
            }
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        function toggleSearchModal() {
            const modal = document.getElementById('search-modal');
            const isHidden = modal.classList.toggle('hidden');
            setBodyScrollLock(!isHidden);
        }

        // Auth Modal Controls
        function openAuthModal(tab = 'login') {
            const modal = document.getElementById('auth-modal');
            const tabSwitcher = document.getElementById('auth-modal-tabs');
            if (tabSwitcher) tabSwitcher.classList.remove('hidden');

            // Reset form visibility if previously completed
            const formLogin = document.getElementById('form-login');
            const loginSuccess = document.getElementById('login-success');
            if (formLogin) formLogin.classList.remove('hidden');
            if (loginSuccess) loginSuccess.classList.add('hidden');

            const formRegister = document.getElementById('form-register');
            const registerSuccess = document.getElementById('register-success');
            if (formRegister) formRegister.classList.remove('hidden');
            if (registerSuccess) registerSuccess.classList.add('hidden');

            modal.classList.remove('hidden');
            setBodyScrollLock(true);
            switchAuthTab(tab);
        }

        function closeAuthModal() {
            document.getElementById('auth-modal').classList.add('hidden');
            setBodyScrollLock(false);
        }

        function switchAuthTab(tab) {
            const tabLoginBtn = document.getElementById('tab-btn-login');
            const tabRegisterBtn = document.getElementById('tab-btn-register');
            const tabLoginContent = document.getElementById('tab-content-login');
            const tabRegisterContent = document.getElementById('tab-content-register');

            if (tab === 'login') {
                tabLoginBtn.classList.add('border-chestnut', 'text-chestnut');
                tabLoginBtn.classList.remove('border-transparent', 'text-gray-500');
                tabRegisterBtn.classList.remove('border-chestnut', 'text-chestnut');
                tabRegisterBtn.classList.add('border-transparent', 'text-gray-500');
                tabLoginContent.classList.remove('hidden');
                tabRegisterContent.classList.add('hidden');
            } else {
                tabRegisterBtn.classList.add('border-chestnut', 'text-chestnut');
                tabRegisterBtn.classList.remove('border-transparent', 'text-gray-500');
                tabLoginBtn.classList.remove('border-chestnut', 'text-chestnut');
                tabLoginBtn.classList.add('border-transparent', 'text-gray-500');
                tabRegisterContent.classList.remove('hidden');
                tabLoginContent.classList.add('hidden');
            }
        }

        async function handleAuthSubmit(event, url, type) {
            event.preventDefault();
            const form = event.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnHtml = submitBtn ? submitBtn.innerHTML : '';
            const errorDiv = document.getElementById(type + '-error');
            const inputs = form.querySelectorAll('input');

            if (errorDiv) {
                errorDiv.classList.add('hidden');
            }

            const showError = (message) => {
                if (errorDiv) {
                    errorDiv.textContent = message;
                    errorDiv.classList.remove('hidden');
                }
            };

            const firstInvalid = validateFields(form);
            if (firstInvalid) {
                showError('Please fix the highlighted fields below.');
                focusField(firstInvalid);
                return;
            }

            // Collect form data BEFORE disabling inputs (disabled inputs are excluded from FormData)
            const formData = new FormData(form);

            const resetForm = () => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-80', 'cursor-not-allowed');
                    submitBtn.innerHTML = originalBtnHtml;
                }
                inputs.forEach(el => el.disabled = false);
            };

            // Loading UI state
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
                submitBtn.innerHTML = type === 'register'
                    ? '<i class="fa-solid fa-circle-notch fa-spin text-sm"></i> <span>Creating your account...</span>'
                    : '<i class="fa-solid fa-circle-notch fa-spin text-sm"></i> <span>Signing you in...</span>';
            }
            inputs.forEach(el => el.disabled = true);

            let result;
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData,
                });
                result = await readJsonResponse(response);
            } catch (err) {
                resetForm();
                showError(NETWORK_ERROR_MESSAGE);
                return;
            }

            const data = result.data;
            if (!result.ok) {
                resetForm();
                applyServerErrors(form, data.errors);
                showError(result.message || 'Something went wrong. Please try again.');
                return;
            }

            const tabSwitcher = document.getElementById('auth-modal-tabs');
            if (tabSwitcher) tabSwitcher.classList.add('hidden');
            const userName = (data.user && data.user.name) ? data.user.name : 'traveler';
            form.classList.add('hidden');

            if (type === 'register') {
                const userEmail = (data.user && data.user.email) ? data.user.email : '';
                const regSuccessEl = document.getElementById('register-success');
                if (regSuccessEl) {
                    const nameEl = document.getElementById('register-success-name');
                    const emailEl = document.getElementById('register-success-email');
                    if (nameEl) nameEl.textContent = userName;
                    if (emailEl) {
                        emailEl.innerHTML = '<i class="fa-regular fa-envelope text-emerald-600"></i> ';
                        emailEl.appendChild(document.createTextNode(userEmail));
                    }
                    regSuccessEl.classList.remove('hidden');
                }
                setTimeout(() => window.location.reload(), 2300);
            } else {
                const loginSuccessEl = document.getElementById('login-success');
                if (loginSuccessEl) {
                    const nameEl = document.getElementById('login-success-name');
                    if (nameEl) nameEl.textContent = userName;
                    loginSuccessEl.classList.remove('hidden');
                }
                setTimeout(() => window.location.reload(), 1200);
            }
        }

        // Global Advanced Tour Booking Engine Variables
        let currentTourPrice = 199;
        let currentPackageName = 'Easy Rider (With local driver)';
        let currentPaymentMethod = 'vietqr'; // 'vietqr' or 'pay_on_arrival'
        let currentBookingStep = 1;

        // Which booking step each server-side field belongs to (used to jump back to the right step on errors)
        const BOOKING_FIELD_STEPS = {
            tour_id: 1, departure_date: 1, departure_time: 1, package_option: 1, package_price: 1,
            adults: 2, children: 2, extra_services: 2,
            customer_name: 3, customer_email: 3, customer_phone: 3, hotel_pickup: 3, special_requests: 3,
            payment_method: 4, payment_type: 4,
        };

        function showBookingError(message) {
            const errorDiv = document.getElementById('booking-error');
            if (!errorDiv) return;
            if (message) {
                errorDiv.innerHTML = '<i class="fa-solid fa-circle-exclamation mr-1"></i>';
                errorDiv.appendChild(document.createTextNode(message));
                errorDiv.classList.remove('hidden');
            } else {
                errorDiv.classList.add('hidden');
            }
        }

        // Validates steps [fromStep, toStep]; on failure shows that step with inline errors and returns false
        function validateBookingSteps(fromStep, toStep) {
            for (let i = fromStep; i <= toStep; i++) {
                if (i === 1 && !document.getElementById('modal-tour-id')?.value) {
                    renderBookingStep(1);
                    showBookingError('Please select a tour before booking. Refresh the page and try again.');
                    return false;
                }
                const invalid = validateFields(document.getElementById('step-content-' + i));
                if (invalid) {
                    renderBookingStep(i);
                    showBookingError('Please complete the highlighted fields before continuing.');
                    showToast('Please complete the required information to continue.', 'error');
                    focusField(invalid);
                    return false;
                }
            }
            showBookingError(null);
            return true;
        }

        function switchBookingStep(step) {
            // Moving forward requires every step in between to be valid
            if (step > currentBookingStep && !validateBookingSteps(currentBookingStep, step - 1)) {
                return;
            }
            if (step <= currentBookingStep) showBookingError(null);
            renderBookingStep(step);
        }

        function renderBookingStep(step) {
            currentBookingStep = step;
            for (let i = 1; i <= 4; i++) {
                const tab = document.getElementById('step-tab-' + i);
                const content = document.getElementById('step-content-' + i);
                if (tab && content) {
                    if (i === step) {
                        tab.className = 'step-tab flex items-center gap-1.5 py-2 px-2.5 rounded-xl border border-chestnut bg-chestnut/20 text-white transition text-left cursor-pointer';
                        content.classList.remove('hidden');
                    } else if (i < step) {
                        tab.className = 'step-tab flex items-center gap-1.5 py-2 px-2.5 rounded-xl border border-emerald-500/50 bg-emerald-500/10 text-emerald-300 transition text-left cursor-pointer';
                        content.classList.add('hidden');
                    } else {
                        tab.className = 'step-tab flex items-center gap-1.5 py-2 px-2.5 rounded-xl border border-white/10 bg-white/5 text-stone-400 transition text-left cursor-pointer';
                        content.classList.add('hidden');
                    }
                }
            }
        }

        function selectModalPackage(name, price, element) {
            currentPackageName = name;
            currentTourPrice = parseFloat(price) || 199;
            const pkgOpt = document.getElementById('modal-package-option');
            const pkgPrice = document.getElementById('modal-package-price');
            if (pkgOpt) pkgOpt.value = name;
            if (pkgPrice) pkgPrice.value = currentTourPrice;

            document.querySelectorAll('.package-option-card').forEach(card => {
                card.classList.remove('border-chestnut', 'bg-orange-50/40');
                card.classList.add('border-stone-200', 'bg-white');
                const radio = card.querySelector('input[type="radio"]');
                if (radio) radio.checked = false;
            });
            if (element) {
                element.classList.add('border-chestnut', 'bg-orange-50/40');
                element.classList.remove('border-stone-200', 'bg-white');
                const radio = element.querySelector('input[type="radio"]');
                if (radio) radio.checked = true;
            }

            calculateBookingTotal();
        }

        function selectPaymentMethod(method, element) {
            currentPaymentMethod = method;
            const payMethodInput = document.getElementById('modal-payment-method');
            const payTypeInput = document.getElementById('modal-payment-type');
            if (payMethodInput) payMethodInput.value = method;
            if (payTypeInput) payTypeInput.value = (method === 'vietqr') ? 'full' : 'later';

            document.querySelectorAll('.payment-method-card').forEach(card => {
                card.classList.remove('border-chestnut', 'bg-orange-50/40');
                card.classList.add('border-stone-200', 'bg-white');
                const radio = card.querySelector('input[type="radio"]');
                if (radio) radio.checked = false;
            });
            if (element) {
                element.classList.add('border-chestnut', 'bg-orange-50/40');
                element.classList.remove('border-stone-200', 'bg-white');
                const radio = element.querySelector('input[type="radio"]');
                if (radio) radio.checked = true;
            }

            const vietqrForm = document.getElementById('vietqr-form');
            const payLaterNote = document.getElementById('pay-later-note');
            if (vietqrForm) {
                if (method === 'vietqr') {
                    vietqrForm.classList.remove('hidden');
                } else {
                    vietqrForm.classList.add('hidden');
                }
            }
            if (payLaterNote) {
                if (method === 'pay_on_arrival') {
                    payLaterNote.classList.remove('hidden');
                } else {
                    payLaterNote.classList.add('hidden');
                }
            }

            calculateBookingTotal();
        }

        function changeModalGuests(type, delta) {
            const input = document.getElementById('modal-' + type);
            if (!input) return;
            let val = parseInt(input.value) || 0;
            val += delta;
            if (type === 'adults') {
                if (val < 1) val = 1;
                if (val > 50) val = 50;
            } else {
                if (val < 0) val = 0;
                if (val > 30) val = 30;
            }
            input.value = val;
            calculateBookingTotal();
        }

        function calculateBookingTotal() {
            const adults = parseInt(document.getElementById('modal-adults')?.value) || 1;
            const children = parseInt(document.getElementById('modal-children')?.value) || 0;
            const childRate = Math.round(currentTourPrice * 0.75);

            const adultRateLabel = document.getElementById('modal-adult-rate-label');
            const childRateLabel = document.getElementById('modal-child-rate-label');
            if (adultRateLabel) adultRateLabel.textContent = `$${Math.round(currentTourPrice)} / person`;
            if (childRateLabel) childRateLabel.textContent = `$${childRate} / child (25% off)`;

            // Calculate Extra Services
            let extraTotal = 0;
            const extraServicesList = [];
            document.querySelectorAll('.extra-addon-checkbox:checked').forEach(cb => {
                const id = cb.dataset.addonId;
                const name = cb.dataset.addonName;
                const price = parseFloat(cb.dataset.addonPrice) || 0;
                const calc = cb.dataset.addonCalc || 'fixed';
                let qty = 1;
                if (calc === 'per_person' || id === 'limousine') {
                    qty = adults + children;
                }
                const sub = price * qty;
                extraTotal += sub;
                extraServicesList.push({
                    id: id,
                    name: name,
                    price: price,
                    quantity: qty,
                    subtotal: sub,
                    selected: true
                });
            });

            const extraJsonEl = document.getElementById('modal-extra-services-json');
            if (extraJsonEl) extraJsonEl.value = JSON.stringify(extraServicesList);

            const baseTotal = (adults * currentTourPrice) + (children * childRate);
            const grandTotal = baseTotal + extraTotal;
            const grandTotalEl = document.getElementById('modal-grand-total');
            if (grandTotalEl) grandTotalEl.textContent = `$${grandTotal.toFixed(2)}`;

            const exchangeRate = 25400;
            const payableLabel = document.getElementById('modal-payable-label');
            const payableDisplay = document.getElementById('modal-payable-display');
            const payableVndEl = document.getElementById('modal-payable-vnd');
            const remNotice = document.getElementById('modal-remaining-notice');
            const remDisplay = document.getElementById('modal-remaining-display');
            const btnText = document.getElementById('btn-submit-text');

            if (currentPaymentMethod === 'vietqr') {
                if (payableLabel) payableLabel.textContent = 'PAY BY VIETQR (100%):';
                if (payableDisplay) payableDisplay.textContent = `$${grandTotal.toFixed(2)}`;
                if (payableVndEl) payableVndEl.textContent = `~ ${Math.round(grandTotal * exchangeRate).toLocaleString('en-US')} VND`;
                if (remNotice) remNotice.classList.add('hidden');
                if (btnText) btnText.textContent = 'CONFIRM BOOKING & PAY BY TRANSFER';

                // Update VietQR dynamic QR code with accurate amount in VND
                const qrImg = document.getElementById('vietqr-modal-image');
                if (qrImg) {
                    const amountVnd = Math.round(grandTotal * exchangeRate);
                    const bankBin = '{{ option("site_bank_bin", "MB") }}';
                    const bankAcc = '{{ option("site_bank_account", "0348788668") }}';
                    const bankOwner = '{{ option("site_bank_owner", "CHESTNUT TRAVEL VN") }}';
                    const customQr = '{{ option("site_bank_qr_image") ? asset("storage/" . option("site_bank_qr_image")) : "" }}';
                    if (customQr) {
                        qrImg.src = customQr;
                    } else {
                        qrImg.src = `https://img.vietqr.io/image/${bankBin}-${bankAcc}-compact2.png?amount=${amountVnd}&addInfo=DATTOUR&accountName=${encodeURIComponent(bankOwner)}`;
                    }
                }
            } else {
                // pay_on_arrival (pay later)
                if (payableLabel) payableLabel.textContent = 'DUE TODAY:';
                if (payableDisplay) payableDisplay.textContent = '$0.00';
                if (payableVndEl) payableVndEl.textContent = '~ 0 VND';
                if (remNotice) remNotice.classList.remove('hidden');
                if (remDisplay) remDisplay.textContent = `$${grandTotal.toFixed(2)}`;
                if (btnText) btnText.textContent = 'CONFIRM RESERVATION (PAY LATER)';
            }
        }

        function escapeHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        // Quick Booking Modal Controls
        function openQuickBookingModal(tourId, tourTitle, tourPrice = 199, selectedPackage = '', departureDate = '', adults = 1, children = 0, customPackages = [], tourAddons = null) {
            document.getElementById('modal-tour-id').value = tourId || '';
            document.getElementById('modal-tour-title').textContent = tourTitle || 'Book Your Tour';
            currentTourPrice = parseFloat(tourPrice) || 199;
            const pkgPrice = document.getElementById('modal-package-price');
            const pkgOpt = document.getElementById('modal-package-option');
            if (pkgPrice) pkgPrice.value = currentTourPrice;

            if (selectedPackage) {
                currentPackageName = selectedPackage;
                if (pkgOpt) pkgOpt.value = selectedPackage;
            }

            const pkgContainer = document.getElementById('modal-package-container');
            if (pkgContainer && Array.isArray(customPackages) && customPackages.length > 0) {
                pkgContainer.innerHTML = '';
                customPackages.forEach((pkg, idx) => {
                    const price = parseFloat(pkg.sale_price || pkg.price) || currentTourPrice;
                    const isChecked = (selectedPackage && selectedPackage === pkg.option_name) || (!selectedPackage && idx === 0);
                    if (isChecked) {
                        currentPackageName = pkg.option_name;
                        currentTourPrice = price;
                        if (pkgOpt) pkgOpt.value = pkg.option_name;
                        if (pkgPrice) pkgPrice.value = currentTourPrice;
                    }
                    const card = document.createElement('label');
                    card.className = `package-option-card flex items-start gap-3 p-3.5 rounded-2xl border-2 ${isChecked ? 'border-chestnut bg-orange-50/40' : 'border-stone-200 hover:border-chestnut bg-white'} cursor-pointer transition`;
                    card.onclick = function() { selectModalPackage(pkg.option_name, price, card); };
                    card.innerHTML = `
                        <input type="radio" name="modal_pkg_radio" ${isChecked ? 'checked' : ''} class="mt-1 text-chestnut focus:ring-chestnut">
                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-extrabold text-gray-900">${escapeHtml(pkg.option_name)}</span>
                                <span class="text-xs font-black text-chestnut">$${Math.round(price)}</span>
                            </div>
                            <p class="text-[11px] text-gray-500 mt-0.5">${escapeHtml(pkg.notes || 'Chestnut Travel standard package')}</p>
                        </div>
                    `;
                    pkgContainer.appendChild(card);
                });
            } else {
                const pkg1 = document.getElementById('modal-pkg-price-1');
                const pkg2 = document.getElementById('modal-pkg-price-2');
                if (pkg1) pkg1.textContent = '$' + Math.round(currentTourPrice);
                if (pkg2) pkg2.textContent = '$' + Math.max(99, Math.round(currentTourPrice - 50));
            }

            // Dynamic Extra Addons configuration for this tour
            const addonList = document.getElementById('modal-extra-services-list');
            if (addonList && Array.isArray(tourAddons)) {
                addonList.innerHTML = '';
                if (tourAddons.length === 0) {
                    addonList.innerHTML = `
                        <div class="p-3.5 bg-stone-50 border border-stone-200 rounded-2xl text-xs text-stone-500 italic flex items-center gap-2">
                            <i class="fa-solid fa-circle-check text-emerald-500"></i>
                            This tour already includes all standard services, with no extra charges.
                        </div>
                    `;
                } else {
                    tourAddons.forEach(srv => {
                        const srvId = srv.code || srv.id || ('addon_' + Math.random().toString(36).substr(2, 5));
                        const srvName = srv.name || '';
                        const srvPrice = parseFloat(srv.price) || 0;
                        const srvUnit = srv.price_unit || '';
                        const srvCalc = srv.calculation_type || 'per_person';
                        const srvDesc = srv.description || '';

                        const label = document.createElement('label');
                        label.className = 'flex items-center justify-between p-3 rounded-2xl border border-stone-200 hover:border-chestnut bg-white transition cursor-pointer';
                        label.innerHTML = `
                            <div class="flex items-center gap-3">
                                <input type="checkbox" 
                                       data-addon-id="${srvId}" 
                                       data-addon-name="${escapeHtml(srvName)}" 
                                       data-addon-price="${srvPrice}" 
                                       data-addon-calc="${srvCalc}"
                                       onchange="calculateBookingTotal()" 
                                       class="extra-addon-checkbox text-chestnut focus:ring-chestnut rounded">
                                <div>
                                    <span class="text-xs font-bold text-gray-900 block">${escapeHtml(srvName)}</span>
                                    ${srvDesc ? `<span class="text-[10px] text-gray-500">${escapeHtml(srvDesc)}</span>` : ''}
                                </div>
                            </div>
                            <span class="text-xs font-black text-chestnut">+$${Math.round(srvPrice)}${escapeHtml(srvUnit)}</span>
                        `;
                        addonList.appendChild(label);
                    });
                }
            } else {
                // If tourAddons not provided, uncheck all checkboxes
                document.querySelectorAll('.extra-addon-checkbox').forEach(cb => cb.checked = false);
            }

            if (departureDate) {
                const dateInput = document.getElementById('modal-date');
                if (dateInput) dateInput.value = departureDate;
            }

            if (adults) {
                const adultInput = document.getElementById('modal-adults');
                if (adultInput) adultInput.value = adults;
            }
            if (children !== undefined && children !== null) {
                const childInput = document.getElementById('modal-children');
                if (childInput) childInput.value = children;
            }

            // Reset to step 1 with a clean error state
            clearFieldErrors(document.getElementById('form-quick-booking'));
            showBookingError(null);
            renderBookingStep(1);
            calculateBookingTotal();

            document.getElementById('booking-modal').classList.remove('hidden');
            setBodyScrollLock(true);
        }

        function closeQuickBookingModal() {
            document.getElementById('booking-modal').classList.add('hidden');
            setBodyScrollLock(false);
        }

        async function handleBookingSubmit(event) {
            event.preventDefault();
            const form = event.target;
            const submitBtn = document.getElementById('btn-submit-booking');

            // Hidden steps cannot show native browser validation, so validate every step ourselves
            if (!validateBookingSteps(1, 3)) {
                return;
            }

            const formData = new FormData(form);
            const originalBtnHtml = submitBtn.innerHTML;
            const resetButton = () => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnHtml;
            };

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Creating your booking...';

            let result;
            try {
                const response = await fetch('{{ route("booking.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData,
                });
                result = await readJsonResponse(response);
            } catch (err) {
                resetButton();
                showBookingError(NETWORK_ERROR_MESSAGE + ' You can also contact our hotline {{ option("site_hotline", "+84 867 216 850") }}.');
                showToast(NETWORK_ERROR_MESSAGE, 'error');
                return;
            }

            if (result.ok) {
                showToast('Booking created! Redirecting to your confirmation...', 'success');
                window.location.href = result.data.redirect_url || ('/booking/success/' + result.data.booking.code);
                return;
            }

            resetButton();
            const errors = result.data.errors || {};
            const errorSteps = Object.keys(errors).map(f => BOOKING_FIELD_STEPS[f] || 4);
            if (errorSteps.length) {
                renderBookingStep(Math.min(...errorSteps));
            }
            const firstInput = applyServerErrors(form, errors);
            const message = result.message || 'Please check the information you entered and try again.';
            showBookingError(message);
            showToast(message, 'error');
            focusField(firstInput);
        }

        // Close modals on clicking background backdrop
        window.addEventListener('click', function(e) {
            if (e.target.id === 'auth-modal') closeAuthModal();
            if (e.target.id === 'booking-modal') closeQuickBookingModal();
            if (e.target.id === 'search-modal') toggleSearchModal();
            if (e.target.id === 'wishlist-modal') closeWishlistModal();
        });

        // -------------------------------------------------------------
        // WISHLIST SYSTEM (Persisted in localStorage)
        // -------------------------------------------------------------
        const WISHLIST_STORAGE_KEY = 'chestnut_wishlist_items';

        function getWishlist() {
            try {
                return JSON.parse(localStorage.getItem(WISHLIST_STORAGE_KEY)) || [];
            } catch (e) {
                return [];
            }
        }

        function saveWishlist(list) {
            localStorage.setItem(WISHLIST_STORAGE_KEY, JSON.stringify(list));
            updateWishlistUI();
        }

        function toggleWishlist(id, title, image, url, price) {
            let list = getWishlist();
            const index = list.findIndex(item => item.id == id);
            if (index > -1) {
                list.splice(index, 1);
            } else {
                list.push({ id, title, image, url, price });
            }
            saveWishlist(list);
        }

        function removeWishlistItem(id) {
            let list = getWishlist().filter(item => item.id != id);
            saveWishlist(list);
        }

        function clearAllWishlist() {
            if (confirm('Are you sure you want to remove all tours from your wishlist?')) {
                saveWishlist([]);
            }
        }

        function updateWishlistUI() {
            const list = getWishlist();
            const count = list.length;

            // Badges in header and topbar
            const topbarCount = document.getElementById('topbar-wishlist-count');
            const navBadge = document.getElementById('nav-wishlist-badge');
            const mobileCount = document.getElementById('mobile-wishlist-count');
            const pageCount = document.getElementById('wishlist-page-count');

            if (topbarCount) {
                topbarCount.textContent = count;
                topbarCount.classList.toggle('hidden', count === 0);
            }
            if (navBadge) {
                navBadge.textContent = count;
                navBadge.classList.toggle('hidden', count === 0);
            }
            if (mobileCount) {
                mobileCount.textContent = count;
                mobileCount.classList.toggle('hidden', count === 0);
            }
            if (pageCount) {
                pageCount.textContent = count + (count === 1 ? ' tour' : ' tours');
            }

            // Update heart icons on cards (Always 1-stroke outline, no red heart)
            document.querySelectorAll('[data-wishlist-id]').forEach(btn => {
                const id = btn.getAttribute('data-wishlist-id');
                const isFav = list.some(item => item.id == id);
                const icon = btn.querySelector('i');
                if (icon) {
                    icon.className = 'fa-regular fa-heart text-sm';
                    if (isFav) {
                        btn.classList.add('text-gray-900', 'bg-white', 'border', 'border-gray-800', 'shadow-md');
                        btn.classList.remove('text-gray-400', 'text-red-500');
                        btn.setAttribute('title', 'Saved to wishlist');
                    } else {
                        btn.classList.remove('text-gray-900', 'border-gray-800', 'text-red-500');
                        btn.classList.add('text-gray-400');
                        btn.setAttribute('title', 'Save to wishlist');
                    }
                }
            });

            // Render in modal
            const modalContainer = document.getElementById('modal-wishlist-items');
            const modalEmpty = document.getElementById('modal-wishlist-empty');
            if (modalContainer && modalEmpty) {
                if (count === 0) {
                    modalContainer.innerHTML = '';
                    modalEmpty.classList.remove('hidden');
                } else {
                    modalEmpty.classList.add('hidden');
                    modalContainer.innerHTML = list.map(item => `
                        <div class="flex items-center gap-3 pt-3 first:pt-0">
                            <img src="${item.image}" alt="${item.title}" class="w-14 h-14 rounded-xl object-cover shrink-0">
                            <div class="flex-1 min-w-0">
                                <a href="${item.url}" class="font-bold text-xs text-gray-900 hover:text-chestnut line-clamp-1 block">${item.title}</a>
                                <span class="text-xs font-black text-chestnut block mt-0.5">$${Number(item.price).toLocaleString()}</span>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0">
                                <a href="${item.url}" class="bg-chestnut hover:bg-orange-600 text-white text-[11px] font-bold px-2.5 py-1.5 rounded-lg transition">View</a>
                                <button onclick="removeWishlistItem(${item.id})" class="text-gray-400 hover:text-red-500 p-1.5 transition text-xs cursor-pointer" title="Remove">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                    `).join('');
                }
            }

            // Render in my-account page if present
            const pageContainer = document.getElementById('wishlist-items-container');
            const pageEmpty = document.getElementById('wishlist-empty-state');
            if (pageContainer && pageEmpty) {
                if (count === 0) {
                    pageContainer.innerHTML = '';
                    pageEmpty.classList.remove('hidden');
                } else {
                    pageEmpty.classList.add('hidden');
                    pageContainer.innerHTML = list.map(item => `
                        <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 hover:border-orange-200 transition flex gap-3 items-center">
                            <img src="${item.image}" alt="${item.title}" class="w-20 h-20 rounded-xl object-cover shrink-0">
                            <div class="flex-1 min-w-0">
                                <a href="${item.url}" class="font-bold text-xs text-gray-900 hover:text-chestnut line-clamp-2">${item.title}</a>
                                <div class="text-sm font-extrabold text-chestnut mt-1">$${Number(item.price).toLocaleString()}</div>
                            </div>
                            <div class="flex flex-col gap-1.5 shrink-0">
                                <a href="${item.url}" class="bg-chestnut hover:bg-orange-600 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition text-center">Book now</a>
                                <button onclick="removeWishlistItem(${item.id})" class="text-gray-400 hover:text-red-500 text-xs py-1 transition flex items-center justify-center gap-1 cursor-pointer">
                                    <i class="fa-solid fa-trash-can text-[10px]"></i> <span>Remove</span>
                                </button>
                            </div>
                        </div>
                    `).join('');
                }
            }
        }

        function openWishlistModal() {
            const modal = document.getElementById('wishlist-modal');
            if (modal) {
                modal.classList.remove('hidden');
                setBodyScrollLock(true);
                updateWishlistUI();
            }
        }

        function closeWishlistModal() {
            const modal = document.getElementById('wishlist-modal');
            if (modal) {
                modal.classList.add('hidden');
                setBodyScrollLock(false);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateWishlistUI();
        });
    </script>
    @stack('scripts')
</body>
</html>
