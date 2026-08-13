<?php

namespace App\Livewire\Dashboard\Offerings;

use App\Models\Offering;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Component;

class OfferingForm extends Component
{
    public ?Offering $offering = null;

    public Collection $members;

    public string $user_id = '';

    public string $type = 'oferta';

    public string $amount = '';

    public string $offering_date = '';

    public string $payment_method = '';

    public string $notes = '';

    protected function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string|max:60',
            'amount' => 'required|numeric|gt:0',
            'offering_date' => 'required|date',
            'payment_method' => 'nullable|string|max:60',
            'notes' => 'nullable|string',
        ];
    }

    protected $messages = [
        'user_id.required' => 'Selecione o membro.',
        'user_id.exists' => 'O membro selecionado é inválido.',
        'amount.required' => 'Informe o valor.',
        'amount.numeric' => 'O valor deve ser numérico.',
        'amount.gt' => 'O valor deve ser maior que zero.',
        'offering_date.required' => 'Informe a data da oferta.',
    ];

    public function render()
    {
        $title = $this->offering?->exists ? 'Editar Oferta' : 'Cadastrar Oferta';

        return view('livewire.dashboard.offerings.offering-form', [
            'title' => $title,
        ]);
    }

    public function mount(Offering $offering)
    {
        $this->members = User::orderBy('name')->get();

        if ($offering->exists) {
            $this->offering = $offering;
            $this->user_id = (string) $offering->user_id;
            $this->type = $offering->type ?? 'oferta';
            $this->amount = (string) $offering->amount;
            $this->offering_date = $offering->offering_date?->format('Y-m-d') ?? now()->format('Y-m-d');
            $this->payment_method = $offering->payment_method ?? '';
            $this->notes = $offering->notes ?? '';
        } else {
            $this->offering = new Offering;
            $this->offering_date = now()->format('Y-m-d');
        }
    }

    public function save()
    {
        $validated = $this->validate();

        $data = [
            'user_id' => $validated['user_id'],
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'offering_date' => $validated['offering_date'],
            'payment_method' => $validated['payment_method'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'created_by' => auth()->id(),
        ];

        if ($this->offering->exists) {
            $this->offering->update($data);
            $message = 'Oferta atualizada com sucesso!';
        } else {
            $this->offering = Offering::create($data);
            $message = 'Oferta cadastrada com sucesso!';
        }

        $this->dispatch('swal', [
            'icon' => 'success',
            'timer' => 2000,
            'title' => $message,
            'showConfirmButton' => false,
        ]);

        return redirect()->route('admin.offerings.index');
    }
}
