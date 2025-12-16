<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Example</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa; /* Light background for contrast */
        }
        .footer {
            background: linear-gradient(to bottom, #ffffff, #f8f9fa); /* Gradient background */
            color: #343a40; /* Dark text for contrast */
            padding: 40px 20px;
            box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.1);
        }
        .footer .container {
            max-width: 1200px;
            margin: auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .footer .column {
            flex: 1;
            padding: 20px;
            min-width: 220px; /* Minimum width for columns */
            text-align: left; /* Align text to the left */
        }
        .footer h4 {
            margin-bottom: 10px;
            font-weight: bold;
            color: darkred; /* Dark red color for headings */
        }
        .footer hr {
            border: 0;
            height: 1px;
            background: #343a40; /* Dark line for separation */
            margin: 15px 0; /* Spacing for the line */
            opacity: 0.3; /* Lower opacity for a lighter appearance */
        }
        .footer p {
            margin: 5px 0;
            font-size: 16px;
            line-height: 1.5; /* Improved line spacing */
        }
        .footer .contact-info i, .footer .social-media i {
            margin-right: 10px;
        }
        .footer .social-media {
            margin-top: 15px;
            display: flex;
            flex-direction: column; /* Stack icons and names */
        }
        .footer .social-media a {
            display: flex;
            align-items: center; /* Center items vertically */
            margin-bottom: 10px; /* Spacing between items */
            color: darkred; /* Dark red color for icons */
            transition: color 0.3s ease, transform 0.3s ease; /* Animation */
        }
        .footer .social-media a:hover {
            color: #343a40; /* Change color on hover */
            transform: scale(1.1); /* Slight scaling effect */
        }
        .footer .copyright {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            width: 100%;
        }
        .footer .heart {
            color: darkred; /* Dark red color for the heart icon */
        }
        .footer a {
            color: darkred; /* Dark red color */
            text-decoration: none; /* Remove underline from links */
        }
        .footer a:hover {
            text-decoration: underline; /* Underline links on hover */
        }
        @media (max-width: 600px) {
            .footer {
                padding: 20px 10px;
            }
            .footer .column {
                min-width: 100%; /* Stack columns on small screens */
                text-align: center; /* Center text on small screens */
            }
            .footer .social-media {
                justify-content: center; /* Center social media items */
                margin-top: 10px; /* Adjust spacing */
            }
        }
    </style>
</head>
<body>

<footer class="footer">
    <div class="container">
        <div class="column">
            <h4>About Hound</h4>
            <hr>
            <p>Your premier destination for stylish and sophisticated jewelry for men. Discover our exclusive collections designed to elevate your look and express your individuality.</p>
        </div>
        <div class="column">
            <h4>Contact Us</h4>
            <hr>
            <div class="contact-info">
                <p><i class="material-icons">email</i> <a href="mailto:info@hounddevelopers.com">tiphound@gmail.com</a></p>
                <p><i class="material-icons">phone</i> +1 (555) 123-4567</p>
                <p><i class="material-icons">location_on</i> Hound General Aguinaldo Ave, Cubao, Quezon City, Metro Manila</p>
            </div>
        </div>
        <div class="column">
            <h4>Customer Service</h4>
            <hr>
            <p><a href="{{ url('faq') }}">FAQs</a></p>
            <p><a href="{{ url('returnshipping') }}">Return and Shipping Policy</a></p>
        </div>
        <div class="column">
            <h4>Connect with Us</h4>
            <hr>
            <div class="social-media">
                <a href="https://www.facebook.com/people/Hound-Mens-Jewelry/61566929414081/?mibextid=kFxxJD" target="_blank">
                    <i class="fa-brands fa-facebook"></i> Hound Men's Jewelry
                </a>
                <a href="https://www.instagram.com/" target="_blank">
                    <i class="fa-brands fa-instagram"></i> Instagram
                </a>
            </div>
        </div>
    </div>
    <hr>
    <div class="copyright">
        &copy; <span id="year"></span>, made with <i class="material-icons heart">favorite</i> by 
        <strong>Hound Developers</strong> for a better web.
    </div>
</footer>

<script>
    document.getElementById('year').textContent = new Date().getFullYear();
</script>

</body>
</html>