<?php

namespace Database\Seeders;

use App\Models\CatPost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatPostsTableSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ensino = CatPost::updateOrCreate(
            ['slug' => 'ensino'],
            [
                'title' => 'Ensino',
                'type' => 'artigo',
                'content' => 'Estudos e ensinamentos bíblicos.',
                'tags' => 'ensino,estudo bíblico,escola bíblica',
                'views' => 0,
                'status' => 1,
                'id_pai' => null,
            ]
        );

        $noticias = CatPost::updateOrCreate(
            ['slug' => 'noticias'],
            [
                'title' => 'Notícias',
                'type' => 'noticia',
                'content' => 'Notícias e avisos da igreja.',
                'tags' => 'notícias,avisos,igreja',
                'views' => 0,
                'status' => 1,
                'id_pai' => null,
            ]
        );

        CatPost::updateOrCreate(
            ['slug' => 'devocional'],
            [
                'title' => 'Devocional',
                'type' => 'artigo',
                'content' => 'Devocionais diários.',
                'tags' => 'devocional,meditação',
                'views' => 0,
                'status' => 1,
                'id_pai' => $ensino->id,
            ]
        );

        CatPost::updateOrCreate(
            ['slug' => 'eventos'],
            [
                'title' => 'Eventos',
                'type' => 'noticia',
                'content' => 'Cobertura dos eventos da igreja.',
                'tags' => 'eventos,cultos,campanhas',
                'views' => 0,
                'status' => 1,
                'id_pai' => $noticias->id,
            ]
        );

        CatPost::factory()->count(3)->create();

        $parentes = CatPost::whereNull('id_pai')->pluck('id')->toArray();

        CatPost::factory()
            ->count(4)
            ->sequence(fn () => [
                'id_pai' => fake()->randomElement($parentes),
            ])
            ->create();
    }
}
