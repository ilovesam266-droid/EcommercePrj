<?php

namespace App\Livewire\Admin\Blog;

use App\Http\Requests\BlogRequest;
use App\Repository\Constracts\BlogRepositoryInterface;
use App\Repository\Constracts\CategoryRepositoryInterface;
use App\Repository\Constracts\ImageRepositoryInterface;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

class EditBlog extends Component
{
    protected BlogRepositoryInterface $blogRepository;
    protected CategoryRepositoryInterface $categoryRepository;
    protected ImageRepositoryInterface $imageRepository;
    protected BlogRequest $blogRequest;
    public $editingBlogId = null;
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

    public function mount($editingBlogId)
    {
        $this->editingBlogId = (int) $editingBlogId;
        $this->loadBlog();
    }

    public function loadBlog()
    {
        $blog = $this->blogRepository->find($this->editingBlogId);
        if ($blog) {
            $this->fill($blog->only([
                'title',
                'content',
                'created_by',
            ]));
            $this->selectedCategories = $blog->categories->pluck('id')->toArray();
        }
    }

    #[On('save-mail')]
    public function updateBody($content)
    {
        $this->content = $content;
        $this->editBlog();
    }

    public function editBlog()
    {
        $this->validate();
        $blogData = $this->only([
            'title',
            'content',
        ]);
        $blog = $this->blogRepository->update($this->editingBlogId, $blogData);
        if ($blog) {
            if (!empty($this->selectedCategories)) {
                $blog->categories()->sync($this->selectedCategories);
            }
            $this->dispatch('showToast', 'success', 'Success', 'Blog is updated successfully!');
            return redirect(route('admin.blogs'));
        } else {
            $this->dispatch('showToast', 'error', 'Error', 'Blog is updated failed!');
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
    #[On('hideImagePicker')]
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
        return view('admin.pages.blog.edit', compact('categories'));
    }
}
