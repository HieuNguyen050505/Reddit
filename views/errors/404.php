<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white dark:bg-[#0e1113] ">
    <div class="max-w-lg mx-auto my-24 p-6 flex flex-col items-center justify-center text-center">
        <?php include 'public\icons\error-icon.svg'; ?>
        <h1 class="text-3xl font-bold text-gray-300 my-4">Page Not Found</h1>
        
        <p class="text-gray-500 mb-8">
            Sorry, the page you were looking for doesn't exist or may have been moved.
            <br>
            The link may be broken, or the page may have been removed.
        </p>
        
        <a href="/reddit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
            Go Home
        </a>
    </div>
    
</body>
</html>