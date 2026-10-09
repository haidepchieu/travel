<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Translates the customer-facing content stored in the database from Vietnamese to English.
 * Safe to run more than once: rows are updated by id / key / slug and missing rows are skipped.
 *
 * php artisan db:seed --class=EnglishContentSeeder
 */
class EnglishContentSeeder extends Seeder
{
    private const TOUR_INCLUSIONS = [
        'High-quality round-trip transfers (VIP Limousine / comfortable sleeper bus)',
        'Touring motorbike with a driver who doubles as a knowledgeable local guide',
        'Comfortable homestay or standard hotel rooms as per the itinerary',
        'Main meals featuring local specialties',
        'Entrance tickets to all attractions in the itinerary',
        'Boat trip through Tu San Canyon on the emerald Nho Que River',
        'Safety gear: certified helmets, arm and knee protectors',
        'Purified drinking water throughout the journey',
        'Comprehensive travel insurance with high coverage',
    ];

    private const TOUR_EXCLUSIONS = [
        'Extra drinks ordered during meals',
        'Personal expenses outside the program (laundry, phone calls, shopping)',
        'Single room supplement (if you prefer a private room)',
        'Tips for drivers and guides (at your discretion)',
        'VAT 8-10% (if an official VAT invoice is required)',
    ];

    private const TOUR_FAQS = [
        [
            'question' => "I've never ridden a motorbike on mountain passes before. Is it safe?",
            'answer' => 'Absolutely! You will ride with our local Easy Rider drivers, who have more than 5 years of experience on challenging mountain passes, and you will be fully equipped with protective gear.',
        ],
        [
            'question' => 'I am vegetarian or have food allergies. Can you accommodate me?',
            'answer' => 'Yes! Just add a note to your booking or let our travel consultant know in advance, and we will prepare vegetarian or suitable meals especially for you.',
        ],
        [
            'question' => 'What should I pack for the trip?',
            'answer' => 'We recommend comfortable sneakers, a warm windproof jacket (nights and early mornings in the highlands are often cold), a power bank, sunscreen and your ID/passport.',
        ],
        [
            'question' => 'What is the best time of year to take this tour?',
            'answer' => 'Every season in Northern Vietnam has its own charm: spring brings vibrant peach and plum blossoms, summer has lush green rice fields, autumn (September-October) is the golden rice harvest, and winter (October-December) is buckwheat flower and cloud-hunting season.',
        ],
    ];

    public function run(): void
    {
        $this->translateTours();
        $this->translateItineraries();
        $this->translateComboItems();
        $this->translateDestinations();
        $this->translateExtraServices();
        $this->translateOptions();
        $this->translateMenus();
        $this->translatePosts();
        $this->translateReviews();
        $this->translateBookings();

        if (class_exists(\App\Models\Option::class)) {
            \App\Models\Option::clearCache();
        }

        $this->command?->info('Customer-facing database content translated to English.');
    }

    private function translateTours(): void
    {
        $shared = [
            'inclusions' => self::TOUR_INCLUSIONS,
            'exclusions' => self::TOUR_EXCLUSIONS,
            'faqs' => self::TOUR_FAQS,
        ];

        $tours = [
            1 => [
                'title' => 'Ha Giang Loop Tour 4 Days 3 Nights (Ultimate Experience)',
                'tagline' => 'Best seller - The complete legendary loop',
                'overview' => "This 4-day, 3-night journey takes you over some of the world's most spectacular mountain passes: Ma Pi Leng Pass, Tu San Canyon, Bac Sum Slope, Quan Ba Heaven Gate, the H'Mong King's Palace and the crystal-clear Du Gia waterfall. Experience the vibrant cultures of the H'Mong, Tay and Dao peoples.",
                'trip_type' => 'Motorbike with driver (Easy Rider)',
                'departure_from' => 'Hanoi / Ha Giang City',
                'transportation' => 'VIP Limousine & touring motorbike',
                'group_size' => 'Small group of 6 - 10 people',
                'difficulty' => 'Medium',
                'highlights' => [
                    'Conquer Ma Pi Leng, one of the four great passes, and take in the panoramic Nho Que River',
                    'Cruise through Tu San Canyon, the deepest canyon in Southeast Asia',
                    'Explore the mysterious ancient architecture of the Vuong Family Palace (H\'Mong King)',
                    'Swim in the cool natural waterfall of peaceful Du Gia village',
                    'Taste highland specialties: thang co, men men, black chicken hotpot and buckwheat cakes',
                ],
            ],
            2 => [
                'title' => 'Ha Giang Loop Tour 3 Days 2 Nights (Essential Journey)',
                'tagline' => 'The #1 choice for travelers short on time',
                'overview' => 'A carefully optimized itinerary so you can explore the very best of the Dong Van Karst Plateau in just 3 days and 2 nights, while staying safe and enjoying the scenery at a relaxed pace.',
                'trip_type' => 'Motorbike with driver (Easy Rider)',
                'departure_from' => 'Hanoi / Ha Giang City',
                'transportation' => 'VIP Limousine & touring motorbike',
                'group_size' => 'Small group of 6 - 10 people',
                'difficulty' => 'Medium',
                'highlights' => [
                    'The legendary Ma Pi Leng Pass and a boat trip on the Nho Que River',
                    'Stroll through the sparkling Dong Van Old Quarter at night',
                    'Visit Lung Cu Flag Tower - the sacred northernmost point of Vietnam',
                    'Cultural exchange by the fireside with local people',
                ],
            ],
            3 => [
                'title' => 'Sa Pa Trekking Tour: Muong Hoa Valley & Villages 3D2N',
                'tagline' => 'Immerse yourself in nature and authentic local culture',
                'overview' => 'Leave the noisy city behind to walk along the spectacular rice terraces of the Muong Hoa Valley, spend the night in Giay and Red Dao homestays, enjoy a herbal foot bath and share a cozy home-cooked meal.',
                'trip_type' => 'Trekking & local hiking',
                'departure_from' => 'Hanoi / Sa Pa',
                'transportation' => 'Cabin sleeper bus & walking',
                'group_size' => 'Small group of 6 - 8 people',
                'difficulty' => 'Medium',
                'highlights' => [
                    'Trek through the most beautiful rice terraces of the Muong Hoa Valley',
                    'Discover traditional life in Y Linh Ho, Lao Chai and Ta Van villages',
                    'Try the traditional Red Dao herbal bath',
                    'Stay in a homestay overlooking romantic rice terraces',
                ],
            ],
            4 => [
                'title' => 'Lan Ha Bay & Cat Ba Island Boutique Cruise 2D1N',
                'tagline' => 'Private space - Pristine, untouched waters',
                'overview' => 'Enjoy a luxurious getaway on a boutique cruise amid the emerald waters of Lan Ha Bay. Kayak through limestone caves, swim at Ba Trai Dao beach and watch a romantic sunset from the deck.',
                'trip_type' => 'Leisure cruise',
                'departure_from' => 'Hanoi / Hai Phong',
                'transportation' => 'Limousine & luxury cruise',
                'group_size' => 'Cruise group',
                'difficulty' => 'Easy',
                'highlights' => [
                    'Private balcony cabin with full views of Lan Ha Bay',
                    'Kayak and paddleboard through the Bright & Dark Caves',
                    'Swim at the pristine natural beach of Ba Trai Dao',
                    'Premium fresh seafood dinner and a sunset afternoon tea party',
                ],
            ],
            5 => [
                'title' => 'Ninh Binh Day Tour: Trang An Boat Ride & Mua Cave Peak',
                'tagline' => 'UNESCO dual World Heritage site - all in one day',
                'overview' => 'The perfect day trip from Hanoi: glide by sampan through the water caves of Trang An and climb nearly 500 stone steps up Mua Cave for a breathtaking panorama of Tam Coc.',
                'trip_type' => 'Premium small-group tour',
                'departure_from' => 'Hanoi',
                'transportation' => 'Premium Limousine',
                'group_size' => 'Small group of max. 15 people',
                'difficulty' => 'Easy',
                'highlights' => [
                    'Take a traditional boat through the Trang An heritage complex',
                    'Climb the Dragon Mountain at Mua Cave for a panoramic view',
                    'Visit Hoa Lu Ancient Capital - the first capital of Dai Co Viet',
                    'Cycle leisurely among rice fields and limestone mountains',
                    'Enjoy a buffet lunch of Ninh Binh specialties: goat meat and crispy rice',
                ],
            ],
            6 => [
                'title' => 'Ta Xua Cloud Hunting & Dinosaur Spine Tour 2D1N',
                'tagline' => 'Touch the floating sea of clouds in the Northwest mountains',
                'overview' => 'A journey for adventurous souls to the "cloud paradise" of Ta Xua. Stand on top of the Hang Dong Dinosaur Spine with a rolling sea of clouds below your feet, and sip coffee while watching stunning sunsets and sunrises.',
                'trip_type' => 'Trekking & cloud hunting',
                'departure_from' => 'Hanoi',
                'transportation' => 'Modern tourist vehicle',
                'group_size' => 'Small group of 8 - 12 people',
                'difficulty' => 'Challenging',
                'highlights' => [
                    'Conquer the majestic Hang Dong Dinosaur Spine',
                    'Snap photos at the famous Dolphin Rock and Ta Xua Lonely Tree',
                    'Taste centuries-old Shan Tuyet tea',
                    'Enjoy black chicken hotpot and highland barbecue in the crisp mountain air',
                ],
            ],
            7 => [
                'title' => 'Northern Vietnam Combo: 6 Days Sa Pa - Ha Giang - Ninh Binh',
                'tagline' => 'An all-in-one journey with great savings',
                'overview' => "An all-inclusive combo package combining three of Northern Vietnam's top destinations: explore the rice terraces of Sa Pa, ride the Ha Giang Loop across the karst plateau by motorbike, and cruise the Trang An heritage site in Ninh Binh. Optimized travel time and outstanding savings.",
                'trip_type' => 'All-inclusive Combo Package',
                'departure_from' => 'Hanoi',
                'transportation' => 'VIP Limousine & motorbike with driver',
                'group_size' => 'Flexible small group',
                'difficulty' => 'Easy',
                'highlights' => [
                    'Conquer Fansipan (3,143m), the Roof of Indochina, in Sa Pa',
                    'Ride the thrilling Ma Pi Leng Pass and take a boat on the Nho Que River in Ha Giang',
                    'Cruise through the natural heritage of Trang An, Ninh Binh',
                    'All transport, accommodation and guides included',
                ],
                'combo_badge' => 'Best-Selling Combo',
            ],
            8 => [
                'title' => 'Ha Giang Loop Tour 5 Days 4 Nights (In-Depth Expedition)',
                'tagline' => 'Reach remote frontier lands few travelers know',
                'overview' => 'An extended 5-day journey that goes deeper into remote highland villages such as Thuong Phung and Xin Man, with buckwheat flower fields and an authentic look at rural life untouched by mass tourism.',
                'trip_type' => 'Motorbike with driver (Easy Rider)',
                'departure_from' => 'Hanoi / Ha Giang City',
                'transportation' => 'Limousine & motorbike',
                'group_size' => 'Small group of 6 - 8 people',
                'difficulty' => 'Medium',
                'highlights' => [
                    'The complete Ma Pi Leng Pass, Nho Que River and Lung Cu Flag Tower',
                    'Explore Tu San Canyon and the Vietnam - China border road',
                    'Stay in authentic local homestays in Du Gia and Nam Dam',
                    'Unhurried trekking and photography stops',
                ],
            ],
            9 => [
                'title' => 'Sa Pa Tour: Fansipan Peak & Cat Cat Village 2D1N',
                'tagline' => 'Reach the legendary 3,143m Roof of Indochina',
                'overview' => "The ideal 2-day, 1-night trip to admire the sea of clouds from majestic Fansipan via the world-record cable car, stroll through charming Cat Cat village and enjoy Northwest Vietnam's cuisine.",
                'trip_type' => 'Discovery & leisure',
                'departure_from' => 'Hanoi / Sa Pa',
                'transportation' => 'Premium double-cabin sleeper bus',
                'group_size' => 'Small group',
                'difficulty' => 'Medium',
                'highlights' => [
                    'Conquer Fansipan (3,143m) with views over the Hoang Lien Son range',
                    'Stroll through beautiful Cat Cat village beside the Tien Sa stream',
                    'Snap photos at Moana Sa Pa with romantic valley views',
                    'Taste salmon and sturgeon hotpot and Sa Pa barbecue',
                ],
            ],
            10 => [
                'title' => 'Ninh Binh Tour 2D1N: Tam Coc, Hoa Lu Ancient Capital & Thung Nham Bird Park',
                'tagline' => 'An eco journey through a thousand years of cultural heritage',
                'overview' => 'Explore Ninh Binh in more depth over 2 relaxed days: take a boat at sunset to watch flocks of birds return to Thung Nham, cycle through the rice fields of Tam Coc and find peace at Hoa Lu Ancient Capital.',
                'trip_type' => 'Eco & leisure',
                'departure_from' => 'Hanoi',
                'transportation' => 'Premium Limousine',
                'group_size' => 'Small group',
                'difficulty' => 'Easy',
                'highlights' => [
                    'Sunset boat trip at Thung Nham Eco-park',
                    'Row along the Ngo Dong River in Tam Coc',
                    'Visit the temples of King Dinh and King Le at sacred Hoa Lu',
                    'Overnight at an eco-resort in peaceful countryside',
                ],
            ],
            11 => [
                'title' => 'Lan Ha Bay & Cat Ba National Park 3D2N (Kayaking & Trekking)',
                'tagline' => 'Immerse yourself in primeval forest and emerald bays',
                'overview' => 'The perfect combination of a leisure cruise on Lan Ha Bay and trekking through the primeval forest of Cat Ba National Park, with a visit to the ancient fishing village of Viet Hai and scenic cycling.',
                'trip_type' => 'Cruise & kayaking',
                'departure_from' => 'Hanoi / Hai Phong',
                'transportation' => 'Limousine & cruise',
                'group_size' => 'Small group',
                'difficulty' => 'Easy',
                'highlights' => [
                    'Trek to Ngu Lam Peak for a panoramic view of Cat Ba National Park',
                    'Cycle through the forest to the peaceful ancient fishing village of Viet Hai',
                    'Kayak through hidden caves and sheltered lagoons',
                    'Swim at pristine beaches in the middle of Lan Ha Bay',
                ],
            ],
            12 => [
                'title' => 'Luxury Ha Long Bay Day Cruise: Sung Sot Cave & Ti Top Island',
                'tagline' => 'A luxurious one-day journey to a natural wonder of the world',
                'overview' => 'A 5-star day trip on a luxury cruise to the highlights of Ha Long Bay: the magnificent Sung Sot Cave, Ti Top Island with its panoramic bay views, and a bamboo boat ride at Luon Cave.',
                'trip_type' => 'Day cruise',
                'departure_from' => 'Hanoi / Tuan Chau',
                'transportation' => 'Premium Limousine & 5-star steel cruise',
                'group_size' => 'Cruise group',
                'difficulty' => 'Easy',
                'highlights' => [
                    'Explore Sung Sot Cave - the largest and most splendid cave in Ha Long Bay',
                    'Climb to the top of Ti Top for a full panoramic view of the bay',
                    'Kayak or take a bamboo boat to spot wild monkeys at Luon Cave',
                    'Enjoy a premium seafood buffet lunch on board',
                ],
            ],
            13 => [
                'title' => 'All-inclusive Combo 6 Days 5 Nights: Sa Pa - Ha Giang Loop - Ninh Binh (Deep Local Immersion)',
                'tagline' => "A combo package covering three of Northern Vietnam's wonders: Sa Pa, the Ha Giang Loop and Trang An in Ninh Binh.",
                'overview' => 'A superb combination for travelers who want the most authentic local culture of Northern Vietnam. Six optimized all-inclusive days, from the dramatic passes of Ha Giang and the cloud-topped Fansipan in Sa Pa to the natural World Heritage site of Trang An.',
                'trip_type' => 'All-inclusive Combo Package',
                'departure_from' => 'Hanoi',
                'transportation' => 'VIP Limousine & local motorbike',
                'group_size' => 'Small group',
                'difficulty' => 'Medium',
                'highlights' => [
                    'Conquer Ma Pi Leng Pass and take a boat on the Nho Que River',
                    'Trek the Muong Hoa Valley in Sa Pa and reach the top of Fansipan',
                    'Cruise through Trang An and admire the panorama from Mua Cave',
                    '24/7 support throughout from our professional operations team',
                ],
                'combo_badge' => 'Super Saver Combo',
            ],
        ];

        foreach ($tours as $id => $fields) {
            $this->updateRow('tours', ['id' => $id], array_merge($shared, $fields));
        }

        // Normalize any remaining Vietnamese difficulty values to the English values used by the site filters
        if (Schema::hasTable('tours')) {
            $difficultyMap = ['Dễ' => 'Easy', 'Vừa phải' => 'Medium', 'Trung bình' => 'Medium', 'Thử thách' => 'Challenging', 'Khó' => 'Difficult'];
            foreach ($difficultyMap as $vi => $en) {
                DB::table('tours')->where('difficulty', $vi)->update(['difficulty' => $en]);
            }
        }
    }

    private function translateItineraries(): void
    {
        $itineraries = [
            1 => [
                'title' => 'Day 1: Hanoi / Ha Giang City - Bac Sum Slope - Quan Ba Heaven Gate - Yen Minh',
                'description' => 'Depart Hanoi by Limousine to Ha Giang City. Meet your Easy Rider team and begin the journey up the winding Bac Sum Slope, stopping at Quan Ba Heaven Gate and the legendary Fairy Twin Mountains. In the afternoon, ride through the cool pine forests of Yen Minh, check in to your homestay and enjoy a cozy dinner.',
                'meals' => 'Lunch, Dinner',
                'accommodation' => 'Comfortable local homestay in Yen Minh',
            ],
            2 => [
                'title' => "Day 2: Yen Minh - Tham Ma Slope - H'Mong King's Palace - Dong Van Old Quarter",
                'description' => "Cross the beautifully winding Tham Ma Slope – Ha Giang's most famous photo spot. Visit the palace of H'Mong King Vuong Chinh Duc with its unique pomu wood architecture. In the afternoon, arrive at the Dong Van karst plateau to explore and enjoy coffee in the old quarter.",
                'meals' => 'Breakfast, Lunch, Dinner',
                'accommodation' => 'Hotel / homestay in central Dong Van town',
            ],
            3 => [
                'title' => 'Day 3: Dong Van - Ma Pi Leng Pass - Nho Que River Boat Trip - Du Gia Village',
                'description' => "The highlight of the whole journey! Conquer Ma Pi Leng Pass – one of Vietnam's four most dramatic mountain passes. Head down to the Tu San Canyon pier for a boat trip on the emerald Nho Que River. In the afternoon, ride through valleys full of buckwheat flowers to peaceful Du Gia village.",
                'meals' => 'Breakfast, Lunch, Dinner',
                'accommodation' => 'Tay wooden stilt-house homestay by the stream in Du Gia',
            ],
            4 => [
                'title' => 'Day 4: Du Gia Waterfall - Lung Tam Linen Weaving Village - Ha Giang City - Hanoi',
                'description' => "Relax with an early-morning swim at the crystal-clear Du Gia waterfall or take a walk around the village. Continue to the traditional Lung Tam linen weaving cooperative of the White H'Mong people. Return to Ha Giang City for a light lunch, then board the VIP Limousine back to Hanoi in the evening.",
                'meals' => 'Breakfast, Lunch',
                'accommodation' => 'Return to Hanoi (end of tour)',
            ],
            5 => [
                'title' => 'Hanoi – Got Pier – Lan Ha Bay – Kayaking at the Dark & Bright Caves – Sunset Party & Seafood Dinner on Board',
                'description' => <<<'HTML'
<p><strong>08:00 - 08:30:</strong> A premium Limousine picks you up in Hanoi's Old Quarter or at the Opera House and heads to Hai Phong on the new, modern and smooth Hanoi – Hai Phong expressway (only about 2.5 hours). There is a 20-minute rest stop along the way.</p>
<p><strong>11:30 - 12:00:</strong> Arrive at the harbor (Tuan Chau Port / Got Pier). The cruise staff warmly welcome you in the waiting lounge with cold towels and a welcome drink, then a tender boat takes you to the main cruise anchored in the emerald waters of Lan Ha Bay.</p>
<p><strong>12:30:</strong> Check in to your Deluxe cabin with a private bay-view balcony, and listen to the captain and cruise manager explain the safety rules and the detailed 2-day, 1-night itinerary.</p>
<p><strong>13:00:</strong> Enjoy a hearty lunch in the elegant restaurant with a menu of fresh, locally caught seafood, while the cruise slowly sails past thousands of spectacular limestone islands in all shapes and forms.</p>
<p><strong>15:00 - 16:30:</strong> The cruise anchors at the <strong>Dark & Bright Cave Lagoon</strong> – the stunning natural border between Ha Long Bay and Lan Ha Bay:</p>
<ul class="list-disc pl-5 my-2 space-y-1">
  <li>Paddle a double <strong>kayak</strong> through flooded limestone caves, admiring million-year-old stalactites and a hidden lagoon surrounded by sheer, tree-covered cliffs.</li>
  <li>Or choose a relaxing bamboo boat rowed by local fishermen.</li>
  <li>Swim freely, jump from the side of the boat into the clear blue water, or sunbathe on the Sun Deck.</li>
</ul>
<p><strong>17:30:</strong> Return to the cruise for the <strong>Sunset Party</strong> on deck. Enjoy complimentary fine wine, tropical cocktails and fresh fruit as you watch the red sun slowly set behind the limestone peaks of Lan Ha Bay – an unforgettable romantic experience.</p>
<p><strong>18:30:</strong> Join a traditional cooking demonstration led by the head chef: learn how to roll Vietnamese spring rolls or carve fruit and vegetables into art.</p>
<p><strong>19:30:</strong> Savor a premium seafood BBQ dinner with grilled lobster/tiger prawns, sea crab, steamed fish with soy sauce and refined Asian - European dishes under twinkling lights on the quiet night sea.</p>
<p><strong>21:00:</strong> Free evening activities: try your luck at night squid fishing with the crew, enjoy drinks at the open-air bar, listen to acoustic music or relax with a spa / massage treatment (at your own expense). Spend the night in peaceful surroundings to the gentle sound of the waves.</p>
HTML,
                'meals' => 'Lunch, Seafood dinner',
                'accommodation' => 'Private Deluxe cabin with bay-view balcony',
            ],
            6 => [
                'title' => 'Sunrise Tai Chi – Viet Hai Ancient Village (Cycling & Fish Spa) – Lan Ha Bay – Return to Hanoi',
                'description' => <<<'HTML'
<p><strong>06:00 - 06:30:</strong> Wake up early for a beautiful sunrise over Lan Ha Bay. Join an energizing <strong>Tai Chi</strong> class on deck while the morning mist drifts over the limestone peaks.</p>
<p><strong>06:45:</strong> Enjoy a light breakfast with fragrant tea and coffee, European pastries and nutritious cereals in the restaurant to fuel up for the morning.</p>
<p><strong>07:30 - 09:00:</strong> Board the tender to Viet Hai pier to discover <strong>Viet Hai Ancient Village</strong>, tucked away in a valley of Cat Ba National Park:</p>
<ul class="list-disc pl-5 my-2 space-y-1">
  <li>Go <strong>cycling or ride an electric cart</strong> along a nearly 5km shaded road through the primeval forest, past rice paddies and the old thatched mud-walled houses of local villagers.</li>
  <li>Relax with a <strong>natural fish spa</strong> foot soak beside a babbling, crystal-clear stream.</li>
  <li>Meet and chat with the villagers and learn about the simple, hospitable way of life of this old fishing community nestled in an untouched valley.</li>
</ul>
<p><strong>09:30:</strong> Return to the cruise to freshen up, pack your belongings and check out at the reception.</p>
<p><strong>10:00:</strong> Enjoy a generous buffet brunch as the cruise leisurely passes Cai Beo floating fishing village – one of the oldest fishing villages in Vietnam, with thousands of years of history.</p>
<p><strong>11:30 - 11:45:</strong> The cruise docks at Got Pier / Tuan Chau Port and the crew say goodbye.</p>
<p><strong>12:00:</strong> Board the high-quality Limousine back to Hanoi along the smooth, modern expressway.</p>
<p><strong>14:30 - 15:00:</strong> Arrive in Hanoi's Old Quarter, where the vehicle drops you at your hotel or original meeting point. End of a complete and memorable 2-day, 1-night Lan Ha Bay - Cat Ba cruise!</p>
HTML,
                'meals' => 'Light breakfast, Buffet lunch',
                'accommodation' => 'Limousine back to Hanoi',
            ],
        ];

        foreach ($itineraries as $id => $fields) {
            $this->updateRow('tour_itineraries', ['id' => $id], $fields);
        }
    }

    private function translateComboItems(): void
    {
        $items = [
            4 => [
                'stage_title' => "Stage 1: Sa Pa - H'Mong Village Trekking & Fansipan Peak",
                'transit_notes' => 'Premium VIP cabin bus picks you up at 21:00 in Sa Pa and travels overnight to Ha Giang City (rest on board)',
            ],
            5 => [
                'stage_title' => 'Stage 2: Ha Giang Loop - Ma Pi Leng Pass, Dong Van & Nho Que River',
                'transit_notes' => 'Limousine pickup in Ha Giang at 16:00 to Ninh Binh or Hanoi',
            ],
            6 => [
                'stage_title' => 'Stage 3: Ninh Binh - Tam Coc Sampan Ride, Mua Cave & Hoa Lu Ancient Capital',
                'transit_notes' => "Limousine drop-off back in Hanoi's Old Quarter at 18:30 - end of trip",
            ],
        ];

        foreach ($items as $id => $fields) {
            $this->updateRow('tour_combo_items', ['id' => $id], $fields);
        }
    }

    private function translateDestinations(): void
    {
        $destinations = [
            1 => [
                'name' => 'Ha Giang',
                'description' => "Vietnam's northernmost frontier, famous for the Dong Van Karst Plateau Global Geopark, the dramatic Ma Pi Leng Pass, the emerald Nho Que River and the rich cultures of 22 ethnic groups.",
            ],
            2 => [
                'name' => 'Ha Long Bay',
                'description' => 'A UNESCO World Natural Heritage site with thousands of spectacular limestone islands rising from emerald waters, mysterious stalactite caves and world-class cruise experiences.',
            ],
            3 => [
                'name' => 'Ninh Binh',
                'description' => 'Known as "Ha Long Bay on land", home to the UNESCO dual heritage Trang An landscape complex, poetic Tam Coc - Bich Dong and Mua Cave peak with sweeping views of mountains and rivers.',
            ],
            4 => [
                'description' => "The enchanting land of mist, home to Fansipan - the 3,143m Roof of Indochina, spectacular rice terraces winding through the Muong Hoa Valley and rustic H'Mong and Red Dao villages.",
            ],
            5 => [
                'name' => 'Cat Ba - Lan Ha Bay',
                'description' => 'An unspoiled island paradise with hundreds of natural white-sand beaches, the calm Lan Ha Bay - ideal for kayaking - and the biodiverse Cat Ba National Park.',
            ],
            6 => [
                'name' => 'Ta Xua',
                'description' => 'A famous cloud-hunting paradise with the majestic Dinosaur Spine ridge, seas of clouds flooding the valleys and pristine hills of ancient Shan Tuyet tea trees.',
            ],
        ];

        foreach ($destinations as $id => $fields) {
            $this->updateRow('destinations', ['id' => $id], $fields);
        }
    }

    private function translateExtraServices(): void
    {
        $services = [
            1 => ['name' => 'VIP Limousine transfer upgrade from the Old Quarter', 'description' => 'Door-to-door hotel pickup with premium leather massage seats', 'price_unit' => '/person'],
            2 => ['name' => 'Single Room Supplement', 'description' => 'Upgrade from a shared dorm to a private homestay/hotel room', 'price_unit' => '/night'],
            3 => ['name' => 'Full motorbike damage insurance', 'description' => 'Covers scratches and damaged motorbike parts during the tour'],
            4 => ['name' => 'Extra hotel night in the Old Quarter before the tour', 'description' => 'Deluxe room in central Hanoi Old Quarter to rest before departure', 'price_unit' => '/room'],
        ];

        foreach ($services as $id => $fields) {
            $this->updateRow('extra_services', ['id' => $id], $fields);
        }
    }

    private function translateOptions(): void
    {
        $options = [
            'site_address' => '15 Cau Go Lane, Hang Bac Ward, Hoan Kiem District, Hanoi, Vietnam',
            'working_hours' => '07:30 - 22:00 (Monday - Sunday)',
            'footer_about' => 'Chestnut Travel is a tour operator specializing in authentic, unique experiences in Ha Giang, Sa Pa, Lan Ha Bay, Ninh Binh and other highland destinations in Northern Vietnam.',
            'footer_license' => 'International Tour Operator License No. 01-1898/2023/TCDL-GP LHQT issued by the Vietnam National Authority of Tourism',
            'footer_copyright' => '© 2026 Chestnut Travel. All rights reserved.',
            'booking_notice' => 'No sign-in required! You can book as a guest and the Chestnut Travel team will contact you to confirm within 15 minutes.',
            'award_badge_title' => "Travellers' Choice Award",
            'award_badge_text' => "Chestnut Travel is proud to have been voted a Tripadvisor Travellers' Choice 2025 winner by travelers from Vietnam and around the world!",
            'feature_1_title' => 'Local Travel Experts',
            'feature_1_desc' => 'Our professional team knows the local culture inside out and is always ready to craft the perfect, most unique itinerary just for you.',
            'feature_2_title' => 'Best Price Guaranteed',
            'feature_2_desc' => 'Transparent, all-inclusive pricing and a commitment to the best possible price for consistently high-quality service.',
            'feature_3_title' => '24/7 Customer Support',
            'feature_3_desc' => 'Our customer care team is on hand 24/7 to support you and answer any questions before, during and after your trip.',
            'popular_trips_badge' => 'Popular Trips',
            'popular_trips_title' => 'Explore our most loved tours.',
            'popular_trips_subtitle' => 'Our most popular trips with carefully optimized itineraries and high-quality all-inclusive service.',
            'site_bank_name' => 'MB Bank (Military Commercial Joint Stock Bank)',
            'site_bank_note' => 'Please scan the QR code or make a bank transfer using your booking code as the reference (e.g. CNT-A1B2C3). Your booking will be reviewed and a confirmation email sent as soon as payment is received.',
            'destinations_subtitle' => 'From the legendary bends of Ma Pi Leng to the emerald islands of Lan Ha Bay — discover the most beautiful places in Vietnam.',
            'stat_1_label' => 'Happy travelers',
            'stat_2_label' => 'Successful trips',
            'stat_3_label' => 'Genuine 5-star reviews',
            'stat_4_label' => 'Dedicated customer support',
            'hero_trust_text_1' => '(500+ five-star Tripadvisor reviews)',
            'hero_trust_text_2' => 'Insurance & caring local guides',
        ];

        foreach ($options as $key => $value) {
            // Only touch options that exist, so admin-managed keys are not created unexpectedly
            $this->updateRow('options', ['key' => $key], ['value' => $value], false);
        }

        // Hero banners: translate the text of each slide while keeping images and links
        $bannerTexts = [
            [
                'badge' => '#1 Authentic Local Travel in Northern Vietnam',
                'title' => 'Your companion on every',
                'title_highlight' => 'journey of discovery',
                'subtitle' => 'Let Chestnut Travel be your trusted travel companion — conquering every spectacular road in Vietnam with you.',
                'button_text' => 'Explore now',
            ],
            [
                'badge' => 'Legendary Roads',
                'title' => 'Discover the wonders of',
                'title_highlight' => 'Ha Giang & Sa Pa',
                'subtitle' => 'Conquer Ma Pi Leng Pass, Tu San Canyon, the Nho Que River and breathtaking rice terraces.',
                'button_text' => 'See hot tours',
            ],
        ];

        $row = Schema::hasTable('options') ? DB::table('options')->where('key', 'hero_banners')->first() : null;
        if ($row) {
            $banners = json_decode($row->value, true);
            if (is_array($banners)) {
                foreach ($bannerTexts as $idx => $texts) {
                    if (isset($banners[$idx]) && $this->containsVietnamese(json_encode($banners[$idx], JSON_UNESCAPED_UNICODE))) {
                        $banners[$idx] = array_merge($banners[$idx], $texts);
                    }
                }
                DB::table('options')->where('key', 'hero_banners')->update([
                    'value' => json_encode($banners, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                ]);
            }
        }
    }

    private function translateMenus(): void
    {
        if (!Schema::hasTable('menus')) {
            return;
        }

        $titles = [
            'Trang chủ' => 'Home',
            'Giới thiệu' => 'About Us',
            'Điểm đến' => 'Destinations',
            'Hoạt động' => 'Activities',
            'Combo Trọn gói' => 'Package Combos',
            'Tất cả Package Combo' => 'All Package Combos',
            'Trọn gói tiết kiệm & trung chuyển liền mạch' => 'All-inclusive savings & seamless transfers',
            'Sa Pa, Hà Giang Loop & Ninh Bình' => 'Sa Pa, Ha Giang Loop & Ninh Binh',
            'Huế, Hội An, Phong Nha & Đà Nẵng' => 'Hue, Hoi An, Phong Nha & Da Nang',
            'Đánh giá' => 'Reviews',
            'Liên hệ' => 'Contact',
            'Tùy chỉnh Tour' => 'Customize Tour',
        ];

        foreach (DB::table('menus')->get() as $menu) {
            $items = json_decode($menu->items, true);
            if (!is_array($items)) {
                continue;
            }

            $translate = function (array $list) use (&$translate, $titles) {
                foreach ($list as &$item) {
                    foreach (['title', 'subtitle'] as $field) {
                        if (!empty($item[$field]) && isset($titles[$item[$field]])) {
                            $item[$field] = $titles[$item[$field]];
                        }
                    }
                    if (!empty($item['children']) && is_array($item['children'])) {
                        $item['children'] = $translate($item['children']);
                    }
                }

                return $list;
            };

            $update = ['items' => json_encode($translate($items), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)];
            if ($menu->name === 'Menu Chính (Header Navigation)') {
                $update['name'] = 'Main Menu (Header Navigation)';
            }
            DB::table('menus')->where('id', $menu->id)->update($update);
        }
    }

    private function translatePosts(): void
    {
        $posts = [
            1 => [
                'title' => 'Ha Giang Loop Tips for First-Time Riders',
                'excerpt' => 'Everything you need to know to conquer the Ha Giang Loop by motorbike: what to wear, the best time to go and essential safety tips.',
                'content' => '<p>The Ha Giang Loop is one of the most spectacular motorbike routes on the planet, attracting huge numbers of international and domestic travelers every year. For a safe and memorable trip, choose a professional Easy Rider driver, pack warm clothing and bring a fully charged power bank.</p>',
            ],
            2 => [
                'title' => 'Mu Cang Chai: A Guide to the Golden Rice Season',
                'excerpt' => "Discover Mam Xoi Hill, the Na Hang Tua Chu bamboo forest and the mesmerizing beauty of the Northwest's golden season.",
                'content' => '<p>Every September and October, Mu Cang Chai is draped in the shimmering gold of its spectacular rice terraces. This is the best time to visit, take photos and experience the "Flying Over the Golden Season" paragliding festival at Khau Pha Pass.</p>',
            ],
            3 => [
                'title' => 'Top 5 Most Beautiful Lan Ha Bay Cruises to Try',
                'excerpt' => 'A detailed review of the boutique leisure cruises on Lan Ha Bay: elegant spaces, 5-star service and private kayaking routes.',
                'content' => '<p>Unlike bustling Ha Long Bay, Lan Ha Bay offers unspoiled, peaceful beauty with crystal-clear water and hundreds of natural white-sand beaches. Spending a night on a boutique cruise is the perfect way to enjoy it.</p>',
            ],
        ];

        foreach ($posts as $id => $fields) {
            $this->updateRow('posts', ['id' => $id], $fields);
        }

        $this->updateRow('posts', ['slug' => 'about-us'], [
            'title' => AboutUsSeeder::TITLE,
            'category' => AboutUsSeeder::CATEGORY,
            'excerpt' => AboutUsSeeder::EXCERPT,
            'content' => AboutUsSeeder::content(),
            'tags' => AboutUsSeeder::TAGS,
        ]);
    }

    private function translateReviews(): void
    {
        if (!Schema::hasTable('reviews')) {
            return;
        }

        $reviews = [
            1 => [
                'comment' => 'Our 2-day, 1-night cruise on Lan Ha Bay was even better than we expected! The staff were attentive, the seafood was fresh and delicious, and kayaking at sunset was truly unforgettable. We will definitely come back with our family!',
            ],
            2 => [
                'author_name' => 'Minh Ngoc & Friends',
                'author_location' => 'Hanoi',
                'comment' => "Our recent trip to Lan Ha Bay and Cat Ba Island was the best experience our group has ever had. The cruise was clean, the service was professional, and the Chestnut Travel consultant was incredibly helpful from booking right through to the end of the trip.",
            ],
            3 => [
                'comment' => "THE BEST EXPERIENCE OF MY LIFE! The Ha Giang Loop is breathtakingly beautiful. Our Chestnut Easy Rider driver was incredibly skilled, great fun and took amazing photos of us. Highly recommended!",
            ],
        ];

        foreach ($reviews as $id => $fields) {
            $this->updateRow('reviews', ['id' => $id], $fields);
        }

        $months = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June',
            7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
        ];

        foreach (DB::table('reviews')->get() as $review) {
            $update = [];

            // Repair UTF-8 text that was saved double-encoded (e.g. "â€¢" instead of "•", "ThÃ¡ng" instead of "Tháng")
            foreach (['author_location', 'review_date'] as $field) {
                $value = $review->{$field};
                if ($value !== null && preg_match('/Ã|â€/u', $value)) {
                    $fixed = @mb_convert_encoding($value, 'Windows-1252', 'UTF-8');
                    $value = mb_check_encoding($fixed, 'UTF-8') ? $fixed : str_replace('â€¢', '•', $value);
                }
                $update[$field] = $value;
            }

            // "Tháng 9, 2026" => "September 2026"
            if (!empty($update['review_date']) && preg_match('/^Tháng\s*(\d{1,2}),?\s*(\d{4})$/u', trim($update['review_date']), $m)) {
                $update['review_date'] = ($months[(int) $m[1]] ?? $m[1]) . ' ' . $m[2];
            }

            if ($update['author_location'] !== $review->author_location || $update['review_date'] !== $review->review_date) {
                DB::table('reviews')->where('id', $review->id)->update($update);
            }
        }
    }

    private function translateBookings(): void
    {
        if (!Schema::hasTable('tour_bookings')) {
            return;
        }

        $packages = [
            'Easy Rider (Có tài xế lái kèm)' => 'Easy Rider (With local driver)',
            'Self-Drive (Tự lái xe máy)' => 'Self-Drive (Ride your own motorbike)',
            'Gói Tiêu Chuẩn' => 'Standard Package',
        ];
        foreach ($packages as $vi => $en) {
            DB::table('tour_bookings')->where('package_option', $vi)->update(['package_option' => $en]);
        }

        $extraNames = [
            'Nâng cấp xe Limousine VIP Hà Nội <-> Hà Giang' => 'VIP Limousine upgrade Hanoi <-> Ha Giang',
            'Phòng riêng tư (Single Room Supplement)' => 'Single Room Supplement',
            'Nâng cấp xe Limousine VIP đưa đón Phố Cổ' => 'VIP Limousine transfer upgrade from the Old Quarter',
            'Bảo hiểm toàn diện sự cố xe máy' => 'Full motorbike damage insurance',
            'Thêm 1 đêm khách sạn Phố Cổ trước tour' => 'Extra hotel night in the Old Quarter before the tour',
            'Dịch vụ phụ trợ' => 'Extra service',
        ];

        foreach (DB::table('tour_bookings')->whereNotNull('extra_services')->get(['id', 'extra_services']) as $booking) {
            $extras = json_decode($booking->extra_services, true);
            if (!is_array($extras)) {
                continue;
            }
            $changed = false;
            foreach ($extras as &$extra) {
                if (isset($extra['name'], $extraNames[$extra['name']])) {
                    $extra['name'] = $extraNames[$extra['name']];
                    $changed = true;
                }
            }
            unset($extra);
            if ($changed) {
                DB::table('tour_bookings')->where('id', $booking->id)->update([
                    'extra_services' => json_encode($extras, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                ]);
            }
        }
    }

    /**
     * Update one row; arrays are stored as JSON. Rows/columns that don't exist are skipped.
     */
    private function updateRow(string $table, array $where, array $fields, bool $warnMissing = true): void
    {
        if (!Schema::hasTable($table)) {
            return;
        }

        $query = DB::table($table)->where($where);
        if (!$query->exists()) {
            if ($warnMissing) {
                $this->command?->warn("Skipped {$table} " . json_encode($where) . ' (not found)');
            }

            return;
        }

        $columns = Schema::getColumnListing($table);
        $data = [];
        foreach ($fields as $column => $value) {
            if (!in_array($column, $columns, true)) {
                continue;
            }
            $data[$column] = is_array($value)
                ? json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                : $value;
        }

        if ($data) {
            $query->update($data);
        }
    }

    private function containsVietnamese(string $text): bool
    {
        return (bool) preg_match('/[àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ]/iu', $text);
    }
}
