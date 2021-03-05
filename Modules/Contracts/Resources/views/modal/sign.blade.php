<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@icon('solid/shield-alt') @langapp('sign_contract')</h4>
        </div>

        {!! Form::open(['route' => ['contracts.api.sign', $contract->id], 'class' => 'bs-example form-horizontal ajaxifyForm', 'data-toggle' => 'validator']) !!}

        <div class="modal-body">

            <p>@langapp('confirm_contract_sign_message', ['name' => Auth::user()->name, 'email' => Auth::user()->email])</p>

            <input type="hidden" name="contract_id" value="{{ $contract->id }}">
            <input type="hidden" name="ip_address" value="">
            <input type="hidden" name="unix_time" value="">
            <input type="hidden" name="device_agent" value="">
            <input type="hidden" name="device_platform" value="">
            <input type="hidden" name="sign_identity" value="">
            <input type="hidden" name="checksum" value="">
            <input type="hidden" name="signature" value="">

            <div class="pb15 signatureSec">

                <div id="target" class="signature">

                    @if(Auth::user()->signed())
                    <img src="{{ \Auth::user()->profile->sign }}" width="250" alt="">
                    <input type="hidden" name="image" value="{{ \Auth::user()->profile->signature }}">
                    <input type="hidden" class="form-control" name="signature" value="{{ Auth::user()->name }}">

                    <center>
                        <canvas id="userSignature" class="hidden sig"></canvas>
                    </center>

                    @endif

                </div>

            </div>

            @if(!Auth::user()->signed())

            @if (settingEnabled('enable_signaturepad'))
            <x-alert type="success" icon="solid/signature" class="text-sm leading-5">
                Draw your signature below to sign the document.
            </x-alert>
            <input type="hidden" id="saveit" name="signature_image" value="">
            <center><canvas id="userSignature" class="m-2 border-gray-300 rounded-md sig" width=400 height=200></canvas></center>
            <center>
                <button type="button" class="text-white bg-red-500 btn hover:text-white focus:outline-none" onclick="cleartheform()">
                    Clear Pad
                </button>
            </center>
            <input type="hidden" name="signature" value="{{Auth::user()->name}}">
            @endif
            @if (!settingEnabled('enable_signaturepad'))
            <div class="form-group">
                <label class="col-lg-5 control-label">@langapp('type_your_name_to_sign') @required</label>
                <div class="col-lg-7">
                    <input type="text" id="sign" class="form-control" placeholder="Your Signature" name="signature" required>
                </div>
            </div>
            @endif
            @endif


        </div>

        <div class="modal-footer">

            {!! closeModalButton() !!}
            {!! renderAjaxButton('confirm_signature', 'fas fa fa-file-signature', true) !!}

        </div>


        {!! Form::close() !!}


    </div>
</div>

@include('partial.ajaxify')

@if (settingEnabled('enable_signaturepad'))

<script type="text/javascript">
    $('#sign').keyup(function () {
        $('#target').html($(this).val());
    });
    signaturePad = new SignaturePad(document.getElementById("userSignature"), {
      onEnd: function () {
          document.getElementById("saveit").value = signaturePad.toDataURL();
      }
    });
    function cleartheform() {
     signaturePad.clear();
    }
</script>
@endif