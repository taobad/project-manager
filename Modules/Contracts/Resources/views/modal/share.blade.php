<div class="modal-dialog">
    <div class="modal-content">
        <div class="p-2 border-b border-gray-300">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="text-xl text-gray-600 modal-title">
                @icon('solid/share-alt','text-indigo-500') @langapp('share')
            </h4>
        </div>
        <div class="modal-body">
            <p class="my-2 text-xl text-gray-600">
                {{ __('Share this link to access Contract') }}
            </p>
            <input type="text" class="form-control" onfocus="this.select();" onmouseup="return false;" value="{{ URL::signedRoute('contracts.guest.show', $id) }}">

        </div>
        <div class="modal-footer">
            {!! closeModalButton() !!}
            <a href="{{ URL::signedRoute('contracts.guest.show', $id) }}" class="btn {{themeButton()}}" target="_blank">
                @icon('solid/link') @langapp('preview')
            </a>

        </div>
    </div>
</div>