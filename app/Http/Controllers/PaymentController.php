<?php

namespace App\Http\Controllers;


use App\Http\Requests\PaymentRequest;
use App\Models\Order;
use App\Models\User;
use App\Notifications\AfterPurchaseNotification;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Netopia\Payment\Address;
use Netopia\Payment\Invoice;
use Netopia\Payment\Request\Card;
use Netopia\Payment\Request\PaymentAbstract;
use Illuminate\Http\Request;
class PaymentController extends ApiController
{

    /**
     * all payment requests will be sent to the NETOPIA Payments server
     * SANDBOX : http://sandboxsecure.mobilpay.ro
     * LIVE : https://secure.mobilpay.ro
     */
    public $paymentUrl;
    /**
     * NETOPIA Payments is working only with Certificate. Each NETOPIA partner (merchant) has a certificate.
     * From your Admin panel you can download the Certificate.
     * is located in Admin -> Conturi de comerciant -> Detalii -> Setari securitate
     * the var $x509FilePath is path of your certificate in your platform
     * i.e: /home/certificates/public.cer
     */
    public $x509FilePath;
    /**
     * Billing Address
     */
    public $billingAddress;
    /**
     * Shipping Address
     */
    public $shippingAddress;

    public $errorCode;
    public $errorType;
    public $errorMessage;
    public function getPaymentForm(PaymentRequest $request){

        $requiredServices = $request->input('services_array');

        $user = request()->user();

        $this->paymentUrl   = config('netopia.url');
        $this->x509FilePath = storage_path(config('netopia.public_certificate'));

        $returnPaymentUrl =  config('app.url').'api/payment/success';
        $confirmPaymentUrl =  config('app.url').'api/payment/return';

        try {

            $orderId = md5(uniqid(rand()));
            $paymentRequest = new Card();
            $paymentRequest->signature  = config('netopia.signature');//signature - generated by mobilpay.ro for every merchant account
            $paymentRequest->orderId    =  $orderId; // order_id should be unique for a merchant account
            $paymentRequest->confirmUrl = $confirmPaymentUrl;
            $paymentRequest->returnUrl  = $returnPaymentUrl;

            $newOrder = Order::create([
                'user_id' => $user->id,
                'amount'=> $request->input('total_amount'),
                'status'=> Order::STATUS['NEW'],
                'payment_id'=>$orderId
            ]);

            $newOrder->userTrainings()->attach($requiredServices);

            /*
             * Invoices info
             */
            $paymentRequest->invoice = new Invoice();
            $paymentRequest->invoice->currency  = config('netopia.currency');
            $paymentRequest->invoice->amount    = $request->input('total_amount');
            $paymentRequest->invoice->tokenId   = null;
            $paymentRequest->invoice->details   = config('netopia.invoice_description');

            /*
             * Billing Info
             */
            $this->billingAddress = new Address();
            $this->billingAddress->type         = "person"; //should be "person" / "company"
            $this->billingAddress->firstName    = $user->first_name;
            $this->billingAddress->lastName     = $user->last_name;
            $this->billingAddress->email        = $user->email;
            $this->billingAddress->mobilePhone  = $user->phone;
            $paymentRequest->invoice->setBillingAddress($this->billingAddress);

            /*
             * encrypting
             */
            $paymentRequest->encrypt($this->x509FilePath);


            /**
             * send the following data to NETOPIA Payments server
             * Method : POST
             * URL : $paymentUrl
             */
            $envKey = $paymentRequest->getEnvKey();
            $data   = $paymentRequest->getEncData();
            $url = config('netopia.url');

        }catch (Exception $e)
        {
            return  $this->errorResponse($e->getCode(), $e->getMessage());
        }

        return $this->successResponse(['env'=>$envKey, 'data'=>$data, 'url'=>$url],'Netopia data retrieved with success');
    }

    public function instantPaymentNotification(Request $request){

        $this->errorType = PaymentAbstract::CONFIRM_ERROR_TYPE_NONE;
        $this->errorCode = 0;
        $this->errorMessage = '';

        $this->paymentUrl = config('netopia.url');
        $this->x509FilePath = storage_path(config('netopia.private_key'));

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') == 0){

            if($request->input('env_key') && $request->input('data')){
                try {
                    $paymentRequestIpn = PaymentAbstract::factoryFromEncrypted($request->input('env_key'),$request->input('data'),$this->x509FilePath);
                    $rrn = $paymentRequestIpn->objPmNotify->rrn;


                    $order=Order::where('payment_id',$paymentRequestIpn->orderId)->first();

                    if ($paymentRequestIpn->objPmNotify->errorCode == 0) {

                        switch($paymentRequestIpn->objPmNotify->action){
                            case 'confirmed':
                                Log::info('Payment confirmed for order '.$order->id);
                                Log::info('rrn '.json_encode($rrn));
                                //update DB, SET status = "confirmed/captured"
                                if($order->status !== Order::STATUS['CONFIRMED']){
                                    $order->status=Order::STATUS['CONFIRMED'];
                                    $order->save();
                                    $orderTrainings = $order->userTrainings->pluck('id');
                                    $userBoughtTrainings = $order->user->assignTrainings->whereIn('id',$orderTrainings);
                                    $userBoughtTrainings->each(function($order){
                                        $order->update([
                                            'active'=>true,
                                            'expire_at'=>Carbon::now()->addDays(30)
                                        ]);
                                    });
                                    $user = User::find($order->user->id);

                                    $user->notify( new AfterPurchaseNotification());

                                    $this->sendDataToSmartBill($order);
                                }

                                $this->errorMessage = $paymentRequestIpn->objPmNotify->errorMessage;
                                break;
                            case 'confirmed_pending':
                                //update DB, SET status = "pending"
                                $order->status=Order::STATUS['CONFIRMED_PENDING'];
                                $this->errorMessage = $paymentRequestIpn->objPmNotify->errorMessage;
                                break;
                            case 'paid_pending':
                                //update DB, SET status = "pending"
                                $order->status=Order::STATUS['PAID_PENDING'];
                                $this->errorMessage = $paymentRequestIpn->objPmNotify->errorMessage;
                                break;
                            case 'paid':
                                //update DB, SET status = "open/preauthorized"
                                $order->status=Order::STATUS['PAID'];
                                $this->errorMessage = $paymentRequestIpn->objPmNotify->errorMessage;
                                break;
                            case 'canceled':
                                //update DB, SET status = "canceled"
                                $order->status=Order::STATUS['CANCELED'];
                                $this->errorMessage = $paymentRequestIpn->objPmNotify->errorMessage;
                                break;
                            case 'credit':
                                //update DB, SET status = "refunded"
                                $order->status=Order::STATUS['CREDIT'];
                                $this->errorMessage = $paymentRequestIpn->objPmNotify->errorMessage;
                                break;
                            default:
                                $errorType = PaymentAbstract::CONFIRM_ERROR_TYPE_PERMANENT;
                                $this->errorCode = PaymentAbstract::ERROR_CONFIRM_INVALID_ACTION;
                                $this->errorMessage = 'mobilpay_refference_action paramaters is invalid';
                        }
                    }else{
                        //update DB, SET status = "rejected"
                        $order->status=Order::STATUS['REJECTED'];
                        $this->errorMessage = $paymentRequestIpn->objPmNotify->errorMessage;
                    }
                    $order->save();
                }catch (\Exception $e) {
                    \Log::error('try failed '.$e->getCode().' message:'.$e->getMessage());
                    $this->errorType = PaymentAbstract::CONFIRM_ERROR_TYPE_TEMPORARY;
                    $this->errorCode = $e->getCode();
                    $this->errorMessage = $e->getMessage();
                } catch (GuzzleException $e) {
                    Log::error('Guzzle exception :'.$e->getMessage());
                }

            }else{
                $this->errorType = PaymentAbstract::CONFIRM_ERROR_TYPE_PERMANENT;
                $this->errorCode = PaymentAbstract::ERROR_CONFIRM_INVALID_POST_PARAMETERS;
                $this->errorMessage = 'mobilpay.ro posted invalid parameters';
            }

        } else {
            $this->errorType = PaymentAbstract::CONFIRM_ERROR_TYPE_PERMANENT;
            $this->errorCode = PaymentAbstract::ERROR_CONFIRM_INVALID_POST_METHOD;
            $this->errorMessage = 'invalid request metod for payment confirmation';
        }

        /**
         * Communicate with NETOPIA Payments server
         */

        header('Content-type: application/xml');
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        if($this->errorCode == 0)
        {
            echo "<crc>{$this->errorMessage}</crc>";
        }
        else
        {
            echo "<crc error_type=\"{$this->errorType}\" error_code=\"{$this->errorCode}\">{$this->errorMessage}</crc>";
        }
    }

    /**
     * @throws GuzzleException
     */
    public function sendDataToSmartBill($order){

        Log::info('Sending data to smart bill'.$order->id);
        $client = new Client(['base_uri'=>'https://ws.smartbill.ro']);

        $authToken=base64_encode(config('smartbill.user').':'.config('smartbill.token'));

        $smartBillObject = $this->setSmartBillData($order);

        try{
            $client->post('/SBORO/api/invoice',[
                'headers'=>[
                    'Accept'=>'application/json',
                    'Content-Type'=>'application/json',
                    'Authorization'=>'Basic '.$authToken
                ],
                'json'=>$smartBillObject
            ]);
        }catch (\Exception $e){
            Log::error('Guzzle smart bill post request error: '.$e->getMessage());
        }

    }

    public function setSmartBillData($order){

        $user = $order->user;

        return [
            'companyVatCode'=>config('smartbill.vat_code'),
            'client'=>[
                'name'=>$user->first_name.' '.$user->last_name,
                'email'=>$user->email,
                'city'=>json_decode($user->city,true)["nume"],
                'address'=>$user->street.' '.$user->street_aditional,
                'county'=>json_decode($user->county,true)["nume"],
                'country'=> "Romania",
                'saveToDb'=>false
            ],
            'seriesName'=>config('smartbill.series'),
            'dueDate'=> Carbon::now()->addDays(config('smartbill.due_date'))->toDateString(),
            'sendEmail'=> true,
            'email'=>[
                'to'=>$user->email,
                'cc'=>config('smartbill.email_cc')
            ],
            'products'=>$this->getOrderTrainings($order)
        ];
    }

    public function getOrderTrainings($order){

        $userTrainings =  $order->userTrainings;

        $trainings = [];
        if($userTrainings->count() > 0 ){
            foreach ($userTrainings as $userTraining){
                $trainings[]=[
                    'name'=>$userTraining->training->category->name . ' - '.$userTraining->training->type->name,
                    'currency'=>config('smartbill.currency'),
                    'quantity'=>1,
                    'price'=>$userTraining->training->type->price * $userTraining->training->category->multiplier,
                    'isTaxIncluded'=>config('smartbill.tax_included'),
                    'taxPercentage'=>config('smartbill.tax_percentage'),
                    'measuringUnitName'=>'buc',
                    'isService'=>config('smartbill.is_service')
                ];
            }
        }

        return $trainings;

    }

    public function paymentSuccess(){
        return view('netopia-exit');
    }
}
