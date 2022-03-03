<form method="Post" action="{{ Route::has('postSearchJob') ? Route('postSearchJob') : 'javascript:;' }}">
    @csrf
    <div class="bg-dark p-2" style="border-radius: 6px;">
    <div class="row">
        <div class="col-md-5" align="left">
            <div class="position-relative left-icon">
            <select class="custom-select-lg basic-select" name="industry" style="width: 100%; border:none;">
                <option value="">All Industries</option>
                @if(isset($allCategory) && $allCategory)
                    @foreach($allCategory as $key => $value)
                        <option value="{{$value->industryID}}" {{ isset($category) && $category == $value->industryID ? 'selected' : '' }}> {{ $value->industry_name }} </option>
                    @endforeach
                @endif
            </select>
            </div>
        </div>
        <div class="col-md-5" align="left">
            <div class="position-relative left-icon">
            <select class="custom-select-lg basic-select" name="location" style="width: 100%; border: none;">
                <option value="">All Locations</option>
                @if(isset($getAllJobLocation) && $getAllJobLocation)
                    @foreach($getAllJobLocation as $value)
                        <option {{ isset($location) && $location == $value->job_location ? 'selected' : '' }}>{{ $value->job_location }}</option>
                    @endforeach
                @endif
            </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="position-relative right-icon">
                <div align="center">
                    <button type="submit" class="btn btn-primary" style="margin: 5px 0 0 0px; height: 48px; padding: 12px;"><i class="fas fa-search"></i> Search</button>
                </div>
            </div>
        </div>

        {{--  more search parameters--}}
        <div class="col-md-12">
            <div class="dashboard-resume-title d-flex align-items-center p-1 mr-3">
                <a class="ml-md-auto text-white" data-toggle="collapse" href="#moreFilter" role="button" aria-expanded="false" aria-controls="moreFilter">Add More Filter</a>
            </div>
            <div class="collapse" id="moreFilter"> {{-- show --}}
                <div class="bg-light p-3 mt-1">
                    <div class="row">
                        <div class="col-md-4 mt-1" align="left">
                            <div class="position-relative left-icon">
                            <select class="custom-select-lg basic-select" name="jobType" style="width: 100%; border:none;">
                                <option value="">All Job Type</option>
                                @if(isset($getJobType) && $getJobType)
                                    @foreach($getJobType as $key => $value)
                                        <option value="{{$value->job_typeID}}" {{ isset($jobType) && $jobType == $value->job_typeID ? 'selected' : '' }}> {{ $value->type_name }} </option>
                                    @endforeach
                                @endif
                            </select>
                            </div>
                        </div>
                        <div class="col-md-4 mt-1" align="left">
                            <div class="position-relative left-icon">
                            <select class="custom-select-lg basic-select" name="salary" style="width: 100%; border: none;">
                                <option value="" selected>Salary Range</option>
                                <option value="10000, 50000" {{ isset($salary) && $salary == '10000, 50000' ? 'selected' : '' }}>10,000 - 50,000 NGN</option>
                                <option value="50000, 100000" {{ isset($salary) && $salary == '50000, 100000' ? 'selected' : '' }}>50,000 - 100,000 NGN</option>
                                <option value="100000, 300000" {{ isset($salary) && $salary == '100000, 300000' ? 'selected' : '' }}>100,000 - 300,000 NGN</option>
                                <option value="300000, 500000" {{ isset($salary) && $salary == '300000, 500000' ? 'selected' : '' }}>300,000 - 500,000 NGN</option>
                                <option value="500000, 800000" {{ isset($salary) && $salary == '500000, 800000' ? 'selected' : '' }}>500,000 - 800,000 NGN</option>
                                <option value="800000, 1000000" {{ isset($salary) && $salary == '800000, 1000000' ? 'selected' : '' }}>800,000 - 1,000,000 NGN</option>
                                <option value="1000000, 1300000" {{ isset($salary) && $salary == '1000000, 1300000' ? 'selected' : '' }}>1,000,000 - 1,300,000 NGN</option>
                                <option value="1300000, 1500000" {{ isset($salary) && $salary == '1300000, 1500000' ? 'selected' : '' }}>1,300,000 - 1,500,000 NGN</option>
                                <option value="1500000, 999999999999999" {{ isset($salary) && $salary == '1500000, 999999999999999' ? 'selected' : '' }}>1,500,000 - More NGN</option>
                            </select>
                            </div>
                        </div>
                        <div class="row col-md-4 mt-1">
                            <div class="col-md-4 bg-white pt-2 pr-0 pl-1">
                                <div class="position-relative left-icon text-right">
                                    Date Posted Till Date:
                                </div>
                            </div>
                            <div class="col-md-8 bg-white">
                                <div align="left" class="position-relative left-icon">
                                <input type="date" value="{{ isset($datePoster) ? $datePoster : '' }}" class="form-control" name="postedDate" placeholder="Date Posted" style="width: 100%; border:none;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end more search parameters --}}

    </div>
 </div>
</form>
