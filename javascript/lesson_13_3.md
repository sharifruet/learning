# Lesson 13.3: DOM Traversal

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand parent, child, and sibling relationships
- Navigate up the DOM tree (parent nodes)
- Navigate down the DOM tree (child nodes)
- Navigate sideways (sibling nodes)
- Use traversal methods effectively
- Differentiate between Element and Node methods
- Build efficient DOM navigation code

---

## Introduction to DOM Traversal

DOM traversal is the process of moving through the DOM tree to access different nodes based on their relationships.

### Why Traverse the DOM?

- **Find Related Elements**: Access parent, children, siblings
- **Navigate Structure**: Move through DOM tree
- **Efficient Access**: Direct navigation vs searching
- **Dynamic Operations**: Work with element relationships

---

## Parent Nodes

### parentNode

Get the parent node:

```javascript
let element = document.getElementById('child');
let parent = element.parentNode;
console.log(parent);
```

### parentElement

Get the parent element (excludes non-element nodes):

```javascript
let element = document.getElementById('child');
let parent = element.parentElement;
console.log(parent);
```

### Difference

```javascript
// parentNode: Returns any node type
let textNode = document.createTextNode('Hello');
let parent = textNode.parentNode;  // Could be element or document

// parentElement: Returns only element nodes
let parent = textNode.parentElement;  // null if parent is not element
```

### Closest()

Find closest ancestor matching selector:

```javascript
let element = document.getElementById('child');
let container = element.closest('.container');
let div = element.closest('div');
```

---

## Child Nodes

### childNodes

Get all child nodes (including text nodes):

```javascript
let container = document.getElementById('container');
let children = container.childNodes;
console.log(children.length);  // Includes text nodes
```

### children

Get only element children:

```javascript
let container = document.getElementById('container');
let children = container.children;
console.log(children.length);  // Only element nodes
```

### firstChild and lastChild

Get first and last child nodes:

```javascript
let container = document.getElementById('container');
let first = container.firstChild;  // May be text node
let last = container.lastChild;    // May be text node
```

### firstElementChild and lastElementChild

Get first and last element children:

```javascript
let container = document.getElementById('container');
let first = container.firstElementChild;  // First element
let last = container.lastElementChild;    // Last element
```

### hasChildNodes()

Check if element has children:

```javascript
let container = document.getElementById('container');
if (container.hasChildNodes()) {
    console.log('Has children');
}
```

---

## Sibling Nodes

### nextSibling and previousSibling

Get next/previous sibling nodes:

```javascript
let element = document.getElementById('middle');
let next = element.nextSibling;      // May be text node
let previous = element.previousSibling; // May be text node
```

### nextElementSibling and previousElementSibling

Get next/previous element siblings:

```javascript
let element = document.getElementById('middle');
let next = element.nextElementSibling;      // Next element
let previous = element.previousElementSibling; // Previous element
```

---

## Element vs Node Methods

### Node Methods (All Nodes)

- `parentNode`
- `childNodes`
- `firstChild` / `lastChild`
- `nextSibling` / `previousSibling`

### Element Methods (Elements Only)

- `parentElement`
- `children`
- `firstElementChild` / `lastElementChild`
- `nextElementSibling` / `previousElementSibling`

### When to Use Each

**Use Node methods when:**
- You need to work with all node types
- Text nodes are important
- Working with document structure

**Use Element methods when:**
- You only care about elements
- Text nodes are whitespace
- More convenient for most cases

---

## Practical Examples

### Example 1: Finding Parent Container

```javascript
function findContainer(element) {
    let current = element;
    
    while (current) {
        if (current.classList && current.classList.contains('container')) {
            return current;
        }
        current = current.parentElement;
    }
    
    return null;
}

// Or using closest()
function findContainer(element) {
    return element.closest('.container');
}
```

### Example 2: Getting All Siblings

```javascript
function getAllSiblings(element) {
    let siblings = [];
    let parent = element.parentElement;
    
    if (parent) {
        let children = parent.children;
        for (let child of children) {
            if (child !== element) {
                siblings.push(child);
            }
        }
    }
    
    return siblings;
}
```

### Example 3: Getting All Children

```javascript
function getAllChildren(element) {
    return Array.from(element.children);
}

// Or get all including text nodes
function getAllChildNodes(element) {
    return Array.from(element.childNodes);
}
```

### Example 4: Finding Next Element

```javascript
function findNextElement(element, selector) {
    let current = element.nextElementSibling;
    
    while (current) {
        if (current.matches(selector)) {
            return current;
        }
        current = current.nextElementSibling;
    }
    
    return null;
}
```

### Example 5: Walking the Tree

```javascript
function walkTree(element, callback) {
    callback(element);
    
    let children = element.children;
    for (let child of children) {
        walkTree(child, callback);
    }
}

// Usage
walkTree(document.body, (element) => {
    console.log(element.tagName);
});
```

---

## Advanced Traversal

### matches()

Check if element matches selector:

```javascript
let element = document.getElementById('myDiv');
if (element.matches('.container')) {
    console.log('Matches container class');
}
```

### contains()

Check if element contains another element:

```javascript
let container = document.getElementById('container');
let child = document.getElementById('child');

if (container.contains(child)) {
    console.log('Container contains child');
}
```

### compareDocumentPosition()

Compare positions of two nodes:

```javascript
let element1 = document.getElementById('elem1');
let element2 = document.getElementById('elem2');

let position = element1.compareDocumentPosition(element2);

if (position & Node.DOCUMENT_POSITION_FOLLOWING) {
    console.log('element2 follows element1');
}
```

---

## Practice Exercise

### Exercise: DOM Traversal

**Objective**: Practice navigating the DOM tree using traversal methods.

**Instructions**:

1. Create an HTML file with nested structure
2. Create a JavaScript file for traversal
3. Practice:
   - Navigating to parent nodes
   - Accessing child nodes
   - Finding sibling nodes
   - Using Element vs Node methods
   - Building traversal utilities

**Example Solution**:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOM Traversal Practice</title>
</head>
<body>
    <div id="container" class="container">
        <h1 id="title">My Page</h1>
        <div class="section">
            <p id="para1" class="text">First paragraph</p>
            <p id="para2" class="text">Second paragraph</p>
            <p id="para3" class="text">Third paragraph</p>
        </div>
        <ul id="list">
            <li class="item">Item 1</li>
            <li class="item" id="middleItem">Item 2</li>
            <li class="item">Item 3</li>
        </ul>
    </div>
    <script src="dom-traversal.js"></script>
</body>
</html>
```

```javascript
// dom-traversal.js
console.log("=== DOM Traversal Practice ===");

console.log("\n=== Parent Nodes ===");

let para1 = document.getElementById('para1');
console.log("Para1:", para1.textContent);

// parentNode
let parentNode = para1.parentNode;
console.log("Parent node:", parentNode.tagName);

// parentElement
let parentElement = para1.parentElement;
console.log("Parent element:", parentElement.tagName);

// closest()
let container = para1.closest('.container');
console.log("Closest container:", container.id);

let section = para1.closest('.section');
console.log("Closest section:", section.className);
console.log();

console.log("=== Child Nodes ===");

let container = document.getElementById('container');

// childNodes (includes text nodes)
console.log("Child nodes count:", container.childNodes.length);

// children (only elements)
console.log("Children count:", container.children.length);

// firstChild vs firstElementChild
console.log("First child node:", container.firstChild.nodeType);
console.log("First element child:", container.firstElementChild.tagName);

// lastChild vs lastElementChild
console.log("Last child node:", container.lastChild.nodeType);
console.log("Last element child:", container.lastElementChild.tagName);

// hasChildNodes()
console.log("Has child nodes:", container.hasChildNodes());
console.log();

console.log("=== Sibling Nodes ===");

let para2 = document.getElementById('para2');
console.log("Para2:", para2.textContent);

// nextSibling vs nextElementSibling
let nextSibling = para2.nextSibling;
console.log("Next sibling node type:", nextSibling ? nextSibling.nodeType : "null");
let nextElement = para2.nextElementSibling;
console.log("Next element sibling:", nextElement ? nextElement.id : "null");

// previousSibling vs previousElementSibling
let prevSibling = para2.previousSibling;
console.log("Previous sibling node type:", prevSibling ? prevSibling.nodeType : "null");
let prevElement = para2.previousElementSibling;
console.log("Previous element sibling:", prevElement ? prevElement.id : "null");
console.log();

console.log("=== Node vs Element Methods ===");

let list = document.getElementById('list');

console.log("Using Node methods:");
console.log("childNodes length:", list.childNodes.length);
console.log("firstChild:", list.firstChild.nodeType === Node.TEXT_NODE ? "Text node" : "Element");

console.log("\nUsing Element methods:");
console.log("children length:", list.children.length);
console.log("firstElementChild:", list.firstElementChild.tagName);
console.log();

console.log("=== Finding Parent Container ===");

function findContainer(element) {
    return element.closest('.container');
}

let item = document.getElementById('middleItem');
let foundContainer = findContainer(item);
console.log("Container found:", foundContainer ? foundContainer.id : "null");
console.log();

console.log("=== Getting All Siblings ===");

function getAllSiblings(element) {
    let siblings = [];
    let parent = element.parentElement;
    
    if (parent) {
        let children = parent.children;
        for (let child of children) {
            if (child !== element) {
                siblings.push(child);
            }
        }
    }
    
    return siblings;
}

let middleItem = document.getElementById('middleItem');
let siblings = getAllSiblings(middleItem);
console.log("Siblings of middleItem:", siblings.length);
siblings.forEach((sibling, index) => {
    console.log(`Sibling ${index + 1}:`, sibling.textContent);
});
console.log();

console.log("=== Getting All Children ===");

function getAllChildren(element) {
    return Array.from(element.children);
}

let section = document.querySelector('.section');
let children = getAllChildren(section);
console.log("Children of section:", children.length);
children.forEach((child, index) => {
    console.log(`Child ${index + 1}:`, child.tagName, "-", child.textContent);
});
console.log();

console.log("=== Finding Next Element ===");

function findNextElement(element, selector) {
    let current = element.nextElementSibling;
    
    while (current) {
        if (current.matches(selector)) {
            return current;
        }
        current = current.nextElementSibling;
    }
    
    return null;
}

let para1 = document.getElementById('para1');
let nextText = findNextElement(para1, '.text');
console.log("Next text element after para1:", nextText ? nextText.id : "null");
console.log();

console.log("=== Walking the Tree ===");

function walkTree(element, callback, depth = 0) {
    callback(element, depth);
    
    let children = element.children;
    for (let child of children) {
        walkTree(child, callback, depth + 1);
    }
}

console.log("Tree structure:");
walkTree(document.getElementById('container'), (element, depth) => {
    let indent = '  '.repeat(depth);
    console.log(`${indent}${element.tagName}${element.id ? '#' + element.id : ''}${element.className ? '.' + element.className : ''}`);
});
console.log();

console.log("=== matches() Method ===");

let element = document.getElementById('para1');
console.log("Para1 matches .text:", element.matches('.text'));
console.log("Para1 matches p:", element.matches('p'));
console.log("Para1 matches #para1:", element.matches('#para1'));
console.log();

console.log("=== contains() Method ===");

let container = document.getElementById('container');
let para1 = document.getElementById('para1');
let title = document.getElementById('title');

console.log("Container contains para1:", container.contains(para1));
console.log("Container contains title:", container.contains(title));
console.log("Para1 contains container:", para1.contains(container));
console.log();

console.log("=== Navigation Utilities ===");

// Get all ancestors
function getAllAncestors(element) {
    let ancestors = [];
    let current = element.parentElement;
    
    while (current) {
        ancestors.push(current);
        current = current.parentElement;
    }
    
    return ancestors;
}

let item = document.getElementById('middleItem');
let ancestors = getAllAncestors(item);
console.log("Ancestors of middleItem:");
ancestors.forEach((ancestor, index) => {
    console.log(`  Level ${index + 1}:`, ancestor.tagName, ancestor.id || ancestor.className || '');
});
console.log();

// Get all descendants
function getAllDescendants(element) {
    let descendants = [];
    let children = element.children;
    
    for (let child of children) {
        descendants.push(child);
        descendants.push(...getAllDescendants(child));
    }
    
    return descendants;
}

let container = document.getElementById('container');
let descendants = getAllDescendants(container);
console.log("Descendants of container:", descendants.length);
descendants.forEach((desc, index) => {
    console.log(`  ${index + 1}.`, desc.tagName, desc.id || desc.className || '');
});
```

**Expected Output** (in browser console):
```
=== DOM Traversal Practice ===

=== Parent Nodes ===
Para1: First paragraph
Parent node: DIV
Parent element: DIV
Closest container: container
Closest section: section

=== Child Nodes ===
Child nodes count: [number including text nodes]
Children count: [number of elements only]
First child node: 3 (text node)
First element child: H1
Last child node: 3 (text node)
Last element child: UL
Has child nodes: true

=== Sibling Nodes ===
Para2: Second paragraph
Next sibling node type: 3 (text node)
Next element sibling: para3
Previous sibling node type: 3 (text node)
Previous element sibling: para1

=== Node vs Element Methods ===
Using Node methods:
childNodes length: [number]
firstChild: Text node

Using Element methods:
children length: 3
firstElementChild: LI

=== Finding Parent Container ===
Container found: container

=== Getting All Siblings ===
Siblings of middleItem: 2
Sibling 1: Item 1
Sibling 2: Item 3

=== Getting All Children ===
Children of section: 3
Child 1: P - First paragraph
Child 2: P - Second paragraph
Child 3: P - Third paragraph

=== Finding Next Element ===
Next text element after para1: para2

=== Walking the Tree ===
Tree structure:
DIV#container.container
  H1#title
  DIV.section
    P#para1.text
    P#para2.text
    P#para3.text
  UL#list
    LI.item
    LI#middleItem.item
    LI.item

=== matches() Method ===
Para1 matches .text: true
Para1 matches p: true
Para1 matches #para1: true

=== contains() Method ===
Container contains para1: true
Container contains title: true
Para1 contains container: false

=== Navigation Utilities ===
Ancestors of middleItem:
  Level 1: UL list
  Level 2: DIV container

Descendants of container: [number]
  1. H1 title
  2. DIV section
  3. P para1
  4. P para2
  5. P para3
  6. UL list
  7. LI item
  8. LI middleItem
  9. LI item
```

**Challenge (Optional)**:
- Build a DOM tree visualizer
- Create navigation utilities
- Build a breadcrumb generator
- Create element finder utilities

---

## Common Mistakes

### 1. Confusing Node and Element Methods

```javascript
// ⚠️ Problem: firstChild might be text node
let first = container.firstChild;
first.classList.add('active');  // Error if text node

// ✅ Solution: Use firstElementChild
let first = container.firstElementChild;
first.classList.add('active');
```

### 2. Not Checking for null

```javascript
// ⚠️ Problem: Sibling might not exist
let next = element.nextElementSibling;
next.classList.add('active');  // Error if null

// ✅ Solution: Always check
let next = element.nextElementSibling;
if (next) {
    next.classList.add('active');
}
```

### 3. Forgetting Text Nodes

```javascript
// ⚠️ Problem: childNodes includes text nodes
let children = container.childNodes;
children.forEach(child => {
    child.classList.add('active');  // Error for text nodes
});

// ✅ Solution: Use children or check node type
let children = container.children;
children.forEach(child => {
    child.classList.add('active');
});
```

### 4. Infinite Loops in Traversal

```javascript
// ⚠️ Problem: Circular reference
function traverse(element) {
    // No base case
    traverse(element.parentElement);  // Infinite loop
}

// ✅ Solution: Add base case
function traverse(element) {
    if (!element) return;  // Base case
    console.log(element);
    traverse(element.parentElement);
}
```

---

## Key Takeaways

1. **Parent Nodes**: parentNode, parentElement, closest()
2. **Child Nodes**: childNodes, children, firstChild, lastChild
3. **Sibling Nodes**: nextSibling, previousSibling, nextElementSibling, previousElementSibling
4. **Node Methods**: Work with all node types
5. **Element Methods**: Work only with elements (usually preferred)
6. **matches()**: Check if element matches selector
7. **contains()**: Check if element contains another
8. **Best Practice**: Use Element methods for most cases, check for null

---

## Quiz: DOM Traversal

Test your understanding with these questions:

1. **parentNode returns:**
   - A) Only elements
   - B) Any node type
   - C) Only text nodes
   - D) Nothing

2. **children returns:**
   - A) All nodes
   - B) Only elements
   - C) Only text nodes
   - D) Attributes

3. **nextElementSibling:**
   - A) Next node (any type)
   - B) Next element
   - C) Previous element
   - D) Parent element

4. **firstChild might be:**
   - A) Element only
   - B) Text node
   - C) Both A and B
   - D) Neither

5. **closest() finds:**
   - A) Child element
   - B) Ancestor element
   - C) Sibling element
   - D) Any element

6. **Element methods work with:**
   - A) All nodes
   - B) Elements only
   - C) Text nodes only
   - D) Attributes only

7. **contains() checks:**
   - A) If element contains another
   - B) If element is contained
   - C) If elements are siblings
   - D) If elements match

**Answers**:
1. B) Any node type
2. B) Only elements
3. B) Next element
4. C) Both A and B (could be text or element)
5. B) Ancestor element
6. B) Elements only
7. A) If element contains another

---

## Next Steps

Congratulations! You've completed Module 13: Document Object Model (DOM). You now know:
- How to access DOM elements
- How to manipulate the DOM
- How to traverse the DOM tree
- Complete DOM operations

**What's Next?**
- Module 14: Events
- Lesson 14.1: Event Basics
- Learn to handle user interactions
- Build interactive web applications

---

## Additional Resources

- **MDN: Node**: [developer.mozilla.org/en-US/docs/Web/API/Node](https://developer.mozilla.org/en-US/docs/Web/API/Node)
- **MDN: Element**: [developer.mozilla.org/en-US/docs/Web/API/Element](https://developer.mozilla.org/en-US/docs/Web/API/Element)
- **JavaScript.info: DOM Navigation**: [javascript.info/dom-navigation](https://javascript.info/dom-navigation)

---

*Lesson completed! You've finished Module 13: Document Object Model (DOM). Ready for Module 14: Events!*

