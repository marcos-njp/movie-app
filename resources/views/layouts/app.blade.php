<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Review App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Simple helper for visual star rating */
        .star-rating {
            color: #ffc107;
            /* Bootstrap's 'warning' yellow */
        }

        /* Add this new rule for the index page posters */
        .index-poster-img {
            height: 300px;
            /* Set a fixed height */
            object-fit: cover;
            /* Scale/crop image to fill the space */
            width: 100%;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('movies.index') }}">MovieReviews</a>
        </div>
    </nav>

    <main class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- Add this new script block --}}
<script>
    function updateCharCount(textarea) {
        const counter = document.getElementById('char-counter');
        if (counter) {
            const currentLength = textarea.value.length;
            const maxLength = textarea.getAttribute('data-maxlength');
            counter.textContent = `${currentLength} / ${maxLength}`;

            // Optional: Change color if over limit
            if (currentLength > maxLength) {
                counter.classList.add('text-danger');
            } else {
                counter.classList.remove('text-danger');
            }
        }
    }

    // Run the function on page load in case the form
    // is pre-filled (like on the edit page or after a validation error)
    document.addEventListener('DOMContentLoaded', (event) => {
        const textarea = document.getElementById('review_content');
        if (textarea) {
            updateCharCount(textarea);
        }
    });
</script>
{{-- End of new script block --}}

</html>
