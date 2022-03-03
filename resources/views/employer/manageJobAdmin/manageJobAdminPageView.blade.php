@if(isset($showPagePostedJob) && $showPagePostedJob == 1)


<!--=================================
Manage Jobs -->
<section>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="user-dashboard-info-box mb-0">

            <div class="row mb-4">
              <div class="col-md-7 col-sm-5 d-flex align-items-center">
                <div class="section-title-02 mb-0 ">
                  <h4 class="mb-0">Manage Jobs</h4>
                </div>
              </div>
              {{-- <div class="col-md-5 col-sm-7 mt-3 mt-sm-0">
                <div class="search">
                  <i class="fas fa-search"></i>
                  <input type="text" class="form-control" placeholder="Search...">
                </div>
              </div> --}}
            </div>

            <div class="user-dashboard-table table-responsive">
              <table class="table table-bordered">
                <thead class="bg-light">
                  <tr >
                    <th scope="col">Job Title</th>
                    <th scope="col">Applications</th>
                    <th scope="col">Accepted</th>
                    <th scope="col">Rejected</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>

                    @if(isset($getPostedJob) && $getPostedJob)
                        @foreach($getPostedJob as $key => $value)
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="job-list-logo">
                                                <a href="{{ Route::has('viewJobDetails') ? Route('viewJobDetails', ['jid'=>$value->jobID]) : 'javascript:;' }}">
                                                    <img width="80" class="img-fluid" src="{{ ($value->job_cover_img <> null ? (isset($getUserPath) ? $getUserPath . $value->job_cover_img : '') : (isset($userPhoto) ? $userPhoto : ''))}}" alt="">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-10 pt-2">
                                            <div class="job-list-title">
                                                <h5 class="mb-0">
                                                    <a href="{{ Route::has('viewJobDetails') ? Route('viewJobDetails', ['jid'=>$value->jobID]) : 'javascript:;' }}">{{ $value->job_title}}</a>
                                                </h5>
                                                <p class="mb-0"> {{ $value->job_company_name ? $value->job_company_name : $value->company_name }}</p>
                                            </div>
                                            <p class="mb-1 mt-2"><i class="fa fa-calendar pr-1"></i> Posted: {{ date('d-m-Y', strtotime($value->job_post_date)) }} <b>|</b> Expiry: {{ date('d-m-Y', strtotime($value->job_expire_date)) }} </p>
                                            <p class="mb-0"> <i class="fas fa-map-marker-alt pr-1"></i> {{ $value->job_location }}, {{ $value->job_country }}</p>
                                            <p class="mb-1 mt-2"><i class="fas fa-filter pr-1"></i> {{ $value->industry_name }} <b>|</b> <i class="fas fa-suitcase pr-1"></i>  <span  class="{{$value->colour}}"> {{ $value->type_name }}</span> </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center text-info"><i class="fa fa-file"></i> <h3><b> {{ isset($totalApplication) ? $totalApplication[$key] : 0 }} </b></h3> </td>
                                <td class="text-center text-success"><i class="fa fa-users"></i> <h3><b> {{ isset($totalShortlisted) ? $totalShortlisted[$key] : 0 }} </b></h3> </td>
                                <td class="text-center text-danger"><i class="fa fa-users"></i> <h3><b> {{ isset($totalRejected) ? $totalRejected[$key] : 0 }} </b></h3> </td>
                                <td>
                                    <div class="m-1 p-1">
                                        <i class="fa fa-eye"></i> <a href="{{ Route::has('viewJobDetails') ? Route('viewJobDetails', ['jid'=>$value->jobID]) : 'javascript:;' }}" class="text-primary" data-toggle="tooltip" title="view Job">View</a>
                                    </div>
                                    <div class="m-1 p-1">
                                        <i class="fa fa-pencil"></i> <a href="{{ Route::has('editJob') ? Route('editJob', ['jid'=>$value->jobID]) : 'javascrip:;' }}" class="text-info" data-toggle="tooltip" title="Edit Job">Edit</a>
                                    </div>
                                    <div class="m-1 p-1">
                                        <i class="fa fa-trash"></i> <a href="javascrip:;" class="text-danger"  title="Delete Job" data-toggle="modal" data-backdrop="false" data-target="#deletePostedJob{{$key}}">Delete</a>
                                    </div>
                                    <div class="m-1 p-1">
                                        <i class="fa fa-users"></i> <a href="{{ Route::has('manageCandidate') ? Route('manageCandidate', ['jid'=>$value->jobID]) : 'javascript:;' }}" class="text-success"  title="Manage Candidate Application">Manage</a>
                                    </div>
                                </td>
                            </tr>

                            {{-- Delete confirm job  --}}
                            <div style="z-index: 9999" class="modal fade text-left d-print-none" id="deletePostedJob{{$key}}" tabindex="-1" role="dialog" aria-labelledby="deletePostedJobs{{$key}}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                        <h5 class="modal-title text-dark"><i class="fa fa-trash"></i> Confirm</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center text-success">
                                                <h6>{{ $value->job_title}}</h6>
                                            </div>
                                            <div class="text-danger text-center m-2 pt-2 h6"> Are you sure you want to delete this job? </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-success" data-dismiss="modal"> Cancel </button>
                                            <a class="btn btn-outline-danger" href="{{Route::has('deleteJob') ? Route('deleteJob', ['jid'=>$value->jobID]) : 'javascrip:;' }}">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Delete Job --}}


                        @endforeach
                    @endif
                </tbody>
              </table>
              @if(isset($getPostedJob) && $getPostedJob)
                <div align="right" class="col-md-12">
                    Showing {{($getPostedJob->currentpage()-1)*$getPostedJob->perpage()+1}}
                    to {{$getPostedJob->currentpage()*$getPostedJob->perpage()}}
                    of  {{$getPostedJob->total()}} entries
                </div>
              {{-- <div class="d-print-none">{{ $getPostedJob->links() }}</div> --}}
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--=================================
  Manage Jobs -->


@endif
