@push('pagescript')
<script>
    $(document).ready(function () {

        $('#save-template').on('submit', function(e) {
            $(".formSaving").html('Processing..<i class="fas fa-spin fa-spinner"></i>');

            e.preventDefault();
            var tag, data;
            tag = $(this);
            data = tag.serialize();

             axios.post($(this).attr("action"), data)
            .then(function (response) {
                    $('#template-list').prepend(response.data.html);
                    toastr.info( response.data.message , '@langapp('response_status') ');
                    $(".formSaving").html('<i class="fas fa-paper-plane"></i> @langapp('save') </span>');
                    window.location.href = response.data.redirect;
            })
            .catch(function (error) {
                var errors = error.response.data.errors;
                var errorsHtml= '';
                $.each( errors, function( key, value ) {
                    errorsHtml += '<li>' + value[0] + '</li>'; 
                });
                toastr.error( errorsHtml , '@langapp('response_status') ');
                $(".formSaving").html('<i class="fas fa-sync"></i> Try Again</span>');
            });


        });


        $('.list').on('click', '.delete-template', function (e) {
            e.preventDefault();
            var tag, id, request;

            tag = $(this);
            id = tag.data('template-id');

            if(!confirm('Do you want to delete this message?')) {
                return false;
            }
            axios.delete('/contracts/templates/'+id)
            .then(function (response) {
                toastr.warning( response.data.message , '@langapp('response_status') ');
                $('#template-' + id).hide(500, function () {
                    $(this).remove();
                });
            })
            .catch(function (error) {
                toastr.error( 'Something went wrong please try again' , '@langapp('response_status') ');
            });

        })
    });

</script>
@endpush