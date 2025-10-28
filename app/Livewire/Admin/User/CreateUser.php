<?php

namespace App\Livewire\Admin\User;

use App\Helpers\ImageUpload;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Repository\Constracts\UserRepositoryInterface;

class CreateUser extends Component
{
    use WithFileUploads;

    protected UserRepositoryInterface $userRepository;
    public function boot(UserRepositoryInterface $repository)
    {
        $this->userRepository = $repository;
    }

    public $first_name;
    public $last_name;
    public $username;
    public $email;
    public $password;
    public $password_confirmation;
    public $birthday;
    public $avatar;
    public $role = 'user';
    public $status = 'active';

    public function rules()
    {
        return (new UserRequest()->rules());
    }
    public function messages()
    {
        return (new UserRequest()->messages());
    }

    public function createUser()
    {
        $this->validate();

        $userData = $this->only([
            'first_name',
            'last_name',
            'username',
            'email',
            'birthday',
            'role',
            'status'
        ]);
        $userData['password'] = Hash::make($this->password);

        if ($this->avatar) {
            $avatarPath = ImageUpload::upload($this->avatar, 'avatars', 'public');
            $userData['avatar'] = $avatarPath;
        }

        $this->userRepository->create($userData);

        $this->reset();
        $this->dispatch('userCreated');

        session()->flash('massage', 'User is created successfully!');
    }

    #[Layout('layouts.page-layout')]
    public function render()
    {
        return view('admin.pages.user.create');
    }
}
