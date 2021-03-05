<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-success">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@langapp('estimate') URL</h4>
        </div>
        <div class="modal-body">
            <p class="h3">
                Share this link to access the Estimate
            </p>
            <input type="text" class="form-control" onfocus="this.select();" onmouseup="return false;" value="{{ URL::signedRoute('estimates.guest', $id) }}">

        </div>
        <div class="modal-footer">
            {!! closeModalButton() !!}
            <a href="{{ URL::signedRoute('estimates.guest', $id) }}" class="btn {{themeButton()}}" target="_blank">@icon('solid/link') @langapp('preview') </a>

        </div>
    </div>
</div>