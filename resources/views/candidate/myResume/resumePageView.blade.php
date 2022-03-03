@if(isset($showPageResume) && $showPageResume == 1)


<!--=================================
    My Resume -->
    <section>
        <div class="container">
          <div class="row">
            <div class="col-lg-8">
              <div class="section-title-02">
                <h3>My Resume</h3>
              </div>
            </div>
            <div class="col-lg-4 text-lg-right">
                <a class="btn btn-primary btn-md mb-4 mb-lg-0" href="{{ Route::has('viewMyResume') ? Route('viewMyResume') : 'javascript:;' }}">Preview My Resume</a>
            </div>
            <div class="col-md-12">
                {{-- Cover Letter --}}
                <form method="post" action="{{ (Route::has('postCoverLetter') ? Route('postCoverLetter') : '#') }}" enctype="multipart/form-data">
                @csrf
                    <div class="user-dashboard-info-box">
                        <div class="form-group col-md-12">
                            <label for="coverLetter h5"> Cover Letter <span class="text-danger">*</span> </label>
                            <textarea name="coverLetter" required class="form-control summernoteLong @error('coverLetter') is-invalid @enderror" rows="4">{!! (isset($coverLetter) ? $coverLetter : '') !!}</textarea>
                            @error('coverLetter')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12" align="right">
                            <button type="submit" class="btn btn-md ml-sm-auto btn-primary">Update Cover Letter</button>
                        </div>
                    </div>
                </form>

                {{-- Education --}}
                <div class="user-dashboard-info-box">
                    <div class="dashboard-resume-title d-flex align-items-center">
                        <div class="section-title-02 mb-sm-0">
                            <h4 class="mb-0">Education</h4>
                        </div>
                        <a class="btn btn-md ml-sm-auto btn-secondary" data-toggle="collapse" href="#datepostedEducation" role="button" aria-expanded="false" aria-controls="datepostedEducation">Add Education</a>
                    </div>
                    <form method="post" action="{{ (Route::has('postAddEducation') ? Route('postAddEducation') : '#') }}" enctype="multipart/form-data">
                    @csrf
                        <div class="collapse" id="datepostedEducation"> {{-- show --}}
                            <div class="bg-light p-3 mt-4">
                                @includeif('share.addEducationFields')
                            </div>
                        </div>
                    </form>
                    <div class="jobber-candidate-timeline mt-4">
                        <div class="jobber-timeline-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        @if(isset($getAllEducation) && $getAllEducation)
                            @foreach($getAllEducation as $key => $value)
                                <form method="post" action="{{ (Route::has('postEducationSaveChanges') ? Route('postEducationSaveChanges') : '#') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="educationID" value="{{ $value->educationID }}" />
                                    <div class="jobber-timeline-item">
                                        <div class="jobber-timeline-cricle">
                                            <i class="far fa-circle"></i>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-11 jobber-timeline-info">
                                                <div class="dashboard-timeline-info">
                                                    <div class="dashboard-timeline-edit">
                                                        <ul class="list-unstyled d-flex">
                                                            <li>
                                                                <a class="text-right" data-toggle="collapse" href="#dateposted-{{$key}}" role="button" aria-expanded="false" aria-controls="dateposted">
                                                                    <i class="fas fa-pencil-alt text-info mr-2"></i>
                                                                </a>
                                                            </li>
                                                            <li> &nbsp; &nbsp; &nbsp;</li>
                                                            <li>
                                                                <a href="javascript:;" data-toggle="modal" data-backdrop="false" data-target="#confirmToDelete{{$key}}">
                                                                    <i class="far fa-trash-alt text-danger"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    {{-- Show school details --}}
                                                    <span class="jobber-timeline-time">{{ date('F d, Y', strtotime($value->date_started)) }} - {{ ($value->date_completed < date('Y-m-d')) ? date('F d, Y', strtotime($value->date_completed)) : 'Today' }}</span>
                                                    <h6 class="mb-2">{{ $value->certificate_name}} in {{ $value->course_title}}</h6>
                                                    <span>- {{ $value->institution}}</span>
                                                    <p class="mt-2"> </p>
                                                </div>
                                                {{-- Edit education form --}}
                                                <div class="collapse " id="dateposted-{{$key}}"> {{-- show --}}
                                                    <div class="bg-light p-3">
                                                        <div class="form-row collapse show" id="dateposted-01">
                                                            <div class="col-md-12">
                                                                <form method="post" action="{{ (Route::has('postAddEducation') ? Route('postAddEducation') : '#') }}" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @includeif('share.addEducationFields')
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- Modal to delete -->
                                <div style="z-index: 9999" class="modal fade text-left d-print-none" id="confirmToDelete{{$key}}" tabindex="-1" role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-info">
                                                <h6 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h6>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <div>
                                                    <h6 class="mb-2 text-info">Deleting: {{ $value->certificate_name}} in {{ $value->course_title}}</h6>
                                                </div>
                                                <div class="text-success text-center"> <h6>Are you sure you want to delete this record? </h6></div>
                                                <p class="text-danger">Note, this record will be deleted permanently from our system!</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-info" data-dismiss="modal"> Cancel </button>
                                                <a href="{{ Route::has('deleteEducation') ? Route('deleteEducation', ['eid'=>$value->educationID]) : 'javascript:;' }}" class="btn btn-outline-danger"> Delete now </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end Modal-->
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- Work Experience --}}
                    <div class="user-dashboard-info-box">
                        <div class="dashboard-resume-title d-flex align-items-center">
                            <div class="section-title-02 mb-sm-0">
                                <h4 class="mb-0">Work & Experience</h4>
                            </div>
                            <a class="btn btn-md ml-sm-auto btn-secondary" data-toggle="collapse" href="#datepostedWorkExp" role="button" aria-expanded="false" aria-controls="datepostedWorkExp">Add Experience</a>
                        </div>
                        <form method="post" action="{{ (Route::has('postWorExperience') ? Route('postWorExperience') : '#') }}" enctype="multipart/form-data">
                        @csrf
                            <div class="collapse" id="datepostedWorkExp"> {{-- show --}}
                                <div class="bg-light p-3 mt-4">
                                    @includeif('share.addWorkExperienceFields')
                                </div>
                            </div>
                        </form>
                        <div class="jobber-candidate-timeline mt-4">
                            <div class="jobber-timeline-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            @if(isset($getAllworkExperience) && $getAllworkExperience)
                                @foreach($getAllworkExperience as $keyWordExp => $valueWork)
                                    <form method="post" action="{{ (Route::has('postWorkExperienceSaveChanges') ? Route('postWorkExperienceSaveChanges') : '#') }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="workExperienceID" value="{{ $valueWork->work_experienceID }}" />
                                        <div class="jobber-timeline-item">
                                            <div class="jobber-timeline-cricle">
                                                <i class="far fa-circle"></i>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-11 jobber-timeline-info">
                                                    <div class="dashboard-timeline-info">
                                                        <div class="dashboard-timeline-edit">
                                                            <ul class="list-unstyled d-flex">
                                                                <li>
                                                                    <a class="text-right" data-toggle="collapse" href="#datepostedWorkExp-{{$keyWordExp}}" role="button" aria-expanded="false" aria-controls="dateposted">
                                                                        <i class="fas fa-pencil-alt text-info mr-2"></i>
                                                                    </a>
                                                                </li>
                                                                <li> &nbsp; &nbsp; &nbsp;</li>
                                                                <li>
                                                                    <a href="javascript:;" data-toggle="modal" data-backdrop="false" data-target="#confirmToDeleteWorkExp{{$keyWordExp}}">
                                                                        <i class="far fa-trash-alt text-danger"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        {{-- Show school details --}}
                                                        <span class="jobber-timeline-time">{{ date('F d, Y', strtotime($valueWork->date_started)) }} - {{ ($valueWork->date_stop < date('Y-m-d')) ? date('F d, Y', strtotime($valueWork->date_stop)) : 'Today' }}</span>
                                                        <h6 class="mb-2">{{ $valueWork->job_title}} at {{ $valueWork->company_name}}</h6>
                                                        <span>- {{ $valueWork->job_description}}</span>
                                                        <p class="mt-2"> </p>
                                                    </div>
                                                    {{-- Edit education form --}}
                                                    <div class="collapse " id="datepostedWorkExp-{{$keyWordExp}}"> {{-- show --}}
                                                        <div class="bg-light p-3">
                                                            <div class="form-row collapse show" id="datepostedWorkExp-01">
                                                                <div class="col-md-12">
                                                                    <form method="post" action="{{ (Route::has('postWorkExperienceSaveChanges') ? Route('postWorkExperienceSaveChanges') : '#') }}" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @includeif('share.addWorkExperienceFields')
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <!-- Modal to delete -->
                                    <div style="z-index: 9999" class="modal fade text-left d-print-none" id="confirmToDeleteWorkExp{{$keyWordExp}}" tabindex="-1" role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-info">
                                                    <h6 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h6>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <div>
                                                        <h6 class="mb-2 text-info">Deleting: {{ $valueWork->job_title}} at {{ $valueWork->company_name}}</h6>
                                                    </div>
                                                    <div class="text-success text-center"> <h6>Are you sure you want to delete this record? </h6></div>
                                                    <p class="text-danger">Note, this record will be deleted permanently from our system!</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-info" data-dismiss="modal"> Cancel </button>
                                                    <a href="{{ Route::has('deleteWorkExperience') ? Route('deleteWorkExperience', ['weid'=>$valueWork->work_experienceID]) : 'javascript:;' }}" class="btn btn-outline-danger"> Delete now </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end Modal-->

                                @endforeach
                            @endif
                        </div>
                    </div>



                     {{-- Professional Skill --}}
                    <div class="user-dashboard-info-box">
                        <div class="dashboard-resume-title d-flex align-items-center">
                            <div class="section-title-02 mb-sm-0">
                                <h4 class="mb-0">Professional Skill</h4>
                            </div>
                            <a class="btn btn-md ml-sm-auto btn-secondary" data-toggle="collapse" href="#datepostedSkill" role="button" aria-expanded="false" aria-controls="datepostedSkill">Add Skill</a>
                        </div>
                        <form method="post" action="{{ (Route::has('postSkill') ? Route('postSkill') : '#') }}" enctype="multipart/form-data">
                        @csrf
                            <div class="collapse" id="datepostedSkill"> {{-- show --}}
                                <div class="bg-light p-3 mt-4">
                                    @includeif('share.addProfessionalSkillFields')
                                </div>
                            </div>
                        </form>
                        <div class="jobber-candidate-timeline mt-4">
                            <div class="jobber-timeline-icon">
                                <i class="fas fa-brain"></i>
                            </div>
                            @if(isset($getAllProfessionalSkill) && $getAllProfessionalSkill)
                                @foreach($getAllProfessionalSkill as $keySkill => $valueSkill)
                                    <form method="post" action="{{ (Route::has('postSkillSaveChanges') ? Route('postSkillSaveChanges') : '#') }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="skillID" value="{{ $valueSkill->skillID }}" />
                                        <div class="jobber-timeline-item">
                                            <div class="jobber-timeline-cricle">
                                                <i class="far fa-circle"></i>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-11 jobber-timeline-info">
                                                    <div class="dashboard-timeline-info">
                                                        <div class="dashboard-timeline-edit">
                                                            <ul class="list-unstyled d-flex">
                                                                <li>
                                                                    <a class="text-right" data-toggle="collapse" href="#datepostedSkill-{{$keySkill}}" role="button" aria-expanded="false" aria-controls="dateposted">
                                                                        <i class="fas fa-pencil-alt text-info mr-2"></i>
                                                                    </a>
                                                                </li>
                                                                <li> &nbsp; &nbsp; &nbsp;</li>
                                                                <li>
                                                                    <a href="javascript:;" data-toggle="modal" data-backdrop="false" data-target="#confirmToDeleteSkill{{$keySkill}}">
                                                                        <i class="far fa-trash-alt text-danger"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        {{-- Show school details --}}
                                                        <span class="jobber-timeline-time">{{ $valueSkill->year_of_experience }} year(s) experience in - {{ $valueSkill->skill_title }}</span>
                                                        <h6 class="mb-2"> - I am {{ $valueSkill->efficiency}}% good at this skill </h6>
                                                        <p class="mt-2"> </p>
                                                    </div>
                                                    {{-- Edit education form --}}
                                                    <div class="collapse " id="datepostedSkill-{{$keySkill}}"> {{-- show --}}
                                                        <div class="bg-light p-3">
                                                            <div class="form-row collapse show" id="datepostedSkill-01">
                                                                <div class="col-md-12">
                                                                    <form method="post" action="{{ (Route::has('postWorkExperienceSaveChanges') ? Route('postWorkExperienceSaveChanges') : '#') }}" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @includeif('share.addProfessionalSkillFields')
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <!-- Modal to delete -->
                                    <div style="z-index: 9999" class="modal fade text-left d-print-none" id="confirmToDeleteSkill{{$keySkill}}" tabindex="-1" role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-info">
                                                    <h6 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h6>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <div>
                                                        <h6 class="mb-2 text-info">Deleting: {{ $valueSkill->skill_title}} </h6>
                                                    </div>
                                                    <div class="text-success text-center"> <h6>Are you sure you want to delete this record? </h6></div>
                                                    <p class="text-danger">Note, this record will be deleted permanently from our system!</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-info" data-dismiss="modal"> Cancel </button>
                                                    <a href="{{ Route::has('deleteSkill') ? Route('deleteSkill', ['psid'=>$valueSkill->skillID]) : 'javascript:;' }}" class="btn btn-outline-danger"> Delete now </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end Modal-->

                                @endforeach
                            @endif
                            </div>
                        </div>


                        {{-- Upload CV --}}
                        <div class="user-dashboard-info-box">
                        <div class="dashboard-resume-title d-flex align-items-center">
                            <div class="section-title-02 mb-sm-0">
                                <h4 class="mb-0">Upload CV</h4>
                            </div>
                            <a class="btn btn-md ml-sm-auto btn-secondary" data-toggle="collapse" href="#datepostedCvFile" role="button" aria-expanded="false" aria-controls="datepostedCvFile">Add CV</a>
                        </div>
                        <form method="post" action="{{ (Route::has('postUploadCv') ? Route('postUploadCv') : '#') }}" enctype="multipart/form-data">
                        @csrf
                            <div class="collapse" id="datepostedCvFile"> {{-- show --}}
                                <div class="bg-light p-3 mt-4">
                                    @includeif('share.uploadCVFields')
                                </div>
                            </div>
                        </form>
                        <div class="jobber-candidate-timeline mt-4">
                            <div class="jobber-timeline-icon">
                                <i class="fas fa-file"></i>
                            </div>
                            @if(isset($getAllCv) && $getAllCv)
                                @foreach($getAllCv as $keyCv => $valueCv)
                                        <div class="jobber-timeline-item">
                                            <div class="jobber-timeline-cricle">
                                                <i class="far fa-circle"></i>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-11 jobber-timeline-info">
                                                    <div class="dashboard-timeline-info">
                                                        <div class="dashboard-timeline-edit">
                                                            <ul class="list-unstyled d-flex">
                                                                <li> &nbsp; &nbsp; &nbsp;</li>
                                                                <li>
                                                                    <a href="javascript:;" data-toggle="modal" data-backdrop="false" data-target="#confirmToDeleteCv{{$keyCv}}">
                                                                        <i class="far fa-trash-alt text-danger"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        {{-- Show  details --}}
                                                        <span class="jobber-timeline-time">
                                                            <i class="fas fa-file"></i> {{ $valueCv->file_description }} &nbsp; | &nbsp;
                                                            <a href="javascript:;" data-toggle="modal" data-backdrop="false" data-target="#viewCvDetails{{$keyCv}}">
                                                                <i class="far fa-file"></i> View File
                                                            </a>
                                                        </span>
                                                        <p class="mt-2"> </p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal to delete -->
                                        <div style="z-index: 9999" class="modal fade text-left d-print-none" id="viewCvDetails{{$keyCv}}" tabindex="-1" role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info">
                                                        <h6 class="modal-title text-white"><i class="ti-save"></i>{{ $valueCv->file_description }} </h6>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <object
                                                                data="{{ isset($getPath) ? $getPath . $valueCv->file_name : ''}}#page=2"
                                                                type="application/pdf"
                                                                width="100%"
                                                                height="600px">
                                                                <iframe
                                                                    src="{{ isset($getPath) ? $getPath . $valueCv->file_name : ''}}#page=2"
                                                                    width="100%"
                                                                    height="600px"
                                                                    style="border: none;">
                                                                    <p>Your browser does not support Docs/PDFs.
                                                                    <a href="{{ isset($getPath) ? $getPath . $valueCv->file_name : ''}}">Download the PDF</a>.</p>
                                                                </iframe>
                                                            </object>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-info" data-dismiss="modal"> Close </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end Modal-->


                                    <!-- Modal to delete -->
                                    <div style="z-index: 9999" class="modal fade text-left d-print-none" id="confirmToDeleteCv{{$keyCv}}" tabindex="-1" role="dialog" aria-labelledby="confirmToSubmit" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-info">
                                                    <h6 class="modal-title text-white"><i class="ti-save"></i> Confirm!</h6>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <div>
                                                        <h6 class="mb-2 text-info">Deleting: <i class="fas fa-file"></i> {{ $valueCv->file_description }} </h6>
                                                    </div>
                                                    <div class="text-success text-center"> <h6>Are you sure you want to delete this record? </h6></div>
                                                    <p class="text-danger">Note, this record will be deleted permanently from our system!</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-info" data-dismiss="modal"> Cancel </button>
                                                    <a href="{{ Route::has('deleteCv') ? Route('deleteCv', ['cvid'=>$valueCv->candidate_cvID ]) : 'javascript:;' }}" class="btn btn-outline-danger"> Delete now </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end Modal-->
                                @endforeach
                            @endif
                            </div>
                        </div>


                </div>
              </div>
          </div>
        </div>
    </section>



@endif
