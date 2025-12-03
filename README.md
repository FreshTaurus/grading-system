# Judge Grading System

A web-based grading system for computer science project evaluations.

## Setup Instructions

### 1. Database Setup (Supabase)

1. Create a free account at [Supabase](https://supabase.com)
2. Create a new project
3. Go to the SQL Editor and run the `database_schema.sql` file
4. Go to Project Settings > Database to get your connection details

### 2. Environment Variables

For local development, create a `.env` file (or set environment variables):
```
DB_HOST=your-supabase-host
DB_PORT=5432
DB_NAME=postgres
DB_USER=postgres
DB_PASSWORD=your-supabase-password
```

Or use the connection string format:
```
DATABASE_URL=postgresql://postgres:password@host:5432/postgres
```

### 3. Render Deployment

In your Render dashboard, add these environment variables:
- `DATABASE_URL` - Your Supabase connection string
  - Format: `postgresql://postgres:[YOUR-PASSWORD]@[YOUR-HOST]:5432/postgres`
  - You can find this in Supabase: Project Settings > Database > Connection string (URI)

### 4. Default Login Credentials

- **Judge**: username: `user`, password: `password`
- **Admin**: username: `admin`, password: `admin123`

## Features

- Judge login for submitting grades
- Administrator dashboard to view all submissions
- Database storage using Supabase (PostgreSQL)
- Session management

## Files

- `index.php` - Login page
- `loginsuccess.php` - Grading form for judges
- `admin.php` - Administrator dashboard
- `connect.php` - Database connection
- `database_schema.sql` - Database schema

