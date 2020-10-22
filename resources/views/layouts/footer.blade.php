<footer class="container my-4 py-4 has-text-centered">
    <a href="/info/about">Tentang Kami</a> - 
    <a href="/info/faq">FAQ</a>
    <p>Berikan kami saran dan kritik <a href="https://twitter.com/pulodev" target="_blank"> @pulodev</a></p> 
    <p>©PuloDev</p>

    {{-- SweerAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.3.1/dist/sweetalert2.min.css">
    @if (session('success'))
        <script type="text/javascript" defer>
        swal.fire("Selamat!", "{{ session('success') }}", "success")
        </script>
    @endif

    @if (session('warning'))
        <script type="text/javascript" defer>
        swal.fire("Oops!", "{{ session('warning') }}", "warning")
        </script>
    @endif

    @if (session('info'))
        <script type="text/javascript" defer>
        swal.fire("Hai!", "{{ session('info') }}", "info")
        </script>
    @endif
    {{-- End SweerAlert --}}
</footer>