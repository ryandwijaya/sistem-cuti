@extends('backend/layouts/main')

@section('judul_halaman','Pegawai')

@section('konten')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-muted text-light">
                    <h4 class="card-title float-left">Data Pegawai</h4>
                    <button class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target=".bs-example-modal-center"><i class="fa fa-plus"></i> Data Pegawai</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 60px;">No</th>
                                <th>Nama Pegawai</th>
                                <th class="text-center">NIP</th>
                                <th class="text-center">Jabatan</th>
                                <th class="text-center"><i class="fa fa-cogs"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pegawai as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->pegawai_nama }}</td>
                                    <td class="text-center">{{ $item->pegawai_nip }}</td>
                                    <td class="text-center">{{ $item->pegawai_jabatan }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button> |
                                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
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

    <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Tambah Data Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ action('backend\PegawaiController@store')  }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Nama Pegawai</label>
                            <input type="text" class="form-control" name="nama" required placeholder="Masukkan nama pegawai">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" required placeholder="Masukkan email pegawai">
                        </div>
                        <div class="form-group">
                            <label>NIP</label>
                            <input type="text" class="form-control" name="nip" placeholder="Kosongkan jika tidak ada">
                        </div>
                        <div class="form-group">
                            <label>Jabatan</label>
                            <input type="text" class="form-control" name="jabatan" placeholder="Masukkan Jabatan">
                        </div>
                        <div class="form-group">
                            <label>Level Akun</label>
                            <select name="level" class="form-control">
                                <option value="pegawai">Pegawai</option>
                                <option value="kepala">Kepala</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                        <button class="btn btn-success float-right">Simpan</button>

                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div>
@endsection
