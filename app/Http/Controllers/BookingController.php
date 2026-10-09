<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmedMail;
use App\Models\Tour;
use App\Models\TourBooking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /**
     * Store a new booking (Supports both Guests and Logged-in Members)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tour_id' => ['required', 'exists:tours,id'],
            'departure_date' => ['required', 'date', 'after_or_equal:today'],
            'departure_time' => ['nullable', 'string', 'max:50'],
            'package_option' => ['nullable', 'string', 'max:255'],
            'package_price' => ['nullable', 'numeric', 'min:0'],
            'adults' => ['required', 'integer', 'min:1', 'max:50'],
            'children' => ['nullable', 'integer', 'min:0', 'max:50'],
            'extra_services' => ['nullable'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'hotel_pickup' => ['nullable', 'string', 'max:255'],
            'special_requests' => ['nullable', 'string', 'max:1000'],
            'payment_method' => ['nullable', 'string', 'in:vietqr,credit_card,pay_on_arrival'],
            'payment_type' => ['nullable', 'string', 'in:deposit,full,later'],
        ], [
            'tour_id.required' => 'Please select a tour before booking.',
            'tour_id.exists' => 'This tour is no longer available. Please refresh the page and try again.',
            'departure_date.required' => 'Please choose your departure date.',
            'departure_date.after_or_equal' => 'The departure date cannot be in the past.',
            'adults.min' => 'At least 1 adult is required for a booking.',
            'customer_name.required' => 'Please enter your full name.',
            'customer_email.required' => 'Please enter your email address so we can send your confirmation.',
            'customer_email.email' => 'Please enter a valid email address (e.g. name@example.com).',
            'customer_phone.required' => 'Please enter your phone / WhatsApp number.',
            'payment_method.in' => 'Please choose a valid payment method.',
        ]);

        $tour = Tour::findOrFail($validated['tour_id']);

        // Determine adult price securely from database to prevent client-side price tampering
        $adultPrice = (float) ($tour->sale_price ?? $tour->price);
        if (!empty($validated['package_option'])) {
            $matchedOption = $tour->prices()->where('option_name', $validated['package_option'])->first();
            if ($matchedOption) {
                $adultPrice = (float) ($matchedOption->sale_price ?? $matchedOption->price);
            }
        }

        $childPrice = round($adultPrice * 0.75, 2); // 75% for children
        $adultsCount = (int) $validated['adults'];
        $childrenCount = (int) ($validated['children'] ?? 0);

        // Process Extra Services (verified strictly against database prices)
        $extraServices = [];
        $extraServicesTotal = 0.0;

        if ($request->filled('extra_services')) {
            $rawExtras = $request->input('extra_services');
            if (is_string($rawExtras)) {
                $rawExtras = json_decode($rawExtras, true) ?? [];
            }
            if (is_array($rawExtras)) {
                foreach ($rawExtras as $extra) {
                    $selected = !empty($extra['selected']) && ($extra['selected'] === true || $extra['selected'] === 'true' || $extra['selected'] === 1 || $extra['selected'] === '1');
                    $qty = isset($extra['quantity']) ? (int) $extra['quantity'] : 1;

                    if ($selected || $qty > 0) {
                        $qty = max(1, $qty);
                        $extraId = $extra['id'] ?? null;
                        $extraName = $extra['name'] ?? 'Extra service';
                        $unitPrice = 0.0;

                        // Securely look up verified price from database
                        if ($extraId) {
                            $dbAddon = \App\Models\TourAddon::find($extraId);
                            if ($dbAddon) {
                                $unitPrice = (float) $dbAddon->price;
                                $extraName = $dbAddon->name;
                            }
                        }

                        $sub = round($qty * $unitPrice, 2);
                        $extraServicesTotal += $sub;
                        $extraServices[] = [
                            'id' => $extraId,
                            'name' => $extraName,
                            'unit_price' => $unitPrice,
                            'quantity' => $qty,
                            'subtotal' => $sub,
                        ];
                    }
                }
            }
        }

        $baseTotalPrice = ($adultPrice * $adultsCount) + ($childPrice * $childrenCount);
        $totalPrice = round($baseTotalPrice + $extraServicesTotal, 2);

        $paymentMethod = $validated['payment_method'] ?? 'vietqr';
        if (!in_array($paymentMethod, ['vietqr', 'pay_on_arrival'])) {
            $paymentMethod = 'vietqr';
        }
        $paymentType = $validated['payment_type'] ?? ($paymentMethod === 'vietqr' ? 'full' : 'later');

        $depositAmount = 0.00;
        $remainingAmount = $totalPrice;
        $paymentStatus = 'pending';
        $transactionId = null;

        if ($paymentMethod === 'vietqr') {
            $depositAmount = $totalPrice;
            $remainingAmount = 0.00;
            $paymentStatus = 'pending';
            $paymentType = 'full';
            $transactionId = 'VQR-' . strtoupper(substr(uniqid(), -8));
        } else {
            // Pay later when the guide picks you up (pay_on_arrival / later)
            $paymentMethod = 'pay_on_arrival';
            $paymentType = 'later';
            $depositAmount = 0.00;
            $remainingAmount = $totalPrice;
            $paymentStatus = 'pending';
            $transactionId = null;
        }

        // Auto find or create customer record in database
        $customer = $this->resolveCustomer(
            $validated['customer_name'],
            $validated['customer_email'],
            $validated['customer_phone']
        );

        $booking = new TourBooking();
        $booking->tour_id = $tour->id;
        $booking->booking_type = 'standard';
        $booking->package_option = $validated['package_option'] ?? ($tour->prices->first()->option_name ?? 'Standard Package');
        $booking->departure_time = $validated['departure_time'] ?? null;
        $booking->user_id = $customer->id;
        $booking->customer_name = $validated['customer_name'];
        $booking->customer_email = $validated['customer_email'];
        $booking->customer_phone = $validated['customer_phone'];
        $booking->departure_date = $validated['departure_date'];
        $booking->adults = $adultsCount;
        $booking->children = $childrenCount;
        $booking->hotel_pickup = $validated['hotel_pickup'] ?? null;
        $booking->special_requests = $validated['special_requests'] ?? null;
        $booking->extra_services = !empty($extraServices) ? $extraServices : null;
        $booking->total_price = $totalPrice;
        $booking->payment_method = $paymentMethod;
        $booking->payment_type = $paymentType;
        $booking->deposit_amount = $depositAmount;
        $booking->remaining_amount = $remainingAmount;
        $booking->payment_transaction_id = $transactionId;
        $booking->payment_status = $paymentStatus;
        $booking->booking_status = 'pending'; // Waiting for admin confirmation
        $booking->save();

        // Note: the booking confirmation email is sent when an admin approves the booking in the Admin Panel

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Your booking has been created successfully!',
                'booking' => [
                    'code' => $booking->booking_code,
                    'tour_title' => $tour->title,
                    'package_option' => $booking->package_option,
                    'departure_date' => $booking->departure_date->format('d/m/Y'),
                    'departure_time' => $booking->departure_time,
                    'adults' => $booking->adults,
                    'children' => $booking->children,
                    'total_price' => number_format($booking->total_price, 2),
                    'deposit_amount' => number_format($booking->deposit_amount, 2),
                    'remaining_amount' => number_format($booking->remaining_amount, 2),
                    'payment_method' => $booking->payment_method,
                    'payment_status' => $booking->payment_status,
                    'customer_name' => $booking->customer_name,
                    'customer_phone' => $booking->customer_phone,
                    'customer_email' => $booking->customer_email,
                ],
                'redirect_url' => route('booking.success', ['code' => $booking->booking_code]),
            ]);
        }

        return redirect()->route('booking.success', ['code' => $booking->booking_code]);
    }

    /**
     * Submit an Enquiry from Tour Detail Page
     */
    public function enquiry(Request $request)
    {
        $validated = $request->validate([
            'tour_id' => ['required', 'exists:tours,id'],
            'enquiry_name' => ['required', 'string', 'max:255'],
            'enquiry_email' => ['required', 'email', 'max:255'],
            'enquiry_contact' => ['required', 'string', 'max:50'],
            'enquiry_country' => ['nullable', 'string', 'max:100'],
            'enquiry_message' => ['nullable', 'string', 'max:2000'],
        ], [
            'enquiry_name.required' => 'Please enter your name.',
            'enquiry_email.required' => 'Please enter your email address.',
            'enquiry_email.email' => 'Please enter a valid email address (e.g. name@example.com).',
            'enquiry_contact.required' => 'Please enter your contact number or WhatsApp.',
        ]);

        $tour = Tour::findOrFail($validated['tour_id']);

        $customer = $this->resolveCustomer(
            $validated['enquiry_name'],
            $validated['enquiry_email'],
            $validated['enquiry_contact'],
            $validated['enquiry_country'] ?? null
        );

        $booking = new TourBooking();
        $booking->tour_id = $tour->id;
        $booking->user_id = $customer->id;
        $booking->customer_name = $validated['enquiry_name'];
        $booking->customer_email = $validated['enquiry_email'];
        $booking->customer_phone = $validated['enquiry_contact'];
        $booking->departure_date = now()->addDays(7)->toDateString();
        $booking->adults = 1;
        $booking->children = 0;
        $booking->hotel_pickup = $validated['enquiry_country'] ?? null;
        $booking->special_requests = $validated['enquiry_message'] ?? 'Enquiry from tour detail page';
        $booking->total_price = $tour->sale_price ?? $tour->price;
        $booking->payment_status = 'pending';
        $booking->booking_status = 'enquiry';
        $booking->save();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your enquiry has been sent successfully. The Chestnut Travel team will get back to you shortly.',
                'booking_code' => $booking->booking_code,
            ]);
        }

        return back()->with('enquiry_success', 'Thank you! Your enquiry has been sent successfully. Our travel experts will contact you very soon!');
    }

    /**
     * Show booking success page
     */
    public function success(Request $request, $code)
    {
        $booking = TourBooking::with('tour')->where('booking_code', $code)->firstOrFail();

        return view('booking-success', compact('booking'));
    }

    /**
     * Guest Booking Lookup
     */
    public function lookup(Request $request)
    {
        $booking = null;
        $searched = false;
        $lookupError = null;

        if ($request->hasAny(['booking_code', 'email', 'phone'])) {
            if (!$request->filled('booking_code')) {
                $lookupError = 'Please enter your booking code (it starts with CNT-).';
            } elseif (!$request->filled('email') && !$request->filled('phone')) {
                $lookupError = 'Please enter the email or phone number you used when booking.';
            }
        }

        if (!$lookupError && $request->filled('booking_code') && ($request->filled('email') || $request->filled('phone'))) {
            $searched = true;
            $query = TourBooking::with('tour')->where('booking_code', trim($request->booking_code));

            if ($request->filled('email')) {
                $query->where('customer_email', trim($request->email));
            }
            if ($request->filled('phone')) {
                $query->where('customer_phone', trim($request->phone));
            }

            $booking = $query->first();
        }

        return view('booking-lookup', compact('booking', 'searched', 'lookupError'));
    }

    /**
     * Handle Customized Tour Submission (https://chestnuttravel.net/customized-tour/)
     */
    public function storeCustomizedTour(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:50'],
            'nationality' => ['nullable', 'string', 'max:100'],
            'departure_date' => ['nullable', 'date'],
            'duration' => ['nullable', 'string', 'max:100'],
            'adults' => ['required', 'integer', 'min:1', 'max:50'],
            'children' => ['nullable', 'integer', 'min:0', 'max:50'],
            'destinations' => ['nullable', 'array'],
            'accommodation' => ['nullable', 'string', 'max:100'],
            'activities' => ['nullable', 'array'],
            'budget' => ['nullable', 'string', 'max:100'],
            'special_requests' => ['nullable', 'string', 'max:3000'],
        ], [
            'customer_name.required' => 'Please enter your full name.',
            'customer_email.required' => 'Please enter your email address so we can send you the itinerary.',
            'customer_email.email' => 'Please enter a valid email address (e.g. name@example.com).',
            'customer_phone.required' => 'Please enter your phone / WhatsApp number.',
            'adults.required' => 'Please enter the number of adults.',
            'adults.min' => 'At least 1 adult is required.',
            'departure_date.date' => 'Please enter a valid departure date.',
        ]);

        // Auto find or create customer record in database
        $customer = $this->resolveCustomer(
            $validated['customer_name'],
            $validated['customer_email'],
            $validated['customer_phone'],
            $validated['nationality'] ?? null
        );

        $booking = new TourBooking();
        $booking->tour_id = null; // Custom tour has no fixed pre-defined tour
        $booking->booking_type = 'customized_tour';
        $booking->user_id = $customer->id;
        $booking->customer_name = $validated['customer_name'];
        $booking->customer_email = $validated['customer_email'];
        $booking->customer_phone = $validated['customer_phone'];
        $booking->departure_date = !empty($validated['departure_date']) ? $validated['departure_date'] : now()->addDays(7)->toDateString();
        $booking->adults = (int) $validated['adults'];
        $booking->children = (int) ($validated['children'] ?? 0);
        $booking->hotel_pickup = $validated['nationality'] ?? null;
        $booking->special_requests = $validated['special_requests'] ?? null;
        $booking->custom_details = [
            'nationality' => $validated['nationality'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'destinations' => $validated['destinations'] ?? [],
            'accommodation' => $validated['accommodation'] ?? null,
            'activities' => $validated['activities'] ?? [],
            'budget' => $validated['budget'] ?? null,
        ];
        $booking->total_price = 0.00; // Will be quoted by travel experts
        $booking->payment_status = 'pending';
        $booking->booking_status = 'pending';
        $booking->save();

        // Note: the confirmation email is sent once an admin reviews and quotes the request in the Admin Panel

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Your customized tour request has been sent successfully!',
                'booking_code' => $booking->booking_code,
            ]);
        }

        return redirect()->route('booking.success', ['code' => $booking->booking_code])
            ->with('custom_tour_message', 'Thank you! We have received your customized tour request. The Chestnut Travel team will contact you within 30 minutes to finalize your personal itinerary.');
    }

    /**
     * Automatically find or create a Customer account for any booking
     */
    protected function resolveCustomer(string $name, string $email, string $phone, ?string $nationality = null): User
    {
        if (Auth::check()) {
            $user = Auth::user();
            $dirty = false;
            if (empty($user->phone) && !empty($phone)) {
                $user->phone = trim($phone);
                $dirty = true;
            }
            if (empty($user->nationality) && !empty($nationality)) {
                $user->nationality = trim($nationality);
                $dirty = true;
            }
            if ($dirty) {
                $user->save();
            }
            return $user;
        }

        $emailClean = trim(strtolower($email));
        $user = User::where('email', $emailClean)->first();

        if (!$user) {
            $digits = preg_replace('/[^0-9]/', '', $phone);
            $defaultPassword = strlen($digits) >= 6 ? substr($digits, -6) : 'travel123456';

            $user = User::create([
                'name' => trim($name),
                'email' => $emailClean,
                'phone' => trim($phone),
                'role' => 'customer',
                'nationality' => $nationality ? trim($nationality) : null,
                'password' => bcrypt($defaultPassword),
            ]);
        } else {
            $dirty = false;
            if (empty($user->phone) && !empty($phone)) {
                $user->phone = trim($phone);
                $dirty = true;
            }
            if (empty($user->nationality) && !empty($nationality)) {
                $user->nationality = trim($nationality);
                $dirty = true;
            }
            if ($dirty) {
                $user->save();
            }
        }

        return $user;
    }
}
