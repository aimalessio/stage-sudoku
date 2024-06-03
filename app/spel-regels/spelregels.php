<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sudoku Regels</title>
    <style>
        body {
            background-image: url('../spel-regels/images/sudoku.jpg');
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            background-color: #f0f0f0; /* fallback color */
            background-size: cover;
            margin: 0;
            padding-top: 70px; /* Add padding to prevent overlap with fixed header */
        }
        .title {
            font-size: 2em;
            margin-top: 20px; /* Adjust space between header and title */
            margin-bottom: 20px;
            color: white;
        }
        .content {
            background-color: rgba(255, 255, 255, 0.79);
            border: 4px solid white; /* Add white border */
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5); /* Add black box-shadow */
            padding: 20px;
            width: 80%;
            max-width: 800px;
            color: #333;
            display: flex;
            align-items: flex-start; /* Align items to the top */
        }
        .text-content {
            flex: 1;
            padding-right: 20px; /* Space between text and image */
        }
        .text-content h2 {
            text-align: center;
            color: #333;
        }
        .text-content p {
            margin-bottom: 15px;
            line-height: 1.6;
        }
        .text-content ul {
            list-style: disc inside;
            margin: 15px 0;
            padding-left: 20px;
        }
        .image-content {
            flex-shrink: 0; /* Prevent the image from shrinking */
        }
        .image-content img {
            max-width: 300px; /* Set a max width for the image */
            border-radius: 10px; /* Match the border radius of the content */
        }
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-image: linear-gradient(to top, transparent 1%, black);
            z-index: 9999;
            padding: 5px 0;
            transition: transform 0.3s; /* Add smooth transition effect */
            display: flex;
            justify-content: space-between; /* Space between svg and buttons */
            padding: 5px 20px; /* Add some padding to the sides */
            height: 60px; /* Fixed height for header */
        }

        .button-style5 {
            font-size: 25px;
            padding: 20px 20px;
            text-shadow: 0 0 15px #009ac1; /* Adjust the shadow properties as needed */
            color:  #daf6ff;;
            transition: background-color 0.3s ease, transform 0.3s ease;
            text-align: center;
        }

        .button-style5:hover {
            transform: scale(1.4);
        }

        .button-container a {
            text-decoration: none;
            margin: 0 10px;
            position: relative;
            display: inline-block;
        }

        .button-container a::after {
            content: "";
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: 0;
            left: 0;
            visibility: hidden;
            transform: scaleX(0);
            transition: all 0.4s ease-in-out;
        }

        .button-container a:hover::after {
            visibility: visible;
            transform: scaleX(1);
        }
        .svg-container a {
            display: flex;
            align-items: center;
            transition: transform 0.3s ease; /* Add smooth transition effect for hover */
        }
        .svg-container a:hover {
            transform: scale(1.3); /* Add scaling on hover */
        }
        .svg-container svg {
            filter: drop-shadow(0px 0px 10px #009ac1);
            transform: rotate(90deg);
        }
    </style>
</head>
<header>
    <div class="svg-container">
        <a href="http://localhost/">
            <svg width="60" height="60" viewBox="0 0 24 24" style="fill: white;">
                <path d="M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6z"></path>
                <path fill="none" d="M0 0h24v24H0V0z"></path>
            </svg>
        </a>
    </div>
</header>
<body>
    <div class="title">Sudoku Regels</div>
    <div class="content">
        <div class="text-content">
            <h2>Hoe speel je Sudoku?</h2>
            <p>Sudoku is een puzzelspel waarbij je cijfers moet plaatsen in een 9x9 raster. Het doel is om elk cijfer van 1 tot 9 precies één keer te laten voorkomen in elke rij, elke kolom en elk van de negen 3x3 vakken die het raster vormen.</p>
            <h3>Basisregels:</h3>
            <ul>
                <li>Het Sudoku-rooster bestaat uit negen rijen en negen kolommen, wat neerkomt op 81 vakjes.</li>
                <li>Het raster is verder onderverdeeld in negen 3x3 vakken.</li>
                <li>Je moet elk cijfer van 1 tot 9 precies één keer plaatsen in elke rij.</li>
                <li>Je moet elk cijfer van 1 tot 9 precies één keer plaatsen in elke kolom.</li>
                <li>Je moet elk cijfer van 1 tot 9 precies één keer plaatsen in elk 3x3 vak.</li>
            </ul>
            <h3>Tips voor beginners:</h3>
            <ul>
                <li>Begin met de rijen, kolommen of vakken die bijna volledig zijn ingevuld. Dit maakt het gemakkelijker om te bepalen waar de ontbrekende cijfers moeten komen.</li>
                <li>Gebruik een potlood en gum bij het invullen van het rooster, zodat je fouten kunt corrigeren.</li>
                <li>Zoek naar patronen en gebruik logica in plaats van te gokken waar cijfers moeten komen.</li>
            </ul>
            <p>Veel plezier met het oplossen van Sudoku-puzzels!</p>
        </div>
        <div class="image-content">
            <img src="../spel-regels/images/spelregels.png" alt="Sudoku image"> <!-- Ensure you replace this with the correct path to your image -->
        </div>
    </div>
</body>
</html>
