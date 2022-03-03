@extends('layouts.site')
@section("pageTitle", "Manage Job")
@section("adminManageJobPageActive", "active")
@section('pageContent')

    @includeIf('share.homeTopMenu', ['data' => '' ])

    @includeIf('admin.manageJobAdmin.manageJobAdminPageView', ['showPagePostedJob'=> (isset($showPagePostedJob) ? $showPagePostedJob : 1)])

@endsection

{{-- Style --}}
@section('style')

@endsection

{{-- Script --}}
@section('script')

@endsection
