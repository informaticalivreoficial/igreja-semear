<?php

namespace App\Livewire\Dashboard\Slides;

use App\Models\Slide;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class SlideForm extends Component
{
    use WithFileUploads;

    public ?Slide $slide = null;

    public $title;

    public $subtitle;

    public $button_label;

    public $image;

    public $content;

    public $link;

    public $target = false;

    public $show_title = true;

    public $category;

    public $expires_at;

    public $is_active = false;

    public ?string $imagePath = null;

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'expires_at' => 'nullable|date_format:d/m/Y',
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.slides.slide-form', [
            'titlee' => $this->slide?->exists ? 'Editar Banner' : 'Cadastrar Banner',
        ]);
    }

    public function mount(Slide $slide)
    {
        if ($slide->exists) {
            $this->slide = $slide;
            $this->imagePath = $slide->image;
            $this->title = $slide->title;
            $this->subtitle = $slide->subtitle;
            $this->button_label = $slide->button_label;
            $this->content = $slide->content;
            $this->link = $slide->link;
            $this->target = (bool) $slide->target;
            $this->show_title = (bool) $slide->show_title;
            $this->category = $slide->category;
            $this->expires_at = $slide->expires_at?->format('d/m/Y');
            $this->is_active = (bool) $slide->is_active;
        } else {
            $this->slide = new Slide;
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->image) {
            if ($this->slide?->exists && $this->imagePath) {
                Storage::disk('public')->delete($this->imagePath);
            }
            $this->imagePath = $this->image->store('slides', 'public');
        }

        $slug = Str::slug($this->title);
        if (Slide::where('slug', $slug)->where('id', '!=', $this->slide->id ?? 0)->exists()) {
            $slug = $slug.'-'.Str::random(4);
        }

        $data = [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'button_label' => $this->button_label,
            'image' => $this->imagePath,
            'content' => $this->content,
            'link' => $this->link,
            'target' => (bool) $this->target,
            'show_title' => (bool) $this->show_title,
            'category' => $this->category,
            'expires_at' => $this->expires_at,
            'is_active' => (bool) $this->is_active,
            'slug' => $slug,
        ];

        if ($this->slide->exists) {
            $this->slide->update($data);
            $text = 'Slide Atualizado com sucesso!';
        } else {
            $this->slide = Slide::create($data);
            $text = 'Slide Cadastrado com sucesso!';
        }

        $this->dispatch('swal', [
            'title' => 'Sucesso!',
            'text' => $text,
            'icon' => 'success',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);

        return redirect()->route('admin.slides.edit', $this->slide->id);
    }
}
