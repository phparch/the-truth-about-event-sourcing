<?php

namespace App\Providers;

use App\EventSauce\Consumer\ContactConsumer;
use App\EventSauce\Consumer\ContactSearchConsumer;
use App\EventSauce\Contact;
use App\EventSauce\ContactRepository;
use App\EventSauce\MessageDecorator\HowDecorator;
use App\EventSauce\MessageDecorator\WhoDecorator;
use EventSauce\EventSourcing\DefaultHeadersDecorator;
use EventSauce\EventSourcing\EventSourcedAggregateRootRepository;
use EventSauce\EventSourcing\MessageDecorator;
use EventSauce\EventSourcing\MessageDecoratorChain;
use EventSauce\EventSourcing\MessageRepository;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use EventSauce\EventSourcing\SynchronousMessageDispatcher;
use EventSauce\IdEncoding\StringIdEncoder;
use EventSauce\MessageRepository\IlluminateMessageRepository\IlluminateMessageRepository;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class EventSauceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(MessageRepository::class, function (Application $app): IlluminateMessageRepository
        {
            return new IlluminateMessageRepository(
                DB::connection(),
                'contact_data_store',
                new ConstructingMessageSerializer(),
                aggregateRootIdEncoder: new StringIdEncoder(),
            );
        });

        $this->app->singleton(MessageDecorator::class, function (): MessageDecorator
        {
            return new MessageDecoratorChain(
                new DefaultHeadersDecorator(),
                new WhoDecorator(),
                new HowDecorator($this->app->get(Request::class)),
            );
        });

        $this->app->singleton(ContactRepository::class, function (Application $app): ContactRepository
        {
            $messageDispatcher = new SynchronousMessageDispatcher(
                new ContactConsumer(),
                new ContactSearchConsumer(),
            );

            $repository = new EventSourcedAggregateRootRepository(
                Contact::class,
                $this->app->get(MessageRepository::class),
                $messageDispatcher,
                $app->get(MessageDecorator::class),
            );

            return new ContactRepository(
                $repository,
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
