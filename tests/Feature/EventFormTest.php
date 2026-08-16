<?php

namespace Tests\Feature;

use App\Livewire\Dashboard\Events\EventForm;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class EventFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->actingAs(User::factory()->create());
    }

    public function test_can_create_event_without_end_at(): void
    {
        Livewire::test(EventForm::class)
            ->set('title', 'Culto de Celebração')
            ->set('slug', 'culto-celebracao')
            ->set('type', 'culto')
            ->set('start_at', '20/08/2026 10:00')
            ->set('end_at', '')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('events', [
            'title' => 'Culto de Celebração',
            'end_at' => null,
        ]);
    }

    public function test_can_create_event_with_start_and_end(): void
    {
        Livewire::test(EventForm::class)
            ->set('title', 'Conferência Semear')
            ->set('slug', 'conferencia-semear')
            ->set('type', 'evento')
            ->set('start_at', '21/08/2026 09:00')
            ->set('end_at', '22/08/2026 18:00')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('events', [
            'title' => 'Conferência Semear',
            'start_at' => '2026-08-21 09:00:00',
            'end_at' => '2026-08-22 18:00:00',
        ]);
    }

    public function test_end_at_before_start_is_rejected(): void
    {
        Livewire::test(EventForm::class)
            ->set('title', 'Evento Inválido')
            ->set('slug', 'evento-invalido')
            ->set('start_at', '21/08/2026 09:00')
            ->set('end_at', '21/08/2026 08:00')
            ->call('save')
            ->assertHasErrors(['end_at' => 'after_or_equal']);

        $this->assertDatabaseMissing('events', ['title' => 'Evento Inválido']);
    }

    public function test_update_event_keeps_empty_end_at(): void
    {
        $event = Event::create([
            'title' => 'Retiro',
            'slug' => 'retiro',
            'type' => 'campanha',
            'start_at' => '2026-08-21 09:00',
            'end_at' => '2026-08-22 18:00',
            'status' => 1,
            'created_by' => auth()->id(),
        ]);

        Livewire::test(EventForm::class, ['event' => $event])
            ->set('title', 'Retiro Atualizado')
            ->set('end_at', '')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => 'Retiro Atualizado',
            'end_at' => null,
        ]);
    }

    public function test_cover_upload_is_converted_to_webp(): void
    {
        $file = UploadedFile::fake()->image('capa.jpg', 1200, 600);

        Livewire::test(EventForm::class)
            ->set('title', 'Culto de Celebração')
            ->set('slug', 'culto-celebracao-webp')
            ->set('start_at', '20/08/2026 10:00')
            ->set('cover', $file)
            ->call('save')
            ->assertHasNoErrors();

        $event = Event::where('slug', 'culto-celebracao-webp')->firstOrFail();

        $this->assertStringEndsWith('.webp', $event->cover);
        $this->assertTrue(Storage::disk('public')->exists($event->cover));
        $this->assertSame('image/webp', Storage::disk('public')->mimeType($event->cover));
    }

    public function test_cover_with_small_dimensions_is_rejected(): void
    {
        $file = UploadedFile::fake()->image('capa-pequena.png', 200, 200);

        Livewire::test(EventForm::class)
            ->set('title', 'Evento Teste')
            ->set('slug', 'evento-teste-imagem')
            ->set('start_at', '20/08/2026 10:00')
            ->set('cover', $file)
            ->call('save')
            ->assertHasErrors(['cover' => 'dimensions']);

        $this->assertDatabaseMissing('events', ['slug' => 'evento-teste-imagem']);
    }

    public function test_cover_rejects_non_image_file(): void
    {
        $file = UploadedFile::fake()->create('documento.txt', 100);

        Livewire::test(EventForm::class)
            ->set('title', 'Evento Teste 2')
            ->set('slug', 'evento-teste-arquivo')
            ->set('start_at', '20/08/2026 10:00')
            ->set('cover', $file)
            ->call('save')
            ->assertHasErrors(['cover']);

        $this->assertDatabaseMissing('events', ['slug' => 'evento-teste-arquivo']);
    }
}