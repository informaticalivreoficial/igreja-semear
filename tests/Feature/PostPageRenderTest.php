<?php

namespace Tests\Feature;

use App\Models\CatPost;
use App\Models\Post;
use App\Models\PostGb;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PostPageRenderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        foreach (['super admin', 'admin', 'editor', 'lider', 'pastor', 'member'] as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }
    }

    public function test_edit_page_renders(): void
    {
        $user = User::factory()->create();
        $pai = CatPost::create(['title' => 'Pai', 'type' => 'artigo', 'status' => 1]);
        $cat = CatPost::create(['title' => 'Sub', 'id_pai' => $pai->id, 'type' => 'artigo', 'status' => 1]);
        $post = Post::create(['autor' => $user->id, 'type' => 'artigo', 'category' => $cat->id, 'cat_pai' => $cat->id_pai, 'title' => 'Post original', 'slug' => 'post-original', 'content' => 'X', 'status' => 1]);
        PostGb::create(['post' => $post->id, 'path' => 'posts/1/a.jpg', 'order_img' => 0, 'cover' => 0]);

        $user->assignRole('editor');
        $this->actingAs($user);

        $this->withoutExceptionHandling();
        $response = $this->get('/admin/posts/'.$post->id.'/editar');
        $response->assertStatus(200);
        $response->assertSee('saved-tile');
        $response->assertSee('reorderImages');
    }
}
