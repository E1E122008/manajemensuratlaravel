@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="[__('menu.transaction.menu'), __('menu.transaction.outgoing_letter')]">
    </x-breadcrumb>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('menu.transaction.outgoing_letter') }}</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createOutgoingLetterModal">
                <i class="bx bx-plus"></i> Surat Keluar Baru
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Surat Keluar</th>
                            <th>Perihal</th>
                            <th>Nomor Surat</th>
                            <th>Dikeluarkan Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($outgoingLetters as $index => $letter)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $letter->letter_date->format('d/m/Y') }}</td> <!-- Assuming letter_date is the date of the outgoing letter -->
                                <td>{{ $letter->description }}</td> <!-- Assuming description is the perihal -->
                                <td>{{ $letter->reference_number }}</td> <!-- Assuming reference_number is the nomor surat -->
                                <td>{{ $letter->issued_by }}</td> <!-- Assuming issued_by is the field for dikeluarkan oleh -->
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('transaction.outgoing.edit', $letter) }}">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="deleteOutgoingLetter({{ $letter->id }})">
                                                <i class="bx bx-trash me-1"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">{{ __('menu.general.empty') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Buat Surat Keluar -->
    <div class="modal fade" id="createOutgoingLetterModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Surat Keluar Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="outgoingLetterForm" action="{{ route('transaction.outgoing.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nomor Surat</label>
                            <input type="text" class="form-control" name="reference_number" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Perihal</label>
                            <input type="text" class="form-control" name="description" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dikeluarkan Oleh</label>
                            <input type="text" class="form-control" name="issued_by" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Surat</label>
                            <input type="date" class="form-control" name="letter_date" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lampiran</label>
                            <input type="file" class="form-control" name="attachments[]" multiple>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="outgoingLetterForm" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteOutgoingLetter(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                // Implementasi fungsi delete
            }
        }
    </script>
@endsection