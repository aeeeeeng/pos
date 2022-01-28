<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AddOpt extends Model
{
    use HasFactory;

    public static function getData($payloads, $type)
    {
        try {
            $querySub = DB::table('add_opt as ao')
                        ->join('add_opt_detail as aod', 'ao.id_add_opt', '=', 'aod.id_add_opt')
                        ->selectRaw("
                            ao.id_add_opt,
                            ao.id_outlet,
                            ao.nama_add_opt,
                            ao.punya_bahan_baku,
                            ao.created_at,
                            GROUP_CONCAT(aod.nama_add_opt_detail SEPARATOR ', ') as add_opt_detail
                        ")
                        ->groupBy('ao.id_add_opt', 'ao.nama_add_opt', 'ao.punya_bahan_baku');
            $addOpt = DB::table(DB::raw("({$querySub->toSql()}) as aodOpt"));
            if(isset($payloads['search'])) {
                $addOpt->where('aodOpt.nama_add_opt', 'like', '%' . $payloads['search'] . '%');
                $addOpt->orWhere('aodOpt.add_opt_detail', 'like', '%' . $payloads['search'] . '%');
            }
            if(isset($payloads['id_outlet'])) {
                $addOpt->where('aodOpt.id_outlet', $payloads['id_outlet']);
            }
            if($type == 'datatable') {
                return $addOpt;
            }
            return $addOpt->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function updateAddOpt($id, $payloads)
    {
        $payload = $payloads['opsiTambahan'];
        try {
            DB::table('add_opt_detail')->where('id_add_opt', $id)->delete();
            DB::table('add_opt')->where('id_add_opt', $id)
                                ->update([
                                    'nama_add_opt' => $payload['group'],
                                    'punya_bahan_baku' => $payload['punya_bahan_baku'],
                                    'updated_at' => date('Y-m-d H:i:s'),
                                    'updated_by' => auth()->user()->name
                                ]);
            $details = [];
            foreach ($payload['detail'] as $item) {
                $detail['id_add_opt'] = $id;
                $detail['nama_add_opt_detail'] = $item['nama'];
                $detail['harga_add_opt_detail'] = $item['harga'];
                $details[] = $detail;
            }
            DB::table('add_opt_detail')->insert($details);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function storeKelolaBahanBaku($id, $payloads)
    {
        try {
            $payloadInsert = [];
            foreach ($payloads as $item) {
                DB::table('add_opt_komposit')->where('id_add_opt', $item['id_add_opt_detail'])->delete();
                foreach ($item['detail'] as $itemDetail) {
                    if($itemDetail['id_produk_detail'] != null) {
                        $payload = [];
                        $payload['id_add_opt'] = $item['id_add_opt_detail'];
                        $payload['id_produk_detail'] = $itemDetail['id_produk_detail'];
                        $payload['jumlah_komposit'] = $itemDetail['jumlah_komposit'];
                        $payload['nama_komposit'] = 'BAHAN_BAKU_' . strtoupper(str_replace(' ', '_', $itemDetail['nama_produk']));
                        $payloadInsert[] = $payload;
                    }
                }
            }
            if(count($payloadInsert) > 0) {
                DB::table('add_opt_komposit')->insert($payloadInsert);
            } else {
                throw new Exception("tidak ada data yang akan disimpan");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
