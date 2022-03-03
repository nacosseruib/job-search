@extends('layouts.site')
@section("pageTitle", "My Resume")
@section("resumeDetailsPageActive", "active")
@section('pageContent')

   {{--  @includeIf('share.homeTopMenu', ['data' => '' ]) --}}

    {{-- start content --}}
        <!--=================================
    My Resume -->
    <section>
        <div class="container">
          <div class="row">
            <div class="col-md-12">

                {{-- USER FULL NAME --}}
                <div class="mt-4 user-dashboard-info-box bg-light">
                    <div class="row">
                        <div class="form-group col-sm-2">
                            <div align="center">
                                <img src="{{ isset($userPhoto) ? $userPhoto : '' }}" alt=" " width="110" height="100" class="rounded-circle img-reponsive" />
                            </div>
                        </div>
                        <div class="form-group col-sm-10">
                            <div class="text-left text-uppercase">
                                <h3><b>{{ isset($userFullName) ? $userFullName : '' }}</b></h3>
                                <h5 class="text-lowercase"><b>{{ Auth::check() ? Auth::user()->email : '' }}</b></h5>
                                <h5><b>{{ isset($userProfile) && $userProfile ? $userProfile->gender : '' }}</b></h5>
                            </div>
                            <hr />
                            <div class="text-left text-info">  <h4>MY RESUME</h4> </div>
                        </div>
                    </div>
                </div>


                {{-- Cover Letter --}}
                <div class="user-dashboard-info-box">
                    <h4>Cover Letter</h4>
                    <div class="form-group col-md-12">
                        <div class="">{!! (isset($coverLetter) ? $coverLetter : '') !!}</div>
                    </div>
                </div>


                {{-- Education --}}
                <div class="user-dashboard-info-box">
                    <div class="dashboard-resume-title d-flex align-items-center">
                        <div class="section-title-02 mb-sm-0">
                            <h4 class="mb-0">Education</h4>
                        </div>
                    </div>
                    <div class="jobber-candidate-timeline mt-4">
                        <div class="jobber-timeline-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        @if(isset($getAllEducation) && $getAllEducation)
                            @foreach($getAllEducation as $key => $value)
                                    <div class="jobber-timeline-item">
                                        <div class="jobber-timeline-cricle">
                                            <i class="far fa-circle"></i>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-11 jobber-timeline-info">
                                                <div class="dashboard-timeline-info">
                                                    {{-- Show details --}}
                                                    <span class="jobber-timeline-time">{{ date('F d, Y', strtotime($value->date_started)) }} - {{ ($value->date_completed < date('Y-m-d')) ? date('F d, Y', strtotime($value->date_completed)) : 'Today' }}</span>
                                                    <h6 class="mb-2">{{ $value->certificate_name}} in {{ $value->course_title}}</h6>
                                                    <span>- {{ $value->institution}}</span>
                                                    <p class="mt-2"> </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                        </div>
                        <div class="jobber-candidate-timeline mt-4">
                            <div class="jobber-timeline-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            @if(isset($getAllworkExperience) && $getAllworkExperience)
                                @foreach($getAllworkExperience as $keyWordExp => $valueWork)
                                        <div class="jobber-timeline-item">
                                            <div class="jobber-timeline-cricle">
                                                <i class="far fa-circle"></i>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-11 jobber-timeline-info">
                                                    <div class="dashboard-timeline-info">
                                                        {{-- Show  details --}}
                                                        <span class="jobber-timeline-time">{{ date('F d, Y', strtotime($valueWork->date_started)) }} - {{ ($valueWork->date_stop < date('Y-m-d')) ? date('F d, Y', strtotime($valueWork->date_stop)) : 'Today' }}</span>
                                                        <h6 class="mb-2">{{ $valueWork->job_title}} at {{ $valueWork->company_name}}</h6>
                                                        <span>- {{ $valueWork->job_description}}</span>
                                                        <p class="mt-2"> </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                        </div>
                        <div class="jobber-candidate-timeline mt-4">
                            <div class="jobber-timeline-icon">
                                <i class="fas fa-brain"></i>
                            </div>
                            @if(isset($getAllProfessionalSkill) && $getAllProfessionalSkill)
                                @foreach($getAllProfessionalSkill as $keySkill => $valueSkill)
                                        <div class="jobber-timeline-item">
                                            <div class="jobber-timeline-cricle">
                                                <i class="far fa-circle"></i>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-11 jobber-timeline-info">
                                                    <div class="dashboard-timeline-info">
                                                        {{-- Show  details --}}
                                                        <span class="jobber-timeline-time">{{ $valueSkill->year_of_experience }} year(s) experience in - {{ $valueSkill->skill_title }}</span>
                                                        <h6 class="mb-2"> - I am {{ $valueSkill->efficiency}}% good at this skill </h6>
                                                        <p class="mt-2"> </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                        </div>
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
                                                        <span class="jobber-timeline-time"><i class="fas fa-file"></i> {{ $valueCv->file_description }}</span>
                                                        <p class="mt-2"> </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                @endforeach
                            @endif
                            </div>
                        </div>

                        <a href="{{ Route::has('createResume') ? Route('createResume') : 'javascript:;' }}" class="btn btn-primary text-white">Back To Resume</a>
                </div>
              </div>
          </div>
        </div>
    </section>

    {{-- end content --}}

@endsection


{{-- Style --}}
@section('style')

@endsection

{{-- Script --}}
@section('script')
    <script>

    </script>
@endsection
