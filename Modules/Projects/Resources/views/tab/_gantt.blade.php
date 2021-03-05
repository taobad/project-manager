@if (($project->setting('show_project_gantt') && $project->isClient()) || isAdmin() || $project->isTeam())
<section class="scrollable">
	<section class="panel panel-default">
		<div class="m-xs">
			<div class="btn-group" data-toggle="buttons">
				<label class="btn {{themeButton()}}">
					<input type="radio" name="options" value="Quarter Day">@langapp('quarter_day')
				</label>
				<label class="btn {{themeButton()}}">
					<input type="radio" name="options" value="Half Day">@langapp('half_day')
				</label>
				<label class="btn {{themeButton()}}">
					<input type="radio" name="options" value="Day">@langapp('day')
				</label>
				<label class="btn {{themeButton()}} active">
					<input type="radio" name="options" value="Week">@langapp('week')
				</label>
				<label class="btn {{themeButton()}}">
					<input type="radio" name="options" value="Month">@langapp('month')
				</label>
			</div>
		</div>


		<div class="project-gantt"></div>
	</section>
</section>
@if ($project->tasks->count() > 0)

@push('pagescript')
@include('stacks.js.gantt')
<script>
	var tasks = JSON.parse('{!! json_encode($project->ganttData()) !!}');
	var gantt_chart = new Gantt(".project-gantt", tasks, {
		popup_trigger: 'click mouseover',
		on_click: function (data) {
			if(data.id != 'milestone_0'){
				if (typeof(data.milestone_id) != 'undefined') {
					window.location = '/projects/view/'+data.project+'/milestones/'+data.milestone_id;
				}else{
					window.location = '/projects/view/'+data.project+'/tasks/'+data.task_id;
				}
			}
			
		},
		on_date_change: function(task, start, end) {
			if (typeof(task.task_id) != 'undefined') {
				axios.put('/api/v1/tasks/'+task.id, {
					start_date: moment(start).format('{{ strtoupper(get_option('date_picker_format')) }}'),
					due_date: moment(end).format('{{ strtoupper(get_option('date_picker_format')) }}'),
					name:task.name,
					project_id:task.project
				})
				.then(function (response) {
					toastr.success( response.data.message , '@langapp('response_status') ');
				})
				.catch(function (error) {
					toastr.error('Oops! Request failed to complete.', '@langapp('response_status') ');
				});
			}
		},
		on_progress_change: function(task, progress) {
			if (typeof(task.task_id) != 'undefined') {
				axios.put('/api/v1/tasks/'+task.id, {
					progress: progress,
					start_date: moment(task.start).format('{{ strtoupper(get_option('date_picker_format')) }}'),
					due_date: moment(task.end).format('{{ strtoupper(get_option('date_picker_format')) }}'),
					name:task.name,
					project_id:task.project
				})
				.then(function (response) {
					toastr.success( response.data.message , '@langapp('response_status') ');
				})
				.catch(function (error) {
					toastr.error('Oops! Request failed to complete.', '@langapp('response_status') ');
				});

			}
		},
		custom_popup_html: function(task) {
				const end_date = moment(task.end).format('MMM D');
				return `
					<div class="details-container">
					<h5>${task.name}</h5>
					<p>Expected to finish by ${end_date}</p>
					<p>${task.progress}% completed!</p>
					</div>
				`;
		},
		on_view_change: function(mode) {
					
		}
		});
	gantt_chart.change_view_mode('Week');
	$('body').on('mouseleave', '.grid-row', function() {
		gantt_chart.hide_popup();
    })
	$(function() {
		$(".btn-group").on("change", "input[type='radio']", function() {
			var mode = $('input[name=options]:checked').val();
			gantt_chart.change_view_mode(mode);
		});
});
</script>
@endpush
@endif

@endif