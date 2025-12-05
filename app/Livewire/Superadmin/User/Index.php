<?php

namespace App\Livewire\Superadmin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;


class Index extends Component
{
    use WithPagination;
    protected $paginationTheme ='bootstrap';
    public $paginate = '10';
    public $search = '';

    public $name;
    public $email;
    public function render()
    {
        $data = array (
            'title' => 'Data User',
            'user' => User::where('name', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%')
            ->orWhere('role', 'like', '%'.$this->search.'%')
            ->orderBy('role','asc')->paginate($this->paginate),

        );
        return view('livewire.superadmin.user.index',$data);
    }

    public function create(){
        $this->resetValidation();
        $this->reset([
            'name',
            'email',
        ]);
    }

    public function store(){
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
        ],[
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email salah',
            'email.unique' => 'Email sudah digunakan',
        ]
    );
    }
}
