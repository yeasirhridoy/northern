<?php

namespace App\Filament\Widgets;

use App\Models\Application;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Applications', Application::count())
                ->description('All time applications')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),

            Stat::make('Admitted Students', Application::where('status', 'admitted')->count())
                ->description('Applications accepted')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Pending Payments', Application::where('payment_status', 'pending')->count())
                ->description('Payments awaiting verification')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('warning'),
        ];
    }
}
