@extends('layouts.site')
@section("pageTitle", "Payment Summary")
@section("paymentPageActive", "active")
@section('pageContent')

    @includeIf('share.homeTopMenu', ['data' => '' ])

    @includeIf('payment.paymentSummaryPageView', ['showPagePayment'=> (isset($showPagePayment) ? $showPagePayment : 1)])

@endsection

{{-- Style --}}
@section('style')

@endsection

{{-- Script --}}
@section('script')

@endsection
