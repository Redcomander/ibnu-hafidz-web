<style>
    /* Enhanced Custom Styles */
    :root {
        --primary-gradient: linear-gradient(to right, #4f46e5, #7c3aed);
        --secondary-gradient: linear-gradient(to right, #06b6d4, #3b82f6);
        --success-gradient: linear-gradient(to right, #10b981, #059669);
        --danger-gradient: linear-gradient(to right, #ef4444, #dc2626);
    }

    .student-card {
        transition: all 0.3s ease;
        border-radius: 1rem;
        overflow: hidden;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .student-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .animate-float {
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-15px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    .table-container {
        border-radius: 1rem;
        overflow: hidden;
    }

    .table-header {
        background: var(--primary-gradient);
    }

    .table-row {
        transition: all 0.2s ease;
    }

    .table-row:hover {
        background-color: rgba(79, 70, 229, 0.05);
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-active {
        background-color: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .status-inactive {
        background-color: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .status-pending {
        background-color: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .btn-action {
        transition: all 0.2s ease;
        @apply p-2 rounded-full;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        @apply bg-slate-100 dark:bg-slate-700;
    }

    .search-input {
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        border: 1px solid rgba(209, 213, 219, 0.5);
        background-color: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        transition: all 0.2s ease;
    }

    .search-input:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }

    .pagination-item {
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        margin: 0 0.25rem;
        transition: all 0.2s ease;
    }

    .pagination-item:hover:not(.active) {
        background-color: rgba(79, 70, 229, 0.1);
    }

    .pagination-item.active {
        background-color: #4f46e5;
        color: white;
    }

    /* New Styles */
    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
    }

    .dark .glass-card {
        background: rgba(30, 41, 59, 0.7);
        border: 1px solid rgba(30, 41, 59, 0.2);
    }

    .progress-bar {
        height: 8px;
        border-radius: 4px;
        background: #e2e8f0;
        overflow: hidden;
    }

    .dark .progress-bar {
        background: #334155;
    }

    .progress-value {
        height: 100%;
        border-radius: 4px;
        background: var(--primary-gradient);
        transition: width 0.5s ease;
    }

    .avatar-stack {
        display: flex;
        margin-left: 0.5rem;
    }

    .avatar-stack img {
        width: 2rem;
        height: 2rem;
        border-radius: 9999px;
        border: 2px solid white;
        margin-left: -0.5rem;
        object-fit: cover;
    }

    .dark .avatar-stack img {
        border-color: #1e293b;
    }

    .tooltip {
        position: relative;
    }

    .tooltip:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        padding: 0.5rem;
        background: #1e293b;
        color: white;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        white-space: nowrap;
        z-index: 10;
        margin-bottom: 0.5rem;
    }

    .dark .tooltip:hover::after {
        background: #f8fafc;
        color: #1e293b;
    }

    .filter-chip {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        background: #e2e8f0;
        border-radius: 9999px;
        font-size: 0.75rem;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
        transition: all 0.2s ease;
    }

    .dark .filter-chip {
        background: #334155;
    }

    .filter-chip:hover {
        background: #cbd5e1;
    }

    .dark .filter-chip:hover {
        background: #475569;
    }

    .filter-chip .close {
        margin-left: 0.5rem;
        width: 1rem;
        height: 1rem;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #94a3b8;
        color: white;
        font-size: 0.75rem;
        line-height: 1;
    }

    .dark .filter-chip .close {
        background: #64748b;
    }

    .pulse {
        position: relative;
    }

    .pulse::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 0.5rem;
        height: 0.5rem;
        background: currentColor;
        border-radius: 50%;
        box-shadow: 0 0 0 0 currentColor;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(currentColor, 0.7);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(currentColor, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(currentColor, 0);
        }
    }

    /* Student Detail Modal Styles */
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 50;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow-y: auto;
        overflow-x: hidden;
        transition: all 0.3s ease-in-out;
        visibility: hidden;
        opacity: 0;
    }

    .modal.show {
        visibility: visible;
        opacity: 1;
    }

    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }

    .modal-content {
        position: relative;
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        width: 100%;
        max-width: 900px;
        max-height: 90vh;
        overflow-y: auto;
        transform: translateY(20px);
        transition: transform 0.3s ease-in-out;
    }

    .dark .modal-content {
        background-color: #1e293b;
        color: #f8fafc;
    }

    .modal.show .modal-content {
        transform: translateY(0);
    }

    .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .dark .modal-header {
        border-bottom-color: #334155;
    }

    .modal-body {
        padding: 1.5rem;
        overflow-y: auto;
    }

    .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .dark .modal-footer {
        border-top-color: #334155;
    }

    .modal-close {
        background: transparent;
        border: none;
        color: #64748b;
        cursor: pointer;
        padding: 0.5rem;
        transition: color 0.2s ease;
    }

    .modal-close:hover {
        color: #ef4444;
    }

    .student-detail-section {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .dark .student-detail-section {
        border-bottom-color: #334155;
    }

    .student-detail-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .student-detail-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 1rem;
    }

    @media (min-width: 640px) {
        .student-detail-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 768px) {
        .student-detail-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    .student-detail-item {
        margin-bottom: 0.75rem;
    }

    .student-detail-label {
        font-size: 0.75rem;
        font-weight: 500;
        color: #64748b;
        margin-bottom: 0.25rem;
    }

    .dark .student-detail-label {
        color: #94a3b8;
    }

    .student-detail-value {
        font-size: 0.875rem;
        color: #1e293b;
    }

    .dark .student-detail-value {
        color: #f1f5f9;
    }

    .student-profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .student-profile-photo {
        width: 5rem;
        height: 5rem;
        border-radius: 9999px;
        background-color: #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 600;
        color: #64748b;
        overflow: hidden;
    }

    .dark .student-profile-photo {
        background-color: #334155;
        color: #94a3b8;
    }

    .student-profile-info {
        margin-left: 1.5rem;
    }

    .student-profile-name {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.25rem;
    }

    .dark .student-profile-name {
        color: #f8fafc;
    }

    .student-profile-meta {
        font-size: 0.875rem;
        color: #64748b;
    }

    .dark .student-profile-meta {
        color: #94a3b8;
    }

    .student-profile-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        margin-top: 0.5rem;
    }

    .student-profile-badge.active {
        background-color: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .student-profile-badge.inactive {
        background-color: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .student-profile-badge.pending {
        background-color: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .tab-container {
        margin-top: 1.5rem;
    }

    .tab-buttons {
        display: flex;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 1.5rem;
        overflow-x: auto;
        scrollbar-width: none;
    }

    .tab-buttons::-webkit-scrollbar {
        display: none;
    }

    .dark .tab-buttons {
        border-bottom-color: #334155;
    }

    .tab-button {
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #64748b;
        border-bottom: 2px solid transparent;
        cursor: pointer;
        white-space: nowrap;
    }

    .dark .tab-button {
        color: #94a3b8;
    }

    .tab-button.active {
        color: #4f46e5;
        border-bottom-color: #4f46e5;
    }

    .dark .tab-button.active {
        color: #818cf8;
        border-bottom-color: #818cf8;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* Mass selection checkbox styles */
    .select-checkbox {
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 0.25rem;
        cursor: pointer;
        position: relative;
        appearance: none;
        border: 2px solid #cbd5e1;
        background-color: white;
        transition: all 0.2s ease;
    }

    .dark .select-checkbox {
        border-color: #475569;
        background-color: #1e293b;
    }

    .select-checkbox:checked {
        background-color: #4f46e5;
        border-color: #4f46e5;
    }

    .dark .select-checkbox:checked {
        background-color: #6366f1;
        border-color: #6366f1;
    }

    .select-checkbox:checked::after {
        content: '';
        position: absolute;
        top: 40%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(45deg);
        width: 0.25rem;
        height: 0.5rem;
        border-bottom: 2px solid white;
        border-right: 2px solid white;
    }

    /* Progress bar and container styles */
    .progress-container {
        margin-bottom: 1rem;
    }

    .progress-title {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .progress-percentage {
        font-weight: 600;
        color: #4f46e5;
    }

    .dark .progress-percentage {
        color: #818cf8;
    }

    /* Circular chart styles */
    .circular-chart {
        display: block;
        margin: 0 auto;
        max-width: 100%;
    }

    .circle-bg {
        fill: none;
        stroke: #e2e8f0;
        stroke-width: 3;
    }

    .dark .circle-bg {
        stroke: #334155;
    }

    .circle {
        fill: none;
        stroke-width: 3;
        stroke-linecap: round;
        animation: progress 1s ease-out forwards;
    }

    @keyframes progress {
        0% {
            stroke-dasharray: 0 100;
        }
    }

    /* Responsive improvements */
    @media (max-width: 640px) {
        .student-card {
            padding: 1rem;
        }

        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .modal-content {
            max-width: 95%;
            margin: 0 10px;
        }

        .student-profile-header {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .student-profile-info {
            margin-left: 0;
            margin-top: 1rem;
        }
    }
</style>
