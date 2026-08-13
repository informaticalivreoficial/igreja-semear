<?php

namespace Database\Seeders;

use App\Models\CatPost;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SitePagesSeeder extends Seeder
{
    public function run(): void
    {
        $autor = User::query()->value('id') ?? 1;

        $paginas = [
            [
                'slug' => 'sobre-a-igreja',
                'title' => 'Sobre a Igreja',
                'excerpt' => 'Conheça a história, missão e valores da Comunidade Cristã Semear.',
                'content' => '<h2>Nossa História</h2><p>Somos a Comunidade Cristã Semear, uma igreja que caminha em comunhão, fé e amor ao próximo.</p><h2>Missão</h2><p>Proclamar o evangelho, fazer discípulos e servir a nossa comunidade.</p><h2>Visão</h2><p>Ser uma igreja acolhedora, onde cada pessoa encontra um lugar para crescer, servir e adorar a Deus.</p>',
            ],
            [
                'slug' => 'cultos-e-horarios',
                'title' => 'Cultos e Horários',
                'excerpt' => 'Acompanhe os horários dos nossos cultos e reuniões.',
                'content' => '<h2>Agenda Semanal</h2><p><strong>Domingo</strong> – Culto de Celebração</p><p><strong>Quarta-feira</strong> – Culto de Oração</p><p><strong>Sexta-feira</strong> – Células e Pequenos Grupos</p><h2>Venha nos visitar</h2><p>Confira os horários atualizados nas nossas redes sociais ou fale conosco pelo WhatsApp.</p>',
            ],
            [
                'slug' => 'pregacoes',
                'title' => 'Pregações',
                'excerpt' => 'Acesse as pregações e mensagens da igreja.',
                'content' => '<h2>Mensagens que edificam</h2><p>Acompanhe aqui as nossas pregações e mensagens. Os vídeos também ficam disponíveis no nosso canal no YouTube.</p><h2>Se inscreva no canal</h2><p>Não perca nenhuma mensagem: inscreva-se no canal oficial da igreja e ative as notificações.</p>',
            ],
            [
                'slug' => 'galeria-de-fotos',
                'title' => 'Galeria de Fotos',
                'excerpt' => 'Momentos especiais da nossa comunidade.',
                'content' => '<h2>Nossos momentos</h2><p>Confira as fotos dos nossos cultos, eventos e momentos de comunhão.</p>',
            ],
            [
                'slug' => 'localizacao',
                'title' => 'Localização',
                'excerpt' => 'Onde estamos e como chegar.',
                'content' => '<h2>Onde estamos</h2><p>Estamos na cidade de Ubatuba. Use o mapa abaixo para traçar a sua rota e venha nos fazer uma visita. Será um prazer recebê-lo!</p>',
            ],
            [
                'slug' => 'doacoes',
                'title' => 'Doações',
                'excerpt' => 'Ajude a manter os projetos e ministérios da igreja.',
                'content' => '<h2>Contribua com a obra</h2><p>As suas doações ajudam a manter os ministérios, projetos sociais e a manutenção da nossa casa de adoração.</p><h2>Formas de contribuir</h2><p>Você pode contribuir durante os cultos ou por transferência bancária. Consulte a chave Pix disponível na secretaria da igreja ou em nossas redes sociais.</p>',
            ],
        ];

        foreach ($paginas as $pagina) {
            Post::updateOrCreate(['slug' => $pagina['slug']], [
                'autor' => $autor,
                'type' => 'pagina',
                'title' => $pagina['title'],
                'content' => $pagina['content'],
                'excerpt' => $pagina['excerpt'],
                'category' => CatPost::query()->value('id') ?? 1,
                'status' => 1,
                'menu' => 1,
                'views' => 0,
                'publish_at' => Carbon::now()->format('d/m/Y'),
            ]);
        }
    }
}
