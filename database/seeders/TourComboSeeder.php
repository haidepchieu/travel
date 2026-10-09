<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Tour;
use App\Models\TourComboItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TourComboSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Schema::hasTable('tours') || !Schema::hasTable('tour_combo_items')) {
            return;
        }

        // Find available child tours to link
        $haGiangTour = Tour::where('slug', 'like', '%ha-giang%')->where('is_combo', false)->first();
        $sapaTour = Tour::where(function ($q) {
            $q->where('slug', 'like', '%sapa%')->orWhere('title', 'like', '%Sapa%');
        })->where('is_combo', false)->first();
        $ninhBinhTour = Tour::where(function ($q) {
            $q->where('slug', 'like', '%ninh-binh%')->orWhere('title', 'like', '%Ninh Binh%');
        })->where('is_combo', false)->first();

        // If specific tours don't exist, just get any other tours
        $fallbackTours = Tour::where('is_combo', false)->take(3)->get();
        if (!$haGiangTour && $fallbackTours->count() > 0) $haGiangTour = $fallbackTours->get(0);
        if (!$sapaTour && $fallbackTours->count() > 1) $sapaTour = $fallbackTours->get(1);
        if (!$ninhBinhTour && $fallbackTours->count() > 2) $ninhBinhTour = $fallbackTours->get(2);

        $northDest = Destination::where('slug', 'ha-giang')->orWhere('slug', 'hanoi')->first();

        $comboSlug = 'cultural-trekking-motor-riding-and-sight-seeing-6-day-sapa-ha-giang-ninh-binh-ethnic-immersion';
        
        $combo = Tour::firstOrNew(['slug' => $comboSlug]);
        $combo->title = 'Cultural Trekking, Motor Riding and Sight-seeing: 6-Day Sapa, Ha Giang & Ninh Binh Ethnic Immersion';
        $combo->tagline = 'A combo package covering three of Northern Vietnam\'s wonders: Sa Pa, the Ha Giang Loop and Trang An in Ninh Binh.';
        $combo->destination_id = $northDest?->id;
        $combo->duration_days = 6;
        $combo->duration_nights = 5;
        $combo->trip_type = 'Package Combo';
        $combo->difficulty = 'Medium';
        $combo->price = 459.00;
        $combo->sale_price = 399.00;
        $combo->is_combo = true;
        $combo->combo_badge = 'SAVE $60';
        $combo->combo_saving_amount = 60.00;
        $combo->is_featured = true;
        $combo->is_active = true;
        $combo->rating = 5.0;
        $combo->review_count = 18;
        $combo->highlights = [
            'Seamless inter-province journey: Sa Pa - Ha Giang - Ninh Binh with no need to book your own transport',
            'Conquer the majestic Ma Pi Leng Pass and Tu San Canyon on the Nho Que River',
            'Trek through H\'Mong and Red Dao villages in Sa Pa and admire the rice terraces',
            'Sampan ride on the Ngo Dong River at the Tam Coc - Bich Dong World Heritage site',
            'All transfers by premium cabin sleeper limousine with door-to-door pickup',
        ];
        $combo->inclusions = [
            'All inter-province premium cabin sleeper limousine tickets',
            'Modern motorbike with fuel and riding gear for Ha Giang',
            'Professional English-speaking local guide throughout',
            'All entrance tickets and Trang An / Tam Coc sampan rides',
            '5 nights in hotels & characterful village homestays',
            'Meals as per the program featuring local cuisine',
        ];
        $combo->exclusions = [
            'Alcoholic drinks outside the program',
            'Tips for guides and drivers (at your discretion)',
            'Personal souvenir shopping',
        ];
        $combo->overview = '<h2>The complete Northern Vietnam discovery journey (6 Days 5 Nights)</h2>
<p>If you want to fully enjoy the wild, majestic beauty of the northern highlands together with the peaceful landscapes of Trang An - without the hassle of buying bus tickets, changing stations or planning everything yourself - the <strong>6-Day Sapa, Ha Giang & Ninh Binh Package Combo</strong> is the perfect choice.</p>
<p>Seamlessly coordinated by Chestnut Travel, the trip takes you from the spectacular rice terraces of Sa Pa, over the legendary Ma Pi Leng Pass in Ha Giang, to a boat ride through the cultural and natural World Heritage site of Trang An (Ninh Binh).</p>';
        
        if (!$combo->featured_image && $haGiangTour?->featured_image) {
            $combo->featured_image = $haGiangTour->featured_image;
        }

        $combo->save();

        // Attach combo stages
        TourComboItem::where('parent_tour_id', $combo->id)->delete();

        $order = 1;
        if ($sapaTour) {
            TourComboItem::create([
                'parent_tour_id' => $combo->id,
                'child_tour_id' => $sapaTour->id,
                'stage_order' => $order++,
                'stage_title' => 'Stage 1: Sa Pa - H\'Mong Village Trekking & Fansipan Peak',
                'stage_days' => 2,
                'transit_notes' => 'Premium VIP cabin bus picks you up at 21:00 in Sa Pa and travels overnight to Ha Giang City (rest on board)',
            ]);
        }

        if ($haGiangTour) {
            TourComboItem::create([
                'parent_tour_id' => $combo->id,
                'child_tour_id' => $haGiangTour->id,
                'stage_order' => $order++,
                'stage_title' => 'Stage 2: Ha Giang Loop - Ma Pi Leng Pass, Dong Van & Nho Que River',
                'stage_days' => 3,
                'transit_notes' => 'Limousine pickup in Ha Giang at 16:00 to Ninh Binh or Hanoi',
            ]);
        }

        if ($ninhBinhTour) {
            TourComboItem::create([
                'parent_tour_id' => $combo->id,
                'child_tour_id' => $ninhBinhTour->id,
                'stage_order' => $order++,
                'stage_title' => 'Stage 3: Ninh Binh - Tam Coc Sampan Ride, Mua Cave & Hoa Lu Ancient Capital',
                'stage_days' => 1,
                'transit_notes' => 'Limousine drop-off back in Hanoi\'s Old Quarter at 18:30 - end of trip',
            ]);
        }
    }
}
