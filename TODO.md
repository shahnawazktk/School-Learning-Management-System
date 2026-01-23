# TODO: Create Eloquent Models for LMS Tables with Relations

## Steps to Complete:
- [ ] Create School model: No relations.
- [ ] Create Grade model: belongsTo School.
- [ ] Create Subject model: No relations.
- [ ] Create Course model: belongsTo Subject, belongsTo User (teacher).
- [ ] Create Assignment model: belongsTo Course, belongsTo User (teacher).
- [ ] Create GradeScore model: Check migration for fields and relations.
- [ ] Create Timetable model: Check migration for fields and relations.
- [ ] Create Resource model: Check migration for fields and relations.
- [ ] Create Question model: Check migration for fields and relations.
- [ ] Create Enrollment model: Check migration for fields and relations.
- [ ] Create Attendance model: Check migration for fields and relations.
- [ ] Create Announcement model: Check migration for fields and relations.
- [ ] Create Exam model: Check migration for fields and relations.
- [ ] Create Submission model: Check migration for fields and relations.
- [ ] Create Parent model: belongsTo User.
- [ ] Create Answer model: Check migration for fields and relations.
- [ ] Create Admin model: belongsTo User.
- [ ] Create Teacher model: belongsTo User.
- [ ] Create Student model: belongsTo User, belongsTo Grade.
- [ ] Update User model: Add role-based relationships to Admin, Teacher, Student, Parent.
- [ ] Test relations and models.
