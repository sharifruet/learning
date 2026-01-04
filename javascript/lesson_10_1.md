# Lesson 10.1: Iterators

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand the Iterator protocol
- Understand the Iterable protocol
- Use Symbol.iterator
- Create custom iterators
- Work with built-in iterables
- Use iterators with for...of loops
- Build iterator-based utilities

---

## Introduction to Iterators

Iterators provide a way to access elements of a collection sequentially. They're a fundamental part of JavaScript's iteration mechanism.

### What are Iterators?

An iterator is an object that provides a way to access elements one at a time. It implements the Iterator protocol.

### Why Iterators?

- **Unified Interface**: Same way to iterate over different data structures
- **Lazy Evaluation**: Generate values on demand
- **Memory Efficient**: Don't need to store all values
- **Custom Iteration**: Define how your objects are iterated

---

## Iterator Protocol

An object is an iterator if it implements a `next()` method that returns an object with:
- `value`: The current value
- `done`: Boolean indicating if iteration is complete

### Basic Iterator

```javascript
let iterator = {
    items: [1, 2, 3],
    index: 0,
    
    next() {
        if (this.index < this.items.length) {
            return {
                value: this.items[this.index++],
                done: false
            };
        } else {
            return { done: true };
        }
    }
};

console.log(iterator.next());  // { value: 1, done: false }
console.log(iterator.next());  // { value: 2, done: false }
console.log(iterator.next());  // { value: 3, done: false }
console.log(iterator.next());  // { done: true }
```

### Iterator Example

```javascript
function createIterator(array) {
    let index = 0;
    
    return {
        next() {
            if (index < array.length) {
                return {
                    value: array[index++],
                    done: false
                };
            } else {
                return { done: true };
            }
        }
    };
}

let iterator = createIterator([1, 2, 3]);
console.log(iterator.next());  // { value: 1, done: false }
console.log(iterator.next());  // { value: 2, done: false }
console.log(iterator.next());  // { value: 3, done: false }
console.log(iterator.next());  // { done: true }
```

---

## Iterable Protocol

An object is iterable if it implements the `Symbol.iterator` method that returns an iterator.

### Symbol.iterator

```javascript
let iterable = {
    items: [1, 2, 3],
    
    [Symbol.iterator]() {
        let index = 0;
        let items = this.items;
        
        return {
            next() {
                if (index < items.length) {
                    return {
                        value: items[index++],
                        done: false
                    };
                } else {
                    return { done: true };
                }
            }
        };
    }
};

// Can use with for...of
for (let item of iterable) {
    console.log(item);  // 1, 2, 3
}
```

### Built-in Iterables

Many built-in objects are iterable:

```javascript
// Arrays
let arr = [1, 2, 3];
for (let item of arr) {
    console.log(item);
}

// Strings
let str = "Hello";
for (let char of str) {
    console.log(char);  // H, e, l, l, o
}

// Maps
let map = new Map([["a", 1], ["b", 2]]);
for (let [key, value] of map) {
    console.log(key, value);
}

// Sets
let set = new Set([1, 2, 3]);
for (let item of set) {
    console.log(item);
}
```

---

## Custom Iterators

### Simple Custom Iterator

```javascript
let countdown = {
    start: 5,
    
    [Symbol.iterator]() {
        let current = this.start;
        
        return {
            next() {
                if (current > 0) {
                    return {
                        value: current--,
                        done: false
                    };
                } else {
                    return { done: true };
                }
            }
        };
    }
};

for (let num of countdown) {
    console.log(num);  // 5, 4, 3, 2, 1
}
```

### Range Iterator

```javascript
let range = {
    start: 1,
    end: 5,
    
    [Symbol.iterator]() {
        let current = this.start;
        let end = this.end;
        
        return {
            next() {
                if (current <= end) {
                    return {
                        value: current++,
                        done: false
                    };
                } else {
                    return { done: true };
                }
            }
        };
    }
};

for (let num of range) {
    console.log(num);  // 1, 2, 3, 4, 5
}
```

### Fibonacci Iterator

```javascript
let fibonacci = {
    [Symbol.iterator]() {
        let prev = 0;
        let curr = 1;
        
        return {
            next() {
                let value = curr;
                curr = prev + curr;
                prev = value;
                
                return {
                    value: value,
                    done: false
                };
            }
        };
    }
};

let count = 0;
for (let num of fibonacci) {
    console.log(num);
    if (++count >= 10) break;  // First 10 numbers
}
```

---

## Using Iterators

### for...of Loop

```javascript
let iterable = {
    [Symbol.iterator]() {
        let items = [1, 2, 3];
        let index = 0;
        
        return {
            next() {
                if (index < items.length) {
                    return { value: items[index++], done: false };
                }
                return { done: true };
            }
        };
    }
};

for (let item of iterable) {
    console.log(item);  // 1, 2, 3
}
```

### Spread Operator

```javascript
let iterable = {
    [Symbol.iterator]() {
        let items = [1, 2, 3];
        let index = 0;
        
        return {
            next() {
                if (index < items.length) {
                    return { value: items[index++], done: false };
                }
                return { done: true };
            }
        };
    }
};

let array = [...iterable];
console.log(array);  // [1, 2, 3]
```

### Array.from()

```javascript
let iterable = {
    [Symbol.iterator]() {
        let items = [1, 2, 3];
        let index = 0;
        
        return {
            next() {
                if (index < items.length) {
                    return { value: items[index++], done: false };
                }
                return { done: true };
            }
        };
    }
};

let array = Array.from(iterable);
console.log(array);  // [1, 2, 3]
```

### Destructuring

```javascript
let iterable = {
    [Symbol.iterator]() {
        let items = [1, 2, 3];
        let index = 0;
        
        return {
            next() {
                if (index < items.length) {
                    return { value: items[index++], done: false };
                }
                return { done: true };
            }
        };
    }
};

let [first, second, third] = iterable;
console.log(first, second, third);  // 1, 2, 3
```

---

## Advanced Iterator Patterns

### Iterator with Return Method

```javascript
let iterable = {
    [Symbol.iterator]() {
        let items = [1, 2, 3];
        let index = 0;
        
        return {
            next() {
                if (index < items.length) {
                    return { value: items[index++], done: false };
                }
                return { done: true };
            },
            return() {
                console.log("Iterator closed");
                return { done: true };
            }
        };
    }
};

for (let item of iterable) {
    console.log(item);
    if (item === 2) break;  // Triggers return()
}
```

### Infinite Iterator

```javascript
let infiniteCounter = {
    [Symbol.iterator]() {
        let count = 0;
        
        return {
            next() {
                return {
                    value: count++,
                    done: false
                };
            }
        };
    }
};

let count = 0;
for (let num of infiniteCounter) {
    console.log(num);
    if (++count >= 5) break;  // Must break manually
}
```

### Iterator with Parameters

```javascript
function createRangeIterator(start, end, step = 1) {
    return {
        [Symbol.iterator]() {
            let current = start;
            let endValue = end;
            let stepValue = step;
            
            return {
                next() {
                    if (current <= endValue) {
                        let value = current;
                        current += stepValue;
                        return { value, done: false };
                    }
                    return { done: true };
                }
            };
        }
    };
}

let range = createRangeIterator(0, 10, 2);
for (let num of range) {
    console.log(num);  // 0, 2, 4, 6, 8, 10
}
```

---

## Practical Examples

### Example 1: Object Iterator

```javascript
let person = {
    name: "Alice",
    age: 25,
    city: "New York",
    
    [Symbol.iterator]() {
        let keys = Object.keys(this);
        let index = 0;
        
        return {
            next() {
                if (index < keys.length) {
                    let key = keys[index++];
                    return {
                        value: [key, this[key]],
                        done: false
                    };
                }
                return { done: true };
            }
        };
    }
};

for (let [key, value] of person) {
    console.log(`${key}: ${value}`);
}
```

### Example 2: Tree Iterator

```javascript
let tree = {
    value: 1,
    children: [
        { value: 2, children: [] },
        {
            value: 3,
            children: [
                { value: 4, children: [] },
                { value: 5, children: [] }
            ]
        }
    ],
    
    [Symbol.iterator]() {
        let stack = [this];
        
        return {
            next() {
                if (stack.length === 0) {
                    return { done: true };
                }
                
                let node = stack.pop();
                stack.push(...node.children.reverse());
                
                return {
                    value: node.value,
                    done: false
                };
            }
        };
    }
};

for (let value of tree) {
    console.log(value);  // 1, 3, 5, 4, 2
}
```

### Example 3: Pagination Iterator

```javascript
function createPaginationIterator(items, pageSize) {
    return {
        [Symbol.iterator]() {
            let index = 0;
            let itemsArray = items;
            let size = pageSize;
            
            return {
                next() {
                    if (index < itemsArray.length) {
                        let page = itemsArray.slice(index, index + size);
                        index += size;
                        return {
                            value: page,
                            done: false
                        };
                    }
                    return { done: true };
                }
            };
        }
    };
}

let items = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
let pagination = createPaginationIterator(items, 3);

for (let page of pagination) {
    console.log("Page:", page);
}
// Page: [1, 2, 3]
// Page: [4, 5, 6]
// Page: [7, 8, 9]
// Page: [10]
```

---

## Practice Exercise

### Exercise: Creating Iterators

**Objective**: Practice creating custom iterators for various scenarios.

**Instructions**:

1. Create a file called `iterators-practice.js`

2. Create iterators for:
   - Range iterator
   - Countdown iterator
   - Object property iterator
   - Custom data structure iterator

3. Practice:
   - Using Symbol.iterator
   - Implementing next() method
   - Using with for...of
   - Using with spread operator

**Example Solution**:

```javascript
// Iterators Practice
console.log("=== Basic Iterator ===");

let basicIterator = {
    items: [1, 2, 3],
    index: 0,
    
    next() {
        if (this.index < this.items.length) {
            return {
                value: this.items[this.index++],
                done: false
            };
        } else {
            return { done: true };
        }
    }
};

console.log(basicIterator.next());  // { value: 1, done: false }
console.log(basicIterator.next());  // { value: 2, done: false }
console.log(basicIterator.next());  // { value: 3, done: false }
console.log(basicIterator.next());  // { done: true }
console.log();

console.log("=== Iterable with Symbol.iterator ===");

let iterable = {
    items: [1, 2, 3],
    
    [Symbol.iterator]() {
        let index = 0;
        let items = this.items;
        
        return {
            next() {
                if (index < items.length) {
                    return {
                        value: items[index++],
                        done: false
                    };
                } else {
                    return { done: true };
                }
            }
        };
    }
};

console.log("Using for...of:");
for (let item of iterable) {
    console.log(item);  // 1, 2, 3
}

console.log("Using spread:");
let array = [...iterable];
console.log(array);  // [1, 2, 3]

console.log("Using Array.from():");
let array2 = Array.from(iterable);
console.log(array2);  // [1, 2, 3]
console.log();

console.log("=== Range Iterator ===");

let range = {
    start: 1,
    end: 5,
    
    [Symbol.iterator]() {
        let current = this.start;
        let end = this.end;
        
        return {
            next() {
                if (current <= end) {
                    return {
                        value: current++,
                        done: false
                    };
                } else {
                    return { done: true };
                }
            }
        };
    }
};

for (let num of range) {
    console.log(num);  // 1, 2, 3, 4, 5
}
console.log();

console.log("=== Countdown Iterator ===");

let countdown = {
    start: 5,
    
    [Symbol.iterator]() {
        let current = this.start;
        
        return {
            next() {
                if (current > 0) {
                    return {
                        value: current--,
                        done: false
                    };
                } else {
                    return { done: true };
                }
            }
        };
    }
};

for (let num of countdown) {
    console.log(num);  // 5, 4, 3, 2, 1
}
console.log();

console.log("=== Fibonacci Iterator ===");

let fibonacci = {
    [Symbol.iterator]() {
        let prev = 0;
        let curr = 1;
        
        return {
            next() {
                let value = curr;
                curr = prev + curr;
                prev = value;
                
                return {
                    value: value,
                    done: false
                };
            }
        };
    }
};

let count = 0;
console.log("First 10 Fibonacci numbers:");
for (let num of fibonacci) {
    console.log(num);
    if (++count >= 10) break;
}
console.log();

console.log("=== Object Property Iterator ===");

let person = {
    name: "Alice",
    age: 25,
    city: "New York",
    
    [Symbol.iterator]() {
        let keys = Object.keys(this).filter(key => key !== Symbol.iterator);
        let index = 0;
        let self = this;
        
        return {
            next() {
                if (index < keys.length) {
                    let key = keys[index++];
                    return {
                        value: [key, self[key]],
                        done: false
                    };
                } else {
                    return { done: true };
                }
            }
        };
    }
};

for (let [key, value] of person) {
    console.log(`${key}: ${value}`);
}
console.log();

console.log("=== Infinite Iterator ===");

let infiniteCounter = {
    [Symbol.iterator]() {
        let count = 0;
        
        return {
            next() {
                return {
                    value: count++,
                    done: false
                };
            }
        };
    }
};

let counter = 0;
console.log("First 5 numbers from infinite iterator:");
for (let num of infiniteCounter) {
    console.log(num);
    if (++counter >= 5) break;
}
console.log();

console.log("=== Pagination Iterator ===");

function createPaginationIterator(items, pageSize) {
    return {
        [Symbol.iterator]() {
            let index = 0;
            let itemsArray = items;
            let size = pageSize;
            
            return {
                next() {
                    if (index < itemsArray.length) {
                        let page = itemsArray.slice(index, index + size);
                        index += size;
                        return {
                            value: page,
                            done: false
                        };
                    } else {
                        return { done: true };
                    }
                }
            };
        }
    };
}

let items = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
let pagination = createPaginationIterator(items, 3);

console.log("Pages:");
for (let page of pagination) {
    console.log("Page:", page);
}
console.log();

console.log("=== Iterator with Return Method ===");

let iterableWithReturn = {
    [Symbol.iterator]() {
        let items = [1, 2, 3, 4, 5];
        let index = 0;
        
        return {
            next() {
                if (index < items.length) {
                    return {
                        value: items[index++],
                        done: false
                    };
                } else {
                    return { done: true };
                }
            },
            return() {
                console.log("Iterator closed early");
                return { done: true };
            }
        };
    }
};

for (let item of iterableWithReturn) {
    console.log(item);
    if (item === 3) break;  // Triggers return()
}
```

**Expected Output**:
```
=== Basic Iterator ===
{ value: 1, done: false }
{ value: 2, done: false }
{ value: 3, done: false }
{ done: true }

=== Iterable with Symbol.iterator ===
Using for...of:
1
2
3
Using spread:
[ 1, 2, 3 ]
Using Array.from():
[ 1, 2, 3 ]

=== Range Iterator ===
1
2
3
4
5

=== Countdown Iterator ===
5
4
3
2
1

=== Fibonacci Iterator ===
First 10 Fibonacci numbers:
1
1
2
3
5
8
13
21
34
55

=== Object Property Iterator ===
name: Alice
age: 25
city: New York

=== Infinite Iterator ===
First 5 numbers from infinite iterator:
0
1
2
3
4

=== Pagination Iterator ===
Pages:
Page: [ 1, 2, 3 ]
Page: [ 4, 5, 6 ]
Page: [ 7, 8, 9 ]
Page: [ 10 ]

=== Iterator with Return Method ===
1
2
3
Iterator closed early
```

**Challenge (Optional)**:
- Build a tree traversal iterator
- Create a file line-by-line iterator
- Build a database result iterator
- Create a streaming data iterator

---

## Common Mistakes

### 1. Forgetting Symbol.iterator

```javascript
// ⚠️ Problem: Not iterable
let obj = {
    items: [1, 2, 3],
    next() { /* ... */ }
};

// for (let item of obj) { }  // Error: obj is not iterable

// ✅ Solution: Add Symbol.iterator
let obj = {
    items: [1, 2, 3],
    [Symbol.iterator]() {
        // Return iterator
    }
};
```

### 2. Not Returning Iterator Object

```javascript
// ⚠️ Problem: next() not in returned object
[Symbol.iterator]() {
    let index = 0;
    this.next = function() { /* ... */ };
    return this;  // Wrong
}

// ✅ Solution: Return object with next()
[Symbol.iterator]() {
    let index = 0;
    return {
        next() { /* ... */ }
    };
}
```

### 3. Mutating State Incorrectly

```javascript
// ⚠️ Problem: Shared state
[Symbol.iterator]() {
    this.index = 0;  // Shared across iterations
    return {
        next() {
            return { value: this.items[this.index++], done: false };
        }
    };
}

// ✅ Solution: Local state
[Symbol.iterator]() {
    let index = 0;  // Local to iterator
    let items = this.items;
    return {
        next() {
            return { value: items[index++], done: false };
        }
    };
}
```

---

## Key Takeaways

1. **Iterator Protocol**: Object with `next()` method returning `{value, done}`
2. **Iterable Protocol**: Object with `Symbol.iterator` method returning iterator
3. **Symbol.iterator**: Special symbol for making objects iterable
4. **for...of**: Works with iterables
5. **Spread/Destructuring**: Works with iterables
6. **Custom Iterators**: Define how your objects are iterated
7. **Lazy Evaluation**: Generate values on demand
8. **Best Practice**: Use iterators for custom iteration logic

---

## Quiz: Iterators

Test your understanding with these questions:

1. **Iterator protocol requires:**
   - A) next() method
   - B) value property
   - C) done property
   - D) All of the above

2. **Iterable protocol requires:**
   - A) next() method
   - B) Symbol.iterator method
   - C) value property
   - D) done property

3. **Symbol.iterator returns:**
   - A) Value
   - B) Iterator
   - C) Array
   - D) Object

4. **for...of works with:**
   - A) Iterators
   - B) Iterables
   - C) Arrays only
   - D) Objects only

5. **next() returns object with:**
   - A) value and done
   - B) value only
   - C) done only
   - D) Nothing

6. **Infinite iterators:**
   - A) Always error
   - B) Need manual break
   - C) Auto-stop
   - D) Not possible

7. **Spread operator works with:**
   - A) Iterables
   - B) Arrays only
   - C) Objects only
   - D) Nothing

**Answers**:
1. A) next() method (returns object with value and done)
2. B) Symbol.iterator method
3. B) Iterator
4. B) Iterables
5. A) value and done
6. B) Need manual break
7. A) Iterables

---

## Next Steps

Congratulations! You've learned iterators. You now know:
- Iterator and Iterable protocols
- How to create custom iterators
- How to use Symbol.iterator
- How iterators work with for...of

**What's Next?**
- Lesson 10.2: Generators
- Learn generator functions
- Understand yield keyword
- Build more advanced iteration patterns

---

## Additional Resources

- **MDN: Iteration Protocols**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Iteration_protocols](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Iteration_protocols)
- **MDN: Symbol.iterator**: [developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Symbol/iterator](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Symbol/iterator)
- **JavaScript.info: Iterables**: [javascript.info/iterable](https://javascript.info/iterable)

---

*Lesson completed! You're ready to move on to the next lesson.*

