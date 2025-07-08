<!-- Konfirmasi Logout -->
<div
    x-show="showLogoutConfirm"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
>
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-bold mb-4">Konfirmasi Keluar</h2>
        <p class="mb-6">Apakah Anda yakin ingin keluar?</p>
        <div class="flex justify-end gap-3">
            <button
                @click="showLogoutConfirm = false"
                class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300"
            >
                Tidak
            </button>
            <a
                href="{{ route('beranda') }}"
                class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700"
            >
                Ya
            </a>
        </div>
    </div>
</div>

