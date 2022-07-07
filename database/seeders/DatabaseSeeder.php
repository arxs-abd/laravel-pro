<?php

namespace Database\Seeders;

use App\Models\KabupatenKotaModel;
use App\Models\KecamatanModel;
use App\Models\ProvinsiModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // DatabaseSeeder::dapilProvinsi('pdprd1');
        // DatabaseSeeder::dapilAKhir('pdprd2');
        // DatabaseSeeder::dapil_pdpr();
        // DatabaseSeeder::dapil_pdprd1();
        // DatabaseSeeder::kabupaten();

        set_time_limit(7200);
        $provinsi = ProvinsiModel::all();
        // $provinsi = ProvinsiModel::where(['id' => 27])->get();
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
                    $total++;
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
                // }
            }
            $no++;
            // echo '[' . $no . '. ' . $name . ' ' . $total .  '] ';
            dump('[' . $no . '. ' . $name . ' ' . $total .  '] ');
        }
    }

    public function dapil_pdpr()
    {
        set_time_limit(7200);
        $allProvinsi = ProvinsiModel::all();
        $no = 0;
        $totalKelurahan = 0;
        foreach ($allProvinsi as $provinsi) {
            $name = $provinsi->provinsi;
            $id = $provinsi->id;
            $subTotal = 0;
            $data = DB::table('user')->distinct('kabupaten_kota')->where(['jenis_pemilihan' => 'pdpr', 'provinsi' => $name])->get(['dapil', 'kabupaten_kota']);
            $newData = $data->groupBy('dapil');
            foreach ($newData as $dapil) {
                // dump($dapil[0]->dapil);
                $dapilProv = DB::table('dapil_pdpr')->where(['dapil' => $dapil[0]->dapil])->get();
                $id = $dapilProv[0]->id;
                foreach ($dapil as $d) {
                    DB::table('kabupaten_kota_pdpr_new')->where(['kabupaten_kota' => $d->kabupaten_kota])->update(['id_pdpr' => $id]);
                    $subTotal++;
                }
            }
            $no++;
            $totalKelurahan += $subTotal;
            echo '[' . $no . ' ' . $name . ' ' . $subTotal . ':' . $totalKelurahan . '] ';
        }
    }

    public function dapil_pdprd1()
    {
        // $allProvinsi = ProvinsiModel::all();
        set_time_limit(7200);
        $provinsi = ProvinsiModel::where(['id' => 11])->get();
        // $provinsi = ProvinsiModel::all();
        $no = 0;
        $totalKelurahan = 0;
        foreach ($provinsi as $prov) {
            $name = trim($prov->provinsi);
            $idProv = $prov->id;
            $jumlahKelurahan = 0;
            $kelurahanSemua = DB::table('user')->distinct('kecamatan')->where([
                'jenis_pemilihan' => 'pdprd1',
                'provinsi' => $name
                // ])->get(['kecamatan', 'kelurahan_desa']);
            ])->get(['dapil', 'kabupaten_kota', 'kecamatan', 'kelurahan_desa']);
            $kecamatanKabupaten = $kelurahanSemua->groupBy('kecamatan');
            foreach ($kecamatanKabupaten as $kec) {
                $dapilId = DB::table('dapil_pdprd1')->where([
                    'dapil' => $kec[0]->dapil,
                ])->get('id')->first()->id;
                $kabId = DB::table('kabupaten_kota_pdprd1')->where([
                    'kabupaten_kota' => $kec[0]->kabupaten_kota,
                    // 'id_provinsi' => $idProv
                    'id_pdprd1' => $dapilId
                ])->get('id')->first()->id;
                $kecamatan = $kec[0]->kecamatan;
                dump('', $kecamatan, $kec[0]->kabupaten_kota);
                $id = DB::table('kecamatan_pdprd1')->where([
                    'kecamatan' => $kecamatan,
                    'id_kabupaten_kota_pdprd1' => $kabId,
                ])->get('id')->first();
                // dd($id->id);
                foreach ($kec as $kelurahan) {
                    DB::table('kelurahan_desa_pdprd1')->insert([
                        'id_kecamatan_pdprd1' => $id->id,
                        'kelurahan_desa' => $kelurahan->kelurahan_desa,
                    ]);
                    $jumlahKelurahan++;
                }
            }
            $no++;
            $totalKelurahan += $jumlahKelurahan;
            echo '[' . $no . '. ' . $name . ' ' . $jumlahKelurahan . ':' . $totalKelurahan . '] ';
        }
    }
    // public function dapil_pdprd1()
    // {
    //     set_time_limit(7200);
    //     // $allProvinsi = ProvinsiModel::all();
    //     $allProvinsi = ProvinsiModel::where(['id' => '11'])->get();
    //     // $allProvinsi = ProvinsiModel::where(['id' => '27'])->get();
    //     $no = 0;
    //     $totalKelurahan = 0;
    //     foreach ($allProvinsi as $provinsi) {
    //         $name = $provinsi->provinsi;
    //         $idProv = $provinsi->id;
    //         $subTotal = 0;
    //         $data = DB::table('user')->distinct('kecamatan')->where(['jenis_pemilihan' => 'pdpr', 'provinsi' => $name])->get(['dapil', 'kecamatan', 'kabupaten_kota']);
    //         $newData = $data->groupBy('kabupaten_kota');
    //         foreach ($newData as $dapil) {
    //             $kabupaten = $dapil[0]->kabupaten_kota;
    //             $id = DB::table('kabupaten_kota_pdpr_new')->where(['kabupaten_kota' => $kabupaten, 'id_provinsi' => $idProv])->get('id')->first()->id;
    //             $oldId = DB::table('kabupaten_kota')->where(['kabupaten_kota' => $kabupaten, 'id_provinsi' => $idProv])->get('id')->first()->id;
    //             foreach ($dapil as $d) {
    //                 DB::table('kecamatan_pdpr')->where([
    //                     'kecamatan' => $d->kecamatan,
    //                     'id_kabupaten_kota' => $oldId,
    //                 ])->update([
    //                     'id_kabupaten_kota_pdpr' => $id,
    //                 ]);
    //                 $subTotal++;
    //             }
    //         }
    //         $no++;
    //         $totalKelurahan += $subTotal;
    //         echo '[' . $no . ' ' . $name . ' ' . $subTotal . ':' . $totalKelurahan . '] ';
    //     }
    // }

    public function kelurahan()
    {
        set_time_limit(7200);
        $provinsi = ProvinsiModel::all();
        $no = 0;
        $totalKelurahan = 0;
        foreach ($provinsi as $prov) {
            $name = trim($prov->provinsi);
            $jumlahKelurahan = 0;
            $kelurahanSemua = DB::table('user')->distinct('kecamatan')->where(['provinsi' => $name])->get(['kecamatan', 'kelurahan_desa']);
            $kecamatanKabupaten = $kelurahanSemua->groupBy('kecamatan');
            foreach ($kecamatanKabupaten as $kec) {
                $kecamatan = $kec[0]->kecamatan;
                $id = KecamatanModel::where(['kecamatan' => $kecamatan])->get('id')->first()['id'];
                foreach ($kec as $kelurahan) {
                    DB::table('kelurahan_desa')->insert([
                        'id_kecamatan' => $id,
                        'kelurahan_desa' => $kelurahan->kelurahan_desa,
                    ]);
                    $jumlahKelurahan++;
                }
            }
            $no++;
            $totalKelurahan += $jumlahKelurahan;
            echo '[' . $no . '. ' . $name . ' ' . $jumlahKelurahan . ':' . $totalKelurahan . '] ';
        }
    }


    public function kecamatan()
    {
        set_time_limit(7200);
        $provinsi = ProvinsiModel::where(['id' => 27])->get();
        // $provinsi = ProvinsiModel::all();
        $no = 0;
        $total = 0;
        foreach ($provinsi as $prov) {
            $name = trim($prov->provinsi);
            $kecamatanSemua = DB::table('user')->distinct('kecamatan')->where([
                'jenis_pemilihan' => 'pdprd1',
                'provinsi' => $name,
            ])->get(['kabupaten_kota', 'kecamatan']);
            $kabupatenProvinsi = $kecamatanSemua->groupBy('kabupaten_kota');
            $subTotal = 0;
            foreach ($kabupatenProvinsi as $kab) {
                $kabupaten = $kab[0]->kabupaten_kota;
                $id = DB::table('kabupaten_kota_pdprd1')->where(['kabupaten_kota' => $kabupaten])->get('id')->first()['id'];
                foreach ($kab as $kecamatan) {
                    DB::table('kecamatan_pdprd1')->insert([
                        'id_kabupaten_kota' => $id,
                        'kecamatan' => $kecamatan->kecamatan,
                    ]);
                    $subTotal++;
                }
            }
            $no++;
            $total += $subTotal;
            echo '[' . $no . '. ' . $name . ' ' . $subTotal . ':' . $total .  '] ';
        }
    }

    public function kabupaten()
    {
        set_time_limit(7200);
        $provinsi = ProvinsiModel::all();
        // $provinsi = ProvinsiModel::where(['id' => 27])->get();
        $no = 0;
        $total = 0;
        foreach ($provinsi as $prov) {
            $name = trim($prov->provinsi);
            $kabupatenSemua = DB::table('user')->distinct('kelurahan_desa')->where([
                'jenis_pemilihan' => 'pdprd1',
                'provinsi' => $name
            ])->get(['kabupaten_kota', 'kecamatan', 'dapil', 'kelurahan_desa']);
            $dapil = $kabupatenSemua->groupBy('dapil');
            // dump($dapil);
            foreach ($dapil as $kabupaten) {
                $idDapil = DB::table('dapil_pdprd1')->where([
                    'dapil' => $kabupaten[0]->dapil
                ])->get()->first()->id;
                foreach ($kabupaten as $res) {
                    $idKab = DB::table('kabupaten_kota_pdprd1')->where([
                        'id_provinsi' => $prov->id,
                        'id_pdprd1' => $idDapil,
                        'kabupaten_kota' => $res->kabupaten_kota
                    ])->get()->first()->id;
                    $idKec = DB::table('new_kecamatan_pdprd1')->where([
                        'id_provinsi' => $prov->id,
                        'id_kabupaten_kota' => $idKab,
                        'kecamatan' => $res->kecamatan
                    ])->get()->first()->id;
                    DB::table('new_kelurahan_desa_pdprd1')->insert([
                        'id_provinsi' => $prov->id,
                        'id_kabupaten_kota' => $idKab,
                        'id_kecamatan' => $idKec,
                        'kelurahan_desa' => $res->kelurahan_desa
                    ]);
                    $total++;
                }
            }
            $no++;
            // echo '[' . $no . '. ' . $name . ' ' . $total .  '] ';
            dump('[' . $no . '. ' . $name . ' ' . $total .  '] ');
        }
    }
    // public function kabupaten()
    // {
    //     set_time_limit(7200);
    //     $provinsi = ProvinsiModel::all();
    //     // $provinsi = ProvinsiModel::where(['id' => 27])->get();
    //     $no = 0;
    //     $total = 0;
    //     foreach ($provinsi as $prov) {
    //         $name = trim($prov->provinsi);
    //         $kabupatenSemua = DB::table('user')->distinct('kecamatan')->where([
    //             'jenis_pemilihan' => 'pdprd1',
    //             'provinsi' => $name
    //         ])->get(['kabupaten_kota', 'kecamatan', 'dapil']);
    //         $dapil = $kabupatenSemua->groupBy('dapil');
    //         // dd($dapil);
    //         foreach ($dapil as $kabupaten) {
    //             $idDapil = DB::table('dapil_pdprd1')->where([
    //                 'dapil' => $kabupaten[0]->dapil
    //             ])->get()->first()->id;
    //             foreach ($kabupaten as $res) {
    //                 $idKab = DB::table('kabupaten_kota_pdprd1')->where([
    //                     'id_provinsi' => $prov->id,
    //                     'id_pdprd1' => $idDapil,
    //                     'kabupaten_kota' => $res->kabupaten_kota
    //                 ])->get()->first()->id;
    //                 DB::table('new_kecamatan_pdprd1')->insert([
    //                     'id_provinsi' => $prov->id,
    //                     'id_kabupaten_kota' => $idKab,
    //                     'kecamatan' => $res->kecamatan
    //                 ]);
    //                 $total++;
    //             }
    //         }
    //         $no++;
    //         // echo '[' . $no . '. ' . $name . ' ' . $total .  '] ';
    //         dump('[' . $no . '. ' . $name . ' ' . $total .  '] ');
    //     }
    // }
    // public function kabupaten()
    // {
    //     set_time_limit(7200);
    //     // $provinsi = ProvinsiModel::all();
    //     $provinsi = ProvinsiModel::where(['id' => 27]);
    //     $no = 0;
    //     $total = 0;
    //     foreach ($provinsi as $prov) {
    //         $name = trim($prov->provinsi);
    //         $kabupatenSemua = DB::table('user')->distinct('kecamatan')->where(['provinsi' => $name])->get('kabupaten_kota', 'kecamatan');
    //         foreach ($kabupatenSemua as $kabupaten) {
    //             DB::table('kabupaten_kota')->insert([
    //                 'id_provinsi' => $prov->id,
    //                 'kabupaten_kota' => $kabupaten->kabupaten_kota,
    //             ]);
    //             $total++;
    //         }
    //         $no++;
    //         echo '[' . $no . '. ' . $name . ' ' . $total .  '] ';
    //     }
    // }
}
