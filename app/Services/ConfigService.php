<?php

namespace App\Services;

use App\Repositories\ConfigRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Support\Cropper;

class ConfigService
{
    protected $configRepository;
    protected $idConfig = 1;

    public function __construct(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    public function getConfig()
    {
        $config = $this->configRepository->getConfigById($this->idConfig);
        return $config;
    }

    public function getMetaImg()
    {
        $config = $this->configRepository->getConfigById($this->idConfig);
        if(empty($config->metaimg) || !Storage::disk()->exists($config->metaimg)) {
            return url(asset('backend/assets/images/image.jpg'));
        } 
        return Storage::url($config->metaimg);
    }
}