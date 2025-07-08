<x-app-layout pageTitle="Reset Password">

    <div class="d-flex flex-column justify-content-center align-items-center vh-100 bg-login">

        <div class="text-center mb-2" style="line-height: 1.1;">
            <h1 class="fs-3 fs-md-1 mb-0">SIMA KOMINFO</h1>
            <h1 class="fs-3 fs-md-1 mt-0">JATIM</h1>
        </div>

        <div class="card w-100" style="max-width: 350px; border-radius: 0;">
            <div class="card-body">
                <h4 class="text-center mb-4">Reset Password</h4>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ request()->email }}">

                    <div class="mb-3 position-relative">
                        <input type="password" name="password" placeholder="Password Baru" 
                            class="form-control @error('password') is-invalid is-invalid-lite @enderror" required autofocus>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 position-relative">
                        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" 
                            class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Reset Password</button>

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
