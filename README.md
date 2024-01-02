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
tools/codeQuality/vendor/bin/php-cs-fixer fix src
tools/codeQuality/vendor/bin/php-cs-fixer fix tests
```
* phpstan
```
tools/codeQuality/vendor/bin/phpstan analyse --memory-limit 1G -c phpstan.neon --error-format=table > qa/phpstan_result.txt

```

Or you can run all code quality tools together with
```
make codeQuality
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

