@extends('layouts.site')
@section("pageTitle", "Request For Your CV To Be Built")
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

                <form method="post" action="{{ (Route::has('postRequestBuildCV') ? Route('postRequestBuildCV') : '#') }}" enctype="multipart/form-data">
                @csrf
                <div class="">
                    <div class="row">
                        <div class="col-md-12 row">
                            <div class="form-group col-md-6 mt-2">
                                <label for="cv"> Select CV to be Built <span class="text-danger">*</span> </label>
                                <select name="cv" required class="form-control basic-select @error('cv') is-invalid @enderror">
                                    <option value="" selected="selected">Select</option>
                                    @if(isset($allMyCV) && $allMyCV)
                                        @foreach($allMyCV as $value)
                                            <option value="{{$value->candidate_cvID}}" {{ $value->candidate_cvID == old('cv') ? 'selected' : '' }}>{{$value->file_description}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('cv')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 mt-2">
                                <label for="description">Description (Add Comment) </label>
                                <input type="text" value="{{ (isset($jobDetails) && $jobDetails) ? $jobDetails->job_title : old('description') }}" name="description" class="form-control @error('description') is-invalid @enderror">
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-12 mt-2">
                                <label for="resume"> Enter Your Complete Resume </label>
                                <textarea name="resume" class="summernoteShort form-control @error('resume') is-invalid @enderror">{{ old('resume') }}</textarea>
                                @error('resume')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div align="center" class="col-md-12">
                                <button type="submit" class="btn btn-outline-primary">Submit Request</button>
                         </div>
                    </div>
                </div>
                </form>

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
