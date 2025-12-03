# Judge Grading System

A web-based grading system for computer science project evaluations. This system allows judges to submit grades for student projects and administrators to view all submissions.

## Table of Contents

- [Features](#features)
- [Project Structure](#project-structure)
- [Development History](#development-history)
- [Errors Encountered & Solutions](#errors-encountered--solutions)
- [Setup Instructions](#setup-instructions)
- [Deployment](#deployment)
- [Usage](#usage)

## Features

- **Dual Login System**: Separate login for judges and administrators
- **Grading Form**: Judges can submit grades with criteria evaluation
- **Admin Dashboard**: Administrators can view all submissions
- **Database Integration**: Uses Supabase (PostgreSQL) for data storage
- **Session Management**: Secure session-based authentication
- **Docker Support**: Containerized deployment ready

## Project Structure

```
judge_grading_system/
├── index.php              # Login page (supports judge and admin)
├── loginsuccess.php       # Grading form for judges
├── admin.php              # Administrator dashboard
├── connect.php            # Database connection (PDO/PostgreSQL)
├── database_schema.sql    # Database schema for Supabase
├── Dockerfile             # Docker configuration
├── .dockerignore          # Files to exclude from Docker build
└── README.md              # This file
```

## Development History

### Phase 1: Initial Setup
- Created basic login system with hardcoded credentials
- Built grading form with criteria evaluation
- Implemented session management

### Phase 2: Styling Simplification
- **Change**: Removed decorative styling to create a plain, minimal design
- Removed background colors, shadows, rounded corners
- Simplified form layout to basic HTML

### Phase 3: Administrator Login
- **Change**: Added administrator login functionality
- Created separate credentials for admin (`admin` / `admin123`)
- Added role-based session tracking (`judge` vs `admin`)
- Created `admin.php` dashboard page
- Updated login page to support both user types

### Phase 4: Docker Setup
- **Change**: Added Dockerfile for containerized deployment
- Created `.dockerignore` file
- Configured PHP 8.2 with Apache
- Added PostgreSQL extension support

### Phase 5: Database Integration
- **Change**: Integrated Supabase (PostgreSQL) database
- Created database schema (`database_schema.sql`)
- Updated `connect.php` to use PDO with Supabase
- Added save functionality to grading form
- Added display functionality to admin dashboard
- Updated Dockerfile with PostgreSQL extensions

### Phase 6: Code Refactoring
- **Change**: Converted from `pg_*` functions to PDO
- Improved security with prepared statements
- Better error handling with PDO exceptions
- More maintainable and database-agnostic code

## Errors Encountered & Solutions

### Error 1: Session/Header Errors
**Error Message:**
```
Warning: session_start(): Session cannot be started after headers have already been sent
Warning: Cannot modify header information - headers already sent
```

**Cause:**
- HTML output (`<!DOCTYPE HTML>`) was placed before PHP code
- PHP sends HTTP headers when any output occurs
- `session_start()` and `header()` must be called before any output

**Solution:**
- Moved all PHP code (including `session_start()` and `header()` calls) to the top of files
- Placed `<!DOCTYPE HTML>` after PHP code
- Applied fix to `index.php`, `loginsuccess.php`, and `admin.php`

**Files Changed:**
- `index.php` - Moved PHP block before HTML
- `loginsuccess.php` - Moved PHP block before HTML
- `admin.php` - Moved PHP block before HTML

---

### Error 2: Missing Dockerfile
**Error Message:**
```
error: failed to solve: failed to read dockerfile: open Dockerfile: no such file or directory
```

**Cause:**
- Render.com deployment requires a Dockerfile for containerized builds
- No Dockerfile existed in the repository

**Solution:**
- Created `Dockerfile` with PHP 8.2 Apache base image
- Added PostgreSQL extension installation
- Configured proper file permissions
- Created `.dockerignore` to exclude unnecessary files

**Files Created:**
- `Dockerfile`
- `.dockerignore`

---

### Error 3: PostgreSQL Extension Not Found
**Error Message:**
```
Fatal error: Uncaught Error: Call to undefined function pg_connect()
```

**Cause:**
- `pg_connect()` function requires the `pgsql` PHP extension
- Dockerfile was installing `pdo_pgsql` but code was using `pg_*` functions
- Two different PostgreSQL APIs: `pg_*` (procedural) vs PDO (object-oriented)

**Solution:**
- Converted all database code from `pg_*` functions to PDO
- PDO is more standard, secure, and maintainable
- Updated `connect.php` to use PDO connection
- Updated `loginsuccess.php` to use PDO prepared statements
- Updated `admin.php` to use PDO `fetchAll()`
- Updated Dockerfile to install `pdo_pgsql` extension

**Code Changes:**
- **Before:** `pg_connect()`, `pg_query()`, `pg_fetch_assoc()`, `pg_escape_string()`
- **After:** `new PDO()`, `prepare()`, `execute()`, `fetchAll()`

**Benefits of PDO:**
- Built-in prepared statements (prevents SQL injection)
- Better error handling with exceptions
- Database-agnostic (works with MySQL, PostgreSQL, SQLite, etc.)
- More modern and recommended approach

**Files Changed:**
- `connect.php` - Converted to PDO
- `loginsuccess.php` - Converted to PDO prepared statements
- `admin.php` - Converted to PDO fetch methods
- `Dockerfile` - Ensured `pdo_pgsql` extension is installed

---

## Setup Instructions

### Prerequisites
- PHP 8.2 or higher
- PostgreSQL database (or Supabase account)
- Web server (Apache/Nginx) or Docker

### Local Development

1. **Clone the repository**
   ```bash
   git clone https://github.com/FreshTaurus/grading-system.git
   cd grading-system
   ```

2. **Set up Supabase Database**
   - Create a free account at [Supabase](https://supabase.com)
   - Create a new project
   - Go to SQL Editor and run `database_schema.sql`
   - Get your connection string from Project Settings > Database

3. **Configure Environment Variables**
   Create a `.env` file or set environment variables:
   ```bash
   DATABASE_URL=postgresql://postgres:[PASSWORD]@[HOST]:5432/postgres
   ```
   
   Or set individual variables:
   ```bash
   DB_HOST=your-supabase-host
   DB_PORT=5432
   DB_NAME=postgres
   DB_USER=postgres
   DB_PASSWORD=your-supabase-password
   ```

4. **Run with PHP Built-in Server**
   ```bash
   php -S localhost:8000
   ```

5. **Or Run with Docker**
   ```bash
   docker build -t judge-grading-system .
   docker run -p 8000:80 -e DATABASE_URL="your-connection-string" judge-grading-system
   ```

### Database Schema

Run the SQL in `database_schema.sql` in your Supabase SQL Editor:

```sql
CREATE TABLE IF NOT EXISTS submissions (
    id SERIAL PRIMARY KEY,
    group_members VARCHAR(255) NOT NULL,
    project_title VARCHAR(255) NOT NULL,
    group_number VARCHAR(50) NOT NULL,
    criteria1 VARCHAR(20),
    criteria2 VARCHAR(20),
    criteria3 VARCHAR(20),
    criteria4 VARCHAR(20),
    judge_name VARCHAR(255) NOT NULL,
    comments TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Deployment

### Render.com Deployment

1. **Connect Repository**
   - Link your GitHub repository to Render
   - Select "Web Service"

2. **Configure Environment Variables**
   - Add `DATABASE_URL` with your Supabase connection string
   - Format: `postgresql://postgres:[PASSWORD]@[HOST]:5432/postgres`

3. **Build Settings**
   - Render will automatically detect the Dockerfile
   - Build command: (automatic)
   - Start command: (automatic)

4. **Deploy**
   - Render will build and deploy automatically
   - Your app will be available at `your-app.onrender.com`

### Environment Variables for Render

Required environment variable:
- `DATABASE_URL` - Your Supabase PostgreSQL connection string

## Usage

### Judge Login
1. Navigate to the login page
2. Use credentials: `user` / `password`
3. Fill out the grading form:
   - Group Members
   - Project Title
   - Group Number
   - Select criteria ratings (Developing or Accomplished)
   - Judge's name
   - Comments
4. Click Submit
5. Submission is saved to database

### Administrator Login
1. Navigate to the login page
2. Use credentials: `admin` / `admin123`
3. View all submissions in the dashboard
4. See submission details including:
   - Group information
   - Criteria ratings
   - Judge name
   - Comments
   - Submission timestamp

## Default Login Credentials

- **Judge**: 
  - Username: `user`
  - Password: `password`

- **Administrator**: 
  - Username: `admin`
  - Password: `admin123`

⚠️ **Important**: Change these credentials in production!

## Technology Stack

- **Backend**: PHP 8.2
- **Database**: PostgreSQL (via Supabase)
- **Database Access**: PDO (PHP Data Objects)
- **Web Server**: Apache
- **Containerization**: Docker
- **Deployment**: Render.com
- **Session Management**: PHP Sessions

## Security Notes

- Uses PDO prepared statements to prevent SQL injection
- Session-based authentication
- Role-based access control (judge vs admin)
- Input sanitization with `htmlspecialchars()`

## Future Enhancements

- [ ] Password hashing and secure authentication
- [ ] Judge management system
- [ ] Reports and statistics generation
- [ ] Export functionality (CSV/PDF)
- [ ] Email notifications
- [ ] Search and filter submissions
- [ ] Edit/delete submissions (admin)
- [ ] User registration system

## Troubleshooting

### Database Connection Issues
- Verify `DATABASE_URL` environment variable is set correctly
- Check Supabase project is active
- Ensure database schema is created
- Verify network connectivity to Supabase

### Session Issues
- Ensure PHP code comes before HTML output
- Check session storage permissions
- Verify `session_start()` is called before any output

### Docker Build Issues
- Ensure Dockerfile is in repository root
- Check PostgreSQL extension installation
- Verify all dependencies are included

## License

This project is for educational purposes.

## Author

Developed for Computer Science Project Grading System
