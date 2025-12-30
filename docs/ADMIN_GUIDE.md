# Admin Guide - Python Learning Platform

Welcome to the Admin Guide! This comprehensive guide covers all administrative functions of the platform.

## Table of Contents
1. [Admin Dashboard](#admin-dashboard)
2. [User Management](#user-management)
3. [Course Management](#course-management)
4. [Content Management](#content-management)
5. [System Overview](#system-overview)
6. [Security](#security)
7. [Troubleshooting](#troubleshooting)

## Admin Dashboard

### Accessing Admin Panel

1. Log in with an admin account
2. Click **"Admin"** in the navigation menu
3. You'll see the admin dashboard

### Dashboard Overview

The admin dashboard displays:

**Statistics Cards:**
- Total Courses (with published count)
- Total Users (with students count)
- Total Enrollments (with active count)
- Total Lessons (with published count)

**Quick Actions:**
- Create Course
- Manage Courses
- Manage Users
- Manage Lessons

**Recent Activity:**
- Recent Courses (last 5)
- Recent Users (last 5)

## User Management

### Viewing Users

1. Go to Admin Dashboard
2. Click **"Manage Users"** in Quick Actions
3. View all users in a table

### Filtering Users

Use filter buttons:
- **All Users**: Show everyone
- **Students**: Show only students
- **Instructors**: Show only instructors
- **Admins**: Show only admins

### User Statistics

View at-a-glance statistics:
- Total Users
- Total Students
- Total Instructors
- Total Admins

### Editing Users

1. Click **"Edit"** next to a user
2. Update user information:
   - First Name
   - Last Name
   - Email
   - Role (Student, Instructor, Admin)
   - Password (optional - leave blank to keep current)
3. Click **"Update User"**

### Changing User Roles

1. Edit the user
2. Select new role from dropdown
3. Save changes

**Roles:**
- **Student**: Can enroll and learn
- **Instructor**: Can create and manage courses
- **Admin**: Full system access

### Resetting Passwords

1. Edit the user
2. Enter new password in "New Password" field
3. Leave blank to keep current password
4. Save changes

### Deleting Users

1. Click **"Delete"** next to a user
2. Confirm deletion
3. **Note**: Cannot delete your own account

**Warning**: Deleting users may affect:
- Course ownership (if instructor)
- Enrollment records
- Progress tracking

## Course Management

### Viewing All Courses

1. Go to Admin Dashboard
2. Click **"Manage Courses"**
3. View all courses in a table

### Course Information Displayed

- Title and description
- Status (Published/Draft)
- Difficulty level
- Sort order
- Quick actions (Edit, View, Modules)

### Creating Courses

1. Click **"Create New Course"**
2. Fill in course details (see Instructor Guide)
3. Save course

### Editing Courses

1. Click **"Edit"** next to a course
2. Update course information
3. Save changes

### Managing Course Modules

1. Click **"Modules"** button next to course
2. View all modules for the course
3. Create, edit, or delete modules

## Content Management

### Module Management

**Creating Modules:**
1. Navigate to course modules
2. Click **"Add Module"**
3. Fill in module details
4. Save

**Editing Modules:**
1. Click **"Edit"** next to module
2. Update information
3. View lessons in module (sidebar)
4. Save changes

### Lesson Management

**Creating Lessons:**
1. Navigate to module
2. Click **"Add Lesson"**
3. Fill in lesson details
4. Add content using rich text editor
5. Add code examples
6. Save lesson

**Editing Lessons:**
1. Click **"Edit"** next to lesson
2. Update content
3. Manage exercises (button in edit page)
4. Save changes

**Lesson Features:**
- Rich text editor (WYSIWYG)
- Image upload
- Code examples with syntax highlighting
- Learning objectives
- Estimated time
- Status (Draft/Published)

### Exercise Management

**Creating Exercises:**
1. Navigate to lesson
2. Click **"Manage Exercises"**
3. Click **"Add Exercise"**
4. Fill in exercise details:
   - Title and description
   - Starter code
   - Solution code
   - Hints
5. Save exercise

**Editing Exercises:**
1. Click **"Edit"** next to exercise
2. Update exercise details
3. Save changes

## System Overview

### System Statistics

Monitor platform health:
- **Total Courses**: All courses in system
- **Published Courses**: Live courses
- **Draft Courses**: Work in progress
- **Total Users**: All registered users
- **Total Students**: Student accounts
- **Total Instructors**: Instructor accounts
- **Total Admins**: Admin accounts
- **Total Enrollments**: All course enrollments
- **Active Enrollments**: Current enrollments
- **Total Lessons**: All lessons
- **Published Lessons**: Live lessons
- **Total Modules**: All modules

### Recent Activity

**Recent Courses:**
- Last 5 created courses
- Quick access to edit
- Status indicators

**Recent Users:**
- Last 5 registered users
- Role badges
- Quick access to edit

## Security

### User Security

**Password Requirements:**
- Minimum 8 characters
- Stored using bcrypt hashing
- Can be reset by admin

**Email Verification:**
- Required for account activation
- Prevents unauthorized access
- Can be resent if needed

**Role-Based Access:**
- Students: Limited access
- Instructors: Course management
- Admins: Full system access

### Data Security

**Input Validation:**
- All user inputs validated
- SQL injection prevention
- XSS protection
- CSRF protection

**File Upload Security:**
- File type validation
- Size limits (5MB for images)
- Secure storage location

### Best Practices

1. **Regular Backups**: Backup database regularly
2. **Monitor Logs**: Check error logs frequently
3. **Update Passwords**: Encourage strong passwords
4. **Review Users**: Periodically review user accounts
5. **Audit Trail**: Monitor admin actions

## Troubleshooting

### Common Issues

**User Can't Login:**
- Check email verification status
- Verify password is correct
- Check if account is active
- Reset password if needed

**Course Not Appearing:**
- Check course status (must be Published)
- Verify course is assigned to instructor
- Check course visibility settings

**Content Not Saving:**
- Check internet connection
- Verify all required fields
- Check browser console for errors
- Try refreshing page

**Image Upload Failing:**
- Check file size (max 5MB)
- Verify file format
- Check upload directory permissions
- Verify disk space

### System Maintenance

**Database Maintenance:**
- Regular backups
- Index optimization
- Query optimization
- Cleanup old data

**File Maintenance:**
- Clean up unused uploads
- Optimize images
- Monitor disk space
- Archive old content

**Performance Optimization:**
- Monitor page load times
- Optimize database queries
- Cache static content
- CDN for assets (if applicable)

## Quick Reference

### Admin Shortcuts

- **Dashboard**: `/admin`
- **Users**: `/admin/users`
- **Courses**: `/admin/courses`
- **Lessons**: `/admin/lessons`
- **Exercises**: `/admin/exercises`

### Status Meanings

- **Draft**: Not visible to students
- **Published**: Visible to enrolled students
- **Enrolled**: Student is enrolled
- **Completed**: Student completed course

### User Roles

- **Student**: Learn and enroll
- **Instructor**: Create courses
- **Admin**: Full access

## Best Practices

### User Management

1. **Regular Audits**: Review user accounts periodically
2. **Role Assignment**: Assign appropriate roles
3. **Password Policy**: Enforce strong passwords
4. **Account Cleanup**: Remove inactive accounts

### Content Management

1. **Quality Control**: Review content before publishing
2. **Consistent Structure**: Maintain consistent course structure
3. **Regular Updates**: Keep content current
4. **Backup Content**: Backup important content

### System Monitoring

1. **Error Logs**: Monitor error logs daily
2. **Performance**: Track page load times
3. **User Activity**: Monitor user engagement
4. **Security**: Review security logs

## Getting Help

If you need assistance:
1. Review this guide
2. Check system documentation
3. Review error logs
4. Contact technical support

---

**System Administration** 🔧⚙️

