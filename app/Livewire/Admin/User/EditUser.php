<?php

namespace App\Livewire\Admin\User;

use App\Repository\Constracts\UserRepositoryInterface;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

class EditUser extends Component
{
    use WithFileUploads;

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

    protected UserRepositoryInterface $userRepository;

    public function boot(UserRepositoryInterface $repository)
    {
        $this->userRepository = $repository;
    }

    //custom rule for EditUser
    public function rules()
    {
        return (new UserRequest()->rules('edit', $this->userId));
    }
    public function messages()
    {
        return (new UserRequest()->messages());
    }


    public function mount($userId)
    {
        $this->userId = $userId;
        $this->loadUser();
    }

    public function loadUser()
    {
        $user = $this->userRepository->find($this->userId);
        if ($user) {
            $this->first_name = $user->first_name;
            $this->last_name = $user->last_name;
            $this->username = $user->username;
            $this->email = $user->email;
            $this->currentAvatar = $user->avatar;
            $this->birthday = $user->birthday;
            $this->role = $user->role->value;
            $this->status = $user->status->value;
        }
        else {
            session()->flash('error', 'Không tìm thấy người dùng để chỉnh sửa.');
            $this->dispatch('userUpdated'); // Close modal if user not exists
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
                if ($this->currentAvatar && Storage::disk('public')->exists($this->currentAvatar)) {
                    Storage::disk('public')->delete($this->currentAvatar);
                }
            $avatar = $this->avatar->store('avatars', 'public');
            $userData['avatar'] = $avatar;
        }

        $success = $this->userRepository->update($this->userId, $userData);
        if ($success) {
            $this->dispatch('userUpdated');
            session()->flash('message', 'Thông tin người dùng đã được cập nhật thành công!');
        } else {
            session()->flash('error', 'Có lỗi xảy ra khi cập nhật người dùng.');
        }
    }

    #[Layout('layouts.page-layout')]
    public function render()
    {
        return view('admin.pages.user.update');
    }
}
