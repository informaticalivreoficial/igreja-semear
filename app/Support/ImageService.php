<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImageService
{
    public static function makeThumb(string $path, int $width, ?int $height = null)
    {
        $disk = Storage::disk();

        // Se o arquivo não existe no R2
        if (! $disk->exists($path)) {
            return asset('theme/images/image.jpg');
        }

        // Lê arquivo binário do R2
        $original = $disk->get($path);

        // Inicializa o Intervention v3
        $manager = new ImageManager(new Driver);

        // Carrega imagem (binário)
        $image = $manager->read($original);

        // Redimensiona
        if ($height) {
            $image = $image->scale($width, $height);
        } else {
            // Mantém proporção
            $image = $image->scale($width);
        }

        // Nome único baseado no path + dimensões
        $fileName = 'thumbs/'.md5($path.$width.$height).'.jpg';

        // Gera o binário JPEG
        $binary = $image->toJpeg(85);

        // Salva thumb no R2
        $disk->put($fileName, $binary);

        // Retorna a URL pública (funciona se bucket for público ou tiver domain)
        return $disk->url($fileName);
    }

    public static function storeWebp(TemporaryUploadedFile $file, string $folder, int $maxWidth = 1600, int $quality = 82): string
    {
        $manager = new ImageManager(new Driver);
        $image = $manager->read($file->getRealPath())
            ->scale(width: $maxWidth);

        $filename = $folder.'/'.Str::uuid().'.webp';

        Storage::disk('public')->put($filename, (string) $image->toWebp($quality));

        return $filename;
    }
}
