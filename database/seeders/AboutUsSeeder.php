<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AboutUsSeeder extends Seeder
{
    public const TITLE = 'About Us — Introducing Chestnut Travel';

    public const CATEGORY = 'About Us';

    public const EXCERPT = 'Chestnut Travel is a leading, trusted tour operator based in Hanoi, offering unique authentic local travel experiences across the Ha Giang Loop, Sa Pa, Lan Ha Bay, Ninh Binh and all over Vietnam.';

    public const TAGS = ['About Us', 'Introduction', 'Chestnut Travel', 'Vietnam Travel'];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update About Us article
        Post::updateOrCreate(
            ['slug' => 'about-us'],
            [
                'title' => self::TITLE,
                'category' => self::CATEGORY,
                'excerpt' => self::EXCERPT,
                'featured_image' => 'https://images.unsplash.com/photo-1528127269322-539801943592?auto=format&fit=crop&w=1600&q=85',
                'author_name' => 'Chestnut Travel Team',
                'tags' => self::TAGS,
                'is_published' => true,
                'is_featured' => true,
                'published_at' => Carbon::now(),
                'views_count' => 128,
                'content' => self::content(),
            ]
        );

        // Also add or update "About Us" in the header menu if not present
        $menu = Menu::where('code', 'header')->first();
        if ($menu && is_array($menu->items)) {
            $items = $menu->items;
            $hasAbout = false;
            foreach ($items as $it) {
                if (($it['url'] ?? '') === '/about-us' || in_array($it['title'] ?? '', ['About Us', 'Giới thiệu'], true)) {
                    $hasAbout = true;
                    break;
                }
            }

            if (!$hasAbout) {
                // Insert "About Us" right after "Home" (at index 1)
                $newItem = [
                    'title' => 'About Us',
                    'url' => '/about-us',
                    'type' => 'link',
                    'badge' => '',
                    'target' => '_self',
                    'is_active' => true,
                ];

                array_splice($items, 1, 0, [$newItem]);
                $menu->items = $items;
                $menu->save();
            }
        }
    }

    /**
     * About Us article body (HTML).
     */
    public static function content(): string
    {
        return <<<'HTML'
<div class="space-y-6">
    <!-- Intro Highlights Callout -->
    <div class="bg-gradient-to-r from-teal-50 to-emerald-50 border-l-4 border-[#26786e] p-5 sm:p-6 rounded-r-2xl shadow-sm">
        <p class="text-sm sm:text-base font-semibold text-teal-900 leading-relaxed italic mb-0">
            "Handling all your travel issues — Experience travel with trust and comfort, let us make your journey memorable."
        </p>
        <span class="block text-xs font-bold text-[#26786e] uppercase tracking-wider mt-2">— The Chestnut Travel founding team</span>
    </div>

    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight pt-2">
        1. About Chestnut Travel — Born from a Passion for Discovery
    </h2>

    <p class="text-gray-700 leading-relaxed">
        Welcome to <strong>Chestnut Travel</strong>, your trusted companion on a journey to discover the breathtaking beauty and rich culture of Vietnam. Headquartered in the heart of Hanoi's thousand-year-old Old Quarter, we are a young, passionate team of Vietnamese locals who know every corner of our homeland.
    </p>

    <p class="text-gray-700 leading-relaxed">
        At Chestnut Travel, we understand that every traveler has their own interests, expectations and travel style. That is why we don't simply sell fixed tours — we listen carefully to create <strong>unique tailor-made journeys (Customized Tours)</strong>, from relaxing escapes on emerald bays to captivating motorbike adventures through the mountains of the Northeast.
    </p>

    <!-- Tripadvisor Choice Banner -->
    <div class="my-8 p-6 bg-[#26786e]/5 border border-[#26786e]/20 rounded-2xl flex flex-col sm:flex-row items-center gap-5">
        <img src="https://chestnuttravel.net/wp-content/uploads/2026/03/68924ea5265fcab08277e6f3_TCBR_green_BF_Logo_L_2025_RGB-170x170.webp"
             alt="Tripadvisor Travellers Choice" class="w-20 h-20 object-contain shrink-0">
        <div>
            <span class="text-xs font-extrabold uppercase text-[#26786e] tracking-wider">Prestigious recognition</span>
            <h4 class="text-lg font-bold text-gray-900">Tripadvisor Travellers' Choice Award 2025</h4>
            <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                We are honored to have received the Travellers' Choice award from the global TripAdvisor community, recognizing the outstanding satisfaction of the thousands of travelers worldwide who have explored with Chestnut Travel.
            </p>
        </div>
    </div>

    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight pt-2">
        2. Four Core Values That Make the Difference
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 my-6">
        <div class="p-5 rounded-2xl bg-white border border-gray-200 shadow-sm hover:border-[#26786e] transition">
            <div class="w-10 h-10 rounded-xl bg-teal-100 text-[#26786e] flex items-center justify-center font-bold text-lg mb-3">
                <i class="fa-solid fa-map-location-dot"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-base mb-1">Local Experts</h3>
            <p class="text-xs text-gray-600 leading-relaxed">
                Our guides and Easy Rider drivers were born and raised locally. We take you to secret viewpoints, authentic local food and genuine encounters with the local people.
            </p>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-gray-200 shadow-sm hover:border-[#26786e] transition">
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-lg mb-3">
                <i class="fa-solid fa-hand-holding-dollar"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-base mb-1">Best Price Guaranteed</h3>
            <p class="text-xs text-gray-600 leading-relaxed">
                Chestnut Travel works directly with limousine operators, cruises, hotels and family homestays, giving you the best possible price with no middlemen.
            </p>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-gray-200 shadow-sm hover:border-[#26786e] transition">
            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-lg mb-3">
                <i class="fa-solid fa-headset"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-base mb-1">24/7 Support (Always By Your Side)</h3>
            <p class="text-xs text-gray-600 leading-relaxed">
                Our customer care team is available 24/7 via WhatsApp, hotline and Zalo. We proactively follow your journey to make sure any issue is resolved smoothly.
            </p>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-gray-200 shadow-sm hover:border-[#26786e] transition">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-lg mb-3">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-base mb-1">Safety & Full Insurance</h3>
            <p class="text-xs text-gray-600 leading-relaxed">
                Every trip comes with certified helmets, modern, strictly inspected vehicles and comprehensive travel insurance for every passenger.
            </p>
        </div>
    </div>

    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight pt-2">
        3. Our Signature Travel Services
    </h2>

    <ul class="space-y-3 text-gray-700 text-sm sm:text-base leading-relaxed pl-2">
        <li class="flex items-start gap-2.5">
            <i class="fa-solid fa-circle-check text-[#26786e] mt-1 shrink-0"></i>
            <span><strong>Ha Giang Loop Tour:</strong> Explore the legendary Ma Pi Leng Pass, the Nho Que River and Tu San Canyon by motorbike with an Easy Rider or by VIP vehicle.</span>
        </li>
        <li class="flex items-start gap-2.5">
            <i class="fa-solid fa-circle-check text-[#26786e] mt-1 shrink-0"></i>
            <span><strong>Sa Pa Trekking & Villages:</strong> Conquer Fansipan, the Roof of Indochina, and trek through the Muong Hoa Valley, Ta Van and Y Linh Ho.</span>
        </li>
        <li class="flex items-start gap-2.5">
            <i class="fa-solid fa-circle-check text-[#26786e] mt-1 shrink-0"></i>
            <span><strong>Lan Ha Bay & Cat Ba Cruises:</strong> Enjoy a luxury boutique cruise, kayak through the Dark & Bright Caves and swim in emerald waters.</span>
        </li>
        <li class="flex items-start gap-2.5">
            <i class="fa-solid fa-circle-check text-[#26786e] mt-1 shrink-0"></i>
            <span><strong>Ninh Binh World Heritage:</strong> Take a boat through Trang An and Tam Coc - Bich Dong, and admire the panoramic view from the top of Mua Cave.</span>
        </li>
        <li class="flex items-start gap-2.5">
            <i class="fa-solid fa-circle-check text-[#26786e] mt-1 shrink-0"></i>
            <span><strong>Customized Tours:</strong> Itineraries built around the needs of families, companies and groups of friends at the best possible price.</span>
        </li>
    </ul>

    <!-- Legal & Contact Box -->
    <div class="mt-8 p-6 bg-gray-50 border border-gray-200 rounded-2xl space-y-3">
        <h3 class="font-bold text-gray-900 text-base flex items-center gap-2">
            <i class="fa-solid fa-building-columns text-[#26786e]"></i>
            Company Information & Operating License
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-gray-600 pt-2">
            <div>
                <strong>Brand name:</strong> Chestnut Travel
            </div>
            <div>
                <strong>International Tour Operator License:</strong> No. 01-1898/2023/TCDL-GP LHQT
            </div>
            <div>
                <strong>Office address:</strong> 95h Ly Nam De, Cua Dong, Hoan Kiem, Hanoi
            </div>
            <div>
                <strong>Hotline / WhatsApp:</strong> +84 867 216 850
            </div>
            <div>
                <strong>Support email:</strong> info@chestnuttravel.net
            </div>
            <div>
                <strong>Opening hours:</strong> 07:30 - 22:00 (Daily)
            </div>
        </div>
    </div>
</div>
HTML;
    }
}
