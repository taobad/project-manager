<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@icon('brands/whatsapp') @langapp('subscribe')</h4>
        </div>


        <div class="modal-body">

        {!! Form::open(['route' => 'whatsapp.subscribe.send', 'class' => 'bs-example form-horizontal ajaxifyForm']) !!}
        
        <div class="alert alert-info">
            @langapp('whatsapp_subscribe_message',['subtext' => get_option('whatsapp_sub_text'), 'number' => get_option('whatsapp_number')]) <i class="fab fa-whatsapp fa-2x text-success"></i> 
        </div>
        <h3>International Number</h3>
        <ul>
            <li>Start by entering a plus sign (+)</li>
            <li>Enter the country code, followed by the full phone number.</li>
            <blockquote style="font-size:13px">
                If a contact in the United States (country code "1") has the area code "408" and phone number "123-4567", you'd enter +14081234567.
                If you have a contact in the United Kingdom (country code "44") with the phone number "07981555555", you'd remove the leading "0" and enter +447981555555.
            </blockquote>
        </ul>

        <div class="form-group">
                <label class="col-lg-3 control-label">@langapp('mobile') / @langapp('phone') @required</label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" placeholder="+14081234567" value="{{ Auth::user()->mobile }}" required name="mobile">
                </div>
        </div>
        {{-- <div class="m-sm">
        Using mobile phone? <a href="https://api.whatsapp.com/send?phone={{ get_option('whatsapp_number') }}&text={{ get_option('whatsapp_sub_text') }}" class="btb btn-sm btn-success alert-link">Click Here</a> 
        </div> --}}



            <div class="modal-footer">

            {!! closeModalButton() !!}
            {!! renderAjaxButton('subscribe','fab fa-whatsapp') !!}

            </div>
    {!! Form::close() !!}



        </div>
</div>

@include('partial.ajaxify')