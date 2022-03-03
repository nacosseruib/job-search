@extends('layouts.site')
@section("pageTitle", "About Us")
@section("aboutusPageActive", "active")
@section('pageContent')

    @includeIf('share.topHeader', ['data' => '' ])

    @includeIf('aboutus.aboutusPageView', ['showPageAboutus'=> (isset($showPageAboutus) ? $showPageAboutus : 1)])

@endsection

{{-- Style --}}
@section('style')

@endsection

{{-- Script --}}
@section('script')

@endsection
