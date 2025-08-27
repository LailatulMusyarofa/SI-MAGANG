<x-app-layout pageTitle="Detail Peserta Magang">
    <div class="container py-4 px-4 rounded bg-light shadow-sm" style="max-width: 800px; background-color: #f1f5f9;">
        <h3 class="fw-bold mb-4">Daftar Peserta Magang</h3>

        {{-- Nama Lembaga --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lembaga Pendidikan</label>
            <div class="form-control bg-white">{{ $item->nama_lembaga }}</div>
        </div>

        {{-- Data Lembaga --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Data Lembaga Pendidikan</label>
            <div class="form-control bg-white">
                {{ $item->alamat }}<br>
                {{ $item->telepon }}<br>
                {{ $item->email }}
            </div>
        </div>

        {{-- Narahubung --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Narahubung</label>
            <div class="form-control bg-white">
                {{ $item->narahubung }}<br>
                {{ $item->jenis_kelamin }}<br>
                {{ $item->jabatan }}<br>
                {{ $item->no_hp }}
            </div>
        </div>

        {{-- Status Administrasi --}}
        <div class="mb-4">
            <label class="form-label fw-semibold">Status Administrasi</label>
            <div class="p-3 border rounded bg-white">

                @php
                    $steps = [
                        'Pengajuan',
                        'Verifikasi Berkas',
                        'Persetujuan Pimpinan',
                        'Penempatan',
                        'Surat Tugas',
                        'Evaluasi & Sertifikat',
                    ];

                    $status = strtolower($item->status_pengajuan); // sukses, proses, belum diproses
                    $statusIndex = match ($status) {
                        'sukses' => 6,
                        'proses' => 5,
                        'belum diproses' => 1,
                        default => 0,
                    };

                    $badgeClass = function ($index) use ($statusIndex) {
                        if ($index < $statusIndex) {
                            return 'bg-success';
                        }
                        if ($index == $statusIndex) {
                            return 'bg-warning';
                        }
                        return 'bg-danger';
                    };
                @endphp

                <ul class="list-unstyled m-0 p-0 position-relative ps-4">
                    @foreach ($steps as $i => $step)
                        <li class="d-flex align-items-start mb-3 position-relative">
                            <div class="position-relative me-2">
                                <span class="rounded-circle {{ $badgeClass($i + 1) }}"
                                    style="width: 16px; height: 16px; display: inline-block;"></span>
                                @if ($i < count($steps) - 1)
                                    <div
                                        style="width: 2px; height: 40px; background: #ccc; position: absolute; top: 16px; left: 7px;">
                                    </div>
                                @endif
                            </div>
                            <span>{{ $step }}</span>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-4">
                    <small class="fw-semibold">Status Tahapan:</small>
                    <ul class="list-inline mt-2">
                        <li class="list-inline-item">
                            <span class="badge bg-success rounded-circle" 
                                  style="width: 20px; height: 20px; display: inline-block; vertical-align: middle;"></span>
                            Sukses
                        </li>
                        <li class="list-inline-item">
                            <span class="badge bg-warning rounded-circle" 
                                  style="width: 20px; height: 20px; display: inline-block; vertical-align: middle;"></span>
                            Proses
                        </li>
                        <li class="list-inline-item">
                            <span class="badge bg-danger rounded-circle" 
                                  style="width: 20px; height: 20px; display: inline-block; vertical-align: middle;"></span>
                            Belum Diproses
                        </li>
                    </ul>
                    
                    
                </div>
            </div>
        </div>

        <a href="{{ route('master_administrasi') }}" class="btn btn-primary">Kembali</a>
    </div>
</x-app-layout>
