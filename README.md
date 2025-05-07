
Getting Started:

1. Run
   ###### composer install

2. Copy the "env.example" file in the root directory and rename it to ".env"
   ###### composer run post-root-package-install
3. Open Docker 
   ###### ./vendor/bin/sail up -d

4. ###### ./vendor/bin/sail artisan key:generate --ansi
5. ###### ./vendor/bin/sail artisan migrate --seed
6. ###### ./vendor/bin/sail artisan queue:work
7. ###### ./vendor/bin/sail artisan reverb:start

