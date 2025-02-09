@extends('layout.main')

@section('content')
<div class="container-fluid">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Surat Masuk</h5>
            <div>
                <a href="{{ route('transaction.incoming.export') }}" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
                <a href="{{ route('transaction.incoming.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Surat Masuk
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. Surat</th>
                            <th>Pengirim</th>
                            <th>Tanggal Surat</th>
                            <th>Tanggal Diterima</th>
                            <th>Perihal</th>
                            <th>Lampiran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($incomingLetters as $index => $letter)
                        <tr>
                            <td>{{ $incomingLetters->firstItem() + $index }}</td>
                            <td>{{ $letter->reference_number }}</td>
                            <td>{{ $letter->sender }}</td>
                            <td>{{ $letter->letter_date->format('d/m/Y') }}</td>
                            <td>{{ $letter->received_date->format('d/m/Y') }}</td>
                            <td>{{ $letter->description }}</td>
                            <td>
                                @foreach($letter->attachments as $attachment)
                                    <a href="{{ Storage::url($attachment->path) }}" target="_blank">
                                        <i class="fas fa-paperclip"></i> {{ $attachment->filename }}
                                    </a><br>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('transaction.incoming.edit', $letter->id) }}" 
                                   class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('transaction.incoming.destroy', $letter->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
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
            {{ $incomingLetters->links() }}
        </div>
    </div>
</div>
@endsection
