// Enhanced Student Management JavaScript with Real-time Search and Filtering
class StudentManager {
    constructor() {
        this.searchTimeout = null;
        this.currentStudentId = null;
        this.initializeEventListeners();
        this.loadModules();
    }

    initializeEventListeners() {
        // Real-time search with debouncing
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                clearTimeout(this.searchTimeout);
                this.searchTimeout = setTimeout(() => {
                    this.performSearch();
                }, 500); // 500ms delay
            });
        }

        // Real-time filtering for dropdowns
        const classFilter = document.getElementById('classFilter');
        const moduleFilter = document.getElementById('moduleFilter');

        if (classFilter) {
            classFilter.addEventListener('change', () => this.performSearch());
        }
        if (moduleFilter) {
            moduleFilter.addEventListener('change', () => this.performSearch());
        }

        // Clear filters button
        const clearButton = document.getElementById('clearFilters');
        if (clearButton) {
            clearButton.addEventListener('click', () => this.clearFilters());
        }

        // Set initial values from URL parameters
        this.setInitialFilters();
    }

    setInitialFilters() {
        const urlParams = new URLSearchParams(window.location.search);
        const searchInput = document.getElementById('searchInput');
        const classFilter = document.getElementById('classFilter');
        const moduleFilter = document.getElementById('moduleFilter');
        if (searchInput && urlParams.get('search')) {
            searchInput.value = urlParams.get('search');
        }
        if (classFilter && urlParams.get('class')) {
            classFilter.value = urlParams.get('class');
        }
        if (moduleFilter && urlParams.get('module')) {
            moduleFilter.value = urlParams.get('module');
        }
    }    loadModules() {
        // Fetch all modules and classes from the backend
        fetch('students.php', {
            method: 'POST',
            body: new URLSearchParams({ action: 'get_modules_and_classes' })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (Array.isArray(data.modules)) {
                    this.allModules = data.modules;
                    this.updateModuleFilter();
                }
                if (Array.isArray(data.classes)) {
                    this.allClasses = data.classes;
                    this.updateClassFilter();
                }
                // Update modules when class changes
                const classFilter = document.getElementById('classFilter');
                if (classFilter) {
                    classFilter.addEventListener('change', () => this.updateModuleFilter());
                }
            }
        })
        .catch(error => {
            console.error('Error fetching modules/classes:', error);
        });
    }

    updateClassFilter() {
        const classFilter = document.getElementById('classFilter');
        if (!classFilter || !this.allClasses) return;
        const currentValue = classFilter.value;
        // Remove all except the first option (All Classes)
        while (classFilter.children.length > 1) {
            classFilter.removeChild(classFilter.lastChild);
        }
        this.allClasses.forEach(cls => {
            const option = document.createElement('option');
            option.value = cls;
            option.textContent = cls;
            classFilter.appendChild(option);
        });
        // Restore previous value if possible
        if (currentValue) classFilter.value = currentValue;
    }    updateModuleFilter() {
        const classFilter = document.getElementById('classFilter');
        const moduleFilter = document.getElementById('moduleFilter');
        if (!moduleFilter) return;
        // Save current value
        const currentValue = moduleFilter.value;
        // Clear existing options except 'All Modules'
        while (moduleFilter.children.length > 1) {
            moduleFilter.removeChild(moduleFilter.lastChild);
        }
        // For now, show all modules regardless of class (unless you want to filter by class in PHP)
        const modules = this.allModules || [];
        modules.forEach(module => {
            const option = document.createElement('option');
            option.value = module;
            option.textContent = module;
            moduleFilter.appendChild(option);
        });
        // Restore previous value if possible
        if (currentValue) moduleFilter.value = currentValue;
    }    performSearch() {
        const searchInput = document.getElementById('searchInput');
        const classFilter = document.getElementById('classFilter');
        const moduleFilter = document.getElementById('moduleFilter');

        const searchTerm = searchInput ? searchInput.value : '';
        const classValue = classFilter ? classFilter.value : '';
        const moduleValue = moduleFilter ? moduleFilter.value : '';

        // Show loading indicator
        this.showLoadingIndicator();

        // Prepare form data
        const formData = new FormData();
        formData.append('action', 'filter_students');
        formData.append('search', searchTerm);
        formData.append('class', classValue);
        formData.append('module', moduleValue);

        // Perform AJAX request
        fetch('students.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.updateStudentsTable(data.students);
                if (data.count !== undefined) {
                    this.updateResultsCount(data.count);
                }
            } else {
                console.error('Filter request failed:', data.message || 'Unknown error');
                this.showErrorMessage('Error performing search. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error performing search:', error);
            this.showErrorMessage('Error performing search. Please try again.');
        })
        .finally(() => {
            this.hideLoadingIndicator();
        });
    }

    updateStudentsTable(students) {
        const tableBody = document.querySelector('#studentsTable tbody');
        if (!tableBody) return;

        // Clear existing rows
        tableBody.innerHTML = '';

        if (students.length === 0) {
            // Show no results message
            const noResultsRow = document.createElement('tr');
            noResultsRow.innerHTML = `
                <td colspan="10" class="text-center py-4">
                    <div class="text-muted">
                        <i class="fas fa-search fa-2x mb-2"></i>
                        <p>No students found matching your criteria.</p>
                    </div>
                </td>
            `;
            tableBody.appendChild(noResultsRow);
            return;
        }

        // Populate table with students
        students.forEach((student, index) => {
            const row = this.createStudentRow(student, index + 1);
            tableBody.appendChild(row);
        });
    }

    createStudentRow(student, serialNo) {
        const row = document.createElement('tr');
        
        const dob = student.dob ? new Date(student.dob).toLocaleDateString('en-GB', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        }) : 'Not Set';
        
        const registered = student.created_at ? new Date(student.created_at).toLocaleDateString('en-GB', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        }) : 'N/A';

        const statusClass = student.status === 'Active' ? 'success' : 
                           student.status === 'Pending' ? 'warning' : 'secondary';
        
        row.innerHTML = `
            <td>${serialNo}</td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="student-avatar me-2">
                        <i class="fas fa-user-circle fa-2x text-primary"></i>
                    </div>
                    <div>
                        <strong>${this.escapeHtml(student.student_name || "No Name")}</strong>
                    </div>
                </div>
            </td>
            <td>${this.escapeHtml(student.email || "")}</td>
            <td><span class="badge bg-info">${this.escapeHtml(student.class || "Not Assigned")}</span></td>
            <td><span class="badge bg-secondary">${this.escapeHtml(student.module || "No Module")}</span></td>
            <td>${dob}</td>
            <td>
                <small>
                    ${this.escapeHtml(student.parent_firstname || "")}
                    ${student.parent_surname ? this.escapeHtml(student.parent_surname) : ''}
                </small>
            </td>
            <td>
                <span class="badge bg-${statusClass}">
                    ${this.escapeHtml(student.status || "inactive")}
                </span>
            </td>
            <td>${registered}</td>            <td>
                <div class="btn-group">
                    <button class="btn-sm btn-view btn-tooltip" onclick="viewStudent(${student.id})" data-tooltip="View Details">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-sm btn-delete btn-tooltip" onclick="deleteStudent(${student.id})" data-tooltip="Delete Student">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        `;
        
        return row;
    }

    updateResultsCount(count) {
        let countElement = document.getElementById('resultsCount');
        if (!countElement) {
            // Create count element if it doesn't exist
            const cardHeader = document.querySelector('.card .card-body');
            if (cardHeader) {
                countElement = document.createElement('div');
                countElement.id = 'resultsCount';
                countElement.className = 'mb-3 text-muted';
                cardHeader.parentNode.insertBefore(countElement, cardHeader);
            }
        }
        
        if (countElement) {
            countElement.innerHTML = `
                <small><i class="fas fa-users"></i> Showing ${count} student${count !== 1 ? 's' : ''}</small>
            `;
        }
    }

    clearFilters() {
        // Clear all filter inputs
        const searchInput = document.getElementById('searchInput');
        const classFilter = document.getElementById('classFilter');
        const moduleFilter = document.getElementById('moduleFilter');

        if (searchInput) searchInput.value = '';
        if (classFilter) classFilter.value = '';
        if (moduleFilter) moduleFilter.value = '';

        // Update URL without parameters
        const url = new URL(window.location);
        url.search = '';
        window.history.pushState({}, '', url);

        // Perform search to refresh results
        this.performSearch();
    }

    showLoadingIndicator() {
        const tableBody = document.querySelector('#studentsTable tbody');
        if (tableBody) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="10" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 mb-0">Searching students...</p>
                    </td>
                </tr>
            `;
        }
    }

    hideLoadingIndicator() {
        // Loading indicator will be replaced by search results
    }

    showErrorMessage(message) {
        const tableBody = document.querySelector('#studentsTable tbody');
        if (tableBody) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="10" class="text-center py-4">
                        <div class="text-danger">
                            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                            <p>${this.escapeHtml(message)}</p>
                        </div>
                    </td>
                </tr>
            `;
        }
    }

    escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text ? text.replace(/[&<>"']/g, m => map[m]) : '';
    }
}

// Helper function to render a single enrollment card
function renderEnrollmentCard(enrollment, index) {
    const accessPeriod = enrollment.access_start && enrollment.access_end 
        ? new Date(enrollment.access_start).toLocaleDateString() + ' - ' + new Date(enrollment.access_end).toLocaleDateString()
        : (enrollment.access_start ? 'From ' + new Date(enrollment.access_start).toLocaleDateString() : 'No Access Period');

    const statusBadge = enrollment.payment_status === 'paid' ? 'bg-success' : 
                      enrollment.payment_status === 'pending' ? 'bg-warning text-dark' : 
                      enrollment.payment_status === 'failed' ? 'bg-danger' : 'bg-secondary';

    const enrolledDate = enrollment.created_at ? new Date(enrollment.created_at).toLocaleDateString('en-GB', { 
        day: '2-digit', 
        month: 'short', 
        year: 'numeric' 
    }) : 'N/A';

    return `
        <div class="enrollment-card card shadow-sm border-0 mb-4">
            <div class="enrollment-card-body card-body bg-white">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="enrollment-detail-row mb-3 d-flex align-items-center">
                            <span class="enrollment-detail-label fw-bold text-secondary me-2">
                                <i class="fas fa-chalkboard-teacher me-1"></i>Class:
                            </span>
                            <span class="enrollment-detail-value">
                                <span class="badge bg-info enrollment-badge fs-6">${enrollment.class || 'N/A'}</span>
                            </span>
                        </div>
                        <div class="enrollment-detail-row mb-3 d-flex align-items-center">
                            <span class="enrollment-detail-label fw-bold text-secondary me-2">
                                <i class="fas fa-book me-1"></i>Module:
                            </span>
                            <span class="enrollment-detail-value">
                                <span class="badge bg-secondary enrollment-badge fs-6">${enrollment.module || 'N/A'}</span>
                            </span>
                        </div>
                        <div class="enrollment-detail-row mb-3 d-flex align-items-center">
                            <span class="enrollment-detail-label fw-bold text-secondary me-2">
                                <i class="fas fa-pound-sign me-1"></i>Course Price:
                            </span>
                            <span class="enrollment-detail-value enrollment-price fw-bold fs-5">
                                £${enrollment.price ? parseFloat(enrollment.price).toFixed(2) : '0.00'}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="enrollment-detail-row mb-3 d-flex align-items-center">
                            <span class="enrollment-detail-label fw-bold text-secondary me-2">
                                <i class="fas fa-clock me-1"></i>Access Period:
                            </span>
                            <span class="enrollment-detail-value">
                                <small class="text-muted">${accessPeriod}</small>
                            </span>
                        </div>
                        <div class="enrollment-detail-row mb-3 d-flex align-items-center">
                            <span class="enrollment-detail-label fw-bold text-secondary me-2">
                                <i class="fas fa-credit-card me-1"></i>Payment Status:
                            </span>
                            <span class="enrollment-detail-value">
                                <span class="badge ${statusBadge} enrollment-badge fs-6">
                                    ${enrollment.payment_status ? enrollment.payment_status.toUpperCase() : 'N/A'}
                                </span>
                            </span>
                        </div>
                        <div class="enrollment-detail-row mb-0 d-flex align-items-center">
                            <span class="enrollment-detail-label fw-bold text-secondary me-2">
                                <i class="fas fa-calendar me-1"></i>Enrolled On:
                            </span>
                            <span class="enrollment-detail-value">
                                <span class="text-dark">${enrolledDate}</span>
                            </span>
                        </div>
                    </div>
                </div>
                <hr class="my-3">
                ${enrollment.transaction_id ? `
                    <div class="enrollment-transaction-id d-flex align-items-center justify-content-center py-2">
                        <i class="fas fa-receipt me-2 text-success"></i>
                        <strong class="text-success">Transaction ID: ${enrollment.transaction_id}</strong>
                    </div>
                ` : `
                    <div class="alert alert-warning mt-3 mb-0 d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <div>
                            <strong>No Transaction ID Available</strong><br>
                            <small class="text-muted">This enrollment may not have been completed or processed yet.</small>
                        </div>
                    </div>
                `}
            </div>
        </div>
    `;
}


// Global functions for view and delete (called from table buttons)
function viewStudent(id) {
    fetch('students.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=view&id=' + id
    })
    .then(response => response.json())
    .then(data => {
        if (data) {
            // Populate Personal Details
            document.getElementById('view_fullname').textContent = data.student_name || 'N/A';
            document.getElementById('view_fname').textContent = data.fname || 'N/A';
            document.getElementById('view_surname').textContent = data.surname || 'N/A';
            document.getElementById('view_dob').textContent = data.dob ? new Date(data.dob).toLocaleDateString() : 'N/A';
            document.getElementById('view_gender').textContent = data.gender || 'N/A';
            document.getElementById('view_email').textContent = data.email || 'N/A';
            document.getElementById('view_gender_dob').textContent = (data.gender || 'N/A') + ', ' + (data.dob ? new Date(data.dob).toLocaleDateString() : 'N/A');
            
            // Populate Course Information
            document.getElementById('view_class').textContent = data.class || 'Not Assigned';
            document.getElementById('view_module').textContent = data.module || 'No Module';
            document.getElementById('view_price').textContent = data.price ? parseFloat(data.price).toFixed(2) : '0.00';
            document.getElementById('view_status').textContent = data.status || 'Inactive';
            document.getElementById('view_registered').textContent = data.created_at ? new Date(data.created_at).toLocaleDateString() : 'N/A';
            
            // Populate Parent's Details
            document.getElementById('view_parent_fname').textContent = data.parent_firstname || 'N/A';
            document.getElementById('view_parent_surname').textContent = data.parent_surname || 'N/A';
            document.getElementById('view_address').textContent = data.address || 'N/A';
            document.getElementById('view_parent_email').textContent = data.email || 'N/A';
            document.getElementById('view_phone').textContent = data.phone || 'N/A';
            
            // Populate Terms & Conditions
            const termsAccepted = data.yesorno === 'yes';
            const termsSpan = document.getElementById('view_terms_accepted');
            termsSpan.textContent = termsAccepted ? 'YES' : 'NO';
            termsSpan.className = 'badge fs-6 ' + (termsAccepted ? 'bg-success' : 'bg-danger');            // Populate Enrollment Details with Card-based Layout
            const enrollmentDiv = document.getElementById('enrollment_details');
            if (data.enrollments && data.enrollments.length > 0) {
                let enrollmentHtml = '';
                data.enrollments.forEach((enrollment, index) => {
                    enrollmentHtml += renderEnrollmentCard(enrollment, index);
                });
                enrollmentDiv.innerHTML = enrollmentHtml;
            } else {
                enrollmentDiv.innerHTML = `
                    <div class="alert alert-info d-flex align-items-center">
                        <i class="fas fa-info-circle me-2"></i>
                        <div>
                            <strong>No enrollment records found</strong><br>
                            <small class="text-muted">This student has not enrolled in any courses yet.</small>
                        </div>
                    </div>
                `;
            }
            
            // Populate Login Credentials (if available)
            const passwordElement = document.getElementById('view_password');
            if (passwordElement) {
                passwordElement.textContent = data.password || 'N/A';
            }
            
            // Show the modal
            new bootstrap.Modal(document.getElementById('studentViewModal')).show();
        } else {
            console.error('No student data received');
            alert('Error: No student data found');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error loading student details. Please try again.');
    });
}

function deleteStudent(id) {
    swal({
        title: 'Are you sure?',
        text: 'Are you sure you want to delete this student? This action cannot be undone.',
        icon: 'warning',
        buttons: [true, 'Delete'],
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=delete&id=' + id
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Refresh the student list
                    if (window.studentManager) {
                        window.studentManager.performSearch();
                    } else {
                        location.reload();
                    }
                    swal({
                        title: 'Deleted!',
                        text: data.message,
                        icon: 'success',
                        timer: 1800,
                        buttons: false
                    });
                } else {
                    swal('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                swal('Error', 'An error occurred while deleting the student', 'error');
            });
        }
    });
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.studentManager = new StudentManager();
    
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
