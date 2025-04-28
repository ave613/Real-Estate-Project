<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Heart Icon</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }
        .heart {
            font-size: 100px;
            color: orange;
            cursor: pointer;
            transition: color 0.3s ease-in-out;
        }
        .heart::before {
            content: '\2661'; /* Hollow heart */
        }
        .heart.filled::before {
            content: '\2665'; /* Filled heart */
            color: darkorange;
        }
    </style>
</head>
<body>
    <div class="heart" onclick="toggleHeart()"></div>

    <script>
        function toggleHeart() {
            document.querySelector('.heart').classList.toggle('filled');
        }
    </script>
</body>
</html>
