<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_content_planning_user_can_manage_products_with_thumbnail(): void
    {
        Storage::fake('public');
        $role = Role::create(['name' => 'perencanaan_konten', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->actingAs($user)->post(route('pk.products.store'), [
            'title' => 'Portal Mobile',
            'description' => 'Aplikasi pendamping portal berita.',
            'link' => 'https://example.com/portal-mobile',
            'thumbnail' => UploadedFile::fake()->image('portal-mobile.png'),
        ]);

        $response->assertSessionHasNoErrors()->assertRedirect(route('pk.products.index'));
        $product = Product::firstOrFail();
        $this->assertSame('Portal Mobile', $product->title);
        $this->assertSame('portal-mobile', $product->slug);
        Storage::disk('public')->assertExists($product->thumbnail);

        $response = $this->actingAs($user)->put(route('pk.products.update', $product), [
            'title' => 'Portal Mobile Updated',
            'description' => 'Deskripsi diperbarui.',
            'link' => 'https://example.com/portal-mobile-updated',
        ]);

        $response->assertSessionHasNoErrors()->assertRedirect(route('pk.products.index'));
        $this->assertSame('Portal Mobile Updated', $product->refresh()->title);
        $this->assertSame('portal-mobile-updated', $product->slug);

        $response = $this->actingAs($user)->delete(route('pk.products.destroy', $product));

        $response->assertSessionHasNoErrors()->assertRedirect(route('pk.products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
