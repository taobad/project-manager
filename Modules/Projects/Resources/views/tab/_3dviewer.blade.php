@if(($project->setting('show_project_3dviewer') && $project->isClient()) || isAdmin() || $project->isTeam())

@push('pagestyle')
  {{-- <meta http-equiv="Content-Security-Policy" content="default-src https://cdnjs.cloudflare.com; child-src 'none'; object-src 'none'"> --}}
    <!-- Common packages: jQuery, Bootstrap, jsTree -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    {{-- <script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script> --}}
    {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.7/jstree.min.js"></script> --}}
    {{-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css"> --}}

    {{-- <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous"> --}}

    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script> --}}
    <link rel="stylesheet" href="{{ asset('css/jstree.min.css') }}" />
    <!-- Autodesk Forge Viewer files -->
    {{-- <link rel="stylesheet" href="//developer.api.autodesk.com/modelderivative/v2/viewers/7.*/style.min.css" type="text/css"> --}}
    <link rel="stylesheet" href="{{ asset('css/autodesk.min.css') }}" type="text/css">
    
    <!-- this project files -->
    <link href="{{ asset('css/forge.css') }}" rel="stylesheet" />
    
@endpush

<div class="container">
    <!-- Fixed navbar by Bootstrap: https://getbootstrap.com/examples/navbar-fixed-top/ -->
  {{-- <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
      <ul class="nav navbar-nav left">
        <li>
          <a href="http://forge.autodesk.com" target="_blank">
            <img alt="Autodesk Forge" src="//developer.static.autodesk.com/images/logo_forge-2-line.png" height="20">
          </a>
        </li>
      </ul>
    </div>
  </nav> --}}
  <!-- End of navbar -->
  <div class="container-fluid fill mt-5">
    <div class="row fill">
      <div class="col-sm-4 fill">
        <div class="panel panel-default fill">
          <div class="panel-heading" data-toggle="tooltip">
            Buckets &amp; Objects
            <span id="refreshBuckets" class="glyphicon glyphicon-refresh" style="cursor: pointer"></span>
            <button class="btn btn-xs btn-info" style="float: right" id="showFormCreateBucket" data-toggle="modal" data-target="#createBucketModal">
              <span class="glyphicon glyphicon-folder-close"></span> New bucket
            </button>
          </div>
          <div id="appBuckets">
            tree here
          </div>
        </div>
      </div>
      <div class="col-sm-8 fill">
        <div id="forgeViewer"></div>
      </div>
    </div>
  </div>
  <form id="uploadFile" method='post' enctype="multipart/form-data">
    <input id="hiddenUploadField" type="file" name="theFile" style="visibility:hidden" />
  </form>
  <!-- Modal Create Bucket -->
  <div class="modal fade" id="createBucketModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cancel">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="myModalLabel">Create new bucket</h4>
        </div>
        <div class="modal-body">
          <input type="text" id="newBucketKey" class="form-control"> For demonstration purposes, objects (files)
          are NOT automatically translated. After you upload, right click on
          the object and select "Translate". Note: Technically your bucket name is required to be globally unique across
          the entire platform - to keep things simple with this tutorial your client ID will be prepended by default to
          your bucket name and in turn masked by the UI so you only have to make sure your bucket name is unique within
          your current Forge app.
        </div>
        <input type="hidden" id="csrf_token" name="csrf_token" value="{{csrf_token()}}">
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="createNewBucket">Go ahead, create the bucket</button>
        </div>
      </div>
    </div>
  </div>
</div>

@push('pagescript')
  <script src="https://developer.api.autodesk.com/modelderivative/v2/viewers/7.*/viewer3D.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.7/jstree.min.js"></script>
  <script src="{{ asset('js/ForgeTree.js') }}"></script>
  <script src="{{ asset('js/ForgeTreeViewer.js') }}"></script>
@endpush

@endif