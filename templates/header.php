<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

    <title>Sprint 2: Crud Application</title>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <style>
        .hover-trigger .hover-target {
            display: none;
        }

        .hover-trigger:hover .hover-target {
            display: block;
        }
    </style>
</head>
<body>
    <?php include "templates/nav.php"; ?>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">