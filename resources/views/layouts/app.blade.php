<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Review App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        /* Set a light background for the whole page */
        body {
            background-color: #f8f9fa;
        }

        /* Clean white navbar */
        .navbar {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        /* Star rating color */
        .star-rating {
            color: #ffc107; /* Bootstrap's 'warning' yellow */
        }

        /* New styles for horizontal card image on index page */
        .card-img-left {
            width: 100%;
            height: 250px; /* Taller fixed height for list view */
            object-fit: cover; /* This will crop the image nicely */
        }

        /* Style for the poster on the 'show' page */
        .poster-show-page {
            width: 100%;
            height: auto;
            max-height: 600px;
            object-fit: contain;
            border-radius: 0.375rem; /* Bootstrap's rounded corners */
        }

        /* Make the review content on the show page more readable */
        .review-content {
            font-size: 1.15rem; /* Slightly larger text */
            line-height: 1.7;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('movies.index') }}">MovieReviews</a>
            <a href="{{ route('movies.create') }}" class="btn btn-primary">Add New Review</a>
        </div>
    </nav>

    <main class="container">
        {{-- Session Success/Error Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Whoops!</strong> There were some problems with your input.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="text-center text-muted py-4 mt-5">
        Movie App &copy; 2025
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Character Counter Script --}}
    <script>
        let searchTimer; // Timer for debouncing (if you want to add it back)
        
        function debounceSubmit(form) {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                form.submit();
            }, 500); 
        }

        function updateCharCount(textarea) {
            const counter = document.getElementById('char-counter');
            if (counter) {
                const currentLength = textarea.value.length;
                const maxLength = textarea.getAttribute('data-maxlength');
                counter.textContent = `${currentLength} / ${maxLength}`;
                
                if (currentLength > maxLength) {
                    counter.classList.add('text-danger');
                } else {
                    counter.classList.remove('text-danger');
                }
            }
        }
        
        document.addEventListener('DOMContentLoaded', (event) => {
            const textarea = document.getElementById('review_content');
            if (textarea) {
                updateCharCount(textarea);
            }
        });
    </script>
    
</body>
</html>