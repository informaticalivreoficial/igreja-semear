<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Seeder;

class AnnouncementsTableSeeder extends Seeder
{
    public function run(): void
    {
        if (Announcement::exists()) {
            return;
        }

        $admin = User::role('admin')->first() ?? User::first();

        $announcements = [
            [
                'title' => 'Culto de celebração neste domingo',
                'content' => '<p>Não se esqueça do nosso culto de celebração neste domingo às <strong>10h</strong>. Vamos juntos adorar ao Senhor!</p>',
            ],
            [
                'title' => 'Retiro espiritual anual',
                'content' => '<p>Estão abertas as inscrições para o retiro espiritual anual. Vagas limitadas! Fale com a secretaria da igreja para garantir a sua vaga.</p>',
            ],
            [
                'title' => 'Campanha de solidariedade',
                'content' => '<p>Estamos arrecadando alimentos e roupas para as famílias da comunidade. Sua doação é muito bem-vinda!</p>',
            ],
        ];

        foreach ($announcements as $data) {
            Announcement::create([
                'title' => $data['title'],
                'content' => $data['content'],
                'status' => true,
                'publish_at' => now()->format('Y-m-d'),
                'created_by' => $admin?->id,
            ]);
        }
    }
}
