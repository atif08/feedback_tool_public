
# Feedback Tool

After clone the project you need to follow bellow given steps:

Add details of your database instance
Run php artisan migrate:fresh --seed on your project terminal.
Configure mailhog to test emails on your local and put this crend in your .env file

MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null


To test real time notification add this crend on your .env

PUSHER_APP_ID=1683727
PUSHER_APP_KEY=bca2806ac0610c5d43fd
PUSHER_APP_SECRET=d70b22fe0a8f6ad1df2f
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=ap2

Run php artisan optimize:clear


 

