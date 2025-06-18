<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal PPDB SMK Taruna Bangsa - Major Toolbox Modern</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 30px;
        }

        header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            border-radius: 10px;
        }

        .menu-container {
            position: relative;
            display: inline-block;
            margin-top: 40px;
        }

        .major-button {
            background-color: #007BFF;
            color: white;
            padding: 15px 30px;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .major-button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            min-width: 220px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 8px;
            overflow: hidden;
            margin-top: 5px;
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s, transform 0.3s;
        }

        .dropdown-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        /* Responsive */
        @media (max-width: 600px) {
            .major-button {
                width: 100%;
                font-size: 16px;
            }

            .dropdown-content {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>

<header>Portal PPDB SMK Taruna Bangsa</header>

<div class="menu-container">
    <button onclick="toggleDropdown()" class="major-button">MAJOR</button>
    <div id="dropdown" class="dropdown-content">
        <a href="#">Teknik Komputer dan Jaringan</a>
        <a href="#">Akuntansi dan Keuangan</a>
        <a href="#">Perhotelan</a>
        <a href="#">Teknik Otomotif</a>
        <a href="#">Desain Grafis</a>
    </div>
</div>

<script>
    function toggleDropdown() {
        document.getElementById("dropdown").classList.toggle("show");
    }

    // Optional: Tutup dropdown jika klik di luar menu
    window.onclick = function(event) {
        if (!event.target.matches('.major-button')) { 
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>

</body>
</html>
