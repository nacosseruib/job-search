@if(isset($showPageUploadImages) && $showPageUploadImages == 1)


<!--=================================
Change Password -->
<section>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="user-dashboard-info-box">
            <div class="section-title-02 mb-4">
              <h4>Upload Profile Photos</h4>
            </div>
            <div class="row">
              <div class="col-12">

                <form method="post" action="{{ (Route::has('postProfileImage') ? Route('postProfileImage') : '#') }}" enctype="multipart/form-data">
                    @csrf
                       <div class="user-dashboard-info-box">
                           <div class="form-row">
                               <div class="form-group col-md-6">
                                   <label for="profilePhoto"> Profile Photo </label>
                                   <input type="file" name="profilePhoto" class="form-control">
                                   @error('profilePhoto')
                                       <span class="invalid-feedback" role="alert">
                                           <strong>{{ $message }}</strong>
                                       </span>
                                   @enderror
                               </div>
                               <div class="form-group col-md-6">
                                    <label for="profileCover"> Profile Cover Photo </label>
                                    <input type="file" name="profileCover" class="form-control">
                                    @error('profileCover')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                               <div class="form-group col-md-12">
                                    <hr />
                               </div>
                               <div class="form-group col-md-12">
                                    <div align="center" class="col-md-12">
                                        <button type="submit" class="btn btn-primary d-block">
                                           UPLOAD PHOTO
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
