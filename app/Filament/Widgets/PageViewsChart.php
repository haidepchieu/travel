<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class PageViewsChart extends ChartWidget
{
    protected static ?string $heading = 'Biểu đồ số lượt người xem trang (Traffic Analytics)';

    protected static ?string $description = 'Thống kê lượng khách truy cập và số lượt xem các trang trên website';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public ?string $filter = '7days';

    protected function getFilters(): ?array
    {
        return [
            '7days' => '7 ngày gần nhất',
            '14days' => '14 ngày gần nhất',
            '30days' => '30 ngày qua',
            'today' => 'Hôm nay (Theo giờ)',
        ];
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter ?? '7days';

        $labels = [];
        $viewsData = [];

        if ($activeFilter === 'today') {
            // Group by hour for today
            $today = Carbon::today();
            $records = PageView::whereDate('created_at', $today)
                ->selectRaw('HOUR(created_at) as hour, count(*) as views')
                ->groupBy('hour')
                ->pluck('views', 'hour')
                ->toArray();

            for ($h = 0; $h <= 23; $h++) {
                $labels[] = sprintf('%02d:00', $h);
                $viewsData[] = isset($records[$h]) ? (int) $records[$h] : 0;
            }
        } else {
            // Group by day
            $days = match ($activeFilter) {
                '14days' => 14,
                '30days' => 30,
                default => 7,
            };

            $startDate = Carbon::today()->subDays($days - 1)->startOfDay();

            $records = PageView::where('created_at', '>=', $startDate)
                ->selectRaw('DATE(created_at) as date, count(*) as views')
                ->groupBy('date')
                ->get()
                ->keyBy('date');

            for ($i = $days - 1; $i >= 0; $i--) {
                $dateObj = Carbon::today()->subDays($i);
                $dateKey = $dateObj->toDateString();

                $labels[] = $dateObj->format('d/m');
                $viewsData[] = isset($records[$dateKey]) ? (int) $records[$dateKey]->views : 0;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Lượt xem trang (Pageviews)',
                    'data' => $viewsData,
                    'borderColor' => '#F26522',
                    'backgroundColor' => 'rgba(242, 101, 34, 0.12)',
                    'fill' => 'start',
                    'tension' => 0.4,
                    'pointBackgroundColor' => '#F26522',
                    'pointBorderColor' => '#ffffff',
                    'pointHoverRadius' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
