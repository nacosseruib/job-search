@if(isset($showPageIndex) && $showPageIndex == 1)

<!--=================================
Browse listing space-ptb -->
<section class="bg-light pt-3">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="section-title center">
            <h2 class="title"> Jobs Listing</h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 order-lg-2 mb-3 mb-lg-0">

            <div class="browse-job d-flex border-0 bg-white p-3">
                <div class="style-01">
                    <ul class="nav nav-tabs justify-content-center d-flex mt-0" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link  active" id="profile-tab" data-toggle="tab" href="javascript:;" role="tab" aria-controls="profile" aria-selected="false">Find your dream Job Vacancies </a>
                        </li>
                    </ul>
                </div>
                <div class="job-found ml-auto">
                    <span class="badge badge-lg badge-primary">{{ isset($getPostedJob) ? count($getPostedJob) .'+ Job Found' : '' }}</span>
                </div>
           </div>

          <div class="tab-content">
            <div class="tab-pane fade active show" id="contact" role="tabpanel" aria-labelledby="contact-tab">
              <div class="row mt-4">

                @if(isset($getPostedJob) && $getPostedJob)
                    @foreach($getPostedJob as $key => $value)
                    @if($key <= 27)
                        <div class="col-lg-4 col-sm-4">
                            <div class="job-list job-grid">
                            <div class="job-list-logo">
                                @if($value->profile_picture == null)
                                    <div align="center" class=""><i class="fa fa-briefcase fa-4x"></i></div>
                                @else
                                    <a href="{{ Route::has('searchJobDetails') ? Route('searchJobDetails', ['jid'=>$value->jobID]) : 'javascript:;' }}">
                                        <img class="img-fluid img-responsive" src="{{ isset($getJobLogo) ? $getJobLogo[$key] : '' }}" alt=" {{ $value->job_company_name }} ">
                                    </a>
                                @endif
                            </div>
                            <div class="job-list-details">
                                <div class="job-list-info">
                                <div class="job-list-title">
                                    <h6><a href="{{ Route::has('searchJobDetails') ? Route('searchJobDetails', ['jid'=>$value->jobID]) : 'javascript:;' }}"> {{ $value->job_title}}</a></h6>
                                </div>
                                <div class="job-list-option">
                                    <ul class="list-unstyled">
                                    <li>
                                        <span>via</span>
                                        {{ $value->job_company_name }}
                                    </li>
                                    <li><i class="fas fa-map-marker-alt pr-1"></i>{{ $value->job_location .', '. $value->job_country }}</li>
                                    <li><i class="fas fa-filter pr-1"></i>{{ $value->company_name }}</li>
                                    <li><a class="{{ $value->colour}}" href="#"><i class="fas fa-suitcase pr-1"></i>{{ $value->type_name}}</a></li>
                                    </ul>
                                </div>
                                </div>
                            </div>
                            <div class="job-list-favourite-time">
                                <a class="job-list-favourite order-2"  title="Apply for this job"><i class="fa fa-briefcase"></i></a>
                                <span class="job-list-time order-1"><i class="far fa-clock pr-1"></i> <small>Posted: {{ date('jS M, Y', strtotime($value->job_post_date)) }}  {{ ($value->job_expire_date ? '| Expires: ' . date('jS M, Y', strtotime($value->job_expire_date)) : '') }} </small></span>
                            </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                @endif

              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
  <!--=================================
  Browse listing -->

  <!--=================================
  Category-style space-ptb-->
  <section class="mt-4 p-2">
    <div class="container">
      <div class="section-title center">
        <h2 class="title">Choose Your Sector</h2>
      </div>
      <div class="row">
        <div class="col-lg-12">

          <div class="category-style text-center">
              @if(isset($allCategory) && $allCategory)
                @foreach($allCategory as $key => $value)
                    @if($key <= 11)
                    <a href="{{ Route::has('searchJob') ? Route('searchJob', ['cid'=>$value->industryID]) : 'javascript:;' }}" class="category-item">
                        <div class="category-icon mb-4">
                            <i class="fa fa-briefcase fa-3x"></i>
                        </div>
                        <h6>{{ $value->industry_name }}</h6>
                    </a>
                    @endif
                @endforeach
              @endif
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--=================================
  Category-style -->


  <!--=================================
  Top Companies -->
  <section class="space-ptb">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 text-center">
          <div class="section-title center">
            <h2 class="title">Top Companies</h2>
          </div>
          <div class="owl-carousel owl-nav-bottom-center" data-nav-arrow="false" data-nav-dots="true" data-items="4" data-md-items="3" data-sm-items="2" data-xs-items="1" data-xx-items="1" data-space="15" data-autoheight="true">

            @if(isset($getAllCompany) && $getAllCompany)
                @foreach($getAllCompany as $keyCompany => $value)
                    <div class="item">
                        <div class="employers-grid mb-4 mb-lg-0" style="height: 220px;">
                        <div class="employers-list-logo">
                            <img class="img-fluid" src="{{ isset($getCompanyLogo) ? $getCompanyLogo[$keyCompany] : '' }}" alt="">
                        </div>
                        <div class="employers-list-details">
                            <div class="employers-list-info">
                            <div class="employers-list-title">
                                <h5 class="mb-0">
                                    {{ $value->company_name}}
                                </h5>
                            </div>
                            <div class="employers-list-option">
                                <ul class="list-unstyled">
                                <li><i class="fas fa-map-marker-alt pr-1"></i>{{ $value->location_city .', '. $value->country }}</li>
                                </ul>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                @endforeach
            @endif

          </div>
        </div>
      </div>
    </div>
  </section>
  <!--=================================
  Top Companies -->

  <!--=================================
  Easiest Way to Use -->
  <section class="space-ptb bg-primary">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
          <div class="section-title-02 text-center text-white">
            <h2 class="text-white">Easiest Way to Use</h2>
            <p>Positive pleasure-oriented goals are much more powerful motivators than negative fear-based ones.</p>
          </div>
        </div>
      </div>
      <div class="row bg-holder-pattern mr-md-0 ml-md-0" style="background-image: url({{ asset('assets/images/step/pattern-01.png')}});">
        <div class="col-md-4 mb-4 mb-md-0">
          <div class="feature-step text-center">
            <div class="feature-info-icon">
              <i class="flaticon-resume"></i>
            </div>
            <div class=" text-white">
              <h5>Create Account</h5>
              <p class="mb-0">Create an account and access your profile.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4 mb-md-0">
          <div class="feature-step text-center">
            <div class="feature-info-icon">
              <i class="flaticon-recruitment"></i>
            </div>
            <div class=" text-white">
              <h5>Find your Vacancy</h5>
              <p class="mb-0">Don't just find. Be found. Put your CV in front of great employers.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-0">
          <div class="feature-step text-center">
            <div class="feature-info-icon">
              <i class="flaticon-position"></i>
            </div>
            <div class=" text-white">
              <h5>Get a Job</h5>
              <p class="mb-0">Your next career move starts here. Choose Job from thousands of companies</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--=================================
  Easiest Way to Use -->


  <!--=================================
  Plans&and Packages -->
  {{-- <section class="space-ptb">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
          <div class="section-title center">
            <h2 class="title">Buy Our Plans and Packages</h2>
            <p>We've got monthly and daily plans that fit your needs. You can always exchange out jobs, upgrade or scale down when you need to.</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 text-center">
          <div class="pricing-plan pricing-plan-02 mt-md-3 mt-0 free">
            <div class="pricing-price">
              <span>$00</span>
              <h5 class="pricing-title">Free Forever</h5>
            </div>
            <ul class="list-unstyled pricing-list">
              <li>Appear in general results</li>
              <li>Accept mobile app </li>
            </ul>
            <a class="btn btn-outline" href="#">Post a Job</a>
          </div>
        </div>
        <div class="col-md-4 text-center">
          <div class="pricing-plan pricing-plan-02 sponsor active">
            <div class="pricing-price">
              <span>$10</span>
              <h5 class="pricing-title">Sponsor Jobs</h5>
            </div>
            <ul class="list-unstyled pricing-list">
              <li>Premium placement</li>
              <li>PPC on your Job</li>
              <li>Reach more candidates</li>
            </ul>
            <a class="btn btn-outline" href="#">Get Started</a>
          </div>
        </div>
        <div class="col-md-4 text-center">
          <div class="pricing-plan pricing-plan-02 premium mt-md-3 mb-0">
            <div class="pricing-price">
              <span>$299</span>
              <h5 class="pricing-title">Premium Plan</h5>
            </div>
            <ul class="list-unstyled pricing-list">
              <li>Job ad live for six-weeks</li>
              <li>50 Feature Jobs </li>
              <li>Premium placement </li>
              <li>Desktop, mobile and Job Alerts</li>
            </ul>
            <a class="btn btn-outline" href="#">Select Plan</a>
          </div>
        </div>
      </div>
    </div>
  </section> --}}
  <!--=================================
  Plans&and Packages -->

 @if(!Auth::check())
  <section class="feature-info-section mt-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 mb-lg-0">
          <div class="feature-info feature-info-02 p-4 p-lg-5 bg-primary">
            <div class="feature-info-icon mb-3 mb-sm-0 text-dark">
              <i class="flaticon-team"></i>
            </div>
            <div class="feature-info-content text-white pl-sm-4 pl-0">
              <p>Jobseeker</p>
              <h5 class="text-white">Looking For Job?</h5>
            </div>
            <a class="ml-auto align-self-center" href="{{ Route::has('registerCandidate') ? Route('registerCandidate') : 'javascript:;' }}">Apply now<i class="fas fa-long-arrow-alt-right"></i> </a>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="feature-info feature-info-02 p-4 p-lg-5 bg-dark">
            <div class="feature-info-icon mb-3 mb-sm-0 text-primary">
              <i class="flaticon-job-3"></i>
            </div>
            <div class="feature-info-content text-white pl-sm-4 pl-0">
              <p>Employer/Recruiter</p>
              <h5 class="text-white">Are You Recruiting?</h5>
            </div>
            <a class="ml-auto align-self-center" href="{{ Route::has('registerEmployer') ? Route('registerEmployer') : 'javascript:;' }}">Post a job<i class="fas fa-long-arrow-alt-right"></i> </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endif

@else


@endif
