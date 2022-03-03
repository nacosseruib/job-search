
<div class="header-inner" style="background-image:url({{ asset('assets/images/top-header-bg.jpg')}})">
    <div class="container text-center">
      <div class="row">
        <div class="col-12">
          <h2 class="text-primary">@yield('pageTitle')</h2>
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="{{ Route::has('index') ? Route('index') : 'javascript' }}"> Home </a></li>
            <li class="breadcrumb-item active"> <i class="fas fa-chevron-right"></i> <span> @yield('pageTitle') </span></li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="">
    @includeIf('share.operationCallBackAlert', ['showAlert' => 1])
 </div>

