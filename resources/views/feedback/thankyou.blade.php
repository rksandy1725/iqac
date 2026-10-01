<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thank You - Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .thankyou-card { max-width: 450px; text-align: center; }
        .check-icon { width: 80px; height: 80px; background: linear-gradient(135deg, #22c55e, #16a34a); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; animation: scaleIn 0.5s ease; }
        @keyframes scaleIn { from { transform: scale(0); } to { transform: scale(1); } }
        .check-icon i { font-size: 2.5rem; color: #fff; }
    </style>
</head>
<body>
    <div class="thankyou-card">
        <div class="check-icon">
            <i class="bi bi-check-lg"></i>
        </div>
        <h3 class="fw-bold text-dark mb-2">Thank You!</h3>
        <p class="text-muted mb-4">Your feedback has been submitted successfully. We appreciate your time and input.</p>
        <a href="{{ url('/') }}" class="btn btn-primary" style="background:linear-gradient(135deg,#3b82f6,#2563eb);border:none;border-radius:10px;padding:0.6rem 2rem;">
            <i class="bi bi-house me-2"></i>Back to Home
        </a>
    </div>
</body>
</html>
