@if(isset($showPageRegister) && $showPageRegister == 1)

@includeIf('share.topHeader', ['data' => '' ])

  <!--=================================
  Register -->
  <section class="pt-5 bg-grey">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-10 col-md-12">
          <div class="login-register p-4" style="border: 2px dotted #eee; background: #f9f9f9;">
           <div class="section-title">
            <h4 class="text-center">Choose your Account Type</h4>
           </div>

            @includeIf('share.registerType', ['title' => isset($registrationTitle) ? $registrationTitle : '' ])

            <div class="tab-content mb-5">
                <div class="tab-pane active" id="candidate" role="tabpanel">

                  <form method="post" action="{{ (Route::has('postRegisterCandidate') ? Route('postRegisterCandidate') : '#') }}" id="customer_login" enctype="multipart/form-data">
                    @csrf
                        {{-- Personal Information --}}
                        <fieldset>
                            <legend class="px-2">Personal Information</legend>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="firstName">First Name <span class="text-danger">*</span> </label>
                                        <input type="text" value="{{old('firstName')}}" name="firstName" required class="form-control @error('firstName') is-invalid @enderror">
                                        @error('firstName')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="lastName"> Last Name <span class="text-danger">*</span> </label>
                                        <input type="text" value="{{old('lastName')}}"  name="lastName" required class="form-control @error('lastName') is-invalid @enderror">
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
                                                <option value="{{$day}}" {{ (old('dayOfYourBirth') == $day ? 'selected' : '') }}>{{$day}}</option>
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
                                                    <option value="{{$month}}" {{ (old('monthOfYourBirth') == $month ? 'selected' : '') }}>{{$month}}</option>
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
                                                <option value="{{ $yr }}" {{ (old("yearOfYourBirth") == $yr ? "selected":"") }}> {{ $yr }} </option>
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
                                        <select name="gender" required class="basic-select form-control @error('gender') is-invalid @enderror">
                                            <option value="">Select</option>
                                            <option value="Male" {{old('gender') == 'Male' ? 'selected' : ''}}>Male</option>
                                            <option value="Female" {{old('gender') == 'Female' ? 'selected' : ''}}>Female</option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="location"> Location/City <span class="text-danger">*</span> </label>
                                        <input type="text"  name="location" value="{{old('location')}}"  required class="form-control @error('location') is-invalid @enderror">
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
                                        <input type="text"  name="phoneNumber" value="{{old('phoneNumber')}}" required class="form-control @error('phoneNumber') is-invalid @enderror">
                                        @error('phoneNumber')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </fieldset>

                            {{-- Login Detais --}}
                            <fieldset class="mt-3">
                                <legend class="px-2">Login Details</legend>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="username">Username <span class="text-danger">*</span> </label>
                                        <input type="text"  name="username" value="{{old('username')}}" required class="form-control @error('username') is-invalid @enderror">
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="emailAddress">Email Address <span class="text-danger">*</span> </label>
                                        <input type="email" name="emailAddress" value="{{old('emailAddress')}}" required class="form-control @error('emailAddress') is-invalid @enderror">
                                        @error('emailAddress')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="password">Password <span class="text-danger">*</span> </label>
                                        <input type="password" name="password"  required class="form-control @error('password') is-invalid @enderror">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="password_confirmation">Confirm Password <span class="text-danger">*</span> </label>
                                        <input type="password" required name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-group col-12 pt-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" checked disabled class="custom-control-input" id="accepts-01">
                                    <label class="custom-control-label" for="accepts-01">You accept our <a href="{{ Route::has('readTermCondition') ? Route('readTermCondition') : 'javascript:;' }}">Terms & Conditions and Privacy Policy</a> </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div align="center" class="col-md-12">
                                <button type="submit" class="btn btn-outline-primary btn-block d-block">
                                    CREATE ACCOUNT
                                </button>
                            </div>
                            <div class="col-md-12 text-md-left mt-2 text-center">
                                <p>Already registered? <a href="{{ Route::has('login') ? Route('login') : 'javascript:;' }}"> Sign in here</a></p>
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
