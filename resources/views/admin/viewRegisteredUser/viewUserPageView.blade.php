@if(isset($showPageViewUser) && $showPageViewUser == 1)

<section>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="user-dashboard-info-box mb-0">

            <div class="row mb-4">
              <div class="col-md-7 col-sm-5 d-flex align-items-center">
                <div class="section-title-02 mb-0 ">
                  <h4 class="mb-0">List of all registered users</h4>
                </div>
              </div>
            </div>

            <div class="user-dashboard-table table-responsive">
              <table class="table table-bordered">
                <thead class="bg-light">
                    <tr >
                        <th scope="col">SN</th>
                        <th scope="col">USER'S NAME</th>
                        <th scope="col">GENDER</th>
                        <th scope="col">EMAIL</th>
                        <th scope="col">MOBILE NUMBER</th>
                        <th scope="col">CITY/COUNTRY</th>
                        <th scope="col">STATUS</th>
                        <th scope="col">DATE CREATED</th>
                        <th scope="col">LAST UPDATED</th>
                    </tr>
                </thead>
                <tbody>

                    @if(isset($registeredUsers) && $registeredUsers)
                        @forelse($registeredUsers as $key => $value)
                            <tr>
                                <td>{{ ($key + 1) }}</td>
                                <td>{{ $value->first_name .' '. $value->last_name }}</td>
                                <td>{{ $value->gender }}</td>
                                <td>{{ $value->email }}</td>
                                <td>{{ $value->phone_number }}</td>
                                <td>{{ $value->location_city .', '. $value->country }}</td>
                                <td>{{ ($value->candidate_status == 1 ? 'Shortlisted' : ($value->candidate_status == 2 ? 'Rejected' : 'Not Review')) }}</td>
                                <td class="text-center">{{ ($value->join_date ? date('d-m-Y', strtotime($value->join_date)) : '-') }}</td>
                                <td class="text-center">{{ date('d-m-Y h:i:s a', strtotime($value->updated_at_time )) }}</td>
                            </tr>
                        @empty
                            <tr >
                                <td colspan="8" scope="col" class="text-center text-danger">NO RECORD FOUND!</td>
                            </tr>
                        @endforelse
                    @endif
                </tbody>
              </table>
              @if(isset($registeredUsers) && $registeredUsers)
                <div align="right" class="col-md-12"><hr />
                Showing {{($registeredUsers->currentpage()-1)*$registeredUsers->perpage()+1}}
                        to {{$registeredUsers->currentpage()*$registeredUsers->perpage()}}
                        of  {{$registeredUsers->total()}} entries
                </div>
                <div class="d-print-none">{{ $registeredUsers->links() }}</div>
            @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endif
