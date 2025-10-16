<?php

namespace App\Livewire\Admin\User;

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

    public $first_name;
    public $last_name;
    public $username;
    public $email;
    public $password;
    public $password_confirmation;
    public $birthday;
    public $avatar;
    public $role = 'user';
    public $status = 'inactive';


    public function mount(){

    }

    public function boot(UserRepositoryInterface $repository){
        $this->userRepository = $repository;
    }

    public function rules(){
        return (new UserRequest()->rules());
    }
    public function messages(){
        return (new UserRequest()->messages());
    }

    public function createUser(){
        $this->validate();

        $userData = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'birthday' => $this->birthday,
            'role' => $this->role,
            'status' => $this->status,
        ];

        if ($this->avatar){
            $avatarPath = $this->avatar->store('avatars', 'public');
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
