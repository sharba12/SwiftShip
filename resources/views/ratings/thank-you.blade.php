<!DOCTYPE html>
<html>
<head>
    <title>Thank You</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8 text-center">
            <div class="text-6xl mb-4">🎉</div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Thank You!</h1>
            <p class="text-gray-600 mb-6">Your feedback helps us improve our service.</p>
            <a href="{{ route('home') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">
                Back to Home
            </a>
        </div>
    </div>
</body>
</html>
