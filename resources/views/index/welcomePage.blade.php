@extends('layouts.site')
@section("pageTitle", "Welcome to My Job on The Go")
@section("indexPageActive", "active")
@php

@endphp
@section('pageContent')

        @includeIf('share.slider')
        @includeIf('index.welcomePageView', ['showPageIndex' => (isset($showPageIndex) && $showPageIndex ? $showPageIndex : 1)])

@endsection

