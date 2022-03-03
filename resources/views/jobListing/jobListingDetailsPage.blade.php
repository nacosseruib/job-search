@extends('layouts.site')
@section("pageTitle", "Job Details")
@section("manageJobPageActive", "active")
@section('pageContent')

    @includeIf('share.topHeader', ['data' => '' ])

    <section>
        <div class="container">
            <div class="col-lg-12 p-2">
                <h4>Job Details</h4>
                <hr />
            </div>
            <div class="col-lg-12">
                @if(isset($jobDetails) && $jobDetails)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="job-list border">
                                <div class=" job-list-logo">
                                    <img class="img-fluid" src="{{ (isset($jobLogo) ? $jobLogo : '') }}" alt="">
                                </div>
                                <div class="job-list-details">
                                    <div class="job-list-info">
                                    <div class="job-list-title">
                                        <h5 class="mb-0">{{ $jobDetails->job_title}}</h5>
                                    </div>
                                    <div class="job-list-option">
                                        <ul class="list-unstyled">
                                            <li>{{ $jobDetails->job_company_name ? $jobDetails->job_company_name : $jobDetails->company_name }}</li>
                                            <li><i class="fas fa-map-marker-alt pr-1"></i>{{ $jobDetails->job_location }}, {{ $jobDetails->job_country }}</li>
                                            <li><i class="fas fa-phone fa-flip-horizontal fa-fw"></i><span class="pl-2">{{ $jobDetails->job_contact_phone }}</span></li>
                                        </ul>
                                        <span class="job-list-time order-1"><i class="fa fa-calendar pr-1"></i> Posted: {{ date('jS M, Y', strtotime($jobDetails->job_expire_date)) }} | <i class="fa fa-calendar pr-1"></i> Expired: {{ date('jS M, Y', strtotime($jobDetails->job_expire_date)) }}</span>
                                    </div>
                                    </div>
                                </div>
                                <div class="job-list-favourite-time">
                                    @if(Auth::check())
                                        @if($jobDetails->job_expire_date <= date('Y-m-d'))
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-backdrop="false" data-target="#applyForThisJob">
                                                <i class="fa fa-briefcase"></i> Apply
                                            </button>
                                        @else
                                            <button  type="button"  class="btn btn-warning">
                                                <i class="fa fa-briefcase"></i> Job Expired
                                            </button>
                                        @endif
                                    @else
                                        <a class="btn btn-success" href="{{ Route::has('login') ? Route('login') : 'javascript:;'}}">
                                            <i class="fa fa-briefcase"></i> Apply
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border p-4 mt-4 mt-lg-5">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 mb-4">
                                <h5 class="mb-3 mb-md-12">About {{ ucfirst($jobDetails->company_name) }}</h5>
                                <p>
                                    {!! $jobDetails->job_about_company !!}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="border p-4 mt-4 mt-lg-5">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 mb-4">
                        <div class="d-flex">
                            <i class="font-xll text-primary align-self-center flaticon-debit-card"></i>
                            <div class="feature-info-content pl-3">
                            <label class="mb-1">Offered Salary (Per Annual)</label>
                            <span class="mb-0 font-weight-bold d-block text-dark">{{ is_numeric($jobDetails->job_salary) ? number_format(12 * ($jobDetails->job_salary), 2) : (($jobDetails->job_salary) * 12) }} NGN</span>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-4 col-sm-6 mb-md-0 mb-4">
                            <div class="d-flex">
                                <i class="font-xll text-primary align-self-center flaticon-apartment"></i>
                                <div class="feature-info-content pl-3">
                                <label class="mb-1">Sector/Industry</label>
                                <span class="mb-0 font-weight-bold d-block text-dark">{{ $jobDetails->industry_name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 mb-4">
                        <div class="d-flex">
                            <i class="font-xll text-primary align-self-center fa fa-suitcase fa-2x"></i>
                            <div class="feature-info-content pl-3">
                            <label class="mb-1">Job Type</label>
                            <span class="mb-0 font-weight-bold d-block {{ $jobDetails->colour }}">{{ $jobDetails->type_name }}</span>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>

                    <div class="my-4 my-lg-5">
                        <h5 class="mb-3 mb-md-4">Job Description</h5>
                        <p>
                            {!! $jobDetails->job_description !!}
                        </p>
                    </div>
                    <hr>
                    <div class="my-4 my-lg-5">
                        <h5 class="mb-3 mb-md-4">Required Knowledge, Skills, and Abilities</h5>
                        {!! $jobDetails->job_requirement !!}
                    </div>
                    <hr>
                    <div class="mt-4 mt-lg-5">
                    <h5 class="mb-3 mb-md-4">Education + Experience</h5>
                        {!! $jobDetails->job_education_experience !!}
                    </div>
                @endif
            </div>
            <hr />
            <a href="{{ Route::has('searchJob') ? Route('searchJob') : 'javascript:;' }}" class="btn btn-outline-dark" >Back</a>
        </div>
    </section>

    <form method="post" action="{{ (Route::has('postApplyForJob') ? Route('postApplyForJob') : '#') }}" enctype="multipart/form-data">
        @csrf
     <!-- Modal to apply for job -->
     <div style="z-index: 9999" class="modal fade text-left d-print-none" id="applyForThisJob" tabindex="-1" role="dialog" aria-labelledby="applyForThisJob" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h6 class="modal-title text-white"><i class="ti-save"></i> Apply for this job!</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if(isset($jobDetails) && $jobDetails)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="job-list border">
                                <div class=" job-list-logo">
                                    <img class="img-fluid" src="{{ (isset($jobLogo) ? $jobLogo : '') }}" alt="">
                                </div>
                                <div class="job-list-details">
                                    <div class="job-list-info">
                                    <div class="job-list-title">
                                        <h5 class="mb-0">{{ $jobDetails->job_title}}</h5>
                                    </div>
                                    <div class="job-list-option">
                                        <ul class="list-unstyled">
                                            <li>{{ $jobDetails->job_company_name ? $jobDetails->job_company_name : $jobDetails->company_name }}</li>
                                            <li><i class="fas fa-map-marker-alt pr-1"></i>{{ $jobDetails->job_location }}, {{ $jobDetails->job_country }}</li>
                                            <li><i class="fas fa-phone fa-flip-horizontal fa-fw"></i><span class="pl-2">{{ $jobDetails->job_contact_phone }}</span></li>
                                        </ul>
                                        <span class="job-list-time order-1"><i class="fa fa-calendar pr-1"></i> Posted: {{ date('jS M, Y', strtotime($jobDetails->job_expire_date)) }} | Expired: {{ date('jS M, Y', strtotime($jobDetails->job_expire_date)) }}</span>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="text-left"><h5>Review Your Cover Letter</h5></div>
                            <div class="form-group mr-3">
                                <textarea name="coverLetter" required class="form-control text-left summernoteLong @error('coverLetter') is-invalid @enderror" rows="4">{!! (isset($coverLetter) ? $coverLetter : '') !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-left"><h5>Select a CV for this job <span class="text-danger">*</span></h5></div>
                            <div class="position-relative left-icon pr-1">
                                <select name="myCv" class="form-control custom-select-lg p-1" required>
                                    <option value="">Select</option>
                                    @if(isset($allMyCv) && $allMyCv)
                                        @foreach($allMyCv as $key => $value)
                                            <option value="{{ $value->candidate_cvID }}">{{ $value->file_description }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="text-center m-2 p-1"> <h6 class="text-dark">Are you sure you want to apply for this job? </h6></div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="jobName" required value="{{ $jobDetails->jobID }}" />
                    <button type="button" class="btn btn-outline-info" data-dismiss="modal"> Cancel </button>
                    <button type="submit" class="btn btn-success"> Submit CV </button>
                </div>
            </div>
        </div>
    </div>
    <!--end Modal  apply for job -->
</form>

@endsection


{{-- Style --}}
@section('style')
    <link href="{{ asset('assets/summernote/summernote-bs4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Script --}}
@section('script')
      <!--Text Editor-->
    <!-- Summernote js -->
    <script src="{{ asset('assets/summernote/summernote-bs4.min.js') }}"></script>
    <!--tinymce js-->
    <script src="{{ asset('assets/summernote/tinymce.min.js') }}"></script>
    <!-- init js -->
    <script src="{{ asset('assets/summernote/form-editor.init.js') }}"></script>
    <script>
        $(document).ready(function() {
            var getVale;
            $('.summernoteShort').summernote({
                height: 100,
                tabsize: 2,
            });
            $('.summernoteLong').summernote({
                height: 220,
                tabsize: 2,
            });

        });
    </script>
@endsection
