<x-app-layout pageTitle="Login">

    <div class="d-flex flex-column justify-content-center align-items-center vh-100 bg-login">

        <div class="text-center mb-2" style="line-height: 1.1;">
            <h1 class="fs-3 fs-md-1 mb-0">SIMA KOMINFO</h1>
            <h1 class="fs-3 fs-md-1 mt-0">JATIM</h1>
        </div>

        <div class="card w-100" style="max-width: 350px; border-radius: 0;">
            <div class="card-body">
                <h4 class="text-center mb-4">Silahkan Login</h4>

                <form action="{{ route('auth.login') }}" method="POST" onsubmit="showLoader(event)">
                    @csrf

                    <div class="mb-3 position-relative">
                        <input 
                            type="text" 
                            name="user_prefix" 
                            class="form-control pe-5 @error('user_prefix') is-invalid is-invalid-lite @enderror" 
                            placeholder="Email" autocomplete="off" 
                            value="{{ old('user_prefix') }}">
                        <span class="mdi mdi-email position-absolute" style="top: 50%; right: 12px; transform: translateY(-50%); font-size: 20px; color: #6c757d;"></span>
                        @error('user_prefix')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 position-relative">
                        <input 
                            type="password" 
                            name="password" 
                            class="form-control pe-5 @error('password') is-invalid is-invalid-lite @enderror" 
                            placeholder="Password" autocomplete="off" 
                            id="login-password">

                        <a href="#" class="position-absolute" id="toggle-login-password" style="top: 50%; right: 12px; transform: translateY(-50%); cursor: pointer; color: #6c757d; font-size: 20px;">
                            <span class="mdi mdi-eye"></span>
                        </a>

                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-2 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Ingat Saya</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Sign In</button>

                    <div class="mt-2 text-center">
                        Belum punya akun? <a href="{{ route('register') }}">Daftar</a> | 
                        <a href="{{ route('password.request') }}">Lupa Password?</a>
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

    @push('scripts')
    <script>
        function showLoader(event) {
            event.preventDefault();
            document.querySelector('button[type="submit"]').disabled = true;
            // Kamu bisa tambah loading spinner di sini jika ingin
            setTimeout(() => event.target.submit(), 2000);
        }

        document.getElementById('toggle-login-password').addEventListener('click', function (e) {
            e.preventDefault();
            const passwordField = document.getElementById('login-password');
            const icon = this.querySelector('span');
            const isHidden = passwordField.type === 'password';

            passwordField.type = isHidden ? 'text' : 'password';
            icon.classList.toggle('mdi-eye');
            icon.classList.toggle('mdi-eye-off');
        });
    </script>
    @endpush

</x-app-layout>
