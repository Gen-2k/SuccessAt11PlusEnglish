<?php
// Dashboard Statistics Queries using existing mysqli connection
$conn = getDBConnection();

// Get total students (excluding admin user)
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM students WHERE role != 'admin'");
$totalStudents = mysqli_fetch_assoc($result)['total'];

// Get total paid students (students who have paid and registered)
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM students WHERE role = 'student'");
$totalActiveStudents = mysqli_fetch_assoc($result)['total'];

// Get total homeworks
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM resources WHERE resource_type = 'homework'");
$totalHomeworks = mysqli_fetch_assoc($result)['total'];

// Get total activities
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM resources WHERE resource_type = 'activities'");
$totalActivities = mysqli_fetch_assoc($result)['total'];

// Get total answers
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM resources WHERE resource_type = 'answers'");
$totalAnswers = mysqli_fetch_assoc($result)['total'];

// Get total ebooks
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM ebooks");
$totalEbooks = mysqli_fetch_assoc($result)['total'];

// Get total newsletter subscribers
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM newsletter");
$totalNewsletter = mysqli_fetch_assoc($result)['total'];

// Get recent students (all registered students)
$recentStudents = mysqli_query($conn, "SELECT fname, surname, email, role, created_at FROM students ORDER BY created_at DESC LIMIT 5");

// Get recent student registrations (same as recent students since users only register after payment)
$recentRegistrations = mysqli_query($conn, "SELECT fname, surname, email, created_at FROM students WHERE role = 'student' ORDER BY created_at DESC LIMIT 5");
?>
