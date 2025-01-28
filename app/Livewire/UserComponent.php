<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class UserComponent extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama, $email, $password, $id, $cari;
    public function render()
    {
        $layout['title'] = "Kelola User";
        if ($this->cari != "") {
            $users = User::where('nama', 'like', '%' . $this->cari . '%')
                ->orWhere('gmail', 'like', '%' . $this->cari . '%')
                ->paginate(10);
        } 
        else {
            $data['user'] = User::paginate(10);
        }

        return view('livewire.user-component', $data)->layoutData($layout);
    }
    public function store()
    {
        $this->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'nama.required' => 'Nama tidak boleh kosong!',
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Email tidak valid!',
            'password.required' => 'Password tidak boleh kosong!'
        ]);
        User::create([
            'nama' => $this->nama,
            'email' => $this->email,
            'password' => $this->password,
            'jenis' => 'admin'
        ]);
        session()->flash('succes', 'Berhasil Disimpan');
        $this->reset();
    }
    public function edit($id)
    {
        $user = User::find($id);
        $this->nama = $user->nama;
        $this->email = $user->email;
        $this->id = $user->id;
    }
    public function update()
    {
        $user = User::find($this->id);
        if ($this->password == "") {
            $user->update([
                'nama' => $this->nama,
                'email' => $this->email
            ]);
        } else {
            $user->update([
                'nama' => $this->nama,
                'email' => $this->email,
                'password' => $this->password
            ]);
        }
        session()->flash('success', 'Berhasil ubah!');
        $this->reset();
    }
    public function confirm($id)
    {
        $this->id = $id;
    }
    public function destroy()
    {
        $user = User::find($this->id);
        $user->delete();
        session()->flash('success', 'Berhasil dihapus!');
        $this->reset();
    }
}
