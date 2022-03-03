@if(isset($showPageManageJob) && $showPageManageJob == 1)


<!--=================================
Manage Jobs -->
<section>
    <div class="container">
        <div class="section-title ml-2">
            <h4>All Applied Jobs</h4>
            <hr />
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
                                @if($value->candidate_status == 1)
                                    <div class="text-white p-2 bg-success">Shortlisted</div>
                                @elseif($value->candidate_status == 2)
                                    <div class="text-white p-2 bg-danger">Rejected</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
  </section>
  <!--=================================
  Manage Jobs -->


@endif
