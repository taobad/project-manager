<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="{{ get_option('site_author') }}">
  <meta name="keywords" content="{{ get_option('site_keywords') }}">
  <meta name="description" content="{{ get_option('site_desc') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Subscription Declined</title>
  <link rel="stylesheet" href="{{ getAsset('css/theme.css') }}" type="text/css" />
  <link rel="stylesheet" href="{{ getAsset('css/app.css') }}" type="text/css" />
  <link rel="stylesheet" href="{{ getAsset('storage/css/style.css') }}" type="text/css" />
  <link rel="stylesheet" href="{{ getAsset('css/sofia.css') }}" type="text/css" />

  <link rel="icon" type="image/png" href="{{ getStorageUrl(config('system.media_dir').'/'.get_option('site_favicon')) }}">
  <link rel="apple-touch-icon" href="{{ getStorageUrl(config('system.media_dir').'/'.get_option('site_appleicon')) }}" />
  <?php
    $family = 'Sofia';
    $font = get_option('system_font');
    switch ($font) {
    case 'open_sans':
        $family = 'Open Sans';
        echo "<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,latin-ext,greek-ext,cyrillic-ext' rel='stylesheet' type='text/css'>";
        break;
    case 'open_sans_condensed':
        $family = 'Open Sans Condensed';
        echo "<link href='//fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700&subset=latin,greek-ext,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>";
        break;
    case 'roboto':
        $family = 'Roboto';
        echo "<link href='//fonts.googleapis.com/css?family=Roboto:400,300,500,700&subset=latin,greek-ext,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>";
        break;
    case 'roboto_condensed':
        $family = 'Roboto Condensed';
        echo "<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700&subset=latin,greek-ext,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>";
        break;
    case 'ubuntu':
        $family = 'Ubuntu';
        echo "<link href='//fonts.googleapis.com/css?family=Ubuntu:400,300,500,700&subset=latin,greek-ext,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>";
        break;
    case 'lato':
        $family = 'Lato';
        echo "<link href='//fonts.googleapis.com/css?family=Lato:100,300,400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>";
        break;
    case 'oxygen':
        $family = 'Oxygen';
        echo "<link href='//fonts.googleapis.com/css?family=Oxygen:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>";
        break;
    case 'pt_sans':
        $family = 'PT Sans';
        echo "<link href='//fonts.googleapis.com/css?family=PT+Sans:400,700&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>";
        break;
    case 'source_sans':
        $family = 'Source Sans Pro';
        echo "<link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:400,700&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>";
        break;
    case 'muli':
        $family = 'Muli';
        echo "<link href='//fonts.googleapis.com/css?family=Muli' rel='stylesheet'>";
        break;
    case 'miriam':
        $family = 'Miriam Libre';
        echo "<link href='//fonts.googleapis.com/css?family=Miriam+Libre' rel='stylesheet'>";
        break;
    }
    ?>
  <style type="text/css">
    body {
      /* Set system font dynamically */
      font-family: '{{ $family }}';
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    .h1,
    .h2,
    .h3,
    .h4,
    .h5,
    .h6 {
      font-family: '{{ $family }}',
      sans-serif;
    }
  </style>
</head>

<body>
  <div class="row no-margin h-fullscreen p-t2">
    <div class="col-12">
      <div class="mx-auto text-center card card-transparent">
        <h1 class="text-secondary text-muted font200">✘</h1>

        <h3 class="text-uc">Unsubscribed</h3>
        <p class="lead">You will no longer receive emails from <strong> {{ get_option('company_name') }}</strong></p>
        <div class="m-md">
          <a href="#" onclick="window.close()" class="btn {{themeButton()}}">
            @icon('solid/times-circle') Close</a>
        </div>

      </div>
    </div>
    <footer class="text-center col-12 align-self-end fs-13">
      <strong>{{ $lead->email }}</strong> has been unsubscribed.
    </footer>

  </div>
  <script src="{{ getAsset('js/app.js') }}"></script>
  @push('pagescript')
  <script>
    $(document).ready(function(){
    toastr.options.positionClass = '{{ config('toastr.options.positionClass') }}';
    });
  </script>
  {!! Toastr::message() !!}
  @endpush
  @stack('pagescript')
</body>

</html>