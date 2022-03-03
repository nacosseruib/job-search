@if(isset($showPageJobListing) && $showPageJobListing == 1)


<section>

    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="job-search-field">
                    <div class="job-search-item">
                        @includeif('share.jobSearcView')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="user-dashboard-info-box mt-4">
            <div class="section-title-02 mb-2">
              <h4>@yield('pageTitle')</h4>
              <hr />
            </div>
            <div class="form-row">
                <div class="form-group col-md-12 text-justify">

                    <div class="row">
                        @if(isset($getPostedJob) && $getPostedJob)
                            @foreach($getPostedJob as $key => $value)
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
                                                <i class="far fa-clock pr-1"></i>{{ date('jS M, Y', strtotime($value->job_expire_date)) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                      </div>
                </div>
            </div>
        </div>
      </div>
  </section>


@endif
