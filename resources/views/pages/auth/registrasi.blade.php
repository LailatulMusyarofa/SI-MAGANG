<x-app-layout pageTitle="Daftar Akun Baru">

    <div class="d-flex flex-column justify-content-center align-items-center vh-100" style="background-color: #ccd1d9;">

         <div class="text-center mb-2" style="line-height: 1.1;">
            <h1 style="margin-bottom: 0;">SIMA KOMINFO</h1>
            <h1 style="margin-top: 0;">JATIM</h1>
        </div>

        <div class="card" style="width: 350px; border-radius: 0;">
            <div class="card-body">
                <h4 class="text-center mb-4">Daftar Akun Baru</h4>

                <form action="{{ route('auth.register') }}" method="POST" onsubmit="showLoader(event)">
                    @csrf

                    <div class="mb-3 position-relative">
                        <input 
                            type="text" 
                            name="fullname" 
                            class="form-control @error('fullname') is-invalid @enderror" 
                            placeholder="Nama Lembaga Pendidikan" 
                            value="{{ old('fullname') }}" 
                            required>
                        <span class="mdi mdi-bank position-absolute" style="top: 50%; right: 12px; transform: translateY(-50%); font-size: 20px; color: #6c757d;"></span>
                        @error('fullname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 position-relative">
                        <input 
                            type="text" 
                            name="username" 
                            class="form-control @error('username') is-invalid @enderror" 
                            placeholder="Username" 
                            value="{{ old('username') }}" 
                            required>
                        <span class="mdi mdi-account position-absolute" style="top: 50%; right: 12px; transform: translateY(-50%); font-size: 20px; color: #6c757d;"></span>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 position-relative">
                        <input 
                            type="email" 
                            name="email" 
                            class="form-control pe-5 @error('email') is-invalid @enderror" 
                            placeholder="Email" 
                            value="{{ old('email') }}" 
                            required>
                        <span class="mdi mdi-email position-absolute" style="top: 50%; right: 12px; transform: translateY(-50%); font-size: 20px; color: #6c757d;"></span>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 position-relative">
                        <input 
                            type="password" 
                            name="password" 
                            class="form-control pe-5 @error('password') is-invalid @enderror" 
                            placeholder="Password" 
                            required 
                            id="password" 
                            autocomplete="off">

                        <a href="#" class="position-absolute" id="toggle-password" style="top: 50%; right: 12px; transform: translateY(-50%); cursor: pointer; color: #6c757d; font-size: 20px;">
                            <span class="mdi mdi-eye"></span>
                        </a>

                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 position-relative">
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            class="form-control pe-5" 
                            placeholder="Konfirmasi Password" 
                            required 
                            id="password_confirmation" 
                            autocomplete="off">

                        <a href="#" class="position-absolute" id="toggle-password-confirmation" style="top: 50%; right: 12px; transform: translateY(-50%); cursor: pointer; color: #6c757d; font-size: 20px;">
                            <span class="mdi mdi-eye"></span>
                        </a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" id="loginBtn">Daftar</button>

                    <div class="mt-2 text-center">
                        Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
                    </div>
                </form>

            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            function showLoader(event) {
                event.preventDefault();
                document.getElementById('loginBtn').disabled = true;
                // showLoading(); // Kalau ada fungsi loader, aktifkan ini
                setTimeout(() => event.target.submit(), 2000);
            }

            // Toggle password visibility for password input
            document.getElementById('toggle-password').addEventListener('click', function (e) {
                e.preventDefault();
                const passwordField = document.getElementById('password');
                const passwordIcon = this.querySelector('span');
                const isHidden = passwordField.type === 'password';

                passwordField.type = isHidden ? 'text' : 'password';
                passwordIcon.classList.toggle('mdi-eye');
                passwordIcon.classList.toggle('mdi-eye-off');
            });

            // Toggle password visibility for confirmation input
            document.getElementById('toggle-password-confirmation').addEventListener('click', function (e) {
                e.preventDefault();
                const confirmationField = document.getElementById('password_confirmation');
                const confirmationIcon = this.querySelector('span');
                const isHidden = confirmationField.type === 'password';

                confirmationField.type = isHidden ? 'text' : 'password';
                confirmationIcon.classList.toggle('mdi-eye');
                confirmationIcon.classList.toggle('mdi-eye-off');
            });
        </script>
    @endpush
</x-app-layout>