<?php

namespace Database\Seeders;

use App\Models\Tour;
use Illuminate\Database\Seeder;

class TourFaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqsData = [
            'ha-giang-loop-4-days-3-nights' => [
                [
                    'question' => "Is this tour suitable if I've never ridden a motorbike on mountain passes?",
                    'answer' => 'Absolutely, if you choose the Easy Rider package (an experienced local driver rides for you and keeps you safe throughout the journey). If you want to ride yourself (self-riding), you need a valid International Driving Permit (IDP) and experience riding a manual/semi-automatic bike on steep hilly terrain.',
                ],
                [
                    'question' => 'What should I bring on the Ha Giang Loop?',
                    'answer' => 'Bring a small backpack of around 5-7kg (large luggage can be stored safely and free of charge at the Chestnut Travel office in Ha Giang City), a warm jacket (nights in Dong Van and Meo Vac are quite cold), sunscreen, sunglasses, swimwear (for the Du Gia waterfall) and basic personal medicine.',
                ],
                [
                    'question' => 'Does the tour still depart in bad weather or rain?',
                    'answer' => 'The tour runs as normal in light showers. Chestnut Travel provides premium rain suits, waterproof backpack covers and rain boots for every guest. In the event of storms, floods or dangerous landslides, we will flexibly reroute or postpone/refund according to our safety policy.',
                ],
                [
                    'question' => 'Does the tour include transfers from Hanoi to Ha Giang?',
                    'answer' => 'Yes. The tour includes round-trip high-quality sleeper bus tickets (VIP Luxury Cabin) between Hanoi and Ha Giang. The bus picks you up from hotels in the Hanoi Old Quarter or Noi Bai Airport at 20:30 the evening before and brings you safely back to Hanoi.',
                ],
            ],

            'ha-giang-loop-3-days-2-nights' => [
                [
                    'question' => 'How is the 3D2N itinerary different from the 4D3N one?',
                    'answer' => "The 3D2N itinerary focuses on the very best of the karst plateau: Quan Ba Heaven Gate, Tham Ma Slope, Pao's House, Lung Cu Flag Tower and Ma Pi Leng Pass with a boat trip on the Nho Que River. You won't go as deep as Du Gia waterfall village like the 4-day tour, making it ideal for travelers with limited weekend time.",
                ],
                [
                    'question' => 'What is the accommodation like on the 3D2N trip?',
                    'answer' => "You will spend 1 night in a comfortable hotel in Dong Van Old Quarter (private en-suite room, hot water, air conditioning) and 1 night in a rustic local homestay overlooking the valley in Pa Vi cultural village (Meo Vac) to experience H'Mong food and music.",
                ],
                [
                    'question' => 'Can I have vegetarian meals or special dietary requirements?',
                    'answer' => 'Yes, all meals on the tour are freshly cooked with clean highland ingredients. Just let us know in advance if you are vegetarian, avoid pork or beef, or have seafood allergies, and the kitchen will prepare a separate menu for you.',
                ],
                [
                    'question' => "Can I change my motorbike or driver if I don't feel comfortable?",
                    'answer' => 'Of course. All Chestnut Travel motorbikes are serviced daily after every trip. If you feel your driver is going too fast or is not a good fit, tell your tour leader right away and we will adjust or change the driver immediately.',
                ],
            ],

            'sapa-trekking-muong-hoa-valley-3d2n' => [
                [
                    'question' => 'How hard is trekking in the Muong Hoa Valley, and how fit do I need to be?',
                    'answer' => 'The trek is of Medium difficulty, with 9 - 14km of walking per day through rice terraces, dirt trails and rustic villages. You only need average health, a love of the outdoors and a pair of hiking/sports shoes with good grip.',
                ],
                [
                    'question' => 'What facilities do the local homestays have?',
                    'answer' => 'The homestays in Ta Van and Ban Ho are traditional wooden stilt houses of the Giay and Tay people, but they are clean and well equipped: warm comfortable mattresses, mosquito nets, hot showers, wifi and modern private toilets.',
                ],
                [
                    'question' => 'What is the best time of year for trekking in Sapa?',
                    'answer' => 'Autumn (August - October) is when the rice terraces are at their most brilliant golden color. Spring (February - April) brings peach and plum blossoms and dry, fresh weather that is perfect for trekking and cloud hunting.',
                ],
                [
                    'question' => 'Do I have to carry my heavy luggage while trekking?',
                    'answer' => 'No. You only need a small backpack with water, your phone, camera and essentials for the day. Large suitcases and bulky luggage are taken by our transfer vehicle straight to the homestay, ready for your arrival.',
                ],
            ],

            'ninh-binh-trang-an-mua-cave-1-day' => [
                [
                    'question' => 'Is the climb to the Dragon Peak at Mua Cave steep or dangerous?',
                    'answer' => 'The Ngoa Long Peak at Mua Cave has nearly 500 sturdy, winding stone steps. The natural rocky summit requires careful footing and non-slip sports shoes. The 360-degree panorama over the Tam Coc valley and the Ngo Dong River from the top is spectacular and well worth the effort!',
                ],
                [
                    'question' => 'How long is the Trang An boat ride, and do I have to row myself?',
                    'answer' => 'The Trang An sampan ride lasts about 2.5 - 3 hours, winding through 4 magical caves and 3 sacred ancient temples on crystal-clear water. An experienced local rower paddles the whole way, though you are welcome to try rowing if you like.',
                ],
                [
                    'question' => 'Does the tour include hotel pickup and drop-off in Hanoi?',
                    'answer' => 'Yes, a premium Dcar limousine picks you up from hotel lobbies in the Hanoi Old Quarter between 7:30 - 8:00 am and brings you safely back to your hotel at around 18:30 the same day.',
                ],
                [
                    'question' => 'What is included in the lunch on this tour?',
                    'answer' => 'Lunch is a generous buffet or a set menu of Ninh Binh specialties at an eco restaurant, with famous dishes such as grilled mountain goat, crispy rice with goat sauce, free-range chicken and light vegetarian options.',
                ],
            ],

            'ta-xua-cloud-hunting-dinosaur-spine-2d1n' => [
                [
                    'question' => 'How likely am I to see the sea of clouds in Ta Xua, and when is the best season?',
                    'answer' => 'The best cloud-hunting season runs from October to April, with over a 75-85% chance of clouds when the weather is cool, humid and sunny during the day. Our guides monitor the weather forecast and get up early to take you to the best sunrise spots for the clouds.',
                ],
                [
                    'question' => 'Is it safe to walk on the Hang Dong Dinosaur Spine?',
                    'answer' => "The Dinosaur Spine trail has gentle slopes and can be quite windy. Wear shoes with good grip, walk slowly and follow your guide's instructions. If you prefer not to walk, local motorbike taxis at the top of the slope can take you down to the viewpoint hut.",
                ],
                [
                    'question' => 'Do the homestays in Ta Xua have good views?',
                    'answer' => 'Absolutely! We choose wooden homestays with panoramic views straight over the valley of clouds (such as May Home, Ta Xua Lu Tre or Po Mu). You can watch the clouds and enjoy a hot coffee right from your bedroom balcony.',
                ],
            ],

            'northern-vietnam-package-combo-6-days' => [
                [
                    'question' => 'Is the 6-day combo tour too rushed or tiring?',
                    'answer' => "The 6-day combo itinerary is carefully designed, cleverly combining private VIP overnight sleeper buses with well-placed rest stops. You will fully explore Northern Vietnam's top 3 destinations (Sapa, Ha Giang, Ninh Binh) without wasting time going back and forth to Hanoi.",
                ],
                [
                    'question' => 'Can I upgrade to a 4-star or 5-star hotel?',
                    'answer' => 'Yes, you can request a room upgrade (in Sapa and Ninh Binh). Contact our consultants before paying to receive the best quote for the price difference, tailored to your family or couple.',
                ],
                [
                    'question' => 'What is the cancellation and rescheduling policy for this combo?',
                    'answer' => 'You can change your departure date free of charge up to 7 days before departure. Cancellations more than 10 days before receive a 100% deposit refund, 5-9 days before receive 50%, and within 5 days the partner hotels\' booking fees apply.',
                ],
            ],

            'ha-giang-loop-5-days-deep-frontier' => [
                [
                    'question' => 'Does the 5-day tour go deep into little-known villages?',
                    'answer' => 'Yes, the 5-day route extends to Thuong Phung, Xin Man, the Lung Tam linen weaving village and deep into Tu San Canyon at the upper Nho Que River – places shorter tours cannot reach – for a truly wild adventure.',
                ],
                [
                    'question' => 'Who is this tour best suited for?',
                    'answer' => "It is perfect for travelers who love photography and the cultures of the Lo Lo, H'Mong, Tay and Red Dao peoples, and who want to slow down amid pristine, majestic nature away from the crowds.",
                ],
                [
                    'question' => 'Will I get to experience a highland market?',
                    'answer' => 'Yes! If your tour falls on a weekend, your guide will take you to the Dong Van or Meo Vac Sunday market, where you can watch ethnic minority people in colorful dresses trading livestock and brocade, and taste thang co.',
                ],
            ],

            'sapa-fansipan-peak-trekking-2d1n' => [
                [
                    'question' => 'Does this tour reach Fansipan by cable car or on foot?',
                    'answer' => 'The tour includes tickets for the modern 3-rope Sun World Fansipan Legend cable car and the mountain train overlooking the Muong Hoa Valley. In just about 20 minutes you will touch the 3,143m "Roof of Indochina" marker without a strenuous climb.',
                ],
                [
                    'question' => 'Are there lots of photo spots in Cat Cat village?',
                    'answer' => "Plenty! Cat Cat village has giant water wheels, a wooden suspension bridge, the foaming white Tien Sa waterfall, traditional H'Mong rammed-earth houses and many places to rent colorful ethnic costumes for souvenir photos.",
                ],
                [
                    'question' => 'What is the weather like on Fansipan, and what should I wear?',
                    'answer' => 'The temperature at the top of Fansipan is usually 8 - 10°C lower than in Sapa town and it can be very windy. Bring a warm jacket, a scarf, a woolly hat and gloves so you can enjoy taking photos comfortably.',
                ],
            ],

            'ninh-binh-tam-coc-hoa-lu-cycling-2d1n' => [
                [
                    'question' => 'Is cycling in Tam Coc safe?',
                    'answer' => 'Very safe and pleasant. The cycling route follows flat concrete village roads with no steep hills, flanked by rice fields and majestic limestone mountains, with very little motor traffic.',
                ],
                [
                    'question' => 'When is the best time to see the birds at Thung Nham Bird Park?',
                    'answer' => 'Around 16:30 - 17:30 is the most spectacular sunset moment, when tens of thousands of birds - white egrets, herons, whistling ducks and kingfishers - fill the sky as they return to their nests after a day of feeding.',
                ],
                [
                    'question' => 'Does the tour visit Hoa Lu Ancient Capital?',
                    'answer' => 'Yes, your guide will introduce the history of the 10th-century Dinh and Early Le dynasties in detail at the Temples of King Dinh Tien Hoang and King Le Dai Hanh, with their ancient carved wooden architecture.',
                ],
            ],

            'lan-ha-bay-cat-ba-kayaking-3d2n' => [
                [
                    'question' => 'Where do we go kayaking on this tour?',
                    'answer' => 'You will kayak at the Dark & Bright Caves, Ba Trai Dao beach and pristine lagoons deep in the core of the Cat Ba National Park World Biosphere Reserve, where the sea is as clear as jade.',
                ],
                [
                    'question' => 'Is there a guide with us while kayaking?',
                    'answer' => 'There is always a professional kayak guide, along with internationally certified life jackets, dry bags and a rescue speedboat following behind to ensure complete safety.',
                ],
                [
                    'question' => 'Is the trekking in Cat Ba National Park strenuous?',
                    'answer' => 'The trek is about 5km through primeval tropical forest up to Ngu Lam Peak, with panoramic views of Cat Ba Island from above. The trail is well shaded by trees and suits travelers of average fitness.',
                ],
            ],

            'ha-long-bay-luxury-day-escape' => [
                [
                    'question' => 'Is a day tour enough time to fully explore Ha Long Bay?',
                    'answer' => 'The luxury super cruise follows a 6-hour route (equivalent to an overnight cruise itinerary), taking you to Sung Sot Cave (the largest stalactite cave in the bay), Ti Top Island for swimming and panoramic views, and free kayaking at Luon Cave.',
                ],
                [
                    'question' => 'Is lunch on board a buffet or a set menu?',
                    'answer' => 'The tour serves a premium seafood buffet with more than 50 fresh Asian - European dishes, including lemongrass steamed prawns, cheese-grilled oysters, spicy stir-fried squid, shaking beef and a fresh sushi - sashimi counter, plus fruit for dessert.',
                ],
                [
                    'question' => 'Does the boat have a Jacuzzi or a sundeck?',
                    'answer' => 'Yes, the super cruise has an all-season open-air Jacuzzi on the top deck (Sundeck) with modern sun loungers, so you can relax in the water while admiring this natural wonder of the world.',
                ],
            ],
        ];

        foreach ($faqsData as $slug => $faqs) {
            $tour = Tour::where('slug', 'like', "%{$slug}%")->first();
            if ($tour) {
                $tour->update(['faqs' => $faqs]);
                $this->command->info("Updated FAQs for tour: {$tour->title}");
            }
        }
    }
}
