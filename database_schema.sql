-- Database schema for Judge Grading System
-- Run this in your Supabase SQL editor

-- Create submissions table
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

-- Create index for faster queries
CREATE INDEX IF NOT EXISTS idx_submissions_created_at ON submissions(created_at);
CREATE INDEX IF NOT EXISTS idx_submissions_judge_name ON submissions(judge_name);

