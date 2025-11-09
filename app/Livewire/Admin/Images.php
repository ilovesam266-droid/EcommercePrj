<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Repository\Constracts\ImageRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

class Images extends Component
{
    use WithFileUploads, WithPagination;

    protected ImageRepositoryInterface $imageRepository;
    public int $perPage = 5;
    public array $sort = ['created_at' => 'asc'];
    public string $currentTab = 'all_images';
    protected $userId;

    public $selectedImageId = [];
    public bool $currentPage = false;

    public bool $showedImage = false;
    public $selectedImage = null;

    public function boot(ImageRepositoryInterface $repository)
    {
        $this->imageRepository = $repository;
        $this->userId = Auth::id();
    }

    protected $listeners = [
        'imageUploaded' => '$refresh',
    ];

    public function selectTab($currentTab)
    {
        $this->currentTab = $currentTab;
        $this->resetPage();
    }

    public function getImages()
    {
        if ($this->currentTab == 'all_images') {
            return [];
        } elseif ($this->currentTab == 'my_images') {
            return ['created_by' => Auth::id()];
        }
        return [];
    }

    public function toggleSelection($imageId){
        if (in_array($imageId, $this->selectedImageId)) {
            $this->selectedImageId = array_diff($this->selectedImageId, [$imageId]);
        } else {
            $this->selectedImageId[] = $imageId;
        }
    }

     public function confirmDelete($imageId)
    {
        $this->dispatch(
            'showConfirm',
            'Confirm image deletion',
            'Are you sure you want to delete this image <<'.$imageId.'>>?',
            'delete-image',
            ['image_id' => $imageId],
        );
    }

    #[On('delete-image')]
    public function deleteImage($data)
    {
        $imageId = $data['image_id'];
        $this->imageRepository->delete($imageId);
        $this->dispatch('showToast', 'success', 'Success', 'image Deleted');
    }

    public function showImage($imageUrl){
        $this->selectedImage = $imageUrl;
        $this->showedImage = true;
    }

    public function hideImage(){
        $this->selectedImage = '';
        $this->showedImage = false;
    }

    public function uploadImage($selectedImageId){
        $this->dispatch('imagesSelected', $selectedImageId);
    }

    #[Computed]
    public function images()
    {
        return $this->imageRepository->all(
            $this->getImages(),
            $this->sort,
            $this->perPage,
            ['*'],
            [],
            true,
        );
    }

    #[Layout('layouts.page-layout')]
    #[Title('Image')]
    public function render()
    {
        return view('admin.pages.images');
    }
}
