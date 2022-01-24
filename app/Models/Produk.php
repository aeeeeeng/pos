<?php

namespace App\Models;

use App\Library\UniqueCode;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $fillable = ['kode_produk'];
    protected $guarded = [];

    public static $storeRule = [
        'id_kategori' => 'required',
        'id_uom' => 'required',
        'sku_produk' => 'required|string|max:100|unique:produk,sku_produk',
        'barcode_produk' => 'nullable|string|max:100|unique:produk,barcode_produk',
        'nama_produk' => 'required|string|max:100|unique:produk,nama_produk',
        'harga_jual' => 'required|integer',
        'gambar' => 'nullable|max:1000'
    ];

    public static function getProdukList($payloads, $type)
    {
        try {
            $produk = DB::table('produk as p')
                  ->leftJoin('kategori as k', 'p.id_kategori', '=', 'k.id_kategori')
                  ->selectRaw('p.*, k.nama_kategori')
                  ->where('p.status', '1');
            if(isset($payloads['id_outlet'])) {
                $produk->where('p.id_outlet', $payloads['id_outlet']);
            }
            if(isset($payloads['id_kategori'])) {
                $produk->where('p.id_kategori', $payloads['id_kategori']);
            }
            if(isset($payloads['dijual'])) {
                $produk->where('p.dijual', $payloads['dijual']);
            }
            if(isset($payloads['cari'])) {
                $produk->where('p.nama_produk', 'like', '%' . $payloads['cari'] . '%');
                $produk->orWhere('p.sku_produk', 'like', '%' . $payloads['cari'] . '%');
                $produk->orWhere('p.barcode_produk', 'like', '%' . $payloads['cari'] . '%');
            }

            $produk->orderBy('created_at', 'desc');

            if($type == 'datatable') {
                return $produk;
            }

            return $produk->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function imageText($text)
    {
        $string = $text;
        $font   = 20;
        $im = @imagecreate (50,50);
        $background_color = imagecolorallocate ($im, 81, 86, 190); //white background
        $text_color = imagecolorallocate ($im, 255, 255,255);//black text
        imagestring ($im, $font, 17, 17, $string, $text_color);
        ob_start();
        imagepng($im);
        $imstr = base64_encode(ob_get_clean());
        imagedestroy($im);
        return $imstr;
    }

    public static function storeProduk($payloads)
    {
        try {

            $additionalOpt = $payloads['additionalOpt'];
            unset($payloads['additionalOpt']);

            $payloads['kode_produk'] = (new UniqueCode(self::class, 'kode_produk', 'PRD-', 9, true))->get();
            $payloads['id_kategori'] = self::insertNotExistKategori($payloads['id_kategori']);
            $payloads['id_uom'] = self::insertNotExistUom($payloads['id_uom']);
            $payloads['id_outlet'] = session()->get('outlet');
            $payloads['jenis'] = 'master';
            $payloads['created_at'] = date("Y-m-d H:i:s");
            $payloads['created_by'] = auth()->user()->name;

            $idProduct = DB::table('produk')->insertGetId($payloads);

            if($payloads['additional'] == 1) {
                self::insertProdukAdditional($idProduct, $additionalOpt);
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function storeKelolaStokProduk($id, $payloads)
    {
        try {
            DB::table('produk')->where('id_produk', $id)
            ->update($payloads);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function updateProduk($payloads, $id)
    {
        try {

            $additionalOpt = $payloads['additionalOpt'];
            unset($payloads['additionalOpt']);

            $payloads['kode_produk'] = (new UniqueCode(self::class, 'kode_produk', 'PRD-', 9, true))->get();
            $payloads['id_kategori'] = self::insertNotExistKategori($payloads['id_kategori']);
            $payloads['id_uom'] = self::insertNotExistUom($payloads['id_uom']);
            $payloads['jenis'] = 'master';
            $payloads['updated_at'] = date("Y-m-d H:i:s");
            $payloads['updated_by'] = auth()->user()->name;

            DB::table('produk')->where('id_produk', $id)->update($payloads);

            if($payloads['additional'] == 1) {
                DB::table('produk_additional')->where('id_produk', $id)->delete();
                self::insertProdukAdditional($id, $additionalOpt);
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function insertProdukAdditional($idProduct, $additionalOpt)
    {
        try {
            $payloads = [];
            $additionalOptArr = explode(',', $additionalOpt[0]);
            foreach ($additionalOptArr as $item) {
                $payload['id_produk'] = $idProduct;
                $payload['id_add_opt'] = $item;
                $payloads[] = $payload;
            }
            DB::table('produk_additional')->insert($payloads);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function insertNotExistKategori($kategori)
    {
        try {
            $kategori = strtoupper($kategori);
            $check = DB::table('kategori')->whereRaw("UPPER(kategori.nama_kategori) = '".$kategori."'");
            if($check->count() == 0) {
                $createDate = date("Y-m-d H:i:s");
                $id = DB::table('kategori')->insertGetId(['nama_kategori' => $kategori, 'created_at' => $createDate]);
                return $id;
            }
            return $check->first()->id_kategori;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function insertNotExistUom($uom)
    {
        try {
            $uom = strtoupper($uom);
            $check = DB::table('uom')->whereRaw("UPPER(uom.nama_uom) = '".$uom."'");
            if($check->count() == 0) {
                $createDate = date("Y-m-d H:i:s");
                $createdBy = auth()->user()->name;
                $id = DB::table('uom')->insertGetId(['nama_uom' => $uom, 'created_at' => $createDate, 'created_by' => $createdBy]);
                return $id;
            }
            return $check->first()->id_uom;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function getPriceFifo($idProduct)
    {
        $in = DB::table('stok_produk_detail spd')
              ->join('produk as p', 'spd.id_produk', '=', 'p.id_produk')
              ->join('stok_produk sp', 'spd.id_reference', '=', 'sp.id_stok_produk')
              ->where('spd.id_produk', $idProduct)
              ->where('spd.nilai', '>', 0)
              ->selectRaw("
                    sp.tanggal,
                    p.nama_produk,
                    spd.nilai as qty_in,
                    0 as qty_out,
                    spd.harga,
                    spd.sub_total
              ");

        $out = DB::table('stok_produk_detail spd')
              ->join('produk as p', 'spd.id_produk', '=', 'p.id_produk')
              ->join('stok_produk sp', 'spd.id_reference', '=', 'sp.id_stok_produk')
              ->where('spd.id_produk', $idProduct)
              ->where('spd.nilai', '<', 0)
              ->selectRaw("
                    sp.tanggal,
                    p.nama_produk,
                    0 as qty_in,
                    spd.nilai as qty_out,
                    spd.harga,
                    spd.sub_total
              ")
              ->union($in);

        $result = DB::table(DB::raw( "({$out->toSql()}) as sub" ))
                  ->whereRaw("sub.qty_in + sub.qty_out <> 0")
                  ->orderBy("sub.tanggal", 'asc');

        return $result->first();

    }
}
