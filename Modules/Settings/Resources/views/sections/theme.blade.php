<div class="row">
    <!-- Start Form -->
    <div class="col-lg-12">
        {!! Form::open(['route' => ['settings.edit', $section], 'class' => 'bs-example form-horizontal ajaxifyForm', 'files' => true]) !!}

        <section class="panel panel-default">
            <header class="panel-heading">@icon('solid/cogs') @langapp('theme_settings') </header>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('site_name') </label>
                    <div class="col-lg-6">
                        <input type="text" name="website_name" class="form-control" value="{{  get_option('website_name')  }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('logo_or_icon')</label>
                    <div class="col-lg-6">
                        <select name="logo_or_icon" class="form-control">
                            <option value="icon_title" {{  get_option('logo_or_icon') == 'icon_title' ? ' selected="selected"' : '' }}>@langapp('icon')
                                & @langapp('site_name') </option>
                            <option value="icon" {{  get_option('logo_or_icon') == 'icon' ? ' selected="selected"' : ''  }}>@langapp('icon') </option>
                            <option value="logo_title" {{  get_option('logo_or_icon') == 'logo_title' ? ' selected="selected"' : ''  }}>@langapp('logo')
                                & @langapp('site_name') </option>
                            <option value="logo" {{  get_option('logo_or_icon') == 'logo' ? ' selected="selected"' : ''  }}>@langapp('logo') </option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('login_title')</label>
                    <div class="col-lg-6">
                        <input type="text" name="login_title" class="form-control" value="{{  get_option('login_title')  }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('site_icon')</label>
                    <div class="input-group iconpicker-container col-lg-6">
                        <span class="input-group-addon"><i class="{{ get_option('site_icon') }}"></i></span>
                        <input id="icon" name="site_icon" type="text" value="{{ get_option('site_icon') }}" class="form-control icp icp-auto iconpicker-element iconpicker-input"
                            data-placement="bottomRight">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('company_logo') </label>
                    <div class="col-lg-6">
                        <input type="file" name="company_logo">
                    </div>
                    <div class="col-lg-2">
                        @if (get_option('company_logo') != '')
                        <div class="settings-image">
                            <img src="{{ getStorageUrl(config('system.media_dir').'/'.get_option('company_logo'))  }}" />
                        </div>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('login_background') </label>
                    <div class="col-lg-6">
                        <input type="file" name="login_bg">
                    </div>
                    <div class="col-lg-2">
                        @if (get_option('login_bg') != '')
                        <div class="settings-image">
                            <img src="{{ getStorageUrl(config('system.media_dir').'/'.get_option('login_bg'))  }}" />
                        </div>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('favicon') </label>
                    <div class="col-lg-6">
                        <input type="file" name="site_favicon">
                    </div>
                    <div class="col-lg-2">
                        @if (get_option('site_favicon') != '')
                        <div class="settings-image">
                            <img src="{{ getStorageUrl(config('system.media_dir').'/'.get_option('site_favicon'))  }}" />
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('apple_icon')</label>
                    <div class="col-lg-6">
                        <input type="file" name="site_appleicon">
                    </div>
                    <div class="col-lg-2">
                        @if (get_option('site_appleicon') != '')
                        <div class="settings-image">
                            <img src="{{ getStorageUrl(config('system.media_dir').'/'.get_option('site_appleicon'))  }}" />
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('system_font')</label>
                    <div class="col-lg-6">
                        @php $font = get_option('system_font'); @endphp
                        <select name="system_font" class="form-control">
                            <option value="Default">None</option>
                            <option value="open_sans" {{  $font == 'open_sans' ? ' selected="selected"' : ''  }}>
                                Open Sans
                            </option>
                            <option value="open_sans_condensed" {{  $font == 'open_sans_condensed' ? ' selected="selected"' : ''  }}>
                                Open Sans Condensed
                            </option>
                            <option value="roboto" {{  $font == 'roboto' ? ' selected="selected"' : ''  }}>
                                Roboto
                            </option>
                            <option value="roboto_condensed" {{  $font == 'roboto_condensed' ? ' selected="selected"' : ''  }}>
                                Roboto Condensed
                            </option>
                            <option value="ubuntu" {{  $font == 'ubuntu' ? ' selected="selected"' : ''  }}>
                                Ubuntu
                            </option>
                            <option value="lato" {{  $font == 'lato' ? ' selected="selected"' : ''  }}>
                                Lato
                            </option>
                            <option value="oxygen" {{  $font == 'oxygen' ? ' selected="selected"' : ''  }}>
                                Oxygen
                            </option>
                            <option value="pt_sans" {{  $font == 'pt_sans' ? ' selected="selected"' : '' }}>
                                PT Sans
                            </option>
                            <option value="source_sans" {{  $font == 'source_sans' ? ' selected="selected"' : '' }}>
                                Source Sans Pro
                            </option>
                            <option value="muli" {{  $font == 'muli' ? ' selected="selected"' : '' }}>
                                Muli
                            </option>

                            <option value="miriam" {{  $font == 'miriam' ? ' selected="selected"' : '' }}>
                                Miriam Libre
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Text Direction</label>
                    <div class="col-lg-6">
                        <select name="rtl" class="form-control">

                            <option value="TRUE" {{  settingEnabled('rtl') ? ' selected="selected"' : '' }}>RTL</option>
                            <option value="FALSE" {{  !settingEnabled('rtl') ? ' selected="selected"' : ''  }}>LTR</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Default WYSIWYG Editor</label>
                    <div class="col-lg-6">
                        <select name="htmleditor" class="form-control">
                            <option value="easyMDE" {{ get_option('htmleditor') == 'easyMDE' ? ' selected' : ''  }}>EasyMDE Editor (Markdown)</option>
                            <option value="summernoteEditor" {{ get_option('htmleditor') == 'summernoteEditor' ? ' selected' : '' }}>Summernote (HTML Editor)</option>
                            <option value="markdownEditor" {{ get_option('htmleditor') == 'markdownEditor' ? ' selected' : ''  }}>Bootstrap Markdown Editor</option>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('sidebar_theme') </label>
                    <div class="col-lg-6">
                        <?php $theme = get_option('sidebar_theme'); ?>
                        <select name="sidebar_theme" class="form-control">
                            <option value="light lter" {{  $theme == 'light lter' ? ' selected="selected"' : ''  }}>
                                Light
                            </option>
                            <option value="dark" {{  $theme == 'dark' ? ' selected="selected"' : ''  }}>Dark</option>
                            <option value="black" {{  $theme == 'black' ? ' selected="selected"' : ''  }}>Black</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('theme_color') </label>
                    <div class="col-lg-6">
                        <?php $theme = get_option('theme_color'); ?>
                        <select name="theme_color" class="form-control">
                            <option value="success" {{  $theme == 'success' ? ' selected="selected"' : ''  }}>Success
                            </option>
                            <option value="info" {{  $theme == 'info' ? ' selected="selected"' : '' }}>Info</option>
                            <option value="danger" {{  $theme == 'danger' ? ' selected="selected"' : '' }}>Danger
                            </option>
                            <option value="warning" {{  $theme == 'warning' ? ' selected="selected"' : '' }}>Warning
                            </option>
                            <option value="dark" {{  $theme == 'dark' ? ' selected="selected"' : '' }}>Dark</option>
                            <option value="primary" {{  $theme == 'primary' ? ' selected="selected"' : '' }}>Primary
                            </option>
                            <option value="dracula" {{  $theme == 'dracula' ? ' selected="selected"' : '' }}>Dracula
                            </option>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-lg-3 control-label">Widget Background</label>
                    <div class="col-lg-6">
                        <?php $widget_bg = get_option('widget_bg'); ?>
                        <select name="widget_bg" class="form-control">
                            <option value="success" {{ $widget_bg == 'success' ? ' selected' : ''  }}>Success</option>
                            <option value="info" {{ $widget_bg == 'info' ? ' selected' : '' }}>Info</option>
                            <option value="danger" {{ $widget_bg == 'danger' ? ' selected' : '' }}>Danger</option>
                            <option value="warning" {{ $widget_bg == 'warning' ? ' selected' : '' }}>Warning</option>
                            <option value="dark" {{ $widget_bg == 'dark' ? ' selected' : '' }}>Dark</option>
                            <option value="primary" {{ $widget_bg == 'primary' ? ' selected' : '' }}>Primary</option>
                            <option value="dracula" {{ $widget_bg == 'dracula' ? ' selected' : '' }}>Dracula</option>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('top_bar_color') </label>
                    <div class="col-lg-6">

                        <?php $theme = get_option('top_bar_color'); ?>
                        <select name="top_bar_color" class="form-control">
                            <option value="success" {{  $theme == 'success' ? ' selected="selected"' : '' }}>Success</option>
                            <option value="info" {{  $theme == 'info' ? ' selected="selected"' : '' }}>Info</option>
                            <option value="danger" {{  $theme == 'danger' ? ' selected="selected"' : '' }}>Danger</option>
                            <option value="warning" {{  $theme == 'warning' ? ' selected="selected"' : '' }}>Warning</option>
                            <option value="dark" {{  $theme == 'dark' ? ' selected="selected"' : '' }}>Dark</option>
                            <option value="primary" {{  $theme == 'primary' ? ' selected="selected"' : '' }}>Primary</option>
                            <option value="dracula" {{  $theme == 'dracula' ? ' selected="selected"' : '' }}>Dracula</option>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('hide_sidebar') </label>
                    <div class="col-lg-6">
                        <label class="switch">
                            <input type="hidden" value="FALSE" name="hide_sidebar" />
                            <input type="checkbox" {{ settingEnabled('hide_sidebar') ? 'checked="checked"' : '' }} name="hide_sidebar" value="TRUE" />
                            <span></span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">Blur Login</label>
                    <div class="col-lg-6">
                        <label class="switch">
                            <input type="hidden" value="FALSE" name="blur_login" />
                            <input type="checkbox" {{ settingEnabled('blur_login') ? 'checked="checked"' : '' }} name="blur_login" value="TRUE" />
                            <span></span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label">@langapp('hide_branding')</label>
                    <div class="col-lg-6">
                        <label class="switch">
                            <input type="hidden" value="FALSE" name="hide_branding" />
                            <input type="checkbox" {{ settingEnabled('hide_branding') ? 'checked' : '' }} value="TRUE" name="hide_branding" />
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Site Meta Author</label>
                    <div class="col-lg-6">
                        <x-inputs.text for="site_author" value="{{get_option('site_author')}}" name="site_author" />
                        @error('site_author') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Site Meta Keywords</label>
                    <div class="col-lg-6">
                        <x-inputs.text for="site_keywords" value="{{get_option('site_keywords')}}" name="site_keywords" />
                        @error('site_keywords') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Site Meta Description</label>
                    <div class="col-lg-6">
                        <x-inputs.text for="site_desc" value="{{get_option('site_desc')}}" name="site_desc" />
                        @error('site_desc') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>


            </div>
            <div class="panel-footer">
                {!! renderAjaxButton() !!}
            </div>
        </section>
        {!! Form::close() !!}
    </div>
</div>

@push('pagestyle')
<link rel="stylesheet" href="{{ getAsset('plugins/iconpicker/fontawesome-iconpicker.min.css') }}" type="text/css" />
@endpush
@push('pagescript')
@include('stacks.js.iconpicker')
@endpush