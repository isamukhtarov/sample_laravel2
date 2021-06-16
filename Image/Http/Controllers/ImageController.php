<?php

declare(strict_types=1);

namespace Modules\Image\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Modules\Core\CommandBus\CommandBusInterface;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Image\Commands\ChangeImageOrderCommand;
use Modules\Image\Commands\DeleteImageCommand;
use Modules\Image\Commands\UpdateImageCommand;
use Modules\Image\Entities\Image;
use Modules\Image\Http\Requests\ImageChangeOrderRequest;
use Modules\Image\Http\Requests\ImageUpdateRequest;
use Modules\Image\Transformers\ImageResource;

class ImageController extends ApiController
{
    private CommandBusInterface $bus;

    public function __construct(CommandBusInterface $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @OA\Put(
     *      tags={"Image"},
     *      path="/api/image/{id}/edit",
     *      operationId="ad-images-upload",
     *      summary="Update image",
     *      description="Update given image",
     *      @OA\Parameter(
     *          name="id",
     *          description="Image id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ImagesStoreUpdateRequest")
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *       ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found"
     *      )
     * )
     * @param ImageUpdateRequest $request
     * @param Image $image
     * @return JsonResponse
     */
    public function update(ImageUpdateRequest $request, Image $image): JsonResponse
    {
        $command = new UpdateImageCommand($image);
        $this->bus->dispatch($command, $request->validated());
        return (new ImageResource($image))->response()->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Delete(
     *      tags={"Image"},
     *      path="/api/image/{id}/delete",
     *      operationId="ad-images-delete",
     *      summary="Update image",
     *      description="Delete given image",
     *      @OA\Parameter(
     *          name="id",
     *          description="Image id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found"
     *      )
     * )
     * @param Image $image
     * @return JsonResponse
     */
    public function destroy(Image $image): JsonResponse
    {
        $command = new DeleteImageCommand($image);
        $this->bus->dispatch($command);
        return response()->json([
            'message' => "Image with id {$image->id} deleted successfully"
        ]);
    }

    /**
     * @OA\Post(
     *      tags={"Image"},
     *      path="/api/image/{id}/change-order",
     *      operationId="image-change-order",
     *      summary="image change order",
     *      description="Change order of the given image",
     *      @OA\Parameter(
     *          name="id",
     *          description="Image id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *           @OA\JsonContent(
     *              required={"order"},
     *              @OA\Property(property="order", type="integer", example=2)
     *          )
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *       ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found"
     *      )
     * )
     * @param Image $image
     * @param ImageChangeOrderRequest $request
     * @return JsonResponse
     */
    public function changeOrder(ImageChangeOrderRequest $request, Image $image): JsonResponse
    {
        $command = new ChangeImageOrderCommand($image);
        $this->bus->dispatch($command, $request->validated());
        return response()->json([
             'message' => "Image with id {$image->getId()} order changed successfully"
        ], Response::HTTP_ACCEPTED);
    }
}
