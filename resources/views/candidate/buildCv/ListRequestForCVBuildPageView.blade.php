@extends('layouts.site')
@section("pageTitle", "My CV Build Request")
@section("buildCVPageActive", "active")
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
                                    <th>SN</th>
                                    <th>Date Requested</th>
                                    <th>Transaction ID</th>
                                    <th>CV Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Resume</th>
                                    <th></th>
                                </tr>

                                @if(isset($listAllCVBuildRequest) && $listAllCVBuildRequest)
                                    @foreach($listAllCVBuildRequest as $key => $value)
                                        <tr>
                                            <td>{{ ($key + 1) }}</td>
                                            <td>{!! date('jS M, Y', strtotime($value->created_at)) !!}</td>
                                            <td>{{ $value->transactionID }}</td>
                                            <td>
                                                <a href="{{ (isset($userPath) ? $userPath . $value->file_name : '#') }}" target="_blank" title="{{ $value->file_description }}">{{ $value->file_description }}</a>
                                            </td>
                                            <td>{{ $value->description }}</td>
                                            <td>
                                                @if($value->payment_status_code == 200)
                                                    <div class="text-white text-center bg-success p-1"> PAID </div>
                                                @else
                                                    <div class="text-white text-center bg-danger p-1"> UNPAID </div>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-backdrop="false" data-target="#viewResumeDetails{{$key}}">View</button>
                                            </td>
                                            <td>
                                                @if($value->payment_status_code <> 200)
                                                    <a href="{{ Route::has('whereToMakePayement') ? Route('whereToMakePayement', ['phID'=>$value->paymentID]) : 'javascript:;' }}" title="make payment now" class="btn btn-outline-success btn-sm">
                                                        Pay&nbsp;({{number_format($value->amount, 2)}}&nbsp;NGN)
                                                    </a>
                                                @else
                                                    <div class="text-white text-center bg-success p-1"> Comfirmed </div>
                                                @endif
                                            </td>
                                        </tr>

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
