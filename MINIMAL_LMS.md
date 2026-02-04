# Multi-Vendor LMS – Technical Specification (Minimal MVP)

**Version:** 3.1 (Laravel + Inertia.js + React)
**Last Updated:** February 2, 2025
**Status:** Ready for Development

---

## 1. System Overview

**Platform Type:** Multi-vendor Learning Management System (Course Marketplace)

**Core Business Model:**
- Instructors create video courses (FREE or PAID)
- Students enroll in courses
- If paid: Manual payment verification
  - Student pays to instructor's Bkash/Nagad account
  - Student submits transaction ID
  - Instructor verifies and approves enrollment
  - Student gets access
- 100% goes to instructor 

**Minimal MVP Scope:**
- Video courses (YouTube/Vimeo embedding only)
- Course categories - dynamic
- Student enrollment - FREE, PREMIUM (manual payment verification)
- Instructor dashboard (manage courses + approve enrollment requests)
- Admin panel (platform management)

**Tech Stack:**
- **Backend:** Laravel 11 (PHP 8.2+)
- **Admin/Instructor UI:** Filament 3.x (auto-generated admin panels)
- **Student UI:** React.js + Inertia.js + Tailwind CSS (existing frontend)
- **Database:** MySQL 8+ or PostgreSQL 14+
- **Authentication:** Laravel Sessions (via Inertia.js)
- **File Storage:** Local 
- **Payment:** Manual verification (Bkash/Nagad)

**Architecture:**
```
┌─────────────────┐    ┌──────────────────┐    ┌─────────────────┐
│  Filament Admin │    │  React Pages     │    │   Laravel       │
│  /admin         │    │  (Rendered via   │◄──►│   Controllers   │
│  /instructor    │    │   Inertia.js)    │    │   + Routes      │
└─────────────────┘    └──────────────────┘    └─────────────────┘
     (Admin/              (Student              (Database,
     Instructor)          Facing)               Auth, Payments)
```

---

## 1.1 Quick Start Guide

**Prerequisites:**
- PHP 8.2+ installed
- Composer installed
- Node.js 18+ & npm installed
- MySQL or PostgreSQL
- Your existing frontend with Tailwind CSS 

## 2. User Roles & Permissions

### 2.1 Student
**Registration:**
- Email, password, name
- No email verification (MVP)

**Capabilities:**
- Browse all published courses
- View course details (title, description, thumbnail, instructor)
- Enroll in courses (FREE)
- Access enrolled courses
- Watch video lessons
- Leave star rating (1-5) + optional review
- View "My Courses" dashboard

**Access Rules:**
- Can only watch enrolled courses
- Can only review enrolled courses

### 2.2 Instructor
**Registration:**
- Separate registration from students
- Email, password, name, bio (optional)

**Capabilities:**
- Create/edit/delete own courses
- Add modules to courses
- Add lessons to modules
- Upload course thumbnail
- Mark lessons as "free preview"
- Set payment details (Bkash/Nagad number)
- View enrolled students count
- **Approve/reject enrollment requests** (for paid courses)

**Access Rules:**
- Can only manage own courses
- Cannot view other instructors' data
- No access to platform analytics

### 2.3 Admin
**Capabilities:**
- Full access to all data
- Manage all users (students, instructors)
- Manage all courses
- Process instructor payouts
- View platform analytics
- Moderate reviews

**Access:**
- Via Filament admin panel at `/admin`

---

## 3. Core Modules

### Module 1: Authentication & Authorization
**Purpose:** User registration, login, session management

**Features:**
- Student registration
- Instructor registration
- Login (email/password)
- Password reset (email link)
- Role-based access control
- Session management via Laravel

**Technology:**
- Laravel built-in authentication
- Inertia.js for seamless auth (no page reloads)
- Session-based auth (no API tokens needed)

---

### Module 2: Course Management (Instructor)
**Purpose:** Instructors create and manage courses

**Features:**
- Create course (title, description, price, category, thumbnail)
- Add/edit/delete modules
- Add/edit/delete lessons
- Upload course thumbnail
- Organize modules and lessons (drag-and-drop ordering)
- Mark lessons as free preview
- Publish/unpublish courses
- View course statistics (enrollments, revenue)

**Technology:**
- Filament Resource: CourseResource
- Filament RelationManager: Modules, Lessons
- File upload to local storage 

**Instructor Dashboard Pages:**
1. Course List (all instructor's courses)
2. Course Create/Edit Form
3. Module & Lesson Management (nested)
4. Revenue Stats (total earnings, available balance)

---

### Module 3: Course Catalog (Student)
**Purpose:** Students discover and browse courses

**Features:**
- Course listing page (grid view)
- Course detail page (full info + lessons preview)
- Search by course title
- Filter by category
- Filter by price (All/Free/Paid)
- Display average rating
- Show instructor name
- Free preview lessons (watch without enrollment)

**Technology:**
- React components (rendered via Inertia.js)
- Laravel controllers
- Your existing Tailwind CSS design

**Student Pages:**
1. Home/Course Catalog
2. Course Detail Page
3. Lesson Preview (for free preview lessons)

---

### Module 4: Enrollment & Learning
**Purpose:** Students request enrollment and access courses

**Features:**
- View course payment details (instructor's Bkash/Nagad number)
- Submit enrollment request with transaction ID
- Track request status (pending/approved/rejected)
- "My Courses" dashboard
- Video player (YouTube/Vimeo embed)
- Module/Lesson sidebar navigation
- Resume learning (save last watched lesson)
- Mark lesson as complete
- Track progress

**Technology:**
- React components
- Laravel routes
- Video embed (iframe)

**Enrollment Flow:**
1. Student clicks "Enroll" on paid course
2. See payment instructions (instructor's Bkash/Nagad number)
3. Pay to instructor's number
4. Submit transaction ID and payment details
5. Request marked as "pending"
6. Instructor verifies payment
7. Instructor approves → enrollment created
8. Instructor rejects → student can resubmit

**Student Pages:**
1. Payment Request Page (shows instructor details, form to submit transaction)
2. My Requests Dashboard (track all enrollment requests)
3. My Courses Dashboard (approved enrollments)
4. Course Learning Interface (video player)

---

### Module 5: Reviews & Ratings
**Purpose:** Students rate and review courses

**Features:**
- Star rating (1-5 stars, required)
- Text review (optional, min 10 characters)
- Only enrolled students can review
- One review per course per student
- Display average rating
- Show reviews on course page

**Technology:**
- React form component
- API endpoints for CRUD

**Validation Rules:**
- User must be enrolled in course
- User hasn't reviewed before
- Rating: 1-5 required
- Comment: 10+ characters if provided

---

### Module 6: Admin Panel
**Purpose:** Platform administration

**Features:**
- User management (students, instructors, admins)
- Course management (view all courses)
- Review moderation (approve/delete)
- Payout processing
- Platform analytics

**Technology:**
- Filament Admin Panel at `/admin`
- Admin-only access

**Admin Pages:**
1. User Management (CRUD)
2. Course Management (view all)
3. Review Moderation
4. Payout Processing
5. Analytics Dashboard

---

## 4. Database Schema

### 4.1 Tables Overview

**Total Tables:** 8 core tables

1. **users** - All user accounts (students, instructors, admins)
2. **categories** - Course categories (10 predefined)
3. **courses** - Course information
4. **modules** - Course sections (contains lessons)
5. **lessons** - Individual video lessons
6. **enrollments** - Student course enrollments (approved)
7. **enrollment_requests** - Pending enrollment requests (payment verification)
8. **reviews** - Course ratings and reviews

---

### 4.2 Table Schemas

#### Table: users
**Purpose:** Store all user types (students, instructors, admins)

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO INCREMENT | User ID |
| name | VARCHAR(255) | NOT NULL | Full name |
| email | VARCHAR(255) | UNIQUE, NOT NULL | Email address |
| password | VARCHAR(255) | NOT NULL | Hashed password |
| role | ENUM | NOT NULL, DEFAULT 'student' | Values: 'student', 'instructor', 'admin' |
| bio | TEXT | NULLABLE | Instructor bio (optional) |
| payment_details | TEXT | NULLABLE | Instructor's Bkash/Nagad number (for paid courses) |
| email_verified_at | TIMESTAMP | NULLABLE | Email verification timestamp |
| remember_token | VARCHAR(100) | NULLABLE | "Remember me" token |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Account creation date |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Last update date |

**Indexes:**
- Index on `email` (for login queries)
- Index on `role` (for filtering by user type)

**Relationships:**
- Has many: courses (if instructor)
- Has many: enrollments (if student)
- Has many: reviews

---

#### Table: categories
**Purpose:** Predefined course categories

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO INCREMENT | Category ID |
| name | VARCHAR(100) | UNIQUE, NOT NULL | Category name |
| slug | VARCHAR(100) | UNIQUE, NOT NULL | URL-friendly name |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Creation date |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Last update date |

**Predefined Categories (Seeded Data):**
1. Web Development
2. Data Science
3. Design
4. Business
5. Marketing
6. Photography
7. Music
8. Health & Fitness
9. Personal Development
10. IT & Software

**Relationships:**
- Has many: courses

---

#### Table: courses
**Purpose:** Course information and metadata

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO INCREMENT | Course ID |
| instructor_id | BIGINT | FOREIGN KEY → users.id, NOT NULL | Course creator |
| category_id | BIGINT | FOREIGN KEY → categories.id, NOT NULL | Course category |
| title | VARCHAR(255) | NOT NULL | Course title |
| description | TEXT | NOT NULL | Course description |
| price | INT | UNSIGNED | Price in cents (NULL = free, $49.99 = 4999) |
| thumbnail_url | VARCHAR(500) | NULLABLE | Thumbnail image URL |
| is_published | BOOLEAN | DEFAULT false | Published status |
| slug | VARCHAR(255) | UNIQUE, NOT NULL | URL-friendly title |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Creation date |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Last update date |

**Indexes:**
- Index on `instructor_id` (instructor's courses)
- Index on `category_id` (category filtering)
- Index on `is_published` (published courses query)
- Index on `slug` (URL lookup)

**Relationships:**
- Belongs to: user (instructor)
- Belongs to: category
- Has many: modules
- Has many: enrollments
- Has many: reviews
- Has many: transactions

---

#### Table: modules
**Purpose:** Organize lessons into sections

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO INCREMENT | Module ID |
| course_id | BIGINT | FOREIGN KEY → courses.id, NOT NULL | Parent course |
| title | VARCHAR(255) | NOT NULL | Module title |
| order_index | INT | DEFAULT 0 | Display order |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Creation date |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Last update date |

**Indexes:**
- Index on `course_id` (course modules)
- Index on `order_index` (sorting)

**Relationships:**
- Belongs to: course
- Has many: lessons

---

#### Table: lessons
**Purpose:** Individual video lessons

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO INCREMENT | Lesson ID |
| module_id | BIGINT | FOREIGN KEY → modules.id, NOT NULL | Parent module |
| title | VARCHAR(255) | NOT NULL | Lesson title |
| video_provider | ENUM | NOT NULL | 'youtube' or 'vimeo' |
| video_id | VARCHAR(100) | NOT NULL | YouTube/Vimeo video ID only |
| is_free_preview | BOOLEAN | DEFAULT false | Free preview flag |
| order_index | INT | DEFAULT 0 | Display order |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Creation date |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Last update date |

**Indexes:**
- Index on `module_id` (module lessons)
- Index on `order_index` (sorting)

**Video Embedding:**
- YouTube: `https://www.youtube.com/embed/{video_id}`
- Vimeo: `https://player.vimeo.com/video/{video_id}`

**Relationships:**
- Belongs to: module
- Has many: enrollments (via last_lesson_id)

---

#### Table: enrollments
**Purpose:** Student course enrollments

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO INCREMENT | Enrollment ID |
| user_id | BIGINT | FOREIGN KEY → users.id, NOT NULL | Student |
| course_id | BIGINT | FOREIGN KEY → courses.id, NOT NULL | Enrolled course |
| last_lesson_id | BIGINT | FOREIGN KEY → lessons.id, NULLABLE | Last accessed lesson |
| enrolled_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Enrollment date |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Last update date |

**Indexes:**
- Index on `user_id` (student enrollments)
- Index on `course_id` (course enrollments)
- UNIQUE on `(user_id, course_id)` - one enrollment per student per course

**Relationships:**
- Belongs to: user (student)
- Belongs to: course
- Belongs to: lesson (last accessed)

---

#### Table: reviews
**Purpose:** Course ratings and reviews

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO INCREMENT | Review ID |
| user_id | BIGINT | FOREIGN KEY → users.id, NOT NULL | Reviewer |
| course_id | BIGINT | FOREIGN KEY → courses.id, NOT NULL | Reviewed course |
| rating | TINYINT | UNSIGNED, NOT NULL, 1-5 | Star rating |
| comment | TEXT | NULLABLE | Review text (optional) |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Review date |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Last update date |

**Indexes:**
- Index on `course_id` (course reviews)
- UNIQUE on `(user_id, course_id)` - one review per student per course

**Relationships:**
- Belongs to: user (student)
- Belongs to: course

---

#### Table: enrollment_requests
**Purpose:** Pending enrollment requests awaiting payment verification

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT | PRIMARY KEY, AUTO INCREMENT | Request ID |
| user_id | BIGINT | FOREIGN KEY → users.id, NOT NULL | Student |
| course_id | BIGINT | FOREIGN KEY → courses.id, NOT NULL | Course to enroll |
| transaction_id | VARCHAR(255) | NOT NULL | Student's transaction number |
| payment_method | VARCHAR(50) | NOT NULL | 'bkash', 'nagad', or other |
| payment_number | VARCHAR(50) | NOT NULL | Number sent to |
| amount_paid | INT | UNSIGNED | Amount paid in cents |
| status | ENUM | DEFAULT 'pending' | 'pending', 'approved', 'rejected' |
| rejection_reason | TEXT | NULLABLE | Reason if rejected |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Request date |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Last update date |

**Indexes:**
- Index on `user_id` (student requests)
- Index on `course_id` (course requests)
- Index on `status` (filter pending requests)
- Index on `instructor_id` (via course_id)

**Relationships:**
- Belongs to: user (student)
- Belongs to: course
- When approved: Creates enrollment record

**Workflow:**
1. Student submits enrollment request with transaction ID
2. Instructor sees pending requests in dashboard
3. Instructor verifies payment (checks Bkash/Nagad account)
4. Instructor approves → enrollment created, request deleted
5. Instructor rejects → rejection_reason added, student notified

---

### 4.3 Entity Relationships

```
users (instructor)
  ├─→ courses (hasMany)
  │     ├─→ modules (hasMany)
  │     │     └─→ lessons (hasMany)
  │     ├─→ enrollments (hasMany)
  │     ├─→ enrollment_requests (hasMany)
  │     └─→ reviews (hasMany)

users (student)
  ├─→ enrollments (hasMany)
  ├─→ enrollment_requests (hasMany)
  └─→ reviews (hasMany)

categories
  └─→ courses (hasMany)
```

---

## 5. Routes & Controllers (Inertia.js)

**Note:** These are Laravel routes handled by controllers, which return Inertia.js responses (React components). No separate API needed.

### 5.1 Authentication Routes

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/auth/register` | Student registration | No |
| POST | `/auth/register/instructor` | Instructor registration | No |
| POST | `/auth/login` | User login | No |
| POST | `/auth/logout` | User logout | Yes |
| POST | `/auth/forgot-password` | Request password reset | No |
| POST | `/auth/reset-password` | Reset password | No |
| GET | `/auth/user` | Get current user | Yes |

---

### 5.2 Course Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/courses` | List all published courses | No |
| GET | `/courses/{id}` | Get course details | No |
| GET | `/courses/{id}/modules` | Get course modules | No |
| GET | `/courses/{id}/lessons` | Get all course lessons | No |
| GET | `/courses/{id}/reviews` | Get course reviews | No |
| POST | `/courses` | Create new course | Instructor |
| PUT | `/courses/{id}` | Update course | Owner only |
| DELETE | `/courses/{id}` | Delete course | Owner only |
| POST | `/courses/{id}/publish` | Publish course | Owner only |

**Query Parameters (GET /courses):**
- `search` - Search by title
- `category` - Filter by category ID
- `price` - Filter: 'all', 'free', 'paid'
- `sort` - Sort: 'newest', 'oldest', 'price_low', 'price_high'

---

### 5.3 Module & Lesson Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/courses/{courseId}/modules` | List course modules | No |
| POST | `/courses/{courseId}/modules` | Create module | Owner only |
| PUT | `/modules/{id}` | Update module | Owner only |
| DELETE | `/modules/{id}` | Delete module | Owner only |
| GET | `/modules/{moduleId}/lessons` | List module lessons | No |
| POST | `/modules/{moduleId}/lessons` | Create lesson | Owner only |
| PUT | `/lessons/{id}` | Update lesson | Owner only |
| DELETE | `/lessons/{id}` | Delete lesson | Owner only |
| POST | `/lessons/{id}/reorder` | Reorder lessons | Owner only |

---

### 5.4 Enrollment Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/enrollments` | Get user's enrollments | Student |
| GET | `/enrollments/{courseId}` | Check enrollment status | Student |
| GET | `/enrollment-requests` | Get user's enrollment requests | Student |
| POST | `/enrollment-requests` | Submit enrollment request | Student |
| POST | `/enrollments/{id}/progress` | Update last lesson | Student |
| GET | `/enrollments/{id}/progress` | Get learning progress | Student |

---

### 5.5 Instructor Approval Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/instructor/enrollment-requests` | Get pending requests for my courses | Instructor |
| GET | `/enrollment-requests/{id}` | Get request details | Instructor |
| PUT | `/enrollment-requests/{id}/approve` | Approve enrollment request | Instructor |
| PUT | `/enrollment-requests/{id}/reject` | Reject enrollment request | Instructor |

---

### 5.6 Review Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/courses/{courseId}/reviews` | Get course reviews | No |
| POST | `/courses/{courseId}/reviews` | Create review | Enrolled only |
| PUT | `/reviews/{id}` | Update review | Owner only |
| DELETE | `/reviews/{id}` | Delete review | Owner or Admin |

---

### 5.7 User Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/users/{id}` | Get user profile | No |
| PUT | `/users/{id}` | Update user profile | Owner only |
| GET | `/users/{id}/courses` | Get user's courses (instructor) | Instructor |

---

### 5.8 Analytics Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/instructor/stats` | Get instructor statistics (course count, enrollments) | Instructor |
| GET | `/admin/analytics` | Get platform analytics | Admin |

---

## 6. Filament Resources

### 6.1 Admin Panel Resources
**URL:** `/admin`

**Resources:**
1. **UserResource** - Manage all users
   - List, create, edit, delete users
   - Filter by role
   - View user details

2. **CourseResource** (Read-only) - View all courses
   - List all courses
   - View course details
   - Unpublish courses if needed

3. **ReviewResource** - Moderate reviews
   - List all reviews
   - Delete inappropriate reviews

4. **AnalyticsDashboard** - Platform stats
   - Total users
   - Total courses
   - Total enrollments

---

### 6.2 Instructor Panel Resources
**URL:** `/instructor`

**Resources:**
1. **CourseResource** - Manage courses
   - List own courses
   - Create/edit/delete courses
   - Upload thumbnails
   - Set price (or leave NULL for free)
   - Set payment details (Bkash/Nagad number)
   - Publish/unpublish

2. **ModuleRelationManager** - Manage modules (nested in courses)
   - Add/edit/delete modules
   - Reorder modules

3. **LessonRelationManager** - Manage lessons (nested in modules)
   - Add/edit/delete lessons
   - Set video provider & ID
   - Mark as free preview
   - Reorder lessons

4. **EnrollmentRequestResource** - Manage enrollment requests
   - List pending requests (for own courses)
   - View student details + transaction ID
   - Approve request (creates enrollment)
   - Reject request (with reason)
   - Filter by status (pending/approved/rejected)

5. **StatsPage** - View statistics
   - Course count
   - Enrollment count per course
   - Pending enrollment requests
   - Student engagement

---

## 7. Frontend Pages (React)

### 7.1 Public Pages

| Page | Route | Description |
|------|-------|-------------|
| Home | `/` | Course catalog with search/filters |
| Course Detail | `/course/{slug}` | Course info, lessons preview, purchase button |
| Category Page | `/category/{slug}` | Courses by category |

**Home Page Features:**
- Course grid layout
- Search bar (title search)
- Filter: Category dropdown
- Filter: Price (All/Free/Paid)
- Course cards: thumbnail, title, instructor, price, rating
- Pagination

**Course Detail Page Features:**
- Course info: title, description, thumbnail, price, instructor
- Course curriculum: modules + lessons (expandable)
- Free preview lessons (watchable without enrollment)
- "Enroll Now" button (if not enrolled)
- "Start Learning" button (if enrolled)
- Reviews section
- Average rating display

---

### 7.2 Student Pages (Auth Required)

| Page | Route | Description |
|------|-------|-------------|
| My Courses | `/my-courses` | Enrolled courses dashboard |
| Learning | `/learn/{courseSlug}` | Video player + lesson navigation |
| Profile | `/profile` | User profile settings |

**My Courses Page Features:**
- Grid of enrolled courses
- Progress indicator
- "Continue Learning" button
- Thumbnail, title, instructor

**Learning Page Features:**
- Video player (YouTube/Vimeo embed)
- Sidebar: Module/Lesson navigation
- Lesson locking indicators (if not enrolled)
- "Next Lesson" button
- "Mark Complete" button
- Resume from last lesson

---

### 7.3 Auth Pages

| Page | Route | Description |
|------|-------|-------------|
| Register (Student) | `/register` | Student registration form |
| Register (Instructor) | `/instructor/register` | Instructor registration form |
| Login | `/login` | Login form |
| Forgot Password | `/forgot-password` | Password reset request |
| Reset Password | `/reset-password/{token}` | Password reset form |

---

## 9. Email Notifications

### 9.1 Student Emails

| Email | Trigger | Content |
|-------|---------|---------|
| Enrollment Confirmation | Successful course purchase | Course title, instructor, link to course |
| Password Reset | User requests reset | Reset link (expires 1 hour) |

### 9.2 Instructor Emails

| Email | Trigger | Content |
|-------|---------|---------|
| Welcome | Instructor publishes first course | Welcome message, dashboard link |
| Password Reset | User requests reset | Reset link (expires 1 hour) |

---

## 10. Security Considerations

### 10.1 Authentication
- Laravel built-in session authentication
- Inertia.js for seamless auth (no page reloads)
- CSRF protection on all forms
- HTTP-only cookies for session tokens
- Password hashing (bcrypt)

### 10.2 Authorization
- Role-based access control (Student, Instructor, Admin)
- Course ownership validation (instructors can only edit own courses)
- Enrollment validation (students can only access enrolled courses)
 
 

---
 