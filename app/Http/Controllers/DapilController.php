<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DapilController extends Controller
{
    //
    public function pdpr()
    {
        return DB::table('dapil_pdpr')->get();
    }
    public function pdprd1($id)
    {
        return DB::table('dapil_pdprd1')->where(['id_pdprd1' => $id])->get();
    }
    public function pdprd2($id)
    {
        return DB::table('new_dapil_pdprd2')->where(['id_pdprd2' => $id])->get();
    }
}
