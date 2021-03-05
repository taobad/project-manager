@if (get_option('htmleditor') == 'summernoteEditor')
<script src="{{ getAsset('plugins/wysiwyg/summernote.min.js') }}"></script>
@php
$path = public_path().'/plugins/wysiwyg/lang/summernote-'.editorLocale().'-'.strtoupper(editorLocale()).'.min.js';
@endphp
@if (file_exists($path))
<script src="{{ getAsset('plugins/wysiwyg/lang/summernote-'.editorLocale().'-'.strtoupper(editorLocale()).'.min.js') }}">
</script>
@endif
<script type="text/javascript">
	$(document).ready(function() {
		$('.summernoteEditor').summernote({
			lang: '{{editorLocale().'-'.strtoupper(editorLocale())}}',
			callbacks: {
			    onImageUpload: function(files) {
			    	for(var i=0; i < files.length; i++) {
        				sendCMSFile(files[i]);
      				}
			    },
  			},
			placeholder: 'Type text or message here...',
			toolbar: [
					['style', ['style', 'bold', 'italic', 'underline', 'clear']],
					['fontsize', ['fontsize']],
					['para', ['ul', 'ol', 'paragraph']],
					['insert', ['link', 'unlink', 'picture', 'video','hr']],
					['height', ['height']],
					['view', ['codeview']],
					]
		});
	});

function sendCMSFile(file) {
  if (file.type.includes('image')) {
    var name = file.name.split(".");
    name = name[0];
    var data = new FormData();
    data.append('file', file);
    data.append('_token', "{{ csrf_token() }}");
    $.ajax({
        url: '/files/summernote/upload',
        type: 'POST',
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'JSON',
        data: data,
        success: function (url) {
          $('.summernoteEditor').summernote('insertImage', url);
        },
        error: function (jqXHR, textStatus, errorThrown) {
        	toastr.error('Upload failed or application in demo mode', '@langapp('response_status')');
        }
    });
  }
}
</script>
@endif
@if (get_option('htmleditor') == 'markdownEditor')
<script src="{{ getAsset('plugins/wysiwyg/bootstrap-markdown.js') }}"></script>
<script src="{{ getAsset('plugins/wysiwyg/showdown.min.js') }}"></script>
@if (file_exists(asset('plugins/wysiwyg/locale/bootstrap-markdown.'.editorLocale().'.js')))
<script src="{{ getAsset('plugins/wysiwyg/locale/bootstrap-markdown.'.editorLocale().'js') }}"></script>
@endif
<script type="text/javascript">
	$(document).ready(function () {
        $(".markdownEditor").markdown({
            autofocus: false,
            savable: false,
            iconlibrary: 'fa',
            language: '{{ editorLocale() }}',
        })
	});
	var markdown = new showdown.Converter();
    markdown.setFlavor('github');
    markdown.toHTML = function (val) {
        return markdown.makeHtml(val);
    }
</script>
@endif

@if (get_option('htmleditor') == 'easyMDE')
<script src="{{ getAsset('plugins/wysiwyg/easymde.js') }}"></script>
@endif