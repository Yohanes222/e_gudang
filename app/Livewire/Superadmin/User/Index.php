<?php

namespace App\Livewire\Superadmin\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

use function PHPSTORM_META\map;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginate = '10';
    public $search = '';

    public $name, $email, $password, $password_confirmation, $user_id;
    public $role = 'Super Admin';
    public function render()
    {
        $data = array(
            'title' => 'Data User',
            'user' => User::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('role', 'like', '%' . $this->search . '%')
                ->orderBy('role', 'asc')->paginate($this->paginate),

        );
        return view('livewire.superadmin.user.index', $data);
    }

    public function create()
    {
        //reset form
        $this->resetValidation();

        $this->reset([
            'name',
            'email',
            'role',
            'password',
            'password_confirmation',
        ]);
    }

    public function store()
    {
        //validate
        $this->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'role' => 'required',
                'password' => 'required|min:8|confirmed',
                'password_confirmation' => 'required',
            ],
            [
                'name.required' => 'Nama wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email salah',
                'email.unique' => 'Email sudah digunakan',
                'role.required' => 'Role wajib diisi',
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
                'password.confirmed' => 'Password Konfirmasi tidak sama',
                'password_confirmation.required' => 'Konfirmasi password wajib diisi',
            ]
        );

        //save to db
        $user = new User;
        $user->name = $this->name;
        $user->email = $this->email;
        $user->role = $this->role;
        $user->password = Hash::make($this->password);
        $user->save();
        $this->dispatch('closeCreateModal');
    }

    public function edit($id)
    {
        //reset form
        $this->resetValidation();

        //old data
        $user = User::findOrFail($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = '';
        $this->password_confirmation = '';
        $this->user_id = $user->id;
    }

    public function update($id)
    {
        $user = User::findOrFail($id);

        //validate
        $this->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
                'role' => 'required',
                'password' => 'nullable|min:8|confirmed',
            ],
            [
                'name.required' => 'Nama wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email salah',
                'email.unique' => 'Email sudah digunakan',
                'role.required' => 'Role wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
                'password.confirmed' => 'Password Konfirmasi tidak sama',
            ]
        );

        //save to db
        $user->name = $this->name;
        $user->email = $this->email;
        $user->role = $this->role;
        if (filled($this->password)) {
            $user->password = Hash::make($this->password);
        }
        $user->save();
        $this->dispatch('closeEditModal');
    }

    public function confirm($id){
        $user = User::findOrFail($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->user_id = $user->id;
    }

    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();
        $this->dispatch('closeDeleteModal');
    }
}
