@push('pagescript')
<script>
        $('#sendChat').on('submit', function(e) {
            $(".formSaving").html('Sending..<i class="fas fa-spin fa-spinner"></i>');
            e.preventDefault();
            var url, tag;
            tag = $(this);
            var formData = new FormData($(this)[0]);

             axios.post('{{ route('extras.chats.create') }}', formData)
            .then(function (response) {
                    $('#chatMessages').prepend(response.data.html);
                    toastr.success( response.data.message , '@langapp('response_status') ');
                    $(".formSaving").html('<i class="fas fa-paper-plane"></i> @langapp('send') </span>');
                    tag[0].reset();
            })
            .catch(function (error) {
                var errors = error.response.data.errors;
                var errorsHtml= '';
                $.each( errors, function( key, value ) {
                errorsHtml += '<li>' + value[0] + '</li>';
                });
                toastr.error( errorsHtml , '@langapp('response_status') ');
                $(".formSaving").html('<i class="fas fa-sync"></i> @langapp('try_again')');
        });    

        });


        $('.chat-list').on('click', '.deleteChat', function (e) {
            e.preventDefault();
            var tag, id;

            tag = $(this);
            id = tag.data('message-id');

            if(!confirm('Do you want to delete this message?')) {
                return false;
            }
            axios.post('{{ route('extras.chats.delete') }}', {
                id: id
            })
            .then(function (response) {
                    toastr.warning( response.data.message , '@langapp('response_status') ');
                    $('#message-' + id).hide(500, function () {
                        $(this).remove();
                    });
            })
            .catch(function (error) {
                toastr.error( 'Oop! Something went wrong!' , '@langapp('response_status') ');
        }); 

        });

</script>
@endpush