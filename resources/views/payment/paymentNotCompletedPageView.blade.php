@extends('layouts.site')
@section("pageTitle", "Payment Not Complete")
@section("paymentPageActive", "active")
@section('pageContent')

    {{-- @includeIf('share.homeTopMenu', ['data' => '' ]) --}}

    <section>
        <div class="container">
          <div class="">
            <div class="col-md-12 p-3">
                <div align="center" class="row">
                    <div class="col-md-10 offset-md-1">

                        <div class="alert alert-danger p-2 h5">
                            Payment Not Completed.
                            <div class="h5 m-2 p-2 bg-danger text-white">Your payment was not successful.</div>

                            <div class="p-2">Please try again.</div>
                        </div>

                        <a href="{{ Route::has('dashboard') ? Route('dashboard') : 'javascript' }}" class="btn btn-outline-warning">Back to Dashboard</a>

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
