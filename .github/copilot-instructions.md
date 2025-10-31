# Backtrace - Copilot Instructions

## Project Overview

Backtrace is a self-hosted developer journal platform focused on retrospectives, learnings, and code-driven reflections. It enables developers to document their experiences, learnings, and thoughts about their code and projects.

## Technology Stack

### Backend (api/)
- **Framework**: Laravel 12
- **PHP Version**: 8.2+
- **Key Packages**:
  - Laravel Sanctum (API authentication)
  - Laravel Telescope (debugging and monitoring)
  - Laravel Tinker (REPL)
  - Laravel Pint (code style)
- **Testing**: PHPUnit 11
- **Database**: SQLite (development/testing), configurable for production

### Frontend (frontend-simple/)
- **Build Tool**: Vite 6
- **CSS Framework**: TailwindCSS 4
- **JavaScript**: Vanilla JS

## Project Structure

```
/api                  # Laravel backend application
  /app
    /Http
      /Controllers    # PostController, CommentController, TopicController
    /Models          # Post, Comment, Topic, User
  /database
    /migrations      # Database schema
  /routes            # API and web routes
  /tests
    /Feature         # Integration tests
    /Unit           # Unit tests
  /config           # Laravel configuration
  
/frontend-simple    # Simple frontend interface
```

## Domain Model

The application manages a journal/blog system with:
- **Users**: Authors of posts and comments
- **Topics**: Categories for organizing posts
- **Posts**: Main content items (title, body, author, status, slug, views)
  - Uses soft deletes
  - Can have multiple comments
  - Belongs to a topic and user
- **Comments**: Responses to posts

## Development Workflow

### Backend Development (api/)

#### Setup
```bash
cd api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

#### Running the Application
```bash
# Development server with hot reload, queue, logs, and Vite
composer dev

# Individual services
php artisan serve        # Development server
php artisan queue:listen # Queue worker
php artisan pail         # Real-time logs
npm run dev             # Vite dev server
```

#### Testing
```bash
# Run all tests
php artisan test

# Or via composer
composer test

# PHPUnit configuration in phpunit.xml
```

#### Code Style
```bash
# Format code with Laravel Pint
./vendor/bin/pint
```

### Frontend Development (frontend-simple/)
```bash
cd frontend-simple
# Simple HTML/CSS/JS, no build process required for basic changes
```

## Code Style Guidelines

### PHP/Laravel
- Follow PSR-12 coding standards
- Use Laravel Pint for automatic formatting
- Follow Laravel best practices and conventions
- Use type hints for method parameters and return types
- Leverage Eloquent ORM for database operations
- Use resource controllers for RESTful operations
- Implement proper validation in form requests

### Database
- Use migrations for all schema changes
- Use factories for test data
- Implement soft deletes where appropriate (e.g., Posts model)
- Use proper foreign key relationships

### Testing
- Write feature tests for API endpoints
- Write unit tests for business logic
- Use in-memory SQLite for testing
- Follow existing test structure in tests/Feature and tests/Unit

## Common Commands

```bash
# Navigate to API directory
cd api

# Install/update dependencies
composer install

# Database operations
php artisan migrate
php artisan migrate:fresh --seed

# Testing
php artisan test
php artisan test --filter=PostTest

# Code formatting
./vendor/bin/pint

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Interactive console
php artisan tinker
```

## CI/CD

The project uses GitHub Actions for continuous integration:
- Workflow: `.github/workflows/laravel.yml`
- Runs on: Push to main, Pull Requests
- Tests: PHPUnit tests with SQLite database
- PHP Version: 8.0+ (configured in workflow)

## Important Notes

### Making Changes
- All backend code changes should be in the `api/` directory
- Database changes require migrations in `api/database/migrations/`
- Always run tests after making changes: `php artisan test`
- Format code with Pint before committing: `./vendor/bin/pint`
- The project uses soft deletes for Posts - use `restore()` and `forceDelete()` appropriately

### Security
- API routes use Laravel Sanctum for authentication
- Environment variables in `.env` for sensitive data
- Never commit `.env` files
- License: AGPL-3.0 (ensure compliance with licensing requirements)

### Models and Relationships
- Post belongs to User and Topic, has many Comments
- Comment belongs to Post and User
- Topic has many Posts
- User has many Posts and Comments
- Use eager loading to avoid N+1 queries: `Post::with('user', 'topic')->get()`

## Best Practices for This Repository

1. **Testing First**: Run existing tests before making changes to understand current behavior
2. **Minimal Changes**: Make surgical, focused changes rather than large refactors
3. **Follow Conventions**: Use Laravel conventions for naming (controllers, models, routes)
4. **Database Safety**: Always use migrations, never modify the database directly
5. **Validation**: Use Form Request classes for complex validation
6. **Documentation**: Update this file if architecture or workflows change significantly
7. **Dependencies**: Check for security vulnerabilities before adding new packages
