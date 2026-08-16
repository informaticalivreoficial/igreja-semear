<?php

namespace Tests\Feature;

use App\Livewire\Dashboard\Dashboard;
use App\Models\User;
use App\Services\Analytics\AnalyticsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DashboardAnalyticsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        foreach (['super admin', 'admin', 'editor', 'lider', 'pastor', 'member'] as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }
    }

    private function fakeRows(): \Illuminate\Support\Collection
    {
        return collect([
            ['date' => Carbon::parse('2026-03-05'), 'activeUsers' => 10, 'screenPageViews' => 20, 'deviceCategory' => 'mobile'],
            ['date' => Carbon::parse('2026-03-06'), 'activeUsers' => 5, 'screenPageViews' => 8, 'deviceCategory' => 'desktop'],
            ['date' => Carbon::parse('2026-07-01'), 'activeUsers' => 3, 'screenPageViews' => 9, 'deviceCategory' => 'tablet'],
        ]);
    }

    public function test_monthly_visits_are_aggregated_by_month(): void
    {
        Analytics::fake($this->fakeRows());

        $data = (new AnalyticsService)->monthlyVisits(6);

        $this->assertCount(6, $data['labels']);
        $this->assertSame('Mar/2026', $data['labels'][0]);
        $this->assertSame(15, $data['visitors'][0]);
        $this->assertSame(28, $data['pageviews'][0]);
        $this->assertSame(3, $data['visitors'][4]);
    }

    public function test_devices_are_aggregated_by_category(): void
    {
        Analytics::fake($this->fakeRows());

        $data = (new AnalyticsService)->devices(6);

        $this->assertSame(['Mobile', 'Desktop', 'Tablet'], $data['labels']);
        $this->assertSame([10, 5, 3], $data['values']);
    }

    public function test_dashboard_renders_charts(): void
    {
        Analytics::fake($this->fakeRows());

        $user = User::factory()->create();
        $user->assignRole('editor');
        $this->actingAs($user);

        Livewire::test(Dashboard::class)
            ->assertViewHas('analyticsMonthly')
            ->assertViewHas('analyticsDevices')
            ->assertSee('visitsChart', false)
            ->assertSee('devicesChart', false);
    }

    public function test_dashboard_renders_without_analytics_data(): void
    {
        Analytics::fake(collect());

        $user = User::factory()->create();
        $user->assignRole('editor');
        $this->actingAs($user);

        Livewire::test(Dashboard::class)
            ->assertViewHas('analyticsMonthly')
            ->assertSee('Sem dados de visitas ainda', false)
            ->assertSee('Sem dados de dispositivos ainda', false);
    }
}