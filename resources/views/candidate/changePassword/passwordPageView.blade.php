@if(isset($showPageSecurity) && $showPageSecurity == 1)


<!--=================================
Change Password -->
<section>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="user-dashboard-info-box">
            <div class="section-title-02 mb-4">
              <h4>Change Password</h4>
            </div>
            <div class="row">
              <div class="col-12">

                <form method="post" action="{{ (Route::has('postChangePassword') ? Route('postChangePassword') : '#') }}" enctype="multipart/form-data">
                    @csrf
                       <div class="user-dashboard-info-box">
                           <div class="form-row">
                               <div class="form-group col-md-4">
                                   <label for="currentPassword"> Current Password </label>
                                   <input type="password"  name="currentPassword" required class="form-control @error('currentPassword') is-invalid @enderror">
                                   @error('currentPassword')
                                       <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                       </span>
                                   @enderror
                               </div>
                               <div class="form-group col-md-4">
                                   <label for="password"> New Password  </label>
                                   <input type="password"  name="password" required class="form-control @error('password') is-invalid @enderror">
                                   @error('password')
                                       <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                       </span>
                                   @enderror
                               </div>
                               <div class="form-group col-md-4">
                                   <label for="password_confirmation"> Confirm New Password  </label>
                                   <input type="password"  name="password_confirmation" required class="form-control @error('password_confirmation') is-invalid @enderror">
                                   @error('password_confirmation')
                                       <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                       </span>
                                   @enderror
                               </div>
                               <div class="form-group col-md-12">
                                   <label for="instagram">  </label>
                                   <div class="form-row mb-4">
                                    <div align="center" class="col-md-12">
                                        <button type="submit" class="btn btn-primary d-block">
                                            UPDATE PASSWORD
                                        </button>
                                    </div>
                                </div>
                               </div>
                           </div>

                       </div>
                   </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--=================================
  Change Password -->


@endif
