@if(isset($showPageCandidate) && $showPageCandidate == 1)

<!--=================================
Candidates Dashboard -->
<section>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="row mb-3 mb-lg-5 mt-3 mt-lg-0">
              <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="candidates-feature-info bg-dark">
                  <div class="candidates-info-icon text-white">
                    <i class="fas fa-globe-asia"></i>
                  </div>
                  <div class="candidates-info-content">
                   <h6 class="candidates-info-title text-white">Total Submitted Applications</h6>
                  </div>
                  <div class="candidates-info-count">
                    <h3 class="mb-0 text-white">{{ isset($countSubmittedApplication) ? $countSubmittedApplication : 0}}</h3>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="candidates-feature-info bg-success">
                  <div class="candidates-info-icon text-white">
                    <i class="fas fa-thumbs-up"></i>
                  </div>
                  <div class="candidates-info-content">
                   <h6 class="candidates-info-title text-white">Shortlisted Applications</h6>
                  </div>
                  <div class="candidates-info-count">
                    <h3 class="mb-0 text-white">{{ isset($shortlistedApplication) ? $shortlistedApplication : 0 }}</h3>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="candidates-feature-info bg-danger">
                  <div class="candidates-info-icon text-white">
                    <i class="fas fa-thumbs-down"></i>
                  </div>
                  <div class="candidates-info-content">
                   <h6 class="candidates-info-title text-white">Rejected Applications</h6>
                  </div>
                  <div class="candidates-info-count">
                    <h3 class="mb-0 text-white">{{ isset($rejectedApplication) ? $rejectedApplication : 0 }}</h3>
                  </div>
                </div>
              </div>
            </div>

             <div class="row">
                <div class="col-md-12">
                    <div class="user-dashboard-info-box">
                        <div id="chart"></div>
                      </div>
                </div>
            </div>

          <div class="user-dashboard-info-box mb-0 pb-4">
            <div class="section-title">
              <h4>Recent Applied Jobs</h4>
            </div>

                <div class="row">
                    @if(isset($getAllSubmittedApplication) && $getAllSubmittedApplication)
                        @foreach($getAllSubmittedApplication as $key => $value)
                            <div class="col-12">
                                <div class="job-list ">
                                    <div class="job-list-logo">
                                        <a href="{{ Route::has('searchJobDetails') ? Route('searchJobDetails', ['jid'=>$value->jobID]) : 'javascript:;' }}">
                                            <img class="img-fluid" src="{{ (isset($getJobLogo) ? $getJobLogo[$key] : '') }}" alt=" ">
                                        </a>
                                    </div>
                                    <div class="job-list-details">
                                        <div class="job-list-info">
                                        <div class="job-list-title">
                                            <h5 class="mb-0"><a href="{{ Route::has('searchJobDetails') ? Route('searchJobDetails', ['jid'=>$value->jobID]) : 'javascript:;' }}">{{ $value->job_title }}</a></h5>
                                        </div>
                                        <div class="job-list-option">
                                            <ul class="list-unstyled">
                                            <li> <span>via</span> {{ $value->company_name }} </li>
                                            <li><i class="fas fa-map-marker-alt pr-1"></i>{{ $value->job_location .', '. $value->job_country}}</li>
                                            <li><i class="fas fa-filter pr-1"></i>{{ $value->industry_name }}</li>
                                            <li><a class="{{ $value->colour }}" ><i class="fas fa-suitcase pr-1"></i>{{ $value->type_name }}</a></li>
                                            </ul>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="job-list-favourite-time">
                                        <i class="far fa-calendar"></i>
                                        <span class="job-list-time order-1">
                                            <i class="far fa-clock pr-1"></i>{{ date('jS M, Y', strtotime($value->created_at)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

{{--             <div class="row">
              <div class="col-12 text-center mt-4 mt-md-5">
                <ul class="pagination justify-content-center mb-md-4 mb-0">
                  <li class="page-item disabled"> <span class="page-link b-radius-none">Prev</span> </li>
                  <li class="page-item active" aria-current="page"><span class="page-link">1 </span> <span class="sr-only">(current)</span></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">...</a></li>
                  <li class="page-item"><a class="page-link" href="#">25</a></li>
                  <li class="page-item"> <a class="page-link" href="#">Next</a> </li>
                </ul>
              </div>
            </div> --}}
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--=================================
  Change Password -->



@endif
