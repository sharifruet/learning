# Lesson 13.2: Manipulating the DOM

## Learning Objectives

By the end of this lesson, you will be able to:
- Create new DOM elements
- Add elements to the DOM
- Remove elements from the DOM
- Modify element content (text and HTML)
- Change element attributes
- Add and remove CSS classes
- Update element styles
- Build dynamic web pages

---

## Introduction to DOM Manipulation

DOM manipulation allows you to dynamically change the content, structure, and appearance of web pages using JavaScript.

### Why Manipulate the DOM?

- **Dynamic Content**: Update page without reload
- **User Interaction**: Respond to user actions
- **Real-time Updates**: Show live data
- **Interactive UIs**: Build modern web applications

---

## Creating Elements

### createElement()

Create a new HTML element:

```javascript
// Create a div element
let div = document.createElement('div');

// Create a paragraph
let paragraph = document.createElement('p');

// Create a button
let button = document.createElement('button');
```

### Setting Element Properties

```javascript
let div = document.createElement('div');
div.id = 'myDiv';
div.className = 'container';
div.textContent = 'Hello World';
```

### Creating Elements with Attributes

```javascript
let link = document.createElement('a');
link.href = 'https://example.com';
link.textContent = 'Visit Example';
link.target = '_blank';
```

---

## Adding Elements to DOM

### appendChild()

Add element as the last child:

```javascript
let container = document.getElementById('container');
let newDiv = document.createElement('div');
newDiv.textContent = 'New content';
container.appendChild(newDiv);
```

### insertBefore()

Insert element before another element:

```javascript
let container = document.getElementById('container');
let newDiv = document.createElement('div');
let existingDiv = document.getElementById('existing');
container.insertBefore(newDiv, existingDiv);
```

### insertAdjacentElement()

Insert element at specific position:

```javascript
let element = document.getElementById('target');

// beforebegin: Before element
element.insertAdjacentElement('beforebegin', newElement);

// afterbegin: First child
element.insertAdjacentElement('afterbegin', newElement);

// beforeend: Last child
element.insertAdjacentElement('beforeend', newElement);

// afterend: After element
element.insertAdjacentElement('afterend', newElement);
```

### prepend() and append()

Modern methods (may need polyfill for older browsers):

```javascript
let container = document.getElementById('container');

// Add at beginning
container.prepend(newElement);

// Add at end
container.append(newElement);
```

---

## Removing Elements

### removeChild()

Remove a child element:

```javascript
let container = document.getElementById('container');
let child = document.getElementById('child');
container.removeChild(child);
```

### remove()

Modern method to remove element:

```javascript
let element = document.getElementById('myElement');
element.remove();
```

### Clearing All Children

```javascript
let container = document.getElementById('container');

// Method 1: Remove all children
while (container.firstChild) {
    container.removeChild(container.firstChild);
}

// Method 2: Clear innerHTML
container.innerHTML = '';

// Method 3: Modern way
container.replaceChildren();
```

---

## Modifying Element Content

### textContent

Get or set text content (strips HTML):

```javascript
let element = document.getElementById('myDiv');

// Get text content
console.log(element.textContent);  // "Hello World"

// Set text content
element.textContent = 'New text';
```

### innerHTML

Get or set HTML content:

```javascript
let element = document.getElementById('myDiv');

// Get HTML
console.log(element.innerHTML);  // "<span>Hello</span>"

// Set HTML
element.innerHTML = '<strong>Bold text</strong>';
```

### innerText

Get or set visible text (respects CSS):

```javascript
let element = document.getElementById('myDiv');
element.innerText = 'Visible text';
```

### Comparison

| Property | Gets | Sets | HTML Support |
|----------|------|------|--------------|
| `textContent` | All text | Plain text | No |
| `innerHTML` | HTML string | HTML string | Yes |
| `innerText` | Visible text | Plain text | No |

---

## Changing Attributes

### getAttribute() and setAttribute()

```javascript
let element = document.getElementById('myLink');

// Get attribute
let href = element.getAttribute('href');

// Set attribute
element.setAttribute('href', 'https://example.com');
element.setAttribute('target', '_blank');
element.setAttribute('data-id', '123');
```

### Direct Property Access

```javascript
let element = document.getElementById('myLink');

// Set properties directly
element.href = 'https://example.com';
element.id = 'newId';
element.className = 'newClass';
```

### hasAttribute() and removeAttribute()

```javascript
let element = document.getElementById('myDiv');

// Check if attribute exists
if (element.hasAttribute('data-id')) {
    console.log('Has data-id');
}

// Remove attribute
element.removeAttribute('data-id');
```

### data-* Attributes

```javascript
let element = document.getElementById('myDiv');

// Set data attribute
element.setAttribute('data-user-id', '123');
element.setAttribute('data-status', 'active');

// Access via dataset
console.log(element.dataset.userId);  // "123"
console.log(element.dataset.status);  // "active"

// Set via dataset
element.dataset.userId = '456';
element.dataset.newAttribute = 'value';
```

---

## Working with Classes

### className

Get or set all classes:

```javascript
let element = document.getElementById('myDiv');

// Get classes
console.log(element.className);  // "class1 class2"

// Set classes
element.className = 'newClass';
element.className = 'class1 class2 class3';
```

### classList

Modern API for class manipulation:

```javascript
let element = document.getElementById('myDiv');

// Add class
element.classList.add('newClass');
element.classList.add('class1', 'class2');

// Remove class
element.classList.remove('oldClass');
element.classList.remove('class1', 'class2');

// Toggle class
element.classList.toggle('active');

// Check if has class
if (element.classList.contains('active')) {
    console.log('Has active class');
}

// Replace class
element.classList.replace('oldClass', 'newClass');
```

### classList Methods

```javascript
let element = document.getElementById('myDiv');

// Add multiple classes
element.classList.add('class1', 'class2', 'class3');

// Remove multiple classes
element.classList.remove('class1', 'class2');

// Toggle with condition
element.classList.toggle('active', true);   // Force add
element.classList.toggle('active', false);  // Force remove

// Get all classes as array
let classes = Array.from(element.classList);
console.log(classes);  // ["class1", "class2"]
```

---

## Changing Styles

### style Property

Set inline styles:

```javascript
let element = document.getElementById('myDiv');

// Set individual styles
element.style.color = 'red';
element.style.backgroundColor = 'blue';
element.style.fontSize = '20px';
element.style.display = 'none';
```

### style Property (camelCase)

CSS properties use camelCase in JavaScript:

```javascript
element.style.backgroundColor = 'red';      // background-color
element.style.fontSize = '16px';           // font-size
element.style.marginTop = '10px';          // margin-top
element.style.zIndex = '100';              // z-index
```

### getComputedStyle()

Get computed styles (including CSS):

```javascript
let element = document.getElementById('myDiv');
let styles = window.getComputedStyle(element);

console.log(styles.color);
console.log(styles.backgroundColor);
console.log(styles.fontSize);
```

### Setting Multiple Styles

```javascript
// Method 1: Individual properties
element.style.color = 'red';
element.style.fontSize = '20px';

// Method 2: cssText
element.style.cssText = 'color: red; font-size: 20px; background: blue;';

// Method 3: Object.assign
Object.assign(element.style, {
    color: 'red',
    fontSize: '20px',
    backgroundColor: 'blue'
});
```

---

## Practical Examples

### Example 1: Creating a List

```javascript
function createList(items) {
    let ul = document.createElement('ul');
    
    items.forEach(item => {
        let li = document.createElement('li');
        li.textContent = item;
        ul.appendChild(li);
    });
    
    return ul;
}

let list = createList(['Apple', 'Banana', 'Orange']);
document.body.appendChild(list);
```

### Example 2: Dynamic Card Creation

```javascript
function createCard(title, content) {
    let card = document.createElement('div');
    card.className = 'card';
    
    let cardTitle = document.createElement('h2');
    cardTitle.textContent = title;
    cardTitle.className = 'card-title';
    
    let cardContent = document.createElement('p');
    cardContent.textContent = content;
    cardContent.className = 'card-content';
    
    card.appendChild(cardTitle);
    card.appendChild(cardContent);
    
    return card;
}

let card = createCard('My Title', 'Card content here');
document.getElementById('container').appendChild(card);
```

### Example 3: Toggle Visibility

```javascript
function toggleElement(elementId) {
    let element = document.getElementById(elementId);
    
    if (element.style.display === 'none') {
        element.style.display = 'block';
    } else {
        element.style.display = 'none';
    }
}

// Or using classList
function toggleElement(elementId) {
    let element = document.getElementById(elementId);
    element.classList.toggle('hidden');
}
```

### Example 4: Form Validation Display

```javascript
function showError(inputId, message) {
    let input = document.getElementById(inputId);
    
    // Remove existing error
    let existingError = input.parentElement.querySelector('.error');
    if (existingError) {
        existingError.remove();
    }
    
    // Add error class
    input.classList.add('error');
    
    // Create error message
    let errorDiv = document.createElement('div');
    errorDiv.className = 'error';
    errorDiv.textContent = message;
    errorDiv.style.color = 'red';
    
    input.parentElement.appendChild(errorDiv);
}
```

---

## Practice Exercise

### Exercise: DOM Manipulation

**Objective**: Practice creating, modifying, and removing DOM elements.

**Instructions**:

1. Create an HTML file with a container
2. Create a JavaScript file for manipulation
3. Practice:
   - Creating elements
   - Adding elements
   - Removing elements
   - Modifying content
   - Changing attributes and classes
   - Updating styles

**Example Solution**:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOM Manipulation Practice</title>
    <style>
        .card {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 10px;
            border-radius: 5px;
        }
        .highlight {
            background-color: yellow;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div id="container">
        <h1>DOM Manipulation Practice</h1>
        <button id="addBtn">Add Card</button>
        <button id="removeBtn">Remove Last</button>
        <button id="toggleBtn">Toggle Highlight</button>
    </div>
    <script src="dom-manipulation.js"></script>
</body>
</html>
```

```javascript
// dom-manipulation.js
console.log("=== DOM Manipulation Practice ===");

console.log("\n=== Creating Elements ===");

// Create a div
let div = document.createElement('div');
div.id = 'myDiv';
div.className = 'card';
div.textContent = 'Created with createElement';
console.log("Created div:", div);

// Create a paragraph
let paragraph = document.createElement('p');
paragraph.textContent = 'This is a paragraph';
paragraph.style.color = 'blue';
console.log("Created paragraph:", paragraph);

// Create a button
let button = document.createElement('button');
button.textContent = 'Click Me';
button.className = 'btn';
button.setAttribute('data-action', 'click');
console.log("Created button:", button);
console.log();

console.log("=== Adding Elements ===");

let container = document.getElementById('container');

// Append child
let newDiv = document.createElement('div');
newDiv.textContent = 'Appended element';
newDiv.className = 'card';
container.appendChild(newDiv);
console.log("Appended element to container");

// Insert before
let beforeDiv = document.createElement('div');
beforeDiv.textContent = 'Inserted before';
beforeDiv.className = 'card';
container.insertBefore(beforeDiv, newDiv);
console.log("Inserted element before");

// Using insertAdjacentElement
let adjacentDiv = document.createElement('div');
adjacentDiv.textContent = 'Adjacent element';
adjacentDiv.className = 'card';
container.insertAdjacentElement('beforeend', adjacentDiv);
console.log("Inserted adjacent element");
console.log();

console.log("=== Modifying Content ===");

let contentDiv = document.createElement('div');
contentDiv.id = 'contentDiv';

// textContent
contentDiv.textContent = 'Plain text content';
console.log("textContent:", contentDiv.textContent);

// innerHTML
contentDiv.innerHTML = '<strong>Bold</strong> and <em>italic</em> text';
console.log("innerHTML:", contentDiv.innerHTML);
console.log("textContent after innerHTML:", contentDiv.textContent);

container.appendChild(contentDiv);
console.log();

console.log("=== Changing Attributes ===");

let link = document.createElement('a');
link.href = 'https://example.com';
link.textContent = 'Visit Example';
link.target = '_blank';
link.setAttribute('data-link-id', '123');

console.log("Link href:", link.getAttribute('href'));
console.log("Link target:", link.target);
console.log("Link data-id:", link.dataset.linkId);

// Update attributes
link.setAttribute('href', 'https://google.com');
link.setAttribute('data-link-id', '456');
console.log("Updated href:", link.getAttribute('href'));
console.log("Updated data-id:", link.dataset.linkId);
console.log();

console.log("=== Working with Classes ===");

let classDiv = document.createElement('div');
classDiv.className = 'card';

// Add classes
classDiv.classList.add('highlight');
classDiv.classList.add('active', 'visible');
console.log("Classes after add:", classDiv.className);

// Remove classes
classDiv.classList.remove('active');
console.log("Classes after remove:", classDiv.className);

// Toggle class
classDiv.classList.toggle('highlight');
console.log("Has highlight:", classDiv.classList.contains('highlight'));

classDiv.classList.toggle('highlight');
console.log("Has highlight after toggle:", classDiv.classList.contains('highlight'));

// Replace class
classDiv.classList.replace('visible', 'hidden');
console.log("Classes after replace:", classDiv.className);
console.log();

console.log("=== Changing Styles ===");

let styleDiv = document.createElement('div');
styleDiv.textContent = 'Styled div';
styleDiv.style.color = 'red';
styleDiv.style.backgroundColor = 'yellow';
styleDiv.style.padding = '20px';
styleDiv.style.border = '2px solid black';

console.log("Color:", styleDiv.style.color);
console.log("Background:", styleDiv.style.backgroundColor);

// Using cssText
let styleDiv2 = document.createElement('div');
styleDiv2.textContent = 'Styled with cssText';
styleDiv2.style.cssText = 'color: blue; font-size: 20px; margin: 10px;';

// Using Object.assign
let styleDiv3 = document.createElement('div');
styleDiv3.textContent = 'Styled with Object.assign';
Object.assign(styleDiv3.style, {
    color: 'green',
    fontSize: '18px',
    padding: '15px'
});

container.appendChild(styleDiv);
container.appendChild(styleDiv2);
container.appendChild(styleDiv3);
console.log();

console.log("=== Removing Elements ===");

// Create elements to remove
let removeDiv1 = document.createElement('div');
removeDiv1.textContent = 'Will be removed';
removeDiv1.id = 'removeMe';
container.appendChild(removeDiv1);

let removeDiv2 = document.createElement('div');
removeDiv2.textContent = 'Will also be removed';
container.appendChild(removeDiv2);

console.log("Container children before removal:", container.children.length);

// Remove by reference
container.removeChild(removeDiv1);
console.log("Removed first element");

// Remove using remove()
removeDiv2.remove();
console.log("Removed second element");

console.log("Container children after removal:", container.children.length);
console.log();

console.log("=== Practical Example: Card Creator ===");

function createCard(title, content, color = 'white') {
    let card = document.createElement('div');
    card.className = 'card';
    card.style.backgroundColor = color;
    
    let cardTitle = document.createElement('h2');
    cardTitle.textContent = title;
    cardTitle.style.marginTop = '0';
    
    let cardContent = document.createElement('p');
    cardContent.textContent = content;
    
    let removeBtn = document.createElement('button');
    removeBtn.textContent = 'Remove';
    removeBtn.onclick = () => card.remove();
    
    card.appendChild(cardTitle);
    card.appendChild(cardContent);
    card.appendChild(removeBtn);
    
    return card;
}

// Add cards
let card1 = createCard('Card 1', 'This is the first card', '#f0f0f0');
let card2 = createCard('Card 2', 'This is the second card', '#e0e0e0');
let card3 = createCard('Card 3', 'This is the third card', '#d0d0d0');

container.appendChild(card1);
container.appendChild(card2);
container.appendChild(card3);

console.log("Created 3 cards");
console.log();

console.log("=== Toggle Functionality ===");

let toggleDiv = document.createElement('div');
toggleDiv.id = 'toggleDiv';
toggleDiv.textContent = 'This div can be toggled';
toggleDiv.style.padding = '10px';
toggleDiv.style.border = '1px solid black';
container.appendChild(toggleDiv);

function toggleVisibility(elementId) {
    let element = document.getElementById(elementId);
    element.classList.toggle('hidden');
    console.log("Toggled visibility, is hidden:", element.classList.contains('hidden'));
}

// Test toggle
toggleVisibility('toggleDiv');
toggleVisibility('toggleDiv');
console.log();

console.log("=== List Creator ===");

function createList(items) {
    let ul = document.createElement('ul');
    ul.style.listStyle = 'none';
    ul.style.padding = '0';
    
    items.forEach((item, index) => {
        let li = document.createElement('li');
        li.textContent = item;
        li.style.padding = '5px';
        li.style.backgroundColor = index % 2 === 0 ? '#f0f0f0' : '#ffffff';
        ul.appendChild(li);
    });
    
    return ul;
}

let list = createList(['Apple', 'Banana', 'Orange', 'Grape', 'Mango']);
container.appendChild(list);
console.log("Created list with", list.children.length, "items");
```

**Expected Output** (in browser console):
```
=== DOM Manipulation Practice ===

=== Creating Elements ===
Created div: [div element]
Created paragraph: [p element]
Created button: [button element]

=== Adding Elements ===
Appended element to container
Inserted element before
Inserted adjacent element

=== Modifying Content ===
textContent: Plain text content
innerHTML: <strong>Bold</strong> and <em>italic</em> text
textContent after innerHTML: Bold and italic text

=== Changing Attributes ===
Link href: https://example.com
Link target: _blank
Link data-id: 123
Updated href: https://google.com
Updated data-id: 456

=== Working with Classes ===
Classes after add: card highlight active visible
Classes after remove: card highlight visible
Has highlight: false
Has highlight after toggle: true
Classes after replace: card highlight hidden

=== Changing Styles ===
Color: red
Background: yellow

=== Removing Elements ===
Container children before removal: [number]
Removed first element
Removed second element
Container children after removal: [number]

=== Practical Example: Card Creator ===
Created 3 cards

=== Toggle Functionality ===
Toggled visibility, is hidden: true
Toggled visibility, is hidden: false

=== List Creator ===
Created list with 5 items
```

**Challenge (Optional)**:
- Build a dynamic form generator
- Create a todo list application
- Build a card-based UI system
- Create a dynamic table generator

---

## Common Mistakes

### 1. Using innerHTML with User Input

```javascript
// ⚠️ Security risk: XSS vulnerability
let userInput = "<img src=x onerror='alert(1)'>";
element.innerHTML = userInput;  // Dangerous!

// ✅ Solution: Use textContent or sanitize
element.textContent = userInput;
// or use a sanitization library
```

### 2. Not Checking Element Existence

```javascript
// ⚠️ Problem: Element might not exist
let element = document.getElementById('myDiv');
element.appendChild(newElement);  // Error if element is null

// ✅ Solution: Always check
let element = document.getElementById('myDiv');
if (element) {
    element.appendChild(newElement);
}
```

### 3. Creating Elements in Loop Without Optimization

```javascript
// ⚠️ Problem: Multiple DOM updates
for (let i = 0; i < 1000; i++) {
    let div = document.createElement('div');
    container.appendChild(div);  // Updates DOM each time
}

// ✅ Solution: Use DocumentFragment
let fragment = document.createDocumentFragment();
for (let i = 0; i < 1000; i++) {
    let div = document.createElement('div');
    fragment.appendChild(div);
}
container.appendChild(fragment);  // Single DOM update
```

### 4. Confusing textContent and innerHTML

```javascript
// ⚠️ Problem: innerHTML doesn't work as expected
element.innerHTML = '<strong>Bold</strong>';  // Renders HTML
element.textContent = '<strong>Bold</strong>';  // Shows as text

// ✅ Solution: Use appropriate property
// Use innerHTML for HTML, textContent for plain text
```

---

## Key Takeaways

1. **createElement()**: Create new elements
2. **appendChild()**: Add elements to DOM
3. **remove()**: Remove elements
4. **textContent**: Plain text content
5. **innerHTML**: HTML content
6. **setAttribute()**: Set attributes
7. **classList**: Modern class manipulation
8. **style**: Inline styles
9. **Best Practice**: Check for null, use DocumentFragment for multiple elements
10. **Security**: Be careful with innerHTML and user input

---

## Quiz: DOM Manipulation

Test your understanding with these questions:

1. **createElement() creates:**
   - A) Element in DOM
   - B) Element object (not in DOM)
   - C) Text node
   - D) Attribute

2. **appendChild() adds element:**
   - A) At beginning
   - B) At end
   - C) Before element
   - D) After element

3. **textContent:**
   - A) Includes HTML
   - B) Strips HTML
   - C) Renders HTML
   - D) Nothing

4. **innerHTML:**
   - A) Plain text only
   - B) Renders HTML
   - C) Strips HTML
   - D) Nothing

5. **classList.add() is:**
   - A) Old method
   - B) Modern method
   - C) Deprecated
   - D) Not available

6. **element.remove() is:**
   - A) Old method
   - B) Modern method
   - C) Not available
   - D) Error

7. **DocumentFragment is used for:**
   - A) Single element
   - B) Multiple elements (optimization)
   - C) Text nodes
   - D) Attributes

**Answers**:
1. B) Element object (not in DOM yet)
2. B) At end
3. B) Strips HTML
4. B) Renders HTML
5. B) Modern method
6. B) Modern method
7. B) Multiple elements (optimization)

---

## Next Steps

Congratulations! You've learned DOM manipulation. You now know:
- How to create elements
- How to add and remove elements
- How to modify content
- How to change attributes and classes

**What's Next?**
- Lesson 13.3: DOM Traversal
- Learn to navigate the DOM tree
- Understand parent/child relationships
- Build more complex DOM operations

---

## Additional Resources

- **MDN: Element**: [developer.mozilla.org/en-US/docs/Web/API/Element](https://developer.mozilla.org/en-US/docs/Web/API/Element)
- **MDN: Document.createElement()**: [developer.mozilla.org/en-US/docs/Web/API/Document/createElement](https://developer.mozilla.org/en-US/docs/Web/API/Document/createElement)
- **JavaScript.info: DOM Manipulation**: [javascript.info/modifying-document](https://javascript.info/modifying-document)

---

*Lesson completed! You're ready to move on to the next lesson.*

