@extends('layouts.site')
@section("pageTitle", "Saved Jobs")
@section("savedJobPageActive", "active")
@section('pageContent')

    @includeIf('share.homeTopMenu', ['data' => '' ])

    @includeIf('candidate.savedJob.savedJobPageView', ['showPageSavedJob'=> (isset($showPageSavedJob) ? $showPageSavedJob : 1)])

@endsection

{{-- Style --}}
@section('style')

@endsection

{{-- Script --}}
@section('script')

@endsection
