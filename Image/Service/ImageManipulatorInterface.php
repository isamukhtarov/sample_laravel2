<?php

declare(strict_types=1);

namespace Modules\Image\Service;

interface ImageManipulatorInterface
{
    public function upload(string $file, string $diskName): string;

    public function delete(string $filename, string $diskName): void;
}
