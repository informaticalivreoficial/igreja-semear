<?php

namespace App\Livewire\Dashboard\Announcements;

use App\Models\Announcement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class AnnouncementForm extends Component
{
    use WithFileUploads;

    public ?Announcement $announcement = null;

    public string $title = '';

    public string $content = '';

    public $cover;

    public bool $status = true;

    public ?string $publish_at = null;

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'cover' => 'nullable|image|max:5120',
            'publish_at' => 'nullable|date_format:d/m/Y',
        ];
    }

    protected $messages = [
        'title.required' => 'Informe o título do aviso.',
        'content.required' => 'Escreva o conteúdo do aviso.',
    ];

    public function render()
    {
        $title = $this->announcement?->exists ? 'Editar Aviso' : 'Cadastrar Aviso';

        return view('livewire.dashboard.announcements.announcement-form', [
            'title' => $title,
        ]);
    }

    public function mount(Announcement $announcement)
    {
        $this->announcement = $announcement;

        if ($announcement->exists) {
            $this->title = $announcement->title;
            $this->content = $announcement->content;
            $this->status = $announcement->status;
            $this->publish_at = $announcement->publish_at?->format('d/m/Y');
        }
    }

    public function save()
    {
        $validated = $this->validate();

        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'status' => $this->status,
            'publish_at' => $validated['publish_at'] ? Carbon::createFromFormat('d/m/Y', $validated['publish_at'])->format('Y-m-d') : null,
            'created_by' => auth()->id(),
        ];

        if ($this->cover) {
            if ($this->announcement->exists && $this->announcement->cover) {
                Storage::disk('public')->delete($this->announcement->cover);
            }
            $data['cover'] = $this->cover->store('announcements', 'public');
        }

        if ($this->announcement->exists) {
            $this->announcement->update($data);
            $message = 'Aviso atualizado com sucesso!';
        } else {
            Announcement::create($data);
            $message = 'Aviso cadastrado com sucesso!';
        }

        $this->dispatch('swal', ['icon' => 'success', 'timer' => 2000, 'title' => $message, 'showConfirmButton' => false]);

        return redirect()->route('admin.announcements.index');
    }
}
