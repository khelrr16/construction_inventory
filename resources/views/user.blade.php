<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Pending - Awaiting Admin Assignment</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .card-container {
            max-width: 500px;
            width: 100%;
            padding: 20px;
        }
        
        .status-card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: none;
        }
        
        .card-header {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            text-align: center;
            padding: 30px 20px;
            border-bottom: none;
        }
        
        .card-body {
            padding: 40px 30px;
            text-align: center;
        }
        
        .status-icon {
            font-size: 5rem;
            color: #6c757d;
            margin-bottom: 20px;
        }
        
        .spinner-border {
            width: 3rem;
            height: 3rem;
            margin: 20px 0;
        }
        
        .btn-logout {
            background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-logout:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 75, 43, 0.4);
        }
        
        .status-text {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 30px;
        }
        
        .card-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="card status-card">
            <div class="card-header">
                <h1 class="h3 mb-0">Account Status</h1>
            </div>
            <div class="card-body">
                <div class="status-icon">
                    <i class="fas fa-user-clock"></i>
                </div>
                <h2 class="h4 mb-3">Your Role is Unset</h2>
                <p class="status-text">
                    Please wait while the administrator assigns your role. This process typically takes a few minutes.
                </p>
                
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                
                <p class="mt-3 text-muted">
                    <small>Waiting for admin assignment...</small>
                </p>
                
                <form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="btn btn-logout text-white">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </button>
                </form>
            </div>
            <div class="card-footer">
                <i class="fas fa-info-circle me-2"></i>
                You will be notified once your role has been assigned
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>