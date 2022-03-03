@if(isset($showPageProfile) && $showPageProfile == 1)



<!--=================================
My Profile -->
<section>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="user-dashboard-info-box">

            <div class="cover-photo-contact">
              <div class="upload-file">
                <div class="custom-file">
                  <a href="{{ Route::has('createProfileImage') ? Route('createProfileImage') : 'javascript:;' }}" class="custom-file-label">Upload Photo/Cover</a>
                </div>
              </div>
            </div>


            <form method="post" action="{{ (Route::has('saveChangesBasicInfoEmployer') ? Route('saveChangesBasicInfoEmployer') : '#') }}" enctype="multipart/form-data">
                @csrf

                        <div class="user-dashboard-info-box">
                            <div class="section-title-02 mb-3">
                                <h4>Company Information</h4>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="companyName">Comapny Name <span class="text-danger">*</span> </label>
                                    <input type="text"  name="companyName" value="{{ (isset($userProfile) && $userProfile ? $userProfile->company_name :  old('companyName')) }}" required class="form-control @error('companyName') is-invalid @enderror">
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
                                                <option value="{{ $value->industryID }}" {{ isset($userProfile) && $userProfile->company_industry_id == $value->industryID ? 'selected' : (old('industry') == $value->industryID ? 'selected' : '') }}>{{ $value->industry_name }}</option>
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
                                    <input type="text"  value="{{ isset($userProfile) && $userProfile ? $userProfile->phone_number :''}}" name="companyPhoneNumber" required class="form-control @error('companyPhoneNumber') is-invalid @enderror">
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
                                    <input type="text"  name="location" value="{{ isset($userProfile) && $userProfile ? $userProfile->location_city : '' }}"  required class="form-control @error('location') is-invalid @enderror">
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
                                        <option {{isset($userProfile) && $userProfile && $userProfile->number_of_employee == '1-5' ? 'selected' : ''}}>1-5</option>
                                        <option {{isset($userProfile) && $userProfile && $userProfile->number_of_employee == '6-10' ? 'selected' : ''}}>6-10</option>
                                        <option {{isset($userProfile) && $userProfile && $userProfile->number_of_employee == '11-15' ? 'selected' : ''}}>11-15</option>
                                        <option {{isset($userProfile) && $userProfile && $userProfile->number_of_employee == '16-20' ? 'selected' : ''}}>16-20</option>
                                        <option {{isset($userProfile) && $userProfile && $userProfile->number_of_employee == '21-50' ? 'selected' : ''}}>21-50</option>
                                        <option {{isset($userProfile) && $userProfile && $userProfile->number_of_employee == '51-100' ? 'selected' : ''}}>51-100</option>
                                        <option {{isset($userProfile) && $userProfile && $userProfile->number_of_employee == '101-150' ? 'selected' : ''}}>101-150</option>
                                        <option {{isset($userProfile) && $userProfile && $userProfile->number_of_employee == '151-200' ? 'selected' : ''}}>151-200</option>
                                        <option {{isset($userProfile) && $userProfile && $userProfile->number_of_employee == '201-500' ? 'selected' : ''}}>201-500</option>
                                        <option {{isset($userProfile) && $userProfile && $userProfile->number_of_employee == '501-1000' ? 'selected' : ''}}>501-1000</option>
                                        <option {{isset($userProfile) && $userProfile && $userProfile->number_of_employee == '1000+' ? 'selected' : ''}}>1000+</option>
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
                                                <option value="{{ $value->user_typeID }}" {{ isset($userProfile) && ($userProfile->user_type == $value->user_typeID) ? 'selected' : ''}}>{{ $value->type_name }}</option>
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
                                <div class="form-group col-md-6">
                                    <label for="companyWebsite">Comapny Website </label>
                                    <input type="text"  name="companyWebsite" value="{{ isset($userProfile) ? $userProfile->company_website : old('companyWebsite') }}" class="form-control @error('companyWebsite') is-invalid @enderror">
                                    @error('companyWebsite')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="emailAddress"> Company Email Address <span class="text-danger">*</span> </label>
                                    <input type="emailAddress" name="emailAddress" value="{{ isset($userProfile) ? $userProfile->email : old('emailAddress')}}" required class="form-control @error('emailAddress') is-invalid @enderror">
                                    @error('emailAddress')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="address"> Company Full Address <span class="text-danger">*</span> </label>
                                    <textarea name="address" required class="form-control @error('address') is-invalid @enderror">{{ isset($userProfile) ? $userProfile->address : old('address')}}</textarea>
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="aboutCompnay"> About Company  </label>
                                    <textarea name="aboutCompnay" class="summernoteShort form-control @error('aboutCompnay') is-invalid @enderror">{{ ((isset($userProfile) && $userProfile) ? $userProfile->about_company : old('aboutCompnay')) }}</textarea>
                                    @error('aboutCompnay')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>
                        </div>


                        <div class="user-dashboard-info-box">
                            <div class="section-title-02 mb-3">
                                <h4>Other Information</h4>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="firstName">First Name <span class="text-danger">*</span> </label>
                                    <input type="text"  name="firstName" value="{{ ((isset($userProfile) && $userProfile) ? $userProfile->first_name : old('firstName')) }}" required class="form-control @error('firstName') is-invalid @enderror">
                                    @error('firstName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="lastName"> Last Name <span class="text-danger">*</span> </label>
                                    <input type="text" name="lastName" required value="{{ ((isset($userProfile) && $userProfile) ? $userProfile->last_name : old('lastName')) }}" class="form-control @error('lastName') is-invalid @enderror">
                                    @error('lastName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="user-dashboard-info-box">
                            <div class="section-title-02 mb-3">
                                <h4>Contact Information</h4>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="contactFullName">Full Name <span class="text-danger">*</span> </label>
                                    <input type="text"  name="contactFullName"  value="{{ ((isset($userProfile) && $userProfile) ? $userProfile->contact_name : old('contactFullName')) }}" required class="form-control @error('contactFullName') is-invalid @enderror">
                                    @error('contactFullName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="contactEmail"> Email Address <span class="text-danger">*</span> </label>
                                    <input type="email" name="contactEmail" value="{{ ((isset($userProfile) && $userProfile) ? $userProfile->contact_email : old('contactEmail')) }}" required class="form-control @error('contactEmail') is-invalid @enderror">
                                    @error('contactEmail')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    <div class="form-row mb-4">
                        <div align="right" class="col-md-12">
                            <input type="hidden" name="userProfileId" value="{{ (isset($userProfile) && $userProfile) ? $userProfile->user_profileID : '' }}" required class="form-control @error('contactEmail') is-invalid @enderror">
                            <button type="submit" class="btn btn-primary d-block">
                                SAVE CHANGES
                            </button>
                        </div>
                    </div>


            </form>

        </div>
        </div>
      </div>
    </div>
  </section>


@endif
