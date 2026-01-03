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
            padding: 30px 15px;
        }

        .auth-container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            min-height: 600px;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-radius: 8px;
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
            padding: 60px 40px;
            position: relative;
        }

        .logo-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }

        .logo-text {
            color: white;
            font-size: 40px;
            font-weight: 700;
            letter-spacing: 8px;
            text-align: center;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hexagon {
            width: 80px;
            height: 80px;
            background: white;
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hexagon-inner {
            width: 66px;
            height: 66px;
            background: #0a1f44;
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
        }

        /* Right Panel - Form Section */
        .auth-right {
            flex: 0 0 55%;
            padding: 40px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
            overflow-y: auto;
        }

        .auth-title {
            text-align: center;
            margin-bottom: 10px;
        }

        .auth-title h1 {
            font-size: 36px;
            font-weight: 700;
            color: #0a1f44;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .auth-subtitle {
            text-align: center;
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 30px;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 7px;
            font-size: 13px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: white;
            color: #495057;
        }

        .form-control:focus {
            outline: none;
            border-color: #2d4a7c;
            box-shadow: 0 0 0 3px rgba(45, 74, 124, 0.08);
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper .form-control {
            padding-right: 45px;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            cursor: pointer;
            font-size: 15px;
            transition: color 0.2s ease;
        }

        .password-toggle:hover {
            color: #2d4a7c;
        }

        .forgot-link {
            text-align: right;
            margin-top: 8px;
        }

        .forgot-link a {
            color: #2d4a7c;
            text-decoration: none;
            font-size: 13px;
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
            gap: 10px;
            margin-bottom: 24px;
        }

        .remember-me input[type="checkbox"] {
            width: 17px;
            height: 17px;
            cursor: pointer;
            accent-color: #2d4a7c;
        }

        .remember-me label {
            color: #495057;
            font-size: 13px;
            cursor: pointer;
            margin: 0;
            user-select: none;
        }

        .btn-submit {
            width: 100%;
            padding: 13px;
            background: #2d4a7c;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 18px;
            letter-spacing: 0.3px;
        }

        .btn-submit:hover {
            background: #1e3558;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(45, 74, 124, 0.25);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .auth-footer {
            text-align: center;
            color: #6c757d;
            font-size: 13px;
            padding-top: 8px;
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
            margin-bottom: 30px;
            position: relative;
            padding: 0 20px;
        }

        .step-indicator::before {
            content: '';
            position: absolute;
            top: 18px;
            left: 20%;
            right: 20%;
            height: 2px;
            background: #dee2e6;
            z-index: 0;
        }

        .progress-line {
            position: absolute;
            top: 18px;
            left: 20%;
            height: 2px;
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
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: white;
            border: 2px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 6px;
            font-weight: 600;
            color: #adb5bd;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .step-item.active .step-circle {
            border-color: #2d4a7c;
            background: #2d4a7c;
            color: white;
            box-shadow: 0 2px 8px rgba(45, 74, 124, 0.3);
        }

        .step-item.completed .step-circle {
            border-color: #2d4a7c;
            background: #2d4a7c;
            color: white;
        }

        .step-name {
            font-size: 11px;
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
            gap: 12px;
            margin-top: 24px;
        }

        .btn-back {
            flex: 1;
            padding: 13px;
            background: #f8f9fa;
            color: #495057;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            font-size: 14px;
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
            padding: 13px;
            background: #2d4a7c;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-next:hover {
            background: #1e3558;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(45, 74, 124, 0.25);
        }

        .btn-next:active {
            transform: translateY(0);
        }

        select.form-control {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23495057' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 40px;
        }

        .password-strength {
            height: 5px;
            margin-top: 8px;
            background: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
        }

        .strength-bar {
            height: 100%;
            width: 0;
            transition: all 0.3s ease;
            border-radius: 3px;
        }

        .weak { background: linear-gradient(to right, #dc3545, #e35d6a); width: 33%; }
        .medium { background: linear-gradient(to right, #ffc107, #ffcd39); width: 66%; }
        .strong { background: linear-gradient(to right, #28a745, #34ce57); width: 100%; }

        /* Tablet Responsive */
        @media (max-width: 1024px) {
            .auth-container {
                max-width: 900px;
            }

            .auth-right {
                padding: 40px 45px;
            }

            .logo-text {
                font-size: 36px;
                letter-spacing: 6px;
            }

            .logo-icon {
                width: 70px;
                height: 70px;
            }

            .hexagon {
                width: 70px;
                height: 70px;
            }

            .hexagon-inner {
                width: 58px;
                height: 58px;
            }

            .auth-title h1 {
                font-size: 32px;
            }
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .auth-container {
                flex-direction: column;
                min-height: auto;
                border-radius: 6px;
                max-width: 100%;
            }

            .auth-left {
                flex: 0 0 auto;
                padding: 35px 25px;
                min-height: 200px;
            }

            .logo-wrapper {
                gap: 15px;
            }

            .logo-text {
                font-size: 28px;
                letter-spacing: 5px;
            }

            .logo-icon {
                width: 60px;
                height: 60px;
            }

            .hexagon {
                width: 60px;
                height: 60px;
            }

            .hexagon-inner {
                width: 50px;
                height: 50px;
            }

            .auth-right {
                flex: 0 0 auto;
                padding: 35px 30px;
            }

            .auth-title h1 {
                font-size: 28px;
            }

            .auth-subtitle {
                font-size: 13px;
                margin-bottom: 25px;
            }

            .form-group {
                margin-bottom: 18px;
            }

            .step-indicator {
                padding: 0 10px;
                margin-bottom: 25px;
            }

            .step-indicator::before {
                left: 18%;
                right: 18%;
                top: 16px;
            }

            .progress-line {
                left: 18%;
                top: 16px;
            }

            .step-circle {
                width: 32px;
                height: 32px;
                font-size: 13px;
            }

            .step-name {
                font-size: 10px;
            }

            .btn-submit, .btn-next, .btn-back {
                padding: 12px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .auth-left {
                padding: 30px 20px;
                min-height: 160px;
            }

            .logo-wrapper {
                gap: 12px;
            }

            .logo-text {
                font-size: 22px;
                letter-spacing: 3px;
            }

            .logo-icon {
                width: 50px;
                height: 50px;
            }

            .hexagon {
                width: 50px;
                height: 50px;
            }

            .hexagon-inner {
                width: 42px;
                height: 42px;
            }

            .auth-right {
                padding: 28px 22px;
            }

            .auth-title h1 {
                font-size: 24px;
            }

            .auth-subtitle {
                font-size: 12px;
                margin-bottom: 22px;
            }

            .form-control {
                padding: 11px 13px;
                font-size: 13px;
            }

            .form-label {
                font-size: 12px;
            }

            .step-indicator {
                padding: 0 5px;
                margin-bottom: 22px;
            }

            .step-circle {
                width: 28px;
                height: 28px;
                font-size: 12px;
            }

            .step-name {
                font-size: 9px;
            }

            .navigation-buttons {
                gap: 10px;
                margin-top: 20px;
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
                <div class="remember-me">
                    <input type="checkbox" id="rememberMe">
                    <label for="rememberMe">Remember me</label>
                </div>
                <button type="submit" class="btn-submit">Login</button>
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
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" id="phone" class="form-control" placeholder="Enter your phone number" required>
                    </div>
                </div>

                <!-- Step 3: Professional Details -->
                <div class="signup-step" data-step="3">
                    <div class="form-group">
                        <label class="form-label">Role</label>
                        <select class="form-control" id="role" required>
                            <option value="">Select your role</option>
                            <option value="employee">Employee</option>
                            <option value="hr">HR</option>
                        </select>
                    </div>
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
                role: document.getElementById('role').value,
                department: document.getElementById('department').value,
                position: document.getElementById('position').value
            };

            console.log('Registration Data:', registrationData);
            alert('Account created successfully! Welcome ' + registrationData.fullName);
        });
    </script>
</body>
</html>