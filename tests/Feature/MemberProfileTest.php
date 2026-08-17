<?php

namespace Tests\Feature;

use App\Models\Config;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class MemberProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Config::create([
            'id' => 1,
            'app_name' => 'Igreja Semear',
            'template' => 'default',
        ]);

        View::share('configuracoes', Config::find(1));
        View::share('viewPaginas', collect());
    }

    private function makeMember(): array
    {
        $user = User::factory()->create();
        $member = Member::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'cell_phone' => $user->cell_phone,
            'birthday' => '10/05/1990',
            'status' => 1,
        ]);

        return [$user, $member];
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'João da Silva',
            'email' => 'joao@exemplo.com',
            'cell_phone' => '(11) 99999-9999',
            'birthday' => '10/05/1990',
            'postcode' => '11680-000',
            'street' => 'Rua das Flores',
            'number' => '123',
            'neighborhood' => 'Centro',
            'city' => 'Ubatuba',
            'state' => 'SP',
        ], $overrides);
    }

    public function test_profile_page_renders(): void
    {
        [$user] = $this->makeMember();

        $this->actingAs($user)
            ->get('/minha-conta/perfil')
            ->assertOk()
            ->assertSee('Meu perfil')
            ->assertSee('birthday')
            ->assertSee('foto');
    }

    public function test_update_perfil_updates_data(): void
    {
        [$user] = $this->makeMember();

        $this->actingAs($user)
            ->post('/minha-conta/perfil', $this->payload())
            ->assertRedirect()
            ->assertSessionHas('toast');

        $user->refresh();

        $this->assertSame('João da Silva', $user->name);
        $this->assertSame('joao@exemplo.com', $user->email);
        $this->assertSame('11999999999', $user->cell_phone);
        $this->assertSame('1990-05-10', $user->birthday?->format('Y-m-d'));
        $this->assertSame('Ubatuba', $user->member->city);
        $this->assertSame('SP', $user->member->state);
    }

    public function test_update_perfil_rejects_invalid_phone(): void
    {
        [$user] = $this->makeMember();

        $this->actingAs($user)
            ->from('/minha-conta/perfil')
            ->post('/minha-conta/perfil', $this->payload(['cell_phone' => '99999']))
            ->assertSessionHasErrors('cell_phone');
    }

    public function test_update_perfil_rejects_future_birthday(): void
    {
        [$user] = $this->makeMember();

        $this->actingAs($user)
            ->from('/minha-conta/perfil')
            ->post('/minha-conta/perfil', $this->payload(['birthday' => '10/05/2090']))
            ->assertSessionHasErrors('birthday');
    }

    public function test_update_perfil_uploads_photo_as_webp(): void
    {
        Storage::fake('public');

        [$user] = $this->makeMember();

        $this->actingAs($user)
            ->post('/minha-conta/perfil', $this->payload([
                'foto' => UploadedFile::fake()->image('foto.png', 100, 100),
            ]))
            ->assertRedirect()
            ->assertSessionHas('toast');

        $user->refresh();

        $this->assertNotNull($user->avatar);
        $this->assertStringEndsWith('.webp', $user->avatar);
        Storage::disk('public')->assertExists($user->avatar);
        $this->assertSame($user->avatar, $user->member->avatar);
    }

    public function test_update_perfil_changes_password(): void
    {
        [$user] = $this->makeMember();

        $this->actingAs($user)
            ->post('/minha-conta/perfil', array_merge($this->payload(), [
                'current_password' => 'password',
                'password' => 'nova-senha-123',
                'password_confirmation' => 'nova-senha-123',
            ]))
            ->assertRedirect();

        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('nova-senha-123', $user->fresh()->password));
    }
}
