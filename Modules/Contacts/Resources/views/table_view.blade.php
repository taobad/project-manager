<div class="row">
	<div class="col-lg-12">
		<section class="panel panel-default">
			<form id="frm-contact" action="{{ route('contacts.bulk.email') }}" method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="module" value="users">
				<div class="table-responsive">
					<table class="table table-striped" id="contacts-table">
						<thead>
							<tr>
								<th class="hide"></th>
								<th class="no-sort">
									<label>
										<input name="select_all" value="1" id="select-all" type="checkbox" />
										<span class="label-text"></span>
									</label>
								</th>
								<th class="">@langapp('name') </th>
								<th class="">@langapp('company_name') </th>
								<th class="">@langapp('job_title')</th>
								<th class="">@langapp('email') </th>
								<th class="">@langapp('mobile') </th>
							</tr>
						</thead>
					</table>
				</div>
				@can('leads_create')
				<button type="submit" id="button" class="btn {{themeButton()}} m-xs" value="bulk-email">
					<span class="">@icon('solid/mail-bulk') @langapp('send_email')</span>
				</button>
				@endcan
				@can('leads_create')
				<button type="submit" id="button" class="btn {{themeButton()}} m-xs" value="bulk-sms">
					<span class="">@icon('solid/sms') @langapp('send') SMS</span>
				</button>
				@endcan

				@can('leads_delete')
				<button type="submit" id="button" class="btn {{themeButton()}} m-xs" value="bulk-delete">
					<span class="">@icon('solid/trash-alt') @langapp('delete')</span>
				</button>
				@endcan

			</form>
		</section>
	</div>
</div>
@push('pagestyle')
@include('stacks.css.datatables')
@endpush
@push('pagescript')
@include('stacks.js.datatables')
<script>
	$(function() {
	$('#contacts-table').DataTable({
	processing: true,
	serverSide: true,
	ajax: {
		url: '{{ route('contacts.data') }}',
		type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	},
		data: {
			"filter": '{{ $filter }}',
		}
	},
	order: [[ 0, "desc" ]],
	columns: [
	{ data: 'id', name: 'id' },
	{ data: 'chk', name: 'chk', searchable: false },
	{ data: 'name', name: 'user.name' },
	{ data: 'company', name: 'company' },
	{ data: 'job_title', name: 'job_title' },
	{ data: 'email', name: 'user.email' },
	{ data: 'mobile', name: 'mobile' }
	]
	});
	$("#frm-contact button").click(function(ev){
	ev.preventDefault();
	if($(this).attr("value") == "bulk-email"){
		var form = $("#frm-contact").serialize();
		axios.post('{{ route('contacts.bulk.email') }}', form)
	    .then(function (response) {
	    	$("#frm-contact").submit();
	    })
	    .catch(function (error) {
	    	showErrors(error);
	    });
		
	}
	if($(this).attr("value") == "bulk-sms"){
		var form = $("#frm-contact").serialize();
		axios.post('{{ route('contacts.bulk.sms') }}', form)
	    .then(function (response) {
	    	$('#frm-contact').attr('action', "{{ route('contacts.bulk.sms') }}").submit();
	    })
	    .catch(function (error) {
	    	showErrors(error);
	    });
		
	}

if($(this).attr("value")=="bulk-delete"){
    var form = $("#frm-contact").serialize();
    axios.post('{{ route('users.bulk.delete') }}', form)
    .then(function (response) {
    toastr.warning(response.data.message, '@langapp('response_status') ');
    window.location.href = response.data.redirect;
    })
    .catch(function (error) {
    	showErrors(error);
    });
    }
});

	function showErrors(error){
	    var errors = error.response.data.errors;
	    var errorsHtml= '';
	    $.each( errors, function( key, value ) {
	    errorsHtml += '<li>' + value[0] + '</li>';
	    });
	    toastr.error( errorsHtml , '@langapp('response_status') ');
	}
	
});
</script>
@endpush