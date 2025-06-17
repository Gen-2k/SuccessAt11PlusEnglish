<!-- Sidebar Navigation -->
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-content">
                <div class="sidebar-header">
                    <div class="student-profile">
                        <img src="assets/img/student-avatar.svg" alt="Student" class="profile-img">
                        <div class="profile-info">
                            <h4><?php echo htmlspecialchars($current_student['name'] ?? 'Student'); ?></h4>
                            <p>Student</p>
                        </div>
                    </div>
                </div>
                
                <div class="sidebar-menu">
                    <ul class="nav-menu">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                                <i class="fas fa-home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="homework.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'homework.php' ? 'active' : ''; ?>">
                                <i class="fas fa-book"></i>
                                <span>Homework</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="activities.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'activities.php' ? 'active' : ''; ?>">
                                <i class="fas fa-play-circle"></i>
                                <span>Activities</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="answers.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'answers.php' ? 'active' : ''; ?>">
                                <i class="fas fa-check-circle"></i>
                                <span>Answer Sheets</span>
                            </a>
                        </li>
                          <li class="nav-item">
                            <a href="ebooks.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'ebooks.php' ? 'active' : ''; ?>">
                                <i class="fas fa-book-open"></i>
                                <span>E-Books</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
