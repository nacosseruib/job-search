@extends('layouts.site')
@section("pageTitle", "Our Terms and Conditions")
@section("termsConditionsPageActive", "active")
@section('pageContent')

    @includeIf('share.topHeader', ['data' => '' ])
    
    @includeIf('termsAndConditions.termsAndConditionsPageView', ['showPageTerm'=> (isset($showPageTerm) ? $showPageTerm : 1)])

@endsection

{{-- Style --}}
@section('style')

@endsection

{{-- Script --}}
@section('script')

@endsection
