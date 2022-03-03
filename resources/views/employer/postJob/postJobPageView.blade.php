@if(isset($showPagePostJob) && $showPagePostJob == 1)

<section>
    <form method="post" action="{{ (Route::has('saveNewJob') ? Route('saveNewJob') : '#') }}" enctype="multipart/form-data">
        @csrf

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                <div class="user-dashboard-info-box">
                    <div class="section-title-02 mb-2">
                        <h4>Post A New Job</h4>
                        <div align="right">All fields with <span class="text-danger">*</span> are important</div>
                        <hr />
                    </div>
                    <fieldset>
                        <legend class="px-2"></legend>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                        <label for="jobTitle">Job Title <span class="text-danger">*</span> </label>
                                    <input type="text" value="{{ (isset($jobDetails) && $jobDetails) ? $jobDetails->job_title : old('jobTitle') }}" name="jobTitle" required class="form-control @error('jobTitle') is-invalid @enderror">
                                    @error('jobTitle')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="category"> Job Sector/Category <span class="text-danger">*</span> </label>
                                    <select name="category" required class="form-control basic-select @error('category') is-invalid @enderror">
                                        <option value="" selected="selected">Select</option>
                                        @if(isset($allCategories) && $allCategories)
                                            @foreach($allCategories as $value)
                                                <option value="{{$value->industryID}}" {{ isset($jobDetails) && ($jobDetails->job_category == $value->industryID) ? 'selected' : '' }}>{{$value->industry_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="jobType"> Job Type <span class="text-danger">*</span> </label>
                                    <select name="jobType" required class="form-control basic-select @error('jobType') is-invalid @enderror">
                                        <option value="" selected="selected">Select</option>
                                        @if(isset($allJobType) && $allJobType)
                                            @foreach($allJobType as $value)
                                                <option value="{{$value->job_typeID}}" {{ isset($jobDetails) && ($jobDetails->job_type == $value->job_typeID) ? 'selected' : '' }}>{{$value->type_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('jobType')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-2"> {{-- max="{{date('Y-m-' . (date('d') + 3))}}"  --}}
                                    <label for="datePosted"> Date Posted <span class="text-danger">*</span> </label>
                                    <input type="date" value="{{ (isset($jobDetails) && $jobDetails) ? $jobDetails->job_post_date : old('datePosted') }}" name="datePosted" required class="form-control @error('datePosted') is-invalid @enderror">
                                    @error('datePosted')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="expireDate"> Expire Date <span class="text-danger">*</span> </label>
                                    <input type="date" value="{{ (isset($jobDetails) && $jobDetails) ? $jobDetails->job_expire_date : old('expireDate') }}" name="expireDate" required class="form-control @error('expireDate') is-invalid @enderror">
                                    @error('expireDate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="location"> Job Location/City  </label>
                                    <input type="text"  name="location" value="{{ ((isset($jobDetails) && $jobDetails) ? $jobDetails->job_location :  old('location')) }}" class="form-control @error('location') is-invalid @enderror">
                                    @error('location')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="country"> Job Country <span class="text-danger">*</span> </label>
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
                                    <label for="jobEmail"> Email To Apply Job Through <span class="text-danger">*</span> </label>
                                    <input type="email" name="jobEmail" value="{{ ((isset($jobDetails) && $jobDetails) ? $jobDetails->job_apply_email : old('jobEmail')) }}" class="form-control @error('jobEmail') is-invalid @enderror">
                                    @error('jobEmail')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="jobStatus"> Job Status <span class="text-danger">*</span> </label>
                                    <select name="jobStatus" required class="form-control basic-select @error('jobStatus') is-invalid @enderror">
                                        <option value="">Select</option>
                                        <option value="0" {{ isset($jobDetails) && ($jobDetails->job_status == 0) ? 'selected' : (old('jobStatus') == 0 ? 'selected' : '') }}>Post to Offline</option>
                                        <option value="1" {{ isset($jobDetails) && ($jobDetails->job_status == 1) ? 'selected' : (old('jobStatus') == 1 ? 'selected' : '') }}>Post to Online</option>
                                    </select>
                                    @error('jobStatus')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="jobSalary"> Job Salary (Monthly) <span class="text-danger">*</span> </label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                          <div class="input-group-text">&#8358;</div>
                                        </div>
                                        <input type="text" id="formatAmountOnKeyPress" name="jobSalary" required value="{{ ((isset($jobDetails) && $jobDetails) ? $jobDetails->job_salary : old('jobSalary')) }}" class="form-control  @error('jobSalary') is-invalid @enderror" placeholder="Salary">
                                    </div>
                                    @error('jobSalary')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="jobDescription"> Job Description <span class="text-danger">*</span> </label>
                                    <textarea name="jobDescription" required class="summernoteShort form-control @error('jobDescription') is-invalid @enderror">{{ ((isset($jobDetails) && $jobDetails) ? $jobDetails->job_description : old('jobDescription')) }}</textarea>
                                    @error('jobDescription')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="jobRequirement"> Job Requirement  </label>
                                    <textarea name="jobRequirement" class="summernoteShort form-control @error('jobRequirement') is-invalid @enderror">{{ ((isset($jobDetails) && $jobDetails) ? $jobDetails->job_requirement : old('jobRequirement')) }}</textarea>
                                    @error('jobRequirement')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="jobEducationExperience"> Job Education & Experience  </label>
                                    <textarea name="jobEducationExperience" class="summernoteShort form-control @error('jobEducationExperience') is-invalid @enderror">{{ ((isset($jobDetails) && $jobDetails) ? $jobDetails->job_education_experience : old('jobEducationExperience')) }}</textarea>
                                    @error('jobEducationExperience')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="aboutCompnay"> About Company <span class="text-danger">*</span> </label>
                                    <textarea name="aboutCompnay" required class="summernoteShort form-control @error('aboutCompnay') is-invalid @enderror">{{ ((isset($jobDetails) && $jobDetails) ? $jobDetails->job_about_company : (isset($getCompanyDetails) ? $getCompanyDetails : old('aboutCompnay')) )}}</textarea>
                                    @error('aboutCompnay')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>




                <div class="user-dashboard-info-box">
                    <div class="section-title-02 mb-3">
                        <h4>Other Details (Optional)</h4>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="contactName"> Job Contact Person's Name </label>
                            <input type="text"  name="contactName" value="{{ ((isset($jobDetails) && $jobDetails) ? $jobDetails->job_contact_name : old('contactName')) }}" class="form-control @error('contactName') is-invalid @enderror">
                            @error('contactName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="contactPhoneNo"> Contact Person Phone Number </label>
                            <input type="text"  name="contactPhoneNo" value="{{ ((isset($jobDetails) && $jobDetails) ? $jobDetails->job_contact_phone : old('contactPhoneNo')) }}" class="form-control @error('contactPhoneNo') is-invalid @enderror">
                            @error('contactPhoneNo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="jobCoverImage"> Use another Logo (PNG, JPG, JPEG, GIF)</label>
                            <input type="file"  name="jobCoverImage" class="form-control @error('jobCoverImage') is-invalid @enderror">
                            @error('jobCoverImage')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="jobCompanyName"> Use another Company Name</label>
                            <input type="text"  name="jobCompanyName" value="{{ ((isset($jobDetails) && $jobDetails) ? $jobDetails->job_company_name : old('jobCompanyName')) }}" class="form-control @error('jobCompanyName') is-invalid @enderror">
                            @error('jobCompanyName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                @if(isset($jobDetails) && $jobDetails->jobID)
                    <input type="hidden" value="{{ (isset($jobDetails) && $jobDetails) ? $jobDetails->jobID : '' }}" name="jobID" required>
                    <div align="center" class="row">
                        <div class="col-md-6" align="right">
                            <a href="{{Route::has('cancelEditing') ? Route('cancelEditing') : 'javascript:;' }}" class="btn btn-md btn-info btn-outline">Cancel Editing</a>
                        </div>
                        <div class="col-md-6" align="left">
                            <button type="submit" class="btn btn-md btn-primary btn-outline">Update Job</button>
                        </div>
                    </div>
                @else
                   <input type="hidden" value="" name="jobID">
                    <div align="center" class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-backdrop="false" data-target="#confirmToPostJob">Post Job</button>
                        </div>
                    </div>
                @endif
        </div>
        </div>
      </div>
    </div>

    {{-- confirm post new job  --}}
    <div style="z-index: 99999" class="modal fade text-left d-print-none" id="confirmToPostJob" tabindex="-1" role="dialog" aria-labelledby="confirmToPostJob" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                <h5 class="modal-title text-dark"><i class="fa fa-save"></i> Post New/Update Job!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">

                    <div class="text-success text-center m-2 pt-2 h6"> Are you sure you want to continue with this operation? </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-success" data-dismiss="modal"> Cancel </button>
                   <button type="submit" class="btn btn-outline-primary">Post Job</button>
                </div>
            </div>
        </div>
    </div>
    {{-- post new Job --}}


    </form>
  </section>


@endif
