# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel 11 project based on the SuperDuper Filament Starter Kit, featuring Filament 3 admin panel with comprehensive CMS capabilities. It includes user management, blog system, banner management, contact forms, and extensive customization options.

## Development Commands

### Frontend Development
- `npm run dev` - Start Vite development server with hot reloading
- `npm run build` - Build assets for production
- `npm install` - Install frontend dependencies

### Backend Development
- `php artisan serve` - Start Laravel development server
- `php artisan migrate` - Run database migrations
- `php artisan migrate:fresh --seed` - Fresh migration with seeders
- `php artisan db:seed` - Run database seeders
- `php artisan key:generate` - Generate application key
- `php artisan storage:link` - Create symbolic link for storage

### Testing
- `php artisan test` or `./vendor/bin/phpunit` - Run PHPUnit tests
- Tests are located in `tests/Unit` and `tests/Feature`

### Filament-Specific Commands
- `php artisan shield:generate --all` - Generate Shield permissions and policies
- `php artisan db:seed --class=PermissionsSeeder` - Bind permissions to roles
- `php artisan icons:cache` - Cache icons for better performance
- `php artisan filament:upgrade` - Upgrade Filament components

### Translation
- `php artisan superduper:lang-translate [from] [to]` - Generate translations using Google Translate API
- Example: `php artisan superduper:lang-translate en fr es`
- Use `--json` flag for JSON translations

## Architecture

### Core Structure
- **Admin Panel**: Filament 3-based admin at `/admin`
- **Frontend**: Custom Livewire components with SuperDuper theme
- **Authentication**: Default email: `superadmin@starter-kit.com`, password: `superadmin`

### Key Directories
- `app/Filament/` - Filament admin resources, pages, and widgets
- `app/Livewire/` - Frontend Livewire components
- `app/Models/` - Eloquent models organized by feature (Blog, Banner, etc.)
- `app/Settings/` - Spatie Settings classes for site configuration
- `resources/views/livewire/` - Livewire Blade templates
- `resources/views/filament/` - Custom Filament views
- `public/superduper/` - Frontend theme assets

### Main Features
- **User Management**: Roles, permissions via Filament Shield
- **Blog System**: Posts, categories with SEO optimization
- **Banner Management**: Categories and content management
- **Contact System**: Contact forms with email notifications
- **Media Management**: Spatie Media Library integration
- **Settings**: Site configuration, SEO, social media, scripts
- **Menu Builder**: Dynamic navigation management

### Models & Relationships
- `User` - Has roles/permissions, user stamping
- `Blog\Post` - Belongs to category, has tags, media
- `Banner\Content` - Belongs to category, has scheduling
- `ContactUs` - Standalone contact submissions

### Key Packages
- **filament/filament** - Admin panel framework
- **livewire/livewire** - Frontend reactivity
- **spatie/laravel-media-library** - File management
- **spatie/laravel-settings** - Configuration management
- **bezhansalleh/filament-shield** - Role-based access control
- **jeffgreco13/filament-breezy** - Enhanced authentication

### Frontend Integration
- **Theme**: SuperDuper theme with custom styling
- **CSS**: TailwindCSS with custom color palette
- **JS**: Alpine.js for interactions
- **Build**: Vite for asset compilation

### Security Features
- Role-based access control throughout admin
- User stamping for audit trails
- Security headers middleware
- CSRF protection enabled

### Development Notes
- Uses PHP 8.2+ and Laravel 11
- Database migrations include comprehensive seeding
- Multilingual support with automated translation
- Optimized for performance with icon caching
- Comprehensive logging and error tracking