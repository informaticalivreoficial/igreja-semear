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

    public $titulo;

    public $subtitulo;

    public $botaolabel;

    public $imagem;

    public $content;

    public $link;

    public $target = false;

    public $exibir_titulo = true;

    public $categoria;

    public $expira;

    public $status = false;

    public ?string $imagemPath = null;

    protected function rules(): array
    {
        return [
            'titulo' => 'required|string|max:255',
            'imagem' => $this->slide ? 'nullable|image|max:2048' : 'nullable|image|max:2048',
            'expira' => 'nullable|date_format:d/m/Y',
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
            $this->imagemPath = $slide->imagem;
            $this->titulo = $slide->titulo;
            $this->subtitulo = $slide->subtitulo;
            $this->botaolabel = $slide->botaolabel;
            $this->content = $slide->content;
            $this->link = $slide->link;
            $this->target = (bool) $slide->target;
            $this->exibir_titulo = (bool) $slide->exibir_titulo;
            $this->categoria = $slide->categoria;
            $this->expira = $slide->expira?->format('d/m/Y');
            $this->status = (bool) $slide->status;
        } else {
            $this->slide = new Slide;
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->imagem) {
            if ($this->slide?->exists && $this->imagemPath) {
                Storage::disk('public')->delete($this->imagemPath);
            }
            $this->imagemPath = $this->imagem->store('slides', 'public');
        }

        $slug = Str::slug($this->titulo);
        if (Slide::where('slug', $slug)->where('id', '!=', $this->slide->id ?? 0)->exists()) {
            $slug = $slug.'-'.Str::random(4);
        }

        $data = [
            'titulo' => $this->titulo,
            'subtitulo' => $this->subtitulo,
            'botaolabel' => $this->botaolabel,
            'imagem' => $this->imagemPath,
            'content' => $this->content,
            'link' => $this->link,
            'target' => (bool) $this->target,
            'exibir_titulo' => (bool) $this->exibir_titulo,
            'categoria' => $this->categoria,
            'expira' => $this->expira,
            'status' => (bool) $this->status,
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
