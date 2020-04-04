@extends('backend/layouts/main')

@section('judul_halaman','Pengajuan Cuti')

@section('konten')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-muted text-light">
                    <h4 class="card-title float-left">Form Pengajuan Cuti</h4>
                </div>
                <div class="card-body">
                    @if($status == 'enable')
                        <form action="{{ url('cuti/ajukan') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label>Nama Pegawai</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="hidden" value="{{ Auth::user()->id_pegawai }}" name="id_pegawai">
                                    <input type="text" class="form-control" name="nama" value="{{ Auth::user()->name }}"
                                           readonly placeholder="Masukkan nama pegawai">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label>Jenis Cuti</label>
                                </div>
                                <div class="col-md-10">
                                    <select name="jenis" class="form-control" id="jenis-cuti" required>
                                        <option disabled selected>- Pilih Jenis Cuti -</option>
                                        <option>Cuti Tahunan</option>
                                        <option>Cuti Sakit</option>
                                        <option>Cuti Karena Alasan Penting</option>
                                        <option>Cuti Besar</option>
                                        <option>Cuti Melahirkan</option>
                                        <option>Cuti di Luar Tanggungan Negara</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" id="lampiran" style="display: none;">
                                <div class="col-md-2">
                                    <label>Lampiran</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="file" name="lampiran" class="dropify">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label>Alasan Cuti</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea name="alasan" class="form-control" placeholder="Masukkan Alasan Cuti"
                                              required></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label>Lama / Durasi Cuti</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" min="1" id="durasi" name="durasi" class="form-control"
                                           placeholder="Lama Cuti" required>
                                </div>
                                <span class="mt-3">Hari</span>

                                <div class="col-md-1 ml-5">Mulai Tanggal</div>
                                <div class="col-md-2">
                                    <input type="date" name="tgl_mulai" class="form-control" required>
                                </div>
                                -
                                <div class="col-md-2">
                                    <input type="date" name="tgl_selesai" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label>Alamat Selama Cuti</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea name="alamat_cuti" class="form-control"
                                              placeholder="Masukkan alamat selama menjalankan cuti" required></textarea>
                                </div>
                            </div>
                            <button class="btn btn-success float-right"
                                    onclick="confirm('Apakah anda yakin ingin mengajukan cuti?')">Ajukan
                            </button>

                        </form>
                    @else
                        <h4 class="text-warning">Kamu Telah Melakukan Pengajuan Cuti</h4>
                        <h5>Silahkan Tunggu Untuk Dikonfirmasi !</h5>
                        <h6>Data Pengajuan :</h6>
                        <table cellpadding="5">
                            <tr>
                                <td>Jenis Cuti</td>
                                <td>:</td>
                                <td>{{ $pengajuan->cuti_jenis }}</td>
                            </tr>
                            <tr>
                                <td>Alasan Cuti</td>
                                <td>:</td>
                                <td>{{ $pengajuan->cuti_alasan }}</td>
                            </tr>
                            <tr>
                                <td>Cuti Mulai</td>
                                <td>:</td>
                                <td>{{ $pengajuan->cuti_tgl_mulai }}</td>
                            </tr>
                            <tr>
                                <td>Cuti Selesai</td>
                                <td>:</td>
                                <td>{{ $pengajuan->cuti_tgl_selesai }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td><span class="badge badge-warning">{{ $pengajuan->cuti_status_pengajuan }}</span>
                                </td>
                            </tr>
                        </table>

                        <a href="{{ url('cuti/cancel') }}/{{ $pengajuan->cuti_id }}"
                           onclick="confirm('Yakin ingin membatalkan pengajuan ini?')"
                           class="float-right btn btn-danger btn-sm">Batalkan</a>

                    @endif

                </div>
            </div>
        </div>
    </div>



@endsection
