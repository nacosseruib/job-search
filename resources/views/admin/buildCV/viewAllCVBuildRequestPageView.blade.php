@extends('layouts.site')
@section("pageTitle", "Request For CV Building")
@section("buildCVRequestPageActive", "active")
@section('pageContent')

    @includeIf('share.homeTopMenu', ['data' => '' ])

    <section>
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="user-dashboard-info-box mb-0">

                <div class="row">
                  <div class="col-md-12 col-sm-12 d-flex align-items-center">
                    <div class="section-title-02 mb-0 ">
                      <h4 class="mb-0">@yield('pageTitle')</h4>
                      <hr />
                    </div>
                  </div>
                </div>

                <div class="">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-hover table-responsive">
                                <tr>
                                    <th colspan="9" class="text-center text-success">PAID CV BUILD REQUEST</th>
                                </tr>
                                <tr>
                                    <th>SN</th>
                                    <th>Full Name</th>
                                    <th>Location</th>
                                    <th>Transaction ID</th>
                                    <th>CV Name</th>
                                    <th>Description</th>
                                    <th>Resume</th>
                                    <th>Date Requested</th>
                                    <th>Status</th>
                                    <th>Upload CV</th>
                                </tr>

                                @if(isset($paidListAllCVBuildRequest) && $paidListAllCVBuildRequest)
                                    @foreach($paidListAllCVBuildRequest as $key => $value)
                                        <tr>
                                            <td>{{ ($key + 1) }}</td>
                                            <td>
                                                {{ $value->first_name . ' '. $value->last_name }} <br />
                                                {{ $value->phone_number }} <br />
                                                {{ $value->email }}
                                            </td>
                                            <td>{{ $value->location_city .', '. $value->country }}</td>
                                            <td>{{ $value->transactionID }}</td>
                                            <td>
                                                <a href="{{ (isset($filePath) ? $filePath[$key] : '#') }}" target="_blank" title="{{ $value->file_description }}">{{ $value->file_description }}</a>
                                            </td>
                                            <td>{{ $value->description }}</td>
                                            <td>
                                                @if($value->resume_details)
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-backdrop="false" data-target="#viewResumeDetails{{$key}}">View</button>
                                                @endif
                                            </td>
                                            <td>{!! date('jS M, Y', strtotime($value->created_at)) !!}</td>
                                            <td>
                                                @if($value->payment_status_code == 200)
                                                    <div class="text-white text-center bg-success p-1"> PAID </div>
                                                @else
                                                    <div class="text-white text-center bg-danger p-1"> UNPAID </div>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-backdrop="false" data-target="#uploadNewCVPaid{{$key}}" title="Upload new CV">Upload</button>
                                            </td>
                                        </tr>

                                        {{-- upload new CV --}}
                                        <div style="z-index: 99999" class="modal fade text-left d-print-none" id="uploadNewCVPaid{{$key}}" tabindex="-1" role="dialog" aria-labelledby="uploadNewCVPaid{{$key}}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-light">
                                                    <h5 class="modal-title text-dark"><i class="fa fa-file"></i> Upload New CV</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <form method="post" action="{{ (Route::has('postNewCVRequest') ? Route('postNewCVRequest') : '#') }}" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="bg-light p-3 mt-4">
                                                                        @include('share.uploadCVFields')
                                                                        <input type="hidden" name="userName" value="{{$value->userID}}" />
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="bg-white p-3 mt-4">
                                                                    <h6>All files you have sent to this user:</h6>
                                                                    <hr />
                                                                    @if(isset($getAllSentCVPaid) && $getAllSentCVPaid)
                                                                        @foreach($getAllSentCVPaid[$key] as $keyCV => $value)
                                                                            <a href="{{ isset($userPath) ? $userPath . $value->file_name : 'javascript:;' }}" target="_black">
                                                                                {{ ($keyCV + 1). '.  '. $value->file_description .' - (Date Sent: '. date('d-m-Y', strtotime($value->created_at)) .')' }}
                                                                            </a>
                                                                            <br />
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-success btn-sm" data-dismiss="modal"> Close </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- //upload new CV--}}

                                         {{-- View Resume  --}}
                                         <div style="z-index: 99999" class="modal fade text-left d-print-none" id="viewResumeDetails{{$key}}" tabindex="-1" role="dialog" aria-labelledby="viewResumeDetails{{$key}}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-light">
                                                    <h5 class="modal-title text-dark"><i class="fa fa-file"></i> Resume</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="text-justify text-dark">
                                                            {!! $value->resume_details !!}
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-success btn-sm" data-dismiss="modal"> Close </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--View Resume--}}

                                    @endforeach
                                @endif
                            </table>
                            @if(isset($paidListAllCVBuildRequest) && $paidListAllCVBuildRequest)
                            <div align="right" class="col-md-12"><hr />
                                Showing {{($paidListAllCVBuildRequest->currentpage()-1)*$paidListAllCVBuildRequest->perpage()+1}}
                                        to {{$paidListAllCVBuildRequest->currentpage()*$paidListAllCVBuildRequest->perpage()}}
                                        of  {{$paidListAllCVBuildRequest->total()}} entries
                            </div>
                            <div class="d-print-none">{{ $paidListAllCVBuildRequest->links() }}</div>
                            @endif

                            <br /><br />

                            <table class="table table-striped table-hover table-responsive">
                                <tr>
                                    <th colspan="8" class="text-center text-danger">UNPAID CV BUILD REQUEST</th>
                                </tr>
                                <tr>
                                    <th>SN</th>
                                    <th>Full Name</th>
                                    <th>Location</th>
                                    <th>Transaction ID</th>
                                    <th>CV Name</th>
                                    <th>Description</th>
                                    <th>Resume</th>
                                    <th>Date Requested</th>
                                    <th>Status</th>
                                    {{-- <th>Upload CV</th> --}}
                                </tr>

                                @if(isset($unpaidListAllCVBuildRequest) && $unpaidListAllCVBuildRequest)
                                    @foreach($unpaidListAllCVBuildRequest as $key => $value)
                                        <tr>
                                            <td>{{ ($key + 1) }}</td>
                                            <td>
                                                {{ $value->first_name . ' '. $value->last_name }}  <br />
                                                {{ $value->phone_number }}<br />
                                                {{ $value->email }}
                                            </td>
                                            <td>{{ $value->location_city .', '. $value->country }}</td>
                                            <td>{{ $value->transactionID }}</td>
                                            <td>
                                                <a href="{{ (isset($unpaidFilePath) ? $unpaidFilePath[$key] : '#') }}" target="_blank" title="{{ $value->file_description }}">{{ $value->file_description }}</a>
                                            </td>
                                            <td>{{ $value->description }}</td>
                                            <td>
                                                @if($value->resume_details)
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-backdrop="false" data-target="#viewResumeDetails{{$key}}">View</button>
                                                @endif
                                            </td>
                                            <td>{!! date('jS M, Y', strtotime($value->created_at)) !!}</td>
                                            <td>
                                                @if($value->payment_status_code == 200)
                                                    <div class="text-white text-center bg-success p-1"> PAID </div>
                                                @else
                                                    <div class="text-white text-center bg-danger p-1"> UNPAID </div>
                                                @endif
                                            </td>
                                            {{-- <td>
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-backdrop="false" data-target="#uploadNewCV{{$key}}" title="Upload new CV">Upload</button>
                                            </td> --}}
                                        </tr>

                                          {{-- upload new CV --}}
                                          <div style="z-index: 99999" class="modal fade text-left d-print-none" id="uploadNewCV{{$key}}" tabindex="-1" role="dialog" aria-labelledby="uploadNewCV{{$key}}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-light">
                                                    <h5 class="modal-title text-dark"><i class="fa fa-file"></i> Upload New CV</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <form method="post" action="{{ (Route::has('postNewCVRequest') ? Route('postNewCVRequest') : '#') }}" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="bg-light p-3 mt-4">
                                                                        @include('share.uploadCVFields')
                                                                        <input type="hidden" name="userName" value="{{$value->userID}}" />
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="bg-white p-3 mt-4">
                                                                    <h6>All files you have sent to this user:</h6>
                                                                    <hr />
                                                                    @if(isset($getAllSentCVUnpaid) && $getAllSentCVUnpaid)
                                                                        @foreach($getAllSentCVUnpaid[$key] as $keyCV => $value)
                                                                            <a href="{{ isset($userPath) ? $userPath . $value->file_name : 'javascript:;' }}" target="_black">
                                                                                {{ ($keyCV + 1). '.  '. $value->file_description .' - (Date Sent: '. date('d-m-Y', strtotime($value->created_at)) .')' }}
                                                                            </a>
                                                                            <br />
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-success btn-sm" data-dismiss="modal"> Close </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- //upload new CV--}}

                                        {{-- View Resume  --}}
                                        <div style="z-index: 99999" class="modal fade text-left d-print-none" id="viewResumeDetails{{$key}}" tabindex="-1" role="dialog" aria-labelledby="viewResumeDetails{{$key}}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-light">
                                                    <h5 class="modal-title text-dark"><i class="fa fa-file"></i> Resume</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="text-justify text-dark">
                                                            {!! $value->resume_details !!}
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-success btn-sm" data-dismiss="modal"> Close </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--View Resume--}}

                                    @endforeach
                                @endif
                            </table>
                            @if(isset($unpaidListAllCVBuildRequest) && $unpaidListAllCVBuildRequest)
                            <div align="right" class="col-md-12"><hr />
                                Showing {{($unpaidListAllCVBuildRequest->currentpage()-1)*$unpaidListAllCVBuildRequest->perpage()+1}}
                                        to {{$unpaidListAllCVBuildRequest->currentpage()*$unpaidListAllCVBuildRequest->perpage()}}
                                        of  {{$unpaidListAllCVBuildRequest->total()}} entries
                            </div>
                            <div class="d-print-none">{{ $unpaidListAllCVBuildRequest->links() }}</div>
                            @endif
                        </div>
                    </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </section>

@endsection

{{-- Style --}}
@section('style')
    <link href="{{ asset('assets/summernote/summernote-bs4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Script --}}
@section('script')
    <!-- Summernote js -->
    <script src="{{ asset('assets/summernote/summernote-bs4.min.js') }}"></script>
    <!--tinymce js-->
    <script src="{{ asset('assets/summernote/tinymce.min.js') }}"></script>
    <!-- init js -->
    <script src="{{ asset('assets/summernote/form-editor.init.js') }}"></script>
    <script>
        $(document).ready(function() {
            var getVale;
            $('.summernoteShort').summernote({
                height: 250,
                tabsize: 2,
            });
        });
    </script>
@endsection
