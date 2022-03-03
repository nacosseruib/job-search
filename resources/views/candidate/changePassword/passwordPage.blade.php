@extends('layouts.site')
@section("pageTitle", "Update Account Security")
@section("securityPageActive", "active")
@section('pageContent')

    @includeIf('share.homeTopMenu', ['data' => '' ])

    @includeIf('candidate.changePassword.passwordPageView', ['showPageSecurity'=> (isset($showPageSecurity) ? $showPageSecurity : 1)])

@endsection

{{-- Style --}}
@section('style')

@endsection

{{-- Script --}}
@section('script')

@endsection
