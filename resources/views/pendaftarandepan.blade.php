@extends('layouts.main-navigation')

@section('title', 'Pendaftaran Calon Santri Baru')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        /* Form validation styles */
        .form-error {
            color: #EF4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .form-input.error,
        .form-textarea.error {
            border-color: #EF4444;
        }

        .form-input.error:focus,
        .form-textarea.error:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2);
        }

        /* Step sections */
        .step-section {
            display: none;
        }

        .step-section.active {
            display: block;
        }

        /* File upload styles */
        .file-upload-container {
            border: 2px dashed #D1D5DB;
            border-radius: 0.5rem;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-upload-container:hover {
            border-color: #4CAF50;
            background-color: rgba(76, 175, 80, 0.05);
        }

        .file-preview {
            max-width: 100%;
            max-height: 200px;
            margin-top: 1rem;
            border-radius: 0.5rem;
        }

        /* Loading spinner */
        .spinner {
            border: 3px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top: 3px solid #4CAF50;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-right: 0.5rem;
            vertical-align: middle;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Rincian Biaya Section Styles */
        .biaya-section {
            background-color: #f9fafb;
            padding: 4rem 0;
            position: relative;
            overflow: hidden;
        }

        .biaya-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            position: relative;
            z-index: 2;
        }

        .biaya-header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }

        .biaya-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2e7d32;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .biaya-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #2e7d32, #4CAF50);
            border-radius: 2px;
        }

        .biaya-subtitle {
            font-size: 1.1rem;
            color: #4b5563;
            max-width: 700px;
            margin: 0 auto;
        }

        .biaya-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .biaya-card {
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .biaya-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.2);
        }

        .biaya-card-header {
            background: linear-gradient(135deg, #2e7d32, #4CAF50);
            color: white;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .biaya-card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0) 70%);
            transform: rotate(30deg);
        }

        .biaya-card-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
        }

        .biaya-card-subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
            position: relative;
        }

        .biaya-card-body {
            padding: 1.5rem;
        }

        .biaya-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px dashed rgba(0, 0, 0, 0.1);
        }

        .biaya-item:last-child {
            border-bottom: none;
        }

        .biaya-label {
            display: flex;
            align-items: center;
            font-size: 1rem;
            color: #4b5563;
        }

        .biaya-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: rgba(76, 175, 80, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            color: #2e7d32;
            flex-shrink: 0;
        }

        .biaya-value {
            font-size: 1.125rem;
            font-weight: 700;
            color: #2e7d32;
        }

        .biaya-total {
            margin-top: 1rem;
            padding: 1rem;
            background-color: rgba(76, 175, 80, 0.05);
            border-radius: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .biaya-total-label {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
        }

        .biaya-total-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: #f59e0b;
        }

        .biaya-note {
            text-align: center;
            max-width: 700px;
            margin: 2rem auto 0;
            padding: 1rem;
            background-color: rgba(255, 193, 7, 0.1);
            border-radius: 0.75rem;
            font-size: 0.95rem;
            color: #4b5563;
        }

        .biaya-note strong {
            color: #2e7d32;
        }

        .biaya-decoration {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(76, 175, 80, 0.05);
            z-index: 1;
        }

        .biaya-decoration-1 {
            width: 300px;
            height: 300px;
            top: -150px;
            right: -100px;
        }

        .biaya-decoration-2 {
            width: 200px;
            height: 200px;
            bottom: -100px;
            left: -50px;
        }

        .biaya-decoration-3 {
            width: 150px;
            height: 150px;
            top: 40%;
            right: 10%;
            background-color: rgba(255, 193, 7, 0.05);
        }

        .biaya-image {
            position: absolute;
            bottom: -20px;
            right: 20px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            border: 5px solid white;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
            z-index: 2;
        }

        .biaya-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .administrasi-header {
            position: relative;
            background: linear-gradient(135deg, #2e7d32, #4CAF50);
            padding: 2rem;
            border-radius: 1rem 1rem 0 0;
            color: white;
            text-align: center;
            overflow: hidden;
        }

        .administrasi-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: 0;
        }

        .administrasi-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .administrasi-content {
            background: white;
            padding: 2rem;
            border-radius: 0 0 1rem 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .administrasi-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px dashed rgba(0, 0, 0, 0.1);
        }

        .administrasi-row:last-of-type {
            border-bottom: none;
        }

        .administrasi-label {
            font-size: 1.125rem;
            color: #4b5563;
        }

        .administrasi-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: #2e7d32;
        }

        .administrasi-total {
            font-size: 1.5rem;
            font-weight: 800;
            color: #f59e0b;
            padding-top: 0.75rem;
            border-top: 2px solid #f59e0b;
            margin-top: 0.75rem;
        }

        .administrasi-divider {
            height: 2px;
            background: linear-gradient(90deg, rgba(46, 125, 50, 0.1), rgba(46, 125, 50, 0.5), rgba(46, 125, 50, 0.1));
            margin: 1.5rem 0;
            border-radius: 1px;
        }

        .administrasi-card {
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
        }

        .administrasi-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.2);
        }

        .administrasi-logo {
            position: absolute;
            bottom: 20px;
            left: 20px;
            width: 80px;
            height: 80px;
            z-index: 2;
        }

        .administrasi-santri {
            position: absolute;
            bottom: 20px;
            right: 20px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            border: 5px solid white;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
            z-index: 2;
        }

        .administrasi-santri img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Payment type styles */
        .payment-type-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .payment-type-option {
            border: 2px solid #E5E7EB;
            border-radius: 0.75rem;
            padding: 1.25rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .payment-type-option:hover {
            border-color: #4CAF50;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .payment-type-option.selected {
            border-color: #4CAF50;
            background-color: rgba(76, 175, 80, 0.05);
        }

        .payment-type-option input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .payment-type-header {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .payment-type-radio {
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid #D1D5DB;
            border-radius: 50%;
            margin-right: 0.75rem;
            position: relative;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }

        .payment-type-option.selected .payment-type-radio {
            border-color: #4CAF50;
        }

        .payment-type-option.selected .payment-type-radio::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 0.625rem;
            height: 0.625rem;
            background-color: #4CAF50;
            border-radius: 50%;
        }

        .payment-type-title {
            font-weight: 600;
            color: #1F2937;
        }

        .payment-type-description {
            color: #6B7280;
            font-size: 0.875rem;
            margin-left: 2rem;
        }

        /* WhatsApp button styles */
        .whatsapp-btn {
            display: inline-flex;
            align-items: center;
            background-color: #25D366;
            color: white;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(37, 211, 102, 0.3), 0 2px 4px -1px rgba(37, 211, 102, 0.2);
        }

        .whatsapp-btn:hover {
            background-color: #128C7E;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(37, 211, 102, 0.3), 0 4px 6px -2px rgba(37, 211, 102, 0.2);
        }

        .whatsapp-btn svg {
            margin-right: 0.5rem;
        }

        /* Success step styles */
        .success-icon-container {
            width: 5rem;
            height: 5rem;
            background-color: #ECFDF5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
        }

        .success-icon {
            width: 3rem;
            height: 3rem;
            color: #10B981;
        }

        .registration-number {
            background-color: #F3F4F6;
            border-radius: 0.75rem;
            padding: 1.5rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        .registration-number-value {
            font-size: 2rem;
            font-weight: 800;
            color: #4CAF50;
            margin: 0.5rem 0;
        }

        .next-steps {
            background-color: #F9FAFB;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .next-step-item {
            display: flex;
            margin-bottom: 1.25rem;
            padding-bottom: 1.25rem;
            border-bottom: 1px dashed #E5E7EB;
        }

        .next-step-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .next-step-number {
            width: 2rem;
            height: 2rem;
            background-color: #4CAF50;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .next-step-content {
            flex: 1;
        }

        .next-step-title {
            font-weight: 600;
            color: #1F2937;
            margin-bottom: 0.25rem;
        }

        .next-step-description {
            color: #6B7280;
            font-size: 0.875rem;
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section with unique style for pendaftaran page -->
    <section class="hero-pendaftaran relative">
        <div class="hero-circles">
            <div class="hero-circle hero-circle-1"></div>
            <div class="hero-circle hero-circle-2"></div>
            <div class="hero-circle hero-circle-3"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28 relative z-10">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-6" data-aos="fade-up">Pendaftaran Santri Baru</h1>
                <p class="text-lg md:text-xl text-white/90 max-w-3xl mx-auto mb-8" data-aos="fade-up" data-aos-delay="100">
                    Bergabunglah dengan Pondok Pesantren Ibnu Hafidz dan mulai perjalanan Anda menuju generasi Qur'ani yang
                    berakhlak mulia
                </p>
                <div class="flex justify-center" data-aos="fade-up" data-aos-delay="200">
                    <a href="#pertanyaan-umum"
                        class="inline-flex items-center px-6 py-3 bg-white text-green-700 font-semibold rounded-lg shadow-lg hover:bg-gray-100 transition duration-300">
                        Daftar Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Rincian Biaya Section -->
    <section class="biaya-section">
        <div class="biaya-decoration biaya-decoration-1"></div>
        <div class="biaya-decoration biaya-decoration-2"></div>
        <div class="biaya-decoration biaya-decoration-3"></div>

        <div class="biaya-container">
            <div class="biaya-header" data-aos="fade-up">
                <h2 class="biaya-title">Rincian Biaya</h2>
                <p class="biaya-subtitle">Informasi lengkap mengenai biaya pendaftaran dan biaya bulanan di Pondok Pesantren
                    Ibnu Hafidz</p>
            </div>

            <div class="administrasi-card" data-aos="fade-up" data-aos-delay="200">
                <div class="administrasi-header">
                    <h3 class="administrasi-title">ADMINISTRASI</h3>
                </div>
                <div class="administrasi-content">
                    <div class="administrasi-row">
                        <div class="administrasi-label">Pendaftaran</div>
                        <div class="administrasi-value">Rp. 600.000</div>
                    </div>
                    <div class="administrasi-row">
                        <div class="administrasi-label">Biaya Gedung</div>
                        <div class="administrasi-value">Rp. 7.000.000</div>
                    </div>
                    <div class="administrasi-row">
                        <div class="administrasi-label">Kasur, Lemari, & Seragam Pondok</div>
                        <div class="administrasi-value">Rp. 2.000.000</div>
                    </div>
                    <div class="administrasi-total">
                        <div class="administrasi-label">Total</div>
                        <div class="administrasi-total-value">Rp. 9.600.000</div>
                    </div>

                    <div class="administrasi-divider"></div>

                    <div class="administrasi-row">
                        <div class="administrasi-label">Uang Makan</div>
                        <div class="administrasi-value">Rp. 700.000</div>
                    </div>
                    <div class="administrasi-row">
                        <div class="administrasi-label">Laundry (Opsional)</div>
                        <div class="administrasi-value">Rp. 170.000</div>
                    </div>
                    <div class="administrasi-row">
                        <div class="administrasi-label">SPP</div>
                        <div class="administrasi-value">Rp. 200.000</div>
                    </div>
                    <div class="administrasi-total">
                        <div class="administrasi-label">Total</div>
                        <div class="administrasi-total-value">Rp. 1.070.000 / Rp. 900.000 (Tanpa Laundry)</div>
                    </div>
                </div>
            </div>

            <div class="biaya-note" data-aos="fade-up" data-aos-delay="300">
                <strong>Catatan:</strong> Biaya awal dibayarkan satu kali saat pendaftaran, biaya bulanan
                dibayarkan setiap bulan selama santri menempuh pendidikan di Pondok Pesantren Ibnu Hafidz.
            </div>
        </div>
    </section>

    <!-- FAQ Section with Accordion -->
    <section id="pertanyaan-umum" class="py-16 md:py-24 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 gradient-text" data-aos="fade-up">Pertanyaan Umum</h2>
                <div class="w-24 h-1 bg-green-500 mx-auto mb-8" data-aos="fade-up" data-aos-delay="100"></div>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                    Berikut adalah beberapa pertanyaan yang sering ditanyakan tentang proses pendaftaran
                </p>
            </div>

            <div class="space-y-4" data-aos="fade-up" data-aos-delay="300">
                <!-- Accordion Item 1 -->
                <div class="accordion-item bg-gray-50 rounded-xl overflow-hidden shadow-sm">
                    <button
                        class="accordion-header w-full flex justify-between items-center p-6 text-left focus:outline-none">
                        <h3 class="text-xl font-semibold text-gray-800">Kapan pendaftaran dibuka?</h3>
                        <svg class="accordion-icon w-6 h-6 text-green-600 transform transition-transform duration-300"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="accordion-content max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                        <div class="p-6 pt-0 text-gray-600">
                            Pendaftaran santri baru dibuka sepanjang tahun, namun untuk tahun ajaran baru kami membuka
                            pendaftaran mulai bulan Januari hingga Juni.
                        </div>
                    </div>
                </div>

                <!-- Accordion Item 2 -->
                <div class="accordion-item bg-gray-50 rounded-xl overflow-hidden shadow-sm">
                    <button
                        class="accordion-header w-full flex justify-between items-center p-6 text-left focus:outline-none">
                        <h3 class="text-xl font-semibold text-gray-800">Berapa biaya pendaftaran?</h3>
                        <svg class="accordion-icon w-6 h-6 text-green-600 transform transition-transform duration-300"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="accordion-content max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                        <div class="p-6 pt-0 text-gray-600">
                            Biaya pendaftaran sebesar Rp 600.000 yang mencakup biaya administrasi. Untuk rincian biaya
                            lengkap, silakan lihat bagian Rincian Biaya di atas.
                        </div>
                    </div>
                </div>

                <!-- Accordion Item 3 -->
                <div class="accordion-item bg-gray-50 rounded-xl overflow-hidden shadow-sm">
                    <button
                        class="accordion-header w-full flex justify-between items-center p-6 text-left focus:outline-none">
                        <h3 class="text-xl font-semibold text-gray-800">Apa saja persyaratan yang harus disiapkan?</h3>
                        <svg class="accordion-icon w-6 h-6 text-green-600 transform transition-transform duration-300"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="accordion-content max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                        <div class="p-6 pt-0 text-gray-600">
                            melakukan pengisian formulir dan pembayaran awal.
                        </div>
                    </div>
                </div>

                <!-- Accordion Item 4 -->
                <div class="accordion-item bg-gray-50 rounded-xl overflow-hidden shadow-sm">
                    <button
                        class="accordion-header w-full flex justify-between items-center p-6 text-left focus:outline-none">
                        <h3 class="text-xl font-semibold text-gray-800">Bagaimana proses seleksi masuk?</h3>
                        <svg class="accordion-icon w-6 h-6 text-green-600 transform transition-transform duration-300"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="accordion-content max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                        <div class="p-6 pt-0 text-gray-600">
                            Saat ini tidak ada proses seleksi, setelah mendaftar dan membayar uang masuk maka sudah
                            dinyatakan terdaftar.
                        </div>
                    </div>
                </div>

                <!-- Accordion Item 6 -->
                <div class="accordion-item bg-gray-50 rounded-xl overflow-hidden shadow-sm">
                    <button
                        class="accordion-header w-full flex justify-between items-center p-6 text-left focus:outline-none">
                        <h3 class="text-xl font-semibold text-gray-800">Apa yang harus dibawa saat masuk pesantren?</h3>
                        <svg class="accordion-icon w-6 h-6 text-green-600 transform transition-transform duration-300"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="accordion-content max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                        <div class="p-6 pt-0 text-gray-600">
                            Santri perlu membawa perlengkapan pribadi seperti pakaian, perlengkapan mandi, perlengkapan
                            ibadah, perlengkapan tidur, dan perlengkapan belajar. Daftar lengkap akan diberikan setelah
                            dinyatakan diterima.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="cek-status" class="py-16 md:py-24 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 gradient-text" data-aos="fade-up">Cek Status Pendaftaran</h2>
                <div class="w-24 h-1 bg-green-500 mx-auto mb-8" data-aos="fade-up" data-aos-delay="100"></div>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                    Masukkan nomor pendaftaran Anda untuk melihat status pendaftaran dan pembayaran
                </p>
            </div>

            <div class="max-w-md mx-auto" data-aos="fade-up" data-aos-delay="300">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                        <h3 class="text-xl font-medium text-gray-800 dark:text-white">Cek Status Pendaftaran</h3>
                    </div>
                    <div class="p-6">
                        <form id="track-form" action="{{ route('pendaftaran.track') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="registration_number"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nomor
                                    Pendaftaran</label>
                                <input type="text" id="registration_number" name="registration_number"
                                    class="w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-3 px-4 text-base shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                    placeholder="Contoh: REG-00001" required>
                            </div>

                            <div class="mt-6">
                                <button type="submit"
                                    class="w-full bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 text-white px-4 py-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Cek Status
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Results will be displayed here -->
                <div id="track-results" class="mt-6" style="display: none;">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                            <h3 class="text-xl font-medium text-gray-800 dark:text-white">Hasil Pencarian</h3>
                        </div>
                        <div class="p-6">
                            <div id="track-content">
                                <!-- Content will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Registration Form Section (moved below FAQ) -->
    <section id="form-pendaftaran" class="py-16 md:py-24 bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 gradient-text" data-aos="fade-up">Formulir Pendaftaran</h2>
                <div class="w-24 h-1 bg-green-500 mx-auto mb-8" data-aos="fade-up" data-aos-delay="100"></div>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                    Silakan lengkapi formulir pendaftaran di bawah ini dengan informasi yang benar
                </p>
            </div>

            <!-- Steps indicator -->
            <div class="steps-container" data-aos="fade-up" data-aos-delay="300">
                <div class="step active" data-step="formulir">
                    1
                    <span class="step-label">Formulir</span>
                </div>
                <div class="step" data-step="checking">
                    2
                    <span class="step-label">Checking Data</span>
                </div>
                <div class="step" data-step="pembayaran">
                    3
                    <span class="step-label">Pembayaran</span>
                </div>
                <div class="step" data-step="berhasil">
                    4
                    <span class="step-label">Pendaftaran Berhasil</span>
                </div>
            </div>

            <!-- Multi-step form container -->
            <div id="registration-form-container">
                <!-- Step 1: Formulir -->
                <div class="step-section active" id="step-formulir">
                    <!-- Information Card -->
                    <div class="info-card" data-aos="fade-up" data-aos-delay="400">
                        <div class="info-card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Informasi Penting
                        </div>
                        <p class="info-card-text">
                            • Pastikan semua data yang diisi sesuai dengan dokumen resmi (Akta Kelahiran, Kartu Keluarga,
                            dll).
                        </p>
                        <p class="info-card-text">
                            • Setelah mengisi formulir, Anda akan diarahkan ke tahap verifikasi dan pembayaran biaya
                            pendaftaran.
                        </p>
                        <p class="info-card-text">
                            • Jika ada pertanyaan, silakan hubungi kami di nomor WhatsApp: <span
                                class="font-semibold">0812-3456-7890</span>
                        </p>
                    </div>

                    <!-- Registration Form -->
                    <div class="form-container" data-aos="fade-up" data-aos-delay="500">
                        <div class="form-header">
                            <h3 class="text-xl font-bold">Data Calon Santri</h3>
                        </div>
                        <div class="form-body">
                            <form id="formulir-form">
                                @csrf

                                <div class="form-group">
                                    <label for="nama" class="form-label required-field">Nama</label>
                                    <input type="text" id="nama" name="nama" class="form-input"
                                        placeholder="Masukkan nama lengkap" required>
                                    <div class="form-error" id="error-nama"></div>
                                </div>

                                <div class="grid md:grid-cols-2 gap-6">
                                    <div class="form-group">
                                        <label for="tempat_lahir" class="form-label required-field">Tempat Lahir</label>
                                        <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-input"
                                            placeholder="Masukkan tempat lahir" required>
                                        <div class="form-error" id="error-tempat_lahir"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="tanggal_lahir" class="form-label required-field">Tanggal Lahir</label>
                                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-input"
                                            required>
                                        <div class="form-error" id="error-tanggal_lahir"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="alamat" class="form-label required-field">Alamat</label>
                                    <textarea id="alamat" name="alamat" class="form-textarea"
                                        placeholder="Masukkan alamat lengkap" required></textarea>
                                    <div class="form-error" id="error-alamat"></div>
                                </div>

                                <div class="grid md:grid-cols-2 gap-6">
                                    <div class="form-group">
                                        <label for="nama_ayah" class="form-label required-field">Nama Ayah</label>
                                        <input type="text" id="nama_ayah" name="nama_ayah" class="form-input"
                                            placeholder="Masukkan nama ayah" required>
                                        <div class="form-error" id="error-nama_ayah"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="nama_ibu" class="form-label required-field">Nama Ibu</label>
                                        <input type="text" id="nama_ibu" name="nama_ibu" class="form-input"
                                            placeholder="Masukkan nama ibu" required>
                                        <div class="form-error" id="error-nama_ibu"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="no_whatsapp" class="form-label required-field">No WhatsApp</label>
                                    <input type="tel" id="no_whatsapp" name="no_whatsapp" class="form-input"
                                        placeholder="Contoh: 08123456789" required>
                                    <div class="form-error" id="error-no_whatsapp"></div>
                                </div>

                                <div class="form-group">
                                    <label for="asal_sekolah" class="form-label required-field">Asal Sekolah</label>
                                    <input type="text" id="asal_sekolah" name="asal_sekolah" class="form-input"
                                        placeholder="Masukkan asal sekolah" required>
                                    <div class="form-error" id="error-asal_sekolah"></div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label required-field">Jenis Kelamin</label>
                                    <div class="radio-group">
                                        <div class="radio-option">
                                            <input type="radio" id="laki_laki" name="jenis_kelamin" value="Laki-laki"
                                                class="radio-input" required>
                                            <label for="laki_laki">Laki-laki</label>
                                        </div>
                                        <div class="radio-option">
                                            <input type="radio" id="perempuan" name="jenis_kelamin" value="Perempuan"
                                                class="radio-input">
                                            <label for="perempuan">Perempuan</label>
                                        </div>
                                    </div>
                                    <div class="form-error" id="error-jenis_kelamin"></div>
                                </div>

                                <div class="mt-8 text-center">
                                    <button type="submit" class="submit-btn" id="submit-formulir">
                                        <span id="formulir-submit-text">Kirim Pendaftaran</span>
                                        <span id="formulir-loading" style="display: none;">
                                            <span class="spinner"></span> Mengirim...
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Checking Data -->
                <div class="step-section" id="step-checking">
                    <div class="info-card" data-aos="fade-up" data-aos-delay="400">
                        <div class="info-card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Periksa Data Anda
                        </div>
                        <p class="info-card-text">
                            • Pastikan semua data yang Anda masukkan sudah benar sebelum melanjutkan ke tahap pembayaran.
                        </p>
                        <p class="info-card-text">
                            • Jika ada kesalahan, silakan kembali ke halaman sebelumnya untuk memperbaiki data.
                        </p>
                    </div>

                    <div class="form-container" data-aos="fade-up" data-aos-delay="500">
                        <div class="form-header">
                            <h3 class="text-xl font-bold">Data Calon Santri</h3>
                        </div>
                        <div class="form-body">
                            <div class="grid md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <h4 class="text-lg font-semibold mb-4">Data Pribadi</h4>
                                    <div class="space-y-3">
                                        <div>
                                            <span class="text-gray-500">Nama:</span>
                                            <p class="font-medium" id="checking-nama"></p>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Tempat, Tanggal Lahir:</span>
                                            <p class="font-medium" id="checking-ttl"></p>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Jenis Kelamin:</span>
                                            <p class="font-medium" id="checking-jenis-kelamin"></p>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Alamat:</span>
                                            <p class="font-medium" id="checking-alamat"></p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-lg font-semibold mb-4">Data Orang Tua & Kontak</h4>
                                    <div class="space-y-3">
                                        <div>
                                            <span class="text-gray-500">Nama Ayah:</span>
                                            <p class="font-medium" id="checking-nama-ayah"></p>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Nama Ibu:</span>
                                            <p class="font-medium" id="checking-nama-ibu"></p>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">No. WhatsApp:</span>
                                            <p class="font-medium" id="checking-no-whatsapp"></p>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Asal Sekolah:</span>
                                            <p class="font-medium" id="checking-asal-sekolah"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-6 mt-6">
                                <div class="flex items-center mb-6">
                                    <input id="confirm-data" name="confirm-data" type="checkbox"
                                        class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                                    <label for="confirm-data" class="ml-2 block text-sm text-gray-700">
                                        Saya menyatakan bahwa data yang saya masukkan adalah benar dan dapat
                                        dipertanggungjawabkan.
                                    </label>
                                </div>

                                <div class="flex justify-between">
                                    <button type="button" id="back-to-formulir"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Kembali
                                    </button>

                                    <!-- Make sure the button is not inside a form or is properly set up -->
                                    <button type="button" id="submit-checking"
                                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <span id="checking-submit-text">Lanjutkan ke Pembayaran</span>
                                        <span id="checking-loading" style="display: none;">
                                            <span class="spinner"></span> Memproses...
                                        </span>
                                        <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Pembayaran -->
                <div class="step-section" id="step-pembayaran">
                    <div class="info-card" data-aos="fade-up" data-aos-delay="400">
                        <div class="info-card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Informasi Pembayaran
                        </div>
                        <p class="info-card-text">
                            • Biaya pendaftaran sebesar <span class="font-semibold">Rp 600.000</span>
                        </p>
                        <p class="info-card-text">• Pembayaran dapat dilakukan melalui transfer bank ke rekening berikut:
                        </p>
                        <div class="bg-white p-4 rounded-lg mt-2 mb-2">
                            <p class="font-medium">Bank BRI</p>
                            <p class="font-semibold text-lg">1234-5678-9012-3456</p>
                            <p>a.n. Yayasan Pondok Pesantren Ibnu Hafidz</p>
                        </div>
                        <p class="info-card-text">
                            • Setelah melakukan pembayaran, silakan unggah bukti pembayaran di bawah ini.
                        </p>
                    </div>

                    <div class="form-container" data-aos="fade-up" data-aos-delay="500">
                        <div class="form-header">
                            <h3 class="text-xl font-bold">Unggah Bukti Pembayaran</h3>
                        </div>
                        <div class="form-body">
                            <form id="pembayaran-form">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label required-field">Pilih Jenis Pembayaran</label>
                                    <div class="payment-type-container">
                                        <label class="payment-type-option" id="payment-lunas">
                                            <input type="radio" name="payment_type" value="Lunas" required>
                                            <div class="payment-type-header">
                                                <div class="payment-type-radio"></div>
                                                <div class="payment-type-title">Pembayaran Lunas</div>
                                            </div>
                                            <div class="payment-type-description">
                                                Bayar penuh Rp 9.600.000
                                            </div>
                                        </label>

                                        <label class="payment-type-option" id="payment-cicilan">
                                            <input type="radio" name="payment_type" value="Cicilan" required>
                                            <div class="payment-type-header">
                                                <div class="payment-type-radio"></div>
                                                <div class="payment-type-title">Pembayaran Cicilan</div>
                                            </div>
                                            <div class="payment-type-description">
                                                Minimal Rp 600.000 (pendaftaran)
                                            </div>
                                        </label>
                                    </div>
                                    <div class="form-error" id="error-payment_type"></div>
                                </div>

                                <div class="form-group">
                                    <label for="payment_proof" class="form-label required-field">Bukti Pembayaran</label>
                                    <div class="mt-2">
                                        <div class="file-upload-container" id="file-upload-container">
                                            <input type="file" id="payment_proof" name="payment_proof" accept="image/*"
                                                class="hidden" required>
                                            <label for="payment_proof"
                                                class="cursor-pointer flex flex-col items-center justify-center">
                                                <div id="preview-container" style="display: none;">
                                                    <img id="preview-image" src="/placeholder.svg"
                                                        alt="Preview bukti pembayaran" class="file-preview">
                                                </div>
                                                <div id="upload-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                    </svg>
                                                </div>
                                                <span class="text-sm font-medium text-gray-700" id="upload-text">
                                                    Klik untuk mengunggah bukti pembayaran
                                                </span>
                                                <span class="text-xs text-gray-500 mt-1">JPG, PNG, atau JPEG (Maks.
                                                    5MB)</span>
                                            </label>
                                        </div>
                                        <div class="form-error" id="error-payment_proof"></div>
                                    </div>
                                </div>

                                <div class="flex justify-between mt-8">
                                    <button type="button" id="back-to-checking"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Kembali
                                    </button>

                                    <button type="submit" class="submit-btn" id="submit-pembayaran">
                                        <span id="pembayaran-submit-text">Kirim Bukti Pembayaran</span>
                                        <span id="pembayaran-loading" style="display: none;">
                                            <span class="spinner"></span> Mengunggah...
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Pendaftaran Berhasil -->
                <div class="step-section" id="step-berhasil">
                    <div class="form-container" data-aos="fade-up" data-aos-delay="500">
                        <div class="form-header">
                            <h3 class="text-xl font-bold">Pendaftaran Berhasil!</h3>
                        </div>
                        <div class="form-body text-center py-8">
                            <div class="success-icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" class="success-icon" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>

                            <h3 class="text-2xl font-bold text-gray-800 mb-4">Pendaftaran Berhasil!</h3>

                            <p class="text-gray-600 mb-8 max-w-lg mx-auto">
                                Pendaftaran Anda telah berhasil diproses. Kami akan menghubungi Anda melalui WhatsApp untuk
                                informasi selanjutnya.
                            </p>

                            <div class="registration-number">
                                <h4 class="font-semibold text-gray-700">Nomor Pendaftaran:</h4>
                                <p class="registration-number-value" id="nomor-pendaftaran">PSB-0000</p>
                                <p class="text-sm text-gray-500">Simpan nomor pendaftaran ini untuk keperluan selanjutnya
                                </p>
                            </div>

                            <div class="next-steps">
                                <h4 class="font-semibold text-gray-800 mb-4">Langkah Selanjutnya:</h4>

                                <div class="next-step-item">
                                    <div class="next-step-number">1</div>
                                    <div class="next-step-content">
                                        <div class="next-step-title">Verifikasi Pembayaran</div>
                                        <div class="next-step-description">Pembayaran Anda akan diverifikasi dalam waktu 1-2
                                            hari kerja.</div>
                                    </div>
                                </div>

                                <div class="next-step-item">
                                    <div class="next-step-number">2</div>
                                    <div class="next-step-content">
                                        <div class="next-step-title">Grup WhatsApp</div>
                                        <div class="next-step-description">Silakan masuk ke grup WhatsApp dan kirim data
                                            yang telah tercantum di chat.</div>
                                        <a href="#" id="whatsapp-link" class="whatsapp-btn mt-3 inline-flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                            </svg>
                                            Hubungi via WhatsApp
                                        </a>
                                    </div>
                                </div>

                                <div class="next-step-item">
                                    <div class="next-step-number">3</div>
                                    <div class="next-step-content">
                                        <div class="next-step-title">Survey Pondok</div>
                                        <div class="next-step-description">Lakukan survey ke pondok secara langsung untuk
                                            mengenal lingkungan belajar.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8">
                                <a href="/"
                                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section with enhanced animations -->
    <section class="py-16 md:py-24 bg-green-600 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                <defs>
                    <pattern id="pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M0 20 L40 20" stroke="white" stroke-width="1" fill="none" />
                        <path d="M20 0 L20 40" stroke="white" stroke-width="1" fill="none" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#pattern)" />
            </svg>
        </div>

        <!-- Animated floating elements -->
        <div class="absolute w-20 h-20 bg-white/10 rounded-full top-10 left-[10%]"
            style="animation: float 8s ease-in-out infinite"></div>
        <div class="absolute w-12 h-12 bg-white/10 rounded-full bottom-10 right-[15%]"
            style="animation: float 6s ease-in-out infinite 1s"></div>
        <div class="absolute w-16 h-16 bg-white/10 rounded-full top-1/2 left-[80%]"
            style="animation: float 10s ease-in-out infinite 2s"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold mb-6 text-white" data-aos="zoom-in">Butuh Bantuan?</h2>
                <p class="text-lg text-white/90 max-w-3xl mx-auto mb-8" data-aos="fade-up" data-aos-delay="200">
                    Jika Anda memiliki pertanyaan atau kesulitan dalam proses pendaftaran, jangan ragu untuk menghubungi
                    kami.
                </p>
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer"
                        class="contact-btn contact-btn-primary" data-aos="fade-up" data-aos-delay="300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                        </svg>
                        Hubungi via WhatsApp
                    </a>
                    <a href="tel:+6281234567890" class="contact-btn contact-btn-secondary" data-aos="fade-up"
                        data-aos-delay="400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        Telepon Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize AOS
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                mirror: false
            });

            // Accordion functionality
            const accordionHeaders = document.querySelectorAll('.accordion-header');
            accordionHeaders.forEach(header => {
                header.addEventListener('click', function () {
                    // Toggle active class on header
                    this.classList.toggle('active');

                    // Get the content element
                    const content = this.nextElementSibling;

                    // Toggle active class on content
                    if (content.classList.contains('active')) {
                        content.classList.remove('active');
                        content.style.maxHeight = 0;
                    } else {
                        content.classList.add('active');
                        content.style.maxHeight = content.scrollHeight + 'px';
                    }
                });
            });

            // Add animation to form fields when they come into view
            const formInputs = document.querySelectorAll('.form-input, .form-textarea, .form-select');
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const formObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 0;
                        entry.target.style.transform = 'translateY(20px)';

                        setTimeout(() => {
                            entry.target.style.transition = 'all 0.5s ease';
                            entry.target.style.opacity = 1;
                            entry.target.style.transform = 'translateY(0)';
                        }, 100 + Math.random() * 300);

                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            formInputs.forEach(input => {
                formObserver.observe(input);
            });

            // Add animated background to CTA section
            const ctaSection = document.querySelector('.py-16.md\\:py-24.bg-green-600');
            if (ctaSection) {
                const animatedBg = document.createElement('div');
                animatedBg.classList.add('cta-bg-animation');
                ctaSection.appendChild(animatedBg);
            }

            // Add scroll-triggered animations
            window.addEventListener('scroll', function () {
                const scrollPosition = window.scrollY;
                const windowHeight = window.innerHeight;

                // Parallax effect for hero section
                const heroSection = document.querySelector('.hero-pendaftaran');
                if (heroSection) {
                    const heroCircles = heroSection.querySelectorAll('.hero-circle');
                    heroCircles.forEach((circle, index) => {
                        const speed = 0.1 + (index * 0.05);
                        circle.style.transform = `translateY(${scrollPosition * speed}px)`;
                    });
                }
            });

            // Multi-step form functionality
            let currentStep = 'formulir';
            let calonSantriData = null;
            let calonSantriId = null;

            // Function to show a specific step
            function showStep(stepId) {
                // Hide all steps
                document.querySelectorAll('.step-section').forEach(section => {
                    section.classList.remove('active');
                });

                // Show the requested step
                document.getElementById(`step-${stepId}`).classList.add('active');

                // Update step indicators
                document.querySelectorAll('.step').forEach(step => {
                    step.classList.remove('active', 'completed');
                });

                const steps = ['formulir', 'checking', 'pembayaran', 'berhasil'];
                const currentIndex = steps.indexOf(stepId);

                steps.forEach((step, index) => {
                    const stepElement = document.querySelector(`.step[data-step="${step}"]`);
                    if (index < currentIndex) {
                        stepElement.classList.add('completed');
                    } else if (index === currentIndex) {
                        stepElement.classList.add('active');
                    }
                });

                currentStep = stepId;

                // Scroll to the top of the form
                document.getElementById('form-pendaftaran').scrollIntoView({ behavior: 'smooth' });
            }

            // Handle form submission for step 1 (Formulir)
            document.getElementById('formulir-form').addEventListener('submit', function (e) {
                e.preventDefault();

                // Show loading state
                document.getElementById('formulir-submit-text').style.display = 'none';
                document.getElementById('formulir-loading').style.display = 'inline-block';

                // Clear previous errors
                document.querySelectorAll('.form-error').forEach(error => {
                    error.textContent = '';
                });
                document.querySelectorAll('.form-input, .form-textarea').forEach(input => {
                    input.classList.remove('error');
                });

                // Get form data
                const formData = new FormData(this);

                // Send AJAX request
                fetch('/pendaftaran', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.errors) {
                            // Display validation errors
                            Object.keys(data.errors).forEach(field => {
                                const errorElement = document.getElementById(`error-${field}`);
                                const inputElement = document.getElementById(field);
                                if (errorElement) {
                                    errorElement.textContent = data.errors[field][0];
                                }
                                if (inputElement) {
                                    inputElement.classList.add('error');
                                }
                            });
                        } else {
                            // Store the data for the next steps
                            calonSantriData = data;
                            calonSantriId = data.id;

                            // Populate checking step with the data
                            document.getElementById('checking-nama').textContent = data.nama;
                            document.getElementById('checking-ttl').textContent = `${data.tempat_lahir}, ${new Date(data.tanggal_lahir).toLocaleDateString('id-ID')}`;
                            document.getElementById('checking-jenis-kelamin').textContent = data.jenis_kelamin;
                            document.getElementById('checking-alamat').textContent = data.alamat;
                            document.getElementById('checking-nama-ayah').textContent = data.nama_ayah;
                            document.getElementById('checking-nama-ibu').textContent = data.nama_ibu;
                            document.getElementById('checking-no-whatsapp').textContent = data.no_whatsapp;
                            document.getElementById('checking-asal-sekolah').textContent = data.asal_sekolah;

                            // Move to the next step
                            showStep('checking');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengirim formulir. Silakan coba lagi.');
                    })
                    .finally(() => {
                        // Hide loading state
                        document.getElementById('formulir-submit-text').style.display = 'inline-block';
                        document.getElementById('formulir-loading').style.display = 'none';
                    });
            });

            // Handle back button in checking step
            document.getElementById('back-to-formulir').addEventListener('click', function () {
                showStep('formulir');
            });

            // Handle checking step submission
            document.getElementById('submit-checking').addEventListener('click', function (e) {
                // Prevent default form submission behavior
                e.preventDefault();

                // Check if the checkbox is checked
                if (!document.getElementById('confirm-data').checked) {
                    alert('Silakan konfirmasi bahwa data yang Anda masukkan sudah benar.');
                    return;
                }

                // Show loading state
                document.getElementById('checking-submit-text').style.display = 'none';
                document.getElementById('checking-loading').style.display = 'inline-block';

                // Send AJAX request
                fetch('/pendaftaran/checking', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ calon_santri_id: calonSantriId })
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Update the data
                        calonSantriData = data;

                        // Move to the next step
                        showStep('pembayaran');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat verifikasi. Silakan coba lagi.');
                    })
                    .finally(() => {
                        // Hide loading state
                        document.getElementById('checking-submit-text').style.display = 'inline-block';
                        document.getElementById('checking-loading').style.display = 'none';
                    });
            });

            // Handle back button in pembayaran step
            document.getElementById('back-to-checking').addEventListener('click', function () {
                showStep('checking');
            });

            // Handle payment type selection
            const paymentOptions = document.querySelectorAll('.payment-type-option');
            paymentOptions.forEach(option => {
                option.addEventListener('click', function () {
                    // Remove selected class from all options
                    paymentOptions.forEach(opt => opt.classList.remove('selected'));

                    // Add selected class to clicked option
                    this.classList.add('selected');

                    // Check the radio button
                    const radio = this.querySelector('input[type="radio"]');
                    radio.checked = true;
                });
            });

            // Handle file upload preview
            document.getElementById('payment_proof').addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        document.getElementById('preview-image').src = e.target.result;
                        document.getElementById('preview-container').style.display = 'block';
                        document.getElementById('upload-icon').style.display = 'none';
                        document.getElementById('upload-text').textContent = 'Ganti gambar';
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Handle payment form submission
            document.getElementById('pembayaran-form').addEventListener('submit', function (e) {
                e.preventDefault();

                // Show loading state
                document.getElementById('pembayaran-submit-text').style.display = 'none';
                document.getElementById('pembayaran-loading').style.display = 'inline-block';

                // Clear previous errors
                document.getElementById('error-payment_proof').textContent = '';
                document.getElementById('error-payment_type').textContent = '';

                // Get form data
                const formData = new FormData(this);
                formData.append('calon_santri_id', calonSantriId);

                // Send AJAX request
                fetch('/pendaftaran/pembayaran', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.errors) {
                            // Display validation errors
                            if (data.errors.payment_proof) {
                                document.getElementById('error-payment_proof').textContent = data.errors.payment_proof[0];
                            }
                            if (data.errors.payment_type) {
                                document.getElementById('error-payment_type').textContent = data.errors.payment_type[0];
                            }
                        } else {
                            // Update the data
                            calonSantriData = data;

                            // Set the registration number
                            const nomorPendaftaran = data.nomor_pendaftaran || `PSB-${calonSantriId.toString().padStart(4, '0')}`;
                            document.getElementById('nomor-pendaftaran').textContent = nomorPendaftaran;

                            // Set WhatsApp link with data
                            const whatsappLink = document.getElementById('whatsapp-link');
                            const nama = encodeURIComponent(calonSantriData.nama);
                            const nomorPendaftaranEncoded = encodeURIComponent(nomorPendaftaran);
                            whatsappLink.href = `https://wa.me/6281234567890?text=Assalamualaikum,%20saya%20${nama}%20dengan%20nomor%20pendaftaran%20${nomorPendaftaranEncoded}%20ingin%20bergabung%20dengan%20grup%20WhatsApp%20santri%20baru.`;

                            // Move to the next step
                            showStep('berhasil');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengunggah bukti pembayaran. Silakan coba lagi.');
                    })
                    .finally(() => {
                        // Hide loading state
                        document.getElementById('pembayaran-submit-text').style.display = 'inline-block';
                        document.getElementById('pembayaran-loading').style.display = 'none';
                    });
            });
            // Track form submission
            const trackForm = document.getElementById('track-form');
            if (trackForm) {
                trackForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const registrationNumber = formData.get('registration_number');

                    // Show loading state
                    const submitButton = this.querySelector('button[type="submit"]');
                    const originalButtonText = submitButton.innerHTML;
                    submitButton.innerHTML = '<span class="spinner"></span> Mencari...';
                    submitButton.disabled = true;

                    // Send AJAX request
                    fetch('/pendaftaran/track', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            // Reset button state
                            submitButton.innerHTML = originalButtonText;
                            submitButton.disabled = false;

                            // Show results container
                            document.getElementById('track-results').style.display = 'block';

                            if (data.error) {
                                // Show error message
                                document.getElementById('track-content').innerHTML = `
                                    <div class="text-center py-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Nomor Pendaftaran Tidak Ditemukan</h4>
                                        <p class="text-gray-600 dark:text-gray-400">Pastikan nomor pendaftaran yang Anda masukkan sudah benar.</p>
                                    </div>
                                `;
                            } else {
                                // Show success message with data
                                let statusBadge = '';
                                let paymentTypeBadge = '';

                                // Status badge
                                if (data.status === 'formulir' || data.status === 'Formulir') {
                                    statusBadge = '<span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">Formulir</span>';
                                } else if (data.status === 'checking' || data.status === 'Verifikasi') {
                                    statusBadge = '<span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">Verifikasi</span>';
                                } else if (data.status === 'pembayaran' || data.status === 'Pembayaran') {
                                    statusBadge = '<span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">Pembayaran</span>';
                                } else {
                                    statusBadge = '<span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">Selesai</span>';
                                }

                                // Payment type badge
                                if (data.payment_type === 'Cicilan') {
                                    paymentTypeBadge = '<span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200">Cicilan</span>';
                                } else if (data.payment_type === 'Lunas') {
                                    paymentTypeBadge = '<span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">Lunas</span>';
                                } else {
                                    paymentTypeBadge = '<span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">Belum Terverifikasi</span>';
                                }

                                // Payment history
                                let paymentHistoryHTML = '';
                                if (data.payment_history && data.payment_history.length > 0) {
                                    paymentHistoryHTML = `
                                        <div class="mt-4">
                                            <h5 class="font-medium text-gray-900 dark:text-white mb-2">Riwayat Pembayaran:</h5>
                                            <div class="overflow-x-auto">
                                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                                        <tr>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Cicilan</th>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jumlah</th>
                                                            <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    `;

                                    data.payment_history.forEach(payment => {
                                        const paymentStatus = payment.status === 'verified'
                                            ? '<span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">Terverifikasi</span>'
                                            : '<span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">Menunggu Verifikasi</span>';

                                        paymentHistoryHTML += `
                                            <tr>
                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-white">${payment.installment_number || 'Pertama'}</td>
                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-white">${payment.payment_date}</td>
                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-white">Rp ${payment.amount}</td>
                                                <td class="px-3 py-2 whitespace-nowrap text-sm">${paymentStatus}</td>
                                            </tr>
                                        `;
                                    });

                                    paymentHistoryHTML += `
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    `;
                                }

                                // Upload form for installment payments (only show for Cicilan payment type)
                                let uploadFormHTML = '';
                                if (data.payment_type === 'Cicilan' && data.remaining_amount !== 'Rp 0') {
                                    uploadFormHTML = `
                                        <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                                            <h5 class="font-medium text-gray-900 dark:text-white mb-4">Unggah Bukti Pembayaran Cicilan Berikutnya</h5>

                                            <form id="upload-installment-form" action="/pendaftaran/upload-installment" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                                <input type="hidden" name="registration_number" value="${data.registration_number}">

                                                <div class="space-y-4">
                                                    <div>
                                                        <label for="installment_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah Pembayaran</label>
                                                        <div class="relative">
                                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                <span class="text-gray-500 dark:text-gray-400">Rp</span>
                                                            </div>
                                                            <input type="number" name="installment_amount" id="installment_amount" required
                                                                class="pl-10 w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-2 px-4 text-base shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50"
                                                                placeholder="Masukkan jumlah pembayaran">
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label for="installment_proof" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bukti Pembayaran</label>
                                                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg">
                                                            <div class="space-y-1 text-center">
                                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                                <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                                                    <label for="installment_proof" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-green-600 dark:text-green-400 hover:text-green-500 dark:hover:text-green-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                                                        <span>Unggah file</span>
                                                                        <input id="installment_proof" name="installment_proof" type="file" class="sr-only" accept="image/*" required>
                                                                    </label>
                                                                    <p class="pl-1">atau seret dan lepas</p>
                                                                </div>
                                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                                    PNG, JPG, JPEG hingga 5MB
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div id="preview-container" class="mt-2 hidden">
                                                            <img id="preview-image" src="#" alt="Preview" class="max-h-40 rounded-lg mx-auto">
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label for="installment_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Pembayaran</label>
                                                        <input type="date" name="installment_date" id="installment_date" required
                                                            class="w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-2 px-4 text-base shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50"
                                                            value="${new Date().toISOString().split('T')[0]}">
                                                    </div>

                                                    <div>
                                                        <label for="installment_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan (Opsional)</label>
                                                        <textarea name="installment_notes" id="installment_notes" rows="2"
                                                            class="w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-2 px-4 text-base shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50"
                                                            placeholder="Tambahkan catatan jika diperlukan"></textarea>
                                                    </div>

                                                    <div class="pt-2">
                                                        <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-medium py-2 px-4 rounded-lg flex items-center justify-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12" />
                                                            </svg>
                                                            Unggah Bukti Pembayaran
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    `;
                                }

                                // Render the content
                                document.getElementById('track-content').innerHTML = `
                                    <div class="text-center mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Informasi Ditemukan</h4>
                                    </div>

                                    <div class="space-y-4">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Nama:</p>
                                                <p class="font-medium text-gray-900 dark:text-white">${data.nama}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">No. Pendaftaran:</p>
                                                <p class="font-medium text-gray-900 dark:text-white">${data.registration_number}</p>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Status:</p>
                                                <div class="mt-1">${statusBadge}</div>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Jenis Pembayaran:</p>
                                                <div class="mt-1">${paymentTypeBadge}</div>
                                            </div>
                                        </div>

                                        ${data.payment_type === 'Cicilan' ? `
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Dibayarkan:</p>
                                                    <p class="font-medium text-gray-900 dark:text-white">Rp ${data.total_paid}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">Sisa Pembayaran:</p>
                                                    <p class="font-medium text-gray-900 dark:text-white">Rp ${data.remaining_amount}</p>
                                                </div>
                                            </div>
                                        ` : ''}

                                        ${paymentHistoryHTML}
                                        ${uploadFormHTML}

                                        <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Untuk informasi lebih lanjut, silakan hubungi admin melalui WhatsApp:
                                            </p>
                                            <a href="https://wa.me/6281234567890" target="_blank" class="mt-2 inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                                </svg>
                                                Hubungi Admin
                                            </a>
                                        </div>
                                    </div>
                                `;

                                // Add event listener for file preview
                                const fileInput = document.getElementById('installment_proof');
                                if (fileInput) {
                                    fileInput.addEventListener('change', function (e) {
                                        const file = e.target.files[0];
                                        if (file) {
                                            const reader = new FileReader();
                                            reader.onload = function (e) {
                                                document.getElementById('preview-image').src = e.target.result;
                                                document.getElementById('preview-container').classList.remove('hidden');
                                            }
                                            reader.readAsDataURL(file);
                                        }
                                    });
                                }

                                // Add event listener for form submission
                                const uploadForm = document.getElementById('upload-installment-form');
                                if (uploadForm) {
                                    uploadForm.addEventListener('submit', function (e) {
                                        e.preventDefault();

                                        const formData = new FormData(this);
                                        const submitButton = this.querySelector('button[type="submit"]');
                                        const originalButtonText = submitButton.innerHTML;

                                        submitButton.innerHTML = '<span class="spinner"></span> Mengunggah...';
                                        submitButton.disabled = true;

                                        fetch('/pendaftaran/upload-installment', {
                                            method: 'POST',
                                            body: formData,
                                            headers: {
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                                'Accept': 'application/json'
                                            }
                                        })
                                            .then(response => response.json())
                                            .then(data => {
                                                submitButton.innerHTML = originalButtonText;
                                                submitButton.disabled = false;

                                                if (data.success) {
                                                    // Show success message
                                                    Swal.fire({
                                                        title: 'Berhasil!',
                                                        text: data.message,
                                                        icon: 'success',
                                                        confirmButtonText: 'OK',
                                                        confirmButtonColor: '#10B981'
                                                    }).then(() => {
                                                        // Refresh the tracking data
                                                        document.getElementById('track-form').dispatchEvent(new Event('submit'));
                                                    });
                                                } else {
                                                    // Show error message
                                                    Swal.fire({
                                                        title: 'Gagal!',
                                                        text: data.message || 'Terjadi kesalahan saat mengunggah bukti pembayaran.',
                                                        icon: 'error',
                                                        confirmButtonText: 'OK',
                                                        confirmButtonColor: '#EF4444'
                                                    });
                                                }
                                            })
                                            .catch(error => {
                                                console.error('Error:', error);
                                                submitButton.innerHTML = originalButtonText;
                                                submitButton.disabled = false;

                                                Swal.fire({
                                                    title: 'Gagal!',
                                                    text: 'Terjadi kesalahan saat mengunggah bukti pembayaran.',
                                                    icon: 'error',
                                                    confirmButtonText: 'OK',
                                                    confirmButtonColor: '#EF4444'
                                                });
                                            });
                                    });
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            submitButton.innerHTML = originalButtonText;
                            submitButton.disabled = false;

                            // Show error message
                            document.getElementById('track-results').style.display = 'block';
                            document.getElementById('track-content').innerHTML = `
                                <div class="text-center py-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Terjadi Kesalahan</h4>
                                    <p class="text-gray-600 dark:text-gray-400">Silakan coba lagi nanti.</p>
                                </div>
                            `;
                        });
                });
            }
        });
    </script>
@endsection
