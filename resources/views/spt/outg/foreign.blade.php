@extends('layout.main')

@section('content')
    <x-breadcrumb
    :values="[__('Surat Perintah Tugas'), __('Luar Daerah')]">
    </x-breadcrumb>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">SPT Luar Daerah</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSptModal">
                <i class="bx bx-plus"></i> Buat SPT Baru
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nomor SPT</th>
                            <th>Pegawai</th>
                            <th>Tujuan</th>
                            <th>Keperluan</th>
                            <th>Lama Tugas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse($spts as $index => $spt)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $spt->tanggal->format('d/m/Y') }}</td>
                            <td>{{ $spt->nomor_spt }}</td>
                            <td>{{ $spt->employee->nama ?? '-' }}</td>
                            <td>{{ $spt->tujuan }}</td>
                            <td>{{ $spt->keperluan }}</td>
                            <td>{{ $spt->lama_tugas }} hari</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="editSpt({{ $spt->id }})">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="deleteSpt({{ $spt->id }})">
                                            <i class="bx bx-trash me-1"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Buat SPT -->
    <div class="modal fade" id="createSptModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat SPT Luar Daerah Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="sptForm" action="{{ route('spt.foreign.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nomor SPT</label>
                                <input type="text" class="form-control" name="nomor_spt" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pegawai yang Bertugas</label>
                            <select class="form-select" name="pegawai_id" required>
                                <option value="">Pilih Pegawai</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->nama }} - {{ $employee->nip }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tujuan</label>
                            <input type="text" class="form-control" name="tujuan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keperluan</label>
                            <textarea class="form-control" name="keperluan" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lama Tugas (Hari)</label>
                            <input type="number" class="form-control" name="lama_tugas" required min="1">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="sptForm" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('#sptForm').submit(function(e) {
            e.preventDefault();
            
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
                        $('#createSptModal').modal('hide');
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'SPT Luar Daerah berhasil dibuat',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan: ' + response.message
                        });
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '';
                    
                    for(let key in errors) {
                        errorMessage += errors[key][0] + '\n';
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan:\n' + errorMessage
                    });
                }
            });
        });
    });

    function deleteSpt(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data SPT akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('spt/foreign') }}/${id}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if(response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'SPT berhasil dihapus',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan: ' + response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan saat menghapus data'
                        });
                    }
                });
            }
        });
    }

    // Reset form saat modal ditutup
    $('#createSptModal').on('hidden.bs.modal', function () {
        $('#sptForm').trigger('reset');
    });
</script>
@endpush 