<?php

namespace App\Livewire\Dashboard;

use App\Models\Config;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Settings extends Component
{
    use WithFileUploads;

    public array $configData = [];

    public string $currentTab = 'dados';

    public $logo;

    public $logo_admin;

    public $logo_footer;

    public $favicon;

    public $watermark;

    public $imgheader;

    public $metaimg;

    public array $tags = [];

    public function updatedLogo($file)
    {
        $this->saveImage('logo', $file);
    }

    public function updatedLogoAdmin($file)
    {
        $this->saveImage('logo_admin', $file);
    }

    public function updatedLogoFooter($file)
    {
        $this->saveImage('logo_footer', $file);
    }

    public function updatedFavicon($file)
    {
        $this->saveImage('favicon', $file);
    }

    public function updatedWatermark($file)
    {
        $this->saveImage('watermark', $file);
    }

    public function updatedMetaimg($file)
    {
        $this->saveImage('metaimg', $file);
    }

    public function updatedImgheader($file)
    {
        $this->saveImage('imgheader', $file);
    }

    /**
     * Função genérica para salvar imagens automaticamente
     */
    protected function saveImage(string $key, $file)
    {
        if ($file instanceof TemporaryUploadedFile) {
            // Deleta a antiga
            if (! empty($this->configData[$key]) && Storage::disk('public')->exists($this->configData[$key])) {
                Storage::disk('public')->delete($this->configData[$key]);
            }

            // Salva sempre com o mesmo nome (sobrescrevendo)
            $path = $file->storeAs(
                'config',
                "{$key}.".$file->getClientOriginalExtension(),
                'public'
            );

            // Atualiza no array
            $this->configData[$key] = $path;

            // Salva no banco imediatamente
            Config::where('id', 1)->update([$key => $path]);

            // Atualiza o preview
            $this->loadLogos();
        }
    }

    public function updated($field, $value)
    {
        $uploadableFields = [
            'logo',
            'logo_admin',
            'logo_footer',
            'favicon',
            'metaimg',
            'imgheader',
            'watermark',
        ];

        if (in_array($field, $uploadableFields)) {
            $this->saveImage($field, $this->$field);
        }
    }

    protected function imageValidationRules(): array
    {
        $rules = [];

        foreach (['logo', 'logo_admin', 'logo_footer', 'favicon', 'watermark', 'metaimg', 'imgheader'] as $field) {
            $isUpload = $this->{$field} instanceof TemporaryUploadedFile;
            $rules["configData.{$field}"] = $isUpload ? 'nullable|image|max:1024' : 'nullable|string';
        }

        return $rules;
    }

    protected function rules()
    {
        return array_merge([
            'configData.app_name' => 'required|min:3',
            // 'configData.email' => 'required|email',
        ], $this->imageValidationRules());
    }

    protected function loadLogos()
    {
        $this->logo = $this->getLogo();
        $this->logo_admin = $this->getLogoadmin();
        $this->logo_footer = $this->getLogofooter();
        $this->favicon = $this->getfaveicon();
        $this->watermark = $this->getwatermark();
        $this->metaimg = $this->getmetaimg();
        $this->imgheader = $this->getheadersite();
    }

    public function mount()
    {
        $config = Config::findOrFail(1);
        $this->configData = $config->toArray();

        $this->normalizeDates();

        // Converte os campos de imagem salvos no banco para URLs
        foreach (['logo', 'logo_admin', 'logo_footer', 'favicon', 'metaimg', 'imgheader', 'watermark'] as $field) {
            if (! empty($config->$field)) {
                $this->$field = asset('storage/'.$config->$field);
            } else {
                $this->$field = asset('theme/images/image.jpg'); // fallback
            }
        }

        $this->tags = explode(',', $config->metatags ?? '');
    }

    public function render()
    {
        $title = 'Configurações';

        return view('livewire.dashboard.settings')->with('title', $title);
    }

    public function update()
    {
        try {
            $validated = $this->validate();

            // Salva os uploads e atualiza configData com os novos caminhos
            $this->handleImageUploads();

            // remove campos que não podem ser atualizados manualmente
            unset($this->configData['id'], $this->configData['created_at'], $this->configData['updated_at']);
            $this->configData['metatags'] = implode(',', $this->tags ?? []);

            $this->normalizeDates();

            // Salva somente colunas existentes na tabela config
            Config::where('id', 1)->update($this->fillableConfigData());

            // Recarrega as imagens para o preview
            $this->loadLogos();

            // $this->resetImages();

            $this->dispatch(['atualizado']);

        } catch (ValidationException $e) {
            $firstErrorKey = array_key_first($e->validator->errors()->messages());

            $this->currentTab = match (true) {
                str_starts_with($firstErrorKey, 'configData.app_name') => 'dados',
                str_starts_with($firstErrorKey, 'configData.meta_') => 'seo',
                str_starts_with($firstErrorKey, 'configData.contact_') => 'contato',
                default => 'dados',
            };

            throw $e;
        }

    }

    public function updatedConfigDataZipcode(string $value)
    {
        $cep = preg_replace('/[^0-9]/', '', $value);

        if (strlen($cep) === 8) {
            $response = Http::get("https://viacep.com.br/ws/{$cep}/json/")->json();

            if (! isset($response['erro'])) {
                $this->configData['street'] = $response['logradouro'] ?? '';
                $this->configData['neighborhood'] = $response['bairro'] ?? '';
                $this->configData['state'] = $response['uf'] ?? '';
                $this->configData['city'] = $response['localidade'] ?? '';
                // $this->configData['complement'] = $response['complemento'] ?? '';
            } else {
                $this->addError('configData.zipcode', 'CEP não encontrado.');
            }
        }
    }

    public function getQrCodeSvgProperty()
    {
        return QrCode::size(240)
            ->margin(2)
            // ->format('png')
            ->color(0, 0, 255)
            // ->merge($this->configData['favicon'] ? : asset('theme/images/chave.png'), 0.3)
            ->generate($this->configData['domain'] ?? env('DESENVOLVEDOR_URL'));
    }

    public function getLogo()
    {
        if (empty($this->configData['logo']) || ! Storage::disk('public')->exists($this->configData['logo'])) {
            return url(asset('theme/images/image.jpg'));
        }

        return Storage::url($this->configData['logo']);
    }

    public function getLogoadmin()
    {
        if (empty($this->configData['logo_admin']) || ! Storage::disk('public')->exists($this->configData['logo_admin'])) {
            return url(asset('theme/images/image.jpg'));
        }

        return Storage::url($this->configData['logo_admin']);
    }

    public function getLogofooter()
    {
        if (empty($this->configData['logo_footer']) || ! Storage::disk('public')->exists($this->configData['logo_footer'])) {
            return url(asset('theme/images/image.jpg'));
        }

        return Storage::url($this->configData['logo_footer']);
    }

    public function getfaveicon()
    {
        if (empty($this->configData['favicon']) || ! Storage::disk('public')->exists($this->configData['favicon'])) {
            return url(asset('theme/images/image.jpg'));
        }

        return Storage::url($this->configData['favicon']);
    }

    public function getwatermark()
    {
        if (empty($this->configData['watermark']) || ! Storage::disk('public')->exists($this->configData['watermark'])) {
            return url(asset('theme/images/image.jpg'));
        }

        return Storage::url($this->configData['watermark']);
    }

    public function getmetaimg()
    {
        if (empty($this->configData['metaimg']) || ! Storage::disk('public')->exists($this->configData['metaimg'])) {
            return url(asset('theme/images/image.jpg'));
        }

        return Storage::url($this->configData['metaimg']);
    }

    public function getheadersite()
    {
        if (empty($this->configData['imgheader']) || ! Storage::disk('public')->exists($this->configData['imgheader'])) {
            return url(asset('theme/images/image.jpg'));
        }

        return Storage::url($this->configData['imgheader']);
    }

    /**
     * Normaliza os campos de data (colunas DATE no MySQL) para 'Y-m-d' e o status para inteiro,
     * pois o update usa query builder (sem casts do Eloquent) e o toArray() serializa datas em ISO.
     */
    protected function normalizeDates(): void
    {
        foreach (['init_date', 'rss_data', 'sitemap_data'] as $field) {
            $value = trim((string) ($this->configData[$field] ?? ''));

            $this->configData[$field] = $value !== '' ? Carbon::parse($value)->format('Y-m-d') : null;
        }

        $this->configData['status'] = (int) filter_var($this->configData['status'] ?? false, FILTER_VALIDATE_BOOLEAN);
    }

    protected function fillableConfigData(): array
    {
        $columns = [
            'app_name', 'social_name', 'alias_name', 'slug', 'status', 'init_date', 'cnpj', 'domain',
            'subdomain', 'template', 'logo', 'logo_admin', 'logo_footer', 'favicon', 'metaimg',
            'imgheader', 'watermark', 'phone', 'cell_phone', 'whatsapp', 'email', 'additional_email',
            'zipcode', 'street', 'number', 'complement', 'neighborhood', 'state', 'city',
            'facebook', 'twitter', 'youtube', 'instagram', 'linkedin', 'information',
            'privacy_policy', 'maps_google', 'metatags', 'analytics_id', 'rss', 'rss_data',
            'sitemap', 'sitemap_data', 'live_url',
        ];

        return array_intersect_key($this->configData, array_flip($columns));
    }

    protected function resetImages()
    {
        $this->reset('logo', 'logo_admin', 'logo_footer', 'favicon', 'watermark', 'metaimg', 'imgheader');
    }

    protected function handleImageUploads()
    {
        $images = [
            'logo' => $this->logo,
            'logo_admin' => $this->logo_admin,
            'logo_footer' => $this->logo_footer,
            'favicon' => $this->favicon,
            'watermark' => $this->watermark,
            'metaimg' => $this->metaimg,
            'imgheader' => $this->imgheader,
        ];

        foreach ($images as $key => $file) {
            if ($file instanceof TemporaryUploadedFile) {
                // Apaga a imagem antiga, se existir
                if (! empty($this->configData[$key]) && Storage::disk('public')->exists($this->configData[$key])) {
                    Storage::disk('public')->delete($this->configData[$key]);
                }

                // Salva a nova
                $path = $file->storeAs(
                    'config',
                    "{$key}.".$file->getClientOriginalExtension(), // força o mesmo nome
                    'public'
                );

                $this->configData[$key] = $path;
            }
        }
    }
}
