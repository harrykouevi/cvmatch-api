<?php

namespace App\Providers;

use App\Events\AiCleanTextEvent;
use App\Events\AiPerfomEvent;
use App\Listeners\AiCleanTextEventListener;
use App\Listeners\AiPerfomEventListener;
use App\Models\Resume;
use App\Repositories\AnalyseRepositoryEloquent;
use App\Repositories\CreditPlanRepositoryEloquent;
use App\Repositories\CreditRepositoryEloquent;
use App\Repositories\CreditTransactionRepositoryEloquent;
use App\Repositories\EventRepositoryEloquent;
use App\Repositories\Interfaces\AnalyseRepository;
use App\Repositories\Interfaces\CreditPlanRepository;
use App\Repositories\Interfaces\CreditRepository;
use App\Repositories\Interfaces\CreditTransactionRepository;
use App\Repositories\Interfaces\EventRepository;
use App\Repositories\Interfaces\MobileWaitRepository;
use App\Repositories\Interfaces\PaymentRepository;
use App\Repositories\Interfaces\PurchaseRepository;
use App\Repositories\Interfaces\ResumeRepository;
use App\Repositories\Interfaces\ReviewRepository;
use App\Repositories\Interfaces\UploadRepository;
use App\Repositories\Interfaces\UserRepository;
use App\Repositories\MobileWaitRepositoryEloquent;
use App\Repositories\PaymentRepositoryEloquent;
use App\Repositories\PurchaseRepositoryEloquent;
use App\Repositories\ResumeRepositoryEloquent;
use App\Repositories\ReviewRepositoryEloquent;
use App\Repositories\UploadRepositoryEloquent;
use App\Repositories\UserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind( UserRepository::class, UserRepositoryEloquent::class);
        $this->app->bind( PurchaseRepository::class, PurchaseRepositoryEloquent::class);
        $this->app->bind( ResumeRepository::class, ResumeRepositoryEloquent::class);
        $this->app->bind( AnalyseRepository::class, AnalyseRepositoryEloquent::class);
        $this->app->bind( EventRepository::class, EventRepositoryEloquent::class);
        $this->app->bind( ReviewRepository::class, ReviewRepositoryEloquent::class);
        $this->app->bind( PaymentRepository::class, PaymentRepositoryEloquent::class);
        $this->app->bind( CreditPlanRepository::class, CreditPlanRepositoryEloquent::class);
        $this->app->bind( CreditTransactionRepository::class, CreditTransactionRepositoryEloquent::class);
        $this->app->bind( MobileWaitRepository::class, MobileWaitRepositoryEloquent::class);
        $this->app->bind( CreditRepository::class, CreditRepositoryEloquent::class);
        $this->app->bind( UploadRepository::class, UploadRepositoryEloquent::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen( AiPerfomEvent::class,AiPerfomEventListener::class);
        Event::listen( AiCleanTextEvent::class,AiCleanTextEventListener::class);
    }
}
