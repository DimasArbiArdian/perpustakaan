<?php

namespace App\Livewire;

use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class KategoriComponent extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme='bootstrap';
    public $nama, $id, $deskripsi, $cari;
    public function render()
    {
        if($this->cari!=""){
            $data['kategori']=Kategori::where('nama','like','%'.$this->cari.'%')->paginate(10);
        }
        else{

        }
        return view('livewire.kategori-component');
    }
}
