<!-- Tabler Core -->
<script src="{{ asset('dist/js/tabler.min.js')}}"></script>
<script src="{{ asset('dist/js/demo.min.js')}}"></script>

<!-- Import Swal -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Script Jquery Ajax Logout -->
<script>
    const logoutNow = () => {
        Swal.fire({
            title: 'Perhatian!',
            text: 'Apakah Anda yakin ingin keluar dari aplikasi?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Keluar!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('auth.logout') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            showAlert(response.message, 'success');
                            setTimeout(() => {
                                window.location.href = "{{ route('login') }}";
                            }, 1000);
                        } else {
                            showAlert(response.message, 'gagal');
                        }
                    }
                });
            }
        });
    }
</script>

<!-- Litepicker -->
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>


<!-- Extended Scripts -->
@stack('scripts')
