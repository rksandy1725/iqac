<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $survey->title }} - Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f1f5f9; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem; }
        .survey-card { max-width: 600px; width: 100%; }
        .star-rating { display: flex; gap: 8px; }
        .star-rating input { display: none; }
        .star-rating label { font-size: 2rem; color: #d1d5db; cursor: pointer; transition: all 0.2s; }
        .star-rating label:hover, .star-rating input:checked ~ label { color: #f59e0b; }
        .star-rating label:hover { transform: scale(1.1); }
        .btn-submit { background: linear-gradient(135deg, #3b82f6, #2563eb); border: none; height: 48px; border-radius: 10px; font-weight: 600; }
        .btn-submit:hover { background: linear-gradient(135deg, #2563eb, #1d4ed8); transform: translateY(-1px); box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3); }
    </style>
</head>
<body>
    <div class="survey-card">
        <div class="text-center mb-4">
            <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle mb-3" style="width:56px;height:56px;">
                <i class="bi bi-chat-dots text-primary" style="font-size:1.5rem;"></i>
            </div>
            <h4 class="fw-bold text-dark">{{ $survey->title }}</h4>
            @if($survey->description)
                <p class="text-muted">{{ $survey->description }}</p>
            @endif
        </div>

        <div class="card border-0 shadow-sm" style="border-radius:12px;">
            <div class="card-body p-4">
                <form action="{{ route('feedback.submit', $survey) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Your Name (Optional)</label>
                        <input type="text" class="form-control" name="respondent_name" placeholder="Enter your name">
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Your Email (Optional)</label>
                        <input type="email" class="form-control" name="respondent_email" placeholder="Enter your email">
                    </div>

                    <div class="mb-4 text-center">
                        <label class="form-label small fw-semibold d-block mb-3">Rate Your Experience *</label>
                        <div class="star-rating justify-content-center">
                            <input type="radio" id="star5" name="rating" value="5" required>
                            <label for="star5"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" id="star4" name="rating" value="4">
                            <label for="star4"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" id="star3" name="rating" value="3">
                            <label for="star3"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" id="star2" name="rating" value="2">
                            <label for="star2"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" id="star1" name="rating" value="1">
                            <label for="star1"><i class="bi bi-star-fill"></i></label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Comments / Suggestions</label>
                        <textarea class="form-control" name="comments" rows="4" placeholder="Share your feedback..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-submit w-100">
                        <i class="bi bi-send me-2"></i>Submit Feedback
                    </button>
                </form>
            </div>
        </div>

        <div class="text-center mt-3">
            <small class="text-muted">Powered by <strong>IQAC Management System</strong></small>
        </div>
    </div>
</body>
</html>
