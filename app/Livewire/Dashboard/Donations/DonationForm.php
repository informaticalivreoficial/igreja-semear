<?php

namespace App\Livewire\Dashboard\Donations;

use App\Enums\DonationStatusEnum;
use App\Enums\DonationTypeEnum;
use App\Models\Donation;
use App\Models\Member;
use Illuminate\Support\Collection;
use Livewire\Component;

class DonationForm extends Component
{
    public ?Donation $donation = null;

    public Collection $members;

    public string $member_id = '';

    public string $type = 'offering';

    public string $amount = '';

    public string $payment_method = '';

    public string $donation_date = '';

    public string $description = '';

    public bool $is_anonymous = false;

    protected function rules()
    {
        return [
            'member_id' => 'nullable|exists:members,id',
            'type' => 'required|string|max:60',
            'amount' => 'required|numeric|gt:0',
            'donation_date' => 'required|date',
            'payment_method' => 'nullable|string|max:60',
            'description' => 'nullable|string|max:500',
            'is_anonymous' => 'boolean',
        ];
    }

    protected $messages = [
        'type.required' => 'Informe o tipo.',
        'amount.required' => 'Informe o valor.',
        'amount.numeric' => 'O valor deve ser numérico.',
        'amount.gt' => 'O valor deve ser maior que zero.',
        'donation_date.required' => 'Informe a data.',
        'donation_date.date' => 'Informe uma data válida.',
    ];

    public function render()
    {
        $title = $this->donation?->exists ? 'Editar Doação' : 'Cadastrar Doação Manual';

        return view('livewire.dashboard.donations.donation-form', [
            'title' => $title,
            'types' => DonationTypeEnum::labels(),
        ]);
    }

    public function mount(Donation $donation)
    {
        $this->members = Member::with('user')->orderBy('name')->get();

        if ($donation->exists) {
            $this->donation = $donation;
            $this->member_id = (string) ($donation->member_id ?? '');
            $this->type = $donation->type ?? 'offering';
            $this->amount = (string) $donation->amount;
            $this->payment_method = $donation->payment_method ?? '';
            $this->donation_date = $donation->created_at?->format('Y-m-d') ?? now()->format('Y-m-d');
            $this->description = $donation->description ?? '';
            $this->is_anonymous = (bool) $donation->is_anonymous;
        } else {
            $this->donation = new Donation;
            $this->donation_date = now()->format('Y-m-d');
        }
    }

    public function save()
    {
        $validated = $this->validate();

        $data = [
            'member_id' => $validated['member_id'] !== '' ? $validated['member_id'] : null,
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_anonymous' => (bool) $validated['is_anonymous'],
            'source' => 'manual',
            'status' => DonationStatusEnum::Paid->value,
            'created_at' => $validated['donation_date'],
        ];

        if ($this->donation->exists) {
            $this->donation->update($data);
            $message = 'Doação atualizada com sucesso!';
        } else {
            $this->donation = Donation::create($data);
            $message = 'Doação cadastrada com sucesso!';
        }

        $this->dispatch('swal', [
            'icon' => 'success',
            'timer' => 2000,
            'title' => $message,
            'showConfirmButton' => false,
        ]);

        return redirect()->route('admin.donations.index');
    }
}