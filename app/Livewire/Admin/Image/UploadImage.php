<?php

namespace App\Livewire\Admin\Image;

use App\Helpers\ImageUpload;
use App\Http\Requests\ImageRequest;
use App\Repository\Constracts\ImageRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadImage extends Component
{
    use WithFileUploads;

    protected ImageRepositoryInterface $imageRepository;

    public $images;
    public $type = 'products';
    public $url = [];

    public function rules(){
        return (new ImageRequest()->rules());
    }
    public function messages(){
        return (new ImageRequest()->rules());
    }

    public function boot(ImageRepositoryInterface $repository){
        $this->imageRepository = $repository;
    }

    public function updatedType($value){
        $this->type = $value;
    }

    public function updatedImages(){
    }

    public function uploadImages(){
        $this->validate();

        $data = $this->only('images', 'type');
        foreach($this->images as $image){
            $urlImage = ImageUpload::upload($image, $this->type, 'public');
            $this->url[] = ImageUpload::url($this->type.$urlImage);

            $this->imageRepository->create([
                'name' => Str::slug($this->type.$image->getClientOriginalName()),
                'url' => $urlImage,
                'created_by' => Auth::id(),
            ]);
        }

        $this->url = [];
        $this->dispatch('imageUploaded');

        session()->flash('message', 'Upload image success');
    }

    public function removeImage($index){
        array_splice($this->images, $index, 1);
    }



    public function render()
    {
        return view('admin.components.upload-image');
    }
}
