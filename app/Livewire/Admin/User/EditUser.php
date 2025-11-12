<?php

namespace App\Livewire\Admin\User;

use App\Helpers\ImageUpload;
use App\Repository\Constracts\UserRepositoryInterface;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Livewire\Attributes\Title;

class EditUser extends Component
{
    use WithFileUploads;

    protected UserRepositoryInterface $userRepository;
    public $userId = null;
    public $first_name;
    public $last_name;
    public $username;
    public $email;
    public $birthday;
    public $currentAvatar;
    public $role;
    public $status;
    public $avatar;
    protected UserRequest $userRequest;

    public function boot(UserRepositoryInterface $repository)
    {
        $this->userRepository = $repository;
    }

    public function __construct()
    {
        $this->userRequest = new UserRequest();
    }

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->loadUser();
    }

    public function rules()
    {
        return $this->userRequest->rules('edit', $this->userId);
    }
    public function messages()
    {
        return $this->userRequest->messages();
    }

    public function loadUser()
    {
        $user = $this->userRepository->find($this->userId);
        if ($user) {
            $this->fill($user->only([
            'first_name',
            'last_name',
            'username',
            'email',
            'birthday',
        ]));
        $this->currentAvatar = $user->avatar;
        $this->role = $user->role->value;
        $this->status = $user->status->value;
        }
        else {
            $this->dispatch('showToast', 'error', 'Error','No user found to edit.');
            $this->dispatch('userUpdated');
        }
    }

    public function updateUser()
    {
        $this->validate();
        $userData = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'email' => $this->email,
            'birthday' => $this->birthday,
            'role' => $this->role,
            'status' => $this->status,
        ];

        if ($this->avatar) {
            ImageUpload::delete($this->currentAvatar);
            $avatar = ImageUpload::upload($this->avatar, 'avatars', 'public');
            $userData['avatar'] = $avatar;
        }

        $success = $this->userRepository->update($this->userId, $userData);
        if ($success) {
            $this->dispatch('userUpdated');
            $this->dispatch('showToast', 'success', 'Success','User info is updated successfully!');
        } else {
            $this->dispatch('showToast', 'error', 'Error','Some error occur while updating user info');
        }
    }

    #[Layout('layouts.page-layout')]
    #[Title('Edit User')]
    public function render()
    {
        return view('admin.pages.user.update');
    }
}
