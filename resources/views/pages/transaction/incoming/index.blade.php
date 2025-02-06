@extends('layout.main')

@section('content')
    <x-breadcrumb
        :values="[__('menu.transaction.menu'), __('menu.transaction.incoming_letter')]">
    </x-breadcrumb>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('menu.transaction.incoming_letter') }}</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createIncomingLetterModal">
                <i class="bx bx-plus"></i> Surat Masuk Baru
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Agenda</th>
                            <th>Nomor Surat</th>
                            <th>Pengirim</th>
                            <th>Tanggal Surat</th>
                            <th>Tanggal Diterima</th>
                            <th>Perihal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($incomingLetters as $letter)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $letter->nomor_agenda }}</td>
                                <td>{{ $letter->nomor_surat }}</td>
                                <td>{{ $letter->pengirim }}</td>
                                <td>{{ $letter->tanggal_surat }}</td>
                                <td>{{ $letter->tanggal_diterima }}</td>
                                <td>{{ $letter->perihal }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('transaction.incoming.edit', $letter) }}">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="deleteIncomingLetter({{ $letter->id }})">
                                                <i class="bx bx-trash me-1"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Buat Surat Masuk -->
    <div class="modal fade" id="createIncomingLetterModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Surat Masuk Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="incomingLetterForm" action="{{ route('transaction.incoming.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nomor Agenda</label>
                            <input type="text" class="form-control" name="agenda_number" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Surat</label>
                            <input type="text" class="form-control" name="reference_number" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dari</label>
                            <input type="text" class="form-control" name="from" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Surat</label>
                            <input type="date" class="form-control" name="letter_date" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Diterima</label>
                            <input type="date" class="form-control" name="received_date" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Perihal</label>
                            <textarea class="form-control" name="perihal" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lampiran</label>
                            <input type="file" class="form-control" name="attachments[]" multiple>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Disposisi</label>
                            <textarea class="form-control" name="disposition"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="incomingLetterForm" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteIncomingLetter(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                // Implementasi fungsi delete
            }
        }
    </script>
@endsection
