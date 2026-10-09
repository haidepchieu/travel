@extends('layouts.app')

@section('title', 'Design Your Own Private Tour - ' . option('site_name', 'Chestnut Travel'))
@section('meta_description', 'Design your dream holiday in Vietnam with Chestnut Travel: customize the itinerary, departure date, budget and transport to suit you.')

@section('content')
<!-- HERO SECTION -->
<div class="relative bg-gradient-to-br from-[#1b5e56] via-[#26786e] to-[#1d5c54] text-white pt-12 pb-20 overflow-hidden">
    <!-- Background subtle texture & glow -->
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-[#28B5A4]/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-black/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb matching Chestnut Travel -->
        <nav class="flex items-center space-x-2 text-xs text-teal-100/80 mb-6 font-medium">
            <a href="{{ route('home') }}" class="hover:text-white transition flex items-center gap-1.5">
                <i class="fa-solid fa-house text-[11px]"></i>
                <span>Home</span>
            </a>
            <span class="text-teal-200/50">/</span>
            <span class="text-white font-semibold">Customized tour</span>
        </nav>

        <div class="text-center max-w-3xl mx-auto">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-white/10 backdrop-blur-md text-teal-100 border border-white/15 mb-4 shadow-sm">
                <i class="fa-solid fa-sliders text-[#28B5A4]"></i>
                Unique experiences, made to order
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-white mb-5 font-serif-display leading-tight">
                Design Your Own Private Tour
            </h1>
            <div class="space-y-3 text-teal-50/90 text-sm sm:text-base leading-relaxed font-light">
                <p>
                    We have prepared the detailed form below so you can easily share your ideas and wishes for your trip.
                </p>
                <p>
                    Choose your travel dates, favorite destinations, accommodation standard, transport and estimated budget. Chestnut Travel's local experts will design the best possible itinerary just for you!
                </p>
                <p class="font-normal text-white">
                    All consultations and itinerary planning are completely free, with a reply within 30 minutes.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- MAIN FORM CONTAINER -->
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 pb-20 relative z-20">

    @if(session('custom_tour_message'))
    <div class="mb-8 p-6 bg-emerald-50 border border-emerald-200 rounded-2xl shadow-lg flex items-start gap-4">
        <div class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0">
            <i class="fa-solid fa-check text-lg"></i>
        </div>
        <div>
            <h3 class="font-bold text-emerald-900 text-base mb-1">Request sent successfully!</h3>
            <p class="text-emerald-700 text-sm">{{ session('custom_tour_message') }}</p>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-3xl shadow-xl shadow-teal-900/5 border border-gray-100 overflow-hidden">
        <!-- Progress / Header Bar -->
        <div class="bg-gray-50/80 px-6 sm:px-10 py-5 border-b border-gray-100 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-[#26786e] text-white flex items-center justify-center font-bold text-sm shadow-sm">
                    <i class="fa-solid fa-pencil"></i>
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-900">Your customized tour details</h2>
                    <p class="text-xs text-gray-500">Takes just 2 minutes - our experts will design your itinerary for free</p>
                </div>
            </div>
            <div class="flex items-center gap-2 text-xs font-semibold text-teal-800 bg-teal-50 px-3 py-1.5 rounded-full border border-teal-100">
                <i class="fa-regular fa-clock text-teal-600"></i>
                <span>Reply within 30 minutes</span>
            </div>
        </div>

        <form action="{{ route('customized-tour.store') }}" method="POST" id="customized-tour-form" novalidate class="p-6 sm:p-10 space-y-10">
            @csrf

            <!-- SECTION 1: CONTACT INFORMATION -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 border-b border-gray-100 pb-2">
                    <span class="w-6 h-6 rounded-full bg-teal-100 text-[#26786e] font-bold text-xs flex items-center justify-center">1</span>
                    <h3 class="text-base font-bold text-gray-900">Contact information</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Your full name <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fa-regular fa-user absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" name="customer_name" required data-required-message="Please enter your full name." autocomplete="name" value="{{ Auth::check() ? Auth::user()->name : old('customer_name') }}"
                                   placeholder="e.g. John Smith"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#26786e] focus:border-transparent outline-none transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Email for itinerary & quote <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fa-regular fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="email" name="customer_email" required data-required-message="Please enter your email address so we can send your itinerary." autocomplete="email" value="{{ Auth::check() ? Auth::user()->email : old('customer_email') }}"
                                   placeholder="email@example.com"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#26786e] focus:border-transparent outline-none transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Phone number <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="fa-brands fa-whatsapp absolute left-3.5 top-1/2 -translate-y-1/2 text-emerald-600 text-base"></i>
                            <input type="tel" name="customer_phone" required data-required-message="Please enter your phone / WhatsApp number." autocomplete="tel" value="{{ Auth::check() ? (Auth::user()->phone ?? '') : old('customer_phone') }}"
                                   placeholder="+84 867 216 850 or WhatsApp number"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#26786e] focus:border-transparent outline-none transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Nationality / Country of residence
                        </label>
                        <div class="relative">
                            <i class="fa-solid fa-globe absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" name="nationality" value="{{ old('nationality') }}"
                                   placeholder="e.g. Australia, United States, France..."
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#26786e] focus:border-transparent outline-none transition">
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: TRIP DATES & TRAVELERS -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 border-b border-gray-100 pb-2">
                    <span class="w-6 h-6 rounded-full bg-teal-100 text-[#26786e] font-bold text-xs flex items-center justify-center">2</span>
                    <h3 class="text-base font-bold text-gray-900">Dates & Travelers</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Expected departure date
                        </label>
                        <div class="relative">
                            <i class="fa-regular fa-calendar absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="date" name="departure_date" min="{{ date('Y-m-d') }}" value="{{ old('departure_date') }}"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#26786e] focus:border-transparent outline-none transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                            Trip length (days)
                        </label>
                        <select name="duration" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#26786e] focus:border-transparent outline-none transition bg-white">
                            <option value="2-3 days (Short weekend trip)">2 - 3 days (Short trip)</option>
                            <option value="4-5 days (Most popular)" selected>4 - 5 days (Most popular)</option>
                            <option value="6-7 days (A full week)">6 - 7 days (A full week)</option>
                            <option value="8-10 days (In-depth discovery)">8 - 10 days (North & Central)</option>
                            <option value="Over 10 days (Across Vietnam)">Over 10 days (Grand Tour)</option>
                            <option value="Flexible - expert advice">Flexible - based on our experts' advice</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Adults <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="adults" min="1" max="50" value="2" required data-required-message="Please enter the number of adults."
                                   class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#26786e] focus:border-transparent outline-none transition text-center font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Children (&lt;12 yrs)
                            </label>
                            <input type="number" name="children" min="0" max="20" value="0"
                                   class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#26786e] focus:border-transparent outline-none transition text-center font-bold">
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: PREFERRED DESTINATIONS -->
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-teal-100 text-[#26786e] font-bold text-xs flex items-center justify-center">3</span>
                        <h3 class="text-base font-bold text-gray-900">Preferred destinations</h3>
                    </div>
                    <span class="text-xs text-gray-400 font-medium">Select as many as you like</span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2.5">
                    @php
                        $presetDestinations = [
                            ['name' => 'Ha Giang (Loop)', 'icon' => 'fa-mountain', 'color' => 'text-teal-600'],
                            ['name' => 'Sa Pa', 'icon' => 'fa-person-hiking', 'color' => 'text-emerald-600'],
                            ['name' => 'Ninh Binh (Trang An)', 'icon' => 'fa-water', 'color' => 'text-cyan-600'],
                            ['name' => 'Cat Ba / Lan Ha Bay', 'icon' => 'fa-ship', 'color' => 'text-blue-600'],
                            ['name' => 'Ha Long Bay', 'icon' => 'fa-anchor', 'color' => 'text-indigo-600'],
                            ['name' => 'Ta Xua (Cloud Hunting)', 'icon' => 'fa-cloud', 'color' => 'text-purple-600'],
                            ['name' => 'Hanoi (Old Quarter)', 'icon' => 'fa-city', 'color' => 'text-amber-600'],
                            ['name' => 'Hoi An', 'icon' => 'fa-lightbulb', 'color' => 'text-orange-500'],
                            ['name' => 'Da Nang', 'icon' => 'fa-umbrella-beach', 'color' => 'text-yellow-600'],
                            ['name' => 'Hue Imperial City', 'icon' => 'fa-landmark', 'color' => 'text-red-500'],
                            ['name' => 'Cao Bang (Ban Gioc)', 'icon' => 'fa-gem', 'color' => 'text-teal-500'],
                            ['name' => 'Mai Chau / Moc Chau', 'icon' => 'fa-seedling', 'color' => 'text-green-600'],
                        ];
                    @endphp

                    @foreach($presetDestinations as $dest)
                    <label class="relative flex items-center gap-2.5 p-3 rounded-2xl border border-gray-200 hover:border-[#26786e] hover:bg-teal-50/40 cursor-pointer transition select-none group has-[:checked]:border-[#26786e] has-[:checked]:bg-teal-50">
                        <input type="checkbox" name="destinations[]" value="{{ $dest['name'] }}" class="rounded text-[#26786e] focus:ring-[#26786e] w-4 h-4 border-gray-300">
                        <i class="fa-solid {{ $dest['icon'] }} {{ $dest['color'] }} text-xs group-hover:scale-110 transition"></i>
                        <span class="text-xs font-semibold text-gray-800">{{ $dest['name'] }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- SECTION 4: LODGING & ACCOMMODATION -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 border-b border-gray-100 pb-2">
                    <span class="w-6 h-6 rounded-full bg-teal-100 text-[#26786e] font-bold text-xs flex items-center justify-center">4</span>
                    <h3 class="text-base font-bold text-gray-900">Accommodation standard</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                    <label class="flex flex-col p-4 rounded-2xl border border-gray-200 hover:border-[#26786e] hover:bg-teal-50/30 cursor-pointer transition select-none has-[:checked]:border-[#26786e] has-[:checked]:bg-teal-50">
                        <div class="flex items-center justify-between mb-2">
                            <i class="fa-solid fa-house-chimney text-emerald-600 text-lg"></i>
                            <input type="radio" name="accommodation" value="Local homestay" checked class="text-[#26786e] focus:ring-[#26786e]">
                        </div>
                        <span class="font-bold text-xs text-gray-900 mb-0.5">Local Homestay</span>
                        <span class="text-[11px] text-gray-500 leading-tight">Cozy, with an up-close local cultural experience</span>
                    </label>

                    <label class="flex flex-col p-4 rounded-2xl border border-gray-200 hover:border-[#26786e] hover:bg-teal-50/30 cursor-pointer transition select-none has-[:checked]:border-[#26786e] has-[:checked]:bg-teal-50">
                        <div class="flex items-center justify-between mb-2">
                            <i class="fa-solid fa-hotel text-blue-600 text-lg"></i>
                            <input type="radio" name="accommodation" value="Comfortable 3-star hotel" class="text-[#26786e] focus:ring-[#26786e]">
                        </div>
                        <span class="font-bold text-xs text-gray-900 mb-0.5">3-Star Hotel</span>
                        <span class="text-[11px] text-gray-500 leading-tight">Clean, comfortable private rooms in central locations</span>
                    </label>

                    <label class="flex flex-col p-4 rounded-2xl border border-gray-200 hover:border-[#26786e] hover:bg-teal-50/30 cursor-pointer transition select-none has-[:checked]:border-[#26786e] has-[:checked]:bg-teal-50">
                        <div class="flex items-center justify-between mb-2">
                            <i class="fa-solid fa-crown text-amber-500 text-lg"></i>
                            <input type="radio" name="accommodation" value="4-5 star resort & hotel" class="text-[#26786e] focus:ring-[#26786e]">
                        </div>
                        <span class="font-bold text-xs text-gray-900 mb-0.5">4 - 5 Star Resort</span>
                        <span class="text-[11px] text-gray-500 leading-tight">Luxurious, upscale, infinity pools & VIP service</span>
                    </label>

                    <label class="flex flex-col p-4 rounded-2xl border border-gray-200 hover:border-[#26786e] hover:bg-teal-50/30 cursor-pointer transition select-none has-[:checked]:border-[#26786e] has-[:checked]:bg-teal-50">
                        <div class="flex items-center justify-between mb-2">
                            <i class="fa-solid fa-ship text-teal-600 text-lg"></i>
                            <input type="radio" name="accommodation" value="Boutique cruise" class="text-[#26786e] focus:ring-[#26786e]">
                        </div>
                        <span class="font-bold text-xs text-gray-900 mb-0.5">Boutique Cruise</span>
                        <span class="text-[11px] text-gray-500 leading-tight">Overnight cruise on Lan Ha / Ha Long Bay</span>
                    </label>
                </div>
            </div>

            <!-- SECTION 5: ACTIVITIES OF INTEREST -->
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-teal-100 text-[#26786e] font-bold text-xs flex items-center justify-center">5</span>
                        <h3 class="text-base font-bold text-gray-900">Activities you're interested in</h3>
                    </div>
                    <span class="text-xs text-gray-400 font-medium">Choose what you enjoy</span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @php
                        $presetActivities = [
                            ['name' => 'Motorbike Tour (Easy Rider)', 'desc' => 'Ride yourself or sit behind a local driver', 'icon' => 'fa-motorcycle', 'color' => 'text-orange-500'],
                            ['name' => 'Trekking & Hiking', 'desc' => 'Walk through rice terraces & hills', 'icon' => 'fa-person-hiking', 'color' => 'text-emerald-500'],
                            ['name' => 'Boating & Kayak', 'desc' => 'Kayak and boat through bays & caves', 'icon' => 'fa-ship', 'color' => 'text-blue-500'],
                            ['name' => 'Street Food Tour', 'desc' => 'Taste local street food specialties', 'icon' => 'fa-utensils', 'color' => 'text-red-500'],
                            ['name' => 'Local Culture & Craft Villages', 'desc' => 'Brocade weaving, conical hat making, tea tasting', 'icon' => 'fa-landmark', 'color' => 'text-amber-500'],
                            ['name' => 'Relaxation & Photography', 'desc' => 'Unwind, chase clouds, capture stunning views', 'icon' => 'fa-camera', 'color' => 'text-purple-500'],
                        ];
                    @endphp

                    @foreach($presetActivities as $act)
                    <label class="flex items-start gap-3 p-3.5 rounded-2xl border border-gray-200 hover:border-[#26786e] hover:bg-teal-50/30 cursor-pointer transition select-none group has-[:checked]:border-[#26786e] has-[:checked]:bg-teal-50">
                        <input type="checkbox" name="activities[]" value="{{ $act['name'] }}" class="rounded text-[#26786e] focus:ring-[#26786e] w-4 h-4 border-gray-300 mt-0.5">
                        <div>
                            <div class="flex items-center gap-1.5 font-bold text-xs text-gray-900">
                                <i class="fa-solid {{ $act['icon'] }} {{ $act['color'] }} text-[11px]"></i>
                                <span>{{ $act['name'] }}</span>
                            </div>
                            <p class="text-[11px] text-gray-500 mt-0.5 leading-tight">{{ $act['desc'] }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- SECTION 6: BUDGET ESTIMATE & SPECIAL NOTES -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Budget -->
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-gray-700">
                        Estimated budget per person
                    </label>
                    <select name="budget" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#26786e] focus:border-transparent outline-none transition bg-white">
                        <option value="Budget / Backpacking (&lt; $40 / day)">Budget / Backpacking (&lt; $40 / day / person)</option>
                        <option value="Standard comfort ($50 - $90 / day)" selected>Standard comfort ($50 - $90 / day / person)</option>
                        <option value="Premium / Luxury (&gt; $100 / day)">Premium & Private (&gt; $100 / day / person)</option>
                        <option value="Flexible - Chestnut Travel advice">Flexible - based on the best itinerary advice</option>
                    </select>
                    <p class="text-[11px] text-gray-400">Chestnut Travel guarantees direct prices from local partners, with no middlemen.</p>
                </div>

                <!-- Special Requests -->
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-gray-700">
                        Notes & special requests
                    </label>
                    <textarea name="special_requests" rows="3"
                              placeholder="Vegetarian/allergy notes, traveling with seniors or young children, places you definitely want to visit..."
                              class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#26786e] focus:border-transparent outline-none transition resize-none"></textarea>
                </div>
            </div>

            <!-- SUBMIT BUTTON & DIRECT WHATSAPP -->
            <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3 text-xs text-gray-500">
                    <i class="fa-solid fa-shield-halved text-[#26786e] text-base"></i>
                    <span>Your information is kept strictly confidential under our data protection policy.</span>
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <!-- WhatsApp Direct -->
                    <a href="https://wa.me/84867216850?text={{ urlencode('Hello Chestnut Travel, I would like advice on designing a private tour in Vietnam.') }}"
                       target="_blank" rel="noopener"
                       class="px-5 py-3 rounded-full border border-emerald-500 text-emerald-700 hover:bg-emerald-50 text-xs font-bold transition flex items-center justify-center gap-2 shrink-0">
                        <i class="fa-brands fa-whatsapp text-emerald-600 text-sm"></i>
                        <span>Chat WhatsApp</span>
                    </a>

                    <!-- Submit Button -->
                    <button type="submit" id="submit-custom-tour-btn"
                            class="w-full sm:w-auto bg-[#26786e] hover:bg-[#1f625a] text-white px-8 py-3.5 rounded-full text-sm font-bold shadow-lg shadow-teal-900/20 transition transform active:scale-95 flex items-center justify-center gap-2 cursor-pointer">
                        <span>Send My Tour Request</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- WHY CHOOSE CHESTNUT TRAVEL FOR CUSTOMIZED TOURS -->
    <div class="mt-14 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-teal-50 text-[#26786e] flex items-center justify-center shrink-0 text-xl font-bold">
                <i class="fa-solid fa-compass"></i>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 text-sm mb-1">Local Experts</h4>
                <p class="text-xs text-gray-500 leading-relaxed">Our guides were born and raised locally and know every mountain pass and village inside out.</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 text-xl font-bold">
                <i class="fa-solid fa-badge-percent"></i>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 text-sm mb-1">Best Price Guaranteed</h4>
                <p class="text-xs text-gray-500 leading-relaxed">Costs optimized for your budget with transparent service quality and no hidden surcharges.</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 text-xl font-bold">
                <i class="fa-solid fa-headset"></i>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 text-sm mb-1">24/7 Support - Always By Your Side</h4>
                <p class="text-xs text-gray-500 leading-relaxed">Our staff support you with anything that comes up on the road via WhatsApp, hotline and in person at pickup.</p>
            </div>
        </div>
    </div>
</div>
<script>
    // Customized tour request: validate inline, submit via AJAX and show clear feedback
    (function () {
        const form = document.getElementById('customized-tour-form');
        if (!form) return;

        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const firstInvalid = validateFields(form);
            if (firstInvalid) {
                showToast('Please complete the highlighted fields to send your request.', 'error');
                focusField(firstInvalid);
                return;
            }

            const btn = document.getElementById('submit-custom-tour-btn');
            const originalBtnHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i><span>Sending your request...</span>';

            let result;
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: new FormData(form),
                });
                result = await readJsonResponse(response);
            } catch (err) {
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
                showToast(NETWORK_ERROR_MESSAGE, 'error');
                return;
            }

            if (result.ok) {
                showToast(result.data.message || 'Your request has been sent successfully!', 'success');
                if (result.data.booking_code) {
                    window.location.href = '{{ url('/booking/success') }}/' + encodeURIComponent(result.data.booking_code);
                }
                return;
            }

            btn.disabled = false;
            btn.innerHTML = originalBtnHtml;
            focusField(applyServerErrors(form, result.data.errors));
            showToast(result.message || 'Something went wrong. Please try again.', 'error');
        });
    })();
</script>
@endsection
