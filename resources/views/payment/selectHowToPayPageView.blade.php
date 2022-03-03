@extends('layouts.site')
@section("pageTitle", "Payment Summary")
@section("paymentPageActive", "active")
@section('pageContent')

    @includeIf('share.homeTopMenu', ['data' => '' ])

    <section>
        <div class="container">
          <div class="">
            <div class="col-md-12 bg-light p-3">

                <form method="POST" action="{{ route('payNow') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
                @csrf

                    {{-- <div class="col-md-10 offset-md-1 alert alert-info h6 text-center">
                        {{ isset($paymentDetails) && $paymentDetails ? $paymentDetails->payment_description : 0 }} <br/> Amount: {{ isset($paymentDetails) && $paymentDetails ? number_format($paymentDetails->amount, 2) : 0 }} NGN
                    </div> --}}

                    <div align="center" class="row">
                        <div class="col-md-10 offset-md-1 row">

                                <div class="col-md-6">
                                    <div class="alert alert-light">
                                       <h5><b> PAY FROM WALLET</b></h5>
                                       <hr />
                                       <span class="fas fa-wallet fa-4x"></span>
                                       <br />
                                       <div class="p-2 bg-success">
                                           <h4 class="text-white">Balance:  {{ isset($walletDetails) && $walletDetails ? number_format($walletDetails->balance_amount, 2) : 0 }} NGN</h4>
                                       </div>
                                        <hr />
                                        <br />
                                        <div class="p-2">
                                                <a href="{{ Route::has('getPaymentSummary') ? Route('getPaymentSummary', ['phID'=>isset($paymentDetails) && $paymentDetails ? $paymentDetails->paymentID : null, 'pay'=>'wallet']) : 'javascript:;' }}" class="btn btn-outline-success">Continue Payment with wallet</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="alert alert-light">
                                        <h5><b>PAY WITH PAYSTACK</b></h5>
                                        <img src="{{ asset('assets/images/bg/paystack.png') }}" class="img-responsive" style="width:83%" />
                                        <hr />
                                        <div class="p-2">
                                            <a href="{{ Route::has('getPaymentSummary') ? Route('getPaymentSummary', ['phID'=>isset($paymentDetails) && $paymentDetails ? $paymentDetails->paymentID : null, 'pay'=>'gateway']) : 'javascript:;' }}" class="btn btn-outline-success">Continue Payment with paystack</a>
                                        </div>
                                    </div>
                                </div>

                        </div>
                    </div>
                </form>

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
