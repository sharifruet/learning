# Master Data Seeder

This document describes the master data seeder for the Python Learning Platform.

## Overview

The `MasterDataSeeder` creates two comprehensive courses:
1. **Python Programming** - A beginner-friendly Python course
2. **JavaScript Programming** - A beginner-friendly JavaScript course

## Courses Included

### 1. Python Programming Course

**Slug**: `python-programming`
**Difficulty**: Beginner
**Status**: Published

#### Modules:
1. **Getting Started with Python**
   - Introduction to Python
   - Python Syntax and Basics
   - Variables and Data Types

2. **Data Structures**
   - Lists
   - Dictionaries

3. **Control Flow**
   - If Statements
   - Loops

### 2. JavaScript Programming Course

**Slug**: `javascript-programming`
**Difficulty**: Beginner
**Status**: Published

#### Modules:
1. **JavaScript Basics**
   - Introduction to JavaScript
   - Variables and Data Types
   - Functions

2. **DOM Manipulation**
   - Selecting Elements
   - Event Handling

3. **Arrays and Objects**
   - Arrays
   - Objects

## Running the Seeder

### Seed Master Data Only:
```bash
php spark db:seed MasterDataSeeder
```

### Seed All Data (including users):
```bash
php spark db:seed DatabaseSeeder
```

### Using Docker:
```bash
docker-compose exec web php spark db:seed MasterDataSeeder
```

## Notes

- The seeder checks if courses already exist before inserting to prevent duplicates
- All courses are set to `published` status
- All lessons are set to `published` status with `text` content type
- Lessons include code examples and HTML content
- Modules are ordered by `sort_order`
- Lessons are ordered by `sort_order` within each module

## Customization

To add more courses or modify existing ones:

1. Edit `app/Database/Seeds/MasterDataSeeder.php`
2. Add new course methods similar to `insertPythonCourse()` and `insertJavaScriptCourse()`
3. Call the new methods in the `run()` method
4. Run the seeder again

## Database Schema

The seeder creates:
- Courses (2 courses)
- Modules (6 modules total - 3 per course)
- Lessons (12 lessons total - 2 per module)

## Re-seeding

If you need to re-seed the master data:

1. **Option 1**: Delete existing courses manually via admin panel or database
2. **Option 2**: Truncate tables (be careful - this removes all data):
   ```sql
   SET FOREIGN_KEY_CHECKS=0;
   TRUNCATE TABLE exercises;
   TRUNCATE TABLE lessons;
   TRUNCATE TABLE modules;
   DELETE FROM courses WHERE slug IN ('python-programming', 'javascript-programming');
   SET FOREIGN_KEY_CHECKS=1;
   ```
3. Run the seeder again

---

**Last Updated**: 2024-12-30
**Version**: 1.0

