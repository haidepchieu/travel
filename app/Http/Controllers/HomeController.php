<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Destination;
use App\Models\Post;
use App\Models\Review;
use App\Models\Tour;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the Homepage
     */
    public function index(Request $request)
    {
        $hasFilters = $request->anyFilled(['destination', 'activity', 's', 'price_range', 'min_price', 'max_price', 'sort']);

        // Optimization: Use cache for default homepage to prevent DB overload on high traffic
        if (!$hasFilters) {
            $homeData = \Illuminate\Support\Facades\Cache::remember('homepage_main_data', 300, function () {
                $destinations = Destination::where('is_active', true)
                    ->withCount('tours')
                    ->orderBy('sort_order', 'asc')
                    ->get();

                $activities = Activity::withCount('tours')->get();

                // Cap popular tours at 27 (max 3 pages of 9 tours) with eager loading to prevent memory overload
                $allTours = Tour::where('is_active', true)
                    ->with(['destination:id,name,slug', 'activities:id,name,slug'])
                    ->latest()
                    ->take(27)
                    ->get();

                $featuredTours = Tour::where('is_active', true)
                    ->where('is_featured', true)
                    ->with(['destination:id,name,slug', 'activities:id,name,slug'])
                    ->take(6)
                    ->get();

                $hiddenGems = Tour::where('is_active', true)
                    ->whereHas('destination', function ($q) {
                        $q->whereIn('slug', ['ha-giang', 'ta-xua']);
                    })
                    ->with(['destination:id,name,slug', 'activities:id,name,slug'])
                    ->take(3)
                    ->get();

                $testimonials = Review::where('is_approved', true)
                    ->where('is_featured', true)
                    ->latest()
                    ->get();

                if ($testimonials->isEmpty()) {
                    $testimonials = Review::where('is_approved', true)
                        ->latest()
                        ->take(6)
                        ->get();
                }

                $latestPosts = Post::published()
                    ->latest('published_at')
                    ->take(3)
                    ->get();

                return compact('destinations', 'activities', 'allTours', 'featuredTours', 'hiddenGems', 'testimonials', 'latestPosts');
            });

            return view('welcome', $homeData);
        }

        // When filters are active, run query dynamically
        $destinations = Destination::where('is_active', true)
            ->withCount('tours')
            ->orderBy('sort_order', 'asc')
            ->get();

        $activities = Activity::withCount('tours')->get();

        $toursQuery = Tour::where('is_active', true)
            ->with(['destination:id,name,slug', 'activities:id,name,slug']);

        if ($request->filled('destination')) {
            $toursQuery->whereHas('destination', function ($q) use ($request) {
                $q->where('slug', $request->destination)->orWhere('id', $request->destination);
            });
        }

        if ($request->filled('activity')) {
            $toursQuery->whereHas('activities', function ($q) use ($request) {
                $q->where('slug', $request->activity)->orWhere('activities.id', $request->activity);
            });
        }

        if ($request->filled('s')) {
            $keyword = trim($request->s);
            $toursQuery->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('tagline', 'like', "%{$keyword}%")
                    ->orWhere('overview', 'like', "%{$keyword}%");
            });
        }

        // Price Filter: price_range ("0-100", "100-200", "200-300", "300+") or min_price/max_price
        $minPrice = null;
        $maxPrice = null;

        if ($request->filled('price_range')) {
            $range = $request->get('price_range');
            if (str_contains($range, '-')) {
                [$min, $max] = explode('-', $range, 2);
                if (is_numeric($min)) $minPrice = (float) $min;
                if (is_numeric($max)) $maxPrice = (float) $max;
            } elseif (str_ends_with($range, '+')) {
                $min = rtrim($range, '+');
                if (is_numeric($min)) $minPrice = (float) $min;
            }
        }

        if ($request->filled('min_price')) {
            $minPrice = (float) $request->get('min_price');
        }
        if ($request->filled('max_price')) {
            $maxPrice = (float) $request->get('max_price');
        }

        if ($minPrice !== null) {
            $toursQuery->whereRaw('COALESCE(sale_price, price) >= ?', [$minPrice]);
        }
        if ($maxPrice !== null) {
            $toursQuery->whereRaw('COALESCE(sale_price, price) <= ?', [$maxPrice]);
        }

        // Sorting
        if ($request->filled('sort')) {
            match ($request->get('sort')) {
                'price-asc', 'price' => $toursQuery->orderByRaw('COALESCE(sale_price, price) ASC'),
                'price-desc' => $toursQuery->orderByRaw('COALESCE(sale_price, price) DESC'),
                'rating' => $toursQuery->orderBy('rating', 'desc'),
                'days' => $toursQuery->orderBy('duration_days', 'asc'),
                default => $toursQuery->latest(),
            };
        } else {
            $toursQuery->latest();
        }

        $allTours = (clone $toursQuery)->take(27)->get();

        $featuredTours = Tour::where('is_active', true)
            ->where('is_featured', true)
            ->with(['destination:id,name,slug', 'activities:id,name,slug'])
            ->take(6)
            ->get();

        $hiddenGems = Tour::where('is_active', true)
            ->whereHas('destination', function ($q) {
                $q->whereIn('slug', ['ha-giang', 'ta-xua']);
            })
            ->with(['destination:id,name,slug', 'activities:id,name,slug'])
            ->take(3)
            ->get();

        $testimonials = Review::where('is_approved', true)
            ->where('is_featured', true)
            ->latest()
            ->get();

        if ($testimonials->isEmpty()) {
            $testimonials = Review::where('is_approved', true)
                ->latest()
                ->take(6)
                ->get();
        }

        $latestPosts = Post::published()
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('welcome', compact(
            'destinations',
            'activities',
            'allTours',
            'featuredTours',
            'hiddenGems',
            'testimonials',
            'latestPosts'
        ));
    }

    /**
     * View Single Tour Details
     */
    public function showTour($slug)
    {
        $tour = Tour::where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'destination', 
                'activities', 
                'itineraries', 
                'prices',
                'reviews' => fn($q) => $q->where('is_approved', true)->latest()
            ])
            ->firstOrFail();

        // Related tours in same destination, fallback to other tours if < 3
        $relatedTours = Tour::where('is_active', true)
            ->where('id', '!=', $tour->id)
            ->where('destination_id', $tour->destination_id)
            ->with(['destination', 'activities'])
            ->take(3)
            ->get();

        if ($relatedTours->count() < 3) {
            $otherTours = Tour::where('is_active', true)
                ->where('id', '!=', $tour->id)
                ->whereNotIn('id', $relatedTours->pluck('id'))
                ->with(['destination', 'activities'])
                ->take(3 - $relatedTours->count())
                ->get();
            $relatedTours = $relatedTours->merge($otherTours);
        }

        // Featured trips for sidebar
        $featuredTours = Tour::where('is_active', true)
            ->where('id', '!=', $tour->id)
            ->where('is_featured', true)
            ->with(['destination'])
            ->take(4)
            ->get();

        if ($featuredTours->isEmpty()) {
            $featuredTours = Tour::where('is_active', true)
                ->where('id', '!=', $tour->id)
                ->with(['destination'])
                ->take(4)
                ->get();
        }

        return view('tour-detail', compact('tour', 'relatedTours', 'featuredTours'));
    }

    /**
     * View Destination with tours
     */
    public function showDestination($slug)
    {
        $destination = Destination::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $tours = Tour::where('is_active', true)
            ->where('destination_id', $destination->id)
            ->with(['destination', 'activities'])
            ->get();

        return view('destination-detail', compact('destination', 'tours'));
    }

    /**
     * View Activity with tours and filter sidebar (Matching Chestnut Travel /activities/{slug}/)
     */
    public function showActivity(Request $request, $slug)
    {
        $activity = Activity::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $query = Tour::where('is_active', true)
            ->whereHas('activities', function ($q) use ($activity) {
                $q->where('activities.id', $activity->id);
            })
            ->with(['destination', 'activities', 'reviews']);

        // Search text
        if ($request->filled('keyword')) {
            $kw = $request->get('keyword');
            $query->where(function ($q) use ($kw) {
                $q->where('title', 'like', "%{$kw}%")
                  ->orWhere('overview', 'like', "%{$kw}%");
            });
        }

        // Filter: Destination
        if ($request->filled('destinations')) {
            $destSlugs = (array) $request->get('destinations');
            $query->whereHas('destination', function ($q) use ($destSlugs) {
                $q->whereIn('slug', $destSlugs);
            });
        }

        // Filter: Difficulty
        if ($request->filled('difficulties')) {
            $diffs = (array) $request->get('difficulties');
            $query->whereIn('difficulty', $diffs);
        }

        // Filter: Price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->get('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->get('max_price'));
        }

        // Filter: Duration range
        if ($request->filled('min_duration')) {
            $query->where('duration_days', '>=', (int) $request->get('min_duration'));
        }
        if ($request->filled('max_duration')) {
            $query->where('duration_days', '<=', (int) $request->get('max_duration'));
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'price' => $query->orderBy('price', 'asc'),
            'price-desc' => $query->orderBy('price', 'desc'),
            'rating' => $query->orderBy('rating', 'desc'),
            'days' => $query->orderBy('duration_days', 'asc'),
            'days-desc' => $query->orderBy('duration_days', 'desc'),
            'name' => $query->orderBy('title', 'asc'),
            'name-desc' => $query->orderBy('title', 'desc'),
            default => $query->latest(),
        };

        $tours = $query->paginate(9)->withQueryString();

        $allDestinations = Destination::where('is_active', true)
            ->withCount('tours')
            ->orderBy('sort_order', 'asc')
            ->get();

        $allActivities = Activity::where('is_active', true)
            ->withCount('tours')
            ->get();

        $viewMode = $request->get('view', 'list');

        return view('activity-detail', compact(
            'activity',
            'tours',
            'allDestinations',
            'allActivities',
            'viewMode'
        ));
    }

    /**
     * Dedicated Wishlist Page (Matching Chestnut Travel /wishlist/)
     */
    public function wishlist()
    {
        $destinations = Destination::where('is_active', true)
            ->withCount('tours')
            ->orderBy('sort_order', 'asc')
            ->get();

        $activities = Activity::withCount('tours')->get();

        $featuredTours = Tour::where('is_active', true)
            ->where('is_featured', true)
            ->with(['destination', 'activities'])
            ->take(4)
            ->get();

        return view('wishlist', compact('destinations', 'activities', 'featuredTours'));
    }

    /**
     * Dedicated Customized Tour Page (Matching https://chestnuttravel.net/customized-tour/)
     */
    public function customizedTour()
    {
        $destinations = Destination::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $activities = Activity::where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();

        return view('customized-tour', compact('destinations', 'activities'));
    }

    /**
     * Dedicated Package Combo Page (Matching https://chestnuttravel.net/package/)
     */
    public function packageCombos(Request $request)
    {
        $query = Tour::where('is_active', true)
            ->where(function ($q) {
                if (\Illuminate\Support\Facades\Schema::hasColumn('tours', 'is_combo')) {
                    $q->where('is_combo', true)
                      ->orWhere('trip_type', 'like', '%Combo%')
                      ->orWhere('trip_type', 'like', '%Package%');
                } else {
                    $q->where('trip_type', 'like', '%Combo%')
                      ->orWhere('trip_type', 'like', '%Package%');
                }
            })
            ->with(['destination', 'activities', 'includedTours', 'comboItems.childTour']);

        // Region filter (North, Central)
        if ($request->filled('region')) {
            $region = $request->input('region');
            if ($region === 'north') {
                $query->whereHas('destination', fn ($d) => $d->whereIn('slug', ['ha-giang', 'sapa', 'ninh-binh', 'hanoi', 'ha-long', 'mu-cang-chai', 'cao-bang']));
            } elseif ($region === 'central') {
                $query->whereHas('destination', fn ($d) => $d->whereIn('slug', ['hue', 'hoi-an', 'da-nang', 'phong-nha', 'quang-binh']));
            }
        }

        if ($request->filled('s')) {
            $search = $request->input('s');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('overview', 'like', "%{$search}%")
                  ->orWhere('tagline', 'like', "%{$search}%");
            });
        }

        $combos = $query->latest()->paginate(9)->withQueryString();

        // If no combos exist yet, fallback to featured multi-day tours so page is never empty
        if ($combos->isEmpty() && !$request->anyFilled(['region', 's'])) {
            $combos = Tour::where('is_active', true)
                ->where('duration_days', '>=', 3)
                ->with(['destination', 'activities'])
                ->latest()
                ->paginate(9);
        }

        $destinations = Destination::where('is_active', true)->orderBy('sort_order')->get();
        $activities = Activity::where('is_active', true)->get();

        return view('package-combos', compact('combos', 'destinations', 'activities'));
    }
}

