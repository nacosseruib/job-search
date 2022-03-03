@extends('layouts.site')
@section("pageTitle", "View All Registered Users")
@section("adminPageActive", "active")
@section('pageContent')

    @includeIf('share.homeTopMenu', ['data' => '' ])

    @includeIf('admin.viewRegisteredUser.viewUserPageView', ['showPageViewUser'=> (isset($showPageViewUser) ? $showPageViewUser : 1)])

@endsection

{{-- Style --}}
@section('style')

@endsection

{{-- Script --}}
@section('script')

@endsection
