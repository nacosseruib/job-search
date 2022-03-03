@extends('layouts.site')
@section("pageTitle", "Upload Profile and Cover Image")
@section("photoPageActive", "active")
@section('pageContent')

    @includeIf('share.homeTopMenu', ['data' => '' ])

    @includeIf('candidate.uploadProfileAndCoverImages.uploadImagePageView', ['showPageUploadImages'=> (isset($showPageUploadImages) ? $showPageUploadImages : 1)])

@endsection

{{-- Style --}}
@section('style')

@endsection

{{-- Script --}}
@section('script')

@endsection
