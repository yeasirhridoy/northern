# University Admission Portal - Requirements Document

## 1. Introduction
The University Admission Portal is a web-based application designed to streamline the student admission process. It serves two primary user groups: Applicants (students) and Administrators (university staff). The system handles the entire lifecycle from application submission to admission confirmation.

## 2. Technology Stack
- **Framework:** Laravel 12
- **Admin Panel:** Filament v4
- **Frontend (Applicant):** Blade + Livewire + Volt + Tailwind CSS + Flux UI
- **Database:** MySQL/PostgreSQL

## 3. User Roles
1.  **Applicant:** Prospective students applying for admission.
2.  **Administrator:** University staff managing the admission process via Filament.

## 4. Functional Requirements

### 4.1. Admission Session Management (Admin)
- Admin can create and manage **Admission Sessions** (e.g., "Fall 2025", "Spring 2026").
- Sessions have start and end dates for applications.
- Only one session can be active for applications at a time (or multiple, if configured).

### 4.2. Department & Subject Management (Admin)
- Manage **Departments** (e.g., Engineering, Arts).
- Manage **Subjects/Majors** available for admission within departments.
- Define seat capacity per subject.

### 4.3. Applicant Portal (Frontend)
- **Authentication:**
    - Registration (Name, Email, Password).
    - Login & Forgot Password (using Fortify).
- **Dashboard:**
    - View current application status (Draft, Submitted, Under Review, Waitlisted, Offered, Rejected).
    - View remarks from admins.
- **Application Process:**
    - **Step 1: Personal Information** (Name, Father's Name, Mother's Name, DOB, Address, Contact).
    - **Step 2: SSC/Equivalent Information** (Board, Roll, Registration, Year, GPA).
    - **Step 3: HSC/Equivalent Information** (Board, Roll, Registration, Year, GPA, Group - Science/Arts/Commerce).
    - **Step 4: Subject Preference** (Select prioritized list of preferred subjects).
    - **Step 5: Review & Submit**.
- **Post-Submission:**
    - **Waitlist View:** If waitlisted, show position.
    - **Offer Acceptance:** If offered, button to "Accept Admission" or "Decline".
    - **Fee Payment:** (Placeholder) Instructions for Bank/Mobile Banking (bKash/Nagad) payment.

### 4.4. Application Evaluation (Admin)
- **Application List:** Filterable by Session, Status, GPA, or Subject Preference.
- **Detail View:** View all applicant data (SSC/HSC results).
- **Evaluation Actions:**
    - **Calculate Score:** System can auto-calculate a merit score based on (SSC GPA * X) + (HSC GPA * Y).
    - **Status Change:** Move application to 'Waitlist', 'Offered', or 'Rejected'.
    - **Subject Assignment:** Assign a specific subject based on merit and preference.
    - **Comments:** Internal notes for other admins.

### 4.5. Waiting List Management
- Automatic or manual handling of the waiting list.
- Ability to promote a waitlisted candidate to 'Offered' if a seat opens up.

### 4.6. Admission Confirmation
- Track which students have accepted the offer.
- Verify payment/enrollment steps.
- Final "Enrolled" status.

## 5. Database Schema (High-Level)

- `users` (Standard Laravel auth)
- `admission_sessions` (name, start_date, end_date, is_active)
- `departments` (name, code)
- `subjects` (department_id, name, capacity)
- `applications` (user_id, session_id, status, evaluation_score, assigned_subject_id)
- `application_details` (personal_info, academic_history - JSON or separate tables)
- `application_preferences` (application_id, subject_id, priority_order)

## 6. Milestones
1.  **Setup:** Project initialization, Database design, Filament installation.
2.  **Admin Core:** Session & Subject management.
3.  **Applicant Core:** Authentication & Profile.
4.  **Application Logic:** Multi-step form & Submission.
5.  **Evaluation System:** Admin review interface & Status workflows.
6.  **Waitlist & Confirmation:** Logic for seat allocation.
7.  **Final Polish:** Dashboards, UI cleanup (Flux UI), Testing.
