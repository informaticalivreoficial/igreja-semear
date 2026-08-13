<?php

namespace App\Livewire\Dashboard\Ministries;

use App\Models\Ministry;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class MinistryForm extends Component
{
    use WithFileUploads;

    public ?Ministry $ministry = null;

    public Collection $leaders;

    public Collection $members;

    public string $name = '';

    public string $slug = '';

    public string $description = '';

    public string $color = '';

    public string $leader_id = '';

    public bool $status = true;

    public array $memberIds = [];

    public string $memberRole = 'membro';

    public $cover;

    protected function rules()
    {
        return [
            'name' => 'required|string|min:3|max:191',
            'slug' => 'required|string|max:191|unique:ministries,slug,'.($this->ministry?->id ?? 'NULL'),
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:20',
            'leader_id' => 'nullable|exists:users,id',
            'status' => 'required|boolean',
            'memberIds' => 'nullable|array',
            'memberIds.*' => 'exists:users,id',
            'cover' => 'nullable|image|max:2048',
        ];
    }

    protected $messages = [
        'name.required' => 'O nome do ministério é obrigatório.',
        'slug.unique' => 'Já existe um ministério com esse endereço (slug).',
        'leader_id.exists' => 'O líder selecionado é inválido.',
    ];

    public function render()
    {
        $title = $this->ministry?->exists ? 'Editar Ministério' : 'Cadastrar Ministério';

        return view('livewire.dashboard.ministries.ministry-form', [
            'title' => $title,
        ]);
    }

    public function mount(Ministry $ministry)
    {
        $this->leaders = User::orderBy('name')->get();
        $this->members = $this->leaders;

        if ($ministry->exists) {
            $this->ministry = $ministry;
            $this->name = $ministry->name;
            $this->slug = $ministry->slug;
            $this->description = $ministry->description ?? '';
            $this->color = $ministry->color ?? '';
            $this->leader_id = (string) $ministry->leader_id;
            $this->status = (bool) $ministry->status;
            $this->memberIds = $ministry->members()->pluck('users.id')->map(fn ($id) => (string) $id)->all();
        } else {
            $this->ministry = new Ministry;
            $this->slug = Str::slug($this->name);
        }
    }

    public function updatedName($value)
    {
        if (! $this->ministry?->exists) {
            $this->slug = Str::slug($value);
        }
    }

    public function save()
    {
        $validated = $this->validate();

        $data = [
            'name' => $validated['name'],
            'slug' => ! empty($validated['slug']) ? $validated['slug'] : Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'color' => $validated['color'] ?? null,
            'leader_id' => ! empty($validated['leader_id']) ? $validated['leader_id'] : null,
            'status' => $validated['status'],
        ];

        if ($this->cover instanceof TemporaryUploadedFile) {
            if (! empty($this->ministry->cover) && Storage::disk('public')->exists($this->ministry->cover)) {
                Storage::disk('public')->delete($this->ministry->cover);
            }
            $data['cover'] = $this->cover->store('ministries', 'public');
        }

        if ($this->ministry->exists) {
            $this->ministry->update($data);
            $message = 'Ministério atualizado com sucesso!';
        } else {
            $this->ministry = Ministry::create($data);
            $message = 'Ministério criado com sucesso!';
        }

        $sync = collect($this->memberIds ?? [])->mapWithKeys(fn ($id) => [$id => ['role' => $this->memberRole]])->all();
        $this->ministry->members()->sync($sync);

        $this->dispatch('swal', [
            'icon' => 'success',
            'timer' => 2000,
            'title' => $message,
            'showConfirmButton' => false,
        ]);

        return redirect()->route('admin.ministries.index');
    }
}
