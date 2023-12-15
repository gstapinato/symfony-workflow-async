# State machine with batch processing
Symfony app to show how to integrate a state machine with batch processing using messenger and workflow components.

### Steps

State machine diagram 
<img src="docs/workflow.png">


API documentation:
http://localhost/api/doc


## Setup
```
make build
make up
```

## Demo app
See [Demo App](docs/demo.md)


### Tests
```
bin/phpunit --testdox 
```

#### Reference
Workflow diagram genereated using:
```
php bin/console workflow:dump catalog --dump-format=mermaid 
```

Docker Integration using https://github.com/dunglas/symfony-docker

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

