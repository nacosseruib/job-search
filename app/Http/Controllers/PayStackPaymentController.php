<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Cache;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Models\PaymentHistoryModel;
use Paystack;


class PayStackPaymentController extends BaseParentController
{
    public function __construct()
    {
        $this->getAllModel();
    }


    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $success = 0;
        $paymentCallBack = Paystack::getPaymentData();
        //Paystack::getAllCustomers();

        //dd($paymentCallBack);
        //VITAL - INSERT ALL DATA IN DB 1ST


        try{
            if($paymentCallBack)
            {
                if(PaymentHistoryModel::where('paymentID', $paymentCallBack->orderID)->where('payment_reference', $paymentCallBack->reference)->first())
                {
                    //success - 200
                    if($paymentCallBack->success)
                    {
                        $transactionID  = $paymentCallBack->orderID;
                        $amountPaid     = $paymentCallBack->amount;
                        $statusCode     = $paymentCallBack->status_code;
                        $paymentSuccess = $paymentCallBack->success;
                        $reference      = $paymentCallBack->reference;
                        $callbackData   = $paymentCallBack;

                        $paymentDetails = PaymentHistoryModel::where('transactionID', $transactionID)->where('status', 1)->first();
                        $userID         = ($paymentDetails ? $paymentDetails->userID : '');
                         //Credit
                         try{
                            $success1 = $this->creditWallet($userID, $amountPaid, $transactionID, 'Wallet was created successfully via paystack gatewate.');
                        }catch(\Throwable $e){$this->storeTryCatchError($e, 'PayStackPaymentController@creditWallet', 'Error occurred when crediting wallet after making payment via gateway.');}

                        if($paymentDetails)
                        {
                            //Debit
                            try{
                                $success2 = $this->debitWallet($userID = null, ($paymentDetails ? $paymentDetails->amount : 0), $transactionID, 'Your wallet was debited with '. $paymentDetails->amount);
                            }catch(\Throwable $e){$this->storeTryCatchError($e, 'PayStackPaymentController@debitWallet', 'Error occurred when debiting wallet after making payment via gateway.');}
                        }
                        //Log
                        try{
                            $success3 = $this->updatePaymentHistory($transactionID, $amountPaid, $statusCode, $paymentSuccess, $reference, $callbackData);
                        }catch(\Throwable $e){$this->storeTryCatchError($e, 'PayStackPaymentController@updatePaymentHistory', 'Error occurred when updating payment history.');}
                        //Payment was successfull
                        if($success1 && $success2 && $success3)
                        {
                            return redirect()->route('paymentCompleted')->with('message', 'Completed! Your payment was successfull.');
                        }
                    }elseif($paymentCallBack->success){
                        ###Code
                        return redirect()->route('paymentNotCompleted')->with('warning', 'Not Complete! Sorry, your payment was not successfull');
                    }
                }else{
                    return redirect()->route('paymentNotCompleted')->with('warning', 'Not Complete! Sorry, your payment was not successfull');
                }
            }
        }catch(\Throwable $e){
            $this->storeTryCatchError($e, 'PayStackPaymentController@updatePaymentHistory', 'Error occurred when getting data from payment gateway.');
        }
        return redirect()->route('paymentNotCompleted')->with('warning', 'Sorry, we are unable to complete your transaction. You can try again.');



        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want

        /**
         * This method gets all the customers that have performed transactions on your platform with Paystack
         * @returns array
         */
        // Paystack::getAllCustomers();

        /**
         * Alternatively, use the helper.
         */
        // paystack()->getAllCustomers();


        /**
         * This method gets all the plans that you have registered on Paystack
         * @returns array
         */
        // Paystack::getAllPlans();

        /**
         * Alternatively, use the helper.
         */
        //  paystack()->getAllPlans();


        /**
         * This method gets all the transactions that have occurred
         * @returns array
         */
        // Paystack::getAllTransactions();

        /**
         * Alternatively, use the helper.
         */
        // paystack()->getAllTransactions();

        /**
         * This method generates a unique super secure cryptographic hash token to use as transaction reference
         * @returns string
         */
        // Paystack::genTranxRef();

        /**
         * Alternatively, use the helper.
         */
        //  paystack()->genTranxRef();


        /**
        * This method creates a subaccount to be used for split payments
        * @return array
        */
        //  Paystack::createSubAccount();

        /**
         * Alternatively, use the helper.
         */
        //  paystack()->createSubAccount();


        /**
        * This method fetches the details of a subaccount
        * @return array
        */
        //  Paystack::fetchSubAccount();

        /**
         * Alternatively, use the helper.
         */
        //  paystack()->fetchSubAccount();


        /**
        * This method lists the subaccounts associated with your paystack account
        * @return array
        */
        //  Paystack::listSubAccounts();

        /**
         * Alternatively, use the helper.
         */
        //  paystack()->listSubAccounts();


        /**
        * This method Updates a subaccount to be used for split payments
        * @return array
        */
        // Paystack::updateSubAccount();

        /**
         * Alternatively, use the helper.
         */
        // paystack()->updateSubAccount();
    }



    //Payment complete
    public function createPaymentComplete()
    {
        try{

        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'PaymentController@createPaymentComplete', 'Error occured when loading payment complete.' );
        }
        return $this->checkViewBeforeRender('payment.paymentCompletedPageView');
    }


    //Payment Not complete
    public function createPaymentNotComplete()
    {
        try{

        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'PaymentController@createPaymentComplete', 'Error occured when loading payment complete.' );
        }
        return $this->checkViewBeforeRender('payment.paymentNotCompletedPageView');
    }






}//end class
