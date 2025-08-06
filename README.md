# Project Guidelines

## Overview

This is a Symfony skeleton project that serves as a base for PHP applications.

## Project Setup

### Requirements

- Docker and Docker Compose

### Installation

1. Clone the repository
2. Run the following commands:

```bash
make build      # Build Docker containers
make up         # Start Docker containers
make install    # Install dependencies
make init       # Initialize the environment (creates db, executes migrations and fixtures)

#Other commands
make createdb   # Create the database
make migrations # Run migrations
make fixtures   # Load fixtures
```

### Code Quality Tools

The project uses several tools to ensure code quality:

- **GrumPHP**: Pre-commit hooks and code quality checks (`make grump`)
- **PHPStan**: Static analysis tool (`make stan`)
- **PHP_CodeSniffer**: Code style checker (`make cs`)
- **PHPUnit**: Unit testing framework (`make tests`)
- **Behat**: Behavior testing framework (`make behat`)
- **Infection**: Mutation testing framework (`make mutation`)

## Docker Environment

The project uses Docker for local development:

- `make up`: Start containers
- `make stop`: Stop containers
- `make down`: Remove containers
- `make bash`: Access PHP container shell
- `make ps`: Check container status

The Docker environment includes:
- PHP 8.4 with Xdebug for debugging and code coverage
- Nginx web server
- PostgreSQL database
- Adminer for database management

## Database Migrations

Database migrations are managed with Phinx:

1. Create a new migration file in `db/migrations/`
2. Implement the `up()` and `down()` methods
3. Run migrations with `make migrations`

## Testing

```bash
make tests    # Run PHPUnit tests
make behat    # Run Behat tests
make mutation # Run mutation tests with Infection
```

### Code Coverage

The project is configured to generate code coverage reports using Xdebug. PHPUnit will generate HTML code coverage reports in the `var/log/code-coverage` directory.

### Mutation Testing

Mutation testing helps ensure the quality of your test suite by making small changes (mutations) to your code and checking if your tests can detect these changes. The project uses Infection for mutation testing, which requires Xdebug for code coverage.

When you run `make mutation`, Infection will:
1. Run your test suite to ensure all tests pass
2. Generate mutations of your code
3. Run the test suite against each mutation
4. Report which mutations were detected (killed) and which were not (escaped)

A high mutation score indicates that your tests are effective at catching bugs.
