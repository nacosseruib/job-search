@extends('layouts.site')
@section("pageTitle", "Job Details")
@section("manageJobPageActive", "active")
@section('pageContent')

    @includeIf('share.homeTopMenu', ['data' => '' ])


    <section>
        <div class="container">
            <div class="col-lg-12">
                <h4>Job Details</h4>
                <hr />
            </div>
            <div class="col-lg-12">
                @if(isset($jobDetails) && $jobDetails)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="job-list border">
                                <div class=" job-list-logo">
                                    <img class="img-fluid" src="{{ ($jobDetails->job_cover_img <> null ? (isset($getUserPath) ? $getUserPath . $jobDetails->job_cover_img : '') : (isset($userPhoto) ? $userPhoto : ''))}}" alt="">
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
                                    </div>
                                    </div>
                                </div>
                                <div class="job-list-favourite-time">
                                    <span class="job-list-time order-1"><i class="fa fa-calendar pr-1"></i>{{date('jS M, Y')}}</span>
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
                            <span class="mb-0 font-weight-bold d-block text-dark"> {{ is_numeric($jobDetails->job_salary) ? number_format(12 * ($jobDetails->job_salary), 2) : (($jobDetails->job_salary) * 12) }} NGN</span>
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
            <div align="center">
                <hr />
                <a href="{{ Route::has('createEmployerManageJob') ? Route('createEmployerManageJob') : 'javascript:;' }}" class="btn btn-sm btn-outline-success"> Back to list of jobs </a>
            </div>
        </div>
    </section>

@endsection


{{-- Style --}}
@section('style')

@endsection

{{-- Script --}}
@section('script')
    <script>

    </script>
@endsection
