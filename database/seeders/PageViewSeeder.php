<?php

namespace Database\Seeders;

use App\Models\PageView;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PageViewSeeder extends Seeder
{
    public function run(): void
    {
        if (PageView::count() > 50) {
            return;
        }

        $ips = [
            '118.70.12.45', '118.70.12.89', '14.162.140.23', '14.162.140.77',
            '42.113.155.10', '42.113.155.44', '27.72.60.12', '27.72.60.88',
            '171.244.10.15', '171.244.10.99', '113.161.40.18', '113.161.40.55',
            '123.24.180.20', '123.24.180.82', '1.53.190.11', '1.53.190.95',
            '115.79.200.33', '115.79.200.67', '222.252.10.5', '222.252.10.88',
        ];

        $urls = [
            'http://localhost:8090/',
            'http://localhost:8090/',
            'http://localhost:8090/',
            'http://localhost:8090/?destination=ha-giang',
            'http://localhost:8090/?activity=motorbike-tour',
            'http://localhost:8090/tours/ha-giang-loop-motorcycle-tour-4-days',
            'http://localhost:8090/tours/sapa-muong-hoa-valley-trekking-3-days',
            'http://localhost:8090/tours/lan-ha-bay-cat-ba-island-cruise-2-days',
            'http://localhost:8090/tours/ninh-binh-trang-an-tam-coc-day-trip',
        ];

        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 17_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.2 Mobile/15E148 Safari/604.1',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        ];

        $referers = [
            'https://www.google.com/',
            'https://www.tripadvisor.com/',
            'https://www.facebook.com/',
            null,
        ];

        $records = [];
        $now = Carbon::now();

        for ($d = 30; $d >= 0; $d--) {
            $date = Carbon::now()->subDays($d);
            $isWeekend = $date->isWeekend();
            // 80 to 220 views per day (higher on weekends)
            $viewsCount = $isWeekend ? rand(150, 240) : rand(90, 170);

            for ($v = 0; $v < $viewsCount; $v++) {
                // Peak hours 9am - 10pm
                $hour = rand(0, 10) > 2 ? rand(8, 22) : rand(0, 7);
                $minute = rand(0, 59);
                $second = rand(0, 59);

                $createdAt = (clone $date)->setTime($hour, $minute, $second);
                if ($createdAt->greaterThan($now)) {
                    continue;
                }

                $records[] = [
                    'ip_address' => $ips[array_rand($ips)],
                    'url' => $urls[array_rand($urls)],
                    'user_agent' => $userAgents[array_rand($userAgents)],
                    'referer' => $referers[array_rand($referers)],
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];

                if (count($records) >= 500) {
                    PageView::insert($records);
                    $records = [];
                }
            }
        }

        if (!empty($records)) {
            PageView::insert($records);
        }
    }
}
