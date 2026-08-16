<?php

namespace App\Services\Analytics;

use Carbon\CarbonPeriod;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

class AnalyticsService
{
    protected const MONTHS_PT = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

    public function monthlyVisits(int $months = 6): array
    {
        $start = now()->subMonths($months - 1)->startOfMonth();
        $end = now()->endOfMonth();

        $labels = [];
        $visitors = [];
        $pageviews = [];

        foreach (CarbonPeriod::create($start, '1 month', $end) as $month) {
            $labels[] = self::MONTHS_PT[$month->month - 1].'/'.$month->year;
            $visitors[$month->format('Y-m')] = 0;
            $pageviews[$month->format('Y-m')] = 0;
        }

        try {
            $rows = Analytics::fetchTotalVisitorsAndPageViews(Period::create($start, $end), 400);

            foreach ($rows as $row) {
                $key = $row['date']->format('Y-m');
                if (array_key_exists($key, $visitors)) {
                    $visitors[$key] += $row['activeUsers'];
                    $pageviews[$key] += $row['screenPageViews'];
                }
            }
        } catch (\Throwable $e) {
            // credenciais inválidas ou indisponibilidade da API: gráfico vazio
        }

        return [
            'labels' => $labels,
            'visitors' => array_values($visitors),
            'pageviews' => array_values($pageviews),
        ];
    }

    public function devices(int $months = 6): array
    {
        $order = [
            'mobile' => 'Mobile',
            'desktop' => 'Desktop',
            'tablet' => 'Tablet',
        ];

        $values = array_fill_keys(array_keys($order), 0);

        try {
            $rows = Analytics::get(
                Period::months($months),
                ['activeUsers'],
                ['deviceCategory'],
                50,
            );

            foreach ($rows as $row) {
                $category = strtolower((string) ($row['deviceCategory'] ?? ''));
                if (array_key_exists($category, $values)) {
                    $values[$category] += (int) ($row['activeUsers'] ?? 0);
                }
            }
        } catch (\Throwable $e) {
            // credenciais inválidas ou indisponibilidade da API: gráfico vazio
        }

        return [
            'labels' => array_values($order),
            'values' => array_values($values),
        ];
    }
}