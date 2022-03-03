@if(isset($showPageRegister) && $showPageRegister == 1)

@includeIf('share.topHeader', ['data' => '' ])

  <!--=================================
  Register -->
  <section class="pt-5 bg-grey">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10 col-md-12">
          <div class="login-register p-4" style="border: 2px dotted #eee;  background: #f9f9f9;">
           <div class="section-title">
            <h4 class="text-center">@yield('pageTitle')</h4>
           </div>

            <div class="tab-content mb-5">

                <div class="tab-pane active" id="candidate" role="tabpanel">

                   <form method="post" action="{{ (Route::has('login') ? Route('login') : '#') }}" id="customer_login" enctype="multipart/form-data">
                     @csrf
                        <fieldset>
                            <legend class="px-2">Account Login</legend>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="username">Username/Email Address <span class="text-danger">*</span> </label>
                                        <input type="text"  name="username" required class="form-control @error('username') is-invalid @enderror">
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="password"> Password <span class="text-danger">*</span> </label>
                                        <input type="password" name="password" required class="form-control @error('password') is-invalid @enderror">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                            </fieldset>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-block btn-outline-primary d-block" href="{{ Route::has('login') ? Route('login') : 'javascript' }}">
                                    LOGIN
                                </button>
                            </div>
                            <div class="col-md-12 text-md-left mt-2 text-center">
                                <p> Don't have account <a href="{{ Route::has('registerCandidate') ? Route('registerCandidate') : 'javascript:;' }}"> Sign up here</a></p>
                            </div>
                        </div>
                    </form>
                </div>
                </div>

                <br /><br />

            </div>
            </div>
        </div>
        </div>
    </section>

@endif
