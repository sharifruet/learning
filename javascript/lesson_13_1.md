# Lesson 13.1: DOM Basics

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what the DOM is
- Understand the DOM tree structure
- Differentiate between nodes and elements
- Access DOM elements using various methods
- Navigate the DOM tree
- Work with the document object
- Understand DOM relationships

---

## Introduction to the DOM

The Document Object Model (DOM) is a programming interface for HTML and XML documents. It represents the page structure as a tree of objects that can be manipulated with JavaScript.

### What is the DOM?

- **Tree Structure**: Represents HTML as a tree
- **Programmatic Access**: JavaScript can access and modify it
- **Live Representation**: Changes reflect in the browser
- **Standard API**: Cross-browser standard
- **Dynamic**: Can be modified at runtime

### Why Learn the DOM?

- **Interactive Web Pages**: Make pages dynamic
- **User Interaction**: Respond to user actions
- **Content Updates**: Change page content dynamically
- **Modern Web Development**: Essential for web apps

---

## DOM Tree Structure

### HTML to DOM Tree

```html
<!DOCTYPE html>
<html>
<head>
    <title>My Page</title>
</head>
<body>
    <h1>Hello</h1>
    <p>World</p>
</body>
</html>
```

**DOM Tree:**
```
Document
└── html
    ├── head
    │   └── title
    │       └── "My Page"
    └── body
        ├── h1
        │   └── "Hello"
        └── p
            └── "World"
```

### Understanding the Tree

- **Root**: `document` object
- **Nodes**: Every part of the tree (elements, text, attributes)
- **Elements**: HTML tags (div, p, h1, etc.)
- **Text Nodes**: Text content
- **Attributes**: Properties of elements (id, class, etc.)

---

## Nodes vs Elements

### Nodes

A node is any object in the DOM tree. Types include:
- **Element Node**: HTML elements (div, p, etc.)
- **Text Node**: Text content
- **Attribute Node**: Attributes (id, class, etc.)
- **Comment Node**: HTML comments
- **Document Node**: The document itself

### Elements

An element is a specific type of node representing HTML tags.

### Example

```html
<div id="container">Hello World</div>
```

- **Element Node**: `<div>` element
- **Attribute Node**: `id="container"`
- **Text Node**: "Hello World"

---

## The document Object

The `document` object represents the entire HTML document.

### Accessing document

```javascript
// document is available globally
console.log(document);
console.log(document.documentElement);  // <html> element
console.log(document.body);            // <body> element
console.log(document.head);            // <head> element
```

### Document Properties

```javascript
console.log(document.title);        // Page title
console.log(document.URL);          // Page URL
console.log(document.domain);       // Domain name
console.log(document.readyState);   // Loading state
```

---

## Accessing Elements

### getElementById()

Get element by its ID attribute:

```javascript
// HTML: <div id="myDiv">Content</div>
let element = document.getElementById('myDiv');
console.log(element);  // <div id="myDiv">Content</div>
```

**Note**: Returns `null` if element not found.

### getElementsByClassName()

Get elements by class name (returns HTMLCollection):

```javascript
// HTML: <div class="item">1</div><div class="item">2</div>
let elements = document.getElementsByClassName('item');
console.log(elements.length);  // 2
console.log(elements[0]);     // First element
```

### getElementsByTagName()

Get elements by tag name (returns HTMLCollection):

```javascript
// HTML: <p>Para 1</p><p>Para 2</p>
let paragraphs = document.getElementsByTagName('p');
console.log(paragraphs.length);  // 2
```

### querySelector()

Get first element matching CSS selector:

```javascript
// Get by ID
let element = document.querySelector('#myDiv');

// Get by class
let element = document.querySelector('.myClass');

// Get by tag
let element = document.querySelector('p');

// Complex selector
let element = document.querySelector('div.container > p');
```

### querySelectorAll()

Get all elements matching CSS selector (returns NodeList):

```javascript
// Get all elements with class
let elements = document.querySelectorAll('.item');

// Get all paragraphs
let paragraphs = document.querySelectorAll('p');

// Complex selector
let elements = document.querySelectorAll('div.container p');
```

### Comparison

| Method | Returns | Live Collection | Selector Support |
|--------|---------|----------------|------------------|
| `getElementById()` | Single element | No | No |
| `getElementsByClassName()` | HTMLCollection | Yes | No |
| `getElementsByTagName()` | HTMLCollection | Yes | No |
| `querySelector()` | Single element | No | Yes |
| `querySelectorAll()` | NodeList | No | Yes |

---

## HTMLCollection vs NodeList

### HTMLCollection

- **Live**: Updates when DOM changes
- **Array-like**: Can use index, length
- **Methods**: Limited (no forEach in older browsers)

```javascript
let items = document.getElementsByClassName('item');
console.log(items.length);  // Current count

// Add new element
document.body.appendChild(document.createElement('div')).className = 'item';
console.log(items.length);  // Updated count (live)
```

### NodeList

- **Static**: Doesn't update (querySelectorAll)
- **Array-like**: Can use index, length
- **Methods**: forEach, entries, keys, values

```javascript
let items = document.querySelectorAll('.item');
console.log(items.length);  // Current count

// Add new element
document.body.appendChild(document.createElement('div')).className = 'item';
console.log(items.length);  // Same count (static)
```

### Converting to Array

```javascript
// HTMLCollection to Array
let items = Array.from(document.getElementsByClassName('item'));

// NodeList to Array
let items = Array.from(document.querySelectorAll('.item'));

// Or use spread
let items = [...document.querySelectorAll('.item')];
```

---

## Practical Examples

### Example 1: Accessing Elements

```html
<!DOCTYPE html>
<html>
<body>
    <div id="container">
        <h1 class="title">Hello</h1>
        <p class="text">World</p>
        <p class="text">JavaScript</p>
    </div>
</body>
</html>
```

```javascript
// Get by ID
let container = document.getElementById('container');

// Get by class
let titles = document.getElementsByClassName('title');
let texts = document.getElementsByClassName('text');

// Get by tag
let paragraphs = document.getElementsByTagName('p');

// Query selector
let firstText = document.querySelector('.text');
let allTexts = document.querySelectorAll('.text');

// Complex selector
let textInContainer = document.querySelector('#container .text');
```

### Example 2: Checking Element Existence

```javascript
function getElementSafely(id) {
    let element = document.getElementById(id);
    if (element) {
        return element;
    } else {
        console.warn(`Element with id "${id}" not found`);
        return null;
    }
}

let element = getElementSafely('myDiv');
if (element) {
    // Work with element
    console.log(element);
}
```

### Example 3: Working with Collections

```javascript
// Get all buttons
let buttons = document.querySelectorAll('button');

// Iterate with forEach
buttons.forEach((button, index) => {
    console.log(`Button ${index}:`, button.textContent);
});

// Convert to array and use array methods
let buttonArray = Array.from(buttons);
let buttonTexts = buttonArray.map(btn => btn.textContent);
```

---

## Practice Exercise

### Exercise: DOM Navigation

**Objective**: Practice accessing and navigating DOM elements.

**Instructions**:

1. Create an HTML file with various elements
2. Create a JavaScript file to access elements
3. Practice:
   - Using all element access methods
   - Working with HTMLCollection and NodeList
   - Navigating the DOM tree
   - Checking element existence

**Example Solution**:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOM Navigation Practice</title>
</head>
<body>
    <div id="container">
        <h1 class="title">My Page</h1>
        <p class="text">First paragraph</p>
        <p class="text">Second paragraph</p>
        <ul id="list">
            <li class="item">Item 1</li>
            <li class="item">Item 2</li>
            <li class="item">Item 3</li>
        </ul>
        <button class="btn">Click Me</button>
        <button class="btn">Another Button</button>
    </div>
    <script src="dom-navigation.js"></script>
</body>
</html>
```

```javascript
// dom-navigation.js
console.log("=== DOM Navigation Practice ===");

console.log("\n=== Document Object ===");
console.log("Document:", document);
console.log("Document title:", document.title);
console.log("Document URL:", document.URL);
console.log("Document body:", document.body);
console.log("Document head:", document.head);

console.log("\n=== getElementById() ===");
let container = document.getElementById('container');
console.log("Container:", container);
console.log("Container ID:", container.id);
console.log("Container tag name:", container.tagName);

let list = document.getElementById('list');
console.log("List:", list);
console.log("List children count:", list.children.length);

console.log("\n=== getElementsByClassName() ===");
let texts = document.getElementsByClassName('text');
console.log("Text elements count:", texts.length);
console.log("First text:", texts[0].textContent);
console.log("Second text:", texts[1].textContent);

let items = document.getElementsByClassName('item');
console.log("Item elements count:", items.length);
for (let i = 0; i < items.length; i++) {
    console.log(`Item ${i + 1}:`, items[i].textContent);
}

let buttons = document.getElementsByClassName('btn');
console.log("Button elements count:", buttons.length);

console.log("\n=== getElementsByTagName() ===");
let paragraphs = document.getElementsByTagName('p');
console.log("Paragraphs count:", paragraphs.length);

let listItems = document.getElementsByTagName('li');
console.log("List items count:", listItems.length);

let allDivs = document.getElementsByTagName('div');
console.log("Divs count:", allDivs.length);

console.log("\n=== querySelector() ===");
let firstText = document.querySelector('.text');
console.log("First text element:", firstText.textContent);

let title = document.querySelector('.title');
console.log("Title:", title.textContent);

let firstButton = document.querySelector('.btn');
console.log("First button:", firstButton.textContent);

let containerQuery = document.querySelector('#container');
console.log("Container via querySelector:", containerQuery.id);

let nestedItem = document.querySelector('#list .item');
console.log("First nested item:", nestedItem.textContent);

console.log("\n=== querySelectorAll() ===");
let allTexts = document.querySelectorAll('.text');
console.log("All text elements:", allTexts.length);
allTexts.forEach((text, index) => {
    console.log(`Text ${index + 1}:`, text.textContent);
});

let allItems = document.querySelectorAll('.item');
console.log("All items:", allItems.length);
allItems.forEach((item, index) => {
    console.log(`Item ${index + 1}:`, item.textContent);
});

let allButtons = document.querySelectorAll('.btn');
console.log("All buttons:", allButtons.length);
allButtons.forEach((btn, index) => {
    console.log(`Button ${index + 1}:`, btn.textContent);
});

console.log("\n=== Complex Selectors ===");
let itemsInList = document.querySelectorAll('#list .item');
console.log("Items in list:", itemsInList.length);

let buttonsInContainer = document.querySelectorAll('#container .btn');
console.log("Buttons in container:", buttonsInContainer.length);

let directChildren = document.querySelectorAll('#container > p');
console.log("Direct paragraph children:", directChildren.length);

console.log("\n=== HTMLCollection vs NodeList ===");
let classCollection = document.getElementsByClassName('text');
let queryNodeList = document.querySelectorAll('.text');

console.log("HTMLCollection length:", classCollection.length);
console.log("NodeList length:", queryNodeList.length);

// Add new element
let newP = document.createElement('p');
newP.className = 'text';
newP.textContent = 'New paragraph';
document.getElementById('container').appendChild(newP);

console.log("After adding element:");
console.log("HTMLCollection length (live):", classCollection.length);
console.log("NodeList length (static):", queryNodeList.length);

console.log("\n=== Converting to Array ===");
let itemsArray = Array.from(items);
console.log("Items as array:", itemsArray);
console.log("Can use array methods:", itemsArray.map(item => item.textContent));

let buttonsArray = [...allButtons];
console.log("Buttons as array:", buttonsArray);
console.log("Button texts:", buttonsArray.map(btn => btn.textContent));

console.log("\n=== Checking Element Existence ===");
function getElementSafely(id) {
    let element = document.getElementById(id);
    if (element) {
        return element;
    } else {
        console.warn(`Element with id "${id}" not found`);
        return null;
    }
}

let existing = getElementSafely('container');
console.log("Existing element:", existing ? existing.id : "null");

let missing = getElementSafely('nonExistent');
console.log("Missing element:", missing);

console.log("\n=== Element Properties ===");
if (container) {
    console.log("Container ID:", container.id);
    console.log("Container className:", container.className);
    console.log("Container tagName:", container.tagName);
    console.log("Container textContent:", container.textContent);
    console.log("Container innerHTML:", container.innerHTML.substring(0, 50) + "...");
}
```

**Expected Output** (in browser console):
```
=== DOM Navigation Practice ===

=== Document Object ===
Document: [Document object]
Document title: DOM Navigation Practice
Document URL: [current URL]
Document body: [body element]
Document head: [head element]

=== getElementById() ===
Container: [div#container]
Container ID: container
Container tag name: DIV
List: [ul#list]
List children count: 3

=== getElementsByClassName() ===
Text elements count: 2
First text: First paragraph
Second text: Second paragraph
Item elements count: 3
Item 1: Item 1
Item 2: Item 2
Item 3: Item 3
Button elements count: 2

=== getElementsByTagName() ===
Paragraphs count: 2
List items count: 3
Divs count: 1

=== querySelector() ===
First text element: First paragraph
Title: My Page
First button: Click Me
Container via querySelector: container
First nested item: Item 1

=== querySelectorAll() ===
All text elements: 2
Text 1: First paragraph
Text 2: Second paragraph
All items: 3
Item 1: Item 1
Item 2: Item 2
Item 3: Item 3
All buttons: 2
Button 1: Click Me
Button 2: Another Button

=== Complex Selectors ===
Items in list: 3
Buttons in container: 2
Direct paragraph children: 2

=== HTMLCollection vs NodeList ===
HTMLCollection length: 2
NodeList length: 2
After adding element:
HTMLCollection length (live): 3
NodeList length (static): 2

=== Converting to Array ===
Items as array: [array of elements]
Can use array methods: ["Item 1", "Item 2", "Item 3"]
Buttons as array: [array of elements]
Button texts: ["Click Me", "Another Button"]

=== Checking Element Existence ===
Existing element: container
Missing element: null

=== Element Properties ===
Container ID: container
Container className: 
Container tagName: DIV
Container textContent: [all text content]
Container innerHTML: [HTML content]
```

**Challenge (Optional)**:
- Build a DOM inspector tool
- Create element finder utilities
- Build a DOM navigation helper
- Create element validation functions

---

## Common Mistakes

### 1. Not Checking for null

```javascript
// ⚠️ Problem: Element might not exist
let element = document.getElementById('myDiv');
element.textContent = "Hello";  // Error if element is null

// ✅ Solution: Always check
let element = document.getElementById('myDiv');
if (element) {
    element.textContent = "Hello";
}
```

### 2. Confusing HTMLCollection and Array

```javascript
// ⚠️ Problem: HTMLCollection doesn't have all array methods
let items = document.getElementsByClassName('item');
items.forEach(item => { });  // Error in older browsers

// ✅ Solution: Convert to array
let items = Array.from(document.getElementsByClassName('item'));
items.forEach(item => { });
```

### 3. Using Wrong Method

```javascript
// ⚠️ Problem: getElementById doesn't accept selector
let element = document.getElementById('.myClass');  // Wrong

// ✅ Solution: Use appropriate method
let element = document.querySelector('.myClass');
// or
let element = document.getElementsByClassName('myClass')[0];
```

### 4. Forgetting Live Collections

```javascript
// ⚠️ Problem: Collection updates automatically
let items = document.getElementsByClassName('item');
console.log(items.length);  // 3

// Add new item
document.body.appendChild(createItem());

console.log(items.length);  // 4 (updated automatically)

// ✅ Solution: Be aware of live collections
// Or use querySelectorAll for static collection
```

---

## Key Takeaways

1. **DOM**: Tree structure representing HTML
2. **Nodes**: All objects in DOM tree
3. **Elements**: Specific type of node (HTML tags)
4. **Access Methods**: getElementById, querySelector, etc.
5. **HTMLCollection**: Live collection (updates automatically)
6. **NodeList**: Static collection (from querySelectorAll)
7. **Best Practice**: Always check for null, use querySelector for flexibility
8. **Modern Approach**: Prefer querySelector/querySelectorAll

---

## Quiz: DOM Basics

Test your understanding with these questions:

1. **What does DOM stand for?**
   - A) Document Object Model
   - B) Data Object Model
   - C) Document Order Model
   - D) Data Order Model

2. **getElementById returns:**
   - A) Array
   - B) Single element or null
   - C) HTMLCollection
   - D) NodeList

3. **querySelectorAll returns:**
   - A) HTMLCollection
   - B) NodeList
   - C) Array
   - D) Single element

4. **HTMLCollection is:**
   - A) Static
   - B) Live
   - C) Both
   - D) Neither

5. **querySelector supports:**
   - A) ID only
   - B) Class only
   - C) CSS selectors
   - D) Tag only

6. **document represents:**
   - A) Body element
   - B) HTML element
   - C) Entire document
   - D) Head element

7. **Which is most flexible?**
   - A) getElementById
   - B) getElementsByClassName
   - C) querySelector
   - D) getElementsByTagName

**Answers**:
1. A) Document Object Model
2. B) Single element or null
3. B) NodeList
4. B) Live
5. C) CSS selectors
6. C) Entire document
7. C) querySelector

---

## Next Steps

Congratulations! You've learned DOM basics. You now know:
- What the DOM is
- How to access elements
- Different access methods
- HTMLCollection vs NodeList

**What's Next?**
- Lesson 13.2: Manipulating the DOM
- Learn to create and modify elements
- Change content dynamically
- Build interactive web pages

---

## Additional Resources

- **MDN: DOM**: [developer.mozilla.org/en-US/docs/Web/API/Document_Object_Model](https://developer.mozilla.org/en-US/docs/Web/API/Document_Object_Model)
- **MDN: Document**: [developer.mozilla.org/en-US/docs/Web/API/Document](https://developer.mozilla.org/en-US/docs/Web/API/Document)
- **JavaScript.info: DOM**: [javascript.info/dom-nodes](https://javascript.info/dom-nodes)

---

*Lesson completed! You're ready to move on to the next lesson.*

