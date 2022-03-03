@extends('layouts.site')
@section("pageTitle", "Login To Your Account")
@section("loginPageActive", "active")
@section('pageContent')

    @includeIf('auth.login.loginPageView', ['showPageRegister'=> (isset($showPage) ? $showPage : 1)])

@endsection

{{-- Style --}}
@section('style')

@endsection

{{-- Script --}}
@section('script')

@endsection
