<?php

namespace App\Enums;

enum PostType: string
{
    case Artigo = 'artigo';
    case Noticia = 'noticia';
    case Pagina = 'pagina';

    public function label(): string
    {
        return match ($this) {
            self::Artigo => 'Artigo',
            self::Noticia => 'Notícia',
            self::Pagina => 'Página',
        };
    }

    public static function labels(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->all();
    }
}
