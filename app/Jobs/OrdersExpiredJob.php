<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\UserTraining;
use App\Notifications\ExpirationNotification;
use App\Notifications\PreExpirationNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrdersExpiredJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $numberOfDays;
    public function __construct($numberOfDays=0)
    {
        $this->numberOfDays=$numberOfDays;
    }

    public function handle(): void
    {
        try{

            $expiredOffers = UserTraining::whereNotNull('expire_at')->whereDate('expire_at','=', today()->addDays($this->numberOfDays))->get();
            $offersGroupedByUser = $expiredOffers->groupBy('user_id');

            $allDetailedUserTrainings = [];

            foreach ($offersGroupedByUser as $key=>$userTrainings){
                $user = User::find($key);

                foreach ($userTrainings as $userTraining){
                    $userTraining->update(['expire_at'=>null,'active'=>false]);
                    $category = $userTraining->training->category->name;
                    $type=$userTraining->training->type->name;
                    $allDetailedUserTrainings[]=[
                        'category'=>$category,
                        'type'=>$type
                    ];
                }
                if($this->numberOfDays === 0){
                    $user->notify( new ExpirationNotification($allDetailedUserTrainings));
                }else{
                    $user->notify(new PreExpirationNotification($allDetailedUserTrainings));
                }

            }
        }catch(\Exception $e){
            \Log::error('Order expired job error: '.$e->getMessage());
        }
    }
}
