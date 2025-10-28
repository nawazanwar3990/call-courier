<?php
namespace App\Traits;

use App\Services\GeneralService;
use Illuminate\Support\Collection;

trait General
{
    public function makeDirectory(string $name): void
    {
        $dirPath = public_path('uploads/' . $name);
        if (!file_exists($dirPath)) {
            if (!mkdir($dirPath, 0777, true) && !is_dir($dirPath)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $dirPath));
            }
        }
    }
    public function makeMultipleDirectories(string $parent, array $children = []): void
    {
        foreach ($children as $child) {
            $dirPath = public_path('uploads/' . $parent . "/" . $child);
            if (!file_exists($dirPath)) {
                if (!mkdir($dirPath, 0777, true) && !is_dir($dirPath)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $dirPath));
                }
            }
        }
    }
    public static function generateFileName($file): string
    {
        return GeneralService::generateRandomString() . '_' . time() . '.' . $file->getClientOriginalExtension();
    }


}
