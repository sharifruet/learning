# Lesson 16.3: Asynchronous Programming

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand async/await syntax
- Use the asyncio module
- Create and work with coroutines
- Understand event loops
- Handle asynchronous I/O operations
- Use async context managers
- Work with async generators
- Apply async patterns in real-world scenarios
- Debug async code
- Understand when to use async programming

---

## Introduction to Asynchronous Programming

**Asynchronous programming** allows you to write concurrent code that can handle multiple operations without blocking. Python's `asyncio` module provides support for asynchronous programming.

### Why Asynchronous Programming?

- **Non-blocking I/O**: Handle I/O operations without blocking
- **Concurrency**: Run multiple tasks concurrently
- **Efficiency**: Better resource utilization
- **Scalability**: Handle many connections efficiently
- **Modern approach**: Foundation for modern Python applications

### What is Asynchronous Programming?

Asynchronous programming allows code to start a task, move on to other tasks while waiting, and come back to the original task when it's ready.

---

## async/await Syntax

### Basic async Function

An `async` function is a coroutine function that returns a coroutine object:

```python
import asyncio

async def hello():
    print("Hello")
    await asyncio.sleep(1)
    print("World")

# Run the coroutine
asyncio.run(hello())
```

### Understanding async

The `async` keyword defines a coroutine function:

```python
async def my_function():
    return "Result"

# Calling async function returns a coroutine
coro = my_function()
print(type(coro))  # <class 'coroutine'>

# Must await or run with asyncio
result = asyncio.run(coro)
print(result)  # Result
```

### Understanding await

The `await` keyword pauses execution until the awaited coroutine completes:

```python
import asyncio

async def fetch_data():
    print("Fetching data...")
    await asyncio.sleep(2)  # Simulate I/O
    return "Data"

async def main():
    result = await fetch_data()
    print(f"Got: {result}")

asyncio.run(main())
```

### Multiple await Calls

```python
import asyncio

async def task1():
    await asyncio.sleep(1)
    return "Task 1"

async def task2():
    await asyncio.sleep(1)
    return "Task 2"

async def main():
    result1 = await task1()
    result2 = await task2()
    print(f"{result1}, {result2}")

asyncio.run(main())  # Takes 2 seconds (sequential)
```

### Concurrent Execution

```python
import asyncio

async def task1():
    await asyncio.sleep(1)
    return "Task 1"

async def task2():
    await asyncio.sleep(1)
    return "Task 2"

async def main():
    # Run concurrently
    result1, result2 = await asyncio.gather(task1(), task2())
    print(f"{result1}, {result2}")

asyncio.run(main())  # Takes 1 second (concurrent)
```

---

## asyncio Module

### Running Coroutines

The `asyncio.run()` function runs a coroutine:

```python
import asyncio

async def main():
    print("Hello")
    await asyncio.sleep(1)
    print("World")

asyncio.run(main())
```

### Creating Tasks

Tasks schedule coroutines to run concurrently:

```python
import asyncio

async def worker(name, delay):
    print(f"{name} starting")
    await asyncio.sleep(delay)
    print(f"{name} finished")
    return f"{name} result"

async def main():
    # Create tasks
    task1 = asyncio.create_task(worker("Worker1", 1))
    task2 = asyncio.create_task(worker("Worker2", 2))
    
    # Wait for tasks
    result1 = await task1
    result2 = await task2
    print(f"Results: {result1}, {result2}")

asyncio.run(main())
```

### asyncio.gather()

`gather()` runs multiple coroutines concurrently:

```python
import asyncio

async def task(name, delay):
    await asyncio.sleep(delay)
    return f"{name} completed"

async def main():
    results = await asyncio.gather(
        task("Task1", 1),
        task("Task2", 2),
        task("Task3", 1)
    )
    print(results)  # ['Task1 completed', 'Task2 completed', 'Task3 completed']

asyncio.run(main())  # Takes ~2 seconds (longest task)
```

### asyncio.wait()

`wait()` waits for tasks with different completion strategies:

```python
import asyncio

async def task(name, delay):
    await asyncio.sleep(delay)
    return f"{name} done"

async def main():
    tasks = [
        asyncio.create_task(task("Task1", 1)),
        asyncio.create_task(task("Task2", 2)),
        asyncio.create_task(task("Task3", 3))
    ]
    
    # Wait for first completed
    done, pending = await asyncio.wait(tasks, return_when=asyncio.FIRST_COMPLETED)
    print(f"Completed: {[t.result() for t in done]}")
    
    # Wait for remaining
    done, pending = await asyncio.wait(pending)
    print(f"All completed: {[t.result() for t in done]}")

asyncio.run(main())
```

### asyncio.sleep()

`asyncio.sleep()` is a non-blocking sleep:

```python
import asyncio

async def main():
    print("Start")
    await asyncio.sleep(1)  # Non-blocking
    print("End")

asyncio.run(main())
```

---

## Coroutines

### What are Coroutines?

Coroutines are functions that can be paused and resumed. They're created with `async def`:

```python
import asyncio

async def coroutine():
    print("Coroutine started")
    await asyncio.sleep(1)
    print("Coroutine finished")
    return "Result"

# Coroutine object
coro = coroutine()
print(type(coro))  # <class 'coroutine'>

# Run coroutine
result = asyncio.run(coro)
print(result)  # Result
```

### Coroutine Execution

```python
import asyncio

async def coroutine():
    print("Step 1")
    await asyncio.sleep(0.5)
    print("Step 2")
    await asyncio.sleep(0.5)
    print("Step 3")
    return "Done"

asyncio.run(coroutine())
```

### Chaining Coroutines

```python
import asyncio

async def step1():
    await asyncio.sleep(1)
    return "Step 1"

async def step2(data):
    await asyncio.sleep(1)
    return f"{data} -> Step 2"

async def step3(data):
    await asyncio.sleep(1)
    return f"{data} -> Step 3"

async def main():
    result1 = await step1()
    result2 = await step2(result1)
    result3 = await step3(result2)
    print(result3)

asyncio.run(main())
```

### Coroutine with Exception Handling

```python
import asyncio

async def might_fail():
    await asyncio.sleep(1)
    raise ValueError("Error occurred")

async def main():
    try:
        await might_fail()
    except ValueError as e:
        print(f"Caught: {e}")

asyncio.run(main())
```

---

## Event Loops

### Understanding Event Loops

An event loop manages and distributes the execution of different tasks:

```python
import asyncio

async def task(name):
    print(f"{name} starting")
    await asyncio.sleep(1)
    print(f"{name} finished")

# Get event loop
loop = asyncio.get_event_loop()

# Run coroutine
loop.run_until_complete(task("Task1"))

# Close loop
loop.close()
```

### Using asyncio.run()

`asyncio.run()` creates an event loop, runs the coroutine, and closes the loop:

```python
import asyncio

async def main():
    print("Running in event loop")

asyncio.run(main())
```

### Manual Event Loop Management

```python
import asyncio

async def task():
    print("Task running")
    await asyncio.sleep(1)

# Create event loop
loop = asyncio.new_event_loop()
asyncio.set_event_loop(loop)

try:
    loop.run_until_complete(task())
finally:
    loop.close()
```

### Scheduling Tasks

```python
import asyncio

async def task(name):
    print(f"{name} executed")
    return f"{name} result"

async def main():
    # Schedule tasks
    task1 = asyncio.create_task(task("Task1"))
    task2 = asyncio.create_task(task("Task2"))
    
    # Wait for both
    results = await asyncio.gather(task1, task2)
    print(results)

asyncio.run(main())
```

---

## Asynchronous I/O Operations

### Async File I/O

```python
import asyncio

async def read_file(filename):
    with open(filename, 'r') as f:
        content = f.read()
    return content

async def main():
    content = await read_file('data.txt')
    print(content)

asyncio.run(main())
```

### Async HTTP Requests

```python
import asyncio
import aiohttp

async def fetch_url(session, url):
    async with session.get(url) as response:
        return await response.text()

async def main():
    async with aiohttp.ClientSession() as session:
        html = await fetch_url(session, 'https://example.com')
        print(len(html))

asyncio.run(main())
```

### Multiple HTTP Requests

```python
import asyncio
import aiohttp

async def fetch_url(session, url):
    async with session.get(url) as response:
        return await response.text()

async def main():
    urls = [
        'https://example.com',
        'https://python.org',
        'https://github.com'
    ]
    
    async with aiohttp.ClientSession() as session:
        tasks = [fetch_url(session, url) for url in urls]
        results = await asyncio.gather(*tasks)
        print(f"Fetched {len(results)} pages")

asyncio.run(main())
```

---

## Async Context Managers

### Creating Async Context Managers

```python
import asyncio

class AsyncContextManager:
    async def __aenter__(self):
        print("Entering context")
        return self
    
    async def __aexit__(self, exc_type, exc_val, exc_tb):
        print("Exiting context")
        return False

async def main():
    async with AsyncContextManager() as cm:
        print("Inside context")

asyncio.run(main())
```

### Using @asynccontextmanager

```python
from contextlib import asynccontextmanager
import asyncio

@asynccontextmanager
async def async_context():
    print("Entering")
    try:
        yield "resource"
    finally:
        print("Exiting")

async def main():
    async with async_context() as resource:
        print(f"Using {resource}")

asyncio.run(main())
```

---

## Async Generators

### Creating Async Generators

```python
import asyncio

async def async_generator():
    for i in range(5):
        await asyncio.sleep(0.5)
        yield i

async def main():
    async for value in async_generator():
        print(value)

asyncio.run(main())
```

### Using Async Generators

```python
import asyncio

async def countdown(n):
    while n > 0:
        await asyncio.sleep(1)
        yield n
        n -= 1

async def main():
    async for num in countdown(5):
        print(num)

asyncio.run(main())
```

---

## Practical Examples

### Example 1: Concurrent Downloads

```python
import asyncio
import aiohttp

async def download_file(session, url, filename):
    async with session.get(url) as response:
        content = await response.read()
        with open(filename, 'wb') as f:
            f.write(content)
        print(f"Downloaded {filename}")

async def main():
    urls = [
        ("https://example.com/file1.txt", "file1.txt"),
        ("https://example.com/file2.txt", "file2.txt"),
        ("https://example.com/file3.txt", "file3.txt"),
    ]
    
    async with aiohttp.ClientSession() as session:
        tasks = [
            download_file(session, url, filename)
            for url, filename in urls
        ]
        await asyncio.gather(*tasks)

asyncio.run(main())
```

### Example 2: Web Scraper

```python
import asyncio
import aiohttp
from bs4 import BeautifulSoup

async def fetch_page(session, url):
    async with session.get(url) as response:
        return await response.text()

async def parse_page(session, url):
    html = await fetch_page(session, url)
    soup = BeautifulSoup(html, 'html.parser')
    return soup.title.string if soup.title else "No title"

async def main():
    urls = [
        'https://example.com',
        'https://python.org',
        'https://github.com'
    ]
    
    async with aiohttp.ClientSession() as session:
        tasks = [parse_page(session, url) for url in urls]
        titles = await asyncio.gather(*tasks)
        for url, title in zip(urls, titles):
            print(f"{url}: {title}")

asyncio.run(main())
```

### Example 3: Rate-Limited Requests

```python
import asyncio

class RateLimiter:
    def __init__(self, rate):
        self.rate = rate
        self.tokens = rate
        self.updated_at = asyncio.get_event_loop().time()
    
    async def acquire(self):
        while self.tokens < 1:
            await asyncio.sleep(0.1)
            self._add_tokens()
        
        self.tokens -= 1
    
    def _add_tokens(self):
        now = asyncio.get_event_loop().time()
        elapsed = now - self.updated_at
        self.tokens = min(self.rate, self.tokens + elapsed * self.rate)
        self.updated_at = now

async def make_request(limiter, request_id):
    await limiter.acquire()
    print(f"Request {request_id} made")
    await asyncio.sleep(0.1)

async def main():
    limiter = RateLimiter(rate=2)  # 2 requests per second
    
    tasks = [make_request(limiter, i) for i in range(10)]
    await asyncio.gather(*tasks)

asyncio.run(main())
```

---

## Common Mistakes and Pitfalls

### 1. Forgetting await

```python
# WRONG: Missing await
async def fetch_data():
    return "Data"

async def main():
    result = fetch_data()  # Returns coroutine, not result!
    print(result)  # <coroutine object fetch_data at 0x...>

# CORRECT: Use await
async def main():
    result = await fetch_data()
    print(result)  # Data
```

### 2. Blocking Operations in Async Code

```python
# WRONG: Blocking operation
import time

async def bad_function():
    time.sleep(1)  # Blocks event loop!

# CORRECT: Use async sleep
async def good_function():
    await asyncio.sleep(1)  # Non-blocking
```

### 3. Not Using asyncio.run()

```python
# WRONG: Calling coroutine directly
async def main():
    print("Hello")

main()  # Returns coroutine, doesn't run

# CORRECT: Use asyncio.run()
asyncio.run(main())
```

### 4. Mixing Sync and Async

```python
# WRONG: Calling async from sync
def sync_function():
    result = await async_function()  # SyntaxError!

# CORRECT: Make function async
async def sync_function():
    result = await async_function()
```

---

## Best Practices

### 1. Always Use await for Async Operations

```python
async def fetch_data():
    await asyncio.sleep(1)
    return "Data"
```

### 2. Use asyncio.gather() for Concurrent Operations

```python
results = await asyncio.gather(task1(), task2(), task3())
```

### 3. Use Async Context Managers

```python
async with async_context() as resource:
    # Use resource
    pass
```

### 4. Avoid Blocking Operations

```python
# Use asyncio.sleep() instead of time.sleep()
await asyncio.sleep(1)
```

### 5. Handle Exceptions Properly

```python
async def main():
    try:
        result = await might_fail()
    except Exception as e:
        print(f"Error: {e}")
```

---

## Practice Exercise

### Exercise: Async Programming

**Objective**: Create a Python program that demonstrates asynchronous programming.

**Instructions**:

1. Create a file called `async_practice.py`

2. Write a program that:
   - Uses async/await syntax
   - Creates and runs coroutines
   - Uses asyncio module features
   - Demonstrates concurrent execution
   - Shows practical applications

3. Your program should include:
   - Basic async functions
   - Multiple coroutines
   - Concurrent execution with gather()
   - Tasks and event loops
   - Real-world examples

**Example Solution**:

```python
"""
Asynchronous Programming Practice
This program demonstrates async/await and asyncio.
"""

import asyncio
import time

print("=" * 60)
print("ASYNCHRONOUS PROGRAMMING PRACTICE")
print("=" * 60)
print()

# 1. Basic async function
print("1. BASIC ASYNC FUNCTION")
print("-" * 60)

async def hello():
    print("Hello")
    await asyncio.sleep(0.5)
    print("World")

asyncio.run(hello())
print()

# 2. Multiple await calls (sequential)
print("2. MULTIPLE AWAIT CALLS (SEQUENTIAL)")
print("-" * 60)

async def task(name, delay):
    print(f"{name} starting")
    await asyncio.sleep(delay)
    print(f"{name} finished")
    return f"{name} result"

async def main():
    start = time.time()
    result1 = await task("Task1", 0.5)
    result2 = await task("Task2", 0.5)
    elapsed = time.time() - start
    print(f"Results: {result1}, {result2}")
    print(f"Time: {elapsed:.2f}s")

asyncio.run(main())
print()

# 3. Concurrent execution with gather()
print("3. CONCURRENT EXECUTION WITH gather()")
print("-" * 60)

async def main():
    start = time.time()
    results = await asyncio.gather(
        task("Task1", 0.5),
        task("Task2", 0.5),
        task("Task3", 0.5)
    )
    elapsed = time.time() - start
    print(f"Results: {results}")
    print(f"Time: {elapsed:.2f}s (concurrent)")

asyncio.run(main())
print()

# 4. Creating tasks
print("4. CREATING TASKS")
print("-" * 60)

async def main():
    task1 = asyncio.create_task(task("Task1", 1))
    task2 = asyncio.create_task(task("Task2", 1))
    
    result1 = await task1
    result2 = await task2
    print(f"Results: {result1}, {result2}")

asyncio.run(main())
print()

# 5. asyncio.wait()
print("5. asyncio.wait()")
print("-" * 60)

async def main():
    tasks = [
        asyncio.create_task(task("Task1", 0.5)),
        asyncio.create_task(task("Task2", 1)),
        asyncio.create_task(task("Task3", 0.3))
    ]
    
    done, pending = await asyncio.wait(tasks, return_when=asyncio.ALL_COMPLETED)
    print(f"All tasks completed: {[t.result() for t in done]}")

asyncio.run(main())
print()

# 6. Chaining coroutines
print("6. CHAINING COROUTINES")
print("-" * 60)

async def step1():
    await asyncio.sleep(0.3)
    return "Step 1"

async def step2(data):
    await asyncio.sleep(0.3)
    return f"{data} -> Step 2"

async def step3(data):
    await asyncio.sleep(0.3)
    return f"{data} -> Step 3"

async def main():
    result1 = await step1()
    result2 = await step2(result1)
    result3 = await step3(result2)
    print(result3)

asyncio.run(main())
print()

# 7. Exception handling
print("7. EXCEPTION HANDLING")
print("-" * 60)

async def might_fail(should_fail):
    await asyncio.sleep(0.2)
    if should_fail:
        raise ValueError("Error occurred")
    return "Success"

async def main():
    try:
        result = await might_fail(False)
        print(f"Result: {result}")
    except ValueError as e:
        print(f"Caught: {e}")
    
    try:
        await might_fail(True)
    except ValueError as e:
        print(f"Caught: {e}")

asyncio.run(main())
print()

# 8. Async generator
print("8. ASYNC GENERATOR")
print("-" * 60)

async def async_countdown(n):
    while n > 0:
        await asyncio.sleep(0.2)
        yield n
        n -= 1

async def main():
    async for num in async_countdown(5):
        print(f"Countdown: {num}")

asyncio.run(main())
print()

# 9. Async context manager
print("9. ASYNC CONTEXT MANAGER")
print("-" * 60)

class AsyncContext:
    async def __aenter__(self):
        print("Entering context")
        return self
    
    async def __aexit__(self, exc_type, exc_val, exc_tb):
        print("Exiting context")
        return False

async def main():
    async with AsyncContext() as ctx:
        print("Inside context")

asyncio.run(main())
print()

# 10. Real-world: Concurrent tasks
print("10. REAL-WORLD: CONCURRENT TASKS")
print("-" * 60)

async def fetch_data(name, delay):
    print(f"Fetching {name}...")
    await asyncio.sleep(delay)
    return f"{name} data"

async def main():
    start = time.time()
    results = await asyncio.gather(
        fetch_data("User", 0.5),
        fetch_data("Posts", 0.5),
        fetch_data("Comments", 0.5)
    )
    elapsed = time.time() - start
    print(f"Results: {results}")
    print(f"Time: {elapsed:.2f}s (concurrent)")

asyncio.run(main())
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
ASYNCHRONOUS PROGRAMMING PRACTICE
============================================================

1. BASIC ASYNC FUNCTION
------------------------------------------------------------
Hello
World

[... rest of output ...]
```

**Challenge** (Optional):
- Create an async web scraper that fetches multiple pages concurrently
- Build an async file processor that processes multiple files in parallel
- Implement an async chat server using asyncio
- Create an async task queue system

---

## Key Takeaways

1. **async/await** - syntax for asynchronous programming
2. **asyncio module** - provides async functionality
3. **Coroutines** - functions that can be paused and resumed
4. **Event loops** - manage async task execution
5. **asyncio.run()** - runs coroutines
6. **asyncio.gather()** - runs multiple coroutines concurrently
7. **Tasks** - scheduled coroutines
8. **Async I/O** - non-blocking I/O operations
9. **Async context managers** - `async with` statement
10. **Async generators** - `async for` statement
11. **Concurrency** - multiple tasks running concurrently
12. **Non-blocking** - doesn't block the event loop
13. **Best practices** - always await, use gather(), avoid blocking
14. **When to use** - I/O-bound operations, concurrent tasks
15. **Common mistakes** - forgetting await, blocking operations

---

## Quiz: Async

Test your understanding with these questions:

1. **What does `async def` create?**
   - A) A regular function
   - B) A coroutine function
   - C) A generator
   - D) A class

2. **What does `await` do?**
   - A) Waits for a coroutine to complete
   - B) Creates a coroutine
   - C) Runs a function
   - D) Nothing

3. **What is asyncio.run() used for?**
   - A) Creating tasks
   - B) Running coroutines
   - C) Creating event loops
   - D) All of the above

4. **What does asyncio.gather() do?**
   - A) Runs coroutines sequentially
   - B) Runs coroutines concurrently
   - C) Creates tasks
   - D) Waits for tasks

5. **What is a coroutine?**
   - A) A function
   - B) A function that can be paused and resumed
   - C) A generator
   - D) A class

6. **What is an event loop?**
   - A) A loop that runs forever
   - B) Manages async task execution
   - C) A for loop
   - D) Nothing

7. **What happens if you forget await?**
   - A) Nothing
   - B) Gets coroutine object instead of result
   - C) Error occurs
   - D) Function runs normally

8. **What should you use instead of time.sleep() in async code?**
   - A) time.sleep()
   - B) asyncio.sleep()
   - C) await sleep()
   - D) sleep()

9. **What is async with used for?**
   - A) Async for loops
   - B) Async context managers
   - C) Async functions
   - D) Nothing

10. **When should you use async programming?**
    - A) Always
    - B) For I/O-bound operations
    - C) For CPU-bound operations
    - D) Never

**Answers**:
1. B) A coroutine function (async def creates coroutine function)
2. A) Waits for a coroutine to complete (await purpose)
3. B) Running coroutines (asyncio.run() purpose)
4. B) Runs coroutines concurrently (asyncio.gather() purpose)
5. B) A function that can be paused and resumed (coroutine definition)
6. B) Manages async task execution (event loop purpose)
7. B) Gets coroutine object instead of result (forgetting await consequence)
8. B) asyncio.sleep() (non-blocking sleep)
9. B) Async context managers (async with purpose)
10. B) For I/O-bound operations (when to use async)

---

## Next Steps

Excellent work! You've mastered asynchronous programming. You now understand:
- async/await syntax
- asyncio module
- Coroutines
- Event loops

**What's Next?**
- Module 17: Testing
- Learn testing basics
- Understand unit testing
- Explore testing frameworks

---

## Additional Resources

- **asyncio**: [docs.python.org/3/library/asyncio.html](https://docs.python.org/3/library/asyncio.html)
- **PEP 492**: [peps.python.org/pep-0492/](https://peps.python.org/pep-0492/) (Coroutines with async and await syntax)
- **PEP 525**: [peps.python.org/pep-0525/](https://peps.python.org/pep-0525/) (Asynchronous Generators)

---

*Lesson completed! You're ready to move on to the next module.*

