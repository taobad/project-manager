<section class="scrollable bg">
  @if(isAdmin() || can('deals_send_email'))
  @widget('Emails\SendContactEmail', ['id' => $deal->contact->id, 'subject' => optional($deal->contact->emails->first())->subject])
  @widget('Emails\ShowEmails', ['emails' => $deal->contact->emails])
  @endif
</section>
@push('pagestyle')
@include('stacks.css.datepicker')
@endpush
@push('pagescript')
@include('stacks.js.datepicker')
<script>
  $('.datetimepicker-input').datetimepicker({showClose: true, showClear: true, minDate: moment() });
   
    $( "#sendLater" ).click(function() {
      $("#queueLater").show("fast");
      $( ".datetimepicker-input" ).focus();
    });
</script>
@endpush