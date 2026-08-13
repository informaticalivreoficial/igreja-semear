<?php

namespace Database\Seeders;

use App\Models\CatPost;
use App\Models\Post;
use App\Models\PostGb;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostsTableSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $autor = User::where('email', env('ADMIN_EMAIL', 'admin@semear.com.br'))->first()
            ?? User::factory()->create();

        $posts = [
            [
                'type' => 'artigo',
                'title' => 'O Poder da Oração',
                'category_slug' => 'devocional',
                'tags' => 'oração,vida cristã,devocional',
                'content' => 'A oração é o canal de comunicação entre o homem e Deus. Em Filipenses 4.6 somos orientados a apresentar a Deus os nossos pedidos com oração e súplicas, e a paz de Deus, que excede todo entendimento, guardará os nossos corações e as nossas mentes em Cristo Jesus.',
                'thumb_caption' => 'Mãos em oração',
            ],
            [
                'type' => 'artigo',
                'title' => 'Vivendo em Comunhão',
                'category_slug' => 'ensino',
                'tags' => 'comunhão,igreja,amor ao próximo',
                'content' => 'A Bíblia nos chama a viver em comunhão uns com os outros. Em Atos 2.42-47 vemos a igreja primitiva perseverando na doutrina dos apóstolos, na comunhão, no partir do pão e nas orações.',
                'thumb_caption' => 'Comunhão da igreja',
            ],
            [
                'type' => 'noticia',
                'title' => 'Culto de Celebração',
                'category_slug' => 'eventos',
                'tags' => 'culto,celebração,domingo',
                'content' => 'Neste domingo teremos nosso tradicional culto de celebração com louvores, palavra e comunhão. Venha participar conosco e traga sua família.',
                'thumb_caption' => 'Culto de celebração',
            ],
            [
                'type' => 'noticia',
                'title' => 'Campanha de Inverno',
                'category_slug' => 'noticias',
                'tags' => 'campanha,solidariedade,doação',
                'content' => 'Estamos arrecadando agasalhos e cobertores para famílias em situação de vulnerabilidade. Traga sua doação até o final do mês e faça a diferença.',
                'thumb_caption' => 'Campanha de inverno',
            ],
        ];

        foreach ($posts as $data) {
            $categoria = CatPost::where('slug', $data['category_slug'])->first();

            if (empty($categoria)) {
                continue;
            }

            $post = Post::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'autor' => $autor->id,
                    'type' => $data['type'],
                    'title' => $data['title'],
                    'content' => $data['content'],
                    'tags' => $data['tags'],
                    'views' => 0,
                    'category' => $categoria->id,
                    'cat_pai' => $categoria->id_pai,
                    'comments' => 0,
                    'status' => 1,
                    'highlight' => 1,
                    'thumb_caption' => $data['thumb_caption'],
                    'publish_at' => now()->format('d/m/Y'),
                ]
            );

            PostGb::factory()->count(2)->forPost($post)->create();
        }

        Post::factory()->published()->count(8)->create()->each(function (Post $post) {
            PostGb::factory()->count(2)->forPost($post)->create();
        });
    }
}
