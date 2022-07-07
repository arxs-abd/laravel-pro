<?php

namespace App\Http\Controllers;

use App\Models\ProvinsiModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // dump($request->input());
        $field = ['jenis_pemilihan', 'provinsi', 'kabupaten_kota', 'kecamatan', 'kelurahan_desa', 'dapil'];
        $where = [];
        foreach ($field as $index) {
            if ($request->input($index) !== null) {
                $where[$index] = $request->input($index);
            }
        }
        if (count($where) === 0) {
            $data = [
                'allUser' => [],
                'length' => 0
            ];
            return view('home', $data);
        }
        // dump($where);
        $user =  UserModel::where($where)->get();
        $newData = [];
        $last = 0;
        foreach ($user as $u) {
            $name = $u->nama_calon;
            $tps = (int) $u->tps;
            $suara = $u->perolehan_suara;
            $id = $u->nomor_calon;
            $newData[$id]['nama'] = $name;
            $newData[$id]['TPS ' . $tps] = $suara;
            $last = $tps;
        }
        $data = [
            'allUser' => $newData,
            'length' => $last,
        ];
        return view('home', $data);
    }

    public function testing()
    {
        set_time_limit(7200);
        // $provinsi = ProvinsiModel::all();
        $provinsi = ProvinsiModel::where(['id' => 27])->get();
        $no = 0;
        $total = 0;
        foreach ($provinsi as $prov) {
            $name = trim($prov->provinsi);
            $kabupatenSemua = DB::table('user')->distinct('kelurahan_desa')->where([
                'jenis_pemilihan' => 'pdprd2',
                'provinsi' => $name
            ])->get(['kabupaten_kota', 'dapil', 'kecamatan', 'kelurahan_desa']);
            $dapil = $kabupatenSemua->groupBy('dapil');
            // dd($dapil);
            foreach ($dapil as $kabupaten) {
                // dump($kabupaten);
                $idDapil = DB::table('new_dapil_pdprd2')->where([
                    'dapil' => $kabupaten[0]->dapil
                ])->get('id')->first()->id;

                foreach ($kabupaten as $res) {
                    $idKec = DB::table('new_kecamatan_pdprd2')->where([
                        'id_provinsi' => $prov->id,
                        'id_kabupaten_kota' => $idDapil,
                        'kecamatan' => $res->kecamatan
                    ])->get('id')->first()->id;
                    DB::table('new_kelurahan_desa_pdprd2')->insert([
                        'id_provinsi' => $prov->id,
                        'id_kabupaten_kota' => $idDapil,
                        'id_kecamatan' => $idKec,
                        'kelurahan_desa' => $res->kelurahan_desa
                    ]);
                }

                // dump($kabupaten);
                // $idDapil = DB::table('dapil_pdprd2')->where([
                //     'dapil' => $kabupaten[0]->dapil
                // ])->get()->first()->id;
                // foreach ($kabupaten as $res) {
                //     $idKab = DB::table('kabupaten_kota_pdprd2')->where([
                //         'id_provinsi' => $prov->id,
                //         'id_pdprd2' => $idDapil,
                //         'kabupaten_kota' => $res->kabupaten_kota
                //     ])->get()->first()->id;
                //     DB::table('new_kecamatan_pdprd2')->insert([
                //         'id_provinsi' => $prov->id,
                //         'id_kabupaten_kota' => $idKab,
                //         'kecamatan' => $res->kecamatan
                //     ]);
                //     $total++;
                // }
            }
            $no++;
            // echo '[' . $no . '. ' . $name . ' ' . $total .  '] ';
            dump('[' . $no . '. ' . $name . ' ' . $total .  '] ');
        }
    }

    public function search(Request $request)
    {
        $where = [];
        $field = ['jenis_pemilihan', 'dapil', 'kabupaten_kota', 'kecamatan', 'kelurahan_desa'];
        $jenisPemilihan = $request->input('jenis_pemilihan');
        if ($jenisPemilihan === 'pdprd1') {
            $field = ['jenis_pemilihan', 'provinsi', 'dapil', 'kabupaten_kota', 'kecamatan', 'kelurahan_desa'];
        } else if ($jenisPemilihan === 'pdprd2') {
            $field = ['jenis_pemilihan', 'provinsi', 'kabupaten_kota', 'dapil', 'kecamatan', 'kelurahan_desa'];
        }
        $lastField = '';
        foreach ($field as $input) {
            if ($request->input($input)) {
                $where[$input] = $request->input($input);
                $lastField = $input;
            }
        }
        $user = UserModel::where($where)->get();
        if (!isset($user[0])) return [
            'user' => 'ERROR'
        ];

        $newData = [];

        if ($lastField === 'kelurahan_desa') {
            $newData = HomeController::searchWith($user);
        } else if ($lastField === 'kecamatan') {
            $newData = HomeController::searchWith($user, 'kelurahan_desa');
        } else if ($lastField === 'kabupaten_kota') {
            if ($where['jenis_pemilihan'] === 'pdprd2') {
                $newData = HomeController::searchWith($user, 'dapil');
            } else {
                $newData = HomeController::searchWith($user, 'kecamatan');
            }
        } else if ($lastField === 'provinsi') {
            if ($where['jenis_pemilihan'] === 'pdprd1') {
                $newData = HomeController::searchWith($user, 'dapil');
            } else if ($where['jenis_pemilihan'] === 'pdprd2') {
                $newData = HomeController::searchWith($user, 'kabupaten_kota');
            }
        } else if ($lastField === 'dapil') {
            if ($where['jenis_pemilihan'] === 'pdpr' || $where['jenis_pemilihan'] === 'pdprd1') {
                $newData = HomeController::searchWith($user, 'kabupaten_kota');
            } else {
                $newData = HomeController::searchWith($user, 'kecamatan');
            }
        }

        return [
            // 'data' => $lastField,
            'data' => $newData,
            // 'coloumn' => []
            'coloumn' => array_keys($newData[1])
        ];
    }


    public function searchWith($user, $filter = '')
    {
        $data = [];
        if ($filter === '') {
            foreach ($user as $u) {
                $name = $u->nama_calon;
                $tps = (int) $u->tps;
                $suara = $u->perolehan_suara;
                $id = $u->nomor_calon;
                $data[$id]['nama-calon'] = $name;
                $data[$id]['tps-' . $tps] = $suara;
            }
        } else {
            $grupBig = $user->groupBy($filter);
            foreach ($grupBig as $grupSmall) {
                $grupByCalon = $grupSmall->groupBy('nama_calon');
                foreach ($grupByCalon as $calon) {
                    $id = $calon[0]['nomor_calon'];
                    $name = $calon[0]['nama_calon'];
                    $coloumn = $calon[0][$filter];
                    $totalSuara = 0;
                    foreach ($calon as $c) {
                        $totalSuara += $c['perolehan_suara'];
                    }
                    $data[$id]['nama-calon'] = $name;
                    $data[$id][$coloumn] = $totalSuara;
                }
            }
        }
        return $data;
    }
}
