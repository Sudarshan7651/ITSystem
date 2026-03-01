# 🎓 Internship Tracking System

A full-featured **web application** built with **Laravel 12** to manage and track student internships across colleges, departments, courses, and class years. The system provides role-based access for **Admins**, **Teachers**, and **Students** — each with their own dedicated dashboard and functionality.

---

## 🚀 Features

### 👤 Multi-Role Authentication

- **Admin** — Full control over the system via a dedicated admin panel
- **Teacher** — Department-level access with profile management
- **Student** — Self-registration with Teacher approval workflow

### 🏛️ Admin Panel

- Manage **Colleges** (add, edit, delete, status toggle)
- Manage **Departments** (linked to colleges)
- Manage **Courses** (linked to departments)
- Manage **Class Years** (e.g. FY, SY, TY — linked to courses)
- Manage **Subjects** (linked to class years, supports Theory / Practical / Elective types)
- Manage **Teachers** (create accounts, assign departments)
- Cascading dropdown filters across all management pages

### 🎓 Student Portal

- Self-registration with college, department, course & year selection
- Accounts require **Teacher approval** before access is granted
- Profile management (name, phone, profile photo, password)

### 👨‍🏫 Teacher Portal

- Login and personal dashboard
- Profile management (name, phone, profile photo, password)

---

## 🛠️ Tech Stack

| Layer              | Technology                                                 |
| ------------------ | ---------------------------------------------------------- |
| **Framework**      | Laravel 12 (PHP 8.2+)                                      |
| **Frontend**       | Blade Templates, Vanilla CSS, Vanilla JS                   |
| **Authentication** | Laravel Breeze (session-based) + custom role middleware    |
| **Database**       | MySQL (via WAMP)                                           |
| **API Tokens**     | Laravel Sanctum                                            |
| **UI Design**      | Custom dark-mode design system (glassmorphism, Inter font) |

---

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/           # College, Department, Course, Subject, Teacher, ClassYear controllers
│   │   ├── Auth/            # Admin, Teacher, Student auth controllers
│   │   ├── StudentProfileController.php
│   │   └── TeacherProfileController.php
│   └── Middleware/          # Role-based guards (admin, teacher, student)
├── Models/
│   ├── User.php             # Unified user model (admin / teacher / student)
│   ├── College.php
│   ├── Department.php
│   ├── Course.php
│   ├── ClassYear.php
│   └── Subject.php

database/
├── migrations/              # All table schemas
└── seeders/
    ├── AdminSeeder.php      # Default superadmin account
    └── CollegeDepartmentCourseSeeder.php

resources/views/
├── admin/                   # Admin panel views (dashboard, colleges, departments, courses, subjects, teachers)
├── teacher/                 # Teacher dashboard
├── student/                 # Student dashboard
└── auth/                    # Login & registration pages

routes/
└── web.php                  # All routes grouped by role prefix
```

---

## 🗃️ Database Schema

```
colleges        → id, name, short_name, status
departments     → id, college_id, name, short_name, status
courses         → id, department_id, name, short_name, status
classes         → id, course_id, name (FY/SY/TY), label, status
subjects        → id, class_id, name, code, type (theory/practical/elective), status
users           → id, name, email, password, role, status, profile_photo,
                  college_id, department_id, course_id, class_id,
                  roll_number, year, employee_id, phone, is_approved
```

---

## ⚙️ Installation & Setup

### Prerequisites

- PHP 8.2+
- Composer
- Node.js & npm
- MySQL (WAMP / XAMPP / Laravel Herd)

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/Sudarshan7651/ITSystem.git
cd ITSystem

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Create environment file
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Configure your database in .env
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=

# 7. Run migrations
php artisan migrate

# 8. Seed the database (creates default admin + sample data)
php artisan db:seed

# 9. Build frontend assets
npm run build

# 10. Start the development server
php artisan serve
```

---

## 🔐 Default Credentials

| Role           | Email             | Password   |
| -------------- | ----------------- | ---------- |
| **Superadmin** | `admin@admin.com` | `password` |

> ⚠️ Change the default admin password immediately after first login in a production environment.

---

## 🌐 Application URLs

| Portal            | URL                                       |
| ----------------- | ----------------------------------------- |
| Home / Landing    | `http://localhost:8000/`                  |
| Admin Login       | `http://localhost:8000/admin/login`       |
| Admin Dashboard   | `http://localhost:8000/admin/dashboard`   |
| Teacher Login     | `http://localhost:8000/teacher/login`     |
| Teacher Dashboard | `http://localhost:8000/teacher/dashboard` |
| Student Login     | `http://localhost:8000/student/login`     |
| Student Register  | `http://localhost:8000/student/register`  |
| Student Dashboard | `http://localhost:8000/student/dashboard` |

---

## 📋 Admin Panel Routes

| Resource    | Routes               |
| ----------- | -------------------- |
| Colleges    | `/admin/colleges`    |
| Departments | `/admin/departments` |
| Courses     | `/admin/courses`     |
| Class Years | `/admin/classes`     |
| Subjects    | `/admin/subjects`    |
| Teachers    | `/admin/teachers`    |

---

## 🔒 Role & Middleware System

The application uses **session-based authentication** with custom middleware for role enforcement:

- `auth` — Ensures the user is logged in
- `admin` — Restricts access to admin users only
- `teacher` — Restricts access to teacher users only
- `student` — Restricts access to approved student users only

Students must be **approved by an admin** (`is_approved = 'approved'`) before they can log in and access their dashboard.

---

## 🎨 Design System

- **Theme:** Dark mode with custom glassmorphism elements
- **Font:** [Inter](https://fonts.google.com/specimen/Inter) via Google Fonts
- **Color Palette:** Dark backgrounds (`#0e0e10`, `#151517`) with white text and accent colors
- **Components:** Custom form cards, filter bars, badge pills, cascading dropdowns, type selector pills
- **Animations:** Subtle hover transitions on all interactive elements

---

## 📌 To-Do / Planned Features

- [ ] Student internship submission & tracking
- [ ] Teacher internship review & grading
- [ ] Teacher approval dashboard for student registrations
- [ ] Internship reports & export (PDF / Excel)
- [ ] Email notifications for approvals and updates
- [ ] Student ↔ Class Year assignment by Teacher

---

## 📄 License

This project is open-sourced under the [MIT License](LICENSE).
