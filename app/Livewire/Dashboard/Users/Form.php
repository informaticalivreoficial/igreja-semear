<?php

namespace App\Livewire\Dashboard\Users;

use App\Models\Family;
use App\Models\Ministry;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class Form extends Component
{
    use WithFileUploads;

    public ?User $user = null;

    public $foto;

    public $fotoUrl;

    public $name;

    public $birthday;

    public $gender;

    public $naturalness;

    public $civil_status;

    public $cpf;

    public $rg;

    public $rg_expedition;

    public $postcode = '';

    public $street;

    public $neighborhood;

    public $city;

    public $state;

    public $complement;

    public $number;

    public $cell_phone;

    public $whatsapp;

    public $email;

    public $additional_email;

    public $facebook;

    public $instagram;

    public $linkedin;

    public bool $baptism = false;

    public $baptism_date;

    public bool $status = true;

    public $information;

    public $role = 'member';

    public array $ministries = [];

    public $family_id = '';

    public $family_role = '';

    public Collection $roles;

    public Collection $ministryOptions;

    public Collection $familyOptions;

    public $password;

    public $password_confirmation;

    protected function rules()
    {
        return [
            'name' => 'required|string|min:3|max:191',
            'birthday' => 'nullable|date_format:d/m/Y|before:today',
            'cpf' => 'nullable|unique:users,cpf,'.($this->user?->id),
            'email' => 'required|email|unique:users,email,'.($this->user?->id),
            'cell_phone' => 'nullable|string|max:20',
            'postcode' => 'nullable|string|max:10',
            'role' => 'required|exists:roles,name',
            'password' => 'nullable|min:6|confirmed',
            'ministries' => 'nullable|array',
            'ministries.*' => 'exists:ministries,id',
        ];
    }

    protected $messages = [
        'name.required' => 'O nome é obrigatório.',
        'name.min' => 'O nome deve ter no mínimo :min caracteres.',
        'cpf.unique' => 'Já existe um usuário com esse CPF.',
        'email.required' => 'O e-mail é obrigatório.',
        'email.email' => 'Informe um e-mail válido.',
        'email.unique' => 'Já existe um usuário com esse e-mail.',
        'role.required' => 'Selecione o cargo do usuário.',
        'role.exists' => 'O cargo selecionado é inválido.',
        'password.min' => 'A senha deve ter no mínimo :min caracteres.',
        'password.confirmed' => 'As senhas não coincidem.',
    ];

    public function mount(?User $user = null)
    {
        $this->roles = Role::orderBy('name')->get();
        $this->ministryOptions = Ministry::orderBy('name')->get();
        $this->familyOptions = Family::orderBy('name')->get();

        $this->user = $user;

        if ($this->user) {
            $this->name = $user->name;
            $this->birthday = $user->birthday?->format('d/m/Y');
            $this->gender = $user->gender ?? 'masculino';
            $this->naturalness = $user->naturalness;
            $this->civil_status = $user->civil_status;
            $this->rg = $user->rg;
            $this->rg_expedition = $user->rg_expedition;
            $this->cpf = $user->cpf;
            $this->email = $user->email;
            $this->cell_phone = $user->cell_phone;
            $this->whatsapp = $user->whatsapp;
            $this->additional_email = $user->additional_email;
            $this->number = $user->number;
            $this->postcode = $user->postcode;
            $this->street = $user->street;
            $this->neighborhood = $user->neighborhood;
            $this->city = $user->city;
            $this->state = $user->state;
            $this->complement = $user->complement;
            $this->facebook = $user->facebook;
            $this->instagram = $user->instagram;
            $this->linkedin = $user->linkedin;
            $this->baptism = (bool) $user->baptism;
            $this->baptism_date = $user->baptism_date?->format('d/m/Y');
            $this->status = (bool) $user->status;
            $this->information = $user->information;
            $this->role = $user->getRoleNames()->first() ?? 'member';
            $this->ministries = $user->ministries()->pluck('ministries.id')->map(fn ($id) => (string) $id)->all();
            $this->family_id = $user->member?->family_id ? (string) $user->member->family_id : '';
            $this->family_role = $user->member?->family_role ?? '';
        }
    }

    public function render()
    {
        $title = $this->user?->exists ? 'Editar Usuário' : 'Cadastrar Usuário';

        return view('livewire.dashboard.users.form')->with('title', $title);
    }

    public function save()
    {
        $validated = $this->validate();

        $data = [
            'name' => $this->name,
            'birthday' => $this->birthday,
            'gender' => $this->gender,
            'naturalness' => $this->naturalness,
            'civil_status' => $this->civil_status,
            'rg' => $this->rg,
            'rg_expedition' => $this->rg_expedition,
            'cpf' => $this->cpf,
            'email' => $this->email,
            'cell_phone' => $this->cell_phone,
            'whatsapp' => $this->whatsapp,
            'additional_email' => $this->additional_email,
            'number' => $this->number,
            'postcode' => $this->postcode,
            'street' => $this->street,
            'neighborhood' => $this->neighborhood,
            'city' => $this->city,
            'state' => $this->state,
            'complement' => $this->complement,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'baptism' => (bool) $this->baptism,
            'baptism_date' => $this->baptism_date,
            'status' => (bool) $this->status,
            'information' => $this->information,
        ];

        if ($this->foto) {
            if ($this->user?->avatar && Storage::disk('public')->exists($this->user->avatar)) {
                Storage::disk('public')->delete($this->user->avatar);
            }

            $data['avatar'] = $this->foto->store('users', 'public');
        }

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->user?->exists) {
            $this->user->update($data);
            $message = 'Usuário atualizado com sucesso!';
        } else {
            $this->user = User::create($data);
            $message = 'Usuário cadastrado com sucesso!';
        }

        $this->user->syncRoles([$this->role]);
        $this->user->ministries()->sync($this->ministries ?? []);

        // Sincronizar registro na tabela members (fonte de dados do membro)
        if ($this->role === 'member' || $this->user->member()->exists()) {
            $this->user->member()->updateOrCreate(
                ['user_id' => $this->user->id],
                [
                    'family_id' => $this->family_id ?: null,
                    'family_role' => $this->family_role ?: null,
                    'name' => $this->name,
                    'gender' => $this->gender,
                    'cpf' => $this->cpf,
                    'rg' => $this->rg,
                    'rg_expedition' => $this->rg_expedition,
                    'birthday' => $this->birthday,
                    'naturalness' => $this->naturalness,
                    'civil_status' => $this->civil_status,
                    'baptism' => (bool) $this->baptism,
                    'baptism_date' => $this->baptism_date,
                    'postcode' => $this->postcode,
                    'street' => $this->street,
                    'number' => $this->number,
                    'neighborhood' => $this->neighborhood,
                    'state' => $this->state,
                    'city' => $this->city,
                    'complement' => $this->complement,
                    'cell_phone' => $this->cell_phone,
                    'whatsapp' => $this->whatsapp,
                    'email' => $this->email,
                    'status' => (bool) $this->status,
                ]
            );
        }

        $this->dispatch('swal', [
            'title' => 'Sucesso!',
            'text' => $message,
            'icon' => 'success',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);

        if ($this->user->wasRecentlyCreated) {
            return redirect()->route('admin.users.edit', $this->user->id);
        }
    }

    public function updatedPostcode(string $value)
    {
        $this->postcode = preg_replace('/[^0-9]/', '', $value);

        if (strlen($this->postcode) === 8) {
            $response = Http::get("https://viacep.com.br/ws/{$this->postcode}/json/")->json();
            if (! isset($response['erro'])) {
                $this->street = $response['logradouro'] ?? '';
                $this->neighborhood = $response['bairro'] ?? '';
                $this->state = $response['uf'] ?? '';
                $this->city = $response['localidade'] ?? '';
                $this->complement = $response['complemento'] ?? '';
            } else {
                $this->addError('postcode', 'CEP não encontrado.');
            }
        }
    }

    public function updatedFoto()
    {
        $this->validateOnly('foto');
        $this->fotoUrl = $this->foto->temporaryUrl();
    }
}
