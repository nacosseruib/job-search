@if(isset($showPageCandidateProfile) && $showPageCandidateProfile == 1)


<!--=================================
My Profile -->
<section>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="user-dashboard-info-box">
            <div class="section-title-02 mb-2">
              <h4>Basic Information</h4>
            </div>

            <div class="cover-photo-contact">
              <div class="upload-file">
                <div class="custom-file">
                  <a href="{{ Route::has('createProfileImage') ? Route('createProfileImage') : 'javascript:;' }}" class="custom-file-label">Upload Profile Photo</a>
                </div>
              </div>
            </div>


              <form method="post" action="{{ (Route::has('saveChangesBasicInfoCandiate') ? Route('saveChangesBasicInfoCandiate') : '#') }}" enctype="multipart/form-data">
                @csrf

                    <fieldset>
                        <legend class="px-2"></legend>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="firstName">First Name <span class="text-danger">*</span> </label>
                                    <input type="text" value="{{ (isset($userProfile) && $userProfile) ? $userProfile->first_name : '' }}" name="firstName" required class="form-control @error('firstName') is-invalid @enderror">
                                    @error('firstName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="lastName"> Last Name <span class="text-danger">*</span> </label>
                                    <input type="text" value="{{ (isset($userProfile) && $userProfile) ? $userProfile->last_name : '' }}"  name="lastName" required class="form-control @error('lastName') is-invalid @enderror">
                                    @error('lastName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12 text-left">
                                    Date of Birth <span class="text-danger">*</span>
                                </div>
                                <div class="form-group col-md-4">
                                    <select name="dayOfYourBirth" required class="form-control basic-select @error('dayOfYourBirth') is-invalid @enderror">
                                        <option value="" selected="selected">Day</option>
                                        @for($day = 1; $day <= 31; $day++)
                                            <option value="{{$day}}" {{ ((isset($userProfile) && $userProfile) ? $userProfile->day_of_birth : '') == $day ? 'selected' : '' }}>{{$day}}</option>
                                        @endfor
                                    </select>
                                    @error('dayOfYourBirth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <select name="monthOfYourBirth" required class="form-control @error('monthOfYourBirth') is-invalid @enderror basic-select">
                                        <option value="" selected="selected">Month</option>
                                        @if(isset($months) && $months)
                                            @foreach($months as $month)
                                                <option value="{{$month}}" {{ (((isset($userProfile) && $userProfile) ? $userProfile->month_of_birth : '') == $month ? 'selected' : '') }}>{{$month}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('monthOfYourBirth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <select name="yearOfYourBirth" required class="form-control @error('yearOfYourBirth') is-invalid @enderror basic-select">
                                        <option value="" selected="selected">Year</option>
                                        @for($yr = date('Y'); $yr >= 1960; $yr --)
                                            <option value="{{ $yr }}" {{ (((isset($userProfile) && $userProfile) ? $userProfile->year_of_birth : '') == $yr ? "selected":"") }}> {{ $yr }} </option>
                                        @endfor
                                    </select>
                                    @error('yearOfYourBirth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="gender"> Gender <span class="text-danger">*</span> </label>
                                    <select name="gender" required class="form-control @error('gender') is-invalid @enderror">
                                        <option value="">Select</option>
                                        <option value="Male" {{ ((isset($userProfile) && $userProfile) ? $userProfile->gender : '') == 'Male' ? 'selected' : ''}}>Male</option>
                                        <option value="Female" {{ ((isset($userProfile) && $userProfile) ? $userProfile->gender : '') == 'Female' ? 'selected' : ''}}>Female</option>
                                    </select>
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="location"> Location/City <span class="text-danger">*</span> </label>
                                    <input type="text"  name="location" value="{{ ((isset($userProfile) && $userProfile) ? $userProfile->location_city : '') }}"  required class="form-control @error('location') is-invalid @enderror">
                                    @error('location')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="country"> Country <span class="text-danger">*</span> </label>
                                    @includeIf('share.country', ['fieldName' => 'country', 'isRequired'=>1])
                                    @error('country')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="countryCode"> Country Code <span class="text-danger">*</span> </label>
                                    @includeIf('share.countryCode', ['fieldName' => 'countryCode', 'isRequired'=>1])
                                    @error('countryCode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phoneNumber"> Phone Number <span class="text-danger">*</span> </label>
                                    <input type="text"  name="phoneNumber" value="{{ ((isset($userProfile) && $userProfile) ? $userProfile->phone_number : '') }}" required class="form-control @error('phoneNumber') is-invalid @enderror">
                                    @error('phoneNumber')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="username">Username <span class="text-danger">*</span> </label>
                                    <div class="form-control bg-light">{{ ((isset($userProfile) && $userProfile) ? $userProfile->username : '') }}</div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="emailAddress">Email Address <span class="text-danger">*</span> </label>
                                    <input type="email" name="emailAddress" value="{{ ((isset($userProfile) && $userProfile) ? $userProfile->email : '') }}" required class="form-control @error('emailAddress') is-invalid @enderror">
                                    @error('emailAddress')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </fieldset>




                <div class="user-dashboard-info-box">
                    <div class="section-title-02 mb-3">
                        <h4>Social Links</h4>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="facebook"> Facebook Link </label>
                            <input type="text"  name="facebook" value="{{ ((isset($userProfile) && $userProfile) ? $userProfile->facebook : '') }}" class="form-control @error('facebook') is-invalid @enderror">
                            @error('facebook')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="twitter"> Twitter Handle  </label>
                            <input type="text"  name="twitter" value="{{ ((isset($userProfile) && $userProfile) ? $userProfile->twitter : '') }}" class="form-control @error('twitter') is-invalid @enderror">
                            @error('twitter')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="linkedin"> LinkedIn Link  </label>
                            <input type="text"  name="linkedin" value="{{ ((isset($userProfile) && $userProfile) ? $userProfile->linkedin : '') }}" class="form-control @error('linkedin') is-invalid @enderror">
                            @error('linkedin')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="instagram"> Instagram Handle </label>
                            <input type="text"  name="instagram" value="{{ ((isset($userProfile) && $userProfile) ? $userProfile->instagram : '') }}" class="form-control @error('instagram') is-invalid @enderror">
                            @error('instagram')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row mb-4">
                        <div align="right" class="col-md-12">
                            <button type="submit" class="btn btn-primary d-block">
                                SAVE CHANGES
                            </button>
                        </div>
                    </div>
                    <hr />
                </div>
            </form>

           {{-- <div class="user-dashboard-info-box">
            <div class="form-group mb-0">
              <h4 class="mb-3">Address</h4>
              <div class="form-group">
                <label>Enter Your Location</label>
                <input type="text" class="form-control" value="214 West Arnold St. New York, NY 10002">
              </div>
              <div class="company-address-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509374!2d144.95373531590414!3d-37.817323442021134!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d4c2b349649%3A0xb6899234e561db11!2sEnvato!5e0!3m2!1sen!2sin!4v1559039794237!5m2!1sen!2sin"  height="400" allowfullscreen></iframe>
              </div>
            </div>
          </div>
          <a class="btn btn-md btn-primary" href="#">Save Settings</a> --}}

        </div>
        </div>
      </div>
    </div>
  </section>


@endif
