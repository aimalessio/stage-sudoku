<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sudoku.css">
    <title>Sudoku Solver</title>
    <style>
        body {
            background-image: url('./homepage/images/sudoku.jpg');
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            background-color: #f0f0f0; /* fallback color */
            background-size: cover;
            margin: 0;
        }
        .title {
            font-size: 2em;
            margin-top: 60px; /* Add space between header and title */
            margin-bottom: 20px;
            color: white;
            text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000; /* Black outline */
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(9, 40px);
            grid-template-rows: repeat(9, 40px);
            gap: 2px;
            border: 3px solid #333;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(255, 255, 255);
        }
        .cell {
            width: 40px;
            height: 40px;
            text-align: center;
            font-size: 20px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }
        .cell:nth-child(3n+1) {
            border-left: 3px solid #333;
        }
        .cell:nth-child(9n+1) {
            border-left: none;
        }
        .cell:nth-child(n+19):nth-child(-n+27),
        .cell:nth-child(n+46):nth-child(-n+54) {
            border-bottom: 3px solid #333;
        }
        .cell:nth-child(-n+9) {
            border-top: none;
        }
        .button-container {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            align-items: center;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        button:hover {
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
        #result {
            margin-top: 10px;
            font-size: 18px;
            color: #333;
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
            justify-content: flex-end; /* Align buttons to the right */
            padding-right: 20px; /* Add some padding to the right */
        }
        .button-style5 {
            font-size: 30px;
            padding: 20px 20px;
            text-shadow: 0 0 10px #009ac1; /* Adjust the shadow properties as needed */
            color: #daf6ff;
            transition: background-color 0.3s ease, transform 0.3s ease;
            text-align: center;
        }
        .button-style5:hover {
            transform: scale(1.3);
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
        .button-container a:hover::after {
            visibility: visible;
            transform: scaleX(1);
        }
        .dropdown-container {
            position: absolute;
            top: -50px; /* Adjust to position above the grid */
            right: 0;
        }
        select {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            cursor: pointer;
        }
        select:focus {
            outline: none;
            border-color: #007BFF;
        }
    </style>
</head>
<header>
    <div class="button-container">
        <a href="http://localhost/spel-regels/spelregels.php" class="button-style5">spel regels</a>
    </div>
</header>
<body>
    <div class="title">Sudoku Solver</div>
    <div class="grid" id="sudoku-grid">
        <!-- JavaScript will populate this -->
    </div>
    <div class="button-container">
        <select id="difficulty" name="niveau">
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="hard">Hard</option>
        </select>
        <button onclick="solveSudoku()">Solve Sudoku</button>
        <button onclick="resetSudoku()">Reset</button>
        <p id="result"></p>
    </div>

    <script>
        // Generate the Sudoku grid with empty cells
        document.addEventListener('DOMContentLoaded', (event) => {
            const gridContainer = document.getElementById('sudoku-grid');
            for (let i = 0; i < 81; i++) {
                const input = document.createElement('input');
                input.type = 'text';
                input.maxLength = '1';
                input.classList.add('cell');
                input.id = `cell-${i}`;
                input.addEventListener('input', function(event) {
                    const inputValue = event.target.value;
                    if (!/^\d*$/.test(inputValue)) {
                        event.target.value = '';
                    }
                });
                gridContainer.appendChild(input);
            }
        });

        // Solve the Sudoku puzzle
        function solveSudoku() {
            const grid = getGrid();
            if (isSolvable(grid)) {
                if (solve(grid)) {
                    displaySolution(grid);
                    alert('Sudoku solved!');
                } else {
                    document.getElementById('result').innerText = 'No solution exists.';
                }
            } else {
                document.getElementById('result').innerText = 'Invalid Sudoku puzzle.';
            }
        }

        // Reset the Sudoku puzzle
        function resetSudoku() {
            const gridInputs = document.querySelectorAll('.cell');
            gridInputs.forEach(input => {
                input.value = '';
            });
        }

        // Get the grid values from the input fields
        function getGrid() {
            const grid = [];
            for (let i = 0; i < 81; i++) {
                const value = document.getElementById(`cell-${i}`).value;
                grid.push(value === '' ? 0 : parseInt(value));
            }
            return grid;
        }

        // Check if the puzzle is solvable (basic validation)
        function isSolvable(grid) {
            for (let i = 0; i < 81; i++) {
                if (grid[i] !== 0 && !isValid(grid, i, grid[i])) {
                    return false;
                }
            }
            return true;
        }

        // Solve the Sudoku puzzle using backtracking
        function solve(grid) {
            for (let i = 0; i < 81; i++) {
                if (grid[i] === 0) {
                    for (let num = 1; num <= 9; num++) {
                        if (isValid(grid, i, num)) {
                            grid[i] = num;
                            if (solve(grid)) {
                                return true;
                            }
                            grid[i] = 0;
                        }
                    }
                    return false;
                }
            }
            return true;
        }

        // Check if placing a number is valid
        function isValid(grid, index, num) {
            const row = Math.floor(index / 9);
            const col = index % 9;
            for (let i = 0; i < 9; i++) {
                if (grid[row * 9 + i] === num || grid[i * 9 + col] === num) {
                    return false;
                }
            }
            const startRow = Math.floor(row / 3) * 3;
            const startCol = Math.floor(col / 3) * 3;
            for (let i = 0; i < 3; i++) {
                for (let j = 0; j < 3; j++) {
                    if (grid[(startRow + i) * 9 + startCol + j] === num) {
                        return false;
                    }
                }
            }
            return true;
        }

        // Display the solution in the input fields
        function displaySolution(grid) {
            for (let i = 0; i < 81; i++) {
                document.getElementById(`cell-${i}`).value = grid[i];
            }
        }
    </script>
</body>
</html>
