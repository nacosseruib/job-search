<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Cache;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Models\PaymentHistoryModel;
use App\Models\PaymentSetUpModel;
use App\Models\WalletModel;
use Paystack;


class PaymentController extends BaseParentController
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->getAllModel();
    }


    //Select : How To Pay - Wallet OR Paystack
    public function createHowToPay($paymentHistoryID = null)
    {
        $data = [];
        try{
            $data['walletDetails']  = WalletModel::where('userID', $this->getUserID())->first();
            $data['paymentDetails'] = PaymentHistoryModel::where('paymentID', $paymentHistoryID)->first();
            if(!$data['paymentDetails'])
            {
                return redirect()->route('dashboard')->with('warning', 'Sorry, we cannot find the details of this payment! Please try again.');
            }
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'PaymentController@createHowToPay', 'Error occured when selecting mode of payment.' );
        }
        return $this->checkViewBeforeRender('payment.selectHowToPayPageView')->with($data);
    }



    //PAY: View Payment Summary
    public function createPaymentSummary($paymentHistoryID = null, $paymentType = null)
    {
        $data = [];
        //try{
            $data['paymentType'] = $paymentType;
            $data['paymentHistoryID'] = $paymentHistoryID;
            $data['paymentSetup'] = PaymentSetUpModel::first();
            $data['paymentDetails'] = PaymentHistoryModel::where('paymentID', $paymentHistoryID)->first();
            if($data['paymentDetails'] || $paymentType <> null  || ($paymentType == 'wallet' || $paymentType <> 'gateway'))
            {
                return $this->checkViewBeforeRender('payment.paymentSummaryPage')->with($data);
            }else{
                return redirect()->route('dashboard')->with('warning', 'Sorry, we cannot find the details of this payment! Please try again.');
            }
        /* }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'PaymentController@createPaymentSummary', 'Error occured when loading payment summary.' );
        } */
        return redirect()->route('dashboard')->with('warning', 'Sorry, we cannot proceed with your payment! Please try again.');
    }



    //MAKE WALLET PAYMENT: Pay from wallet
    public function makePayment(Request $request)
    {
        $this->validate($request,
        [
                'payment_history'           => ['required', 'string', 'max:200'],
                'payment_type'              => ['required', 'string', 'max:200'],
        ]);
        $paymentHistoryID   = $request['payment_history'];
        $paymentType        = $request['payment_type'];
        $reference         = $request['reference'];

        $data = [];
        $success = 0;

        try{
            $userID = $this->getUserID();
            $data['paymentType'] = $paymentType;
            $data['paymentDetails'] = PaymentHistoryModel::where('paymentID', $paymentHistoryID)->first();
            PaymentHistoryModel::where('paymentID', $paymentHistoryID)->update(['payment_reference' => $reference]);
            if($data['paymentDetails'] || $paymentType <> null  || ($paymentType == 'wallet' || $paymentType <> 'gateway'))
            {
                if($paymentType == "wallet")
                {
                    //PAY FROM WALLET
                    if($this->walletBalance($userID, $paymentHistoryID) > $data['paymentDetails']->amount)
                    {
                        $success = $this->debitWallet($userID, $data['paymentDetails']->amount,  $data['paymentDetails']->transactionID,  $data['paymentDetails']->payment_description);
                    }else{
                        return redirect()->back()->with('warning', 'Sorry, you have insufficient funds to complete this transaction.');
                    }
                }elseif($paymentType == "gateway"){
                    //PAY FROM PAYSTACK
                    $success = $this->redirectToGateway();
                }else{
                    return redirect()->back()->with('warning', 'Sorry, we cannot proceed with this payment. Please try again.');
                }

                //Payment complete
                if($success)
                {
                    //Payment was successfull
                    return redirect()->route('paymentCompleted')->with('message', 'Completed! Your payment was successfull.');
                }else{
                    //payment was not successfull
                    return redirect()->route('paymentNotCompleted')->with('warning', 'Not Complete! Sorry, your payment was not successfull');
                }
            }else{
                return redirect()->back()->with('warning', 'Sorry, we cannot find the details of this payment! Please try again.');
            }
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'PaymentController@makePayment', 'Error occured when making payment from wallet of gateway.' );
        }
        return redirect()->back()->with('warning', 'Sorry, we cannot proceed with your payment! Please try again.');
    }


    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        try{
            return Paystack::getAuthorizationUrl()->redirectNow();
        }catch(\Throwable $errorThrown) {
            $this->storeTryCatchError($errorThrown, 'PaymentController@redirectToGateway', 'Error Redirecting to payment gatway website');
            return Redirect::back()->with('error', 'The payment token has expired. Please refresh the page and try again.');
        }
    }


}//end class
