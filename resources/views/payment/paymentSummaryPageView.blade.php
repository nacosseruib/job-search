@if(isset($showPagePayment) && $showPagePayment == 1)


<section>
    <div class="container">
      <div class="">
        <div class="col-md-12 bg-light p-3">

                <div align="center" class="row">
                    <div class="col-md-6 offset-md-3">

                            <div class="alert alert-light">
                                <table class="table table-hover">
                                    <tr>
                                        <th colspan="2" class="bg-light">
                                            <div class="text-center h5 text-success h5"> <b>PAYMENT SUMMARY</b> </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td class="text-left h6">Payment Mode:</td>
                                        <td class="text-right h6">{{ isset($paymentType) ? ucfirst($paymentType) : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left h6">Payment Description:</td>
                                        <td class="text-right h6">{{ isset($paymentDetails) && $paymentDetails ? $paymentDetails->payment_description : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left h6">Transaction ID:</td>
                                        <td class="text-right h6">{{ isset($paymentDetails) && $paymentDetails ? $paymentDetails->transactionID : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left h6">Amount:</td>
                                        <td class="text-right h6">₦{{ isset($paymentDetails) && $paymentDetails ? number_format($paymentDetails->amount, 2) : 0.0 }} </td>
                                    </tr>
                                    <tr class="bg-light">
                                        <td class="text-left h6">TOTAL:</td>
                                        <td class="text-right h6">₦{{ isset($paymentDetails) && $paymentDetails ? number_format($paymentDetails->amount, 2) : 0.0 }} </td>
                                    </tr>
                                </table>
                                <hr >

                                <form method="POST" action="{{ Route::has('payNow') ? route('payNow') : '#' }}" accept-charset="UTF-8" class="form-horizontal" role="form">
                                @csrf
                                    <input type="hidden" name="payment_history" value="{{ isset($paymentDetails) && $paymentDetails ? $paymentDetails->paymentID : '' }}">
                                    @if(isset($paymentType) && $paymentType == 'gateway')
                                        <input type="hidden" name="payment_type" value="gateway">
                                        <img src="{{ asset('assets/images/bg/paystack.png') }}" class="img-responsive" />
                                    @elseif(isset($paymentType) && $paymentType == 'wallet')
                                        <input type="hidden" name="payment_type" value="wallet">
                                        <span class="fas fa-wallet fa-4x"></span>
                                    @endif

                                    <input type="hidden" name="email" value="{{ Auth::check() ? Auth::user()->email : (isset($paymentSetup) ? $paymentSetup->email : '') }}"> {{-- required --}}
                                    <input type="hidden" name="orderID" value="{{ isset($paymentDetails) && $paymentDetails ? $paymentDetails->transactionID : '' }}">
                                    <input type="hidden" name="amount" value="{{ isset($paymentDetails) && $paymentDetails ? ($paymentDetails->amount * 100) : 0 }}"> {{-- required in kobo --}}
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="currency" value="{{ isset($paymentSetup) ? $paymentSetup->currency : '' }}">
                                    <input type="hidden" name="metadata" value="{{ json_encode($array = ['key_name' => (isset($paymentDetails) && $paymentDetails ? $paymentDetails->paymentForID : ''),]) }}" > {{-- For other necessary things you want to add to your payload. it is optional though --}}
                                    <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> {{-- required --}}


                                    <button class="btn btn-success btn-lg btn-block h4" type="submit" value="Pay Now!">
                                        <i class="fa fa-money fa-lg"></i> Pay ₦{{ isset($paymentDetails) && $paymentDetails ? number_format($paymentDetails->amount, 2) : 0.0 }} Now!
                                    </button>
                                </form>

                                <div class="text-center mt-2 p-2">
                                    <a href="{{ Route::has('whereToMakePayement') ? Route('whereToMakePayement', ['phID'=>isset($paymentDetails) && $paymentDetails ? $paymentDetails->paymentID : null]) : 'javascript:;' }}" class="text-success">Back</a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>


@endif
