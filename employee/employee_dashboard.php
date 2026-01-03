<?php
require_once 'config.php';
requireLogin();

$user = getCurrentUser();
$conn = getDBConnection();
$user_id = $_SESSION['user_id'];

// Get attendance stats for current month
$current_month = date('Y-m');
$attendance_stmt = $conn->prepare("
    SELECT 
        COUNT(*) as total_days,
        SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present_days,
        SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent_days,
        SUM(CASE WHEN status = 'leave' THEN 1 ELSE 0 END) as leave_days
    FROM attendance 
    WHERE user_id = ? AND DATE_FORMAT(date, '%Y-%m') = ?
");
$attendance_stmt->bind_param("is", $user_id, $current_month);
$attendance_stmt->execute();
$attendance_stats = $attendance_stmt->get_result()->fetch_assoc();
$attendance_stmt->close();

// Get leave balance for current year
$current_year = date('Y');
$leave_stmt = $conn->prepare("
    SELECT * FROM leave_balance 
    WHERE user_id = ? AND year = ?
");
$leave_stmt->bind_param("ii", $user_id, $current_year);
$leave_stmt->execute();
$leave_balance = $leave_stmt->get_result()->fetch_assoc();
$leave_stmt->close();

// Get pending leave requests
$pending_leaves_stmt = $conn->prepare("
    SELECT COUNT(*) as pending_count 
    FROM leave_requests 
    WHERE user_id = ? AND status = 'pending'
");
$pending_leaves_stmt->bind_param("i", $user_id);
$pending_leaves_stmt->execute();
$pending_leaves = $pending_leaves_stmt->get_result()->fetch_assoc();
$pending_leaves_stmt->close();

// Get recent activities
$activity_stmt = $conn->prepare("
    SELECT action, description, created_at 
    FROM activity_log 
    WHERE user_id = ? 
    ORDER BY created_at DESC 
    LIMIT 5
");
$activity_stmt->bind_param("i", $user_id);
$activity_stmt->execute();
$activities = $activity_stmt->get_result();

// Get unread notifications
$notif_stmt = $conn->prepare("
    SELECT COUNT(*) as unread_count 
    FROM notifications 
    WHERE user_id = ? AND is_read = FALSE
");
$notif_stmt->bind_param("i", $user_id);
$notif_stmt->execute();
$notifications = $notif_stmt->get_result()->fetch_assoc();
$notif_stmt->close();

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $log_stmt = $conn->prepare("INSERT INTO activity_log (user_id, action, description, ip_address) VALUES (?, 'logout', 'User logged out', ?)");
    $ip = $_SERVER['REMOTE_ADDR'];
    $log_stmt->bind_param("is", $user_id, $ip);
    $log_stmt->execute();
    $log_stmt->close();
    
    session_destroy();
    header('Location: login.php');
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard - Dayflow HRMS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #333;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            font-size: 28px;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #667eea;
            font-size: 18px;
        }
        
        .user-details {
            text-align: right;
        }
        
        .user-name {
            font-weight: 600;
            font-size: 16px;
        }
        
        .user-role {
            font-size: 13px;
            opacity: 0.9;
        }
        
        .notification-badge {
            position: relative;
            cursor: pointer;
        }
        
        .notification-badge svg {
            width: 24px;
            height: 24px;
        }
        
        .badge-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ff4757;
            color: white;
            border-radius: 10px;
            padding: 2px 6px;
            font-size: 11px;
            font-weight: bold;
        }
        
        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 40px;
        }
        
        .welcome-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .welcome-section h2 {
            color: #667eea;
            margin-bottom: 8px;
            font-size: 24px;
        }
        
        .welcome-section p {
            color: #666;
            font-size: 14px;
        }
        
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            border-left: 4px solid;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .card.profile {
            border-left-color: #667eea;
        }
        
        .card.attendance {
            border-left-color: #f368e0;
        }
        
        .card.leave {
            border-left-color: #ff6b6b;
        }
        
        .card.logout {
            border-left-color: #feca57;
        }
        
        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            font-size: 24px;
        }
        
        .card.profile .card-icon {
            background: #e6e9fc;
            color: #667eea;
        }
        
        .card.attendance .card-icon {
            background: #fde8f7;
            color: #f368e0;
        }
        
        .card.leave .card-icon {
            background: #ffe0e0;
            color: #ff6b6b;
        }
        
        .card.logout .card-icon {
            background: #fff3d9;
            color: #feca57;
        }
        
        .card h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
        }
        
        .card-stats {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }
        
        .stat-item {
            flex: 1;
        }
        
        .stat-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .stat-value {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
        
        .card-info {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }
        
        .recent-activity {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .recent-activity h3 {
            margin-bottom: 20px;
            color: #333;
            font-size: 20px;
        }
        
        .activity-item {
            padding: 15px;
            border-left: 3px solid #667eea;
            background: #f8f9fa;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        
        .activity-action {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        
        .activity-description {
            font-size: 13px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .activity-time {
            font-size: 12px;
            color: #999;
        }
        
        .no-activity {
            text-align: center;
            padding: 30px;
            color: #999;
        }
        
        .logout-btn {
            background: #ff4757;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }
        
        .logout-btn:hover {
            background: #ff3838;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 0 20px;
            }
            
            .header {
                padding: 15px 20px;
            }
            
            .cards-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>Dayflow HRMS</h1>
            <div class="header-right">
                <div class="notification-badge">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
                    </svg>
                    <?php if ($notifications['unread_count'] > 0): ?>
                        <span class="badge-count"><?php echo $notifications['unread_count']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="user-info">
                    <div class="avatar">
                        <?php echo strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1)); ?>
                    </div>
                    <div class="user-details">
                        <div class="user-name"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></div>
                        <div class="user-role"><?php echo ucfirst($user['role']); ?> • <?php echo htmlspecialchars($user['employee_id']); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="welcome-section">
            <h2>Welcome back, <?php echo htmlspecialchars($user['first_name']); ?>! 👋</h2>
            <p>Here's what's happening with your account today.</p>
        </div>
        
        <div class="cards-grid">
            <!-- Profile Card -->
            <div class="card profile" onclick="location.href='profile.php'">
                <div class="card-icon">👤</div>
                <h3>My Profile</h3>
                <div class="card-info">
                    <strong>Department:</strong> <?php echo htmlspecialchars(isset($user['department']) && $user['department'] ? $user['department'] : 'Not assigned'); ?><br>
                    <strong>Designation:</strong> <?php echo htmlspecialchars(isset($user['designation']) && $user['designation'] ? $user['designation'] : 'Not assigned'); ?>
                </div>
            </div>
            
            <!-- Attendance Card -->
            <div class="card attendance" onclick="location.href='attendance.php'">
                <div class="card-icon">📅</div>
                <h3>Attendance</h3>
                <div class="card-stats">
                    <div class="stat-item">
                        <div class="stat-label">Present</div>
                        <div class="stat-value"><?php echo isset($attendance_stats['present_days']) ? $attendance_stats['present_days'] : 0; ?></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Absent</div>
                        <div class="stat-value"><?php echo isset($attendance_stats['absent_days']) ? $attendance_stats['absent_days'] : 0; ?></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Leave</div>
                        <div class="stat-value"><?php echo isset($attendance_stats['leave_days']) ? $attendance_stats['leave_days'] : 0; ?></div>
                    </div>
                </div>
            </div>
            
            <!-- Leave Requests Card -->
            <div class="card leave" onclick="location.href='leave_requests.php'">
                <div class="card-icon">🏖️</div>
                <h3>Leave Requests</h3>
                <div class="card-info">
                    <strong>Pending Requests:</strong> <?php echo $pending_leaves['pending_count']; ?><br>
                    <?php if ($leave_balance): ?>
                        <strong>Available Leaves:</strong> 
                        Paid: <?php echo $leave_balance['paid_leave']; ?>, 
                        Sick: <?php echo $leave_balance['sick_leave']; ?>, 
                        Casual: <?php echo $leave_balance['casual_leave']; ?>
                    <?php else: ?>
                        <strong>Leave balance not initialized</strong>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Logout Card -->
            <div class="card logout">
                <div class="card-icon">🚪</div>
                <h3>Logout</h3>
                <div class="card-info">
                    Sign out of your account securely
                </div>
                <div style="margin-top: 15px;">
                    <a href="?action=logout" class="logout-btn">Logout Now</a>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity Section -->
        <div class="recent-activity">
            <h3>Recent Activity</h3>
            <?php if ($activities->num_rows > 0): ?>
                <?php while ($activity = $activities->fetch_assoc()): ?>
                    <div class="activity-item">
                        <div class="activity-action"><?php echo htmlspecialchars($activity['action']); ?></div>
                        <div class="activity-description"><?php echo htmlspecialchars($activity['description']); ?></div>
                        <div class="activity-time"><?php echo date('M d, Y h:i A', strtotime($activity['created_at'])); ?></div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-activity">No recent activity to display</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>