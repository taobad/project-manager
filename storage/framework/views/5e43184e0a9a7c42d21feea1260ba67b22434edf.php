<script>
    $('.ajaxifyForm').submit(function (event) {
        $(".formSaving").html('Processing..<i class="fas fa-spin fa-spinner"></i>');
        event.preventDefault();

        var data = new FormData(this);

        axios.post($(this).attr("action"), data)
            .then(function (response) {
                    toastr.success(response.data.message, '<?php echo trans('app.'.'response_status'); ?> ');
                    $(".formSaving").html('<i class="fas fa-check"></i> <?php echo trans('app.'.'save'); ?> </span>');
                    window.location.href = response.data.redirect;
          })
          .catch(function (error) {
            if(error.response.data.exception){
                toastr.error(error.response.data.message , '<?php echo trans('app.'.'response_status'); ?> ');
                $(".formSaving").html('<i class="fas fa-sync"></i> <?php echo trans('app.'.'try_again'); ?></span>');
            }else{
                if(error.response.data.message == 'Server Error'){
                    toastr.error('Request was not completed check the logs folder for more info. Also ensure your application can send emails.', '<?php echo trans('app.'.'response_status'); ?> ');
                    $(".formSaving").html('<i class="fas fa-sync"></i> <?php echo trans('app.'.'try_again'); ?></span>');
                    return;
                }
                var errors = error.response.data.errors;
                var errorsHtml= '';
                $.each( errors, function( key, value ) {
                    errorsHtml += '<li>' + value[0] + '</li>';
                });
                toastr.error( errorsHtml , '<?php echo trans('app.'.'response_status'); ?> ');
                $(".formSaving").html('<i class="fas fa-sync"></i> <?php echo trans('app.'.'try_again'); ?></span>');
            }


        });

    });
</script><?php /**PATH /var/www/project-manager/resources/views/partial/ajaxify.blade.php ENDPATH**/ ?>