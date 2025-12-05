<?php

namespace App\Livewire\Superadmin\Kategori;

use App\Models\kategori;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginate = '10';
    public $search = '';

    public $nama_kategori,$kategori_id;
    public $role = 'Super Admin';
    public function render()
    {
        $data = array(
            'title' => 'Data kategori',
            'kategori' => Kategori::where('nama_kategori', 'like', '%' . $this->search . '%')
                ->orderBy('nama_kategori', 'asc')->paginate($this->paginate),

        );
        return view('livewire.superadmin.kategori.index', $data);
    }

    public function create()
    {
        //reset form
        $this->resetValidation();

        $this->reset([
            'nama_kategori',
        ]);
    }

    public function store()
    {
        //validate
        $this->validate(
            [
                'nama_kategori' => 'required|unique:kategoris,nama_kategori',
            ],
            [
                'nama_kategori.required' => 'Nama kategori wajib diisi',
                'nama_kategori.unique' => 'Nama kategori sudah digunakan',
            ]
        );

        //save to db
        $kategori = new Kategori;
        $kategori->nama_kategori = $this->nama_kategori;
        $kategori->save();
        $this->dispatch('closeCreateModal');
    }

    public function edit($id)
    {
        //reset form
        $this->resetValidation();

        //old data
        $kategori = kategori::findOrFail($id);
        $this->nama_kategori = $kategori->nama_kategori;
        $this->kategori_id = $kategori->id;
    }

    public function update($id)
    {
        $kategori = kategori::findOrFail($id);

        //validate
        $this->validate(
            [
                'nama_kategori' => 'required|unique:kategoris,nama_kategori,' .$id,
            ],
            [
                'nama_kategori.required' => 'Nama kategori wajib diisi',
                'nama_kategori.unique' => 'Nama kategori sudah digunakan',
            ]
        );

        //save to db
        $kategori->nama_kategori = $this->nama_kategori;
        $kategori->save();
        $this->dispatch('closeEditModal');
    }

    public function confirm($id){
        $kategori = Kategori::findOrFail($id);
        $this->nama_kategori = $kategori->nama_kategori;
        $this->kategori_id = $kategori->id;
    }

    public function destroy($id){
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        $this->dispatch('closeDeleteModal');
    }
}
