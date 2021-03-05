<script type="text/javascript">

        $(document).ready(function () {

            $(".menu-view-toggle").on('click', function (e) {
                e.preventDefault();
                var target = $(this).attr('data-href');
                var role = $(this).attr('data-role');
                var vis = 1;
                if ($(this).hasClass('btn-info')) {
                    vis = 0;
                }
                $(this).toggleClass('btn-info').toggleClass('btn-default');
                $.ajax({
                    url: target,
                    type: 'POST',
                    data: {visible: vis, access: role, _token: '{{ csrf_token() }}'},
                    success: function (data) {
                        toastr.success(data.message, '@langapp('response_status') ');
                        window.location.href = data.redirect;
                    },
                    error: function (xhr) {
                        toastr.error('@langapp('request_failed')' , '@langapp('response_status') ');
                    }
                });
            });
});
</script>