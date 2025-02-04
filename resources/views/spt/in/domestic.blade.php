@extends('layout.main')

@section('content')
    <x-breadcrumb
    :values="[__('Surat Perintah Tugas'), __('Dalam Daerah')]">
    </x-breadcrumb>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">SPT Dalam Daerah</h5>
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
                            <th>Perihal</th>
                            <th>Nomor Surat</th>
                            <th>Nama yang Bertugas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse($spts as $index => $spt)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $spt->tanggal->format('d/m/Y') }}</td>
                            <td>{{ $spt->perihal }}</td>
                            <td>{{ $spt->nomor_surat }}</td>
                            <td>{{ $spt->nama_yang_bertugas }}</td>
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
                            <td colspan="6" class="text-center">Tidak ada data</td>
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
                    <h5 class="modal-title">Buat SPT Dalam Daerah Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="sptForm" action="{{ route('spt.domestic.store') }}" method="POST" enctype="multipart/form-data">
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
                            <input type="text" class="form-control" name="nomor_surat" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama yang Bertugas</label>
                            <input type="text" class="form-control" name="nama_yang_bertugas" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lampiran</label>
                            <input type="file" class="form-control" name="attachments[]" multiple>
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
        // Validasi form sebelum submit
        $('#sptForm').submit(function(e) {
            // Add any necessary validation here
        });
    });

    function editSpt(id) {
        // Implementasi fungsi edit
    }

    function deleteSpt(id) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            // Implementasi fungsi delete
        }
    }
</script>
@endpush 