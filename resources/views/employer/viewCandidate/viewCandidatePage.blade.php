@extends('layouts.site')
@section("pageTitle", "View All Candidate Shortlisted or Rejected")
@section("employerManageCandidatePageActive", "active")
@section('pageContent')

    @includeIf('share.homeTopMenu', ['data' => '' ])

    @includeIf('employer.viewCandidate.viewCandidatePageView', ['showPageCandidateStatus'=> (isset($showPageCandidateStatus) ? $showPageCandidateStatus : 1)])

@endsection

{{-- Style --}}
@section('style')

@endsection

{{-- Script --}}
@section('script')

@endsection
