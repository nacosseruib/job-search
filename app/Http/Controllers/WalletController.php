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
use App\Models\PaymentTransactionModel;
use Paystack;
use Carbon\Carbon;


class WalletController extends BaseParentController
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->getAllModel();
    }


    //Select : How To Pay - Wallet OR Paystack
    public function creatWallet()
    {
        $data = [];
        try{
            $data['walletDetails']  = WalletModel::where('userID', $this->getUserID())->first();

        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'WalletController@creatWallet', 'Error occured when creating wallet.' );
        }
        return $this->checkViewBeforeRender('wallet.walletPageView')->with($data);
    }

    //Store Wallet Funding
    public function storeWallet(Request $request)
    {
        $date = Carbon::now();
        $lastMonth =  $date->subMonth()->format('m');

        $this->validate($request,
        [
                'amount'  => ['required', 'numeric', 'max:999999999999999'],
        ]);
        $amount  = $request['amount'];
        $data = [];
        $success = 0;

        try{
            //user ID
            $userID = $this->getUserID();
            //delete all redundant less than a Month ddata.
            PaymentHistoryModel::where('userID', $userID)->where('is_hidden', 1)->where('created_at', '<', (date('Y-') . $lastMonth . date('-d')))->delete();
            //create new payment history
            $success = PaymentHistoryModel::create([
                'userID'            => $userID,
                'transactionID'     => $this->generateRandomAlphaNumeric(20),
                'amount'            => (str_replace(',', '', $amount) / 100),
                'payment_description' => 'Credit/fund wallet with '. $amount .'.',
                'created_at'        => date('Y-m-d'),
                'updated_at'        => date('Y-m-d'),
                'updated_at_time'   => date('Y-m-d h:i:s a'),
                'is_hidden'         => 1,
            ]);
            if($success)
            {
                return redirect()->route('getPaymentSummary', ['phID' =>$success->paymentID, 'pay'=>'gateway']);
            }
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'PaymentController@storeWallet', 'Error occured when making payment from wallet of gateway.' );
        }
        return redirect()->back()->with('warning', 'Sorry, we cannot proceed with your transaction! Please try again.');
    }

    //VIEW WALLET PAYMENT HISTORY
    public function viewPaymentHistory()
    {
        $data = [];
        try{
            $userID = $this->getUserID();
            $data['paymentTransaction'] = PaymentTransactionModel::where('userID', $userID)->where('status', 1)->orderBy('created_at', 'Desc')->paginate(500);
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'PaymentController@viewPaymentHistory', 'Error occured when viewing wallet payment transaction.' );
        }
        return $this->checkViewBeforeRender('wallet.walletPaymentHistoryPageView')->with($data);
    }


    //VIEW WALLET STATEMENT OF ACCOUNT
    public function viewWalletStatementAccount($from = null, $to = null)
    {
        $data = [];
        try{
            $userID = $this->getUserID();
            if ($from <> 0 && $to <> 0)
            {
                $data['paymentTransaction'] = PaymentTransactionModel::where('userID', $userID)->whereBetween('created_at', [$from, $to])->where('status', 1)->orderBy('created_at', 'Desc')->paginate(500);
            }else{
                $data['paymentTransaction'] = PaymentTransactionModel::where('userID', $userID)->where('status', 1)->orderBy('created_at', 'Desc')->paginate(500);
            }
        }catch(\Throwable $errorThrown){
            $this->storeTryCatchError($errorThrown, 'PaymentController@viewWalletStatementAccount', 'Error occured when viewing statement of account.' );
        }
        $data['from']   = $from;
        $data['to']     = $to;
        return $this->checkViewBeforeRender('wallet.walletStatementAccountPageView')->with($data);
    }

    //POST SEARCH STATEMENT OF ACCOUNT
    public function postWalletStatementAccount(Request $request)
    {
        $this->validate($request,
        [
                'dateFrom'   => ['date','nullable','max:50'], //'required', 'date',
                'dateTo'     => ['date','nullable','max:50'], //'required', 'date',
        ]);
        return redirect()->route('walletStatmentAccount', ['from'=>($request['dateFrom'] ? $request['dateFrom'] : 0), 'to'=>($request['dateTo'] ? $request['dateTo'] : 0)]);
    }





}//end class
