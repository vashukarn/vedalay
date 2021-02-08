<?php

namespace App\Providers;

use App\Events\DestinationReachedEvent;
use App\Events\NotifyReachedToCustomer;
use App\Events\NotifyRiderMovedToCustomer;
use App\Events\NotifyRidingAccepted;
use App\Events\RemoveRidingRequestNotification;
use App\Events\RidingCompleteEvent;
use App\Events\SendRidingRequestEvent;
use App\Listeners\DestinationReachedListener;
use App\Listeners\NotifyRiderMoving;
use App\Listeners\NotifyRiderReachedToCustomer;
use App\Listeners\RemoveRidingNotification;
use App\Listeners\RidingAcceptedToCustomer;
use App\Listeners\RidingCompleteListener;
use App\Listeners\SendRidingRequestToRider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SendRidingRequestEvent::class => [
            SendRidingRequestToRider::class
        ],
        NotifyRidingAccepted::class => [
            RidingAcceptedToCustomer::class
        ],
        NotifyRiderMovedToCustomer::class => [
            NotifyRiderMoving::class
        ],
        NotifyReachedToCustomer::class => [
            NotifyRiderReachedToCustomer::class
        ],
        DestinationReachedEvent::class => [
            DestinationReachedListener::class
        ],
        RidingCompleteEvent::class =>[
            RidingCompleteListener::class
        ],
        RemoveRidingRequestNotification::class => [
            RemoveRidingNotification::class 
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
