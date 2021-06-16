<?php

namespace Modules\Image\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Modules\Ad\Entities\Ad\Ad;
use Modules\Image\Entities\Image;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\WithJWTAuth;

class ImageTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase, WithJWTAuth;

    /** @test */
    public function can_edit_image()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $image = $this->createAndGetImage();

        $updateData = [
            'image' => 'data:image/jpeg;base64,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'
        ];

        $response = $this->json('PUT', route('edit.image', $image->getId()), $updateData);

        $content = $response->getOriginalContent()->toArray();

        $responseData = [
            'data' => [
                'id' => $content['id'],
                'type_id' => $image->getImageAbleId(),
                'type' => $content['imageable_type'],
                'order' => $content['order'],
                'url' => \Storage::disk($content['imageable_type'])->url($content['name'])
            ]
        ];

        $response->assertStatus(Response::HTTP_ACCEPTED)
                 ->assertJson($responseData);
    }

    /** @test */
    public function can_delete_image()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $image = $this->createAndGetImage();

        $response = $this->json('DELETE', route('delete.image', $image->getId()));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson($response->getOriginalContent());
    }

    /** @test  */
    public function can_order_change()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $image = $this->createAndGetImage();

        $response = $this->json('POST', route('change.order', $image->getId()), ['order' => 1]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    private function createAndGetImage(): Image
    {
        $ad = Ad::factory()->create();

        $imageData = [
            'image' => 'data:image/jpeg;base64,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'
        ];

        return $this->json('POST', route('ads.ad.image.create', $ad->id), $imageData)->getOriginalContent();
    }
}
