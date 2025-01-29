<?php

namespace App\Livewire;

use App\Models\Buku;
use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class BukuComponent extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $kategori, $judul, $penulis, $penerbit, $isbn, $tahun, $jumlah, $cari, $id;
    public function render()
    {
        if($this->cari!=''){
            $buku = Buku::where('judul', 'like', '%' . $this->cari.'%')->paginate(10);
        }
        else{
            $data['buku']=Buku::paginate(10);
        }
        
        $data['category']=Kategori::all();
        $layout['title']='Kelola Buku';
        return view('livewire.buku-component', $data)->layoutData($layout);
    }
    public function store(){
        $this->validate([
            'judul'=>'required',
            'penulis'=>'required',
            'penerbit'=>'required',
            'isbn'=>'required',
            'tahun'=>'required',
            'jumlah'=>'required',
            'kategori'=>'required'
        ],[
            'judul.required'=>'Judul Buku Tidak Boleh Kosong!',
            'penulis.required'=>'Penulis Buku Tidak Boleh Kosong!',
            'penerbit.required'=>'Penerbit Buku Tidak Boleh Kosong!',
            'isbn.required'=>'ISBN Buku Tidak Boleh Kosong!',
            'tahun.required'=>'Tahun Buku Tidak Boleh Kosong!',
            'jumlah.required'=>'Jumlah Buku Tidak Boleh Kosong!',
            'kategori.required'=>'Kategori Buku Tidak Boleh Kosong!'
        ]);
        Buku::create([
            'judul'=>$this->judul,
            'penulis'=>$this->penulis,
            'penerbit'=>$this->penerbit,
            'isbn'=>$this->isbn,
            'tahun'=>$this->tahun,
            'jumlah'=>$this->jumlah,
            'kategori_id'=>$this->kategori
        ]);
        $this->reset();
        session()->flash('success','Data Buku Berhasil Ditambahkan!');
        return redirect()->route('buku');
    }
    public function edit($id){
        $buku=Buku::find($id);
        $this->id=$id;
        $this->judul=$buku->judul;
        $this->penulis=$buku->penulis;
        $this->penerbit=$buku->penerbit;
        $this->isbn=$buku->isbn;
        $this->tahun=$buku->tahun;
        $this->jumlah=$buku->jumlah;
        $this->kategori=$buku->kategori->id;
    }
    public function update(){
        $buku=Buku::find($this->id);
        $buku->update([
            'judul'=>$this->judul,
            'penulis'=>$this->penulis,
            'penerbit'=>$this->penerbit,
            'isbn'=>$this->isbn,
            'tahun'=>$this->tahun,
            'jumlah'=>$this->jumlah,
            'kategori_id'=>$this->kategori
        ]);
        $this->reset();
        session()->flash('success','Data Buku Berhasil Diubah!');
        return redirect()->route('buku');
    }
    public function confirm($id){
        $this->id=$id;
    }
    public function destroy(){
        $buku=Buku::find($this->id);
        $buku->delete();
        $this->reset();
        session()->flash('success','Data Buku Berhasil Dihapus!');
        return redirect()->route('buku');
    }
}
