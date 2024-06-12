/**
 * Voegt event listeners toe wanneer de pagina geladen is. 
 * Initialiseert het Sudoku-rooster, genereert een Sudoku-puzzel, en 
 * luistert naar wijzigingen in de moeilijkheidsgraad om het rooster opnieuw te genereren.
 */
document.addEventListener('DOMContentLoaded', (event) => {
    createGrid(); // Initialiseert het Sudoku-rooster
    generateSudoku(); // Genereert een nieuw Sudoku-rooster
    document.getElementById('difficulty').addEventListener('change', generateSudoku); // Luistert naar moeilijkheidsgraad wijzigingen
});

/**
 * Functie om een Sudoku-rooster te creëren.
 * Deze functie maakt dynamisch een 9x9 Sudoku-rooster met invoervelden.
 * Elk vakje accepteert alleen enkele cijfers.
 */
function createGrid() {
    const gridContainer = document.getElementById('sudoku-grid');
    gridContainer.innerHTML = '';
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
}

/**
 * Functie om een Sudoku-puzzel te genereren.
 * Genereert eerst een compleet Sudoku-rooster en creëert vervolgens een puzzel 
 * door willekeurig getallen te verwijderen op basis van de moeilijkheidsgraad.
 */
function generateSudoku() {
    let grid = generateCompleteGrid(); // Genereert een compleet Sudoku-rooster
    const difficulty = document.getElementById('difficulty').value; // Haalt de moeilijkheidsgraad op
    let puzzle;
    do {
        puzzle = createPuzzle(grid.slice(), difficulty);
    } while (!hasUniqueSolution(puzzle));
    displayPuzzle(puzzle); // Toont de gegenereerde Sudoku-puzzel
}

/**
 * Functie om een compleet Sudoku-rooster te genereren.
 * Maakt een willekeurig compleet Sudoku-rooster.
 */
function generateCompleteGrid() {
    const grid = Array(81).fill(0);
    fillGrid(grid);
    return grid;
}

/*/ Enzovoort voor de overige functies.../*
 * Functie om het Sudoku-rooster in te vullen.
* Vult een gegeven Sudoku-rooster in met geldige getallen.
*/
function fillGrid(grid) {
   function shuffle(array) {
       for (let i = array.length - 1; i > 0; i--) {
           const j = Math.floor(Math.random() * (i + 1));
           [array[i], array[j]] = [array[j], array[i]];
       }
       return array;
   }

   function fillCell(index) {
       if (index >= 81) return true;

       if (grid[index] !== 0) return fillCell(index + 1);

       const row = Math.floor(index / 9);
       const col = index % 9;
       const nums = shuffle([1, 2, 3, 4, 5, 6, 7, 8, 9]);

       for (const num of nums) {
           if (isValid(grid, index, num)) {
               grid[index] = num;
               if (fillCell(index + 1)) return true;
               grid[index] = 0;
           }
       }

       return false;
   }

   fillCell(0);
}

/**
* Functie om een Sudoku-puzzel te maken op basis van de moeilijkheidsgraad.
* Verwijdert willekeurige getallen uit een compleet Sudoku-rooster volgens de moeilijkheidsgraad.
*/
function createPuzzle(grid, difficulty) {
   const puzzle = grid.slice();
   let attempts;

   if (difficulty === 'easy') {
       attempts = 40; // Gemakkelijk: Minder getallen worden verwijderd
   } else if (difficulty === 'medium') {
       attempts = 50; // Gemiddeld: Matige getallen worden verwijderd
   } else if (difficulty === 'hard') {
       attempts = 55; // Moeilijk: Meer getallen worden verwijderd
   }

   while (attempts > 0) {
       const index = Math.floor(Math.random() * 81);
       if (puzzle[index] !== 0) {
           const backup = puzzle[index];
           puzzle[index] = 0;

           const copy = puzzle.slice();
           if (!hasUniqueSolution(copy)) {
               puzzle[index] = backup;
           } else {
               attempts--;
           }
       }
   }

   return puzzle;
}

/*/ Voeg vereenvoudigde commentaren toe voor de rest van de functies op dezelfde manier.../**
 * Functie om een Sudoku-puzzel weer te geven in het rooster.
* Toont de gegeven Sudoku-puzzel in het rooster, waarbij lege cellen worden weergegeven als invoervelden.
*/
function displayPuzzle(puzzle) {
   for (let i = 0; i < 81; i++) {
       const cell = document.getElementById(`cell-${i}`);
       if (puzzle[i] !== 0) {
           cell.value = puzzle[i];
           cell.disabled = true;
       } else {
           cell.value = '';
           cell.disabled = false;
       }
   }
}

/**
* Functie om een Sudoku-rooster op te lossen.
* Probeert recursief het gegeven Sudoku-rooster op te lossen.
*/
function solveSudoku() {
   const grid = getGrid();
   if (solve(grid)) {
       displaySolution(grid);
       alert('Sudoku opgelost!');
   } else {
       document.getElementById('result').innerText = 'Er bestaat geen oplossing.';
   }
}

/**
* Functie om het Sudoku-rooster te resetten.
* Zet alle cellen in het rooster terug naar de oorspronkelijke staat.
*/
function resetSudoku() {
   const gridInputs = document.querySelectorAll('.cell');
   gridInputs.forEach(input => {
       input.value = '';
       input.disabled = false;
   });
   document.getElementById('result').innerText = '';
}

/**
* Functie om het huidige Sudoku-rooster op te halen.
* Verzamelt de waarden van alle cellen in het Sudoku-rooster.
*/
function getGrid() {
   const grid = [];
   for (let i = 0; i < 81; i++) {
       const value = document.getElementById(`cell-${i}`).value;
       grid.push(value === '' ? 0 : parseInt(value));
   }
   return grid;
}

/**
* Functie om te controleren of een gegeven nummer geldig is voor een bepaalde cel.
* Controleert of het gegeven nummer niet in strijd is met de Sudoku-regels.
*/
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

/**
* Functie om een Sudoku-rooster op te lossen.
* Probeert recursief het gegeven Sudoku-rooster op te lossen.
*/
function solve(grid) {
   function solveCell(index) {
       if (index >= 81) return true;

       if (grid[index] !== 0) return solveCell(index + 1);

       for (let num = 1; num <= 9; num++) {
           if (isValid(grid, index, num)) {
               grid[index] = num;
               if (solveCell(index + 1)) return true;
               grid[index] = 0;
           }
       }

       return false;
   }

   return solveCell(0);
}

/**
* Functie om de oplossing van een Sudoku-rooster weer te geven.
* Toont de oplossing van het Sudoku-rooster in het rooster.
*/
function displaySolution(grid) {
   for (let i = 0; i < 81; i++) {
       document.getElementById(`cell-${i}`).value = grid[i];
   }
}

/**
* Functie om te controleren of een Sudoku-rooster een unieke oplossing heeft.
* Controleert of er slechts één oplossing is voor het gegeven Sudoku-rooster.
*/
function hasUniqueSolution(grid) {
   let solutionCount = 0;

   function solveCell(index) {
       if (index >= 81) {
           solutionCount++;
           return solutionCount === 1;
       }

       if (grid[index] !== 0) return solveCell(index + 1);

       for (let num = 1; num <= 9; num++) {
           if (isValid(grid, index, num)) {
               grid[index] = num;
               if (solveCell(index + 1)) {
                   if (solutionCount > 1) return false;
               }
               grid[index] = 0;
           }
       }

       return solutionCount === 1;
   }

   solveCell(0);
   return solutionCount === 1;
}


