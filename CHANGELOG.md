# Changelog

All notable changes to the Multi-Vendor LMS project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added - 2026-02-04

#### Project Setup
- Laravel 12.49.0 installation and configuration
- MySQL database configuration (database: roufai)
- Environment setup for local MAMP development

#### Admin & Instructor Panels
- Filament 3.3.47 installation
- Admin Panel configuration at `/admin` (blue theme)
- Instructor Panel configuration at `/instructor` (amber theme)
- Separate panel providers for role-based access

#### Database Schema
- `users` table with role-based fields (student, instructor, admin)
  - Added: role, bio, payment_details columns
- `categories` table for course categorization
- `courses` table with pricing in BDT
  - Supports free (NULL price) and paid courses
  - Foreign keys to users (instructor) and categories
- `modules` table for course organization
- `lessons` table with video embedding support
  - Supports YouTube and Vimeo
  - Free preview capability
- `enrollments` table for student enrollments
  - Tracks last accessed lesson for resume functionality
- `enrollment_requests` table for manual payment verification
  - Status workflow: pending → approved/rejected
  - Stores transaction details (Bkash/Nagad)
- `reviews` table for course ratings and feedback
  - 1-5 star rating system
  - Optional text comments
- All tables properly indexed for performance
- Foreign key constraints with cascade deletes

#### Models & Relationships
- **User** model with role helper methods
  - Relationships: courses, enrollments, enrollmentRequests, reviews
  - Methods: isInstructor(), isAdmin(), isStudent()
- **Category** model
  - Relationships: hasMany courses
- **Course** model
  - Relationships: belongsTo user/instructor, belongsTo category, hasMany modules/lessons/enrollments/reviews
  - Accessor: getAverageRatingAttribute()
- **Module** model
  - Relationships: belongsTo course, hasMany lessons
  - Ordered by order_index
- **Lesson** model
  - Relationships: belongsTo module
  - Accessor: getEmbedUrlAttribute() for YouTube/Vimeo
  - Supports free preview flag
- **Enrollment** model
  - Relationships: belongsTo user/course/lastLesson
  - Tracks enrollment date and progress
- **EnrollmentRequest** model
  - Relationships: belongsTo user/course
  - Methods: isPending(), isApproved(), isRejected()
  - Stores payment details (transaction_id, payment_method, amount_paid)
- **Review** model
  - Relationships: belongsTo user/course
  - Rating constraint: 1-5 stars

#### Documentation
- DEVELOPER_LOG.md for daily progress tracking
- CHANGELOG.md for version history
- MINIMAL_LMS.md (original specification)

### Technical Details

#### Migration Order (Fixed)
1. 0001_01_01_000000_create_users_table
2. 2026_02_04_095831_create_categories_table
3. 2026_02_04_095834_create_courses_table
4. 2026_02_04_095835_create_modules_table
5. 2026_02_04_095836_create_lessons_table
6. 2026_02_04_095837_create_enrollments_table
7. 2026_02_04_095838_create_enrollment_requests_table
8. 2026_02_04_095839_create_reviews_table

#### Database Configuration
- Connection: MySQL
- Host: 127.0.0.1
- Port: 3306
- Database: roufai
- Username: root
- Password: root (MAMP default)

#### Dependencies Installed
- laravel/framework: v12.49.0
- filament/filament: v3.3.47
- filament/forms: v3.3.47
- filament/tables: v3.3.47
- filament/notifications: v3.3.47
- filament/support: v3.3.47
- livewire/livewire: v3.7.8

### Database Statistics
- Total Tables: 16 (8 LMS tables + 8 Laravel system tables)
- Total Models: 8
- Relationships: 25+ defined
- Indexes: 15+ for performance optimization

---

## [0.1.0] - TBD

### Planned Features
- Email notification system
- Filament Admin resources
- Filament Instructor resources
- Database seeders for initial data
- Student frontend (React + Inertia.js)
- Course browsing and enrollment
- Video player interface
- Review system frontend
- Payment verification workflow

