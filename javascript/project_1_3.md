# Project 1.3: Calculator

## Project Overview

Build a fully functional Calculator application with a modern, clean interface. This project will help you practice event handling, state management, mathematical operations, and building interactive user interfaces.

## Learning Objectives

By the end of this project, you will be able to:
- Handle complex event interactions
- Manage application state
- Perform mathematical operations
- Build interactive UI components
- Handle edge cases and errors
- Create a polished user experience

---

## Project Requirements

### Core Features

1. **Basic Operations**: Addition, subtraction, multiplication, division
2. **Number Input**: Enter numbers via buttons or keyboard
3. **Clear Function**: Clear current input or all
4. **Decimal Support**: Handle decimal numbers
5. **Equals Function**: Calculate and display result
6. **Error Handling**: Handle division by zero, invalid operations
7. **Keyboard Support**: Use keyboard for input
8. **History Display**: Show calculation history (optional)

### Technical Requirements

- Use vanilla JavaScript
- Clean, modern UI design
- Responsive layout
- Proper state management
- Error handling
- Keyboard accessibility

---

## Project Structure

```
calculator/
├── index.html
├── css/
│   └── style.css
├── js/
│   ├── app.js
│   ├── calculator.js
│   └── display.js
└── README.md
```

---

## Step-by-Step Implementation

### Step 1: HTML Structure

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="calculator">
            <header>
                <h1>Calculator</h1>
            </header>
            
            <!-- Display -->
            <div class="display-container">
                <div id="history" class="history"></div>
                <div id="display" class="display">0</div>
            </div>
            
            <!-- Buttons -->
            <div class="buttons">
                <!-- Row 1 -->
                <button class="btn btn-clear" data-action="clear">C</button>
                <button class="btn btn-clear" data-action="clear-entry">CE</button>
                <button class="btn btn-operator" data-operator="%">%</button>
                <button class="btn btn-operator" data-operator="/">÷</button>
                
                <!-- Row 2 -->
                <button class="btn btn-number" data-number="7">7</button>
                <button class="btn btn-number" data-number="8">8</button>
                <button class="btn btn-number" data-number="9">9</button>
                <button class="btn btn-operator" data-operator="*">×</button>
                
                <!-- Row 3 -->
                <button class="btn btn-number" data-number="4">4</button>
                <button class="btn btn-number" data-number="5">5</button>
                <button class="btn btn-number" data-number="6">6</button>
                <button class="btn btn-operator" data-operator="-">−</button>
                
                <!-- Row 4 -->
                <button class="btn btn-number" data-number="1">1</button>
                <button class="btn btn-number" data-number="2">2</button>
                <button class="btn btn-number" data-number="3">3</button>
                <button class="btn btn-operator" data-operator="+">+</button>
                
                <!-- Row 5 -->
                <button class="btn btn-number btn-zero" data-number="0">0</button>
                <button class="btn btn-number" data-number=".">.</button>
                <button class="btn btn-equals" data-action="equals">=</button>
            </div>
        </div>
    </div>
    
    <script src="js/calculator.js"></script>
    <script src="js/display.js"></script>
    <script src="js/app.js"></script>
</body>
</html>
```

### Step 2: CSS Styling

```css
/* css/style.css */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.container {
    width: 100%;
    max-width: 400px;
}

.calculator {
    background: #1a1a1a;
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

header {
    text-align: center;
    margin-bottom: 20px;
}

header h1 {
    color: white;
    font-size: 1.5em;
    font-weight: 300;
}

.display-container {
    background: #2a2a2a;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    min-height: 120px;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
}

.history {
    color: #888;
    font-size: 0.9em;
    min-height: 20px;
    text-align: right;
    margin-bottom: 10px;
    word-break: break-all;
}

.display {
    color: white;
    font-size: 3em;
    text-align: right;
    word-break: break-all;
    overflow-wrap: break-word;
}

.buttons {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
}

.btn {
    padding: 20px;
    border: none;
    border-radius: 10px;
    font-size: 1.2em;
    cursor: pointer;
    transition: all 0.2s;
    font-weight: 500;
}

.btn:active {
    transform: scale(0.95);
}

.btn-number {
    background: #3a3a3a;
    color: white;
}

.btn-number:hover {
    background: #4a4a4a;
}

.btn-operator {
    background: #ff9500;
    color: white;
}

.btn-operator:hover {
    background: #ffaa33;
}

.btn-operator.active {
    background: white;
    color: #ff9500;
}

.btn-clear {
    background: #505050;
    color: white;
}

.btn-clear:hover {
    background: #606060;
}

.btn-equals {
    background: #ff9500;
    color: white;
    grid-column: span 1;
}

.btn-equals:hover {
    background: #ffaa33;
}

.btn-zero {
    grid-column: span 1;
}

@media (max-width: 480px) {
    .display {
        font-size: 2.5em;
    }
    
    .btn {
        padding: 15px;
        font-size: 1em;
    }
}
```

### Step 3: Calculator Logic

```javascript
// js/calculator.js
class Calculator {
    constructor() {
        this.currentValue = '0';
        this.previousValue = null;
        this.operator = null;
        this.waitingForOperand = false;
    }
    
    inputNumber(number) {
        if (this.waitingForOperand) {
            this.currentValue = number;
            this.waitingForOperand = false;
        } else {
            this.currentValue = this.currentValue === '0' ? number : this.currentValue + number;
        }
    }
    
    inputDecimal() {
        if (this.waitingForOperand) {
            this.currentValue = '0.';
            this.waitingForOperand = false;
        } else if (this.currentValue.indexOf('.') === -1) {
            this.currentValue += '.';
        }
    }
    
    clear() {
        this.currentValue = '0';
        this.previousValue = null;
        this.operator = null;
        this.waitingForOperand = false;
    }
    
    clearEntry() {
        this.currentValue = '0';
    }
    
    performOperation(nextOperator) {
        const inputValue = parseFloat(this.currentValue);
        
        if (this.previousValue === null) {
            this.previousValue = inputValue;
        } else if (this.operator) {
            const currentValue = this.previousValue || 0;
            const newValue = this.calculate(currentValue, inputValue, this.operator);
            
            this.currentValue = String(newValue);
            this.previousValue = newValue;
        }
        
        this.waitingForOperand = true;
        this.operator = nextOperator;
    }
    
    calculate(firstValue, secondValue, operator) {
        switch (operator) {
            case '+':
                return firstValue + secondValue;
            case '-':
                return firstValue - secondValue;
            case '*':
                return firstValue * secondValue;
            case '/':
                if (secondValue === 0) {
                    throw new Error('Cannot divide by zero');
                }
                return firstValue / secondValue;
            case '%':
                return firstValue % secondValue;
            default:
                return secondValue;
        }
    }
    
    equals() {
        if (this.operator && this.previousValue !== null) {
            const inputValue = parseFloat(this.currentValue);
            const newValue = this.calculate(this.previousValue, inputValue, this.operator);
            
            this.currentValue = String(newValue);
            this.previousValue = null;
            this.operator = null;
            this.waitingForOperand = true;
        }
    }
    
    getDisplayValue() {
        return this.currentValue;
    }
    
    getHistory() {
        if (this.previousValue !== null && this.operator) {
            return `${this.previousValue} ${this.operator}`;
        }
        return '';
    }
}
```

### Step 4: Display Module

```javascript
// js/display.js
class Display {
    constructor() {
        this.display = document.getElementById('display');
        this.history = document.getElementById('history');
    }
    
    updateDisplay(value) {
        // Format large numbers
        const numValue = parseFloat(value);
        if (isNaN(numValue)) {
            this.display.textContent = 'Error';
            return;
        }
        
        // Handle very large numbers
        if (Math.abs(numValue) > 999999999) {
            this.display.textContent = numValue.toExponential(3);
        } else {
            // Format with appropriate decimal places
            const formatted = this.formatNumber(value);
            this.display.textContent = formatted;
        }
    }
    
    formatNumber(value) {
        const num = parseFloat(value);
        if (isNaN(num)) return '0';
        
        // If it's an integer, don't show decimals
        if (num % 1 === 0) {
            return num.toString();
        }
        
        // Otherwise, limit to 9 decimal places
        return num.toFixed(9).replace(/\.?0+$/, '');
    }
    
    updateHistory(history) {
        this.history.textContent = history;
    }
    
    showError(message) {
        this.display.textContent = message;
        this.history.textContent = '';
    }
}
```

### Step 5: Main Application

```javascript
// js/app.js
class CalculatorApp {
    constructor() {
        this.calculator = new Calculator();
        this.display = new Display();
        this.initializeApp();
    }
    
    initializeApp() {
        this.attachEventListeners();
        this.attachKeyboardListeners();
        this.updateDisplay();
    }
    
    attachEventListeners() {
        // Number buttons
        document.querySelectorAll('.btn-number[data-number]').forEach(btn => {
            btn.addEventListener('click', () => {
                const number = btn.dataset.number;
                if (number === '.') {
                    this.calculator.inputDecimal();
                } else {
                    this.calculator.inputNumber(number);
                }
                this.updateDisplay();
            });
        });
        
        // Operator buttons
        document.querySelectorAll('.btn-operator[data-operator]').forEach(btn => {
            btn.addEventListener('click', () => {
                const operator = btn.dataset.operator;
                try {
                    this.calculator.performOperation(operator);
                    this.updateDisplay();
                    this.updateOperatorButtons();
                } catch (error) {
                    this.display.showError(error.message);
                }
            });
        });
        
        // Equals button
        document.querySelector('.btn-equals').addEventListener('click', () => {
            try {
                this.calculator.equals();
                this.updateDisplay();
                this.updateOperatorButtons();
            } catch (error) {
                this.display.showError(error.message);
            }
        });
        
        // Clear buttons
        document.querySelector('[data-action="clear"]').addEventListener('click', () => {
            this.calculator.clear();
            this.updateDisplay();
            this.updateOperatorButtons();
        });
        
        document.querySelector('[data-action="clear-entry"]').addEventListener('click', () => {
            this.calculator.clearEntry();
            this.updateDisplay();
        });
    }
    
    attachKeyboardListeners() {
        document.addEventListener('keydown', (e) => {
            // Prevent default for calculator keys
            if (this.isCalculatorKey(e.key)) {
                e.preventDefault();
            }
            
            // Handle number keys
            if (e.key >= '0' && e.key <= '9') {
                this.calculator.inputNumber(e.key);
                this.updateDisplay();
            }
            
            // Handle decimal
            if (e.key === '.') {
                this.calculator.inputDecimal();
                this.updateDisplay();
            }
            
            // Handle operators
            if (['+', '-', '*', '/', '%'].includes(e.key)) {
                try {
                    this.calculator.performOperation(e.key);
                    this.updateDisplay();
                    this.updateOperatorButtons();
                } catch (error) {
                    this.display.showError(error.message);
                }
            }
            
            // Handle equals
            if (e.key === '=' || e.key === 'Enter') {
                try {
                    this.calculator.equals();
                    this.updateDisplay();
                    this.updateOperatorButtons();
                } catch (error) {
                    this.display.showError(error.message);
                }
            }
            
            // Handle clear
            if (e.key === 'Escape') {
                this.calculator.clear();
                this.updateDisplay();
                this.updateOperatorButtons();
            }
            
            // Handle backspace
            if (e.key === 'Backspace') {
                const current = this.calculator.getDisplayValue();
                if (current.length > 1) {
                    this.calculator.currentValue = current.slice(0, -1);
                } else {
                    this.calculator.currentValue = '0';
                }
                this.updateDisplay();
            }
        });
    }
    
    isCalculatorKey(key) {
        return (key >= '0' && key <= '9') ||
               ['+', '-', '*', '/', '%', '.', '=', 'Enter', 'Escape', 'Backspace'].includes(key);
    }
    
    updateDisplay() {
        this.display.updateDisplay(this.calculator.getDisplayValue());
        this.display.updateHistory(this.calculator.getHistory());
    }
    
    updateOperatorButtons() {
        document.querySelectorAll('.btn-operator').forEach(btn => {
            btn.classList.remove('active');
        });
        
        if (this.calculator.operator) {
            const activeBtn = document.querySelector(`[data-operator="${this.calculator.operator}"]`);
            if (activeBtn) {
                activeBtn.classList.add('active');
            }
        }
    }
}

// Initialize app
const app = new CalculatorApp();
```

---

## Features Implementation

### Event Handling

- **Button Clicks**: All calculator buttons functional
- **Keyboard Support**: Full keyboard input support
- **Visual Feedback**: Active operator highlighting
- **Smooth Interactions**: Button press animations

### State Management

- **Current Value**: Currently displayed number
- **Previous Value**: Stored for operations
- **Operator**: Current operation type
- **Waiting Flag**: Tracks input state

### Mathematical Operations

- **Basic Operations**: +, -, *, /
- **Modulo**: % operation
- **Decimal Support**: Proper decimal handling
- **Error Handling**: Division by zero, invalid operations

---

## Testing Your Application

### Manual Testing Checklist

- [ ] Test all number buttons
- [ ] Test all operators
- [ ] Test equals function
- [ ] Test clear functions
- [ ] Test decimal input
- [ ] Test division by zero
- [ ] Test keyboard input
- [ ] Test chained operations
- [ ] Test large numbers
- [ ] Test negative numbers

---

## Exercise: Build Calculator

**Instructions**:

1. Create all files as shown
2. Implement all features
3. Test thoroughly
4. Customize the design
5. Add your own enhancements

**Enhancement Ideas**:

- Add scientific calculator functions
- Add memory functions (M+, M-, MR, MC)
- Add calculation history
- Add theme switcher (light/dark)
- Add sound effects
- Add animation effects
- Add keyboard shortcuts display
- Add unit conversion

---

## Common Issues and Solutions

### Issue: Decimal input not working

**Solution**: Check that inputDecimal() properly handles the waitingForOperand state.

### Issue: Operations not chaining

**Solution**: Ensure performOperation() properly stores previous value and operator.

### Issue: Division by zero

**Solution**: Add check in calculate() method to throw error for division by zero.

---

## Quiz: Calculator Concepts

1. **State management:**
   - A) Tracks calculator state
   - B) Doesn't track state
   - C) Both
   - D) Neither

2. **Event handling:**
   - A) Responds to user input
   - B) Doesn't respond
   - C) Both
   - D) Neither

3. **Mathematical operations:**
   - A) Perform calculations
   - B) Don't perform calculations
   - C) Both
   - D) Neither

4. **Error handling:**
   - A) Important for calculator
   - B) Not important
   - C) Both
   - D) Neither

5. **Keyboard support:**
   - A) Improves usability
   - B) Doesn't improve usability
   - C) Both
   - D) Neither

**Answers**:
1. A) Tracks calculator state
2. A) Responds to user input
3. A) Perform calculations
4. A) Important for calculator
5. A) Improves usability

---

## Key Takeaways

1. **Event Handling**: Complex interactions require careful event management
2. **State Management**: Track all necessary state for calculations
3. **Mathematical Operations**: Implement operations correctly
4. **Error Handling**: Handle edge cases gracefully
5. **User Experience**: Smooth interactions and visual feedback
6. **Best Practice**: Clean code structure and proper separation of concerns

---

## Next Steps

Congratulations! You've built a complete Calculator application. You now know:
- How to handle complex events
- How to manage application state
- How to perform mathematical operations
- How to build interactive UIs

**What's Next?**
- Project 2: Frontend Applications
- Learn React projects
- Build React applications
- Apply React concepts

---

*Project completed! You've finished Project 1: Interactive Web Pages. Ready for Project 2: Frontend Applications!*

