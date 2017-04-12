```git clone https://github.com/bmarcinkowski/cities.git```
```cd cities```

// dodac do /etc/hosts wpis:

// 127.0.0.1       cities.dev

```docker-compose up -d```

app/config/parameters.yml powinien wyglądać następująco:

```yml
parameters:
    database_host: db
    database_port: 5432
    database_name: cities
    database_user: docker
    database_password: docker
    mailer_transport: smtp
    mailer_host: 127.0.0.1
    mailer_user: null
    mailer_password: null
    secret: qwewwore89we7r89ew78ruio23klrwejklrjwe
```

```docker-compose run php php ./composer.phar install```

//tak, wiem powinno wygladac:

// docker-compose run php php ./composer.phar install 

//ale zapomnialem doinstalowac gita:) a jest już późno i mi się nie chce:)

```docker-compose run php php bin/console  doctrine:fixtures:load```

//(czasem dla gdańska leci jakis timeout, wiec trzeba sprobowac ponownie)

w przegladarce wpisujemy 
cities.dev:8080
//powinno działać :)

nie skupiałem sie na html i css ;)
