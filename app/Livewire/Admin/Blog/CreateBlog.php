<?php

namespace App\Livewire\Admin\Blog;

use App\Http\Requests\BlogRequest;
use App\Repository\Constracts\BlogRepositoryInterface;
use App\Repository\Constracts\CategoryRepositoryInterface;
use App\Repository\Constracts\ImageRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

class CreateBlog extends Component
{
    protected BlogRepositoryInterface $blogRepository;
    protected CategoryRepositoryInterface $categoryRepository;
    protected ImageRepositoryInterface $imageRepository;
    protected BlogRequest $blogRequest;
    public $title = '';
    public $content = '';
    public $selectedCategories = [];
    public bool $openImageModal = false;
    public bool $openCategoryModal = false;

    public function __construct()
    {
        $this->blogRequest = new BlogRequest();
    }

    public function boot(BlogRepositoryInterface $blog_repository, CategoryRepositoryInterface $category_repository, ImageRepositoryInterface $image_repository)
    {
        $this->blogRepository = $blog_repository;
        $this->categoryRepository = $category_repository;
        $this->imageRepository = $image_repository;
    }

    public function rules()
    {
        return $this->blogRequest->rules();
    }
    public function messages()
    {
        return $this->blogRequest->messages();
    }

    #[On('save-mail')]
    public function updateBody($content)
    {
        $this->content = $content;
        $this->createBlog();
    }

    public function createBlog()
    {
        $this->validate();
        $blogData = $this->only([
            'title',
            'content',
        ]);
        $blogData['created_by'] = Auth::id();
        $blog = $this->blogRepository->create($blogData);

        if ($blog) {
            if (!empty($this->selectedCategories)) {
                $blog->categories()->sync($this->selectedCategories);
            }
            $this->dispatch('showToast', 'success', 'Success', 'Blog is created successfully!');
            return redirect(route('admin.blogs'));
        } else {
            $this->dispatch('showToast', 'error', 'Error', 'Blog is created failed!');
        }
    }

    public function showCategoryModal()
    {
        $this->openCategoryModal = true;
    }
    public function hideCategoryModal()
    {
        $this->openCategoryModal = false;
    }
    #[On('openImagePicker')]
    public function showImageModal()
    {
        $this->openImageModal = true;
    }
    public function hideImageModal()
    {
        $this->openImageModal = false;
    }

    #[Computed()]
    public function categories()
    {
        return $this->categoryRepository->all(
            [],
            [],
            null,
            ['id', 'name'],
            [],
            false
        );
    }

    #[Layout('layouts.page-layout')]
    #[Title('Mails')]
    public function render()
    {
        $categories = $this->categoryRepository->find($this->selectedCategories)->pluck('name')->toArray();
        return view('admin.pages.blog.create', compact('categories'));
    }
}
