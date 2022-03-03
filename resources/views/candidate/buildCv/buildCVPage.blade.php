@extends('layouts.site')
@section("pageTitle", "Build CV")
@section("buildCVPageActive", "active")
@section('pageContent')

    @includeIf('share.homeTopMenu', ['data' => '' ])

    @includeIf('candidate.buildCv.buildCVPageView', ['showPageBuildCV'=> (isset($showPageBuildCV) ? $showPageBuildCV : 1)])

@endsection

{{-- Style --}}
@section('style')

@endsection

{{-- Script --}}
@section('script')

@endsection
