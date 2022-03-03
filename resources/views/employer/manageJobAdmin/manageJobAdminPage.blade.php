@extends('layouts.site')
@section("pageTitle", "Manage Job")
@section("employerManageJobPageActive", "active")
@section('pageContent')

    @includeIf('share.homeTopMenu', ['data' => '' ])

    @includeIf('employer.manageJob.manageJobPageView', ['showPagePostedJob'=> (isset($showPagePostedJob) ? $showPagePostedJob : 1)])

@endsection

{{-- Style --}}
@section('style')

@endsection

{{-- Script --}}
@section('script')

@endsection
