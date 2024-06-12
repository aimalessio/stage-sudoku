<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./homepage/sudoku.css">
    <title>Sudoku Solver</title>
</head>
<header>
    <div class="button-container">
        <a href="http://localhost/spel-regels/spelregels.php" class="button-style5">spel regels</a>
    </div>
</header>
<body>
    <div class="title">Sudoku Solver</div>
    <div class="grid" id="sudoku-grid">
    </div>
    <div class="button-container">
        <select id="difficulty" name="niveau">
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="hard">Hard</option>
        </select>
        <button class="button-29" onclick="generateSudoku()">Regenerate Sudoku</button>
        <button class="button-29" onclick="solveSudoku()">Solve Sudoku</button>
        <button class="button-29" onclick="resetSudoku()">Reset</button>
        <p id="result"></p>
    </div>
     <script src="./homepage/sudoku.js"></script>
</body>
</html>
