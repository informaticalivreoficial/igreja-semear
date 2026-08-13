<div>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-user"></i> {{ $title }}</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Usuários</a></span>
            <span class="breadcrumb-item active">{{ $user?->exists ? 'Editar' : 'Cadastrar' }}</span>
        </nav>
    </div>

    <form wire:submit.prevent="save" autocomplete="off">
        <div class="card">
            <div class="card-body">
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    {{-- Foto --}}
                    <div class="flex flex-col items-center">
                        @php
                            if (!empty($user?->avatar) && Storage::exists($user->avatar)) {
                                $cover = Storage::url($user->avatar);
                            } else {
                                $cover = asset('backend/assets/images/avatar3.png');
                            }
                        @endphp
                        <input type="file" id="foto" wire:model="foto" style="display: none;">
                        @error('foto')
                            <span class="erro-feedback">{{ $message }}</span>
                        @enderror
                        <label for="foto" class="group relative cursor-pointer">
                            <img class="h-40 w-40 rounded-full object-cover ring-4 ring-gold-300 transition group-hover:ring-gold-500"
                                src="{{ $fotoUrl ?? $cover }}" alt="{{ $name }}">
                            <span class="absolute inset-0 flex items-center justify-center rounded-full bg-forest-900/0 text-white opacity-0 transition group-hover:bg-forest-900/50 group-hover:opacity-100">
                                <i class="fas fa-camera text-2xl"></i>
                            </span>
                        </label>
                        <p class="mt-3 text-xs text-slate-400">Clique para alterar a foto</p>
                    </div>

                    {{-- Dados pessoais --}}
                    <div class="grid grid-cols-1 gap-x-6 gap-y-0 md:grid-cols-2 lg:col-span-2">
                        <div class="form-group">
                            <label class="labelforms"><b>*Nome</b></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nome" wire:model="name">
                            @error('name')
                                <span class="error erro-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="labelforms"><b>Data de Nascimento</b></label>
                            <div class="relative">
                                <i class="far fa-calendar-alt pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" class="form-control pl-9 @error('birthday') is-invalid @enderror" wire:model="birthday" id="datepicker"
                                    x-data="{ value: @entangle('birthday').defer }" x-init="initFlatpickr()" x-ref="datepicker" />
                            </div>
                            @error('birthday')
                                <span class="error erro-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="labelforms"><b>Gênero</b></label>
                            <select class="form-control @error('gender') is-invalid @enderror" wire:model="gender">
                                <option value="">Selecione</option>
                                <option value="masculino">Masculino</option>
                                <option value="feminino">Feminino</option>
                            </select>
                            @error('gender')
                                <span class="error erro-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="labelforms"><b>Estado Civil</b></label>
                            <select class="form-control @error('civil_status') is-invalid @enderror" wire:model="civil_status">
                                <option value="">Selecione</option>
                                <option value="casado">Casado</option>
                                <option value="separado">Separado</option>
                                <option value="solteiro">Solteiro</option>
                                <option value="divorciado">Divorciado</option>
                                <option value="viuvo">Viúvo(a)</option>
                            </select>
                            @error('civil_status')
                                <span class="error erro-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="labelforms"><b>CPF</b></label>
                            <input type="text" class="form-control @error('cpf') is-invalid @enderror" placeholder="000.000.000-00" id="cpf" wire:model="cpf" x-mask="999.999.999-99" />
                            @error('cpf')
                                <span class="error erro-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="labelforms"><b>RG</b></label>
                            <input type="text" class="form-control" placeholder="RG"
                                id="rg" wire:model="rg" x-mask="99.999.999-9" />
                        </div>
                        <div class="form-group">
                            <label class="labelforms"><b>Órgão Expedidor</b></label>
                            <input type="text" class="form-control" placeholder="Expedição"
                                id="rg_expedition" wire:model="rg_expedition">
                        </div>
                        <div class="form-group">
                            <label class="labelforms"><b>Naturalidade</b></label>
                            <input type="text" class="form-control"
                                placeholder="Cidade de Nascimento" id="naturalness"
                                wire:model="naturalness">
                        </div>
                    </div>
                </div>

                <div class="card mt-6 bg-slate-50/60">
                    <div class="card-header">
                        <h4 class="card-title text-slate-700"><strong>Vida Cristã</strong></h4>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 gap-x-6 md:grid-cols-3">
                            <div class="form-group">
                                <label class="labelforms"><b>Batizado</b></label>
                                <div class="pt-2">
                                    <x-forms.switch-toggle
                                        wire:model="baptism"
                                        :checked="$baptism"
                                        size="md"
                                        color="green"
                                    />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>Data do Batismo</b></label>
                                <div class="relative">
                                    <i class="far fa-calendar-alt pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                    <input type="text" class="form-control pl-9 @error('baptism_date') is-invalid @enderror" wire:model="baptism_date" id="datepickerBaptism"
                                        x-data="{ value: @entangle('baptism_date').defer }" x-init="initFlatpickr()" x-ref="datepickerBaptism" />
                                </div>
                                @error('baptism_date')
                                    <span class="error erro-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>Status</b></label>
                                <div class="pt-2">
                                    <x-forms.switch-toggle
                                        wire:model="status"
                                        :checked="$status"
                                        size="md"
                                        color="green"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-6 bg-slate-50/60">
                    <div class="card-header">
                        <h4 class="card-title text-slate-700"><strong>Contato</strong></h4>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 gap-x-6 md:grid-cols-2 lg:grid-cols-4">
                            <div class="form-group">
                                <label class="labelforms"><b>*Celular:</b></label>
                                <input type="text" class="form-control @error('cell_phone') is-invalid @enderror" placeholder="(00) 00000-0000"
                                    x-mask="(99) 99999-9999" wire:model="cell_phone"
                                    id="cell_phone">
                                @error('cell_phone')
                                    <span class="error erro-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>WhatsApp:</b></label>
                                <input type="text" class="form-control" placeholder="(00) 00000-0000"
                                    x-mask="(99) 99999-9999" wire:model="whatsapp"
                                    id="whatsapp">
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>*E-mail:</b></label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email" wire:model="email" id="email">
                                @error('email')
                                    <span class="error erro-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>E-mail Alternativo:</b></label>
                                <input type="text" class="form-control"
                                    placeholder="Email Alternativo" wire:model="additional_email"
                                    id="additional_email">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-6 bg-slate-50/60">
                    <div class="card-header">
                        <h4 class="card-title text-slate-700"><strong>Endereço</strong></h4>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 gap-x-6 md:grid-cols-2 lg:grid-cols-6">
                            <div class="form-group lg:col-span-1">
                                <label class="labelforms"><b>CEP:</b></label>
                                <input type="text" x-mask="99.999-999" class="form-control @error('postcode') is-invalid @enderror" id="postcode" wire:model.lazy="postcode">
                                @error('postcode')
                                    <span class="error erro-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group lg:col-span-1">
                                <label class="labelforms"><b>Estado:</b></label>
                                <input type="text" class="form-control bg-slate-100" id="state" wire:model="state" readonly>
                            </div>
                            <div class="form-group lg:col-span-2">
                                <label class="labelforms"><b>Cidade:</b></label>
                                <input type="text" class="form-control bg-slate-100" id="city" wire:model="city" readonly>
                            </div>
                            <div class="form-group lg:col-span-2">
                                <label class="labelforms"><b>Rua:</b></label>
                                <input type="text" class="form-control bg-slate-100" id="street" wire:model="street" readonly>
                            </div>
                            <div class="form-group lg:col-span-2">
                                <label class="labelforms"><b>Bairro:</b></label>
                                <input type="text" class="form-control bg-slate-100" id="neighborhood" wire:model="neighborhood" readonly>
                            </div>
                            <div class="form-group lg:col-span-1">
                                <label class="labelforms"><b>Número:</b></label>
                                <input type="text" class="form-control" placeholder="Número do Endereço" id="number" wire:model="number">
                            </div>
                            <div class="form-group lg:col-span-2">
                                <label class="labelforms"><b>Complemento:</b></label>
                                <input type="text" class="form-control" id="complement" wire:model="complement">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-6 bg-slate-50/60">
                    <div class="card-header">
                        <h4 class="card-title text-slate-700"><strong>Redes Sociais</strong></h4>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 gap-x-6 md:grid-cols-3">
                            <div class="form-group">
                                <label class="labelforms"><b>Facebook:</b></label>
                                <input type="text" class="form-control" placeholder="Facebook"
                                    id="facebook" wire:model="facebook">
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>Instagram:</b></label>
                                <input type="text" class="form-control" placeholder="Instagram"
                                    id="instagram" wire:model="instagram">
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>Linkedin:</b></label>
                                <input type="text" class="form-control" placeholder="Linkedin"
                                    id="linkedin" wire:model="linkedin">
                            </div>
                            <div class="form-group md:col-span-3">
                                <label class="labelforms"><b>Informações adicionais</b></label>
                                <textarea
                                    class="form-control"
                                    rows="4"
                                    wire:model.defer="information"
                                    placeholder="Observações, informações internas, anotações..."
                                ></textarea>
                                @error('information')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-6 bg-slate-50/60">
                    <div class="card-header">
                        <h4 class="card-title text-slate-700"><strong>Permissões & Acesso</strong></h4>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 gap-x-6 md:grid-cols-3">
                            <div class="form-group">
                                <label class="labelforms"><b>*Cargo</b></label>
                                <select class="form-control @error('role') is-invalid @enderror" wire:model="role">
                                    @foreach ($roles as $roleOption)
                                        <option value="{{ $roleOption->name }}">{{ ucfirst($roleOption->name) }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <span class="error erro-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group md:col-span-2">
                                <label class="labelforms"><b>Ministérios</b></label>
                                <div class="grid max-h-[180px] grid-cols-1 gap-x-4 overflow-y-auto rounded-xl border border-slate-200 bg-white p-3 sm:grid-cols-2">
                                    @foreach ($ministryOptions as $ministry)
                                        <label class="flex items-center gap-2 rounded-lg px-2 py-1.5 hover:bg-forest-50" wire:key="ministry-{{ $ministry->id }}">
                                            <input class="rounded border-slate-300 text-forest-600 focus:ring-gold-400" type="checkbox"
                                                id="ministry-{{ $ministry->id }}" value="{{ $ministry->id }}" wire:model="ministries">
                                            <span class="text-sm text-slate-700">{{ $ministry->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>Família</b></label>
                                <select class="form-control" wire:model="family_id">
                                    <option value="">Sem família</option>
                                    @foreach ($familyOptions as $familyOption)
                                        <option value="{{ $familyOption->id }}">{{ $familyOption->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>Papel na família</b></label>
                                <select class="form-control" wire:model="family_role">
                                    <option value="">Selecione</option>
                                    <option value="chefe">Chefe da família</option>
                                    <option value="conjuge">Cônjuge</option>
                                    <option value="filho">Filho(a)</option>
                                    <option value="outro">Outro</option>
                                </select>
                            </div>
                        </div>

                        @if (!$user?->exists)
                            <div class="mt-4 grid grid-cols-1 gap-x-6 md:grid-cols-2">
                                <div class="form-group">
                                    <label class="labelforms"><b>Senha:</b></label>
                                    <div class="relative">
                                        <input type="password" id="password" class="form-control pr-11 @error('password') is-invalid @enderror" wire:model.defer="password">
                                        <button type="button" onclick="togglePassword('password')" class="absolute right-1 top-1/2 -translate-y-1/2 rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label class="labelforms"><b>Confirmar Senha:</b></label>
                                    <div class="relative">
                                        <input type="password" id="password_confirmation" class="form-control pr-11 @error('password_confirmation') is-invalid @enderror" wire:model.defer="password_confirmation">
                                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-1 top-1/2 -translate-y-1/2 rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password_confirmation') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-6 flex justify-end pb-2">
                    <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-check mr-2"></i>{{ $user?->exists ? 'Atualizar Agora' : 'Cadastrar Agora' }}</button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
    <script>
        function initFlatpickr() {
            let inputs = document.querySelectorAll('[id^="datepicker"]');
            if (!inputs.length) return;

            inputs.forEach(input => {
                if (input._flatpickr) return;

                flatpickr(input, {
                    dateFormat: "d/m/Y",
                    allowInput: true,
                    maxDate: "today",
                    defaultDate: input.value || null,
                    onChange: function(selectedDates, dateStr) {
                        input.dispatchEvent(new Event('input'));
                    },
                    locale: {
                        firstDayOfWeek: 1,
                        weekdays: {
                            shorthand: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
                            longhand: ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'],
                        },
                        months: {
                            shorthand: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                            longhand: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                        },
                        today: "Hoje",
                        clear: "Limpar",
                        weekAbbreviation: "Sem",
                        scrollTitle: "Role para aumentar",
                        toggleTitle: "Clique para alternar",
                    }
                });
            });
        }

        document.addEventListener("livewire:init", () => {
            initFlatpickr();
        });

        document.addEventListener("livewire:updated", () => {
            initFlatpickr();
        });

        function togglePassword(id) {
            let input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
@endpush
