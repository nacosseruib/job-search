@extends('layouts.site')
@section("pageTitle", "Job Listing")
@section("listOfJobPageActive", "active")
@section('pageContent')

    @php $showMoreSearchParameters = 1; @endphp

    @includeIf('share.topHeader', ['data' => '' ])

    @includeIf('jobListing.jobListingPageView', ['showPageJobListing'=> (isset($showPageJobListing) ? $showPageJobListing : 1)])

@endsection

{{-- Style --}}
@section('style')

@endsection

{{-- Script --}}
@section('script')

@endsection
