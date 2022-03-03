@extends('layouts.site')
@section("pageTitle", "My Resume")
@section("resumePageActive", "active")
@section('pageContent')

    @includeIf('share.homeTopMenu', ['data' => '' ])

    @includeIf('candidate.myResume.resumePageView', ['showPageResume'=> (isset($showPageResume) ? $showPageResume : 1)])

@endsection


{{-- Style --}}
@section('style')
    <link href="{{ asset('assets/summernote/summernote-bs4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Script --}}
@section('script')
      <!--Text Editor-->
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
                height: 100,
                tabsize: 2,
            });
            $('.summernoteLong').summernote({
                height: 220,
                tabsize: 2,
            });

        });
    </script>
@endsection
