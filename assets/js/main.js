// Main JavaScript file for CRUD ASBL-ONG System

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initDropdowns();
    initFormValidation();
    initConfirmations();
    initSearch();
});

// Dropdown menus
function initDropdowns() {
    const dropdowns = document.querySelectorAll('.dropdown');

    dropdowns.forEach(dropdown => {
        const toggle = dropdown.querySelector('.dropdown-toggle');

        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            dropdown.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });
    });
}

// Form validation
function initFormValidation() {
    const forms = document.querySelectorAll('form[data-validate]');

    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(form)) {
                e.preventDefault();
            }
        });
    });
}

function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            showFieldError(field, 'Ce champ est obligatoire');
            isValid = false;
        } else {
            clearFieldError(field);
        }
    });

    // Email validation
    const emailFields = form.querySelectorAll('input[type="email"]');
    emailFields.forEach(field => {
        if (field.value && !isValidEmail(field.value)) {
            showFieldError(field, 'Adresse email invalide');
            isValid = false;
        }
    });

    // Date validation
    const dateFields = form.querySelectorAll('input[type="date"]');
    dateFields.forEach(field => {
        if (field.value && !isValidDate(field.value)) {
            showFieldError(field, 'Date invalide');
            isValid = false;
        }
    });

    return isValid;
}

function showFieldError(field, message) {
    clearFieldError(field);

    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    errorDiv.style.color = '#dc3545';
    errorDiv.style.fontSize = '0.875rem';
    errorDiv.style.marginTop = '0.25rem';

    field.parentNode.appendChild(errorDiv);
    field.style.borderColor = '#dc3545';
}

function clearFieldError(field) {
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    field.style.borderColor = '#ced4da';
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidDate(dateString) {
    const date = new Date(dateString);
    return date instanceof Date && !isNaN(date);
}

// Confirmation dialogs
function initConfirmations() {
    const confirmLinks = document.querySelectorAll('a[data-confirm], button[data-confirm]');

    confirmLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const message = this.getAttribute('data-confirm') || 'Êtes-vous sûr ?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });
}

// Search functionality
function initSearch() {
    const searchInputs = document.querySelectorAll('input[data-search]');

    searchInputs.forEach(input => {
        let timeout;
        input.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                performSearch(this);
            }, 300);
        });
    });
}

function performSearch(input) {
    const query = input.value.toLowerCase();
    const target = input.getAttribute('data-search');
    const rows = document.querySelectorAll(target);

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(query) ? '' : 'none';
    });
}

// Utility functions
function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    alertDiv.setAttribute('role', 'alert');

    const container = document.querySelector('.container');
    container.insertBefore(alertDiv, container.firstChild);

    // Auto-hide after 5 seconds
    setTimeout(() => {
        alertDiv.style.opacity = '0';
        setTimeout(() => alertDiv.remove(), 300);
    }, 5000);
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'EUR'
    }).format(amount);
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('fr-FR');
}

// AJAX helper
function ajaxRequest(url, method = 'GET', data = null) {
    return fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: data ? JSON.stringify(data) : null
    })
    .then(response => response.json())
    .catch(error => {
        console.error('AJAX Error:', error);
        showAlert('Erreur de communication avec le serveur', 'error');
    });
}