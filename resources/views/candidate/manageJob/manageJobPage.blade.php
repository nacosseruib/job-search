@extends('layouts.site')
@section("pageTitle", "Manage Job")
@section("manageAppliedJobPageActive", "active")
@section('pageContent')

    @includeIf('share.homeTopMenu', ['data' => '' ])

    @includeIf('candidate.manageJob.manageJobPageView', ['showPageManageJob'=> (isset($showPageManageJob) ? $showPageManageJob : 1)])

@endsection

{{-- Style --}}
@section('style')

@endsection

{{-- Script --}}
@section('script')

@endsection
