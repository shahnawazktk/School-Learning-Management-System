# Student Section - LMS Implementation Guide

## Overview
This document provides a complete guide for the Student section of the Learning Management System (LMS).

## Features Implemented

### 1. Student Dashboard
- **Location**: `resources/views/student/dashboard.blade.php`
- **Route**: `/student/dashboard`
- **Features**:
  - Welcome banner with student name
  - Quick statistics (Attendance %, Average Grade, Total Subjects)
  - Pending assignments list
  - Recent submissions with grades
  - Enrollment overview

### 2. Subjects/Courses
- **Location**: `resources/views/student/subjects.blade.php`
- **Route**: `/student/subjects`
- **Features**:
  - List of enrolled courses
  - Course details with teacher information
  - Subject codes and credits
  - Enrollment status

### 3. Assignments
- **Location**: `resources/views/student/assignments.blade.php`
- **Route**: `/student/assignments`
- **Features**:
  - View all assignments
  - Submit assignments (file upload)
  - Track submission status
  - View grades and feedback
  - Due date tracking

### 4. Attendance
- **Location**: `resources/views/student/attendance.blade.php`
- **Route**: `/student/attendance`
- **Features**:
  - Attendance records by date
  - Attendance percentage calculation
  - Monthly attendance trends
  - Status indicators (Present, Absent, Late, Excused)

### 5. Results/Grades
- **Location**: `resources/views/student/results.blade.php`
- **Route**: `/student/results`
- **Features**:
  - Grade scores for all courses
  - Average percentage calculation
  - Grade distribution chart
  - Assignment and exam grades

### 6. Resources
- **Location**: `resources/views/student/resources.blade.php`
- **Route**: `/student/resources`
- **Features**:
  - Course materials and resources
  - Download lecture notes, documents
  - Resource categorization
  - Access control based on enrollment

### 7. Examinations
- **Location**: `resources/views/student/exams.blade.php`
- **Route**: `/student/exams`
- **Features**:
  - Exam schedule
  - Exam details (date, time, marks)
  - Exam results
  - Exam statistics

### 8. Profile
- **Location**: `resources/views/student/profile.blade.php`
- **Route**: `/student/profile`
- **Features**:
  - View student information
  - Update personal details
  - Emergency contact information
  - Academic information

## Database Structure

### Tables Created/Updated:

1. **students**
   - user_id, student_id, class, section, roll_number
   - academic_year, enrollment_date, date_of_birth
   - address, city, state, zip_code, country
   - emergency_contact, status

2. **enrollments**
   - student_id, course_id, subject_id
   - enrollment_date, status

3. **assignments**
   - title, description, due_date
   - course_id, teacher_id, max_marks

4. **submissions**
   - student_id, assignment_id, file_path
   - comments, submitted_at, marks_obtained
   - feedback, status

5. **attendances**
   - student_id, course_id, date
   - status, remarks

6. **grade_scores**
   - student_id, course_id, assignment_id, exam_id
   - marks_obtained, total_marks, percentage
   - grade, remarks

7. **resources**
   - title, description, course_id, teacher_id
   - file_path, file_type, type

8. **exams**
   - title, description, course_id
   - exam_date, start_time, end_time
   - total_marks, type, status

9. **subjects**
   - name, code, description, credits

10. **courses**
    - title, description, subject_id, teacher_id

## Models and Relationships

### Student Model
```php
- belongsTo: User
- hasMany: Enrollments, Submissions, Attendances, GradeScores
```

### Enrollment Model
```php
- belongsTo: Student, Course, Subject
```

### Assignment Model
```php
- belongsTo: Course, Teacher (User)
- hasMany: Submissions
```

### Submission Model
```php
- belongsTo: Student, Assignment
- hasOne: GradeScore
```

### Attendance Model
```php
- belongsTo: Student, Course
```

### GradeScore Model
```php
- belongsTo: Student, Course, Assignment, Exam
```

### Resource Model
```php
- belongsTo: Course, Teacher (User)
```

### Exam Model
```php
- belongsTo: Course
- hasMany: GradeScores
```

## Installation Steps

### 1. Run Migrations
```bash
php artisan migrate
```

### 2. Seed Database
```bash
php artisan db:seed --class=StudentDataSeeder
```

Or run all seeders:
```bash
php artisan db:seed
```

### 3. Create Storage Link
```bash
php artisan storage:link
```

### 4. Test Login
- Email: student@school.com
- Password: password

## API Endpoints

### Student Routes (Protected by auth and role:student middleware)

**GET Routes:**
- `/student/dashboard` - Student dashboard
- `/student/subjects` - View enrolled subjects
- `/student/assignments` - View assignments
- `/student/attendance` - View attendance records
- `/student/results` - View grades and results
- `/student/resources` - View course resources
- `/student/exams` - View exam schedule
- `/student/profile` - View/edit profile

**POST Routes:**
- `/student/assignments/{assignment}/submit` - Submit assignment
- `/student/profile` (PUT) - Update profile

**Download Routes:**
- `/student/resources/{resource}/download` - Download resource

## Controller Methods

### StudentController

1. **dashboard()** - Display student dashboard with statistics
2. **subjects()** - List enrolled subjects/courses
3. **assignments()** - List all assignments
4. **attendance()** - Show attendance records
5. **results()** - Display grades and results
6. **resources()** - List available resources
7. **exams()** - Show exam schedule
8. **profile()** - Display student profile
9. **submitAssignment()** - Handle assignment submission
10. **downloadResource()** - Handle resource download
11. **updateProfile()** - Update student profile

## Security Features

1. **Authentication**: All routes protected by auth middleware
2. **Authorization**: Role-based access (role:student)
3. **Enrollment Verification**: Students can only access courses they're enrolled in
4. **File Upload Validation**: File type and size restrictions
5. **Late Submission Tracking**: Automatic status update for late submissions

## Sample Data

The `StudentDataSeeder` creates:
- 5 subjects (Math, Physics, Chemistry, English, CS)
- 5 courses (one for each subject)
- 1 student user with complete profile
- Enrollments in all courses
- 15 assignments (3 per course)
- 2 sample submissions
- 150 attendance records (30 per course)
- 5 grade scores
- 5 exams
- 5 resources

## File Storage

### Assignment Submissions
- Path: `storage/app/public/assignments/`
- Allowed types: pdf, doc, docx, ppt, pptx, jpg, jpeg, png, zip
- Max size: 10MB

### Resources
- Path: `storage/app/public/resources/`
- Types: lecture_notes, video, document, link, other

## Grade Calculation

Grades are calculated based on percentage:
- A+: 90-100%
- A: 85-89%
- B+: 80-84%
- B: 75-79%
- C+: 70-74%
- C: 65-69%
- D: 60-64%
- F: Below 60%

## Next Steps

### Recommended Enhancements:
1. Add real-time notifications for new assignments
2. Implement online quiz/exam system
3. Add discussion forums for each course
4. Create mobile-responsive views
5. Add calendar view for assignments and exams
6. Implement grade appeal system
7. Add course feedback/rating system
8. Create student progress reports (PDF export)
9. Add parent portal integration
10. Implement messaging system between students and teachers

## Troubleshooting

### Common Issues:

1. **Student profile not found**
   - Ensure student record exists in students table
   - Check user_id matches authenticated user

2. **File upload fails**
   - Check storage permissions
   - Verify storage link exists
   - Check file size and type

3. **Attendance percentage shows 0**
   - Ensure attendance records exist
   - Check date format in database

4. **Grades not displaying**
   - Verify grade_scores table has records
   - Check relationships in models

## Support

For issues or questions:
- Check Laravel logs: `storage/logs/laravel.log`
- Review migration files for database structure
- Verify model relationships
- Check route definitions in `routes/web.php`

---

**Version**: 1.0  
**Last Updated**: January 2024  
**Author**: Shahnawaz & Team
