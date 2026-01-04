# Lesson 21.2: Optimization Techniques

## Learning Objectives

By the end of this lesson, you will be able to:
- Implement debouncing and throttling
- Use lazy loading for images and code
- Implement code splitting
- Manage memory effectively
- Optimize code performance
- Apply optimization techniques
- Build faster applications

---

## Introduction to Optimization Techniques

Optimization techniques help improve application performance by reducing unnecessary work and improving resource usage.

### Why Optimization?

- **Faster Load Times**: Load only what's needed
- **Better Runtime**: Reduce unnecessary operations
- **Lower Memory**: Efficient memory usage
- **Better UX**: Smoother interactions
- **Mobile Friendly**: Important for mobile devices
- **Cost Effective**: Lower server costs

---

## Debouncing and Throttling

### Debouncing

Debouncing delays function execution until after a pause in calls.

```javascript
// Basic debounce
function debounce(func, delay) {
    let timeoutId;
    return function(...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            func.apply(this, args);
        }, delay);
    };
}

// Usage: Search input
let searchInput = document.getElementById('search');
let debouncedSearch = debounce(function(query) {
    console.log('Searching for:', query);
    // Perform search
}, 300);

searchInput.addEventListener('input', function(e) {
    debouncedSearch(e.target.value);
});
```

### Throttling

Throttling limits function execution to at most once per time period.

```javascript
// Basic throttle
function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => {
                inThrottle = false;
            }, limit);
        }
    };
}

// Usage: Scroll event
let throttledScroll = throttle(function() {
    console.log('Scrolled');
    // Handle scroll
}, 100);

window.addEventListener('scroll', throttledScroll);
```

### Debounce vs Throttle

```javascript
// Debounce: Wait for pause
// - Search input
// - Resize events
// - Form validation

// Throttle: Limit execution rate
// - Scroll events
// - Mouse move
// - Window resize (sometimes)
```

---

## Lazy Loading

### Image Lazy Loading

```javascript
// Native lazy loading
<img src="image.jpg" loading="lazy" alt="Image">

// JavaScript lazy loading
function lazyLoadImages() {
    let images = document.querySelectorAll('img[data-src]');
    
    let imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                let img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

// Usage
<img data-src="image.jpg" alt="Image">
lazyLoadImages();
```

### Code Lazy Loading

```javascript
// Dynamic import (lazy load modules)
async function loadModule() {
    let module = await import('./heavy-module.js');
    module.doSomething();
}

// Lazy load on demand
button.addEventListener('click', async () => {
    let { heavyFunction } = await import('./heavy-module.js');
    heavyFunction();
});

// React lazy loading
const LazyComponent = React.lazy(() => import('./LazyComponent'));
```

### Component Lazy Loading

```javascript
// Lazy load components
function lazyLoadComponent(componentName) {
    return import(`./components/${componentName}.js`)
        .then(module => module.default)
        .catch(error => {
            console.error('Failed to load component:', error);
        });
}

// Usage
button.addEventListener('click', () => {
    lazyLoadComponent('HeavyComponent').then(Component => {
        // Render component
    });
});
```

---

## Code Splitting

### Dynamic Imports

```javascript
// Split code into chunks
// webpack.config.js
module.exports = {
    optimization: {
        splitChunks: {
            chunks: 'all',
            cacheGroups: {
                vendor: {
                    test: /[\\/]node_modules[\\/]/,
                    name: 'vendors',
                    chunks: 'all'
                }
            }
        }
    }
};

// Dynamic import
async function loadFeature() {
    let feature = await import('./feature.js');
    feature.init();
}
```

### Route-Based Splitting

```javascript
// Split by routes
const routes = {
    '/': () => import('./pages/Home.js'),
    '/about': () => import('./pages/About.js'),
    '/contact': () => import('./pages/Contact.js')
};

async function navigate(path) {
    let pageLoader = routes[path];
    if (pageLoader) {
        let Page = await pageLoader();
        render(Page);
    }
}
```

### Component-Based Splitting

```javascript
// Split by components
async function loadModal() {
    let Modal = await import('./Modal.js');
    return Modal.default;
}

// Load on demand
button.addEventListener('click', async () => {
    let Modal = await loadModal();
    showModal(Modal);
});
```

---

## Memory Management

### Avoiding Memory Leaks

```javascript
// ❌ Bad: Memory leak
let listeners = [];
function addListener() {
    let listener = () => console.log('clicked');
    document.addEventListener('click', listener);
    listeners.push(listener);
    // Never removed!
}

// ✅ Good: Clean up
let listeners = [];
function addListener() {
    let listener = () => console.log('clicked');
    document.addEventListener('click', listener);
    listeners.push(listener);
}

function removeListeners() {
    listeners.forEach(listener => {
        document.removeEventListener('click', listener);
    });
    listeners = [];
}
```

### WeakMap and WeakSet

```javascript
// WeakMap: Doesn't prevent garbage collection
let weakMap = new WeakMap();
let obj = { data: 'test' };
weakMap.set(obj, 'value');

// When obj is garbage collected, weakMap entry is removed
obj = null;

// WeakSet: Similar to WeakMap
let weakSet = new WeakSet();
weakSet.add(obj);
```

### Clearing References

```javascript
// Clear large objects
let largeData = new Array(1000000).fill(0);

// When done, clear reference
largeData = null;

// Clear intervals/timeouts
let intervalId = setInterval(() => {
    // ...
}, 1000);

// Clear when done
clearInterval(intervalId);
```

### Object Pooling

```javascript
// Reuse objects instead of creating new ones
class ObjectPool {
    constructor(createFn, resetFn) {
        this.createFn = createFn;
        this.resetFn = resetFn;
        this.pool = [];
    }
    
    acquire() {
        if (this.pool.length > 0) {
            return this.pool.pop();
        }
        return this.createFn();
    }
    
    release(obj) {
        this.resetFn(obj);
        this.pool.push(obj);
    }
}

// Usage
let pool = new ObjectPool(
    () => ({ x: 0, y: 0 }),
    obj => { obj.x = 0; obj.y = 0; }
);

let obj = pool.acquire();
// Use obj
pool.release(obj);
```

---

## Additional Optimization Techniques

### Caching

```javascript
// Function result caching
function memoize(fn) {
    let cache = new Map();
    return function(...args) {
        let key = JSON.stringify(args);
        if (cache.has(key)) {
            return cache.get(key);
        }
        let result = fn.apply(this, args);
        cache.set(key, result);
        return result;
    };
}

// Usage
let expensiveFunction = memoize(function(n) {
    // Expensive calculation
    let result = 0;
    for (let i = 0; i < n * 1000000; i++) {
        result += i;
    }
    return result;
});
```

### Virtual Scrolling

```javascript
// Only render visible items
function virtualScroll(items, containerHeight, itemHeight) {
    let visibleCount = Math.ceil(containerHeight / itemHeight);
    let scrollTop = container.scrollTop;
    let startIndex = Math.floor(scrollTop / itemHeight);
    let endIndex = startIndex + visibleCount;
    
    return items.slice(startIndex, endIndex);
}
```

### Request Batching

```javascript
// Batch multiple requests
class RequestBatcher {
    constructor(batchSize, delay) {
        this.batchSize = batchSize;
        this.delay = delay;
        this.queue = [];
        this.timeoutId = null;
    }
    
    add(request) {
        this.queue.push(request);
        
        if (this.queue.length >= this.batchSize) {
            this.flush();
        } else {
            this.scheduleFlush();
        }
    }
    
    scheduleFlush() {
        if (this.timeoutId) {
            clearTimeout(this.timeoutId);
        }
        this.timeoutId = setTimeout(() => {
            this.flush();
        }, this.delay);
    }
    
    flush() {
        if (this.queue.length === 0) return;
        
        let batch = this.queue.splice(0, this.batchSize);
        // Send batch request
        sendBatchRequest(batch);
        
        if (this.queue.length > 0) {
            this.scheduleFlush();
        }
    }
}
```

---

## Practice Exercise

### Exercise: Optimization

**Objective**: Practice implementing debouncing, throttling, lazy loading, and memory management.

**Instructions**:

1. Create a JavaScript file
2. Practice:
   - Implementing debounce and throttle
   - Lazy loading images
   - Code splitting
   - Memory management
   - Other optimization techniques

**Example Solution**:

```javascript
// optimization-practice.js
console.log("=== Optimization Techniques Practice ===");

console.log("\n=== Debouncing ===");

function debounce(func, delay) {
    let timeoutId;
    return function(...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            func.apply(this, args);
        }, delay);
    };
}

// Search example
let searchCount = 0;
function performSearch(query) {
    searchCount++;
    console.log(`Search ${searchCount} for: "${query}"`);
}

let debouncedSearch = debounce(performSearch, 300);

// Simulate typing
debouncedSearch('h');
debouncedSearch('he');
debouncedSearch('hel');
debouncedSearch('hell');
debouncedSearch('hello');
// Only one search executed after 300ms pause

// Resize example
let resizeCount = 0;
function handleResize() {
    resizeCount++;
    console.log(`Resize ${resizeCount}: ${window.innerWidth}x${window.innerHeight}`);
}

let debouncedResize = debounce(handleResize, 250);
// window.addEventListener('resize', debouncedResize);
console.log();

console.log("=== Throttling ===");

function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => {
                inThrottle = false;
            }, limit);
        }
    };
}

// Scroll example
let scrollCount = 0;
function handleScroll() {
    scrollCount++;
    console.log(`Scroll ${scrollCount}: ${window.scrollY}`);
}

let throttledScroll = throttle(handleScroll, 100);
// window.addEventListener('scroll', throttledScroll);

// Mouse move example
let moveCount = 0;
function handleMouseMove(event) {
    moveCount++;
    console.log(`Mouse move ${moveCount}: (${event.clientX}, ${event.clientY})`);
}

let throttledMouseMove = throttle(handleMouseMove, 200);
// element.addEventListener('mousemove', throttledMouseMove);
console.log();

console.log("=== Lazy Loading ===");

// Image lazy loading
function lazyLoadImages() {
    let images = document.querySelectorAll('img[data-src]');
    
    if ('IntersectionObserver' in window) {
        let imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    let img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    observer.unobserve(img);
                    console.log('Image loaded:', img.src);
                }
            });
        });
        
        images.forEach(img => imageObserver.observe(img));
    } else {
        // Fallback for older browsers
        images.forEach(img => {
            img.src = img.dataset.src;
        });
    }
}

// Code lazy loading
async function lazyLoadModule(modulePath) {
    try {
        let module = await import(modulePath);
        console.log('Module loaded:', modulePath);
        return module;
    } catch (error) {
        console.error('Failed to load module:', error);
        return null;
    }
}

// Usage example
// lazyLoadModule('./heavy-module.js').then(module => {
//     if (module) {
//         module.init();
//     }
// });
console.log();

console.log("=== Code Splitting ===");

// Dynamic import
async function loadFeature(featureName) {
    try {
        let feature = await import(`./features/${featureName}.js`);
        console.log(`Feature ${featureName} loaded`);
        return feature;
    } catch (error) {
        console.error(`Failed to load feature ${featureName}:`, error);
        return null;
    }
}

// Route-based splitting
const routes = {
    '/': () => import('./pages/Home.js'),
    '/about': () => import('./pages/About.js'),
    '/contact': () => import('./pages/Contact.js')
};

async function navigate(path) {
    let pageLoader = routes[path];
    if (pageLoader) {
        try {
            let Page = await pageLoader();
            console.log(`Page ${path} loaded`);
            return Page;
        } catch (error) {
            console.error(`Failed to load page ${path}:`, error);
            return null;
        }
    }
    return null;
}
console.log();

console.log("=== Memory Management ===");

// Avoiding memory leaks
class EventManager {
    constructor() {
        this.listeners = new Map();
    }
    
    add(element, event, handler) {
        if (!this.listeners.has(element)) {
            this.listeners.set(element, []);
        }
        element.addEventListener(event, handler);
        this.listeners.get(element).push({ event, handler });
    }
    
    remove(element, event, handler) {
        if (this.listeners.has(element)) {
            let handlers = this.listeners.get(element);
            let index = handlers.findIndex(h => h.event === event && h.handler === handler);
            if (index !== -1) {
                element.removeEventListener(event, handler);
                handlers.splice(index, 1);
            }
        }
    }
    
    removeAll(element) {
        if (this.listeners.has(element)) {
            let handlers = this.listeners.get(element);
            handlers.forEach(({ event, handler }) => {
                element.removeEventListener(event, handler);
            });
            this.listeners.delete(element);
        }
    }
}

let eventManager = new EventManager();
// Use eventManager to track and clean up listeners

// WeakMap for memory-efficient storage
let weakMap = new WeakMap();
function storeData(obj, data) {
    weakMap.set(obj, data);
}

let tempObj = { id: 1 };
storeData(tempObj, 'some data');
tempObj = null;  // Can be garbage collected

// Clearing large objects
function clearLargeData() {
    let largeArray = new Array(1000000).fill(0);
    // Use largeArray
    largeArray = null;  // Clear reference
    console.log('Large data cleared');
}

clearLargeData();
console.log();

console.log("=== Caching ===");

// Memoization
function memoize(fn) {
    let cache = new Map();
    return function(...args) {
        let key = JSON.stringify(args);
        if (cache.has(key)) {
            console.log('Cache hit');
            return cache.get(key);
        }
        console.log('Cache miss, calculating...');
        let result = fn.apply(this, args);
        cache.set(key, result);
        return result;
    };
}

function expensiveCalculation(n) {
    let result = 0;
    for (let i = 0; i < n * 100000; i++) {
        result += i;
    }
    return result;
}

let memoizedCalc = memoize(expensiveCalculation);
memoizedCalc(10);  // Calculates
memoizedCalc(10);  // Uses cache
console.log();

console.log("=== Object Pooling ===");

class ObjectPool {
    constructor(createFn, resetFn, maxSize = 10) {
        this.createFn = createFn;
        this.resetFn = resetFn;
        this.maxSize = maxSize;
        this.pool = [];
    }
    
    acquire() {
        if (this.pool.length > 0) {
            return this.pool.pop();
        }
        return this.createFn();
    }
    
    release(obj) {
        if (this.pool.length < this.maxSize) {
            this.resetFn(obj);
            this.pool.push(obj);
        }
    }
}

let pool = new ObjectPool(
    () => ({ x: 0, y: 0, active: false }),
    obj => {
        obj.x = 0;
        obj.y = 0;
        obj.active = false;
    }
);

let obj1 = pool.acquire();
obj1.x = 10;
obj1.y = 20;
pool.release(obj1);

let obj2 = pool.acquire();
console.log('Reused object:', obj2);  // Same object, reset
console.log();

console.log("=== Request Batching ===");

class RequestBatcher {
    constructor(batchSize = 5, delay = 100) {
        this.batchSize = batchSize;
        this.delay = delay;
        this.queue = [];
        this.timeoutId = null;
    }
    
    add(request) {
        this.queue.push(request);
        
        if (this.queue.length >= this.batchSize) {
            this.flush();
        } else {
            this.scheduleFlush();
        }
    }
    
    scheduleFlush() {
        if (this.timeoutId) {
            clearTimeout(this.timeoutId);
        }
        this.timeoutId = setTimeout(() => {
            this.flush();
        }, this.delay);
    }
    
    flush() {
        if (this.queue.length === 0) return;
        
        let batch = this.queue.splice(0, this.batchSize);
        console.log(`Sending batch of ${batch.length} requests:`, batch);
        // sendBatchRequest(batch);
        
        if (this.queue.length > 0) {
            this.scheduleFlush();
        }
    }
}

let batcher = new RequestBatcher(3, 200);
for (let i = 0; i < 10; i++) {
    batcher.add({ id: i, data: `request ${i}` });
}
console.log();

console.log("=== Virtual Scrolling (Concept) ===");

function virtualScroll(items, containerHeight, itemHeight, scrollTop) {
    let visibleCount = Math.ceil(containerHeight / itemHeight);
    let startIndex = Math.floor(scrollTop / itemHeight);
    let endIndex = Math.min(startIndex + visibleCount, items.length);
    
    return {
        visibleItems: items.slice(startIndex, endIndex),
        startIndex: startIndex,
        endIndex: endIndex,
        totalHeight: items.length * itemHeight
    };
}

let items = Array.from({ length: 1000 }, (_, i) => `Item ${i}`);
let result = virtualScroll(items, 400, 50, 0);
console.log(`Showing items ${result.startIndex}-${result.endIndex} of ${items.length}`);
console.log(`Visible items: ${result.visibleItems.length}`);
```

**Expected Output**:
```
=== Optimization Techniques Practice ===

=== Debouncing ===
[After 300ms pause]
Search 1 for: "hello"

=== Throttling ===
[Throttled events logged]

=== Lazy Loading ===
[Lazy loading functions defined]

=== Code Splitting ===
[Code splitting functions defined]

=== Memory Management ===
Large data cleared

=== Caching ===
Cache miss, calculating...
Cache hit

=== Object Pooling ===
Reused object: { x: 0, y: 0, active: false }

=== Request Batching ===
Sending batch of 3 requests: [array]
Sending batch of 3 requests: [array]
...

=== Virtual Scrolling (Concept) ===
Showing items 0-8 of 1000
Visible items: 8
```

**Challenge (Optional)**:
- Optimize a real application
- Implement all optimization techniques
- Measure performance improvements
- Build a performance-optimized app

---

## Common Mistakes

### 1. Over-Optimization

```javascript
// ❌ Bad: Optimize too early
// Complex optimization for simple code

// ✅ Good: Optimize when needed
// Measure first, optimize bottlenecks
```

### 2. Not Cleaning Up

```javascript
// ❌ Bad: Memory leak
let intervalId = setInterval(() => {
    // ...
}, 1000);
// Never cleared

// ✅ Good: Clean up
let intervalId = setInterval(() => {
    // ...
}, 1000);
// Later...
clearInterval(intervalId);
```

### 3. Wrong Debounce/Throttle

```javascript
// ❌ Bad: Wrong choice
// Using throttle for search input

// ✅ Good: Right choice
// Debounce for search, throttle for scroll
```

---

## Key Takeaways

1. **Debouncing**: Delay execution until pause
2. **Throttling**: Limit execution rate
3. **Lazy Loading**: Load on demand
4. **Code Splitting**: Split code into chunks
5. **Memory Management**: Avoid leaks, clean up
6. **Caching**: Cache expensive operations
7. **Best Practice**: Measure, optimize, measure again

---

## Quiz: Optimization

Test your understanding with these questions:

1. **Debouncing:**
   - A) Limits rate
   - B) Waits for pause
   - C) Both
   - D) Neither

2. **Throttling:**
   - A) Limits rate
   - B) Waits for pause
   - C) Both
   - D) Neither

3. **Lazy loading:**
   - A) Loads immediately
   - B) Loads on demand
   - C) Never loads
   - D) Random

4. **Code splitting:**
   - A) Splits into chunks
   - B) Combines code
   - C) Deletes code
   - D) Nothing

5. **WeakMap:**
   - A) Prevents GC
   - B) Allows GC
   - C) Both
   - D) Neither

6. **Memoization:**
   - A) Caches results
   - B) Deletes results
   - C) Modifies results
   - D) Nothing

7. **Object pooling:**
   - A) Reuses objects
   - B) Creates new objects
   - C) Deletes objects
   - D) Nothing

**Answers**:
1. B) Waits for pause
2. A) Limits rate
3. B) Loads on demand
4. A) Splits into chunks
5. B) Allows GC
6. A) Caches results
7. A) Reuses objects

---

## Next Steps

Congratulations! You've completed Module 21: Performance Optimization. You now know:
- Performance basics and metrics
- Profiling tools
- Optimization techniques
- Debouncing and throttling
- Lazy loading and code splitting
- Memory management

**What's Next?**
- Course 6: Testing and Tools
- Module 22: Testing
- Lesson 22.1: Testing Basics
- Learn why testing matters
- Understand test types

---

## Additional Resources

- **Web.dev Performance**: [web.dev/performance](https://web.dev/performance)
- **MDN: Performance**: [developer.mozilla.org/en-US/docs/Web/API/Performance](https://developer.mozilla.org/en-US/docs/Web/API/Performance)
- **Lazy Loading**: [web.dev/lazy-loading](https://web.dev/lazy-loading)

---

*Lesson completed! You've finished Module 21: Performance Optimization. Ready for Course 6: Testing and Tools!*

