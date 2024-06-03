// Generate the Sudoku grid
document.addEventListener('DOMContentLoaded', (event) => {
    const gridContainer = document.getElementById('sudoku-grid');
    for (let i = 0; i < 81; i++) {
        const input = document.createElement('input');
        input.type = 'text';
        input.maxLength = '1';
        input.classList.add('cell');
        input.id = `cell-${i}`;
        gridContainer.appendChild(input);
    }
});

// Solve the Sudoku puzzle
function solveSudoku() {
    const grid = getGrid();
    if (isSolvable(grid)) {
        if (solve(grid)) {
            displaySolution(grid);
            document.getElementById('result').innerText = 'Solved!';
        } else {
            document.getElementById('result').innerText = 'No solution exists.';
        }
    } else {
        document.getElementById('result').innerText = 'Invalid Sudoku puzzle.';
    }
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
