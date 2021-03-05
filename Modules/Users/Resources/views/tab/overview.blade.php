<div class="col-md-4">
    <div class="panel-body text-center">
        <div class="content-group-sm user-name">
            <h6 class="text-dark">
            {{ $user->name }}
            </h6>
            <span class="display-block">{{ $user->profile->job_title }}</span>
        </div>
        <a href="#" class="thumb-md display-inline-block content-group-sm">
            <img src="{{ $user->profile->photo }}" class="img-circle">
        </a>
        
        <p id="social-buttons" class="m-t-sm">
            @if ($user->profile->website)
            <a href="{{ $user->profile->website }}" class="btn btn-rounded btn-sm btn-icon btn-success" target="_blank">
                @icon('solid/link')
            </a>
            @endif
            @if ($user->profile->twitter )
            <a href="https://twitter.com/{{ $user->profile->twitter }}" class="btn btn-rounded btn-sm btn-icon btn-info" target="_blank">
                @icon('brands/twitter')
            </a>
            @endif
            @if ($user->profile->skype)
            <a href="skype:{{ $user->profile->skype }}" class="btn btn-rounded btn-sm btn-icon btn-primary">
                @icon('brands/skype')
            </a>
            @endif
            
        </p>
    </div>

    <h3>@langapp('active') @langapp('notifications')</h3>

    <div class="m-xs">
    @foreach($user->profile->channels as $channel)
    <span class="label bg-dark tag-m">@icon('solid/bell') {{ $channel }}</span>
    @endforeach
    </div>
    
    @include('users::includes.info')


    @admin
                <div class="line"></div>
                <small class="text-uc text-xs text-muted">@langapp('tags')  </small>
                <div class="m-xs">
                    @php
                    $data['tags'] = $user->tags;
                    @endphp
                    @include('partial.tags', $data)
                </div>
@endadmin

    
    <small class="text-uc text-xs text-muted">
    @langapp('vaults')
    <a href="{{ route('extras.vaults.create', ['module' => 'users', 'id' => $user->id]) }}" class="btn btn-xs btn-danger pull-right" data-toggle="ajaxModal">@icon('solid/plus')</a>
    </small>
    <div class="line"></div>
    @widget('Vaults\Show', ['vaults' => $user->vault])
</div>



<div class="col-md-8">
    <section class="slim-scroll" data-color="#333333" data-disable-fade-out="true" data-distance="0" data-height="700" data-size="5px">
        
        <section class="panel panel-default">
        <header class="panel-heading">@langapp('activities')  </header>
        
        @widget('Activities\Feed', ['activities' => $user->activities->take(100)])
    </section>
</section>

</div>