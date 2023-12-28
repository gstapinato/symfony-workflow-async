# State machine with batch processing on a Symfony App
Initial architecture to show how to integrate a state machine with batch processing using messenger and workflow components.


## Requirements
What things you need to install the software and how to install them : 
* Git
* Docker

## Setup
```
make build
make up
```

## Demo app
See [Demo App](docs/demo.md)

## To stop and remove container run
```
make down
```

### Running Tests
```
bin/phpunit --testdox 
```

### Code Quality

* php-cs-fixer
```
tools/php-cs-fixer/vendor/bin/php-cs-fixer fix tests
tools/php-cs-fixer/vendor/bin/php-cs-fixer fix tests
```


#### Tags
* PHP 8.3
* Symfony 6.4
* Symfony workflow
* Symfony messenger
* Docker
* PostgreSQL
* Redis
* OpenAPI
* PHPUnit
* Test Driven Development

