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
        if ($request->user()->level == 'kepala'){
            $data['pengajuan'] = DB::table('data_cuti')
                ->leftJoin('pegawai', 'pegawai.pegawai_id', '=', 'data_cuti.cuti_pegawai')
                ->get();
            return view('backend/cuti/data_pengajuan', $data);
        }elseif($request->user()->level == 'pegawai'){
            $check_pengajuan = DB::table('data_cuti')
                ->where('cuti_pegawai', '=', $request->user()->id_pegawai)
                ->where('cuti_status_pengajuan', '=', 'menunggu')
                ->count();
            $check_cuti = DB::table('data_cuti')
                ->where('cuti_pegawai', '=', $request->user()->id_pegawai)
                ->where('cuti_status_pengajuan', '=', 'diterima')
                ->count();

            if ($check_pengajuan != 1) {
                if ($check_cuti == 1){
                    $data['status'] = 'running';
                    $data['pengajuan'] = DB::table('data_cuti')
                        ->where('cuti_pegawai', '=', $request->user()->id_pegawai)
                        ->where('cuti_status_pengajuan', '=', 'diterima')
                        ->first();
//                var_dump($data['pengajuan']);exit();
                    return view('backend/cuti/form_pengajuan', $data);
                }else{
                    $data['status'] = 'enable';
                    return view('backend/cuti/form_pengajuan', $data);
                }

            } else{
                $data['status'] = 'disable';
                $data['pengajuan'] = DB::table('data_cuti')
                    ->where('cuti_pegawai', '=', $request->user()->id_pegawai)
                    ->where('cuti_status_pengajuan', '=', 'menunggu')
                    ->first();
                return view('backend/cuti/form_pengajuan', $data);
            }
        }else{

        }

    }

    public function ajukan(Request $request)
    {
        $cek_jumlah = $this->check_jumlah_cuti();
        $cek_hari = $this->check_hari_cuti($request->id_pegawai, $request->jenis);

        if ($cek_jumlah <5){
            if ($request->jenis == 'Cuti Tahunan') {
                if ($cek_hari + $request->durasi <= 18) {
                    DB::table('data_cuti')->insert([
                        'cuti_pegawai' => $request->id_pegawai,
                        'cuti_jenis' => $request->jenis,
                        'cuti_alasan' => $request->alasan,
                        'cuti_durasi' => $request->durasi,
                        'cuti_tgl_mulai' => $request->tgl_mulai,
                        'cuti_tgl_selesai' => $request->tgl_selesai,
                        'cuti_alamat' => $request->alamat_cuti,
                    ]);
                } else {
                    var_dump('Jumlah hari cuti anda ' . ($cek_hari + $request->durasi) . ' Hari ( Melebihi )');
                    exit();
                }
            } else if ($request->jenis == 'Cuti Sakit') {
                if ($cek_hari + $request->durasi <= 3) {
                    $file1 = $request->file('lampiran');
                    DB::table('data_cuti')->insert([
                        'cuti_pegawai' => $request->id_pegawai,
                        'cuti_jenis' => $request->jenis,
                        'cuti_alasan' => $request->alasan,
                        'cuti_durasi' => $request->durasi,
                        'cuti_tgl_mulai' => $request->tgl_mulai,
                        'cuti_tgl_selesai' => $request->tgl_selesai,
                        'cuti_lampiran' => $request->id_pegawai . '-' . $file1->getClientOriginalName(),
                        'cuti_alamat' => $request->alamat_cuti,
                    ]);
                    $file1->move(public_path('lampiran'), $request->id_pegawai . '-' . $file1->getClientOriginalName());
                } else {
                    var_dump('Jumlah hari cuti anda ' . ($cek_hari + $request->durasi) . ' Hari ( Melebihi )');
                    exit();
                }
            } else if ($request->jenis == 'Cuti Karena Alasan Penting') {
                if ($cek_hari + $request->durasi <= 14) {
                    DB::table('data_cuti')->insert([
                        'cuti_pegawai' => $request->id_pegawai,
                        'cuti_jenis' => $request->jenis,
                        'cuti_alasan' => $request->alasan,
                        'cuti_durasi' => $request->durasi,
                        'cuti_tgl_mulai' => $request->tgl_mulai,
                        'cuti_tgl_selesai' => $request->tgl_selesai,
                        'cuti_alamat' => $request->alamat_cuti,
                    ]);
                } else {
                    var_dump('Jumlah hari cuti anda ' . ($cek_hari + $request->durasi) . ' Hari ( Melebihi )');
                    exit();
                }
            } else {
                DB::table('data_cuti')->insert([
                    'cuti_pegawai' => $request->id_pegawai,
                    'cuti_jenis' => $request->jenis,
                    'cuti_alasan' => $request->alasan,
                    'cuti_durasi' => $request->durasi,
                    'cuti_tgl_mulai' => $request->tgl_mulai,
                    'cuti_tgl_selesai' => $request->tgl_selesai,
                    'cuti_alamat' => $request->alamat_cuti,
                ]);
            }

            $request->session()->flash('alert', ' Menyimpan Data');
            return redirect('/backend/cuti/pengajuan');
        }else{
            var_dump('Jumlah Pegawai Cuti Sudah Maksimal');
        }


    }

    public function riwayat(Request $request)
    {
        $data['riwayat'] = DB::table('data_cuti')
            ->where('cuti_pegawai', '=', $request->user()->id_pegawai)
            ->leftJoin('pegawai', 'pegawai.pegawai_id', '=', 'data_cuti.cuti_pegawai')
            ->get();
        return view('backend/cuti/riwayat', $data);
    }

    public function cancel($id ,Request $request)
    {
        $data= DB::table('data_cuti')->where('cuti_id', '=', $id)->delete();
        $request->session()->flash('alert-wrong', ' Menghapus Data');
        return redirect('backend/cuti/pengajuan');
    }
    public function selesai($id ,Request $request)
    {
        DB::table('data_cuti')->where('cuti_id',$id)->update([
            'cuti_status_pengajuan' => 'selesai'
        ]);
        $request->session()->flash('alert', ' Memproses Data');
        return redirect('backend/cuti/pengajuan');
    }
    public function aksi($id ,$param,Request $request)
    {
        if ($param == 1){
            DB::table('data_cuti')->where('cuti_id',$id)->update([
                'cuti_status_pengajuan' => 'diterima'
            ]);
        }else{
            DB::table('data_cuti')->where('cuti_id',$id)->update([
                'cuti_status_pengajuan' => 'ditolak'
            ]);
        }
        $request->session()->flash('alert', ' Memproses Data');
        return redirect('backend/cuti/pengajuan');
    }

    public function detail()
    {
        $cuti_id = (int)$_GET['id'];
        $data['detail'] = DB::table('data_cuti')
            ->where('cuti_id', '=', $cuti_id)
            ->leftJoin('pegawai', 'pegawai.pegawai_id', '=', 'data_cuti.cuti_pegawai')
            ->first();
        return view('backend/cuti/detail_surat', $data);
    }

    function check_hari_cuti($pegawai, $jenis)
    {
        $data = DB::table('data_cuti')
            ->where('cuti_pegawai', '=', $pegawai)
            ->where('cuti_jenis', '=', $jenis)
            ->first();
        if ($data != NULL) {
            $hari = $data->cuti_durasi;
            return $hari;
        } else {
            return 0;
        }
    }
    function check_jumlah_cuti()
    {
        $jumlah_cuti = DB::table('data_cuti')
            ->where('cuti_status_pengajuan', '=', 'diterima')
            ->orWhere('cuti_status_pengajuan', '=','selesai')
            ->count();
        return $jumlah_cuti;
    }
}
