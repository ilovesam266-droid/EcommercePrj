<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

class ImageUpload
{

    public static array $allowMimes = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
        'image/jpg',
        'image/svg+xml',
    ];

    public static function upload(UploadedFile|array|null $files, string $destination, string $disk){
        if (is_null($files)){
            return null;
        }

        if (is_array($files)){
            $paths = [];

            foreach ($files as $file){
                if ($file instanceof UploadedFile && self::isImage($file)){
                    $path[] = self::storeFile($file, $destination, $disk);
                }
            }
            return $paths;
        }

        if ($files instanceof UploadedFile){
            if (!self::isImage($files)){
                throw new InvalidArgumentException('File uploaded is not valid');
            }

            return self::storeFile($files, $destination, $disk);
        }

        return null;
    }

    public static function isImage(UploadedFile $file):bool{
        return in_array($file->getMimeType(), self::$allowMimes);
    }

    public static function storeFile(UploadedFile $file, string $destination, string $disk){
        $name = $file->hashName();
        // $ext = $file->extension();

        $filename = "{$name}";

        Storage::disk($disk)->makeDirectory($destination);

        return $file->storeAs($destination, $filename, $disk);
    }

    public static function url(?string $path, string $disk = 'public'){
        if (!$path){
            return null;
        }

        return $disk == 'public' ? asset('storage/'.ltrim($path, '/')) : Storage::disk($disk)->url($path);
    }

    public static function exists(?string $path, string $disk = 'public'): bool
    {
        return $path && Storage::disk($disk)->exists($path);
    }

    public static function delete(string|array|null $paths, string $disk = 'public'): void
    {
        if (empty($paths)) {
            return;
        }

        foreach (Arr::wrap($paths) as $path) {
            if (self::exists($path, $disk)) {
                Storage::disk($disk)->delete($path);
            }
        }
    }
}
