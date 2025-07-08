<div id="loading-screen" class="d-none">
    <div class="text-center">
        <div class="text-secondary mb-3">{{ $message }}</div>
        <div class="progress progress-{{ $sizeProgressBar }}">
            <div class="progress-bar progress-bar-indeterminate"></div>
        </div>
    </div>
</div>

<script>
    function showLoading() {
        document.getElementById("loading-screen").classList.remove("d-none");
        document.getElementById("loading-screen").classList.add("d-block");
    }
</script>
