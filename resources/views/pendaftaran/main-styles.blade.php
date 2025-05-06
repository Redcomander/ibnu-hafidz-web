<style>
    /* Unique hero style for pendaftaran page */
    .hero-pendaftaran {
        background: linear-gradient(135deg, #2e7d32 0%, #4CAF50 100%);
        position: relative;
        overflow: hidden;
    }

    .hero-pendaftaran::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        z-index: 0;
    }

    .hero-circles {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        overflow: hidden;
        z-index: 1;
    }

    .hero-circle {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
    }

    .hero-circle-1 {
        width: 300px;
        height: 300px;
        top: -100px;
        left: -100px;
        animation: float 8s ease-in-out infinite;
    }

    .hero-circle-2 {
        width: 200px;
        height: 200px;
        top: 50%;
        right: -50px;
        animation: float 12s ease-in-out infinite;
    }

    .hero-circle-3 {
        width: 150px;
        height: 150px;
        bottom: -50px;
        left: 30%;
        animation: float 10s ease-in-out infinite;
    }

    .gradient-text {
        background: linear-gradient(90deg, #2e7d32, #4CAF50);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Form styles */
    .form-container {
        background-color: white;
        border-radius: 1rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        position: relative;
        z-index: 10;
        transition: transform 0.5s ease, box-shadow 0.5s ease;
    }

    .form-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.05);
    }

    .form-header {
        background: linear-gradient(90deg, #2e7d32, #4CAF50);
        padding: 1.5rem;
        color: white;
    }

    .form-body {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #374151;
    }

    .form-input,
    .form-textarea,
    .form-select {
        transition: all 0.3s ease;
    }

    .form-input:focus,
    .form-textarea:focus,
    .form-select:focus {
        transform: translateY(-2px);
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #D1D5DB;
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: #4CAF50;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.2);
    }

    .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #D1D5DB;
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: white;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1em;
    }

    .form-select:focus {
        outline: none;
        border-color: #4CAF50;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.2);
    }

    .form-textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #D1D5DB;
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        min-height: 100px;
        resize: vertical;
    }

    .form-textarea:focus {
        outline: none;
        border-color: #4CAF50;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.2);
    }

    .submit-btn {
        background: linear-gradient(90deg, #2e7d32, #4CAF50);
        color: white;
        font-weight: 600;
        padding: 0.875rem 2rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-block;
        text-align: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        position: relative;
        overflow: hidden;
    }

    .submit-btn::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0));
        animation: shimmer 3s infinite;
        z-index: 1;
    }

    .submit-btn:hover {
        background: linear-gradient(90deg, #2e7d32, #388e3c);
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .submit-btn:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.5);
    }

    .required-field::after {
        content: '*';
        color: #EF4444;
        margin-left: 0.25rem;
    }

    .info-card {
        background-color: #F3F4F6;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-card-title {
        font-weight: 600;
        font-size: 1.25rem;
        color: #1F2937;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }

    .info-card-title svg {
        margin-right: 0.5rem;
        color: #4CAF50;
    }

    .info-card-text {
        color: #4B5563;
        margin-bottom: 0.5rem;
    }

    .radio-group {
        display: flex;
        gap: 1.5rem;
    }

    .radio-option {
        display: flex;
        align-items: center;
    }

    .radio-input {
        margin-right: 0.5rem;
        width: 1rem;
        height: 1rem;
        accent-color: #4CAF50;
    }

    /* Steps indicator */
    .steps-container {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2rem;
        position: relative;
    }

    .steps-container::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #E5E7EB;
        transform: translateY(-50%);
        z-index: 1;
    }

    .step {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        background-color: white;
        border: 2px solid #E5E7EB;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: #6B7280;
        position: relative;
        z-index: 2;
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .step:hover {
        transform: scale(1.1) translateY(-5px);
    }

    .step.active {
        background-color: #4CAF50;
        border-color: #4CAF50;
        color: white;
    }

    .step.completed {
        background-color: #4CAF50;
        border-color: #4CAF50;
        color: white;
    }

    .step-label {
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: #6B7280;
        white-space: nowrap;
    }

    .step.active .step-label,
    .step.completed .step-label {
        color: #4CAF50;
        font-weight: 500;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .form-body {
            padding: 1.5rem;
        }

        .radio-group {
            flex-direction: column;
            gap: 0.75rem;
        }
    }

    /* Modern contact button styles */
    .contact-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        min-width: 200px;
    }

    .contact-btn-primary {
        background: white;
        color: #2e7d32;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
        border: 2px solid white;
    }

    .contact-btn-primary:hover {
        background: rgba(255, 255, 255, 0.9);
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    }

    .contact-btn-secondary {
        background: transparent;
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.8);
    }

    .contact-btn-secondary:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        border-color: white;
    }

    .contact-btn svg {
        flex-shrink: 0;
    }

    .contact-btn::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0) 70%);
        transform: scale(0);
        opacity: 0;
        transition: transform 0.5s ease, opacity 0.5s ease;
    }

    .contact-btn:hover::after {
        transform: scale(1);
        opacity: 1;
    }

    .contact-btn .btn-content {
        position: relative;
        z-index: 2;
    }

    /* Enhanced animations */
    @keyframes float {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-20px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    @keyframes pulse-ring {
        0% {
            transform: scale(0.8);
            opacity: 0.8;
        }

        50% {
            transform: scale(1);
            opacity: 0.5;
        }

        100% {
            transform: scale(0.8);
            opacity: 0.8;
        }
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }

        100% {
            background-position: 1000px 0;
        }
    }

    .hero-pendaftaran::after {
        content: '';
        position: absolute;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        top: 30%;
        left: 20%;
        animation: pulse-ring 6s ease-in-out infinite;
        z-index: 1;
    }

    /* Accordion styles */
    .accordion-item {
        transition: all 0.3s ease;
    }

    .accordion-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .accordion-header {
        transition: background-color 0.3s ease;
    }

    .accordion-header:hover {
        background-color: rgba(76, 175, 80, 0.05);
    }

    .accordion-header.active {
        background-color: rgba(76, 175, 80, 0.1);
    }

    .accordion-icon {
        transition: transform 0.3s ease;
    }

    .accordion-header.active .accordion-icon {
        transform: rotate(180deg);
    }

    .accordion-content {
        transition: max-height 0.5s ease-in-out;
    }

    .accordion-content.active {
        max-height: 1000px;
    }

    /* Animated background for CTA */
    .cta-bg-animation {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(-45deg, rgba(46, 125, 50, 0.3), rgba(76, 175, 80, 0.3), rgba(46, 125, 50, 0.3), rgba(76, 175, 80, 0.3));
        background-size: 400% 400%;
        animation: gradient 15s ease infinite;
        z-index: -1;
    }

    @keyframes gradient {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    /* Loading state styles */
    .btn-loading {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .hidden {
        display: none;
    }
</style>
