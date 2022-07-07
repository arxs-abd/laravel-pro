<?php

namespace App\Http\Controllers;

use App\Models\KabupatenKotaModel;
use App\Models\KecamatanModel;
use App\Models\KelurahanDesaModel;
use App\Models\ProvinsiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DaerahController extends Controller
{
    //

    public function provinsi(Request $request)
    {
        return ProvinsiModel::all();
    }

    public function kabupaten_kota(Request $request)
    {
        if ($request->input('pdpr_dapil') !== null) {
            return DB::table('kabupaten_kota_pdpr_new')->where(['id_pdpr' => $request->input('pdpr_dapil')])->get();
        } else if ($request->input('pdprd1_dapil') !== null) {
            return DB::table('kabupaten_kota_pdprd1')->where(['id_pdprd1' => $request->input('pdprd1_dapil')])->get();
        }
        return KabupatenKotaModel::where(['id_provinsi' => $request->input('provinsi')])->get();
    }

    public function kecamatan(Request $request)
    {
        if ($request->input('pdpr_dapil') !== null) {
            return DB::table('kecamatan_pdpr')->where(['id_kabupaten_kota_pdpr' => $request->input('pdpr_dapil')])->get();
        } else if ($request->input('pdprd1_dapil') !== null) {
            return DB::table('new_kecamatan_pdprd1')->where(['id_kabupaten_kota' => $request->input('pdprd1_dapil')])->get();
        } else if ($request->input('pdprd2_dapil') !== null) {
            return DB::table('new_kecamatan_pdprd2')->where(['id_kabupaten_kota' => $request->input('pdprd2_dapil')])->get();
        }
        // else if ($request->input('pdprd1_dapil') !== null) {
        //     return DB::table('kecamatan_pdprd1')->where(['id_kabupaten_kota_pdprd1' => $request->input('pdprd1_dapil')])->get();
        // }
        return KecamatanModel::where(['id_kabupaten_kota' => $request->input('kabupaten_kota')])->get();
    }

    public function kelurahan_desa(Request $request)
    {
        if ($request->input('pdpr_dapil') !== null) {
            return DB::table('kelurahan_desa_pdpr')->where(['id_kecamatan_pdpr' => $request->input('pdpr_dapil')])->get();
        } else if ($request->input('pdprd1_dapil') !== null) {
            return DB::table('new_kelurahan_desa_pdprd1')->where(['id_kecamatan' => $request->input('pdprd1_dapil')])->get();
        } else if ($request->input('pdprd2_dapil') !== null) {
            return DB::table('new_kelurahan_desa_pdprd2')->where(['id_kecamatan' => $request->input('pdprd2_dapil')])->get();
        }
        return KelurahanDesaModel::where(['id_kecamatan' => $request->input('kecamatan')])->get();
    }
}
