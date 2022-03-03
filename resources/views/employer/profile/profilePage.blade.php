@extends('layouts.site')
@section("pageTitle", "My Profile")
@section("emplyerProfilePageActive", "active")
@section('pageContent')

    @includeIf('share.homeTopMenu', ['data' => '' ])

    @includeIf('employer.profile.profilePageView', ['showPageProfile'=> (isset($showPageProfile) ? $showPageProfile : 1)])

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
                height: 100,
                tabsize: 2,
            });
            $('.summernoteLong').summernote({
                height: 200,
                tabsize: 2,
            });

        });
    </script>

@endsection
