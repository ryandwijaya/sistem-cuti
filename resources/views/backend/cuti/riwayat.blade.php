@extends('backend/layouts/main')

@section('judul_halaman','Pegawai')

@section('konten')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-muted text-light">
                    <h4 class="card-title float-left">Data Riwayat Cuti</h4>
                    <button class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target=".bs-example-modal-center"><i class="fa fa-plus"></i> Data Pegawai</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 60px;">No</th>
                                <th>Tgl Mengajukan</th>
                                <th>Nama Pegawai</th>
                                <th class="text-center">Alasan Cuti</th>
                                <th class="text-center">Jenis Cuti</th>
                                <th class="text-center">Tgl Mulai</th>
                                <th class="text-center">Tgl Selesai</th>
                                <th class="text-center">status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($riwayat as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <?php
                                    $waktu = explode(' ',$item->cuti_date_created);
                                    ?>
                                    <td><a href="{{ url('backend/cuti/detail') }}?id={{ $item->cuti_id }}" target="_blank" style="font-weight: 800">{{ date_indo($waktu[0]) }}  <i class="ml-2 fa fa-clock"></i> {{ $waktu[1] }}</a></td>
                                    <td>{{ $item->pegawai_nama }}</td>
                                    <td class="text-center">{{ $item->cuti_alasan }}</td>
                                    <td class="text-center">{{ $item->cuti_jenis }}</td>
                                    <td class="text-center">{{ date_indo($item->cuti_tgl_mulai) }}</td>
                                    <td class="text-center">{{ date_indo($item->cuti_tgl_selesai) }}</td>
                                    <td class="text-center">{{ $item->cuti_status_pengajuan }}</td>
                                </tr>
                            @endforeach
                            </tbody>
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
