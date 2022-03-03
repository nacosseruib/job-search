@extends('layouts.site')
@section("pageTitle", "Wallet Payment Transaction")
@section("walletPageActive", "active")
@section('pageContent')

    @includeIf('share.homeTopMenu', ['data' => '' ])

    <section>
        <div class="container">
          <div class="row">
            <div class="col-md-12 p-3">

                    <div align="center">
                        <div class="h5 p-2 text-left text-dark font-weight-bold">WALLET PAYMENT HISTORY</div>
                        <table class="table tbale-responsive table-hover table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>PAYMENT TYPE</th>
                                    <th>AMOUNT</th>
                                    <th>WALLET BAL.</th>
                                    <th>PAYMENT DESC.</th>
                                    <th>DATE/TIME</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($paymentTransaction) && $paymentTransaction)
                                    @foreach($paymentTransaction as $key => $value)
                                        <tr>
                                            <td>{{ ($key + 1) }}</td>
                                            <td>{{ $value->payment_type }}</td>
                                            <td>{{ is_numeric($value->payment_amount) ? number_format($value->payment_amount, 2) : $value->payment_amount }}</td>
                                            <td>{{ is_numeric($value->wallet_balance) ? number_format($value->wallet_balance, 2) : $value->wallet_balance }}</td>
                                            <td>{{ $value->payment_description }}</td>
                                            <td>{{ date('d-m-Y h:i a', strtotime($value->created_at_time ))}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
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
