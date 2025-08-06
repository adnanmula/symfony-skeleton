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

## Docker Environment

The project uses Docker for local development:

- `make up`: Start containers
- `make stop`: Stop containers
- `make down`: Remove containers
- `make bash`: Access PHP container shell
- `make ps`: Check container status

## Database Migrations

Database migrations are managed with Phinx:

1. Create a new migration file in `db/migrations/`
2. Implement the `up()` and `down()` methods
3. Run migrations with `make migrations`

## Testing

```bash
make tests    # Run PHPUnit tests
make behat    # Run Behat tests
```
