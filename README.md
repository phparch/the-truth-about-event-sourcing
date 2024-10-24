# The Truth About Event Sourcing

This is a demo app that shows how to implement Event Sourcing in a simple way.

This is not meant to be a secure application, it's just a demo.

## How to setup
We need to migrate the database 
```bash
composer install
npm install
php artisan migrate:fresh --seed
```


## How to run
We need to run the server and vite server.

```bash
php artisan serve
npm run dev
```

## How to use
First we need to login, change the port to match your system.

[http://localhost:8001/login/1](http://localhost:8001/login/1)

After logging in, we are redirected to the verbs version of contact 2.

[http://localhost:8001/verbs/contact/2](http://localhost:8001/verbs/contact/2)

To see the event sauce version

[http://localhost:8001/eventsauce/contact/2](http://localhost:8001/eventsauce/contact/2)


To see the projection version

[http://localhost:8001/contact/2](http://localhost:8001/contact/2)

## Replaying events
To replay events, we need to run the command

```bash
php artisan app:clean-projections
php artisan verbs:replay
```

## Slides
[Available on Google Slides](https://docs.google.com/presentation/d/e/2PACX-1vTeII2r9H7ui1xg2i-GUox3-v0oNR1J6gu-fx8Q5N7eT1D-pdvzCWAqinCabNC_FvekhHozgbBy43qX/pub?start=false&loop=false&delayms=3000)
