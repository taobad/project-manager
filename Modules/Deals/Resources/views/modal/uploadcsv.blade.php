<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"> @icon('solid/cloud-upload-alt') @langapp('import') CSV</h4>
        </div>
        {!! Form::open(['route' => 'deals.csvmap', 'files' => true]) !!}
        <div class="modal-body">


            @include('partial.csvupload')

            <p class="text-center">Selected file:</p>

            <div class="text-center" id="fileList"></div>


        </div>
        <div class="modal-footer">

            {!! closeModalButton() !!}
            {!! renderAjaxButton('import', 'fas fa-cloud-upload-alt', true) !!}

        </div>
        {!! Form::close() !!}
    </div>
</div>

<script>
    updateList = function() {
    var input = document.getElementById('file');
    var output = document.getElementById('fileList');
    var children = "";
    for (var i = 0; i < input.files.length; ++i) {
        children += '<li>' + input.files.item(i).name + '</li>';
    }
    output.innerHTML = '<ul>'+children+'</ul>';
}

</script>