<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Trekking For Beginners',
                'slug' => 'trekking-for-beginners',
                'category' => 'Travel Guide',
                'excerpt' => 'Starting trekking for the first time takes experience—and confidence. Chestnut Travel shares full A‑to‑Z trekking tips to help make your journey as smooth and rewarding as possible.',
                'featured_image' => 'posts/trekking-beginners.png',
                'author_name' => 'admin',
                'tags' => ['Trekking', 'vietnam', 'vietnamtravel', 'vietnamtrek', 'vietnamtrekking'],
                'is_published' => true,
                'is_featured' => true,
                'published_at' => Carbon::parse('2025-10-08 14:36:13'),
                'content' => <<<'HTML'
<p class="wp-block-paragraph">Starting trekking for the first time takes experience—and confidence. Chestnut Travel shares full A‑to‑Z trekking tips to help make your journey as smooth and rewarding as possible.</p>

<hr class="wp-block-separator has-alpha-channel-opacity my-8 border-gray-200"/>

<h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4"><strong>1. Prepare Your Trek: Choose the Right Route</strong></h3>

<p class="mb-4 text-gray-700 leading-relaxed">As a beginner, avoid routes that are dangerous or extremely challenging. Instead, select simpler trails with fewer obstacles to build your confidence step by step. Be mindful of the trail conditions: muddy, dusty, humid, length, and altitude—so you can plan appropriately.</p>

<p class="mb-4 text-gray-700 leading-relaxed">Before you go, check out our article on <strong>basic trekking trails for first-time hikers</strong>.</p>

<p class="mb-6 text-gray-700 leading-relaxed">Also assess your personal fitness—make sure the route aligns with your endurance level. Know your limitations and plan accordingly.</p>

<figure class="my-8 rounded-2xl overflow-hidden shadow-sm">
    <img src="/storage/posts/trekking-trail.png" alt="Trekking Trail Preparation" class="w-full h-auto object-cover rounded-2xl" />
    <figcaption class="text-xs text-gray-500 text-center mt-2 italic">Scenic trails through northern mountain ranges in Vietnam</figcaption>
</figure>

<hr class="wp-block-separator has-alpha-channel-opacity my-8 border-gray-200"/>

<h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4"><strong>2. Proper Pre-Trek Preparation Is Key</strong></h3>

<p class="mb-4 text-gray-700 leading-relaxed">Be sure to check out our detailed post on trekking skills for new hikers.</p>

<p class="mb-2 font-semibold text-gray-900">✔️ <strong>Physical Fitness + Mental Readiness</strong></p>
<p class="mb-4 text-gray-700 leading-relaxed pl-5">Trekking demands endurance. You will walk long distances and navigate varied terrain—mountains, forests, sand dunes, rocky cliffs. Without regular training, it’s easy to feel exhausted or suffer minor injuries like sprains. Start exercising 2–3 weeks before your trek—walking, running, or stair climbing—to build stamina.</p>
<p class="mb-6 text-gray-700 leading-relaxed pl-5">Equally important: stay mentally strong. Trekking can be mentally challenging, and fear or negativity can weaken your motivation. A positive mindset paired with good physical fitness is vital for success.</p>

<p class="mb-2 font-semibold text-gray-900">✔️ <strong>Research Your Route Thoroughly</strong></p>
<p class="mb-6 text-gray-700 leading-relaxed pl-5">Understand the trail before you go to avoid getting lost. Join tours led by experienced leaders who know the terrain well. Alternatively, hire local guides or porters familiar with the area. If trekking solo, use tools like a compass, GPS device, or track log—but make sure you know how to use them beforehand.</p>

<p class="mb-2 font-semibold text-gray-900">✔️ <strong>Check the Weather Carefully</strong></p>
<p class="mb-6 text-gray-700 leading-relaxed pl-5">Weather can make or break your trek. Monitor forecasts at least one week before departure using reliable sources—TV, weather sites, or mobile apps—to plan your clothing and timing accordingly.</p>

<p class="mb-2 font-semibold text-gray-900">✔️ <strong>Confirm with Your Agent or Guide Before Departure</strong></p>
<p class="mb-6 text-gray-700 leading-relaxed pl-5">A few days before your trip, double-check all details with your tour operator or guide—schedule, logistics, necessary documents, pick-up times, etc. It ensures smooth coordination and lets you address any changes in advance.</p>

<hr class="wp-block-separator has-alpha-channel-opacity my-8 border-gray-200"/>

<h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4"><strong>3. Essential Gear to Bring</strong></h3>

<p class="mb-2 font-semibold text-gray-900">✔️ <strong>Clothing</strong></p>
<p class="mb-6 text-gray-700 leading-relaxed pl-5">Opt for breathable, flexible sportswear with multiple pockets. Avoid stiff jeans—they restrict movement and don't allow for sweat evaporation. Pack minimal layers and bring a jacket—nights in the forest can get chilly.</p>

<p class="mb-2 font-semibold text-gray-900">✔️ <strong>Footwear</strong></p>
<p class="mb-6 text-gray-700 leading-relaxed pl-5">Use quality trekking shoes with good grip, cushioning, water resistance, and ankle support. If shoes get wet, having a pair of sandals or rain slippers on hand is useful. Don’t wear shoes that are too tight—they cause blisters quickly during long hikes.</p>

<p class="mb-2 font-semibold text-gray-900">✔️ <strong>Water & Food</strong></p>
<p class="mb-6 text-gray-700 leading-relaxed pl-5">Plan water intake based on your itinerary—for a 2–3 day trek, carry about 3–4 liters. Refill from streams or locals along the trail. Bring light, compact snacks with high calorie content for energy boosts—avoid perishable items.</p>

<p class="mb-2 font-semibold text-gray-900">✔️ <strong>Backpack, Trekking Poles & Flashlight</strong></p>
<p class="mb-6 text-gray-700 leading-relaxed pl-5">Choose a medium-sized pack—small enough to move easily, big enough to hold essentials. Waterproof and breathable materials are ideal. A headlamp or wide-beam flashlight is crucial after dark. Trekking poles help with balance, reduce muscle fatigue, and support descent control.</p>

<p class="mb-2 font-semibold text-gray-900">✔️ <strong>First Aid Supplies</strong></p>
<p class="mb-6 text-gray-700 leading-relaxed pl-5">Pack basics like painkillers, anti-inflammatory meds, mosquito/leeches repellent, antiseptic, bandages, personal prescriptions, and vitamin C. Know how to use each item—basic first aid skills are a must.</p>

<p class="mb-2 font-semibold text-gray-900">✔️ <strong>Personal Documents & Money</strong></p>
<p class="mb-6 text-gray-700 leading-relaxed pl-5">Bring ID/passport—you may need it at forest checkpoints or park management gates. Carry only a small amount of cash split into safe stashes. Use a waterproof pouch inside your backpack for valuables.</p>

<p class="mb-2 font-semibold text-gray-900">✔️ <strong>Optional</strong></p>
<p class="mb-6 text-gray-700 leading-relaxed pl-5">If backpacking solo, bring a sleeping bag, tent, or hammock. On a guided tour, these are usually provided. Also consider packing lightweight electronics—power bank, phone, camera, etc.</p>

<hr class="wp-block-separator has-alpha-channel-opacity my-8 border-gray-200"/>

<h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4"><strong>4. Additional Tips for Safe Trekking</strong></h3>

<ul class="space-y-2 mb-6 text-gray-700 pl-5">
    <li>✔️ <strong>Don’t Litter</strong>: Preserve the natural environment and leave no trace behind.</li>
    <li>✔️ <strong>Never Split From the Group</strong>: Even the experienced get lost when trekking alone in unfamiliar mountain territory.</li>
    <li>✔️ <strong>Avoid Eating Wild Plants or Mushrooms</strong>: Stick to safe, known foods. Don’t pick flowers or damage wild ecosystems.</li>
    <li>✔️ <strong>No Campfires</strong>: Strictly observe fire safety rules to prevent any risk of forest fires.</li>
    <li>✔️ <strong>Leave Nature Untouched</strong>: Respect local ethnic minority customs and preserve sacred natural sanctuaries.</li>
</ul>

<hr class="wp-block-separator has-alpha-channel-opacity my-8 border-gray-200"/>

<p class="text-gray-700 font-medium leading-relaxed italic bg-emerald-50/70 p-5 rounded-2xl border border-emerald-100">
    With these A‑to‑Z trekking tips from Chestnut Travel, you’re well-equipped for a safe and enriching mountain adventure. Contact our team anytime for tailored trekking packages in Sa Pa, Fansipan, Pu Luong, or Mu Cang Chai!
</p>
HTML
            ],
            [
                'title' => 'Mu Cang Chai Top Attractions',
                'slug' => 'mu-cang-chai-top-attractions',
                'category' => 'Travel Guide',
                'excerpt' => 'Mu Cang Chai, nestled in the mountainous province of Yen Bai in northwest Vietnam, is a destination of stunning beauty, rich culture, and thrilling adventures.',
                'featured_image' => 'posts/mu-cang-chai-attractions.png',
                'author_name' => 'admin',
                'tags' => ['Mu Cang Chai', 'Yen Bai', 'terraced fields', 'vietnam'],
                'is_published' => true,
                'is_featured' => true,
                'published_at' => Carbon::parse('2025-10-08 13:20:00'),
                'content' => <<<'HTML'
<p class="wp-block-paragraph">Mu Cang Chai, nestled in the mountainous province of Yen Bai in northwest Vietnam, is a destination of stunning beauty, vibrant ethnic minority cultures, and unparalleled golden terraced landscapes.</p>

<h3 class="text-xl sm:text-2xl font-bold text-gray-900 my-4"><strong>1. Raspberry Hill (Doi Mam Xoi)</strong></h3>
<p class="mb-4 text-gray-700 leading-relaxed">Located in La Pan Tan village, Raspberry Hill is perhaps the most famous photography icon of Mu Cang Chai. The circular terraces form a picturesque dome that turns radiant gold every autumn between late September and mid-October.</p>

<h3 class="text-xl sm:text-2xl font-bold text-gray-900 my-4"><strong>2. Horseshoe Hill (Doi Mong Ngua)</strong></h3>
<p class="mb-4 text-gray-700 leading-relaxed">Situated in Sang Nhu village, Horseshoe Hill offers dramatic crescent-shaped terraces carved into steep ridges. Sunset here is world-renowned as rays of golden sunlight drape over the glistening rice fields.</p>

<h3 class="text-xl sm:text-2xl font-bold text-gray-900 my-4"><strong>3. Khau Pha Pass</strong></h3>
<p class="mb-4 text-gray-700 leading-relaxed">One of the "Four Great Mountain Passes" of Northern Vietnam, Khau Pha winds through misty mountain peaks and overlooks the expansive Lim Mong valley. It is also a premier destination for paragliding festivals.</p>
HTML
            ],
            [
                'title' => 'Mu Cang Chai: Your Ultimate Guide To The Stunning Terraced Rice Fields',
                'slug' => 'mu-cang-chai-your-ultimate-guide-to-the-stunning-terraced-rice-fields',
                'category' => 'Travel Guide',
                'excerpt' => 'Mu Cang Chai is a small mountainous region located in Yen Bai province, in northwest Vietnam. Nestled at an average altitude of 1,000 meters above sea level, it features breathtaking landscapes.',
                'featured_image' => 'posts/mu-cang-chai-guide.png',
                'author_name' => 'admin',
                'tags' => ['Mu Cang Chai', 'travel guide', 'vietnam', 'rice fields'],
                'is_published' => true,
                'is_featured' => true,
                'published_at' => Carbon::parse('2025-10-08 12:10:00'),
                'content' => <<<'HTML'
<p class="wp-block-paragraph">Mu Cang Chai is a small mountainous region located in Yen Bai province, in northwest Vietnam. Nestled at an average altitude of 1,000 meters above sea level, the terraced rice fields here were carved by generations of H'mong people over hundreds of years.</p>

<h3 class="text-xl sm:text-2xl font-bold text-gray-900 my-4"><strong>When is the Best Time to Visit?</strong></h3>
<p class="mb-4 text-gray-700 leading-relaxed">There are two prime seasons to visit Mu Cang Chai:</p>
<ul class="list-disc pl-6 space-y-2 text-gray-700 mb-6">
    <li><strong>Water Pouring Season (May – June):</strong> When summer rains flood the terraces, turning the mountainsides into shimmering mirrors reflecting the sky and clouds.</li>
    <li><strong>Ripe Rice Season (September – October):</strong> The entire valley transforms into glowing yellow and golden hues, with intoxicating aromas of fresh harvested rice filling the cool autumn air.</li>
</ul>

<h3 class="text-xl sm:text-2xl font-bold text-gray-900 my-4"><strong>How to Get There from Hanoi</strong></h3>
<p class="mb-4 text-gray-700 leading-relaxed">Mu Cang Chai is approximately 300km from Hanoi. Travelers can take overnight sleeper buses from My Dinh bus station, book private limousine transfers, or embark on a multi-day motorbike adventure through Nghia Lo and Tu Le.</p>
HTML
            ],
            [
                'title' => 'Planning a Trip from Hanoi to Ha Giang? Here’s Everything You Need to Know',
                'slug' => 'from-hanoi-to-ha-giang-need-to-know',
                'category' => 'Ha Giang Loop',
                'excerpt' => 'From transportation options, bus tickets, motorbike rentals to must-see spots along the loop, here is the complete guide for traveling from Hanoi to Ha Giang.',
                'featured_image' => 'posts/hanoi-to-hagiang.png',
                'author_name' => 'admin',
                'tags' => ['Ha Giang', 'Hanoi', 'Easy Rider', 'Motorbike Loop'],
                'is_published' => true,
                'is_featured' => false,
                'published_at' => Carbon::parse('2025-06-15 09:00:00'),
                'content' => <<<'HTML'
<p class="wp-block-paragraph">Ha Giang is Vietnam's final northern frontier, boasting karst limestone peaks, plunging canyons, and vibrant ethnic cultures. Here is everything you need to know before leaving Hanoi for the legendary Ha Giang Loop.</p>
HTML
            ],
            [
                'title' => 'Discover the Heart of Hanoi: 16 Unmissable Attractions',
                'slug' => 'discover-the-heart-of-hanoi-16-attractions',
                'category' => 'Hanoi Discovery',
                'excerpt' => 'Explore the vibrant capital of Vietnam with our curated list of 16 must-visit cultural, historical, and culinary spots in Hanoi.',
                'featured_image' => 'posts/heart-of-hanoi.png',
                'author_name' => 'admin',
                'tags' => ['Hanoi', 'Old Quarter', 'Food Tour', 'Culture'],
                'is_published' => true,
                'is_featured' => false,
                'published_at' => Carbon::parse('2025-08-20 10:30:00'),
                'content' => <<<'HTML'
<p class="wp-block-paragraph">From the tranquil waters of Hoan Kiem Lake to the bustling alleys of the Old Quarter and the aroma of steaming Pho Bat Dan, Hanoi is a city that captures every traveler's heart.</p>
HTML
            ],
        ];

        foreach ($posts as $postData) {
            Post::updateOrCreate(
                ['slug' => $postData['slug']],
                $postData
            );
        }
    }
}
