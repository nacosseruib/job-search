@extends('layouts.site')
@section("pageTitle", "Wallet")
@section("walletPageActive", "active")
@section('pageContent')

    @includeIf('share.homeTopMenu', ['data' => '' ])

    <section>
        <div class="container">
          <div class="">
            <div class="col-md-12 bg-light p-3">

                    <div align="center" class="row">
                        <div class="col-md-10 offset-md-1 row">

                            <div class="col-md-6 p-3" style="border: 2px solid #eee;">
                                    <div class="alert alert-light shadow-sm p-3 bg-white rounded">
                                        <a href="javascript:;" data-toggle="modal" data-backdrop="false" data-target="#fundWalletGetAmount">
                                            <div class="p-0 text-left text-success font-weight-bold">
                                                <span class="fas fa-check-circle"></span> Credit/Fund Your Wallet
                                            </div>
                                        </a>
                                    </div>
                                    <div class="alert alert-light shadow-sm p-3 bg-white rounded">
                                        <a href="{{ Route::has('walletTransaction') ? Route('walletTransaction') : 'javascript:;' }}" class="">
                                            <div class="p-0 text-left text-success font-weight-bold">
                                                <span class="fas fa-check-circle"></span> View Payment History
                                            </div>
                                        </a>
                                    </div>
                                    <div class="alert alert-light shadow-sm p-3 bg-white rounded">
                                        <a href="{{ Route::has('walletStatmentAccount') ? Route('walletStatmentAccount') : 'javascript:;' }}" class="">
                                            <div class="p-0 text-left text-success font-weight-bold">
                                                <span class="fas fa-check-circle"></span> View/Print Statement of account
                                            </div>
                                        </a>
                                    </div>
                                    <img src="{{ asset('assets/images/bg/paystack.png') }}" class="img-responsive" style="width:50%" />
                                    {{-- <div class="alert alert-light shadow-sm p-3 bg-white rounded">
                                        <a href="" class="">
                                            <div class="p-0 text-left text-success font-weight-bold">
                                                <span class="fas fa-check-circle"></span> Pay all outstanding/unpaid transactions
                                            </div>
                                        </a>
                                    </div>
                                    <div class="alert alert-light shadow-sm p-3 bg-white rounded">
                                        <a href="" class="">
                                            <div class="p-0 text-left text-success font-weight-bold">
                                                <span class="fas fa-check-circle"></span> Send us complain about your wallet
                                            </div>
                                        </a>
                                    </div> --}}
                                    <hr />
                                    <div><i>Making payment directly from your wallet is fast, secured and reliable.</i></div>
                                </div>
                                <div class="col-md-6 p-3" style="border: 2px solid #eee;">
                                    <div class="alert alert-light shadow-md p-3 bg-white rounded">
                                       <h5><b> My Wallet</b></h5>
                                       <hr />
                                       <span class="fas fa-wallet fa-4x text-success"></span>
                                       <br />
                                       <div class="p-2 m-2 bg-success rounded">
                                           <h4 class="text-white">
                                                Wallet Balance: <br />
                                                <div class="p-2">{{ isset($walletDetails) && $walletDetails ? number_format($walletDetails->balance_amount, 2) : 0 }} NGN</div>
                                            </h4>
                                            <div class="p-1 text-white">
                                                <span class="fa fa-lock fa-2x text-warning"></span>
                                                <br />
                                                <em>Fast, Secured & Reliable</em>
                                            </div>
                                       </div>
                                        <hr />
                                        <div> Last Updated: {{ isset($walletDetails) ? date('d-m-Y h:i a', strtotime($walletDetails->updated_at_time)) : '-' }}</div>
                                    </div>
                                </div>

                        </div>
                    </div>
            </div>
          </div>
        </div>
      </section>

      {{-- View Fund Wallet  --}}
      <div style="z-index: 99999" class="modal fade text-left d-print-none" id="fundWalletGetAmount" tabindex="-1" role="dialog" aria-labelledby="fundWalletGetAmount" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                <h6 class="modal-title text-dark"><i class="fa fa-money"></i> Fund Wallet</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">

                    <form method="post" action="{{ (Route::has('postFundWallet') ? Route('postFundWallet') : '#') }}" enctype="multipart/form-data">
                        @csrf
                           <div>
                               <div class="form-row">
                                   <div class="form-group col-md-12">
                                       <label for="amount"> Enter Amount (NGN)</label>
                                       <input type="number" id="formatAmountOnKeyPress" name="amount" value="{{old('amount')}}" required class="form-control @error('amount') is-invalid @enderror">
                                       @error('amount')
                                           <span class="invalid-feedback" role="alert">
                                               <strong>{{ $message }}</strong>
                                           </span>
                                       @enderror
                                   </div>
                                   <div class="form-group col-md-12">
                                        <div align="center" class="col-md-12 m-2">
                                            <button type="submit" class="btn btn-primary d-block">
                                                Continue
                                            </button>
                                        </div>
                                    </div>
                               </div>
                           </div>
                       </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-success btn-sm" data-dismiss="modal"> Close </button>
                </div>
            </div>
        </div>
    </div>
    {{--  View Fund Wallet --}}

@endsection

{{-- Style --}}
@section('style')

@endsection

{{-- Script --}}
@section('script')
<script>
    //Number Format
    $(document).ready(function () {
        $("#formatAmountOnKeyPressNOT").on('keyup', function(evt){
            if (evt.which != 110 ){//not a fullstop
                var n = parseFloat($(this).val().replace(/\,/g,''),10);
                $(this).val(function (index, value) {
                return  value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    });
                $(this).val(n.toLocaleString());
            }
        });
    });
  </script>
@endsection
