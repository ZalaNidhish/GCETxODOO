<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Management System - Authentication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2vh 2vw;
        }

        .auth-container {
            display: flex;
            width: 90vw;
            max-width: 1000px;
            min-height: 75vh;
            background: white;
            box-shadow: 0 0.5vh 2.5vh rgba(0, 0, 0, 0.08);
            border-radius: 0.8vh;
            overflow: hidden;
        }

        /* Left Panel - Logo Section */
        .auth-left {
            flex: 0 0 45%;
            background: #0a1f44;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 6vh 4vw;
            position: relative;
        }

        .logo-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 2vh;
        }

        .logo-text {
            color: white;
            font-size: clamp(1.2rem, 3vw, 2.5rem);
            font-weight: 700;
            letter-spacing: 0.5vw;
            text-align: center;
        }

        .logo-icon {
            width: clamp(50px, 6vw, 80px);
            height: clamp(50px, 6vw, 80px);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hexagon {
            width: 100%;
            height: 100%;
            background: white;
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hexagon-inner {
            width: 82%;
            height: 82%;
            background: #0a1f44;
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
        }

        /* Right Panel - Form Section */
        .auth-right {
            flex: 0 0 55%;
            padding: 4vh 5vw;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
            overflow-y: auto;
        }

        .auth-title {
            text-align: center;
            margin-bottom: 1vh;
        }

        .auth-title h1 {
            font-size: clamp(1.5rem, 3vw, 2.25rem);
            font-weight: 700;
            color: #0a1f44;
            margin: 0;
            letter-spacing: -0.03vw;
        }

        .auth-subtitle {
            text-align: center;
            color: #6c757d;
            font-size: clamp(0.75rem, 1.2vw, 0.875rem);
            margin-bottom: 3vh;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 2vh;
        }

        .form-label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 0.7vh;
            font-size: clamp(0.7rem, 1.1vw, 0.813rem);
        }

        .form-control {
            width: 100%;
            padding: 1.2vh 1.5vw;
            border: 1px solid #ced4da;
            border-radius: 0.4vh;
            font-size: clamp(0.75rem, 1.2vw, 0.875rem);
            transition: all 0.3s ease;
            background: white;
            color: #495057;
        }

        .form-control:focus {
            outline: none;
            border-color: #2d4a7c;
            box-shadow: 0 0 0 0.3vh rgba(45, 74, 124, 0.08);
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper .form-control {
            padding-right: 4vw;
        }

        .password-toggle {
            position: absolute;
            right: 1.5vw;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            cursor: pointer;
            font-size: clamp(0.8rem, 1.3vw, 0.938rem);
            transition: color 0.2s ease;
        }

        .password-toggle:hover {
            color: #2d4a7c;
        }

        .forgot-link {
            text-align: right;
            margin-top: 0.8vh;
        }

        .forgot-link a {
            color: #2d4a7c;
            text-decoration: none;
            font-size: clamp(0.7rem, 1.1vw, 0.813rem);
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .forgot-link a:hover {
            color: #1e3558;
            text-decoration: underline;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 1vw;
            margin-bottom: 2.4vh;
        }

        .remember-me input[type="checkbox"] {
            width: 1.7vh;
            height: 1.7vh;
            cursor: pointer;
            accent-color: #2d4a7c;
        }

        .remember-me label {
            color: #495057;
            font-size: clamp(0.7rem, 1.1vw, 0.813rem);
            cursor: pointer;
            margin: 0;
            user-select: none;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 1vw;
            margin-bottom: 2.4vh;
        }

        .remember-me input[type="checkbox"] {
            width: 1.7vh;
            height: 1.7vh;
            cursor: pointer;
            accent-color: #2d4a7c;
        }

        .remember-me label {
            color: #495057;
            font-size: clamp(0.7rem, 1.1vw, 0.813rem);
            cursor: pointer;
            margin: 0;
            user-select: none;
        }

        .btn-submit {
            width: 100%;
            padding: 1.3vh 0;
            background: #2d4a7c;
            color: white;
            border: none;
            border-radius: 0.4vh;
            font-size: clamp(0.8rem, 1.3vw, 0.938rem);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1.8vh;
            letter-spacing: 0.03vw;
        }

        .btn-submit:hover {
            background: #1e3558;
            transform: translateY(-0.1vh);
            box-shadow: 0 0.4vh 1.2vh rgba(45, 74, 124, 0.25);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 2vh 0;
            color: #6c757d;
            font-size: clamp(0.7rem, 1.1vw, 0.813rem);
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #dee2e6;
        }

        .divider span {
            padding: 0 1.5vw;
            font-weight: 500;
        }

        .btn-google {
            width: 100%;
            padding: 1.2vh 0;
            background: white;
            color: #444;
            border: 1px solid #dadce0;
            border-radius: 0.4vh;
            font-size: clamp(0.8rem, 1.3vw, 0.938rem);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1vw;
            margin-bottom: 1.5vh;
        }

        .btn-google:hover {
            background: #f8f9fa;
            border-color: #c6c6c6;
            box-shadow: 0 0.1vh 0.3vh rgba(0, 0, 0, 0.1);
        }

        .btn-google svg {
            width: clamp(16px, 1.5vw, 18px);
            height: clamp(16px, 1.5vw, 18px);
        }

        .auth-footer {
            text-align: center;
            color: #6c757d;
            font-size: clamp(0.7rem, 1.1vw, 0.813rem);
            padding-top: 0.8vh;
        }

        .auth-footer a {
            color: #2d4a7c;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .auth-footer a:hover {
            color: #1e3558;
            text-decoration: underline;
        }

        .hidden {
            display: none !important;
        }

        /* Step Progress for Signup */
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3vh;
            position: relative;
            padding: 0 2vw;
        }

        .step-indicator::before {
            content: '';
            position: absolute;
            top: 1.8vh;
            left: 25%;
            right: 25%;
            height: 0.2vh;
            background: #dee2e6;
            z-index: 0;
        }

        .progress-line {
            position: absolute;
            top: 1.8vh;
            left: 25%;
            height: 0.2vh;
            background: #2d4a7c;
            transition: width 0.4s ease;
            z-index: 1;
        }

        .step-item {
            flex: 1;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .step-circle {
            width: 3.6vh;
            height: 3.6vh;
            border-radius: 50%;
            background: white;
            border: 0.2vh solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.6vh;
            font-weight: 600;
            color: #adb5bd;
            transition: all 0.3s ease;
            font-size: clamp(0.75rem, 1.2vw, 0.875rem);
        }

        .step-item.active .step-circle {
            border-color: #2d4a7c;
            background: #2d4a7c;
            color: white;
            box-shadow: 0 0.2vh 0.8vh rgba(45, 74, 124, 0.3);
        }

        .step-item.completed .step-circle {
            border-color: #2d4a7c;
            background: #2d4a7c;
            color: white;
        }

        .step-name {
            font-size: clamp(0.6rem, 1vw, 0.688rem);
            color: #6c757d;
            font-weight: 500;
        }

        .step-item.active .step-name {
            color: #2d4a7c;
            font-weight: 600;
        }

        .signup-step {
            display: none;
        }

        .signup-step.active {
            display: block;
        }

        .navigation-buttons {
            display: flex;
            gap: 1.2vw;
            margin-top: 2.4vh;
        }

        .btn-back {
            flex: 1;
            padding: 1.3vh 0;
            background: #f8f9fa;
            color: #495057;
            border: 1px solid #dee2e6;
            border-radius: 0.4vh;
            font-size: clamp(0.75rem, 1.2vw, 0.875rem);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-back:hover {
            background: #e9ecef;
            border-color: #adb5bd;
        }

        .btn-next {
            flex: 1;
            padding: 1.3vh 0;
            background: #2d4a7c;
            color: white;
            border: none;
            border-radius: 0.4vh;
            font-size: clamp(0.75rem, 1.2vw, 0.875rem);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-next:hover {
            background: #1e3558;
            transform: translateY(-0.1vh);
            box-shadow: 0 0.4vh 1.2vh rgba(45, 74, 124, 0.25);
        }

        .btn-next:active {
            transform: translateY(0);
        }

        select.form-control {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23495057' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1.5vw center;
            padding-right: 4vw;
        }

        .password-strength {
            height: 0.5vh;
            margin-top: 0.8vh;
            background: #e9ecef;
            border-radius: 0.3vh;
            overflow: hidden;
        }

        .strength-bar {
            height: 100%;
            width: 0;
            transition: all 0.3s ease;
            border-radius: 0.3vh;
        }

        .weak { background: linear-gradient(to right, #dc3545, #e35d6a); width: 33%; }
        .medium { background: linear-gradient(to right, #ffc107, #ffcd39); width: 66%; }
        .strong { background: linear-gradient(to right, #28a745, #34ce57); width: 100%; }

        /* Tablet Responsive */
        @media (max-width: 1024px) {
            .auth-container {
                width: 92vw;
            }

            .auth-right {
                padding: 4vh 4vw;
            }
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            body {
                padding: 1.5vh 2vw;
            }

            .auth-container {
                flex-direction: column;
                min-height: auto;
                width: 95vw;
            }

            .auth-left {
                flex: 0 0 auto;
                padding: 4vh 3vw;
                min-height: 20vh;
            }

            .logo-wrapper {
                gap: 1.5vh;
            }

            .logo-text {
                letter-spacing: 0.4vw;
            }

            .auth-right {
                flex: 0 0 auto;
                padding: 4vh 5vw;
            }

            .form-group {
                margin-bottom: 1.8vh;
            }

            .step-indicator {
                padding: 0 1vw;
                margin-bottom: 2.5vh;
            }

            .step-indicator::before {
                left: 20%;
                right: 20%;
                top: 1.6vh;
            }

            .progress-line {
                left: 20%;
                top: 1.6vh;
            }

            .step-circle {
                width: 3.2vh;
                height: 3.2vh;
            }

            .navigation-buttons {
                gap: 2vw;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 1vh 2vw;
            }

            .auth-left {
                padding: 3vh 3vw;
                min-height: 16vh;
            }

            .logo-wrapper {
                gap: 1.2vh;
            }

            .logo-text {
                letter-spacing: 0.3vw;
            }

            .auth-right {
                padding: 3vh 5vw;
            }

            .auth-subtitle {
                margin-bottom: 2.5vh;
            }

            .form-control {
                padding: 1.1vh 3vw;
            }

            .input-wrapper .form-control {
                padding-right: 10vw;
            }

            .password-toggle {
                right: 3vw;
            }

            .step-indicator {
                padding: 0 1vw;
                margin-bottom: 2.2vh;
            }

            .step-circle {
                width: 2.8vh;
                height: 2.8vh;
            }

            .navigation-buttons {
                gap: 2.5vw;
                margin-top: 2vh;
            }

            select.form-control {
                background-position: right 3vw center;
                padding-right: 10vw;
            }
        }
    </style>
</head>
<body>
    <!-- Login Form -->
    <div id="loginForm" class="auth-container">
        <div class="auth-left">
            <div class="logo-wrapper">
                <span class="logo-text">HUMAN RESOURCES</span>
                <div class="logo-icon">
                    <div class="hexagon">
                        <div class="hexagon-inner"></div>
                    </div>
                </div>
                <span class="logo-text">MANAGEMENT</span>
            </div>
        </div>
        <div class="auth-right">
            <div class="auth-title">
                <h1>Login</h1>
            </div>
            <div class="auth-subtitle">
                Sign in to your account
            </div>
            <form id="loginFormElement">
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="loginPassword" class="form-control" required>
                        <i class="fas fa-eye password-toggle" onclick="togglePassword('loginPassword', this)"></i>
                    </div>
                    <div class="forgot-link">
                        <a href="#" onclick="showForgotPassword(event)">Forgot Password?</a>
                    </div>
                </div>
                <button type="submit" class="btn-submit">Login</button>
                
                <div class="divider">
                    <span>OR</span>
                </div>
                
                <button type="button" class="btn-google" onclick="googleAuth()">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.64 9.20443C17.64 8.56625 17.5827 7.95262 17.4764 7.36353H9V10.8449H13.8436C13.635 11.9699 13.0009 12.9231 12.0477 13.5613V15.8194H14.9564C16.6582 14.2526 17.64 11.9453 17.64 9.20443Z" fill="#4285F4"/>
                        <path d="M8.99976 18C11.4298 18 13.467 17.1941 14.9561 15.8195L12.0475 13.5613C11.2416 14.1013 10.2107 14.4204 8.99976 14.4204C6.65567 14.4204 4.67158 12.8372 3.96385 10.71H0.957031V13.0418C2.43794 15.9831 5.48158 18 8.99976 18Z" fill="#34A853"/>
                        <path d="M3.96409 10.7098C3.78409 10.1698 3.68182 9.59301 3.68182 8.99983C3.68182 8.40665 3.78409 7.82983 3.96409 7.28983V4.95801H0.957273C0.347727 6.17301 0 7.54755 0 8.99983C0 10.4521 0.347727 11.8266 0.957273 13.0416L3.96409 10.7098Z" fill="#FBBC05"/>
                        <path d="M8.99976 3.57955C10.3211 3.57955 11.5075 4.03364 12.4402 4.92545L15.0216 2.34409C13.4629 0.891818 11.4257 0 8.99976 0C5.48158 0 2.43794 2.01682 0.957031 4.95818L3.96385 7.29C4.67158 5.16273 6.65567 3.57955 8.99976 3.57955Z" fill="#EA4335"/>
                    </svg>
                    Continue with Google
                </button>
            </form>
            <div class="auth-footer">
                Don't have an account? <a onclick="switchToSignup()">Sign Up</a>
            </div>
        </div>
    </div>

    <!-- Signup Form -->
    <div id="signupForm" class="auth-container hidden">
        <div class="auth-left">
            <div class="logo-wrapper">
                <span class="logo-text">HUMAN RESOURCES</span>
                <div class="logo-icon">
                    <div class="hexagon">
                        <div class="hexagon-inner"></div>
                    </div>
                </div>
                <span class="logo-text">MANAGEMENT</span>
            </div>
        </div>
        <div class="auth-right">
            <div class="auth-title">
                <h1>Create Account</h1>
            </div>
            <div class="auth-subtitle">
                Join our HR Management System
            </div>

            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="progress-line" id="progressLine"></div>
                <div class="step-item active" data-step="1">
                    <div class="step-circle">1</div>
                    <div class="step-name">Basic Info</div>
                </div>
                <div class="step-item" data-step="2">
                    <div class="step-circle">2</div>
                    <div class="step-name">Security</div>
                </div>
                <div class="step-item" data-step="3">
                    <div class="step-circle">3</div>
                    <div class="step-name">Details</div>
                </div>
            </div>

            <form id="signupFormElement">
                <!-- Step 1: Basic Info -->
                <div class="signup-step active" data-step="1">
                    <div class="form-group">
                        <label class="form-label">Employee ID</label>
                        <input type="text" id="employeeId" class="form-control" placeholder="Enter your employee ID" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" id="fullName" class="form-control" placeholder="Enter your full name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" id="signupEmail" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" id="phone" class="form-control" placeholder="Enter your phone number" required>
                    </div>
                </div>

                <!-- Step 2: Account Security -->
                <div class="signup-step" data-step="2">
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-wrapper">
                            <input type="password" id="signupPassword" class="form-control" placeholder="Create a strong password" required oninput="checkStrength()">
                            <i class="fas fa-eye password-toggle" onclick="togglePassword('signupPassword', this)"></i>
                        </div>
                        <div class="password-strength">
                            <div class="strength-bar" id="strengthBar"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <div class="input-wrapper">
                            <input type="password" id="confirmPassword" class="form-control" placeholder="Re-enter your password" required>
                            <i class="fas fa-eye password-toggle" onclick="togglePassword('confirmPassword', this)"></i>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Professional Details -->
                <div class="signup-step" data-step="3">
                    <div class="form-group">
                        <label class="form-label">Department</label>
                        <select class="form-control" id="department" required>
                            <option value="">Select Department</option>
                            <option value="hr">Human Resources</option>
                            <option value="it">Information Technology</option>
                            <option value="finance">Finance</option>
                            <option value="sales">Sales</option>
                            <option value="marketing">Marketing</option>
                            <option value="operations">Operations</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Position</label>
                        <input type="text" id="position" class="form-control" placeholder="e.g., Software Engineer" required>
                    </div>
                    <div class="remember-me">
                        <input type="checkbox" id="agreeTerms" required>
                        <label for="agreeTerms">I agree to the Terms and Conditions</label>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="navigation-buttons">
                    <button type="button" class="btn-back" id="backBtn" onclick="prevStep()" style="display: none;">
                        <i class="fas fa-arrow-left"></i> Previous
                    </button>
                    <button type="button" class="btn-next" id="continueBtn" onclick="nextStep()">
                        Next <i class="fas fa-arrow-right"></i>
                    </button>
                    <button type="submit" class="btn-next" id="finishBtn" style="display: none;">
                        <i class="fas fa-check"></i> Create Account
                    </button>
                </div>
                
                <div class="divider">
                    <span>OR</span>
                </div>
                
                <button type="button" class="btn-google" onclick="googleAuth()">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.64 9.20443C17.64 8.56625 17.5827 7.95262 17.4764 7.36353H9V10.8449H13.8436C13.635 11.9699 13.0009 12.9231 12.0477 13.5613V15.8194H14.9564C16.6582 14.2526 17.64 11.9453 17.64 9.20443Z" fill="#4285F4"/>
                        <path d="M8.99976 18C11.4298 18 13.467 17.1941 14.9561 15.8195L12.0475 13.5613C11.2416 14.1013 10.2107 14.4204 8.99976 14.4204C6.65567 14.4204 4.67158 12.8372 3.96385 10.71H0.957031V13.0418C2.43794 15.9831 5.48158 18 8.99976 18Z" fill="#34A853"/>
                        <path d="M3.96409 10.7098C3.78409 10.1698 3.68182 9.59301 3.68182 8.99983C3.68182 8.40665 3.78409 7.82983 3.96409 7.28983V4.95801H0.957273C0.347727 6.17301 0 7.54755 0 8.99983C0 10.4521 0.347727 11.8266 0.957273 13.0416L3.96409 10.7098Z" fill="#FBBC05"/>
                        <path d="M8.99976 3.57955C10.3211 3.57955 11.5075 4.03364 12.4402 4.92545L15.0216 2.34409C13.4629 0.891818 11.4257 0 8.99976 0C5.48158 0 2.43794 2.01682 0.957031 4.95818L3.96385 7.29C4.67158 5.16273 6.65567 3.57955 8.99976 3.57955Z" fill="#EA4335"/>
                    </svg>
                    Continue with Google
                </button>
            </form>

            <div class="auth-footer">
                Already have an account? <a onclick="switchToLogin()">Login</a>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 3;

        function togglePassword(id, icon) {
            const input = document.getElementById(id);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function checkStrength() {
            const pwd = document.getElementById('signupPassword').value;
            const bar = document.getElementById('strengthBar');
            let strength = 0;
            if (pwd.length >= 8) strength++;
            if (pwd.match(/[a-z]/) && pwd.match(/[A-Z]/)) strength++;
            if (pwd.match(/[0-9]/)) strength++;
            if (pwd.match(/[^a-zA-Z0-9]/)) strength++;

            bar.className = 'strength-bar';
            if (strength <= 1) bar.classList.add('weak');
            else if (strength <= 3) bar.classList.add('medium');
            else bar.classList.add('strong');
        }

        function switchToSignup() {
            document.getElementById('loginForm').classList.add('hidden');
            document.getElementById('signupForm').classList.remove('hidden');
            currentStep = 1;
            updateSteps();
        }

        function switchToLogin() {
            document.getElementById('signupForm').classList.add('hidden');
            document.getElementById('loginForm').classList.remove('hidden');
        }

        function nextStep() {
            const step = document.querySelector(`.signup-step[data-step="${currentStep}"]`);
            const inputs = step.querySelectorAll('input[required], select[required]');
            let valid = true;

            inputs.forEach(input => {
                if (!input.value) {
                    input.style.borderColor = '#ff4444';
                    valid = false;
                } else {
                    input.style.borderColor = '#d0d0d0';
                }
            });

            if (currentStep === 2) {
                const pwd = document.getElementById('signupPassword').value;
                const confirm = document.getElementById('confirmPassword').value;
                if (pwd !== confirm) {
                    alert('Passwords do not match!');
                    return;
                }
            }

            if (!valid) return;

            if (currentStep < totalSteps) {
                currentStep++;
                updateSteps();
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                currentStep--;
                updateSteps();
            }
        }

        function updateSteps() {
            document.querySelectorAll('.signup-step').forEach(s => s.classList.remove('active'));
            document.querySelector(`.signup-step[data-step="${currentStep}"]`).classList.add('active');

            document.querySelectorAll('.step-item').forEach((item, i) => {
                item.classList.remove('active', 'completed');
                if (i + 1 < currentStep) item.classList.add('completed');
                else if (i + 1 === currentStep) item.classList.add('active');
            });

            // Fixed progress bar calculation for 3 steps
            const progress = ((currentStep - 1) / (totalSteps - 1)) * 50;
            document.getElementById('progressLine').style.width = progress + '%';

            document.getElementById('backBtn').style.display = currentStep === 1 ? 'none' : 'block';
            document.getElementById('continueBtn').style.display = currentStep === totalSteps ? 'none' : 'block';
            document.getElementById('finishBtn').style.display = currentStep === totalSteps ? 'block' : 'none';
        }

        function showForgotPassword(e) {
            e.preventDefault();
            const email = prompt('Enter your email address:');
            if (email && email.trim()) {
                alert(`Password reset link sent to ${email}`);
            }
        }

        document.getElementById('loginFormElement').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Login successful!');
        });

        document.getElementById('signupFormElement').addEventListener('submit', function(e) {
            e.preventDefault();
            if (!document.getElementById('agreeTerms').checked) {
                alert('Please agree to Terms and Conditions');
                return;
            }

            // Collect registration data
            const registrationData = {
                employeeId: document.getElementById('employeeId').value,
                fullName: document.getElementById('fullName').value,
                email: document.getElementById('signupEmail').value,
                password: document.getElementById('signupPassword').value,
                phone: document.getElementById('phone').value,
                department: document.getElementById('department').value,
                position: document.getElementById('position').value
            };

            console.log('Registration Data:', registrationData);
            alert('Account created successfully! Welcome ' + registrationData.fullName);
        });
    </script>
</body>
</html>