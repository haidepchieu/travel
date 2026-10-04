<?php

namespace App\Filament\Widgets;

use App\Models\PageView;
use App\Models\TourBooking;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $totalViews = PageView::count();
        $todayViews = PageView::whereDate('created_at', $today)->count();
        $yesterdayViews = PageView::whereDate('created_at', $yesterday)->count();

        // Calculate growth rate compared to yesterday
        if ($yesterdayViews > 0) {
            $growth = round((($todayViews - $yesterdayViews) / $yesterdayViews) * 100);
            $growthText = ($growth >= 0 ? '+' : '') . $growth . '% so với hôm qua';
            $growthIcon = $growth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
            $growthColor = $growth >= 0 ? 'success' : 'danger';
        } else {
            $growthText = 'Lưu lượng ổn định';
            $growthIcon = 'heroicon-m-arrow-trending-up';
            $growthColor = 'success';
        }

        $totalBookings = TourBooking::count();
        $todayBookings = TourBooking::whereDate('created_at', $today)->count();

        // Recent 7 days trend for sparkline
        $trend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $trend[] = PageView::whereDate('created_at', $date)->count();
        }

        return [
            Stat::make('Lượt xem hôm nay', number_format($todayViews))
                ->description($growthText)
                ->descriptionIcon($growthIcon)
                ->color($growthColor)
                ->chart($trend),

            Stat::make('Tổng lượt xem trang', number_format($totalViews))
                ->description('Toàn bộ hệ thống')
                ->descriptionIcon('heroicon-m-eye')
                ->color('info')
                ->chart([30, 45, 60, 50, 75, 90, 110]),

            Stat::make('Tổng đơn đặt tour', number_format($totalBookings))
                ->description($todayBookings > 0 ? "+{$todayBookings} đơn mới hôm nay" : 'Đang xử lý')
                ->descriptionIcon('heroicon-m-ticket')
                ->color('primary'),
        ];
    }
}
