## Todo app
Simple Laravel Vue application that will allow users to manage their tasks

## Setup

- update .env file with data from your database
- composer install
- npm install
- php artisan migrate (if you want to fill db with dummy data add --seed)
- php artisan passport:install
- add the following to your .env file :
            PASSPORT_LOGIN_ENDPOINT="(url to app)/oauth/token"
            PASSPORT_CLIENT_ID=2
            PASSPORT_CLIENT_SECRET=(get the secret key from oauth_clients from db)

