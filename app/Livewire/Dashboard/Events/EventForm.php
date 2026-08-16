<?php

namespace App\Livewire\Dashboard\Events;

use App\Models\Event;
use App\Support\ImageService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class EventForm extends Component
{
    use WithFileUploads;

    public ?Event $event = null;

    public string $title = '';

    public string $slug = '';

    public string $type = 'evento';

    public string $description = '';

    public string $location = '';

    public ?string $start_at = '';

    public ?string $end_at = '';

    public bool $status = true;

    public $cover;

    protected function rules()
    {
        return [
            'title' => 'required|string|min:3|max:191',
            'slug' => 'required|string|max:191|unique:events,slug,'.($this->event?->id ?? 'NULL'),
            'type' => 'required|string|max:60',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:191',
            'start_at' => 'required|date_format:d/m/Y H:i',
            'end_at' => 'nullable|date_format:d/m/Y H:i|after_or_equal:start_at',
            'status' => 'required|boolean',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096|dimensions:min_width=800,min_height=400',
        ];
    }

    protected $messages = [
        'title.required' => 'O título do evento é obrigatório.',
        'title.min' => 'O título deve ter no mínimo :min caracteres.',
        'slug.unique' => 'Já existe um evento com esse endereço (slug).',
        'start_at.required' => 'Informe a data e hora de início.',
        'start_at.date_format' => 'Informe a data de início no formato dd/mm/aaaa hh:mm.',
        'end_at.date_format' => 'Informe a data de término no formato dd/mm/aaaa hh:mm.',
        'end_at.after_or_equal' => 'O término deve ser depois do início.',
        'cover.image' => 'O arquivo deve ser uma imagem.',
        'cover.mimes' => 'A imagem deve ser JPG, PNG ou WebP.',
        'cover.max' => 'A imagem não pode ultrapassar 4MB.',
        'cover.dimensions' => 'A imagem deve ter no mínimo 800x400 pixels.',
    ];

    public function render()
    {
        $title = $this->event?->exists ? 'Editar Evento' : 'Cadastrar Evento';

        return view('livewire.dashboard.events.event-form', [
            'title' => $title,
        ]);
    }

    public function mount(Event $event)
    {
        if ($event->exists) {
            $this->event = $event;
            $this->title = $event->title;
            $this->slug = $event->slug;
            $this->type = $event->type ?? 'evento';
            $this->description = $event->description ?? '';
            $this->location = $event->location ?? '';
            $this->start_at = $event->start_at?->format('d/m/Y H:i') ?? '';
            $this->end_at = $event->end_at?->format('d/m/Y H:i') ?? '';
            $this->status = (bool) $event->status;
        } else {
            $this->event = new Event;
            $this->start_at = now()->format('d/m/Y H:i');
        }
    }

    protected function normalizeDate(?string $value): ?string
    {
        return ($value === null || trim($value) === '') ? null : trim($value);
    }

    protected function storeCoverWebp(TemporaryUploadedFile $cover): string
    {
        return ImageService::storeWebp($cover, 'events');
    }

    public function updatedTitle($value)
    {
        if (! $this->event?->exists) {
            $this->slug = Str::slug($value);
        }
    }

    public function save()
    {
        $this->start_at = $this->normalizeDate($this->start_at);
        $this->end_at = $this->normalizeDate($this->end_at);

        $validated = $this->validate();

        $data = [
            'title' => $validated['title'],
            'slug' => ! empty($validated['slug']) ? $validated['slug'] : Str::slug($validated['title']),
            'type' => $validated['type'],
            'description' => $validated['description'] ?? null,
            'location' => $validated['location'] ?? null,
            'start_at' => Carbon::createFromFormat('d/m/Y H:i', $validated['start_at']),
            'end_at' => $validated['end_at'] ? Carbon::createFromFormat('d/m/Y H:i', $validated['end_at']) : null,
            'status' => $validated['status'],
            'created_by' => auth()->id(),
        ];

        if ($this->cover instanceof TemporaryUploadedFile) {
            if (! empty($this->event->cover) && Storage::disk('public')->exists($this->event->cover)) {
                Storage::disk('public')->delete($this->event->cover);
            }
            $data['cover'] = $this->storeCoverWebp($this->cover);
        }

        if ($this->event->exists) {
            $this->event->update($data);
            $message = 'Evento atualizado com sucesso!';
        } else {
            $this->event = Event::create($data);
            $message = 'Evento criado com sucesso!';
        }

        $this->dispatch('swal', [
            'icon' => 'success',
            'timer' => 2000,
            'title' => $message,
            'showConfirmButton' => false,
        ]);

        $this->reset('cover');
    }
}
