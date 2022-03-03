@if(isset($showPageRegister) && $showPageRegister == 1)

@includeIf('share.topHeader', ['data' => '' ])

  <!--=================================
  Register -->
  <section class="pt-5">
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

                    <form method="post" action="{{ (Route::has('postRegisterEmployer') ? Route('postRegisterEmployer') : '#') }}" id="customer_login" enctype="multipart/form-data">
                    @csrf

                        {{-- Personal Information --}}
                        <fieldset>
                            <legend class="px-2">Contact Information </legend>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="contactFullName">Full Name <span class="text-danger">*</span> </label>
                                        <input type="text"  name="contactFullName"  value="{{old('contactFullName')}}" required class="form-control @error('contactFullName') is-invalid @enderror">
                                        @error('contactFullName')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="contactEmail"> Email Address <span class="text-danger">*</span> </label>
                                        <input type="email" name="contactEmail" value="{{old('contactEmail')}}" required class="form-control @error('contactEmail') is-invalid @enderror">
                                        @error('contactEmail')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                            </fieldset>

                        {{-- Company Information --}}
                        <fieldset class="mt-3">
                            <legend class="px-2">Company Information </legend>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="companyName">Comapny Name <span class="text-danger">*</span> </label>
                                        <input type="text"  name="companyName" value="{{old('companyName')}}" required class="form-control @error('companyName') is-invalid @enderror">
                                        @error('companyName')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="industry"> Industry <span class="text-danger">*</span> </label>
                                        <select name="industry" class="basic-select form-control @error('industry') is-invalid @enderror" required>
                                            <option value="">Select</option>
                                            @if(isset($allIndustries) && $allIndustries)
                                                @foreach($allIndustries as $key => $value)
                                                    <option value="{{ $value->industryID }}" {{old('industry') == $value->industryID ? 'selected' : '' }}>{{ $value->industry_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('industry')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="countryCode"> Country Code <span class="text-danger">*</span> </label>
                                        @includeIf('share.countryCode', ['fieldName' => 'countryCode', 'isRequired'=>1])
                                        @error('countryCode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="companyPhoneNumber"> Phone Number <span class="text-danger">*</span> </label>
                                        <input type="text"  value="{{old('companyPhoneNumber')}}" name="companyPhoneNumber" required class="form-control @error('companyPhoneNumber') is-invalid @enderror">
                                        @error('companyPhoneNumber')
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
                                        <label for="noOfEmployees"> Number of Employees <span class="text-danger">*</span> </label>
                                        <select name="noOfEmployees" class="basic-select form-control @error('noOfEmployees') is-invalid @enderror" required>
                                            <option value="">Select</option>
                                            <option>1-5</option>
                                            <option>6-10</option>
                                            <option>11-15</option>
                                            <option>16-20</option>
                                            <option>21-50</option>
                                            <option>51-100</option>
                                            <option>101-150</option>
                                            <option>151-200</option>
                                            <option>201-500</option>
                                            <option>501-1000</option>
                                            <option>1000+</option>
                                        </select>
                                        @error('noOfEmployees')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="typeOfEmployer"> Type of Employer <span class="text-danger">*</span> </label>
                                        <select name="typeOfEmployer" class="basic-select form-control @error('typeOfEmployer') is-invalid @enderror" required>
                                            <option value="">Select</option>
                                            @if(isset($userType) && $userType)
                                                @foreach($userType as $key => $value)
                                                    <option value="{{ $value->user_typeID }}" {{old('typeOfEmployer') == $value->user_typeID ? 'selected' : '' }}>{{ $value->type_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('typeOfEmployer')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="companyWebsite">Comapny Website </label>
                                        <input type="text"  name="companyWebsite" value="{{old('companyWebsite')}}" class="form-control @error('companyWebsite') is-invalid @enderror">
                                        @error('companyWebsite')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="address"> Company Full Address <span class="text-danger">*</span> </label>
                                        <textarea name="address" required class="form-control @error('address') is-invalid @enderror">{{old('address')}}</textarea>
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </fieldset>


                            {{-- Login Detais --}}
                            <fieldset class="mt-3">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="firstName">First Name <span class="text-danger">*</span> </label>
                                        <input type="text"  name="firstName" value="{{old('firstName')}}" required class="form-control @error('firstName') is-invalid @enderror">
                                        @error('firstName')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="lastName"> Last Name <span class="text-danger">*</span> </label>
                                        <input type="text" name="lastName" required value="{{old('lastName')}}" class="form-control @error('lastName') is-invalid @enderror">
                                        @error('lastName')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <legend class="px-2">Login Details</legend>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="username">Username <span class="text-danger">*</span> </label>
                                        <input type="text"  name="username" value="{{old('username')}}"  required class="form-control @error('username') is-invalid @enderror">
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
                                        <input type="password" name="password" required class="form-control @error('password') is-invalid @enderror">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="password_confirmation">Confirm Password <span class="text-danger">*</span> </label>
                                        <input type="password" required name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" >
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
