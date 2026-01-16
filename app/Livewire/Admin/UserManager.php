<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class UserManager extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $showModal = false;
    public $editingUserId = null;
    
    // Form fields
    public $name = '';
    public $email = '';
    public $password = '';

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'password' => 'nullable|min:8',
    ];

    public function openCreateModal()
    {
        $this->reset(['name', 'email', 'password', 'editingUserId']);
        $this->showModal = true;
    }

    public function openEditModal($userId)
    {
        $user = \App\Models\User::findOrFail($userId);
        $this->editingUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editingUserId) {
            $user = \App\Models\User::find($this->editingUserId);
            $data = [
                'name' => $this->name,
                'email' => $this->email,
            ];
            if ($this->password) {
                $data['password'] = bcrypt($this->password);
            }
            $user->update($data);
        } else {
            \App\Models\User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => bcrypt($this->password),
            ]);
        }

        $this->showModal = false;
        $this->dispatch('show-notification', 'User saved successfully!', 'success');
    }

    public function delete($userId)
    {
        \App\Models\User::findOrFail($userId)->delete();
        $this->dispatch('show-notification', 'User deleted successfully!', 'success');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['name', 'email', 'password', 'editingUserId']);
    }

    public function render()
    {
        $users = \App\Models\User::withCount('orders')
            ->when($this->searchTerm, fn($q) => $q->where('name', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('email', 'like', '%' . $this->searchTerm . '%'))
            ->latest()
            ->paginate(20);

        return view('livewire.admin.user-manager', [
            'users' => $users,
        ]);
    }
}
