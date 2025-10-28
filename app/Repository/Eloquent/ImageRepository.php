<?php

namespace App\Repository\Eloquent;

use App\Repository\Constracts\ImageRepositoryInterface;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class ImageRepository extends BaseRepository implements ImageRepositoryInterface
{
    public function getModel(){
        return Image::class;
    }
}
