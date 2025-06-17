        <!-- Sidebar Navigation -->
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-content">                <div class="sidebar-header">
                    <div class="admin-profile">
                        <img src="assets/img/admin-avatar.svg" alt="Admin" class="profile-img">
                        <div class="profile-info">
                            <h4><?php echo htmlspecialchars($_SESSION['name'] ?? 'Admin'); ?></h4>
                            <p>Administrator</p>
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
                            <a href="students.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'students.php' ? 'active' : ''; ?>">
                                <i class="fas fa-users"></i>
                                <span>Students</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="homeworks.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'homeworks.php' ? 'active' : ''; ?>">
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
                                <span>Answers</span>
                            </a>
                        </li>                        <li class="nav-item">
                            <a href="ebooks.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'ebooks.php' ? 'active' : ''; ?>">
                                <i class="fas fa-book-open"></i>
                                <span>E-Books</span>
                            </a>
                        </li>                    </ul>
                </div>
            </div>
        </nav>
