<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // contoh:
        // \App\Events\SomethingHappened::class => [
        //     \App\Listeners\DoSomething::class,
        // ],
    ];

    // Jika sebelumnya kamu punya properti $observers, hapus seluruhnya.
    // protected $observers = [
    //     \App\Models\OrderItem::class => [\App\Observers\OrderItemObserver::class],
    // ];

    public function boot(): void
    {
        //
    }
}
