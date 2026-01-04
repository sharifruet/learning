# Lesson 17.3: Canvas and WebGL

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand the Canvas API
- Draw shapes and paths on canvas
- Work with colors and gradients
- Transform and animate canvas
- Handle canvas events
- Understand WebGL basics
- Build canvas-based applications

---

## Introduction to Canvas

The Canvas API provides a way to draw graphics using JavaScript and HTML.

### Why Canvas?

- **Graphics**: Draw shapes, images, text
- **Animations**: Create smooth animations
- **Games**: Build 2D games
- **Charts**: Create data visualizations
- **Image Processing**: Manipulate images
- **Modern Web**: Essential for graphics

---

## Canvas Basics

### Creating a Canvas

```html
<canvas id="myCanvas" width="800" height="600"></canvas>
```

```javascript
let canvas = document.getElementById('myCanvas');
let ctx = canvas.getContext('2d');
```

### Getting Context

```javascript
// 2D context (most common)
let ctx = canvas.getContext('2d');

// WebGL context (3D)
let gl = canvas.getContext('webgl');

// WebGL2 context
let gl2 = canvas.getContext('webgl2');
```

### Setting Canvas Size

```javascript
// Set size via attributes (recommended)
canvas.width = 800;
canvas.height = 600;

// Or via CSS (scales, doesn't resize)
canvas.style.width = '800px';
canvas.style.height = '600px';
```

---

## Drawing Shapes

### Drawing Rectangles

```javascript
let ctx = canvas.getContext('2d');

// Fill rectangle
ctx.fillStyle = 'red';
ctx.fillRect(10, 10, 100, 50);

// Stroke rectangle
ctx.strokeStyle = 'blue';
ctx.lineWidth = 2;
ctx.strokeRect(120, 10, 100, 50);

// Clear rectangle
ctx.clearRect(60, 20, 50, 20);
```

### Drawing Paths

```javascript
let ctx = canvas.getContext('2d');

// Start path
ctx.beginPath();

// Move to point
ctx.moveTo(50, 50);

// Line to point
ctx.lineTo(150, 50);
ctx.lineTo(100, 150);

// Close path
ctx.closePath();

// Draw
ctx.stroke();
// or
ctx.fill();
```

### Drawing Circles and Arcs

```javascript
let ctx = canvas.getContext('2d');

// Arc (circle)
ctx.beginPath();
ctx.arc(100, 100, 50, 0, 2 * Math.PI);
ctx.fill();

// Partial arc
ctx.beginPath();
ctx.arc(200, 100, 50, 0, Math.PI);
ctx.stroke();
```

### Drawing Curves

```javascript
let ctx = canvas.getContext('2d');

// Quadratic curve
ctx.beginPath();
ctx.moveTo(50, 50);
ctx.quadraticCurveTo(100, 100, 150, 50);
ctx.stroke();

// Bezier curve
ctx.beginPath();
ctx.moveTo(50, 150);
ctx.bezierCurveTo(75, 100, 125, 200, 150, 150);
ctx.stroke();
```

---

## Colors and Styles

### Fill and Stroke Colors

```javascript
let ctx = canvas.getContext('2d');

// Named colors
ctx.fillStyle = 'red';
ctx.strokeStyle = 'blue';

// Hex colors
ctx.fillStyle = '#FF0000';
ctx.strokeStyle = '#0000FF';

// RGB colors
ctx.fillStyle = 'rgb(255, 0, 0)';
ctx.strokeStyle = 'rgba(0, 0, 255, 0.5)';
```

### Gradients

```javascript
let ctx = canvas.getContext('2d');

// Linear gradient
let gradient = ctx.createLinearGradient(0, 0, 200, 0);
gradient.addColorStop(0, 'red');
gradient.addColorStop(1, 'blue');
ctx.fillStyle = gradient;
ctx.fillRect(10, 10, 200, 100);

// Radial gradient
let radialGradient = ctx.createRadialGradient(100, 100, 0, 100, 100, 50);
radialGradient.addColorStop(0, 'white');
radialGradient.addColorStop(1, 'black');
ctx.fillStyle = radialGradient;
ctx.fillRect(50, 50, 100, 100);
```

### Patterns

```javascript
let ctx = canvas.getContext('2d');

// Create pattern from image
let img = new Image();
img.onload = function() {
    let pattern = ctx.createPattern(img, 'repeat');
    ctx.fillStyle = pattern;
    ctx.fillRect(0, 0, canvas.width, canvas.height);
};
img.src = 'pattern.png';
```

---

## Text

### Drawing Text

```javascript
let ctx = canvas.getContext('2d');

// Font
ctx.font = '30px Arial';

// Fill text
ctx.fillStyle = 'black';
ctx.fillText('Hello Canvas', 10, 50);

// Stroke text
ctx.strokeStyle = 'blue';
ctx.strokeText('Hello Canvas', 10, 100);
```

### Text Properties

```javascript
let ctx = canvas.getContext('2d');

ctx.font = 'bold 30px Arial';
ctx.textAlign = 'center';
ctx.textBaseline = 'middle';
ctx.fillText('Centered Text', canvas.width / 2, canvas.height / 2);
```

---

## Images

### Drawing Images

```javascript
let ctx = canvas.getContext('2d');
let img = new Image();

img.onload = function() {
    // Draw image
    ctx.drawImage(img, 10, 10);
    
    // Draw scaled
    ctx.drawImage(img, 10, 10, 100, 100);
    
    // Draw from source rectangle
    ctx.drawImage(img, 0, 0, 50, 50, 10, 10, 100, 100);
};

img.src = 'image.jpg';
```

### Image Manipulation

```javascript
// Get image data
let imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
let data = imageData.data;

// Manipulate pixels
for (let i = 0; i < data.length; i += 4) {
    // Red
    data[i] = 255 - data[i];
    // Green
    data[i + 1] = 255 - data[i + 1];
    // Blue
    data[i + 2] = 255 - data[i + 2];
    // Alpha (unchanged)
}

// Put image data back
ctx.putImageData(imageData, 0, 0);
```

---

## Transformations

### Translate, Rotate, Scale

```javascript
let ctx = canvas.getContext('2d');

// Save state
ctx.save();

// Translate
ctx.translate(100, 100);

// Rotate
ctx.rotate(Math.PI / 4);

// Scale
ctx.scale(2, 2);

// Draw (will be transformed)
ctx.fillRect(-25, -25, 50, 50);

// Restore state
ctx.restore();
```

### Transform Matrix

```javascript
let ctx = canvas.getContext('2d');

// Transform using matrix
ctx.transform(1, 0, 0, 1, 100, 100);  // Translate
ctx.transform(2, 0, 0, 2, 0, 0);      // Scale

// Or set transform
ctx.setTransform(1, 0, 0, 1, 0, 0);  // Reset
```

---

## Animation

### Basic Animation Loop

```javascript
function animate() {
    // Clear canvas
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    // Draw frame
    draw();
    
    // Next frame
    requestAnimationFrame(animate);
}

// Start animation
animate();
```

### Animation Example

```javascript
let x = 0;
let y = 0;
let dx = 2;
let dy = 2;

function animate() {
    // Clear
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    // Update position
    x += dx;
    y += dy;
    
    // Bounce
    if (x < 0 || x > canvas.width - 50) dx = -dx;
    if (y < 0 || y > canvas.height - 50) dy = -dy;
    
    // Draw
    ctx.fillRect(x, y, 50, 50);
    
    requestAnimationFrame(animate);
}

animate();
```

---

## WebGL Basics

### WebGL Context

```javascript
let canvas = document.getElementById('myCanvas');
let gl = canvas.getContext('webgl');

if (!gl) {
    console.error('WebGL not supported');
}
```

### Basic WebGL Setup

```javascript
// Clear color
gl.clearColor(0.0, 0.0, 0.0, 1.0);
gl.clear(gl.COLOR_BUFFER_BIT);

// Viewport
gl.viewport(0, 0, canvas.width, canvas.height);
```

### Shaders

```javascript
// Vertex shader
let vertexShaderSource = `
    attribute vec4 a_position;
    void main() {
        gl_Position = a_position;
    }
`;

// Fragment shader
let fragmentShaderSource = `
    precision mediump float;
    void main() {
        gl_FragColor = vec4(1, 0, 0, 1);
    }
`;
```

---

## Practical Examples

### Example 1: Drawing App

```javascript
class DrawingApp {
    constructor(canvas) {
        this.canvas = canvas;
        this.ctx = canvas.getContext('2d');
        this.isDrawing = false;
        this.currentPath = [];
        
        this.setupEventListeners();
    }
    
    setupEventListeners() {
        this.canvas.addEventListener('mousedown', (e) => {
            this.isDrawing = true;
            this.currentPath = [this.getMousePos(e)];
        });
        
        this.canvas.addEventListener('mousemove', (e) => {
            if (this.isDrawing) {
                this.currentPath.push(this.getMousePos(e));
                this.draw();
            }
        });
        
        this.canvas.addEventListener('mouseup', () => {
            this.isDrawing = false;
        });
    }
    
    getMousePos(e) {
        let rect = this.canvas.getBoundingClientRect();
        return {
            x: e.clientX - rect.left,
            y: e.clientY - rect.top
        };
    }
    
    draw() {
        if (this.currentPath.length < 2) return;
        
        this.ctx.beginPath();
        this.ctx.moveTo(this.currentPath[0].x, this.currentPath[0].y);
        
        for (let i = 1; i < this.currentPath.length; i++) {
            this.ctx.lineTo(this.currentPath[i].x, this.currentPath[i].y);
        }
        
        this.ctx.stroke();
    }
}

let app = new DrawingApp(document.getElementById('canvas'));
```

### Example 2: Particle System

```javascript
class Particle {
    constructor(x, y) {
        this.x = x;
        this.y = y;
        this.vx = (Math.random() - 0.5) * 2;
        this.vy = (Math.random() - 0.5) * 2;
        this.life = 1.0;
    }
    
    update() {
        this.x += this.vx;
        this.y += this.vy;
        this.life -= 0.01;
    }
    
    draw(ctx) {
        ctx.globalAlpha = this.life;
        ctx.fillRect(this.x, this.y, 2, 2);
    }
}

class ParticleSystem {
    constructor(canvas) {
        this.canvas = canvas;
        this.ctx = canvas.getContext('2d');
        this.particles = [];
    }
    
    addParticle(x, y) {
        this.particles.push(new Particle(x, y));
    }
    
    update() {
        this.particles = this.particles.filter(p => {
            p.update();
            return p.life > 0;
        });
    }
    
    draw() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        this.particles.forEach(p => p.draw(this.ctx));
        this.ctx.globalAlpha = 1.0;
    }
    
    animate() {
        this.update();
        this.draw();
        requestAnimationFrame(() => this.animate());
    }
}
```

---

## Practice Exercise

### Exercise: Canvas Drawing

**Objective**: Practice using Canvas API to draw shapes, create animations, and build interactive graphics.

**Instructions**:

1. Create an HTML file with canvas element
2. Create a JavaScript file for canvas operations
3. Practice:
   - Drawing shapes and paths
   - Using colors and gradients
   - Creating animations
   - Handling mouse events
   - Basic WebGL setup

**Example Solution**:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canvas Practice</title>
    <style>
        canvas {
            border: 1px solid #000;
            display: block;
            margin: 20px auto;
        }
        .controls {
            text-align: center;
            margin: 20px;
        }
        button {
            padding: 10px 20px;
            margin: 5px;
        }
    </style>
</head>
<body>
    <div class="controls">
        <button onclick="drawShapes()">Draw Shapes</button>
        <button onclick="drawGradients()">Draw Gradients</button>
        <button onclick="startAnimation()">Start Animation</button>
        <button onclick="clearCanvas()">Clear</button>
    </div>
    <canvas id="myCanvas" width="800" height="600"></canvas>
    <script src="canvas-practice.js"></script>
</body>
</html>
```

```javascript
// canvas-practice.js
console.log("=== Canvas Practice ===");

let canvas = document.getElementById('myCanvas');
let ctx = canvas.getContext('2d');

console.log("\n=== Canvas Setup ===");

console.log('Canvas width:', canvas.width);
console.log('Canvas height:', canvas.height);
console.log('Context:', ctx);
console.log();

console.log("=== Drawing Shapes ===");

function drawShapes() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    // Rectangles
    ctx.fillStyle = 'red';
    ctx.fillRect(10, 10, 100, 50);
    
    ctx.strokeStyle = 'blue';
    ctx.lineWidth = 3;
    ctx.strokeRect(120, 10, 100, 50);
    
    // Circles
    ctx.fillStyle = 'green';
    ctx.beginPath();
    ctx.arc(200, 200, 50, 0, 2 * Math.PI);
    ctx.fill();
    
    ctx.strokeStyle = 'purple';
    ctx.lineWidth = 2;
    ctx.beginPath();
    ctx.arc(350, 200, 50, 0, 2 * Math.PI);
    ctx.stroke();
    
    // Paths
    ctx.strokeStyle = 'orange';
    ctx.lineWidth = 2;
    ctx.beginPath();
    ctx.moveTo(50, 300);
    ctx.lineTo(150, 300);
    ctx.lineTo(100, 400);
    ctx.closePath();
    ctx.stroke();
    
    // Curves
    ctx.strokeStyle = 'brown';
    ctx.beginPath();
    ctx.moveTo(200, 300);
    ctx.quadraticCurveTo(250, 250, 300, 300);
    ctx.stroke();
    
    ctx.beginPath();
    ctx.moveTo(350, 300);
    ctx.bezierCurveTo(375, 250, 425, 350, 450, 300);
    ctx.stroke();
    
    console.log('Shapes drawn');
}

console.log();

console.log("=== Drawing Gradients ===");

function drawGradients() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    // Linear gradient
    let linearGradient = ctx.createLinearGradient(0, 0, 200, 0);
    linearGradient.addColorStop(0, 'red');
    linearGradient.addColorStop(0.5, 'yellow');
    linearGradient.addColorStop(1, 'green');
    ctx.fillStyle = linearGradient;
    ctx.fillRect(10, 10, 200, 100);
    
    // Radial gradient
    let radialGradient = ctx.createRadialGradient(350, 150, 0, 350, 150, 100);
    radialGradient.addColorStop(0, 'white');
    radialGradient.addColorStop(1, 'black');
    ctx.fillStyle = radialGradient;
    ctx.fillRect(250, 50, 200, 200);
    
    console.log('Gradients drawn');
}

console.log();

console.log("=== Drawing Text ===");

function drawText() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    ctx.font = '30px Arial';
    ctx.fillStyle = 'black';
    ctx.fillText('Hello Canvas', 10, 50);
    
    ctx.font = 'bold 40px Arial';
    ctx.strokeStyle = 'blue';
    ctx.strokeText('Stroked Text', 10, 100);
    
    ctx.font = '20px Arial';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillText('Centered Text', canvas.width / 2, canvas.height / 2);
    
    // Reset alignment
    ctx.textAlign = 'left';
    ctx.textBaseline = 'alphabetic';
    
    console.log('Text drawn');
}

console.log();

console.log("=== Animation ===");

let animationId = null;
let ball = {
    x: 100,
    y: 100,
    vx: 2,
    vy: 2,
    radius: 20
};

function startAnimation() {
    if (animationId) {
        cancelAnimationFrame(animationId);
    }
    
    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        // Update position
        ball.x += ball.vx;
        ball.y += ball.vy;
        
        // Bounce
        if (ball.x - ball.radius < 0 || ball.x + ball.radius > canvas.width) {
            ball.vx = -ball.vx;
        }
        if (ball.y - ball.radius < 0 || ball.y + ball.radius > canvas.height) {
            ball.vy = -ball.vy;
        }
        
        // Draw ball
        ctx.fillStyle = 'red';
        ctx.beginPath();
        ctx.arc(ball.x, ball.y, ball.radius, 0, 2 * Math.PI);
        ctx.fill();
        
        animationId = requestAnimationFrame(animate);
    }
    
    animate();
    console.log('Animation started');
}

function clearCanvas() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    if (animationId) {
        cancelAnimationFrame(animationId);
        animationId = null;
    }
    console.log('Canvas cleared');
}

console.log();

console.log("=== Transformations ===");

function drawTransformed() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    // Original
    ctx.fillStyle = 'blue';
    ctx.fillRect(50, 50, 50, 50);
    
    // Translated
    ctx.save();
    ctx.translate(150, 0);
    ctx.fillStyle = 'red';
    ctx.fillRect(50, 50, 50, 50);
    ctx.restore();
    
    // Rotated
    ctx.save();
    ctx.translate(250, 100);
    ctx.rotate(Math.PI / 4);
    ctx.fillStyle = 'green';
    ctx.fillRect(-25, -25, 50, 50);
    ctx.restore();
    
    // Scaled
    ctx.save();
    ctx.translate(350, 100);
    ctx.scale(1.5, 1.5);
    ctx.fillStyle = 'purple';
    ctx.fillRect(-25, -25, 50, 50);
    ctx.restore();
    
    console.log('Transformed shapes drawn');
}

console.log();

console.log("=== Mouse Interaction ===");

let isDrawing = false;
let lastX = 0;
let lastY = 0;

canvas.addEventListener('mousedown', function(e) {
    isDrawing = true;
    let rect = canvas.getBoundingClientRect();
    lastX = e.clientX - rect.left;
    lastY = e.clientY - rect.top;
});

canvas.addEventListener('mousemove', function(e) {
    if (isDrawing) {
        let rect = canvas.getBoundingClientRect();
        let x = e.clientX - rect.left;
        let y = e.clientY - rect.top;
        
        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(x, y);
        ctx.strokeStyle = 'black';
        ctx.lineWidth = 2;
        ctx.stroke();
        
        lastX = x;
        lastY = y;
    }
});

canvas.addEventListener('mouseup', function() {
    isDrawing = false;
});

canvas.addEventListener('mouseleave', function() {
    isDrawing = false;
});

console.log('Mouse interaction enabled');
console.log();

console.log("=== WebGL Basics ===");

function initWebGL() {
    let gl = canvas.getContext('webgl');
    
    if (!gl) {
        console.error('WebGL not supported');
        return null;
    }
    
    console.log('WebGL context created');
    
    // Clear color
    gl.clearColor(0.0, 0.0, 0.0, 1.0);
    gl.clear(gl.COLOR_BUFFER_BIT);
    
    // Viewport
    gl.viewport(0, 0, canvas.width, canvas.height);
    
    return gl;
}

// Uncomment to test WebGL
// let gl = initWebGL();
console.log();

console.log("=== Image Drawing ===");

function drawImage() {
    let img = new Image();
    
    img.onload = function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 10, 10);
        ctx.drawImage(img, 200, 10, 100, 100);
        console.log('Image drawn');
    };
    
    img.onerror = function() {
        console.error('Error loading image');
    };
    
    // Use a placeholder or actual image URL
    img.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0icmVkIi8+PC9zdmc+';
}

console.log();

console.log("=== Particle System ===");

class Particle {
    constructor(x, y) {
        this.x = x;
        this.y = y;
        this.vx = (Math.random() - 0.5) * 4;
        this.vy = (Math.random() - 0.5) * 4;
        this.life = 1.0;
        this.size = Math.random() * 3 + 1;
    }
    
    update() {
        this.x += this.vx;
        this.y += this.vy;
        this.life -= 0.01;
    }
    
    draw() {
        ctx.globalAlpha = this.life;
        ctx.fillStyle = 'blue';
        ctx.fillRect(this.x, this.y, this.size, this.size);
    }
}

let particles = [];

function createParticles(x, y, count = 50) {
    for (let i = 0; i < count; i++) {
        particles.push(new Particle(x, y));
    }
}

function updateParticles() {
    particles = particles.filter(p => {
        p.update();
        return p.life > 0;
    });
}

function drawParticles() {
    particles.forEach(p => p.draw());
    ctx.globalAlpha = 1.0;
}

canvas.addEventListener('click', function(e) {
    let rect = canvas.getBoundingClientRect();
    let x = e.clientX - rect.left;
    let y = e.clientY - rect.top;
    createParticles(x, y);
});

// Animate particles
function animateParticles() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    updateParticles();
    drawParticles();
    requestAnimationFrame(animateParticles);
}

animateParticles();
console.log('Particle system active - click to create particles');
```

**Expected Output** (in browser):
- Canvas with various shapes
- Gradients
- Animated ball
- Drawing with mouse
- Particles on click

**Challenge (Optional)**:
- Build a complete drawing app
- Create a game
- Build a chart library
- Create an image editor

---

## Common Mistakes

### 1. Not Getting Context

```javascript
// ⚠️ Problem: No context
canvas.fillRect(10, 10, 50, 50);

// ✅ Solution: Get context first
let ctx = canvas.getContext('2d');
ctx.fillRect(10, 10, 50, 50);
```

### 2. Not Clearing Canvas

```javascript
// ⚠️ Problem: Draws over previous frames
function animate() {
    draw();
    requestAnimationFrame(animate);
}

// ✅ Solution: Clear first
function animate() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    draw();
    requestAnimationFrame(animate);
}
```

### 3. Not Saving/Restoring State

```javascript
// ⚠️ Problem: Transformations persist
ctx.translate(100, 100);
draw();
// Translation still active

// ✅ Solution: Save and restore
ctx.save();
ctx.translate(100, 100);
draw();
ctx.restore();
```

---

## Key Takeaways

1. **Canvas API**: Draw graphics with JavaScript
2. **Context**: Get 2D or WebGL context
3. **Shapes**: Rectangles, paths, arcs, curves
4. **Colors**: Fill, stroke, gradients, patterns
5. **Animation**: Use requestAnimationFrame
6. **Transformations**: Translate, rotate, scale
7. **WebGL**: 3D graphics (advanced)
8. **Best Practice**: Clear canvas, save/restore state, use requestAnimationFrame

---

## Quiz: Canvas

Test your understanding with these questions:

1. **Canvas context is:**
   - A) Synchronous
   - B) Asynchronous
   - C) Both
   - D) Neither

2. **fillRect() draws:**
   - A) Outlined rectangle
   - B) Filled rectangle
   - C) Both
   - D) Nothing

3. **beginPath() is:**
   - A) Required for paths
   - B) Optional
   - C) Not needed
   - D) Error

4. **requestAnimationFrame is:**
   - A) Synchronous
   - B) Asynchronous
   - C) Both
   - D) Neither

5. **save() and restore() are:**
   - A) For transformations
   - B) For colors
   - C) For state
   - D) Nothing

6. **WebGL is for:**
   - A) 2D graphics
   - B) 3D graphics
   - C) Both
   - D) Neither

7. **clearRect() clears:**
   - A) Entire canvas
   - B) Rectangle area
   - C) Both
   - D) Nothing

**Answers**:
1. A) Synchronous (drawing operations)
2. B) Filled rectangle
3. A) Required for paths
4. B) Asynchronous
5. C) For state
6. B) 3D graphics
7. B) Rectangle area

---

## Next Steps

Congratulations! You've completed Module 17: Browser APIs. You now know:
- Geolocation API
- File APIs
- Canvas API
- WebGL basics

**What's Next?**
- Course 5: Advanced JavaScript
- Module 18: Functional Programming
- Learn functional programming concepts
- Work with higher-order functions

---

## Additional Resources

- **MDN: Canvas API**: [developer.mozilla.org/en-US/docs/Web/API/Canvas_API](https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API)
- **MDN: WebGL**: [developer.mozilla.org/en-US/docs/Web/API/WebGL_API](https://developer.mozilla.org/en-US/docs/Web/API/WebGL_API)
- **Canvas Tutorial**: [developer.mozilla.org/en-US/docs/Web/API/Canvas_API/Tutorial](https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API/Tutorial)

---

*Lesson completed! You've finished Module 17: Browser APIs. Ready for Course 5: Advanced JavaScript!*

