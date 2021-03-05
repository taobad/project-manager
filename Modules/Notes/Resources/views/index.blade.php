@extends('layouts.app')

@section('content')

<section id="content" class="bg">
  <section class="hbox stretch">

    <aside class="aside-xl b-l b-r" id="note-list">
      <section class="vbox">
        <header class="header clearfix">
          <div class="flex justify-between mt-2 text-gray-500">
            <span class="text-2xl text-gray-500 font-semibold">
              @langapp('notes')
            </span>
            <button class="btn {{themeButton()}} btn-icon" id="new-note" data-toggle="tooltip" data-placement="right" title="New">
              @icon('solid/plus')
            </button>
          </div>
          <div class="input-group my-2">
            <span class="input-group-addon input-sm">@icon('solid/search')</span>
            <input type="text" class="form-control input-sm" id="search-note" placeholder="search">
          </div>
        </header>
        <div>


          <div class="padder">

            <ul id="note-items" class="list-group list-group-sp"></ul>

            <script type="text/template" id="item-template">
              <div class="view" id="note-<%- id %>">
                                <button class="destroy close hover-action">&times;</button>
                                <div class="note-name">
                                  <strong>
                                  <%- (name && name.length) ? name : 'New note' %>
                                  </strong>
                                </div>
                                <div class="note-desc">
                                  <%- description.replace(name,'').length ? description.replace(name,'') : 'empty note' %>
                                </div>
                                <span class="text-xs text-muted"><%- moment(parseInt(date)).format('MMM Do, h:mm a') %></span>
                              </div>
                            </script>

            <p class="text-center">&nbsp;</p>
          </div>


        </div>
      </section>
    </aside>

    <aside id="note-detail">
      <script type="text/template" id="note-template">
        <section class="vbox">
                    <header class="header bg-light lter bg-gradient b-b">
                      <p id="note-date">Created on <%- moment(parseInt(date)).format('MMM Do, h:mm a') %></p>
                    </header>
                    <section class="bg-light lter">
                      <section class="hbox stretch">
                        <aside>
                          <section class="vbox b-b">
                            <section class="paper">
                                <textarea type="text" class="form-control scrollable" placeholder="Type your note here"><%- description %></textarea>
                            </section>
                          </section>
                        </aside>
                      </section>
                    </section>
                  </section>
                </script>
    </aside>
  </section>
  <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open" data-target="#nav,html"></a>
</section>


@push('pagescript')
<script src="{{ getAsset('plugins/underscore/underscore-min.js') }}"></script>
<script src="{{ getAsset('plugins/backbone/backbone-min.js') }}"></script>
<script src="{{ getAsset('plugins/backbone/backbone.localStorage-min.js') }}"></script>
<script src="{{ getAsset('plugins/apps/notes.js') }}"></script>
@endpush
@endsection