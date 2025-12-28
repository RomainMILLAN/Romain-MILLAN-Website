# AGENTS.md - Repository Guidelines for Coding Agents

## Build & Test Commands
- **PHP Lint/Format**: `make ecs` (runs ECS coding standards with auto-fix)
- **PHP Static Analysis**: `docker compose exec php php vendor/bin/phpstan analyse`
- **Run Tests**: `make phpunit` (all tests) or `make phpunit FILTER=TestName` (single test)
- **Test Coverage**: `make phpunit COVERAGE=1`
- **Frontend Build**: `npm run build` (prod) or `npm run dev` (dev)
- **Frontend Watch**: `npm run watch`

## Code Style Guidelines
- **PHP**: Follow Symfony coding standards via ECS (PSR-12, Clean Code, Simplify sets)
- **TypeScript**: Strict mode enabled, ES6 target, ESNext modules
- **PHP Types**: Use `declare(strict_types=1)` in all PHP files
- **PHPStan**: Level 6 static analysis required
- **Naming**: PSR-4 autoloading with context namespaces (AppContext, FrontContext, PanelContext, etc.)
- **Error Handling**: Use Symfony exception handling, validate with Symfony Validator component
- **Imports**: Group use statements, no trailing commas in PHP arrays
- **Testing**: PHPUnit 9.5, place tests in `tests/` directory matching src structure

## Project Architecture
- Symfony 7.4 application with FrankenPHP
- Multi-context architecture (App, Front, Panel, Security, Signature)
- Doctrine ORM with migrations
- Webpack Encore for assets with TypeScript
- Docker-based development environment