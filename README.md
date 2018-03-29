# Event logger

This is a Symfony 4 app that logs events to a database using [Monolog](https://github.com/Seldaek/monolog).

Currently, the app logs events to a MySQL-type DB, though in principle the app could log to any backend data store. In future, we may explore supporting logging to Elasticsearch, MongoDB or other stores.
 
## Requirements
 
* **Composer**
* **PHP** >= 7.1.3
  
## Installation
 
1) Create a database for the app to use.

2) Copy `.env.dist` to `.env` and configure your database connection with the `DATABASE_URL` parameter.

3) Create the database tables from the included schema: 

```
$ php bin/console doctrine:migrations:migrate
```

## Usage

// TODO