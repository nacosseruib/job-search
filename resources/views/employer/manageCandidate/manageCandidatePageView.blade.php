@if(isset($showPageManageCandidate) && $showPageManageCandidate == 1)

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
                  <h4 class="mb-0">Manage Candidate Applications</h4>
                </div>
              </div>
              <div class="col-md-5 col-sm-7 mt-3 mt-sm-0">
                <div class="search">
                  {{-- <i class="fas fa-search"></i>
                  <input type="text" class="form-control" placeholder="Search..."> --}}

                    <select id="jobTitleChanged" name="jobTitle" required class="form-control basic-select">
                        <option value="" selected="selected">Select Job To Manage</option>
                        <option value="0">Reset</option>
                        @if(isset($allMyJob) && $allMyJob)
                            @foreach($allMyJob as $value)
                                <option value="{{$value->jobID}}" {{  $value->jobID == old('jobTitle') ? 'selected' : '' }}>{{$value->job_title}} - (Posted: {{date('d-m-Y', strtotime($value->job_post_date))}} - Expire: {{ date('d-m-Y', strtotime($value->job_expire_date)) }})</option>
                            @endforeach
                        @endif
                    </select>
                    @error('jobTitle')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
              </div>
            </div><hr />

            <div class="user-dashboard-table table-responsive">
              <table class="table table-bordered">
                <thead class="bg-light">
                    @if(isset($jobDetails) && $jobDetails)
                    <tr class="bg-dark">
                        <th colspan="4" class="text-left text-uppercase">
                            <h5 class="text-white">
                                {{ isset($jobDetails) && $jobDetails ? $jobDetails->job_title : ''}}
                            </h5>
                            <div class="text-white">
                                <i class="fas fa-filter"></i> {{ isset($jobDetails) && $jobDetails ? $jobDetails->industry_name : ''}}
                            </div>
                            <div class="{{ isset($jobDetails) && $jobDetails ? $jobDetails->colour : ''}}">
                                <i class="fa fa-briefcase"></i> {{ isset($jobDetails) && $jobDetails ? $jobDetails->type_name : ''}}
                            </div>
                        </th>
                        <th scope="col" class="text-white">
                            <div><i class="fa fa-calendar"></i> Posted: {{ (isset($jobDetails) && $jobDetails) ? date('jS-M-Y', strtotime($jobDetails->job_post_date )) : '' }}</div>
                            <div><i class="fa fa-calendar"></i> Expired: {{ (isset($jobDetails) && $jobDetails) ? date('jS-M-Y', strtotime($jobDetails->job_expire_date)) : '' }}</div>
                            <div><i class="fa fa-envelope"></i> Apply via email: {{ (isset($jobDetails) && $jobDetails) ? $jobDetails->job_apply_email : '' }}</div>
                             <div><i class="fa fa-map-o"></i> Job Location: {{ (isset($jobDetails) && $jobDetails) ? $jobDetails->location_city .', '. $jobDetails->country : '' }}</div>
                        </th>
                        <th scope="col">
                            <div class="bg-primary m-0 p-1">
                                <a href="{{ Route::has('viewJobDetails') ? Route('viewJobDetails', ['jid'=>(isset($jobDetails) ? $jobDetails->jobID : '')]) : 'javascript:;' }}" class="text-white" title="view Job details">View Job</a>
                            </div>
                            <div class="bg-success m-0 p-1">
                                <a href="{{ Route::has('viewCandidateAppliedForJob') ? Route('viewCandidateAppliedForJob', ['jid'=>(isset($jobDetails) ? $jobDetails->jobID : ''), 's'=>1]) : 'javascript:;' }}" class="text-white" title="View all shorlisted candidates on this job">Shortlisted</a>
                            </div>
                            <div class="bg-warning m-0 p-1">
                                <a href="{{ Route::has('viewCandidateAppliedForJob') ? Route('viewCandidateAppliedForJob', ['jid'=>(isset($jobDetails) ? $jobDetails->jobID : ''), 's'=>2]) : 'javascript:;' }}" class="text-white" title="View all rejected candidates on this job">Rejected</a>
                            </div>
                            <div class="bg-info m-0 p-1">
                                <a href="{{ Route::has('viewCandidateAppliedForJob') ? Route('viewCandidateAppliedForJob', ['jid'=>(isset($jobDetails) ? $jobDetails->jobID : ''), 's'=>null]) : 'javascript:;' }}" class="text-white" title="View all candidates on this job">View All</a>
                            </div>
                        </th>
                    </tr>
                  @endif
                  <tr >
                    <th colspan="6" class="text-center text-primary">LIST OF CANDIDATES THAT APPLIED FOR THIS JOB</th>
                  </tr>
                  <tr >
                    <th scope="col">Photo</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Gender</th>
                    <th scope="col">City/Country</th>
                    <th scope="col">CV</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>

                    @if(isset($candidateDetails) && $candidateDetails)
                        @foreach($candidateDetails as $key => $value)
                            <tr>
                                <td>
                                    <img src="{{ isset($userImages) ? $userImages[$key] : '' }}" alt="" width="100" />
                                </td>
                                <td>
                                    <div><h5>{{ $value->name }} </h5></div>
                                    <div><i class="fa fa-envelope"></i> {{ $value->email }}</div>
                                    <div><i class="fa fa-phone"></i> {{ $value->phone_number }}</div>
                                </td>
                                <td>{{ $value->gender }}</td>
                                <td>{{ $value->location_city .', '. $value->country }}</td>
                                <td class="text-center">
                                    <a href="{{ isset($userPath) ? $userPath[$key] . $value->file_name : '' }}" target="_black">{{ $value->file_description }}</a>
                                    <hr />
                                    <table class="table table-borderless">
                                        <tr align="center">
                                            <td>
                                                <button type="button" class="btn btn-sm {{$value->candidate_status == 1 ? 'btn-success' : 'btn-outline-success' }}" title="Shortlist/Accept this candidate" data-toggle="modal" data-backdrop="false" data-target="#shortlistUser{{$key}}">Shortlist</button>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm {{$value->candidate_status == 2 ? 'btn-warning' : 'btn-outline-warning' }}" title="Reject this candidate" data-toggle="modal" data-backdrop="false" data-target="#rejectUser{{$key}}">Reject</button>
                                            </td>
                                        <tr>
                                        <tr align="center">
                                            <td colspan="2">
                                                @if($value->candidate_status == 2)
                                                   <div class="p-1 text-danger text-uppercase"> <i class="fas fa-thumbs-down"></i> Rejected on: {{ date('d-m-Y h:i:sa', strtotime($value->updated_at)) }}</div>
                                                @elseif($value->candidate_status == 1)
                                                    <div class="p-1 text-success text-uppercase"> <i class="fas fa-thumbs-up"></i> Shortlisted on: {{ date('d-m-Y h:i:sa', strtotime($value->updated_at)) }}</div>
                                                @else
                                                    <div class="p-1 text-info text-uppercase"> <i class="fas fa-user"></i> Pending Review  - Submitted on: {{ date('d-m-Y h:i:sa', strtotime($value->created_at_time)) }}</div>
                                                @endif
                                            </td>
                                        <tr>
                                    </table>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-backdrop="false" data-target="#viewUserDetails{{$key}}">View</button>
                                </td>
                            </tr>

                            {{-- shortlist candidate --}}
                            <div style="z-index: 9999" class="modal fade text-left d-print-none" id="shortlistUser{{$key}}" tabindex="-1" role="dialog" aria-labelledby="viewUserDetails{{$key}}" aria-hidden="true">
                                <div class="modal-dialog modal-sm" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success">
                                            <h5 class="modal-title text-white"><i class="fa fa-user"></i> Shortlist Candidate</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div align="center" class="modal-body">
                                            <div>{{ $value->name }} </div>
                                            <div class="text-success p-1">Are you sure you want to shortlist this candidate?</div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-dismiss="modal"> close </button>
                                            <a href="{{ Route::has('updateCandidateStatus') ? Route('updateCandidateStatus', ['jid'=>$value->jobID, 'jaid'=>$value->job_applyID, 's'=>1]) : 'javascript:;' }}" class="btn btn-sm btn-outline-success"> Shortlist </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- end shortlist --}}

                            {{-- Reject candidate --}}
                            <div style="z-index: 9999" class="modal fade text-left d-print-none" id="rejectUser{{$key}}" tabindex="-1" role="dialog" aria-labelledby="viewUserDetails{{$key}}" aria-hidden="true">
                                <div class="modal-dialog modal-sm" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning">
                                            <h5 class="modal-title text-white"><i class="fa fa-user"></i> Reject Candidate</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div align="center" class="modal-body">
                                            <div>{{ $value->name }} </div>
                                            <div class="text-warning p-1">Are you sure you want to reject this candidate?</div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-dismiss="modal"> close </button>
                                            <a href="{{ Route::has('updateCandidateStatus') ? Route('updateCandidateStatus', ['jid'=>$value->jobID, 'jaid'=>$value->job_applyID, 's'=>2]) : 'javascript:;' }}" class="btn btn-sm btn-outline-warning"> Reject </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- end Reject --}}

                            {{-- view candidate details  --}}
                            <div style="z-index: 9999" class="modal fade text-left d-print-none" id="viewUserDetails{{$key}}" tabindex="-1" role="dialog" aria-labelledby="viewUserDetails{{$key}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                        <h5 class="modal-title text-dark"><i class="fa fa-user"></i> Candidate Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="row col-md-12">
                                                     <div class="col-md-2">
                                                        <img src="{{ isset($userImages) ? $userImages[$key] : '' }}" alt="" width="100" />
                                                     </div>
                                                     <div class="col-md-10 pl-2">
                                                        <h6><i class="fa fa-user"></i> {{ $value->name }} ({{$value->gender}})</h6>
                                                        <h6><i class="fa fa-envelope"></i> {{ $value->email }}</h6>
                                                        <h6><i class="fa fa-phone"></i> {{ $value->phone_number }}</h6>
                                                        <h6><i class="fa fa-map"></i> {{ $value->location_city .', '. $value->country }}</h6>
                                                        <h6><i class="fa fa-calendar"></i> {{ date('d-m-Y h:i:sa', strtotime($value->created_at_time)) }}</h6>
                                                     </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <hr />
                                                    <h5>Cover Letter</h5>
                                                    <div>{!! $value->cover_letter ? strip_tags($value->cover_letter) : 'No cover leter founds!' !!}</div>
                                                    <hr />
                                                    <h5>Curriculum vitae </h5>
                                                    <div>

                                                        @php
                                                            $getFileExt = pathinfo(isset($userPath) ? $userPath[$key] . $value->file_name : '', PATHINFO_EXTENSION);
                                                        @endphp
                                                        @if($getFileExt == "docx" || $getFileExt == "doc")
                                                            <iframe  width="100%" height="600px" src="http://docs.google.com/gview?url={{ isset($userPath) ? $userPath[$key] . $value->file_name : '' }}&amp;embedded=true"></iframe>
                                                        @else
                                                            <object
                                                                data="{{ isset($userPath) ? $userPath[$key] . $value->file_name : '' }}#page=2"
                                                                type="application/pdf"
                                                                width="100%"
                                                                height="600px">
                                                                <iframe
                                                                    src="{{ isset($userPath) ? $userPath[$key] . $value->file_name : '' }}#page=2"
                                                                    width="100%"
                                                                    height="600px"
                                                                    style="border: none;">
                                                                    <p>Your browser does not support Docs/PDFs.
                                                                    <a href="{{ isset($userPath) ? $userPath[$key] . $value->file_name : '' }}">Download the PDF</a>.</p>
                                                                </iframe>
                                                            </object>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal"> close </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- view details --}}

                        @endforeach
                    @endif
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--=================================
  Manage Jobs -->


@endif
