<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
<!-- <script src="{{ asset('vendor/libs/jquery/jquery.js') }}"></script> -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="{{ asset('vendor/js/popper.min.js') }}"></script>
<script src="{{ asset('vendor/js/bootstrap.js') }}"></script>
<!-- <script src="{{ asset('vendor/js/bootstrap-old.js') }}"></script> -->
<script src="{{ asset('vendor/libs/node-waves/node-waves.js') }}"></script>
<script src="{{ asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('vendor/libs/hammer/hammer.js') }}"></script>
<script src="{{ asset('vendor/libs/i18n/i18n.js') }}"></script>
<script src="{{ asset('vendor/libs/typeahead-js/typeahead.js') }}"></script>
<script src="{{ asset('vendor/js/menu.js') }}"></script>
<!-- Vendors JS -->
<script src="{{ asset('vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script src="{{ asset('vendor/libs/swiper/swiper.js') }}"></script>
<script src="{{ asset('vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script src="{{ asset('vendor/libs/@form-validation/popular.js') }}"></script>
<script src="{{ asset('vendor/libs/@form-validation/bootstrap5.js') }}"></script>
<script src="{{ asset('vendor/libs/@form-validation/auto-focus.js') }}"></script>
<!-- Main JS -->
<script src="{{ asset('js/main.js') }}"></script>
<script>
    $(function() {
        var url = window.location.href;
        var menulink = $('.menu-link').find(`a[href="${url}"]`);
    });
    $(function() {
        var pgurl = window.location.href;
        // console.log(pgurl);
        $('.menu-item').removeClass('active');
        $('.menu-item').removeClass('open');
        $(".menu-inner .menu-item .menu-link").each(function(){
            // console.log($(this).attr("href"))
            if($(this).attr("href") == pgurl || $(this).attr("href") == '') {
                $(this).parent().addClass("active");
            }
        })
        $('.menu-link.active').parent('.menu-sub').parent('.menu-item').addClass('open');
        $('.menu-item.active').parent('.menu-sub').parent('.menu-item').addClass('open');
        $('.menu-item.open').parent('.menu-sub').parent('.menu-item').addClass('open');
        $('.menu-item.open').parent('.menu-sub').parent('.menu-item').addClass('open');
        // console.log($('.menu-link.active').parent('.menu-sub').length);
    });

    function confirmDelete() {
        var txt;
        var r = confirm("Are you sure ?");
        if (r == true) {
            return true;
        } else {
            return false;
        }
    //    document.getElementById("demo").innerHTML = txt;
    }
</script>

<script src="{{ asset('vendor/libs/toastr/toastr.js') }}"></script>
<script>
    function showToast(msg, type = 'info') {
    // Set the default options for toastr
    toastr.options = {
        maxOpened: 1,
        autoDismiss: true,
        closeButton: true,
        debug: false,
        newestOnTop: true,
        progressBar: true,
        positionClass: "toast-top-center",
        preventDuplicates: true,
        showDuration: 300,      // Animation duration for showing the toast
        hideDuration: 1000,     // Animation duration for hiding the toast
        timeOut: 5000,          // Time after which the toast disappears
        extendedTimeOut: 1000,  // Time after which the toast hides if hovered
        showEasing: "swing",    // Easing function for show animation
        hideEasing: "linear",   // Easing function for hide animation
        showMethod: "fadeIn",   // Method for showing the toast
        hideMethod: "fadeOut"   // Method for hiding the toast
    };

    // Show the toast based on the specified type (success, info, warning, error)
    toastr[type](msg);
}

function confirmDelete() {
    var r = confirm("Are you sure ?");
    if (r == true) {
        return true;
    } else {
        return false;
    }
}
</script>


@if ($sessionData = Session::get('data'))
    @if($sessionData['status_code'] == 1)
            <script type="text/javascript">
                showToast("{{ $sessionData['message'] }}", "success");
            </script>
    @else
            <script type="text/javascript">
                showToast("{{ $sessionData['message'] }}", "danger");
            </script>
    @endif
@endif