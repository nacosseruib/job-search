@if(isset($showPageCandidateStatus) && $showPageCandidateStatus == 1)

<section>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="user-dashboard-info-box mb-0">

            <div class="row mb-4">
              <div class="col-md-7 col-sm-5 d-flex align-items-center">
                <div class="section-title-02 mb-0 ">
                  <h4 class="mb-0">Candidate Status</h4>
                </div>
              </div>
            </div>

            <div class="user-dashboard-table table-responsive">
              <table class="table table-bordered">
                <thead class="bg-light">
                    <tr >
                        <th colspan="8" scope="col" class="text-uppercase">
                            {{ isset($getJob) && $getJob ? $getJob->job_title : '' }}
                        </th>
                    </tr>
                    <tr >
                        <th colspan="4" scope="col" class="text-uppercase">
                            {{ isset($getJob) && $getJob ? $getJob->industry_name : '' }}
                        </th>
                        <th colspan="4" scope="col" class="text-uppercase">
                            {{ isset($getJob) && $getJob ? $getJob->type_name : '' }}
                        </th>
                    </tr>
                    <tr >
                        <th colspan="4" scope="col" class="text-uppercase">
                            Posted On: {{ date('jS F, Y', strtotime($getJob->job_post_date )) }}
                        </th>
                        <th colspan="4" scope="col" class="text-uppercase">
                            Expired On: {{ date('jS F, Y', strtotime($getJob->job_expire_date )) }}
                        </th>
                    </tr>
                    <tr >
                        <th colspan="8" scope="col"></th>
                    </tr>
                    <tr >
                        <th scope="col">SN</th>
                        <th scope="col">CANDIDATE NAME</th>
                        <th scope="col">GENDER</th>
                        <th scope="col">EMAIL</th>
                        <th scope="col">MOBILE NUMBER</th>
                        <th scope="col">CITY/COUNTRY</th>
                        <th scope="col">STATUS</th>
                        <th scope="col">LAST UPDATED</th>
                    </tr>
                </thead>
                <tbody>

                    @if(isset($getAllCandidate) && $getAllCandidate)
                        @forelse($getAllCandidate as $key => $value)
                            <tr>
                                <td>{{ ($key + 1) }}</td>
                                <td>{{ $value->first_name .' '. $value->last_name }}</td>
                                <td>{{ $value->gender }}</td>
                                <td>{{ $value->email }}</td>
                                <td>{{ $value->phone_number }}</td>
                                <td>{{ $value->location_city .', '. $value->country }}</td>
                                <td>{{ ($value->candidate_status == 1 ? 'Shortlisted' : ($value->candidate_status == 2 ? 'Rejected' : 'Not Review')) }}</td>
                                <td>{{ date('jS M, Y h:i:s a', strtotime($value->updated_at_time )) }}</td>
                            </tr>
                        @empty
                            <tr >
                                <td colspan="8" scope="col" class="text-center text-danger">NO RECORD FOUND!</td>
                            </tr>
                        @endforelse
                    @endif
                </tbody>
              </table>

              <div align="center">
                  <a href="{{ (Route::has('manageCandidate') ? Route('manageCandidate') : 'javascript:;' ) }}" class="btn btn-dark" title="Go back">Go Back</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endif
