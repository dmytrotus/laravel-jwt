## Laravel + JWT token example app

Clone the project:

```bash
git clone https://github.com/dmytrotus/laravel-jwt.git
```

Run docker container:

```bash
docker compose up -d
```

Enter docker image:

```bash
docker exec -it lara-jwt-php bash
```

Then copy .env from .env.example to the project root and run the migration with seed:

```bash
php artisan migrate --seed
```

Generate secret key
```bash
php artisan jwt:secret
```

You will have project with database for 10 users.

## Important

The project is created only for testing purposes.
If you are cloning this repo, don't use it in real projects.

Middleware `FromSessionToBearerMiddleware` automatically passes token from session to each request.

## How it works

The app web interface has 2 routes

```bash
/auto-login-test-user // the route which log in automatically first user from the database
/secret // the route for showing some hidden data
```

The route `/secret` won't work without `/auto-login-test-user`. After logging in, the jwt token will be stored to the php session.
The route `/secret` has protected information but this information will be visible because middleware `FromSessionToBearerMiddleware` will automatically pass the token from session to each request.
The token is valid for 1 minute, so when you will update the page after 1 minute, you can see that the token which is returned from `/secret` route will change. 

You can try to "stole" your token, pass it as "Bearer" and enter the same route `/secret` via postman. After 1 minute the token will be expired and you will have the message. `"Token is expired"`

At the same time on the web interface the token will be re-issued and you can see the protected information as usual.

That's as example anout JWT tokens flow.