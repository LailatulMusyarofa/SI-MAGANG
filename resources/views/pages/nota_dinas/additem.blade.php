<x-app-layout pageTitle="Tambah Peserta Nota Dinas">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-arrows breadcrumb-muted">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('nota_dinas.daftar') }}">Nota Dinas Magang</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('nota_dinas.edit', ['id' => $notaDinas->id]) }}">Edit Nota Dinas</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('nota_dinas.additem', ['id' => $notaDinas->id]) }}">Tambah Peserta Magang</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('nota_dinas.storeitem', ['id' => $notaDinas->id]) }}" method="POST">
                @csrf

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Pilih Peserta</h3>
                        <button type="submit" class="btn btn-primary">
                            <span class="mdi mdi-content-save"> Simpan</span>
                        </button>
                    </div>

                    <div class="card-body">
                        @if($pesertaMaster->isEmpty())
                            <p class="text-muted">Tidak ada peserta yang tersedia untuk ditambahkan.</p>
                        @else
                            <div class="form-group">
                                @foreach($pesertaMaster as $p)
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="master_psrt_ids[]"
                                            id="psrt{{ $p->id }}"
                                            value="{{ $p->id }}"
                                            {{ (is_array(old('master_psrt_ids')) && in_array($p->id, old('master_psrt_ids'))) ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="psrt{{ $p->id }}">
                                            {{ $p->nama_peserta }} - {{ $p->program_studi }} (NIS/NIM: {{ $p->nis_peserta }})
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
