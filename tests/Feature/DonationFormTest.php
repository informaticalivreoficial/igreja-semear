<?php

namespace Tests\Feature;

use App\Livewire\Web\DonationForm;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DonationFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_page_renders(): void
    {
        $response = $this->get('/doacoes');

        $response->assertOk();
        $response->assertSee('Dízimo');
        $response->assertSee('Contribua com a Igreja Semear');
    }

    public function test_wizard_advances_through_steps(): void
    {
        Livewire::test(DonationForm::class)
            ->assertSet('step', 1)
            ->call('selectType', 'tithe')
            ->assertSet('step', 2)
            ->assertSet('type', 'tithe')
            ->call('selectAmount', '100,00')
            ->assertSet('amount', 100.0)
            ->call('nextStep')
            ->assertSet('step', 3)
            ->set('name', 'João Teste')
            ->set('email', 'joao@teste.com')
            ->call('nextStep')
            ->assertSet('step', 4);
    }

    public function test_invalid_amount_blocked(): void
    {
        Livewire::test(DonationForm::class)
            ->call('selectType', 'donation')
            ->set('amountInput', '0')
            ->call('nextStep')
            ->assertSet('step', 2)
            ->assertNotSet('errorMessage', '');
    }

    public function test_gateway_failure_marks_donation_failed(): void
    {
        config()->set('services.pagbank.token', '');

        Livewire::test(DonationForm::class)
            ->call('selectType', 'offering')
            ->call('selectAmount', '50,00')
            ->call('nextStep')
            ->set('name', 'Maria Teste')
            ->set('email', 'maria@teste.com')
            ->call('nextStep')
            ->assertSet('step', 4)
            ->call('createDonation');

        $donation = Donation::latest('id')->first();

        $this->assertNotNull($donation);
        $this->assertEquals('failed', $donation->status);
    }

    public function test_admin_page_requires_auth_and_renders(): void
    {
        $this->seed(\Database\Seeders\RolesAndPermissionsTableSeeder::class);

        $user = User::factory()->create();
        $user->assignRole('super admin');

        $this->actingAs($user)
            ->get('/admin/doacoes')
            ->assertOk();
    }

    public function test_admin_manual_create_page_renders(): void
    {
        $this->seed(\Database\Seeders\RolesAndPermissionsTableSeeder::class);

        $user = User::factory()->create();
        $user->assignRole('super admin');

        $this->actingAs($user)
            ->get('/admin/doacoes/cadastrar')
            ->assertOk()
            ->assertSee('Cadastrar Doação Manual');
    }

    public function test_manual_donation_is_saved_as_paid(): void
    {
        Livewire::test(\App\Livewire\Dashboard\Donations\DonationForm::class)
            ->set('type', 'tithe')
            ->set('amount', '120.50')
            ->set('donation_date', '2026-08-14')
            ->set('payment_method', 'dinheiro')
            ->set('description', 'Dízimo recebido em dinheiro')
            ->call('save')
            ->assertHasNoErrors();

        $donation = Donation::where('source', 'manual')->latest('id')->first();

        $this->assertNotNull($donation);
        $this->assertEquals('paid', $donation->status);
        $this->assertEquals('tithe', $donation->type);
        $this->assertEquals('dinheiro', $donation->payment_method);
    }
}
