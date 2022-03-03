@extends('layouts.site')
@section("pageTitle", "Payment Complete")
@section("paymentPageActive", "active")
@section('pageContent')

    {{-- @includeIf('share.homeTopMenu', ['data' => '' ]) --}}

    <section>
        <div class="container">
          <div class="">
            <div class="col-md-12 p-3">
                <div align="center" class="row">
                    <div class="col-md-10 offset-md-1">

                        <div class="alert alert-success p-2 h5">
                            Payment Completed.
                            <div class="h5 m-2 p-2 bg-success text-white">Your payment was successful.</div>
                        </div>

                        <a href="{{ Route::has('dashboard') ? Route('dashboard') : 'javascript' }}" class="btn btn-outline-success">Back to Dashboard</a>

                    </div>
                </div>
            </div>
          </div>
        </div>
    </section>

@endsection

{{-- Style --}}
@section('style')

@endsection

{{-- Script --}}
@section('script')

@endsection
