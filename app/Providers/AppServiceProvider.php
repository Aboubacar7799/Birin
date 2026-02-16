<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Repository\ConversationRepository;
use App\Repository\NotificationRepository;
use Illuminate\Database\Events\QueryExecuted;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if($this->app->environment() === 'local'){
            DB::listen(function(QueryExecuted $query){
                file_put_contents('php://stdout',"\e[34m{$query->sql}\t\e[37m" . json_encode($query->bindings) . "\t\e[32m{$query->time}ms\e[0m\n]");
            });
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(ConversationRepository $conversationRepository, NotificationRepository $notificationRepository )
    {
        //pour compter le nombre de notification sur la navbar
        View::composer(['navbar/navbar','navbar/mobile'],function($view)
        use ($conversationRepository, $notificationRepository)
        {
            if (!auth()->check()){
                $view->with(['unreadMessagesCount' => 0, 'unreadNotificationsCount' => 0 ]);
                return;
            }
                $view->with(['unreadMessagesCount' => $conversationRepository->unreadCount(auth()->id()),
                    'unreadNotificationsCount' => $notificationRepository->unreadCount(auth()->id())
                ]);
                
                // $unreadNotifications = Notification::where('user_id', auth()->id())->where('is_read',false)->count();
                // $view->with('unreadNotifications',$unreadNotifications);
        });
    
    }
}
