<x-app-layout pageTitle="Lupa Password">

    <div class="d-flex flex-column justify-content-center align-items-center vh-100 bg-login">

        <div class="text-center mb-2" style="line-height: 1.1;">
            <h1 class="fs-3 fs-md-1 mb-0">SIMA KOMINFO</h1>
            <h1 class="fs-3 fs-md-1 mt-0">JATIM</h1>
        </div>

        <div class="card w-100" style="max-width: 350px; border-radius: 0;">
            <div class="card-body">
                <h4 class="text-center mb-4">Masukkan Email Anda</h4>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3 position-relative">
                        <input type="email" name="email" class="form-control @error('email') is-invalid is-invalid-lite @enderror" 
                            placeholder="Email" required autofocus value="{{ old('email') }}">
                        <span class="mdi mdi-email position-absolute" style="top: 50%; right: 12px; 
                            transform: translateY(-50%); font-size: 20px; color: #6c757d;"></span>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Kirim Link Reset Password</button>

                    <div class="mt-3 text-center">
                        <a href="{{ route('login') }}">Kembali ke Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .bg-login {
            background-color: #ccd1d9;
        }
    </style>
    @endpush

</x-app-layout>
