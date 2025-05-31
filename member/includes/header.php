<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>COIN-PAY - Digital Wallet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #6c5ce7;
            --primary-dark: #5649c0;
            --secondary: #a29bfe;
            --dark: #2d3436;
            --light: #f5f6fa;
            --success: #00b894;
            --danger: #d63031;
            --warning: #fdcb6e;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            overflow-x: hidden;
        }
        .navbar-main {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            height: 70px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            padding: 0 1rem;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary);
            font-size: 1.5rem;
        }
        .sidebar {
            width: 250px;
            position: fixed;
            top: 70px;
            left: 0;
            bottom: 0;
            z-index: 1020;
            background: white;
            box-shadow: 1px 0 10px rgba(0,0,0,0.1);
            transition: all 0.3s;
            overflow-y: auto;
        }
        
        .main-content {
            margin-left: 250px;
            margin-top: 60px;
            padding: 20px;
            transition: all 0.3s;
            min-height: calc(100vh - 70px);
        }
        
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .sidebar-show .sidebar {
                transform: translateX(0);
            }
            
            .sidebar-show .main-content {
                margin-left: 250px;
            }
            
            .overlay {
                position: fixed;
                top: 70px;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1010;
                display: none;
            }
            
            .sidebar-show .overlay {
                display: block;
            }
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
            margin-bottom: 20px;
        }
        
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            font-weight: 600;
        }
        
        .sidebar-menu {
            padding: 15px 0;
        }
        
        .sidebar-menu .nav-link {
            color: #555;
            padding: 12px 20px;
            margin: 3px 0;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .sidebar-menu .nav-link:hover,
        .sidebar-menu .nav-link.active {
            background: rgba(108, 92, 231, 0.1);
            color: var(--primary);
        }
        
        .sidebar-menu .nav-link i {
            width: 24px;
            text-align: center;
            margin-right: 10px;
            font-size: 1.1rem;
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 0.65rem;
            padding: 3px 6px;
        }
        
        .chat-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(108, 92, 231, 0.4);
            z-index: 1000;
            transition: all 0.3s;
        }
        
        .chat-button:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
        }

    #sidebar {
        width: 250px;
        float: left;
        transition: all 0.3s ease;
    }

    .main-content {
        margin-left: 250px;
        transition: all 0.3s ease;
    }

    .collapsed #sidebar {
        display: none;
    }

    .collapsed .main-content {
        margin-left: 10px;
    }

    </style>
</head>