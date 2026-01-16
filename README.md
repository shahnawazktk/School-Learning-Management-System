School Management System (Laravel)
<p align="center"> <a href="https://laravel.com" target="_blank"> <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="250" alt="Laravel Logo"> </a> </p> <p align="center"> <strong>A comprehensive School Management System built with Laravel</strong> </p>
Table of Contents

About

Features

Installation

Usage

Technologies Used

Contributing

License

About

The School Management System (SMS) is a web application built with Laravel that helps schools manage their administrative tasks efficiently. This system is designed to be user-friendly, modular, and scalable, allowing admins, teachers, students, and parents to interact seamlessly.

It simplifies the management of:

Student enrollment and profiles

Teacher profiles and assignments

Class and section management

Attendance tracking

Exam schedules and results

Fee management

Parent-teacher communication

The goal is to automate school operations while providing a clean and intuitive interface for all users.

Features

User Roles:

Admin: Full control over the system.

Teacher: Manage students, classes, assignments, and exams.

Student: View assignments, results, and attendance.

Parent: Track child’s performance and attendance.

Core Features:

Secure multi-authentication system

Dashboard for each user role

CRUD operations for students, teachers, classes, and subjects

Attendance management

Exam scheduling and result management

Fee collection and management

Notifications for parents and students

Reporting and analytics

Installation

Follow these steps to set up the project locally:

Clone the repository:

git clone https://github.com/your-username/school-management-system.git
cd school-management-system


Install dependencies:

composer install
npm install && npm run dev


Configure environment variables:

cp .env.example .env
php artisan key:generate


Edit .env with your database and mail credentials.

Run migrations and seed database:

php artisan migrate --seed


Start the local server:

php artisan serve


Access the system in your browser at:

http://127.0.0.1:8000

Usage

After installation:

Admin can create teachers, students, and assign classes.

Teachers can manage their subjects, students, and upload results.

Students can view their assignments, results, and attendance.

Parents can monitor their child’s progress.

Optional: You can set up email notifications and role-based dashboards for enhanced functionality.

Technologies Used

Backend: Laravel 12

Frontend: Blade Templates, Bootstrap 5

Database: MySQL / MariaDB

Queue & Notifications: Laravel Queues & Mail

Version Control: Git & GitHub

Contributing

We welcome contributions! If you want to contribute:

Fork the repository

Create a new branch (git checkout -b feature/your-feature)

Make your changes

Commit your changes (git commit -m "Add your message")

Push to the branch (git push origin feature/your-feature)

Open a Pull Request

Please follow the Code of Conduct
.

License

This project is open-sourced software licensed under the MIT License.
See the LICENSE
 file for details.