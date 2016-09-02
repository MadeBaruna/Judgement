# Judgement
A Laravel Based Programming Contest Environment System   
Some parts still WIP

## Installation
Install requirements
```
sudo apt-get install php-common php-mbstring php-pdo php-imagick imagick supervisor
```

Install Judgement
```
git clone https://github.com/MadeBaruna/Judgement.git
cd Judgement
composer install
cp .env.example .env
php artisan key:generate
```

Open .env with your favorite text editor and change the configuration accordingly with your system configuration.
For the timezone use one that listed [here](http://php.net/manual/en/timezones.php). 
You can also change the ``WORKER_COUNT`` to increase or decrease the grader worker count that suit your system.

Then run
```
php artisan migrate --seed
```

Now we need to setup the grader worker
```
sudo nano /etc/supervisor/conf.d/judgement.conf
```

Put these to the file and save it
```
[program:judgement-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/artisan queue:work sqs --sleep=3 --tries=3
autostart=true
autorestart=true
user=forge
numprocs=10 (must be the same with WORKER_COUNT in .env)
redirect_stderr=true
stdout_logfile=/path/to/storage/logs/worker.log
```

Run the workers
```
sudo systemctl start supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start judgement-worker:*
```
## License

Judgement is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
