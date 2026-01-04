# Lesson 21.1: Performance Basics

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand performance concepts
- Measure performance metrics
- Use profiling tools
- Identify performance bottlenecks
- Analyze performance data
- Optimize based on metrics
- Build faster applications

---

## Introduction to Performance

Performance optimization is crucial for creating fast, responsive applications that provide a great user experience.

### Why Performance Matters?

- **User Experience**: Faster applications feel better
- **SEO**: Search engines favor fast sites
- **Conversion**: Faster sites convert better
- **Mobile**: Important for mobile users
- **Competitive**: Better than competitors
- **Professional**: Shows attention to detail

---

## Understanding Performance

### What is Performance?

Performance refers to how quickly and efficiently an application runs.

### Key Performance Areas

1. **Load Time**: How fast page loads
2. **Runtime Performance**: How fast code executes
3. **Memory Usage**: How much memory is used
4. **Network**: How fast data transfers
5. **Rendering**: How fast UI updates

### Performance Goals

```javascript
// Target metrics:
// - First Contentful Paint (FCP): < 1.8s
// - Largest Contentful Paint (LCP): < 2.5s
// - Time to Interactive (TTI): < 3.8s
// - Total Blocking Time (TBT): < 200ms
// - Cumulative Layout Shift (CLS): < 0.1
```

---

## Performance Metrics

### Web Vitals

```javascript
// Core Web Vitals
// 1. Largest Contentful Paint (LCP)
//    - Measures loading performance
//    - Target: < 2.5s

// 2. First Input Delay (FID)
//    - Measures interactivity
//    - Target: < 100ms

// 3. Cumulative Layout Shift (CLS)
//    - Measures visual stability
//    - Target: < 0.1
```

### Measuring Performance

```javascript
// Performance API
let startTime = performance.now();

// ... code to measure ...

let endTime = performance.now();
let duration = endTime - startTime;
console.log(`Execution took ${duration}ms`);

// Performance marks
performance.mark('start');
// ... code ...
performance.mark('end');
performance.measure('duration', 'start', 'end');
let measure = performance.getEntriesByName('duration')[0];
console.log(`Duration: ${measure.duration}ms`);
```

### Navigation Timing

```javascript
// Navigation timing
let timing = performance.timing;

let metrics = {
    // DNS lookup
    dns: timing.domainLookupEnd - timing.domainLookupStart,
    
    // Connection
    connection: timing.connectEnd - timing.connectStart,
    
    // Request
    request: timing.responseStart - timing.requestStart,
    
    // Response
    response: timing.responseEnd - timing.responseStart,
    
    // DOM processing
    domProcessing: timing.domComplete - timing.domLoading,
    
    // Page load
    pageLoad: timing.loadEventEnd - timing.navigationStart
};

console.log('Performance metrics:', metrics);
```

### Resource Timing

```javascript
// Resource timing
let resources = performance.getEntriesByType('resource');

resources.forEach(resource => {
    console.log(`${resource.name}:`);
    console.log(`  Duration: ${resource.duration}ms`);
    console.log(`  Size: ${resource.transferSize} bytes`);
    console.log(`  Type: ${resource.initiatorType}`);
});
```

---

## Profiling Tools

### Chrome DevTools Performance Panel

```javascript
// Using Performance panel:
// 1. Open DevTools → Performance
// 2. Click Record
// 3. Perform actions
// 4. Stop recording
// 5. Analyze timeline

// Shows:
// - FPS (frames per second)
// - CPU usage
// - Memory usage
// - Function call stack
// - Long tasks
// - Layout shifts
```

### Chrome DevTools Memory Panel

```javascript
// Using Memory panel:
// 1. Open DevTools → Memory
// 2. Take heap snapshot
// 3. Perform actions
// 4. Take another snapshot
// 5. Compare snapshots

// Helps find:
// - Memory leaks
// - Large objects
// - Retained objects
// - Object sizes
```

### Lighthouse

```javascript
// Lighthouse (built into Chrome):
// 1. Open DevTools → Lighthouse
// 2. Select categories
// 3. Click Analyze
// 4. View report

// Measures:
// - Performance score
// - Accessibility
// - Best practices
// - SEO
// - PWA

// Provides:
// - Metrics
// - Opportunities
// - Diagnostics
// - Recommendations
```

### Performance Observer API

```javascript
// Performance Observer
let observer = new PerformanceObserver((list) => {
    for (let entry of list.getEntries()) {
        console.log('Performance entry:', entry);
    }
});

// Observe different types
observer.observe({ entryTypes: ['measure', 'navigation', 'resource'] });

// Measure custom performance
performance.mark('custom-start');
// ... code ...
performance.mark('custom-end');
performance.measure('custom', 'custom-start', 'custom-end');
```

---

## Performance Bottlenecks

### Common Bottlenecks

```javascript
// 1. Inefficient loops
// ❌ Bad: O(n²)
function findDuplicates(arr) {
    let duplicates = [];
    for (let i = 0; i < arr.length; i++) {
        for (let j = i + 1; j < arr.length; j++) {
            if (arr[i] === arr[j]) {
                duplicates.push(arr[i]);
            }
        }
    }
    return duplicates;
}

// ✅ Good: O(n)
function findDuplicates(arr) {
    let seen = new Set();
    let duplicates = [];
    for (let item of arr) {
        if (seen.has(item)) {
            duplicates.push(item);
        } else {
            seen.add(item);
        }
    }
    return duplicates;
}
```

### DOM Manipulation

```javascript
// ❌ Bad: Multiple DOM updates
for (let i = 0; i < 1000; i++) {
    document.body.appendChild(document.createElement('div'));
}

// ✅ Good: Batch DOM updates
let fragment = document.createDocumentFragment();
for (let i = 0; i < 1000; i++) {
    fragment.appendChild(document.createElement('div'));
}
document.body.appendChild(fragment);
```

### Memory Leaks

```javascript
// ❌ Bad: Memory leak
let data = [];
function addData() {
    for (let i = 0; i < 10000; i++) {
        data.push(new Array(1000).fill(0));
    }
}
// data never cleared

// ✅ Good: Clean up
let data = [];
function addData() {
    for (let i = 0; i < 10000; i++) {
        data.push(new Array(1000).fill(0));
    }
}
function clearData() {
    data = [];
}
```

### Unnecessary Re-renders

```javascript
// ❌ Bad: Re-render on every change
function updateUI(data) {
    document.getElementById('output').innerHTML = '';
    data.forEach(item => {
        let div = document.createElement('div');
        div.textContent = item;
        document.getElementById('output').appendChild(div);
    });
}

// ✅ Good: Update only changed items
function updateUI(data, previousData = []) {
    let output = document.getElementById('output');
    data.forEach((item, index) => {
        if (item !== previousData[index]) {
            if (output.children[index]) {
                output.children[index].textContent = item;
            } else {
                let div = document.createElement('div');
                div.textContent = item;
                output.appendChild(div);
            }
        }
    });
}
```

---

## Analyzing Performance

### Identifying Slow Code

```javascript
// Use console.time() to measure
console.time('operation');
// ... code ...
console.timeEnd('operation');

// Use performance.now()
let start = performance.now();
// ... code ...
let end = performance.now();
console.log(`Took ${end - start}ms`);

// Use performance marks
performance.mark('start');
// ... code ...
performance.mark('end');
performance.measure('duration', 'start', 'end');
let measure = performance.getEntriesByName('duration')[0];
console.log(`Duration: ${measure.duration}ms`);
```

### Profiling Functions

```javascript
// Profile function calls
function profileFunction(fn, ...args) {
    let start = performance.now();
    let result = fn(...args);
    let end = performance.now();
    console.log(`${fn.name} took ${end - start}ms`);
    return result;
}

function slowFunction(n) {
    let sum = 0;
    for (let i = 0; i < n * 1000000; i++) {
        sum += i;
    }
    return sum;
}

profileFunction(slowFunction, 10);
```

### Memory Profiling

```javascript
// Check memory usage
function getMemoryUsage() {
    if (performance.memory) {
        return {
            used: (performance.memory.usedJSHeapSize / 1048576).toFixed(2) + ' MB',
            total: (performance.memory.totalJSHeapSize / 1048576).toFixed(2) + ' MB',
            limit: (performance.memory.jsHeapSizeLimit / 1048576).toFixed(2) + ' MB'
        };
    }
    return null;
}

console.log('Memory usage:', getMemoryUsage());
```

---

## Practice Exercise

### Exercise: Performance Analysis

**Objective**: Practice measuring performance, using profiling tools, and identifying bottlenecks.

**Instructions**:

1. Create a JavaScript file with various operations
2. Use performance measurement tools
3. Practice:
   - Measuring execution time
   - Using performance marks
   - Analyzing bottlenecks
   - Profiling code

**Example Solution**:

```javascript
// performance-analysis-practice.js
console.log("=== Performance Analysis Practice ===");

console.log("\n=== Performance Measurement ===");

// Basic timing
console.time('basic-operation');
let sum = 0;
for (let i = 0; i < 1000000; i++) {
    sum += i;
}
console.timeEnd('basic-operation');

// Performance.now()
let start = performance.now();
let result = 0;
for (let i = 0; i < 1000000; i++) {
    result += Math.sqrt(i);
}
let end = performance.now();
console.log(`Math.sqrt loop took ${(end - start).toFixed(2)}ms`);

// Performance marks
performance.mark('mark-start');
let data = [];
for (let i = 0; i < 10000; i++) {
    data.push(i * 2);
}
performance.mark('mark-end');
performance.measure('data-creation', 'mark-start', 'mark-end');
let measure = performance.getEntriesByName('data-creation')[0];
console.log(`Data creation took ${measure.duration.toFixed(2)}ms`);
console.log();

console.log("=== Navigation Timing ===");

function getNavigationTiming() {
    let timing = performance.timing;
    
    return {
        dns: timing.domainLookupEnd - timing.domainLookupStart,
        connection: timing.connectEnd - timing.connectStart,
        request: timing.responseStart - timing.requestStart,
        response: timing.responseEnd - timing.responseStart,
        domProcessing: timing.domComplete - timing.domLoading,
        pageLoad: timing.loadEventEnd - timing.navigationStart
    };
}

console.log('Navigation timing:', getNavigationTiming());
console.log();

console.log("=== Resource Timing ===");

function getResourceTiming() {
    let resources = performance.getEntriesByType('resource');
    
    return resources.map(resource => ({
        name: resource.name,
        duration: resource.duration.toFixed(2) + 'ms',
        size: resource.transferSize + ' bytes',
        type: resource.initiatorType
    }));
}

console.log('Resource timing:', getResourceTiming());
console.log();

console.log("=== Performance Bottlenecks ===");

// Inefficient loop
console.time('inefficient-loop');
function inefficientFind(arr, target) {
    for (let i = 0; i < arr.length; i++) {
        for (let j = 0; j < arr.length; j++) {
            if (arr[i] + arr[j] === target) {
                return [i, j];
            }
        }
    }
    return null;
}
let arr1 = Array.from({ length: 100 }, (_, i) => i);
inefficientFind(arr1, 50);
console.timeEnd('inefficient-loop');

// Efficient loop
console.time('efficient-loop');
function efficientFind(arr, target) {
    let map = new Map();
    for (let i = 0; i < arr.length; i++) {
        let complement = target - arr[i];
        if (map.has(complement)) {
            return [map.get(complement), i];
        }
        map.set(arr[i], i);
    }
    return null;
}
let arr2 = Array.from({ length: 100 }, (_, i) => i);
efficientFind(arr2, 50);
console.timeEnd('efficient-loop');
console.log();

console.log("=== DOM Performance ===");

// Slow DOM manipulation
console.time('slow-dom');
let container1 = document.createElement('div');
for (let i = 0; i < 1000; i++) {
    let div = document.createElement('div');
    div.textContent = `Item ${i}`;
    container1.appendChild(div);
}
console.timeEnd('slow-dom');

// Fast DOM manipulation
console.time('fast-dom');
let container2 = document.createElement('div');
let fragment = document.createDocumentFragment();
for (let i = 0; i < 1000; i++) {
    let div = document.createElement('div');
    div.textContent = `Item ${i}`;
    fragment.appendChild(div);
}
container2.appendChild(fragment);
console.timeEnd('fast-dom');
console.log();

console.log("=== Memory Usage ===");

function getMemoryUsage() {
    if (performance.memory) {
        return {
            used: (performance.memory.usedJSHeapSize / 1048576).toFixed(2) + ' MB',
            total: (performance.memory.totalJSHeapSize / 1048576).toFixed(2) + ' MB',
            limit: (performance.memory.jsHeapSizeLimit / 1048576).toFixed(2) + ' MB'
        };
    }
    return 'Memory API not available';
}

console.log('Memory usage:', getMemoryUsage());

// Memory leak example
let memoryLeak = [];
function addToMemoryLeak() {
    for (let i = 0; i < 1000; i++) {
        memoryLeak.push(new Array(1000).fill(0));
    }
}

let memoryBefore = getMemoryUsage();
addToMemoryLeak();
let memoryAfter = getMemoryUsage();
console.log('Memory before:', memoryBefore);
console.log('Memory after:', memoryAfter);
console.log();

console.log("=== Function Profiling ===");

function profileFunction(fn, ...args) {
    let start = performance.now();
    let result = fn(...args);
    let end = performance.now();
    console.log(`${fn.name}(${args.join(', ')}) took ${(end - start).toFixed(2)}ms`);
    return result;
}

function slowCalculation(n) {
    let sum = 0;
    for (let i = 0; i < n * 100000; i++) {
        sum += Math.sqrt(i);
    }
    return sum;
}

function fastCalculation(n) {
    return n * (n + 1) / 2;
}

profileFunction(slowCalculation, 10);
profileFunction(fastCalculation, 10);
console.log();

console.log("=== Performance Observer ===");

let observer = new PerformanceObserver((list) => {
    for (let entry of list.getEntries()) {
        console.log('Performance entry:', {
            name: entry.name,
            type: entry.entryType,
            duration: entry.duration ? entry.duration.toFixed(2) + 'ms' : 'N/A'
        });
    }
});

observer.observe({ entryTypes: ['measure', 'mark'] });

// Create some performance entries
performance.mark('observer-start');
let sum = 0;
for (let i = 0; i < 100000; i++) {
    sum += i;
}
performance.mark('observer-end');
performance.measure('observer-duration', 'observer-start', 'observer-end');
console.log();

console.log("=== Web Vitals (Conceptual) ===");
console.log('Core Web Vitals:');
console.log('  - LCP (Largest Contentful Paint): < 2.5s');
console.log('  - FID (First Input Delay): < 100ms');
console.log('  - CLS (Cumulative Layout Shift): < 0.1');
console.log();
console.log('Use Lighthouse in Chrome DevTools to measure Web Vitals');
console.log('Open DevTools → Lighthouse → Analyze');
```

**Expected Output**:
```
=== Performance Analysis Practice ===

=== Performance Measurement ===
basic-operation: [time]ms
Math.sqrt loop took [time]ms
Data creation took [time]ms

=== Navigation Timing ===
Navigation timing: { object }

=== Resource Timing ===
Resource timing: [array]

=== Performance Bottlenecks ===
inefficient-loop: [time]ms
efficient-loop: [time]ms

=== DOM Performance ===
slow-dom: [time]ms
fast-dom: [time]ms

=== Memory Usage ===
Memory usage: { object }
Memory before: { object }
Memory after: { object }

=== Function Profiling ===
slowCalculation(10) took [time]ms
fastCalculation(10) took [time]ms

=== Performance Observer ===
Performance entry: { object }

=== Web Vitals (Conceptual) ===
[Web Vitals info]
```

**Challenge (Optional)**:
- Profile a real application
- Identify and fix bottlenecks
- Measure before and after optimizations
- Use Lighthouse to analyze performance
- Practice all profiling techniques

---

## Common Mistakes

### 1. Not Measuring Before Optimizing

```javascript
// ❌ Bad: Optimize without measuring
function optimize() {
    // Optimize blindly
}

// ✅ Good: Measure first
let before = performance.now();
// ... code ...
let after = performance.now();
console.log(`Took ${after - before}ms`);
// Then optimize based on data
```

### 2. Premature Optimization

```javascript
// ❌ Bad: Optimize too early
// Complex optimization for simple code

// ✅ Good: Optimize when needed
// Measure first, optimize bottlenecks
```

### 3. Ignoring Memory

```javascript
// ❌ Bad: Only measure speed
console.time('operation');
// ... code ...
console.timeEnd('operation');

// ✅ Good: Measure speed and memory
console.time('operation');
let memoryBefore = performance.memory.usedJSHeapSize;
// ... code ...
let memoryAfter = performance.memory.usedJSHeapSize;
console.timeEnd('operation');
console.log(`Memory used: ${(memoryAfter - memoryBefore) / 1048576}MB`);
```

---

## Key Takeaways

1. **Performance Metrics**: Measure load time, runtime, memory
2. **Web Vitals**: LCP, FID, CLS are key metrics
3. **Profiling Tools**: DevTools, Lighthouse, Performance API
4. **Bottlenecks**: Identify slow code, DOM operations, memory leaks
5. **Measurement**: Always measure before optimizing
6. **Analysis**: Use profiling data to guide optimization
7. **Best Practice**: Measure, identify, optimize, measure again

---

## Quiz: Performance Basics

Test your understanding with these questions:

1. **LCP target is:**
   - A) < 1.8s
   - B) < 2.5s
   - C) < 3.8s
   - D) < 5s

2. **performance.now() returns:**
   - A) Date
   - B) High-resolution timestamp
   - C) String
   - D) Nothing

3. **Lighthouse measures:**
   - A) Performance only
   - B) Multiple categories
   - C) Memory only
   - D) Nothing

4. **DocumentFragment helps:**
   - A) DOM performance
   - B) Memory
   - C) Network
   - D) Nothing

5. **Memory leaks:**
   - A) Objects not garbage collected
   - B) Fast code
   - C) Small objects
   - D) Nothing

6. **Performance Observer:**
   - A) Observes performance entries
   - B) Observes errors
   - C) Observes network
   - D) Nothing

7. **Measure before:**
   - A) Optimizing
   - B) Coding
   - C) Testing
   - D) Nothing

**Answers**:
1. B) < 2.5s
2. B) High-resolution timestamp
3. B) Multiple categories
4. A) DOM performance
5. A) Objects not garbage collected
6. A) Observes performance entries
7. A) Optimizing

---

## Next Steps

Congratulations! You've learned performance basics. You now know:
- How to measure performance
- Performance metrics and Web Vitals
- Profiling tools
- How to identify bottlenecks

**What's Next?**
- Lesson 21.2: Optimization Techniques
- Learn debouncing and throttling
- Understand lazy loading
- Work with code splitting

---

## Additional Resources

- **Web Vitals**: [web.dev/vitals](https://web.dev/vitals)
- **Chrome DevTools Performance**: [developer.chrome.com/docs/devtools/performance](https://developer.chrome.com/docs/devtools/performance)
- **MDN: Performance API**: [developer.mozilla.org/en-US/docs/Web/API/Performance](https://developer.mozilla.org/en-US/docs/Web/API/Performance)

---

*Lesson completed! You're ready to move on to the next lesson.*

