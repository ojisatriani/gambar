<?php
namespace OjiSatriani;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
// use Storage;
class Gambar
{
    private $jenis;
    private $tersimpan;
    //private $destinationPath;
    //private $nama;

    //function __set($propName, $propValue)
    //{
        //$this->$propName = $propValue;
        //property dipakai ( jenis, destinationPath, nama)
    //}

    public function __construct($path, $nama, $file)
    {
        if(Storage::put($target . $nama, file_get_contents($file)))
        {
            $this->tersimpan = TRUE;
            return TRUE;
        } else {
            $this->tersimpan = FALSE;
            return FALSE;
        }
    }

    public static function simpan($path, $nama, $file)
    {
        return new static($path, $nama, $file);
    }

    public function ukuranBaru(array $ukuran = null){
        $ukuran = $ukuran === null ? ['wide','banner']:$ukuran;
        foreach($ukuran as $value){
            // $this->ukuranGambar($value);
            //$this->nama =
            //$this->jenis = $value;
            $gbr = $this->ukuranData();
            $img = Image::make($destinationPath .'/'. $nama);
            $img->resize($gbr[$value]['lebar'], $gbr[$value]['tinggi']);
            $img->save($destinationPath .'/'. $this->jenis .'-'. $nama);
            $img->destroy();
        }
    }

    public function hapus($path, $file)
    {
        $path = 'app/'. $path .'/';
        if (!empty($file)) {
            if (file_exists($path . $file)) {
                //unlink($path . $file);
                Storage::delete($path . $file);
            }
            // $tipe = array("kecil", "thumb", "empatEnam", "sedang", "wide", "slide", "banner","avatar");
            foreach ($this->ukuranData() as $gbr) {
                // $exists = Storage::disk('local')->exists('file.jpg');
                // if (file_exists($path . $gbr .'-'. $file)) {
                if (Storage::disk('local')->exists($path . $file)) {
                    // unlink($path . $gbr .'-'. $file);
                    Storage::delete($path . $gbr .'-'. $file);
                }
            }
        }
    }

    public function tipe($tipe){
        if($tipe !="image/gif" and	$tipe !="image/jpeg" and $tipe !="image/pjpeg" and $tipe !="image/png") return false;
        else return true;
    }

    public function ukuranGambar($jenis){
        $this->jenis = $jenis;
    }

    public function ukuranData(){
        return [
            'thumb'=>[
                'lebar'     => 180,
                'tinggi'    => 280,
            ],
            'wide'=>[
                'lebar'     => 508,
                'tinggi'    => 377,
            ],
        ];
    }

    // public function getLebar(){
    //     $lebar = 700;
    //     $lebar = $this->jenis == 'empatEnam' ? 180:$lebar;
    //     $lebar = $this->jenis == 'thumb' ? 280:$lebar;
    //     $lebar = $this->jenis == 'sedang' ? 330:$lebar;
    //     $lebar = $this->jenis == 'kecil' ? 80:$lebar;
    //     $lebar = $this->jenis == 'wide' ? 508:$lebar;
    //     $lebar = $this->jenis == 'slide' ? 1020:$lebar;
    //     $lebar = $this->jenis == 'banner' ? 300:$lebar;
    //     $lebar = $this->jenis == 'avatar' ? 128:$lebar;
    //     return $lebar;
    // }

    // public function getTinggi(){
    //     $tinggi = 500;
    //     $tinggi = $this->jenis == 'empatEnam' ? 250:$tinggi;
    //     $tinggi = $this->jenis == 'thumb' ? 280:$tinggi;
    //     $tinggi = $this->jenis == 'sedang' ? 240:$tinggi;
    //     $tinggi = $this->jenis == 'kecil' ? 80:$tinggi;
    //     $tinggi = $this->jenis == 'wide' ? 377:$tinggi;
    //     $tinggi = $this->jenis == 'slide' ? 450:$tinggi;
    //     $tinggi = $this->jenis == 'banner' ? 100:$tinggi;
    //     $tinggi = $this->jenis == 'avatar' ? 128:$tinggi;
    //     return $tinggi;
    // }

    // public function namaBaru(){
    //         return $this->jenis;
    // }

    

    // public function tempelBarcode($jenisGbr, $barcodePath){
    //     $img = Image::make($this->destinationPath .'/'. $jenisGbr .'-'. $this->nama);
    //     //$watermark = Image::make($barcodePath);
    //     //$img->insert($watermark, 'center');
    //     $img->insert($barcodePath, 'bottom-right', 10, 10);
    //     $img->save($this->destinationPath .'/'. $this->jenis .'-'. $this->nama);
    // }

}
