<?php

namespace App\Livewire\Admin\User;

use App\Helpers\ImageUpload;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Repository\Constracts\UserRepositoryInterface;
use Livewire\Attributes\Title;

class CreateUser extends Component
{
    use WithFileUploads;

    protected UserRepositoryInterface $userRepository;
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
    protected UserRequest $userRequest;

    public function __construct()
    {
        $this->userRequest = new UserRequest();
    }

    public function boot(UserRepositoryInterface $repository)
    {
        $this->userRepository = $repository;
    }

    public function rules()
    {
        return $this->userRequest->rules();
    }
    public function messages()
    {
        return $this->userRequest->messages();
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

        $user = $this->userRepository->create($userData);

        if ($user) {
            $this->reset();
            $this->dispatch('userCreated');
            $this->dispatch('showToast', 'success', 'Success', 'User is created successfully!');
        } else {
            $this->dispatch('showToast', 'error', 'Error', 'User is created failed!');
        }
    }

    #[Layout('layouts.page-layout')]
    #[Title('Create User')]
    public function render()
    {
        return view('admin.pages.user.create');
    }
}
