@extends('layout.main')

@section('content')
    <x-breadcrumb
    :values="[__('Surat Perintah Perjalanan Dinas'), __('Luar Daerah')]">
      
        {{-- <a href="{{ route('sppd.foreign.export') }}" class="btn btn-success">
            <i class="bx bx-export"></i> Export Excel
        </a> --}}
    </x-breadcrumb>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">SPPD Luar Daerah</h5>
            <div>
                <a href="{{ route('sppd.foreign.export') }}" class="btn btn-success">
                    <i class="bx bx-export"></i> Export Excel
                </a>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSppdModal">
                    <i class="bx bx-plus"></i> Buat SPPD Baru
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. Surat</th>
                            <th>Tanggal</th>
                            <th>Perihal</th>
                            <th>Nama yang Ditugaskan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sppds as $index => $sppd)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $sppd->nomor_sppd }}</td>
                            <td>{{ $sppd->tanggal->format('d/m/Y') }}</td>
                            <td>{{ $sppd->perihal }}</td>
                            <td>{{ $sppd->nama_yang_bertugas }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('sppd.foreign.print', $sppd->id) }}" 
                                       class="btn btn-sm btn-info" target="_blank">
                                        <i class="bx bx-printer"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-warning"
                                            onclick="editSppd({{ $sppd->id }})">
                                        <i class="bx bx-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger"
                                            onclick="deleteSppd({{ $sppd->id }})">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Buat SPPD -->
    <div class="modal fade" id="createSppdModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat SPPD Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="sppdForm" action="{{ route('sppd.foreign.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Perihal</label>
                            <input type="text" class="form-control" name="perihal" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Surat</label>
                            <input type="text" class="form-control" name="nomor_spt" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama yang Bertugas</label>
                            <input type="text" class="form-control" name="nama_yang_bertugas" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Berangkat</label>
                                <input type="date" class="form-control" name="tanggal_berangkat" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Kembali</label>
                                <input type="date" class="form-control" name="tanggal_kembali" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lampiran</label>
                            <input type="file" class="form-control" name="attachments[]" multiple>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="sppdForm" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('#sppdForm').submit(function(e) {
            e.preventDefault();
            
            let tanggalBerangkat = new Date($('input[name="tanggal_berangkat"]').val());
            let tanggalKembali = new Date($('input[name="tanggal_kembali"]').val());
            
            if (tanggalKembali < tanggalBerangkat) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Tanggal kembali tidak boleh lebih awal dari tanggal berangkat!',
                    customClass: {
                        container: 'my-swal'
                    }
                });
                return false;
            }

            let formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500,
                            customClass: {
                                container: 'my-swal'
                            }
                        }).then(() => {
                            $('#createSppdModal').modal('hide');
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message,
                            customClass: {
                                container: 'my-swal'
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    let errorMessage = 'Terjadi kesalahan saat menyimpan data';
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: errorMessage,
                        customClass: {
                            container: 'my-swal'
                        }
                    });
                }
            });
        });

        // Reset form ketika modal ditutup
        $('#createSppdModal').on('hidden.bs.modal', function () {
            $('#sppdForm')[0].reset();
        });
    });

    function deleteSppd(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                container: 'my-swal'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/sppd/foreign/${id}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if(response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: 'Data berhasil dihapus.',
                                showConfirmButton: false,
                                timer: 1500,
                                customClass: {
                                    container: 'my-swal'
                                }
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Gagal menghapus data',
                                customClass: {
                                    container: 'my-swal'
                                }
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan saat menghapus data',
                            customClass: {
                                container: 'my-swal'
                            }
                        });
                    }
                });
            }
        });
    }
</script>
@endpush 