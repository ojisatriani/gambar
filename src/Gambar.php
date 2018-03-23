<?php
namespace OjiSatriani;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class Gambar
{
    private $jenis;
    private $tersimpan;
    private $destinationPath;
    private $nama;

    public function __construct($path, $nama, $file)
    {
        if(Storage::put($path . $nama, file_get_contents($file)))
        {
            $this->destinationPath  = storage_path().'/app/'.$path;
            $this->nama             = $nama;
            $this->tersimpan        = TRUE;
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

    public function ukuranBaru(array $ukuran = []){
        foreach($ukuran as $value){
            $gbr = self::ukuranData();
            $img = Image::make($this->destinationPath .'/'. $this->nama);
            $img->resize($gbr[$value]['lebar'], $gbr[$value]['tinggi']);
            $img->save($this->destinationPath .'/'. $value .'-'. $this->nama);
            $img->destroy();
        }
    }

    public static function hapus($fullPathToFile)
    {
        if (file_exists($fullPathToFile)) {
            if(unlink($fullPathToFile))
            {
                foreach (self::ukuranData() as $key => $value) {
                    $data = explode('/', $fullPathToFile);
                    $file = end($data);
                    $filter = array_filter($data);
                    array_pop($filter);
                    $path = implode("/",$filter);
                    if (file_exists($path .'/'. $key .'-'. $file)) {
                        unlink($path .'/'. $key .'-'. $file);
                    }
                }
            } else {
                return false;
            }
        }
        return true;
    }

    public static function ukuranData(){
        return [
            'thumb'=>[
                'lebar'     => 180,
                'tinggi'    => 280,
            ],
            'wide'=>[
                'lebar'     => 508,
                'tinggi'    => 377,
            ],
            'avatar'=>[
                'lebar'     => 128,
                'tinggi'    => 128,
            ],
        ];
    }

}
