<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- Js Plugins -->
<script src="Public/js/jquery-3.3.1.min.js"></script>
<script src="Public/js/bootstrap.min.js"></script>
<script src="Public/js/jquery.magnific-popup.min.js"></script>
<script src="Public/js/jquery.nice-select.min.js"></script>
<script src="Public/js/jquery-ui.min.js"></script>
<script src="Public/js/jquery.slicknav.js"></script>
<script src="Public/js/owl.carousel.min.js"></script>
<script src="Public/js/main.js"></script>
<script> window.addEventListener('load', function() {
        const roomItems = document.querySelectorAll('.room-item');
        let maxHeight = 0;

        // Tính chiều cao lớn nhất của các phòng
        roomItems.forEach(item => {
            const height = item.offsetHeight;
            if (height > maxHeight) {
                maxHeight = height;
            }
        });

        // Áp dụng chiều cao lớn nhất cho tất cả các phòng
        roomItems.forEach(item => {
            item.style.height = maxHeight + 'px';
        });
    });
</script>