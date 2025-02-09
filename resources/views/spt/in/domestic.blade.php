@extends('layout.main')

@section('content')
    <x-breadcrumb
    :values="[__('Surat Perintah Tugas'), __('Dalam Daerah')]">
    </x-breadcrumb>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">SPT Dalam Daerah</h5>
            <div>
                <a href="{{ route('spt.domestic.export') }}" class="btn btn-success">
                    <i class="bx bx-export"></i> Export Excel
                </a>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSptModal">
                    <i class="bx bx-plus"></i> Buat SPT Baru
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
                        @forelse($spts as $index => $spt)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $spt->nomor_spt }}</td>
                            <td>{{ $spt->tanggal->format('d/m/Y') }}</td>
                            <td>{{ $spt->perihal }}</td>
                            <td>{{ $spt->employee->nama }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('spt.domestic.print', $spt->id) }}" 
                                       class="btn btn-sm btn-info" target="_blank">
                                        <i class="bx bx-printer"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-warning"
                                            onclick="editSpt({{ $spt->id }})">
                                        <i class="bx bx-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger"
                                            onclick="deleteSpt({{ $spt->id }})">
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

    <!-- Modal Create SPT -->
    <div class="modal fade" id="createSptModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat SPT Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="sptForm" action="{{ route('spt.domestic.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pegawai</label>
                                <select class="form-select" name="employee_id" required>
                                    <option value="">Pilih Pegawai</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Perihal</label>
                            <textarea class="form-control" name="perihal" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lampiran</label>
                            <input type="file" class="form-control" name="attachments[]" multiple>
                            <small class="text-muted">Format: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 2MB)</small>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit SPT -->
    <div class="modal fade" id="editSptModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit SPT</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editSptForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" id="editTanggal" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pegawai</label>
                                <select class="form-select" name="employee_id" id="editEmployeeId" required>
                                    <option value="">Pilih Pegawai</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Perihal</label>
                            <textarea class="form-control" name="perihal" id="editPerihal" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lampiran Baru</label>
                            <input type="file" class="form-control" name="attachments[]" multiple>
                            <small class="text-muted">Format: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 2MB)</small>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        // Handle form submission
        $('#sppdForm').on('submit', function(e) {
            e.preventDefault();
            
            let formData = new FormData(this);
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            $('#createSptModal').modal('hide');
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
                error: function(xhr) {
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

        // Reset form when modal is closed
        $('#createSptModal').on('hidden.bs.modal', function () {
            $('#sppdForm')[0].reset();
        });
    });

    function editSpt(id) {
        $.get(`/spt/domestic/${id}/edit`, function(data) {
            $('#editSptModal').modal('show');
            $('#editSptForm').attr('action', `/spt/domestic/${id}`);
            $('#editTanggal').val(data.tanggal);
            $('#editPerihal').val(data.perihal);
            $('#editEmployeeId').val(data.employee_id);
        });
    }

    function deleteSpt(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/spt/domestic/${id}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if(response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function() {
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
</script>
@endpush 