@extends('layouts.site')
@section("pageTitle", "My Profile")
@section("profilePageActive", "active")
@section('pageContent')

    @includeIf('share.homeTopMenu', ['data' => '' ])

    @includeIf('candidate.profile.profilePageView', ['showPageCandidateProfile'=> (isset($showPageCandidateProfile) ? $showPageCandidateProfile : 1)])

@endsection

{{-- Style --}}
@section('style')

@endsection

{{-- Script --}}
@section('script')

@endsection
