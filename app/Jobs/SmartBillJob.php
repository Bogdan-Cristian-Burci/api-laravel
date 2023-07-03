<?php

namespace App\Jobs;

use App\Models\Order;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SmartBillJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public Order $order;
    public function __construct($order)
    {
        $this->order=$order;
    }

    public function handle(): void
    {
//        $client = new Client(['base_uri'=>'https://ws.smartbill.ro']);
//
//        $authToken=base64_encode(config('smartbill.user').':'.config('smartbill.token'));
//
//        Log::info('auth token is'.$authToken);
//        try{
//            $client->post('/SBORO/api/invoice',[
//                'headers'=>[
//                    'Accept'=>'application/json',
//                    'Content-Type'=>'application/json',
//                    'Authorization'=>'Basic '.$authToken
//                ],
//                'json'=>$this->setSmartBillData($this->order)
//            ]);
//        }catch (\Exception $e){
//            Log::error('Guzzle smart bill post request error: '.$e->getMessage());
//        }
    }

    public function setSmartBillData($order): array
    {

//        $user = $order->user;
//
//        return [
//            'companyVatCode'=>config('smartbill.vat_code'),
//            'client'=>[
//                'name'=>$user->first_name.' '.$user->last_name,
//                'email'=>$user->email,
//                'country'=> "Romania",
//                'saveToDb'=>false
//            ],
//            'seriesName'=>config('smartbill.series'),
//            'dueDate'=> Carbon::now()->addDays(config('smartbill.due_date'))->toDateString(),
//            'sendEmail'=> true,
//            'email'=>[
//                'to'=>'bogdan.cristian.burci@gmail.com',
//                'cc'=>'bogdanburci81@gmail.com'
//            ],
//            'products'=>$this->getOrderTrainings($order)
//        ];
    }
    public function getOrderTrainings($order): array
    {
//
//        $userTrainings =  $order->userTrainings;
//
//        $trainings = [];
//        if($userTrainings->count() > 0 ){
//            foreach ($userTrainings as $userTraining){
//                $trainings[]=[
//                    'name'=>$userTraining->training->category->name . ' - '.$userTraining->training->type->name,
//                    'currency'=>config('smartbill.currency'),
//                    'quantity'=>1,
//                    'price'=>$userTraining->training->type->price * $userTraining->training->category->multiplier,
//                    'isTaxIncluded'=>config('smartbill.tax_included'),
//                    'taxPercentage'=>config('smartbill.tax_percentage'),
//                    'measuringUnitName'=>'buc',
//                    'isService'=>config('smartbill.is_service')
//                ];
//            }
//        }
//
//        return $trainings;

    }
}
