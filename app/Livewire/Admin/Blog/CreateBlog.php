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
    public $title = '';
    public $content = '';
    public $selectedCategories = [];
    public bool $openImageModal = false;
    public bool $openCategoryModal = false;

    public function boot(BlogRepositoryInterface $blog_repository, CategoryRepositoryInterface $category_repository, ImageRepositoryInterface $image_repository)
    {
        $this->blogRepository = $blog_repository;
        $this->categoryRepository = $category_repository;
        $this->imageRepository = $image_repository;
    }

    public function rules()
    {
        return (new BlogRequest()->rules());
    }
    public function messages()
    {
        return (new BlogRequest()->messages());
    }

    #[On('save-mail')]
    public function updateBody($content)
    {
        $this->content = $content;
        $this->createBlog();
    }

    public function showCategoryModal()
    {
        $this->openCategoryModal = true;
    }
    public function hideCategoryModal()
    {
        $this->openCategoryModal = false;
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

        if (!empty($this->selectedCategories)) {
            $blog->categories()->sync($this->selectedCategories);
        }

        session()->flash('message', 'Product is created successfully!');
        return redirect(route('admin.blogs'));
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
