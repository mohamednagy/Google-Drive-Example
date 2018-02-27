## Google Drive Exmaple

integration with google drive to list user's files using `google/apiclient` v3

**You have to create a google console project to be able to use the service chek [link](https://github.com/ivanvermeyen/laravel-google-drive-demo/blob/master/README/1-getting-your-dlient-id-and-secret.md) and follow the instructions**

copy the tokens json file that you will get from the google app interface to the project root and rename it to `gd_client_secret.json`
<br>
from the google app interface set the redirect uri to `http://localhost:8000` and the callback to `http://localhost:8000/callback`

## Install

clone the repo <br>
```
$ git clone https://github.com/mohamednagy/Google-Drive-Example.git
```

install the dependancies <br>
```
$ composer install
```

then
```
$cp .env.example .env
```

from the `.env` file set `DB_DATABASE`, `DB_USERNAME`  and `DB_PASSWORD`

after configuring the database connection, run the migrations
```
$ php artisan migrate
```


<br>
finally

```
$ php artisan serve
```

and now, you can access the application by `http://localhost:8000`
