<?php

declare(strict_types=1);

namespace Modules\Image\Service;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\CannotWriteFileException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Illuminate\Support\Str;

class ImageManipulator implements ImageManipulatorInterface
{
    public function upload(string $file, string $diskName): string
    {
        $file_arr = explode(';', $file, 2);
        $extension = explode('/', $file_arr[0])[1];
        $image = str_replace('base64,', '', $file_arr[1]);
        $image = str_replace(' ', '+', $image);

        $avatarName = Str::random(10) . '-' . time() . '.' . $extension;

        try {
            Storage::disk($diskName)->put($avatarName, base64_decode($image));
        }catch (FileException $exception) {
            throw new CannotWriteFileException();
        }

        return $avatarName;
    }

    public function delete(string $filename, string $diskName): void
    {
        Storage::disk($diskName)->delete($filename);
    }
}
