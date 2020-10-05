<footer class="container my-4 py-4 has-text-centered">
    <a href="/info/about">Tentang Kami</a> - 
    <a href="/info/faq">FAQ</a>
    <p>PuloDev</p>

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

    <script>
        //lazy loading image
        var lazyImg = document.querySelectorAll('img[data-src]');

        lazyLoad();
        window.onscroll = function() { lazyLoad(); }

        function lazyLoad() {
            for(var i=0; i<lazyImg.length; i++){
                if(isElementInViewport(lazyImg[i])){
                    if (lazyImg[i].getAttribute('data-src')){
                        lazyImg[i].src = lazyImg[i].getAttribute('data-src');
                        lazyImg[i].removeAttribute('data-src');
                    }
                }
            }
            cleanLazyImage();
        }

        function isElementInViewport (el) {
            var rect = el.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }

        function cleanLazyImage() {
            lazyImg = Array.prototype.filter.call(
                    lazyImg, function(l){
                        return l.getAttribute('data-src');
                    }
            );
        }
    </script>
</footer>