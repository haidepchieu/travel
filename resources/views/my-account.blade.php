@extends('layouts.app')

@section('title', 'My Account | ' . option('site_name', 'Chestnut Travel'))

@section('content')
<div class="py-12 bg-gray-50 min-h-[75vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Dashboard Header -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-200 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-orange-500 to-amber-500 text-white font-black text-2xl flex items-center justify-center shadow-lg shadow-orange-500/20">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900">{{ $user->name }}</h1>
                    <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500 mt-1">
                        <span><i class="fa-regular fa-envelope text-chestnut"></i> {{ $user->email }}</span>
                        @if($user->phone)
                            <span>•</span>
                            <span><i class="fa-solid fa-phone text-chestnut"></i> {{ $user->phone }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <form action="{{ route('customer.logout') }}" method="POST">
                @csrf
                <button type="submit" class="border border-gray-200 hover:border-red-200 hover:bg-red-50 text-red-600 font-bold px-4 py-2 rounded-xl text-xs transition flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>Sign out</span>
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Col: Booking History (2 Cols) -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                        <h3 class="font-extrabold text-base text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-ticket text-chestnut"></i>
                            <span>Booking History ({{ $bookings->count() }})</span>
                        </h3>
                        <a href="{{ route('home') }}#tours-section" class="text-xs font-bold text-chestnut hover:underline">
                            + Book another tour
                        </a>
                    </div>

                    @forelse($bookings as $b)
                        <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 hover:border-orange-200 transition-all mb-4 last:mb-0">
                            <div class="flex flex-wrap justify-between items-start gap-2 mb-3">
                                <div>
                                    <span class="font-mono font-bold text-xs bg-white text-gray-800 border border-gray-200 px-2.5 py-0.5 rounded">
                                        {{ $b->booking_code }}
                                    </span>
                                    <h4 class="font-bold text-sm text-gray-900 mt-1.5">{{ $b->tour->title ?? 'Customized tour' }}</h4>
                                </div>
                                <div>
                                    @if($b->booking_status === 'confirmed')
                                        <span class="bg-emerald-100 text-emerald-800 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase">Confirmed</span>
                                    @elseif($b->booking_status === 'cancelled')
                                        <span class="bg-red-100 text-red-800 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase">Cancelled</span>
                                    @elseif($b->booking_status === 'completed')
                                        <span class="bg-blue-100 text-blue-800 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase">Completed</span>
                                    @else
                                        <span class="bg-amber-100 text-amber-800 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase">Pending</span>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs text-gray-600 bg-white p-3 rounded-xl border border-gray-100">
                                <div>
                                    <span class="text-[10px] text-gray-400 block font-semibold uppercase">Departure</span>
                                    <span class="font-bold text-gray-900">{{ $b->departure_date->format('d/m/Y') }}</span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-gray-400 block font-semibold uppercase">Travelers</span>
                                    <span class="font-bold text-gray-900">{{ $b->adults }} {{ Str::plural('Adult', $b->adults) }} {{ $b->children ? '+ ' . $b->children . ' ' . Str::plural('Child', $b->children) : '' }}</span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-gray-400 block font-semibold uppercase">Total</span>
                                    <span class="font-extrabold text-chestnut">${{ number_format($b->total_price, 2) }}</span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-gray-400 block font-semibold uppercase">Payment</span>
                                    <span class="font-semibold text-gray-700 capitalize">{{ $b->payment_status === 'paid' ? 'Paid' : 'Unpaid' }}</span>
                                </div>
                            </div>

                            <div class="mt-3 flex justify-end gap-2">
                                <a href="{{ option('site_whatsapp_link', 'https://wa.me/' . preg_replace('/[^0-9]/', '', option('site_whatsapp', '84867216850'))) }}?text={{ urlencode('I need help with my booking: ' . $b->booking_code) }}" target="_blank" rel="noopener" class="text-xs bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold px-3 py-1.5 rounded-lg transition flex items-center gap-1">
                                    <i class="fa-brands fa-whatsapp text-sm"></i>
                                    <span>WhatsApp support</span>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-gray-400 text-xs">
                            <i class="fa-solid fa-ticket text-3xl mb-2 text-gray-300"></i>
                            <p>You haven't booked any tours with Chestnut Travel yet.</p>
                            <a href="{{ route('home') }}#tours-section" class="inline-block mt-3 bg-chestnut text-white font-bold px-4 py-2 rounded-xl text-xs">Explore tours now</a>
                        </div>
                    @endforelse
                </div>

                <!-- Wishlist Section -->
                <div id="wishlist" class="bg-white rounded-3xl p-6 shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                        <h3 class="font-extrabold text-base text-gray-900 flex items-center gap-2">
                            <i class="fa-regular fa-heart text-gray-700 text-base"></i>
                            <span>My Wishlist</span>
                            <span id="wishlist-page-count" class="bg-gray-100 text-gray-800 text-xs font-bold px-2.5 py-0.5 rounded-full ml-1">0 tour</span>
                        </h3>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('home') }}#tours-section" class="text-xs font-bold text-chestnut hover:underline">
                                + Add tours
                            </a>
                            <button onclick="clearAllWishlist()" class="text-xs text-gray-400 hover:text-gray-700 transition font-medium cursor-pointer">
                                Clear all
                            </button>
                        </div>
                    </div>

                    <div id="wishlist-items-container" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Populated by JavaScript -->
                    </div>

                    <div id="wishlist-empty-state" class="text-center py-10 text-gray-400 text-xs">
                        <i class="fa-regular fa-heart text-3xl mb-2 text-gray-300"></i>
                        <p>You haven't saved any tours to your wishlist yet.</p>
                        <a href="{{ route('home') }}#tours-section" class="inline-block mt-3 bg-chestnut hover:bg-orange-600 text-white font-bold px-4 py-2 rounded-xl text-xs transition">
                            Explore and save your favorite tours
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Col: Update Profile -->
            <div id="profile" class="space-y-6">
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-200">
                    <h3 class="font-extrabold text-base text-gray-900 flex items-center gap-2 mb-4 pb-3 border-b border-gray-100">
                        <i class="fa-solid fa-user-pen text-chestnut"></i>
                        <span>Update Your Details</span>
                    </h3>

                    <form action="{{ route('my-account.profile') }}" method="POST" id="profile-form" novalidate class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Full name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required data-required-message="Please enter your full name." class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-chestnut transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email</label>
                            <input type="email" value="{{ $user->email }}" disabled class="w-full px-3 py-2.5 bg-gray-100 border border-gray-200 rounded-xl text-xs text-gray-500 cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Phone number</label>
                            <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="0987654321" class="w-full px-3 py-2.5 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-chestnut transition">
                        </div>

                        <div class="pt-2 border-t border-gray-100">
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block mb-2">Change password (leave blank to keep current)</span>
                            <div class="space-y-3">
                                <div>
                                    <input type="password" name="current_password" placeholder="Current password..." autocomplete="current-password" class="w-full px-3 py-2 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-chestnut transition">
                                </div>
                                <div>
                                    <input type="password" name="new_password" minlength="6" placeholder="New password (min. 6 characters)..." autocomplete="new-password" class="w-full px-3 py-2 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-chestnut transition">
                                </div>
                                <div>
                                    <input type="password" name="new_password_confirmation" data-match="new_password" placeholder="Confirm new password..." autocomplete="new-password" class="w-full px-3 py-2 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-chestnut transition">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-gray-900 hover:bg-black text-white font-bold py-2.5 rounded-xl text-xs transition">
                            Save changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    (function () {
        const form = document.getElementById('profile-form');
        if (!form) return;

        // Show server-side validation errors next to their fields
        const serverErrors = @json($errors->getMessages());
        if (Object.keys(serverErrors).length) {
            focusField(applyServerErrors(form, serverErrors));
        }

        form.addEventListener('submit', function (e) {
            let firstInvalid = validateFields(form);
            const current = form.querySelector('[name="current_password"]');
            const next = form.querySelector('[name="new_password"]');
            if (!firstInvalid && next.value && !current.value) {
                setFieldError(current, 'Please enter your current password to set a new one.');
                firstInvalid = current;
            }
            if (firstInvalid) {
                e.preventDefault();
                showToast('Please fix the highlighted fields.', 'error');
                focusField(firstInvalid);
            }
        });
    })();
</script>
@endsection
