/**
 * Dashboard JavaScript - Complete Dashboard Functionality
 * Modern responsive dashboard with charts, analytics, and real-time features
 */

// Theme Management
function toggleTheme() {
    const html = document.documentElement;
    const currentTheme = html.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
}

// Initialize theme from localStorage
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    initializeDashboard();
});

// Initialize Dashboard
function initializeDashboard() {
    initializeCharts();
    initializeCalendar();
    initializeRealtimeMetrics();
    initializeSparklines();
}

// Charts Initialization
function initializeCharts() {
    // Check if Chart.js is loaded
    if (typeof Chart === 'undefined') {
        console.warn('Chart.js not loaded');
        return;
    }

    // Financial Chart
    const financialCtx = document.getElementById('financialChart');
    if (financialCtx) {
        new Chart(financialCtx, {
            type: 'line',
            data: {
                labels: generateMonthLabels(12),
                datasets: [
                    {
                        label: 'Dons',
                        data: generateRandomData(12, 2000, 8000),
                        borderColor: '#7B61FF',
                        backgroundColor: 'rgba(123, 97, 255, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Budgets',
                        data: generateRandomData(12, 3000, 10000),
                        borderColor: '#00C4CC',
                        backgroundColor: 'rgba(0, 196, 204, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Dépenses',
                        data: generateRandomData(12, 1500, 6000),
                        borderColor: '#FF6B9D',
                        backgroundColor: 'rgba(255, 107, 157, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { font: { size: 12 } }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { drawBorder: false }
                    }
                }
            }
        });
    }

    // Modules Chart
    const modulesCtx = document.getElementById('modulesChart');
    if (modulesCtx) {
        new Chart(modulesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Membres', 'Projets', 'Événements', 'Finances', 'RH', 'CRM'],
                datasets: [{
                    data: [25, 20, 15, 20, 15, 5],
                    backgroundColor: [
                        '#7B61FF',
                        '#00C4CC',
                        '#FF6B9D',
                        '#00D4AA',
                        '#FFD23F',
                        '#3742FA'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }

    // HR Chart
    const hrCtx = document.getElementById('hrChart');
    if (hrCtx) {
        new Chart(hrCtx, {
            type: 'bar',
            data: {
                labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                datasets: [{
                    label: 'Présences',
                    data: [12, 15, 13, 14, 16, 8, 5],
                    backgroundColor: '#00D4AA'
                }, {
                    label: 'Absences',
                    data: [2, 1, 3, 2, 1, 4, 6],
                    backgroundColor: '#FF4757'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: { x: { stacked: true }, y: { stacked: true } }
            }
        });
    }

    // Projects Chart
    const projectsCtx = document.getElementById('projectsChart');
    if (projectsCtx) {
        new Chart(projectsCtx, {
            type: 'bar',
            data: {
                labels: ['En cours', 'Complétés', 'En retard', 'En attente'],
                datasets: [{
                    label: 'Projets',
                    data: [8, 12, 2, 5],
                    backgroundColor: ['#FFD23F', '#00D4AA', '#FF4757', '#3742FA']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true
            }
        });
    }

    // Engagement Chart
    const engagementCtx = document.getElementById('engagementChart');
    if (engagementCtx) {
        new Chart(engagementCtx, {
            type: 'radar',
            data: {
                labels: ['Événements', 'Projets', 'Donations', 'Commentaires', 'Partages', 'Votes'],
                datasets: [{
                    label: 'Engagement',
                    data: [65, 59, 90, 81, 56, 55],
                    borderColor: '#7B61FF',
                    backgroundColor: 'rgba(123, 97, 255, 0.2)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true
            }
        });
    }

    // Events Chart
    const eventsCtx = document.getElementById('eventsChart');
    if (eventsCtx) {
        new Chart(eventsCtx, {
            type: 'line',
            data: {
                labels: generateMonthLabels(12),
                datasets: [{
                    label: 'Participation',
                    data: generateRandomData(12, 50, 300),
                    borderColor: '#FF6B9D',
                    backgroundColor: 'rgba(255, 107, 157, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true
            }
        });
    }
}

// Sparklines Initialization
function initializeSparklines() {
    if (typeof Chart === 'undefined') return;

    const sparklineCharts = [
        { id: 'growthSparkline', data: [15, 18, 16, 20, 22, 25, 28] },
        { id: 'efficiencySparkline', data: [85, 87, 86, 89, 88, 90, 92] },
        { id: 'satisfactionSparkline', data: [4.2, 4.3, 4.1, 4.4, 4.3, 4.5, 4.6] },
        { id: 'roiSparkline', data: [120, 130, 125, 140, 135, 150, 160] }
    ];

    sparklineCharts.forEach(spark => {
        const ctx = document.getElementById(spark.id);
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['J1', 'J2', 'J3', 'J4', 'J5', 'J6', 'J7'],
                    datasets: [{
                        data: spark.data,
                        borderColor: '#7B61FF',
                        backgroundColor: 'rgba(123, 97, 255, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: { legend: { display: false } },
                    scales: { x: { display: false }, y: { display: false } }
                }
            });
        }
    });
}

// Calendar Initialization
function initializeCalendar() {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    const now = new Date();
    const year = now.getFullYear();
    const month = now.getMonth();

    calendarEl.innerHTML = generateCalendarHTML(year, month);
    addCalendarEventListeners();
}

// Generate Calendar HTML
function generateCalendarHTML(year, month) {
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const prevLastDay = new Date(year, month, 0);

    const firstDayOfWeek = firstDay.getDay();
    const lastDateOfMonth = lastDay.getDate();
    const prevLastDate = prevLastDay.getDate();
    const nextDays = 7 - lastDay.getDay();

    const monthNames = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
        'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

    let html = `
        <div class="calendar-header">
            <h3>${monthNames[month]} ${year}</h3>
            <div class="calendar-nav">
                <button onclick="previousMonth()">&lt;</button>
                <button onclick="nextMonth()">&gt;</button>
            </div>
        </div>
        <div class="calendar-weekdays">
            <div>Lun</div><div>Mar</div><div>Mer</div><div>Jeu</div>
            <div>Ven</div><div>Sam</div><div>Dim</div>
        </div>
        <div class="calendar-dates">`;

    // Previous month days
    for (let i = firstDayOfWeek - 1; i >= 0; i--) {
        html += `<div class="prev-month-day">${prevLastDate - i}</div>`;
    }

    // Current month days
    for (let i = 1; i <= lastDateOfMonth; i++) {
        const isToday = i === new Date().getDate() && month === new Date().getMonth() && year === new Date().getFullYear();
        html += `<div class="calendar-day ${isToday ? 'today' : ''}">${i}</div>`;
    }

    // Next month days
    for (let i = 1; i <= nextDays; i++) {
        html += `<div class="next-month-day">${i}</div>`;
    }

    html += `</div>`;
    return html;
}

// Calendar Navigation
function previousMonth() {
    const now = new Date();
    now.setMonth(now.getMonth() - 1);
    initializeCalendar();
}

function nextMonth() {
    const now = new Date();
    now.setMonth(now.getMonth() + 1);
    initializeCalendar();
}

// Add Calendar Event Listeners
function addCalendarEventListeners() {
    const calendarDays = document.querySelectorAll('.calendar-day');
    calendarDays.forEach(day => {
        day.addEventListener('click', function() {
            calendarDays.forEach(d => d.classList.remove('selected'));
            this.classList.add('selected');
        });
    });
}

// Real-time Metrics
function initializeRealtimeMetrics() {
    setInterval(updateRealtimeMetrics, 5000);
}

function updateRealtimeMetrics() {
    const metrics = document.querySelectorAll('.metric-item');
    metrics.forEach(metric => {
        const value = metric.querySelector('.metric-value');
        if (value) {
            const currentValue = parseFloat(value.textContent);
            const change = (Math.random() - 0.5) * 10;
            value.textContent = (currentValue + change).toFixed(2);
        }
    });
}

// Dashboard Refresh
function refreshDashboard() {
    const btn = document.querySelector('.refresh-btn');
    btn.classList.add('spinning');
    setTimeout(() => {
        location.reload();
    }, 500);
}

// Export KPIs
function exportKPIs() {
    const data = {
        date: new Date().toLocaleDateString('fr-FR'),
        growth: document.querySelector('[data-metric="growth"]')?.textContent || 'N/A',
        efficiency: document.querySelector('[data-metric="efficiency"]')?.textContent || 'N/A',
        satisfaction: document.querySelector('[data-metric="satisfaction"]')?.textContent || 'N/A',
        roi: document.querySelector('[data-metric="roi"]')?.textContent || 'N/A'
    };

    const csv = `Date,Métrique,Valeur\n${Object.entries(data).map(([k, v]) => `${data.date},${k},${v}`).join('\n')}`;

    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `kpis-${data.date}.csv`;
    a.click();
}

// Change Time Range
function changeTimeRange(range) {
    console.log('Time range changed to:', range);
    // Refresh charts with new time range
    location.reload();
}

// Utility Functions
function generateMonthLabels(count) {
    const labels = [];
    const now = new Date();
    for (let i = count - 1; i >= 0; i--) {
        const date = new Date(now.getFullYear(), now.getMonth() - i, 1);
        labels.push(date.toLocaleDateString('fr-FR', { month: 'short' }));
    }
    return labels;
}

function generateRandomData(count, min, max) {
    const data = [];
    for (let i = 0; i < count; i++) {
        data.push(Math.floor(Math.random() * (max - min + 1)) + min);
    }
    return data;
}

// Chart Filter Buttons
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.chart-filter');
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            console.log('Filtre sélectionné:', this.getAttribute('data-type'));
        });
    });
});

// Animate elements on scroll
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in-up');
            observer.unobserve(entry.target);
        }
    });
});

document.querySelectorAll('.kpi-card, .chart-card').forEach(el => {
    observer.observe(el);
});
