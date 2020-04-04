@extends('backend/layouts/main')

@section('judul_halaman','Pengajuan Cuti')

@section('konten')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-muted text-light">
                    <h4 class="card-title float-left">Data Pengajuan Cuti</h4>
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
                                <th class="text-center">Jenis Cuti</th>
                                <th class="text-center">Alasan Cuti</th>
                                <th class="text-center">Lama Cuti</th>
                                <th class="text-center">status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pengajuan as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <?php
                                    $waktu = explode(' ',$item->cuti_date_created);
                                    ?>
                                    <td><a href="{{ url('backend/cuti/detail') }}?id={{ $item->cuti_id }}" target="_blank" style="font-weight: 800">{{ date_indo($waktu[0]) }}  <i class="ml-2 fa fa-clock"></i> {{ $waktu[1] }}</a></td>
                                    <td>
                                        <span style="font-weight: 700;">{{ $item->pegawai_nama }}</span>
                                        <p class="text-info">Nip. {{ $item->pegawai_nip }}</p>
                                    </td>
                                    <td class="text-center">{{ $item->cuti_jenis }}</td>
                                    <td class="text-center">{{ $item->cuti_alasan }}</td>
                                    <td class="text-center">{{ $item->cuti_durasi }}</td>

                                    <td class="text-center">
                                            @if($item->cuti_status_pengajuan == 'menunggu')
                                            <a href="{{ url('backend/cuti/aksi', [$item->cuti_id,1]) }}"  onclick="confirm('Tekan OK untuk melanjutkan !')" class="btn btn-sm btn-success" title="Terima"><i class="fa fa-check"></i></a>
                                            <a href="{{ url('backend/cuti/aksi', [$item->cuti_id,0]) }}" onclick="confirm('Tekan OK untuk melanjutkan !)" class="btn btn-sm btn-danger" title="Tolak"><i class="far fa-times-circle"></i></a>
                                            @else
                                                {{ $item->cuti_status_pengajuan }}
                                            @endif
                                    </td>
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
