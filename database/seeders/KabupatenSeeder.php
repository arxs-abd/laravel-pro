<?php

namespace Database\Seeders;

use App\Models\KabupatenKotaModel;
use App\Models\ProvinsiModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KabupatenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        set_time_limit(300);
        $provinsi = ProvinsiModel::all();
        $kabupatenSemua = DB::table('user')->distinct('kabupaten_kota')->where(['provinsi' => 'ACEH'])->get('kabupaten_kota');
        foreach ($kabupatenSemua as $kabupaten) {
            // DB::table('kabupaten_kota')->insert([
            //     'id_provinsi' => 1,
            //     'kabupaten_kota' => $kabupaten->kabupaten_kota,
            // ]);
            KabupatenKotaModel::create([
                'id_provinsi' => 1,
                'kabupaten_kota' => $kabupaten->kabupaten_kota,
            ]);
        }
    }
}
