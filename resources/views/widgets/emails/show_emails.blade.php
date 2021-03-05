@foreach ($emails as $email)
<div class="padder m-t">
  <div class="block clearfix m-b">
    <div class="mt-1 {{ $email->opened > 0 ? 'text-indigo-600' : 'text-gray-600' }}">@icon('regular/envelope-open') {{ $email->subject }}
      <span class="pull-right">@icon('solid/clock') {{ dateElapsed($email->created_at) }} <a href="{{ route('email.delete', $email->id) }}"
          data-toggle="ajaxModal">@icon('solid/trash-alt')</a></span>
    </div>
    <div class="line pull-in"></div>

  </div>

  @parsedown($email->message)

  @include('partial._show_files', ['files' => $email->files])

</div>
@endforeach