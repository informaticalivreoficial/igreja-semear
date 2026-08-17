<div x-data="{ open: false }" x-cloak>
    @section('title', $title)

    <div class="content-header">
        <h1><i class="fas fa-cog"></i> Configurações</h1>
        <nav class="breadcrumb">
            <span class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></span>
            <span class="breadcrumb-item active">Configurações</span>
        </nav>
    </div>

    <div x-data="{
            tab: @entangle('currentTab'),
            init() {
                if (!this.tab) this.tab = 'dados';

                this.$watch('tab', () => {
                    this.$nextTick(() => {
                        setTimeout(() => {
                            const erroEl = [...document.querySelectorAll('[x-ref]')].find(el =>
                                el.querySelector('.erro-feedback')
                            );

                            if (erroEl) {
                                erroEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        }, 50);
                    });
                });
            }
        }" class="w-full">
        <!-- Abas -->
        <div class="mb-6 flex flex-wrap gap-1 border-b-2 border-forest-100">
            <button type="button"
                class="border-b-2 px-4 py-3 text-sm font-semibold transition-colors duration-200 focus:outline-none"
                :class="tab === 'dados' ? '-mb-0.5 border-forest-600 text-forest-700' : 'border-transparent text-slate-500 hover:text-forest-600'"
                @click="tab = 'dados'">
                <i class="fas fa-database mr-1.5"></i> Dados
            </button>
            <button type="button"
                class="border-b-2 px-4 py-3 text-sm font-semibold transition-colors duration-200 focus:outline-none"
                :class="tab === 'seo' ? '-mb-0.5 border-forest-600 text-forest-700' : 'border-transparent text-slate-500 hover:text-forest-600'"
                @click="tab = 'seo'">
                <i class="fas fa-globe mr-1.5"></i> SEO &amp; Redes Sociais
            </button>
            <button type="button"
                class="border-b-2 px-4 py-3 text-sm font-semibold transition-colors duration-200 focus:outline-none"
                :class="tab === 'contato' ? '-mb-0.5 border-forest-600 text-forest-700' : 'border-transparent text-slate-500 hover:text-forest-600'"
                @click="tab = 'contato'">
                <i class="fas fa-phone mr-1.5"></i> Contato
            </button>
            <button type="button"
                class="border-b-2 px-4 py-3 text-sm font-semibold transition-colors duration-200 focus:outline-none"
                :class="tab === 'imagens' ? '-mb-0.5 border-forest-600 text-forest-700' : 'border-transparent text-slate-500 hover:text-forest-600'"
                @click="tab = 'imagens'">
                <i class="fas fa-image mr-1.5"></i> Imagens
            </button>
            <button type="button"
                class="border-b-2 px-4 py-3 text-sm font-semibold transition-colors duration-200 focus:outline-none"
                :class="tab === 'manutencao' ? '-mb-0.5 border-forest-600 text-forest-700' : 'border-transparent text-slate-500 hover:text-forest-600'"
                @click="tab = 'manutencao'">
                <i class="fas fa-wrench mr-1.5"></i> Manutenção
            </button>
        </div>

        <div class="card">
            <div class="card-body text-slate-600">
                <form wire:submit.prevent="update" autocomplete="off">
                    <!-- Conteúdo da aba Dados -->
                    <div x-show="tab === 'dados'" x-transition>
                        <div class="grid grid-cols-1 gap-x-6 md:grid-cols-2">
                            <div class="form-group" x-ref="configData_app_name">
                                <label class="labelforms"><b>Nome do site</b></label>
                                <input type="text" class="form-control @error('configData.app_name') is-invalid @enderror" placeholder="Nome do site" wire:model="configData.app_name" id="app_name">
                                @error('configData.app_name')
                                    <span class="error erro-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>URL do site</b></label>
                                <div class="flex">
                                    <input type="text" class="form-control rounded-r-none" placeholder="URL do site" wire:model="configData.domain" @if (!\Illuminate\Support\Facades\Auth::user()->isSuperAdmin()) disabled @endif />
                                    <div class="inline-flex items-center rounded-r-lg border border-l-0 border-slate-300 bg-slate-50 px-3 text-slate-500">
                                        <a href="#" @click.prevent="open = true" title="QrCode" class="text-forest-600 hover:text-forest-800"><i class="fa fa-qrcode"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-6 bg-slate-50/60">
                            <div class="card-body">
                                <div class="grid grid-cols-1 gap-x-6 md:grid-cols-2 lg:grid-cols-6">
                                    <div class="form-group lg:col-span-1" x-ref="configData_zipcode">
                                        <label class="labelforms"><b>*CEP:</b></label>
                                        <input type="text" x-mask="99999-999" class="form-control @error('configData.zipcode') is-invalid @enderror" id="zipcode" wire:model.lazy="configData.zipcode">
                                        @error('configData.zipcode')
                                            <span class="error erro-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group lg:col-span-1">
                                        <label class="labelforms"><b>*Estado:</b></label>
                                        <input type="text" class="form-control bg-slate-100" id="state" wire:model="configData.state" readonly>
                                    </div>
                                    <div class="form-group lg:col-span-2">
                                        <label class="labelforms"><b>*Cidade:</b></label>
                                        <input type="text" class="form-control bg-slate-100" id="city" wire:model="configData.city" readonly>
                                    </div>
                                    <div class="form-group lg:col-span-2">
                                        <label class="labelforms"><b>*Rua:</b></label>
                                        <input type="text" class="form-control bg-slate-100" id="street" wire:model="configData.street" readonly>
                                    </div>
                                    <div class="form-group lg:col-span-2">
                                        <label class="labelforms"><b>*Bairro:</b></label>
                                        <input type="text" class="form-control bg-slate-100" id="neighborhood" wire:model="configData.neighborhood" readonly>
                                    </div>
                                    <div class="form-group lg:col-span-1">
                                        <label class="labelforms"><b>*Número:</b></label>
                                        <input type="text" class="form-control" placeholder="Número do Endereço" id="number" wire:model="configData.number">
                                    </div>
                                    <div class="form-group lg:col-span-2">
                                        <label class="labelforms"><b>Complemento:</b></label>
                                        <input type="text" class="form-control" id="complement" wire:model="configData.complement">
                                    </div>
                                    <div class="form-group lg:col-span-3">
                                        <label class="labelforms"><b>Endereço de exibição:</b></label>
                                        <input type="text" class="form-control @error('configData.display_address') is-invalid @enderror" placeholder="Ex.: Rua da Igreja, 100 - Centro, Ubatuba/SP" wire:model="configData.display_address" id="display_address">
                                        <small class="text-muted">Endereço formatado exibido no rodapé do site (opcional).</small>
                                        @error('configData.display_address')
                                            <span class="error erro-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-6 bg-slate-50/60">
                            <div class="card-body">
                                <div class="grid grid-cols-1 gap-x-6 md:grid-cols-2 lg:grid-cols-4">
                                    <div class="form-group">
                                        <label class="labelforms"><b>CNPJ:</b></label>
                                        <input type="text" x-mask="99.999.999/9999-99" class="form-control" placeholder="CNPJ" wire:model="configData.cnpj" id="cnpj">
                                    </div>
                                    <div class="form-group">
                                        <label class="labelforms"><b>Ano de início</b></label>
                                        <input type="text" class="form-control" placeholder="Ano de início" wire:model="configData.init_date" id="init_date">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6" wire:ignore>
                            <label class="labelforms"><b>Política de Privacidade</b></label>
                            <x-editor-quill
                                :value="$configData['privacy_policy']"
                                model="configData.privacy_policy"
                            />
                        </div>
                    </div>

                    <!-- Conteúdo da aba Seo -->
                    <div x-show="tab === 'seo'" x-cloak x-transition>
                        <h5 class="mb-3 text-lg font-semibold text-slate-600">Descrição do site:</h5>
                        <div class="form-group mb-4">
                            <textarea class="form-control" rows="5" wire:model="configData.information">{{ $configData['information'] ?? '' }}</textarea>
                        </div>

                        <h5 class="mb-3 text-lg font-semibold text-slate-600">MetaTags:</h5>
                        <div class="form-group mb-4">
                            <div
                                x-data="{
                                    tags: @entangle('tags'),
                                    input: '',
                                    addTag() {
                                        const trimmed = this.input.trim();
                                        if (trimmed && !this.tags.includes(trimmed)) {
                                            this.tags.push(trimmed);
                                        }
                                        this.input = '';
                                    },
                                    removeTag(index) {
                                        this.tags.splice(index, 1);
                                    }
                                }"
                                class="rounded-xl border border-slate-200 bg-slate-50/60 p-4"
                            >
                                <div class="mb-2 flex flex-wrap gap-2">
                                    <template x-for="(tag, index) in tags" :key="index">
                                        <span class="flex items-center bg-forest-600 px-3 py-1 text-sm text-white rounded-full">
                                            <span x-text="tag"></span>
                                            <button type="button" @click="removeTag(index)" class="ml-2 hover:text-gold-300">&times;</button>
                                        </span>
                                    </template>
                                </div>
                                <input
                                    type="text"
                                    x-model="input"
                                    @keydown.enter.prevent="addTag"
                                    placeholder="Digite uma tag e pressione Enter"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-forest-500 focus:ring-2 focus:ring-forest-100"
                                >
                            </div>
                        </div>

                        <h5 class="mb-3 text-lg font-semibold text-slate-600">Redes Sociais:</h5>
                        <div class="grid grid-cols-1 gap-x-6 md:grid-cols-2 lg:grid-cols-3">
                            <div class="form-group">
                                <label class="labelforms"><b>Facebook:</b></label>
                                <input type="text" class="form-control" placeholder="Facebook" wire:model="configData.facebook" id="facebook">
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>Twitter:</b></label>
                                <input type="text" class="form-control" placeholder="Twitter" wire:model="configData.twitter" id="twitter">
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>Youtube:</b></label>
                                <input type="text" class="form-control" placeholder="Youtube" wire:model="configData.youtube" id="youtube">
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>Instagram:</b></label>
                                <input type="text" class="form-control" placeholder="Instagram" wire:model="configData.instagram" id="instagram">
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>Linkedin:</b></label>
                                <input type="text" class="form-control" placeholder="Linkedin" wire:model="configData.linkedin" id="linkedin">
                            </div>
                        </div>

                        <hr class="my-6 border-slate-200">
                        <h5 class="mb-3 text-lg font-semibold text-slate-600">Google Maps:</h5>
                        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                            <div class="form-group">
                                <label class="labelforms"><b>Mapa do Google</b> <small class="text-sky-600">(Copie o código de incorporação do Google Maps e cole abaixo)</small></label>
                                <textarea id="inputDescription" class="form-control" rows="14" wire:model="configData.maps_google">{{ $configData['maps_google'] ?? '' }}</textarea>
                            </div>
                            <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                                {!! $configData['maps_google'] ?? '' !!}
                            </div>
                        </div>

                        <hr class="my-6 border-slate-200">
                        <div class="mt-6" wire:ignore>
                            <label class="labelforms"><b>Termos e Condições</b></label>
                            <x-editor-quill
                                :value="$configData['terms_conditions']"
                                model="configData.terms_conditions"
                            />
                        </div>

                        <hr class="my-6 border-slate-200">
                        <h5 class="mb-3 text-lg font-semibold text-slate-600">Cookies</h5>
                        <div class="form-group">
                            <label class="labelforms"><b>Mensagem de cookies</b></label>
                            <textarea class="form-control @error('configData.cookies_preference') is-invalid @enderror" rows="3" wire:model="configData.cookies_preference" placeholder="Texto exibido no aviso de cookies do site">{{ $configData['cookies_preference'] ?? '' }}</textarea>
                            @error('configData.cookies_preference')
                                <span class="error erro-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Conteúdo da aba contato -->
                    <div x-show="tab === 'contato'" x-cloak x-transition>
                        <div class="grid grid-cols-1 gap-x-6 rounded-xl border border-slate-200 bg-slate-50/60 p-5 md:grid-cols-2 lg:grid-cols-3">
                            <div class="form-group">
                                <label class="labelforms"><b>Telefone fixo:</b></label>
                                <input type="text" class="form-control" placeholder="(00) 0000-0000"
                                    x-mask="(99) 9999-9999" wire:model="configData.phone" id="phone">
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>*Celular:</b></label>
                                <input type="text" class="form-control" placeholder="(00) 00000-0000"
                                    x-mask="(99) 99999-9999" wire:model="configData.cell_phone"
                                    id="cell_phone">
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>WhatsApp:</b></label>
                                <input type="text" class="form-control" placeholder="(00) 00000-0000"
                                    x-mask="(99) 99999-9999" wire:model="configData.whatsapp"
                                    id="whatsapp">
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>Telegram:</b></label>
                                <input type="text" class="form-control @error('configData.telegram') is-invalid @enderror" placeholder="https://t.me/usuario"
                                    wire:model="configData.telegram" id="telegram">
                                @error('configData.telegram')
                                    <span class="error erro-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>Email:</b></label>
                                <input type="text" class="form-control" placeholder="Email"
                                    wire:model="configData.email" id="email">
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>Email Adicional:</b></label>
                                <input type="text" class="form-control" placeholder="Email Alternativo"
                                    wire:model="configData.additional_email" id="additional_email">
                            </div>
                        </div>
                    </div>

                    <!-- Conteúdo da aba Imagens -->
                    <div x-show="tab === 'imagens'" x-cloak x-transition>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                            <x-dashboard.logo-upload
                                label="Logo do site"
                                :width="env('LOGOMARCA_WIDTH')"
                                :height="env('LOGOMARCA_HEIGHT')"
                                :preview="$logo"
                                wire:model.live="logo"
                                target="logo"
                            />
                            <x-dashboard.logo-upload
                                label="Logo do Gerenciador"
                                :width="env('LOGOMARCA_GERENCIADOR_WIDTH')"
                                :height="env('LOGOMARCA_GERENCIADOR_HEIGHT')"
                                :preview="$logo_admin"
                                wire:model.defer="logo_admin"
                                target="logo_admin"
                            />
                            <x-dashboard.logo-upload
                                label="Logo do rodapé"
                                :width="env('LOGOMARCA_FOOTER_WIDTH')"
                                :height="env('LOGOMARCA_FOOTER_HEIGHT')"
                                :preview="$logo_footer"
                                wire:model.defer="logo_footer"
                                target="logo_footer"
                            />
                            <x-dashboard.logo-upload
                                label="Favicon"
                                :width="env('FAVEICON_WIDTH')"
                                :height="env('FAVEICON_HEIGHT')"
                                :preview="$favicon"
                                wire:model.defer="favicon"
                                target="favicon"
                            />
                            <x-dashboard.logo-upload
                                label="Marca D´água"
                                :width="env('MARCADAGUA_WIDTH')"
                                :height="env('MARCADAGUA_HEIGHT')"
                                :preview="$watermark"
                                wire:model.defer="watermark"
                                target="watermark"
                            />
                        </div>
                        <div class="mt-4 grid grid-cols-1 gap-4 lg:grid-cols-2">
                            <x-dashboard.logo-upload
                                label="Meta Imagem"
                                :width="env('METAIMG_WIDTH')"
                                :height="env('METAIMG_HEIGHT')"
                                :preview="$metaimg"
                                wire:model.defer="metaimg"
                                target="metaimg"
                            />
                            <x-dashboard.logo-upload
                                label="Topo do site"
                                :width="env('IMGHEADER_WIDTH')"
                                :height="env('IMGHEADER_HEIGHT')"
                                :preview="$imgheader"
                                wire:model.defer="imgheader"
                                target="imgheader"
                            />
                        </div>
                    </div>

                    <!-- Conteúdo da aba Manutenção -->
                    <div x-show="tab === 'manutencao'" x-cloak x-transition>
                        <div class="mb-4 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                            <p><b>Importante:</b> com o modo de manutenção ativo, o site público e a área do membro ficam indisponíveis para os visitantes. Ao acessar o site, eles verão uma página personalizada com o logo, a mensagem abaixo, os contatos da igreja e o último culto transmitido no YouTube. Apenas o painel administrativo continua funcionando.</p>
                        </div>

                        <div class="grid grid-cols-1 gap-x-6 md:grid-cols-2">
                            <div class="form-group">
                                <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50/60 p-4">
                                    <input type="checkbox" id="maintenance_mode" class="h-5 w-5 rounded border-slate-300 text-forest-600 focus:ring-gold-400" wire:model="configData.maintenance_mode">
                                    <label for="maintenance_mode" class="labelforms mb-0"><b>Ativar modo manutenção</b></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="labelforms"><b>Retorno automático (opcional)</b></label>
                                <input type="datetime-local" class="form-control @error('configData.maintenance_until') is-invalid @enderror" id="maintenance_until" wire:model="configData.maintenance_until">
                                <small class="text-muted">Se preenchido, o site volta automaticamente a partir desta data/hora.</small>
                                @error('configData.maintenance_until')
                                    <span class="error erro-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label class="labelforms"><b>Mensagem personalizada</b></label>
                            <textarea class="form-control @error('configData.maintenance_message') is-invalid @enderror" rows="4" wire:model="configData.maintenance_message" placeholder="Ex.: Estamos realizando melhorias no nosso site. Voltamos em breve!">{{ $configData['maintenance_message'] ?? '' }}</textarea>
                            <small class="text-muted">Texto exibido na página de manutenção. Se vazio, é usada uma mensagem padrão.</small>
                            @error('configData.maintenance_message')
                                <span class="error erro-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="button" wire:click="update" class="btn btn-success btn-lg">
                            <i class="fas fa-check mr-2"></i> Atualizar Configurações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div x-show="open" x-cloak
        @keydown.escape.window="open = false"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">

        <div @click.outside="open = false"
            class="relative w-full max-w-md rounded-xl bg-white p-6 shadow-lg transition-all duration-300"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90">

            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-800">QrCode do site</h2>
                <button @click="open = false" class="text-slate-500 hover:text-slate-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="text-center">
                <p class="mb-2 text-slate-600">Este QrCode direciona para:</p>
                <p class="mb-4 text-sm font-semibold text-forest-700">
                    {{ $this->configData['domain'] ?? env('DESENVOLVEDOR_URL') }}
                </p>
                <div class="flex justify-center">
                    <img src="data:image/svg+xml;utf8,{{ rawurlencode($this->qrCodeSvg) }}">
                </div>
            </div>

            <div class="mt-6 text-right">
                <button @click="open = false" class="rounded-lg bg-slate-300 px-4 py-2 text-slate-800 hover:bg-slate-400">
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('atualizado', function() {
        Swal.fire({
            title: 'Sucesso!',
            text: "Configurações atualizadas com sucesso!",
            icon: 'success',
            timerProgressBar: true,
            showConfirmButton: false,
            timer: 3000
        });
    });
</script>
