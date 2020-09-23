<footer>
    <p>KodingClub</p>

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