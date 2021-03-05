@extends('layouts.app')

@section('content')
<section id="content">
    <section class="hbox stretch">
        <aside>
            <section class="vbox">
                <header class="px-2 pb-2 bg-white border-b border-gray-400 panel-heading">
                    <div class="flex justify-between text-gray-500">
                        <div>
                            <h4 class="ml-2 text-xl font-semibold text-gray-600">{{ $article->subject }}</h4>
                        </div>
                        <div>
                            <a href="{{ route('kb.index') }}" class="btn {{themeButton()}}">
                                @icon('solid/chevron-left') @langapp('back')
                            </a>
                        </div>
                    </div>
                </header>
                <section class="scrollable wrapper bg">
                    {!! Form::open(['route' => ['kb.update', $article->id], 'class' => 'm-b-sm ajaxifyForm', 'method' => 'PUT']) !!}
                    <input type="hidden" name="id" value="{{ $article->id }}">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>@langapp('subject') @required</label>
                                <input type="text" value="{{ $article->subject }}" name="subject" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>@langapp('category') @required</label>
                                <select name="group" class="form-control select2-option" required>
                                    @foreach (App\Entities\Category::where('module','knowledgebase')->get() as $cat)
                                    <option value="{{ $cat->id }}" {{ $article->group == $cat->id ? 'selected' : '' }}>{{  $cat->name  }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>@langapp('description') @required</label>
                        <x-inputs.wysiwyg name="description" class="{{ get_option('htmleditor') }}" id="{{ get_option('htmleditor') }}">
                            {!!$article->description!!}
                        </x-inputs.wysiwyg>
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="hidden" name="allow_comments" value="0">
                                <input type="checkbox" name="allow_comments" {{ $article->allow_comments ? 'checked' : ''  }} value="1">
                                <span class="label-text">@langapp('allow_comments') </span>
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="hidden" name="active" value="0">
                                <input type="checkbox" name="active" value="1" {{ $article->active ? 'checked' : ''  }}>
                                <span class="label-text">@langapp('published')</span>
                            </label>
                        </div>

                    </div>


                    <div class="text-right">
                        {!! renderAjaxButton() !!}
                    </div>

                    {!! Form::close() !!}


                </section>

                </div>

            </section>
            </div>


    </section>


</section>
</aside>
</section> <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>

@push('pagestyle')
@include('stacks.css.form')
@include('stacks.css.wysiwyg')
@endpush

@push('pagescript')
@include('stacks.js.form')
@include('stacks.js.wysiwyg')
@endpush

@endsection