@extends('backend/layouts/main')

@section('judul_halaman','Data Pengajuan Cuti')

@section('konten')
    <style>
        p{
            margin: 0;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-muted text-light">
                    <h4 class="card-title float-left">Surat Pengajuan Cuti</h4>
                </div>
                <div class="card-body p-5">
                    <div class="row justify-content-end">
                        <div class="col-md-4">
                            <p>Pekanbaru, ...... Desember 2020</p>
                            <p>Kepada</p>
                            <p style="margin-left: -27px">Yth. Kepala Badan Pendapatan Daerah</p>
                            <p>Provinsi Riau</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 text-center">
                            <h4>FORMULIR PERMINTAAN DAN PEMBERIAN CUTI</h4>
                        </div>
                    </div>
                    <div class="row">
                        <table width="100%" border="1">
                            <tr>
                                <th colspan="4">I. DATA PEGAWAI</th>
                            </tr>
                            <tr>
                                <td style="width: 130px;">Nama</td>
                                <td>{{ $detail->pegawai_nama }}</td>
                                <td style="width: 130px;">NIP</td>
                                <td>{{ $detail->pegawai_nip }}</td>
                            </tr>
                            <tr>
                                <td style="width: 130px;">Jabatan</td>
                                <td>{{ $detail->pegawai_jabatan }}</td>
                                <td style="width: 130px;">Masa Kerja</td>
                                <td> </td>
                            </tr>
                            <tr>
                                <td style="width: 130px;">Unit Kerja</td>
                                <td colspan="3">{{ $detail->pegawai_jabatan }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <table width="100%" border="1">
                            <tr>
                                <th colspan="4">II. JENIS CUTI YANG DIAMBIL</th>
                            </tr>
                            <tr>
                                <td style="width: 300px;">Cuti Tahunan</td>
                                <td> </td>
                                <td style="width: 300px;">Cuti Besar</td>
                                <td> </td>
                            </tr>
                            <tr>
                                <td style="width: 300px;">Cuti Sakit</td>
                                <td> </td>
                                <td style="width: 300px;">Cuti Melahirkan</td>
                                <td> </td>
                            </tr>
                            <tr>
                                <td style="width: 300px;">Cuti Karena Alasan Penting</td>
                                <td> </td>
                                <td style="width: 300px;">Cuti di Luar Tanggungan Negara</td>
                                <td> </td>
                            </tr>
                        </table>
                    </div>

                    <div class="row mt-4">
                        <table width="100%" border="1">
                            <tr>
                                <th colspan="4">III. ALASAN CUTI</th>
                            </tr>
                            <tr>
                                <td colspan="4">{{ $detail->cuti_alasan }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="row mt-4">
                        <table width="100%" border="1">
                            <tr>
                                <th colspan="4">IV. LAMANYA CUTI</th>
                            </tr>
                            <tr>
                                <td width="15%">Selama</td>
                                <td width="40%">{{ $detail->cuti_durasi }} Hari</td>
                                <td width="15%">Mulai Tanggal</td>
                                <td width="40%">{{ date_indo($detail->cuti_tgl_mulai) }} - {{ date_indo($detail->cuti_tgl_selesai) }} </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


<?php
function date_indo($tgl)
{
    $ubah = gmdate($tgl, time()+60*60*8);
    $pecah = explode("-",$ubah);
    $tanggal = $pecah[2];
    $bulan = bulan($pecah[1]);
    $tahun = $pecah[0];
    return $tanggal.' '.$bulan.' '.$tahun;
}

function bulan($bln)
{
    switch ($bln)
    {
        case 1:
            return "Januari";
            break;
        case 2:
            return "Februari";
            break;
        case 3:
            return "Maret";
            break;
        case 4:
            return "April";
            break;
        case 5:
            return "Mei";
            break;
        case 6:
            return "Juni";
            break;
        case 7:
            return "Juli";
            break;
        case 8:
            return "Agustus";
            break;
        case 9:
            return "September";
            break;
        case 10:
            return "Oktober";
            break;
        case 11:
            return "November";
            break;
        case 12:
            return "Desember";
            break;
    }
}
?>
