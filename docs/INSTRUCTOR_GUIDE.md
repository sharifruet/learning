# Instructor Guide - Python Learning Platform

Welcome to the Instructor Guide! This guide will help you create and manage courses on the platform.

## Table of Contents
1. [Getting Started](#getting-started)
2. [Creating Courses](#creating-courses)
3. [Managing Modules](#managing-modules)
4. [Creating Lessons](#creating-lessons)
5. [Adding Exercises](#adding-exercises)
6. [Managing Content](#managing-content)
7. [Student Management](#student-management)
8. [Best Practices](#best-practices)

## Getting Started

### Accessing Instructor Dashboard

1. Log in to your account
2. Click on **"Instructor"** in the navigation menu
3. You'll see your instructor dashboard with:
   - Your courses overview
   - Enrollment statistics
   - Quick action buttons

### Instructor Dashboard Overview

Your dashboard shows:
- **Statistics Cards**: Total courses, enrollments, modules, lessons
- **My Courses**: List of all your courses with statistics
- **Quick Actions**: Fast access to common tasks

## Creating Courses

### Step 1: Create New Course

1. Click **"Create New Course"** button (top right or Quick Actions)
2. Fill in course information:
   - **Title**: Course name (required)
   - **Slug**: URL-friendly identifier (auto-generated)
   - **Description**: Detailed course description
   - **Category**: Select from available categories
   - **Difficulty**: Beginner, Intermediate, or Advanced
   - **Status**: Draft or Published
   - **Image**: Upload course image (optional)
   - **Sort Order**: Display order (lower numbers appear first)
3. Click **"Create Course"**

### Step 2: Course Settings

After creating, you can:
- Edit course details
- Change course status
- Upload/change course image
- Manage course modules

## Managing Modules

### Creating Modules

1. Go to your course
2. Click **"Manage Modules"** or navigate to course modules
3. Click **"Add Module"**
4. Fill in module information:
   - **Title**: Module name (required)
   - **Description**: Module description
   - **Sort Order**: Display order
5. Click **"Create Module"**

### Editing Modules

1. Click **"Edit"** next to a module
2. Update module information
3. View lessons in the module (right sidebar)
4. Click **"Update Module"**

### Module Organization Tips

- **Logical Grouping**: Group related lessons together
- **Progressive Difficulty**: Start with basics, progress to advanced
- **Clear Titles**: Use descriptive module names
- **Sort Order**: Number modules sequentially (0, 1, 2, ...)

## Creating Lessons

### Step 1: Create Lesson

1. Navigate to a module
2. Click **"Add Lesson"** button
3. Fill in lesson information:
   - **Course**: Select course (auto-filled if from module)
   - **Module**: Select module (auto-filled if from module)
   - **Title**: Lesson name (required)
   - **Status**: Draft or Published
   - **Content Type**: Text, Video, or Mixed
   - **Estimated Time**: Minutes to complete
   - **Learning Objectives**: What students will learn
   - **Featured Image**: Upload image (optional)
   - **Sort Order**: Display order

### Step 2: Add Content

#### Rich Text Content

1. Use the **Rich Text Editor** (WYSIWYG)
2. Format your content:
   - Headers (H1, H2, H3)
   - Bold, italic, underline
   - Lists (ordered, unordered)
   - Links
   - Images (upload directly)
   - Code blocks
3. Content is saved automatically as you type

#### Code Examples

1. Scroll to **"Code Examples"** section
2. Enter code in the text area
3. Code will be displayed with syntax highlighting
4. Use Python syntax for best results

### Step 3: Publish Lesson

1. Set **Status** to "Published"
2. Click **"Create Lesson"** or **"Update Lesson"**
3. Students can now access the lesson

### Lesson Best Practices

- **Clear Objectives**: State what students will learn
- **Structured Content**: Use headers and lists
- **Code Examples**: Include working code samples
- **Visual Aids**: Add images where helpful
- **Estimated Time**: Be realistic about completion time

## Adding Exercises

### Creating Exercises

1. Navigate to a lesson
2. Click **"Manage Exercises"** button
3. Click **"Add Exercise"**
4. Fill in exercise details:
   - **Title**: Exercise name (required)
   - **Description**: What students need to do
   - **Starter Code**: Initial code template
   - **Solution Code**: Correct solution (for validation)
   - **Hints**: Helpful hints for students
   - **Sort Order**: Display order
5. Click **"Create Exercise"**

### Exercise Tips

- **Clear Instructions**: Describe what students should do
- **Starter Code**: Provide a template to get started
- **Progressive Difficulty**: Start easy, increase complexity
- **Helpful Hints**: Guide students without giving answers
- **Multiple Exercises**: Add several exercises per lesson

### Editing Exercises

1. Click **"Edit"** next to an exercise
2. Update exercise details
3. Click **"Update Exercise"**

## Managing Content

### Content Status

- **Draft**: Not visible to students (work in progress)
- **Published**: Visible to enrolled students

### Content Organization

**Course Structure:**
```
Course
  └── Module 1
      ├── Lesson 1
      │   ├── Content
      │   └── Exercise 1
      └── Lesson 2
  └── Module 2
      └── ...
```

### Editing Content

1. Navigate to the content item
2. Click **"Edit"** button
3. Make changes
4. Click **"Update"**

### Deleting Content

1. Click **"Delete"** button
2. Confirm deletion
3. **Warning**: Deleting modules/lessons also deletes child content

## Student Management

### Viewing Enrollment Statistics

1. Go to Instructor Dashboard
2. View **"My Courses"** table
3. See enrollment counts:
   - **Enrollments**: Total students enrolled
   - **Completed**: Students who completed the course

### Course Analytics

- Total enrollments per course
- Completed enrollments
- Module and lesson counts
- Quick access to course management

## Best Practices

### Course Design

1. **Start with Outline**: Plan course structure first
2. **Clear Learning Path**: Logical progression of topics
3. **Consistent Format**: Use similar structure across lessons
4. **Regular Updates**: Keep content current and relevant

### Content Creation

1. **Write Clearly**: Use simple, clear language
2. **Use Examples**: Real-world examples help understanding
3. **Visual Content**: Images and diagrams enhance learning
4. **Code Quality**: Provide clean, well-commented code

### Student Engagement

1. **Clear Objectives**: Tell students what they'll learn
2. **Practical Exercises**: Hands-on practice is essential
3. **Progressive Difficulty**: Build skills gradually
4. **Encouragement**: Provide positive feedback

### Content Management

1. **Draft First**: Create content as drafts
2. **Review Before Publishing**: Check for errors
3. **Test Exercises**: Verify solutions work
4. **Update Regularly**: Keep content fresh

### Module Organization

1. **Logical Grouping**: Related lessons together
2. **Sequential Learning**: Build on previous knowledge
3. **Clear Titles**: Descriptive module names
4. **Appropriate Length**: 3-7 lessons per module

### Lesson Structure

1. **Introduction**: What students will learn
2. **Content**: Main lesson material
3. **Examples**: Code examples and demonstrations
4. **Exercises**: Practice problems
5. **Summary**: Key takeaways

## Image Upload

### Supported Formats
- JPEG (.jpg, .jpeg)
- PNG (.png)
- GIF (.gif)
- WebP (.webp)

### Size Limits
- Maximum file size: 5MB
- Recommended: Under 2MB for faster loading

### Upload Process
1. Click **"Upload"** button
2. Select image file
3. Image is uploaded and URL is inserted
4. Image appears in content

## Troubleshooting

### Can't Create Course
- Ensure you're logged in as Instructor or Admin
- Check all required fields are filled
- Verify course title is unique

### Content Not Saving
- Check internet connection
- Verify all required fields
- Try refreshing the page
- Check browser console for errors

### Images Not Uploading
- Check file size (max 5MB)
- Verify file format is supported
- Check browser permissions
- Try a different image

### Exercises Not Working
- Verify solution code is correct
- Check code syntax
- Test solution code manually
- Contact support if needed

## Quick Reference

### Keyboard Shortcuts
- **Ctrl+S**: Save (in some editors)
- **Tab**: Navigate form fields
- **Esc**: Close modals

### Status Meanings
- **Draft**: Work in progress, not visible to students
- **Published**: Live and accessible to students

### Sort Order
- Lower numbers appear first
- Use 0, 10, 20, 30... for easy reordering
- Can use any numbers, sorted ascending

## Getting Help

If you need assistance:
1. Review this guide
2. Check the FAQ section
3. Contact platform support
4. Review admin documentation

---

**Happy Teaching!** 🎓📝

