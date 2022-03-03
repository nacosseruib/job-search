<!--=================================
inner banner -->
<div class="header-inner" style="background-image:url({{ (isset($userCoverPhoto) ? $userCoverPhoto : asset('assets/images/top-header-bg.jpg')) }});">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="candidates-user-info">
            <div class="jobber-user-info">
              <div class="profile-avatar">
                <img class="img-fluid " src="{{ (isset($userPhoto) ? $userPhoto :  asset('assets/images/noPicture.png')) }}" alt="">
               <a href="{{ Route::has('createProfileImage') ? Route('createProfileImage') : 'javascript:;' }}">
                     <i class="fas fa-pencil-alt"></i>
               </a>
              </div>
              <div class="profile-avatar-info ml-4">
                <h3 class="bg-light text-dark p-1">{{ isset($userFullName) ? ucfirst($userFullName) : '' }}</h3>
              </div>
            </div>
          </div>
        </div>
        {{-- <div class="col-lg-6">
          <div class="progress">
            <div class="progress-bar" role="progressbar" style="width:85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
              <span class="progress-bar-number">85%</span>
            </div>
          </div>
          <div class="candidates-skills">
            <div class="candidates-skills-info">
              <h3 class="text-primary">85%</h3>
                <br />
            </div>
            <div class="candidates-required-skills ml-auto mt-sm-0 mt-3">
              <a class="btn btn-dark" href="javascript:;">Skills increase by job Title</a>
            </div>
          </div>
        </div> --}}
      </div>
    </div>
  </div>
  <!--=================================
  inner banner -->

  <!--=================================
  Dashboard Nav -->
  <section>
    <div class="container d-print-none">
      <div class="row">
        <div class="col-md-12">
          <div class="sticky-top secondary-menu-sticky-top">
            <div class="secondary-menu p-2">

                {{-- MENU --}}
                <div class="topnav" id="myTopnav">
                    <a class="@yield('dashboardPageActive')" href="{{ Route::has('dashboard') ? Route('dashboard') : 'javascript' }}">Dashboard</a>
                    @if(Auth::check())
                        @if(Session::get('userMenuModule'))
                            @foreach(Session::get('userMenuModule') as $key=>$module)
                                {{-- <a class="" href="javascript:;" id="navbarDropdown{{$key}}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ ($module ? $module->module_name : '') }}
                                </a> --}}
                                @foreach(Session::get('userMenu')[$key.$module->moduleID] as $subModule)
                                    <a class="@yield($subModule ? $subModule->submodule_active_page : '')" href="{{ (Route::has($subModule->submodule_url) ? Route($subModule->submodule_url) : 'javascript:;') }}">{{ (isset($subModule) && $subModule ? $subModule->submodule_name : '') }}</a>
                                @endforeach
                            @endforeach
                        @endif
                    @endif
                    @if(Auth::check())
                        <a class="" href="{{ Route::has('logout') ? Route('logout') : 'javascript' }}">Logout</a>
                    @else
                        <a class="" href="{{ Route::has('login') ? Route('login') : 'javascript' }}">Login</a>
                    @endif
                    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>
                {{-- END MENU --}}

            </div>
          </div>
        </div>
      </div>
      @includeIf('share.operationCallBackAlert', ['showAlert' => 1])
    </div>
  </section>

  <!--=================================
  Dashboard Nav -->
