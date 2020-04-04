<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CutiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pengajuan(Request $request)
    {
        $check_pengajuan = DB::table('data_cuti')
            ->where('cuti_pegawai','=',$request->user()->id_pegawai)
            ->where('cuti_status_pengajuan','=','menunggu')
            ->count();
        if ($check_pengajuan != 1){
            $data['status'] = 'enable';
            return view('backend/cuti/form_pengajuan',$data);
        }else{
            $data['status'] = 'disable';
            $data['pengajuan'] = DB::table('data_cuti')
                ->where('cuti_pegawai','=',$request->user()->id_pegawai)
                ->where('cuti_status_pengajuan','=','menunggu')
                ->first();;
            return view('backend/cuti/form_pengajuan',$data);
        }
    }
    public function ajukan(Request $request)
    {
        DB::table('data_cuti')->insert([
            'cuti_pegawai' => $request->id_pegawai,
            'cuti_jenis' => $request->jenis,
            'cuti_alasan' => $request->alasan,
            'cuti_durasi' => $request->durasi,
            'cuti_tgl_mulai' => $request->tgl_mulai,
            'cuti_tgl_selesai' => $request->tgl_selesai,
            'cuti_alamat' => $request->alamat_cuti,
        ]);

        $request->session()->flash('alert', ' Menyimpan Data');
        return redirect('/backend/cuti/pengajuan');
    }
    public function riwayat(Request $request)
    {
        $data['riwayat'] = DB::table('data_cuti')
            ->where('cuti_pegawai','=',$request->user()->id_pegawai)
            ->leftJoin('pegawai', 'pegawai.pegawai_id', '=', 'data_cuti.cuti_pegawai')
            ->get();
        return view('backend/cuti/riwayat',$data);
    }

    public function detail()
    {
        $cuti_id = (int)$_GET['id'];
        $data['detail'] = DB::table('data_cuti')
            ->where('cuti_id','=',$cuti_id)
            ->leftJoin('pegawai', 'pegawai.pegawai_id', '=', 'data_cuti.cuti_pegawai')
            ->first();
        return view('backend/cuti/detail_surat',$data);
    }
}
