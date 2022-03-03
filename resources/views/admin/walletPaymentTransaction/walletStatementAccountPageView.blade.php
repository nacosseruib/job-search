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
                        <form method="POST" action="{{ Route::has('postAllWalletTransaction') ? route('postAllWalletTransaction') : '#' }}" accept-charset="UTF-8" class="form-horizontal" role="form">
                            @csrf
                            <div class="row ml-3">
                                <div class="col-md-12 h5 p-2 mb-2 text-center text-dark font-weight-bold">ALL WALLET TRANSACTIONS</div>

                                <div align="center" class="col-md-12 row h6 p-2 text-left text-dark font-weight-bold d-print-none">
                                    <div class="col-md-3">
                                        <label>Select Date From</label>
                                        <input type="date" class="form-control" name="dateFrom" value="{{ isset($from) ? $from : old('dateFrom') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Select Date To</label>
                                        <input type="date" class="form-control" name="dateTo" value="{{ isset($to) ? $to : old('dateTo') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Select User</label>
                                        <select class="form-control" name="userName">
                                            <option value="">Select User</option>
                                            @if(isset($getAllUser) && $getAllUser)
                                                @foreach($getAllUser as $key => $value)
                                                    <option value="{{$value->id}}" {{ isset($userName) && $userName == $value->id ? 'select' : old('userName') }}>{{ $value->first_name .' '. $value->last_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <br />
                                        <button type="submit" class="btn btn-outline-dark mt-2 pt-3"><span class="fas fa-search"></span> Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <table class="table tbale-responsive table-hover table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
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
                                            <td>
                                                <b>{{ $value->first_name .' '. $value->last_name }}</b> <br />
                                                {{ $value->location_city .', ', $value->country }} <br />
                                                {{ $value->company_name }}
                                            </td>
                                            <td>
                                                <b>{{ $value->email }}</b> <br />
                                                {{ $value->phone_number }}
                                            </td>
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
