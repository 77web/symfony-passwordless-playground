# My personal playground for Symfony's passwordless login feature

https://symfony.com/doc/current/security/login_link.html

## usage

```shell
composer install
docker compose up -d
php bin/console doctrine:migrations:migrate
symfony server:start -d
```

- Visit https://127.0.0.1:8000/login
- Enter some email(do not have to be a real one)
- Visit https://127.0.0.1:53875 to check email
- Click login link on email
