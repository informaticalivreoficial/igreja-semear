<?php

namespace Tests\Feature;

use App\Livewire\Dashboard\Posts\PostForm;
use App\Models\CatPost;
use App\Models\Post;
use App\Models\PostGb;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PostSaveTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    }

    private function makeCat(): CatPost
    {
        return CatPost::create(['title' => 'Sub', 'id_pai' => CatPost::create(['title' => 'Pai', 'type' => 'artigo', 'status' => 1])->id, 'type' => 'artigo', 'status' => 1]);
    }

    public function test_save_published_post(): void
    {
        $user = User::factory()->create();
        $cat = $this->makeCat();

        $this->actingAs($user);

        Livewire::test(PostForm::class)
            ->set('autor', $user->id)
            ->set('type', 'artigo')
            ->set('category', $cat->id)
            ->set('title', 'Post de teste')
            ->set('content', 'Conteúdo do post')
            ->call('save', 'published')
            ->assertHasNoErrors();
    }

    public function test_update_post(): void
    {
        $user = User::factory()->create();
        $cat = $this->makeCat();
        $post = Post::create(['autor' => $user->id, 'type' => 'artigo', 'category' => $cat->id, 'cat_pai' => $cat->id_pai, 'title' => 'Post original', 'slug' => 'post-original', 'content' => 'X', 'status' => 1]);

        $this->actingAs($user);

        Livewire::test(PostForm::class, ['post' => $post])
            ->set('title', 'Post editado')
            ->call('save', 'published')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('posts', ['id' => $post->id, 'title' => 'Post editado']);
    }

    public function test_update_post_browser_mimic_dispatches_swal(): void
    {
        $user = User::factory()->create();
        $cat = $this->makeCat();
        $post = Post::create(['autor' => $user->id, 'type' => 'noticia', 'category' => $cat->id, 'cat_pai' => $cat->id_pai, 'title' => 'Culto de Celebração', 'slug' => 'culto', 'content' => 'Neste domingo...', 'status' => 1, 'publish_at' => '14/08/2026']);

        $this->actingAs($user);

        Livewire::test(PostForm::class, ['post' => $post])
            ->set('type', 'noticia')
            ->set('category', $cat->id)
            ->set('title', 'Culto de Celebração')
            ->set('content', 'Neste domingo teremos nosso tradicional culto de celebração com louvores, palavra e comunhão. Venha participar conosco e traga sua família. Não se esqueça de convidar os amigos!')
            ->set('status', true)
            ->call('save', 'published')
            ->assertHasNoErrors()
            ->assertDispatched('swal');

        $this->assertDatabaseHas('posts', ['id' => $post->id, 'title' => 'Culto de Celebração']);
    }

    public function test_reorder_images(): void
    {
        $user = User::factory()->create();
        $cat = $this->makeCat();
        $post = Post::create(['autor' => $user->id, 'type' => 'artigo', 'category' => $cat->id, 'cat_pai' => $cat->id_pai, 'title' => 'P', 'slug' => 'p', 'content' => 'X', 'status' => 1]);
        $a = PostGb::create(['post' => $post->id, 'path' => 'a.jpg', 'order_img' => 0]);
        $b = PostGb::create(['post' => $post->id, 'path' => 'b.jpg', 'order_img' => 1]);
        $c = PostGb::create(['post' => $post->id, 'path' => 'c.jpg', 'order_img' => 2]);

        $this->actingAs($user);

        Livewire::test(PostForm::class, ['post' => $post])
            ->call('reorderImages', [$c->id, $a->id, $b->id]);

        $this->assertSame(0, PostGb::find($c->id)->order_img);
        $this->assertSame(1, PostGb::find($a->id)->order_img);
        $this->assertSame(2, PostGb::find($b->id)->order_img);
    }
}
