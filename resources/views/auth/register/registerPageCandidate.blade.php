@extends('layouts.site')
@section("pageTitle", "Create New Account")
@section("candidateRegistration", "active")
@section('pageContent')

    @includeIf('auth.register.registerPageViewCandidate', ['showPageRegister'=> (isset($showPage) ? $showPage : 1)])

@endsection

{{-- Style --}}
@section('style')

@endsection

{{-- Script --}}
@section('script')

@endsection
