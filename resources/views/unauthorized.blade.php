<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized Access</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #8B0000; /* Dark red */
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
        }
        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.5rem;
            margin-bottom: 30px;
        }
        img {
            max-width: 100px;
            margin-bottom: 20px;
        }
        a {
            color: white;
            text-decoration: underline;
            font-size: 1.2rem;
            margin-right: 10px;
        }
        a:hover {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <img src="{{ asset('assets/images/navbaricon.png') }}" alt="Logo">
    <h1>Unauthorized Access</h1>
    <p>You do not have permission to access this page.</p>
    <a href="javascript:history.back()">Go Back</a>
</body>
</html>