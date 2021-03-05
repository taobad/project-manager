<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@langapp('share') Invoice public URL</h4>
        </div>
        <div class="modal-body">
            <p class="text-lg text-gray-600 m-3">
                Share this link to access the Invoice
            </p>
            <input type="text" class="form-control" onfocus="this.select();" onmouseup="return false;" value="{{ URL::signedRoute('invoices.guest', $id) }}">

        </div>
        <div class="modal-footer">
            {!! closeModalButton() !!}
            <a href="{{ URL::signedRoute('invoices.guest', $id) }}" class="btn {{themeButton()}}" target="_blank">
                @icon('solid/share-alt') @langapp('preview') </a>

        </div>
    </div>
</div>