<?php

namespace Tests\Feature;

use App\Livewire\Dashboard\Ministries\MinistryForm;
use App\Livewire\Dashboard\Posts\PostForm;
use App\Livewire\Dashboard\Users\Form as UserForm;
use App\Models\CatPost;
use App\Models\Ministry;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ImageUploadWebpTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        Role::firstOrCreate(['name' => 'member', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    }

    private function makeCat(): CatPost
    {
        return CatPost::create(['title' => 'Sub', 'id_pai' => CatPost::create(['title' => 'Pai', 'type' => 'artigo', 'status' => 1])->id, 'type' => 'artigo', 'status' => 1]);
    }

    public function test_post_image_upload_is_converted_to_webp(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $cat = $this->makeCat();
        $file = UploadedFile::fake()->image('foto.jpg', 1200, 800);

        Livewire::test(PostForm::class)
            ->set('autor', $user->id)
            ->set('type', 'artigo')
            ->set('category', $cat->id)
            ->set('title', 'Post com imagem')
            ->set('content', 'Conteúdo')
            ->set('images', [$file])
            ->call('save', 'published')
            ->assertHasNoErrors();

        $post = Post::where('slug', 'post-com-imagem')->firstOrFail();
        $image = $post->images()->firstOrFail();

        $this->assertStringEndsWith('.webp', $image->path);
        $this->assertTrue(Storage::disk('public')->exists($image->path));
        $this->assertSame('image/webp', Storage::disk('public')->mimeType($image->path));
    }

    public function test_post_rejects_non_image_file(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $cat = $this->makeCat();
        $file = UploadedFile::fake()->createWithContent('vetor.svg', '<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"></svg>');

        Livewire::test(PostForm::class)
            ->set('autor', $user->id)
            ->set('type', 'artigo')
            ->set('category', $cat->id)
            ->set('title', 'Post inválido')
            ->set('content', 'Conteúdo')
            ->set('images', [$file])
            ->call('save', 'published')
            ->assertHasErrors(['images.0']);

        $this->assertDatabaseMissing('posts', ['slug' => 'post-invalido']);
    }

    public function test_ministry_cover_upload_is_converted_to_webp(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $file = UploadedFile::fake()->image('capa.png', 1200, 600);

        Livewire::test(MinistryForm::class)
            ->set('name', 'Ministério de Louvor')
            ->set('slug', 'ministerio-louvor')
            ->set('cover', $file)
            ->call('save')
            ->assertHasNoErrors();

        $ministry = Ministry::where('slug', 'ministerio-louvor')->firstOrFail();

        $this->assertStringEndsWith('.webp', $ministry->cover);
        $this->assertTrue(Storage::disk('public')->exists($ministry->cover));
        $this->assertSame('image/webp', Storage::disk('public')->mimeType($ministry->cover));
    }

    public function test_ministry_rejects_small_cover(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $file = UploadedFile::fake()->image('capa-pequena.png', 200, 200);

        Livewire::test(MinistryForm::class)
            ->set('name', 'Ministério Pequeno')
            ->set('slug', 'ministerio-pequeno')
            ->set('cover', $file)
            ->call('save')
            ->assertHasErrors(['cover' => 'dimensions']);

        $this->assertDatabaseMissing('ministries', ['slug' => 'ministerio-pequeno']);
    }

    public function test_user_foto_upload_is_converted_to_webp(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $file = UploadedFile::fake()->image('avatar.jpg', 400, 400);

        Livewire::test(UserForm::class)
            ->set('name', 'Novo Membro')
            ->set('email', 'novo@example.com')
            ->set('role', 'member')
            ->set('password', 'secret123')
            ->set('password_confirmation', 'secret123')
            ->set('foto', $file)
            ->call('save')
            ->assertHasNoErrors();

        $created = User::where('email', 'novo@example.com')->firstOrFail();

        $this->assertStringEndsWith('.webp', $created->avatar);
        $this->assertTrue(Storage::disk('public')->exists($created->avatar));
        $this->assertSame('image/webp', Storage::disk('public')->mimeType($created->avatar));
    }

    public function test_user_rejects_non_image_file(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $file = UploadedFile::fake()->create('documento.txt', 100);

        Livewire::test(UserForm::class)
            ->set('name', 'Membro Inválido')
            ->set('email', 'invalido@example.com')
            ->set('role', 'member')
            ->set('foto', $file)
            ->call('save')
            ->assertHasErrors(['foto']);

        $this->assertDatabaseMissing('users', ['email' => 'invalido@example.com']);
    }
}