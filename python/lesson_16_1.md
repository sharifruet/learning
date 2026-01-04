# Lesson 16.1: Threading

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand the threading module
- Create and manage threads
- Use thread synchronization primitives
- Understand the Global Interpreter Lock (GIL)
- Handle thread communication
- Use thread-safe data structures
- Debug threading issues
- Understand when to use threading
- Apply threading in practical scenarios
- Know the limitations of threading in Python

---

## Introduction to Threading

**Threading** allows you to run multiple tasks concurrently within a single process. In Python, the `threading` module provides a high-level interface for working with threads.

### Why Threading?

- **Concurrent execution**: Run multiple tasks simultaneously
- **I/O-bound tasks**: Efficient for I/O operations
- **Responsive applications**: Keep UI responsive while doing work
- **Resource sharing**: Threads share memory space
- **Simpler than multiprocessing**: Easier to share data

### What Are Threads?

Threads are lightweight processes that share the same memory space. They allow concurrent execution of code within a single process.

---

## Threading Module

### Basic Threading

The `threading` module provides classes and functions for working with threads:

```python
import threading
import time

def worker():
    print(f"Thread {threading.current_thread().name} starting")
    time.sleep(2)
    print(f"Thread {threading.current_thread().name} finished")

# Create and start thread
thread = threading.Thread(target=worker, name="WorkerThread")
thread.start()
thread.join()  # Wait for thread to complete
print("Main thread continuing")
```

### Thread Information

```python
import threading

def worker():
    thread = threading.current_thread()
    print(f"Name: {thread.name}")
    print(f"ID: {thread.ident}")
    print(f"Alive: {thread.is_alive()}")
    print(f"Daemon: {thread.daemon}")

thread = threading.Thread(target=worker, name="Worker")
thread.start()
thread.join()
```

---

## Creating Threads

### Method 1: Using Thread Class with Function

```python
import threading
import time

def print_numbers():
    for i in range(5):
        print(f"Number: {i}")
        time.sleep(0.5)

# Create thread
thread = threading.Thread(target=print_numbers)
thread.start()
thread.join()
print("Thread finished")
```

### Method 2: Using Thread Class with Class

```python
import threading
import time

class WorkerThread(threading.Thread):
    def __init__(self, name):
        super().__init__(name=name)
    
    def run(self):
        print(f"{self.name} starting")
        for i in range(5):
            print(f"{self.name}: {i}")
            time.sleep(0.5)
        print(f"{self.name} finished")

# Create and start thread
thread = WorkerThread("Worker1")
thread.start()
thread.join()
```

### Method 3: Multiple Threads

```python
import threading
import time

def worker(name, delay):
    print(f"Thread {name} starting")
    time.sleep(delay)
    print(f"Thread {name} finished")

# Create multiple threads
threads = []
for i in range(3):
    thread = threading.Thread(target=worker, args=(f"Worker{i}", 1))
    threads.append(thread)
    thread.start()

# Wait for all threads
for thread in threads:
    thread.join()

print("All threads finished")
```

### Thread Arguments

```python
import threading

def worker(name, count, delay):
    for i in range(count):
        print(f"{name}: {i}")
        time.sleep(delay)

# Pass arguments
thread = threading.Thread(
    target=worker,
    args=("Worker", 5, 0.5),
    name="WorkerThread"
)
thread.start()
thread.join()
```

### Daemon Threads

Daemon threads automatically exit when the main program exits:

```python
import threading
import time

def daemon_worker():
    while True:
        print("Daemon working...")
        time.sleep(1)

# Create daemon thread
daemon = threading.Thread(target=daemon_worker, daemon=True)
daemon.start()

time.sleep(3)
print("Main program exiting")
# Daemon thread is automatically terminated
```

---

## Thread Synchronization

### The Problem: Race Conditions

Without synchronization, threads can interfere with each other:

```python
import threading

counter = 0

def increment():
    global counter
    for _ in range(100000):
        counter += 1

# Create threads
threads = []
for _ in range(2):
    thread = threading.Thread(target=increment)
    threads.append(thread)
    thread.start()

for thread in threads:
    thread.join()

print(f"Counter: {counter}")  # May not be 200000!
```

### Solution: Locks

A **Lock** ensures only one thread can execute a block of code at a time:

```python
import threading

counter = 0
lock = threading.Lock()

def increment():
    global counter
    for _ in range(100000):
        with lock:  # Acquire lock
            counter += 1
        # Lock automatically released

threads = []
for _ in range(2):
    thread = threading.Thread(target=increment)
    threads.append(thread)
    thread.start()

for thread in threads:
    thread.join()

print(f"Counter: {counter}")  # Always 200000
```

### Using Lock Explicitly

```python
import threading

lock = threading.Lock()

def worker():
    lock.acquire()  # Acquire lock
    try:
        # Critical section
        print("Thread in critical section")
    finally:
        lock.release()  # Always release

thread = threading.Thread(target=worker)
thread.start()
thread.join()
```

### RLock (Reentrant Lock)

An RLock can be acquired multiple times by the same thread:

```python
import threading

rlock = threading.RLock()

def outer():
    with rlock:
        print("Outer function")
        inner()

def inner():
    with rlock:  # Same thread can acquire again
        print("Inner function")

thread = threading.Thread(target=outer)
thread.start()
thread.join()
```

### Semaphore

A **Semaphore** limits the number of threads that can access a resource:

```python
import threading
import time

semaphore = threading.Semaphore(2)  # Allow 2 threads

def worker(name):
    with semaphore:
        print(f"{name} acquired semaphore")
        time.sleep(2)
        print(f"{name} releasing semaphore")

# Create multiple threads
threads = []
for i in range(5):
    thread = threading.Thread(target=worker, args=(f"Worker{i}",))
    threads.append(thread)
    thread.start()

for thread in threads:
    thread.join()
```

### Event

An **Event** allows threads to wait for a signal:

```python
import threading
import time

event = threading.Event()

def waiter():
    print("Waiting for event...")
    event.wait()  # Wait for event
    print("Event received!")

def setter():
    time.sleep(2)
    print("Setting event")
    event.set()  # Signal event

thread1 = threading.Thread(target=waiter)
thread2 = threading.Thread(target=setter)

thread1.start()
thread2.start()

thread1.join()
thread2.join()
```

### Condition

A **Condition** allows threads to wait for a condition to become true:

```python
import threading
import time

condition = threading.Condition()
items = []

def consumer():
    with condition:
        while len(items) == 0:
            condition.wait()  # Wait for items
        item = items.pop(0)
        print(f"Consumed: {item}")

def producer():
    time.sleep(1)
    with condition:
        items.append("Item")
        condition.notify()  # Notify waiting thread

thread1 = threading.Thread(target=consumer)
thread2 = threading.Thread(target=producer)

thread1.start()
thread2.start()

thread1.join()
thread2.join()
```

---

## Thread Communication

### Queue for Thread Communication

The `queue` module provides thread-safe queues:

```python
import threading
import queue
import time

def producer(q):
    for i in range(5):
        print(f"Producing {i}")
        q.put(i)
        time.sleep(0.5)
    q.put(None)  # Signal completion

def consumer(q):
    while True:
        item = q.get()
        if item is None:
            break
        print(f"Consuming {item}")
        q.task_done()

q = queue.Queue()
thread1 = threading.Thread(target=producer, args=(q,))
thread2 = threading.Thread(target=consumer, args=(q,))

thread1.start()
thread2.start()

thread1.join()
thread2.join()
```

### Thread-Safe Data Structures

```python
import threading
from collections import deque

# Thread-safe deque
deque_lock = threading.Lock()
safe_deque = deque()

def add_item(item):
    with deque_lock:
        safe_deque.append(item)

def get_item():
    with deque_lock:
        if safe_deque:
            return safe_deque.popleft()
    return None
```

---

## Global Interpreter Lock (GIL)

### What is the GIL?

The **Global Interpreter Lock (GIL)** is a mutex that protects access to Python objects, preventing multiple threads from executing Python bytecodes at once.

### GIL Implications

- **CPU-bound tasks**: Threading doesn't help with CPU-bound tasks
- **I/O-bound tasks**: Threading works well for I/O-bound tasks
- **Only one thread**: Only one thread executes Python code at a time

### Understanding GIL Behavior

```python
import threading
import time

def cpu_bound_task():
    """CPU-bound task - GIL prevents true parallelism"""
    result = 0
    for i in range(10000000):
        result += i * i
    return result

def io_bound_task():
    """I/O-bound task - GIL released during I/O"""
    time.sleep(1)  # GIL is released during sleep
    return "Done"

# CPU-bound: Threading doesn't help
start = time.time()
threads = []
for _ in range(2):
    thread = threading.Thread(target=cpu_bound_task)
    threads.append(thread)
    thread.start()

for thread in threads:
    thread.join()
cpu_time = time.time() - start

# I/O-bound: Threading helps
start = time.time()
threads = []
for _ in range(2):
    thread = threading.Thread(target=io_bound_task)
    threads.append(thread)
    thread.start()

for thread in threads:
    thread.join()
io_time = time.time() - start

print(f"CPU-bound time: {cpu_time:.2f}s")
print(f"I/O-bound time: {io_time:.2f}s")
```

### When Threading Helps

Threading is beneficial for:
- **I/O operations**: File I/O, network I/O, database operations
- **Waiting operations**: Sleep, waiting for user input
- **Concurrent I/O**: Multiple network requests

Threading is NOT beneficial for:
- **CPU-bound tasks**: Mathematical computations, image processing
- **Pure computation**: Number crunching, data processing

---

## Practical Examples

### Example 1: Downloading Multiple Files

```python
import threading
import time
import urllib.request

def download_file(url, filename):
    print(f"Downloading {filename}...")
    # Simulate download
    time.sleep(2)
    print(f"Finished {filename}")

urls = [
    ("http://example.com/file1.txt", "file1.txt"),
    ("http://example.com/file2.txt", "file2.txt"),
    ("http://example.com/file3.txt", "file3.txt"),
]

threads = []
for url, filename in urls:
    thread = threading.Thread(target=download_file, args=(url, filename))
    threads.append(thread)
    thread.start()

for thread in threads:
    thread.join()

print("All downloads complete")
```

### Example 2: Thread Pool Pattern

```python
import threading
import queue
import time

class ThreadPool:
    def __init__(self, num_threads):
        self.tasks = queue.Queue()
        self.threads = []
        for _ in range(num_threads):
            thread = threading.Thread(target=self._worker)
            thread.start()
            self.threads.append(thread)
    
    def _worker(self):
        while True:
            task = self.tasks.get()
            if task is None:
                break
            task()
            self.tasks.task_done()
    
    def submit(self, task):
        self.tasks.put(task)
    
    def shutdown(self):
        for _ in self.threads:
            self.tasks.put(None)
        for thread in self.threads:
            thread.join()

def task(name):
    print(f"Task {name} executing")
    time.sleep(1)

pool = ThreadPool(3)
for i in range(5):
    pool.submit(lambda i=i: task(i))

pool.shutdown()
```

### Example 3: Producer-Consumer Pattern

```python
import threading
import queue
import time
import random

def producer(q, name):
    for i in range(5):
        item = f"Item-{i}"
        print(f"{name} producing {item}")
        q.put(item)
        time.sleep(random.uniform(0.1, 0.5))

def consumer(q, name):
    while True:
        item = q.get()
        if item is None:
            break
        print(f"{name} consuming {item}")
        time.sleep(random.uniform(0.1, 0.5))
        q.task_done()

q = queue.Queue()

# Create producer threads
producers = []
for i in range(2):
    thread = threading.Thread(target=producer, args=(q, f"Producer{i}"))
    producers.append(thread)
    thread.start()

# Create consumer threads
consumers = []
for i in range(2):
    thread = threading.Thread(target=consumer, args=(q, f"Consumer{i}"))
    consumers.append(thread)
    thread.start()

# Wait for producers
for thread in producers:
    thread.join()

# Signal consumers to stop
for _ in consumers:
    q.put(None)

# Wait for consumers
for thread in consumers:
    thread.join()
```

---

## Common Mistakes and Pitfalls

### 1. Not Using Locks for Shared Data

```python
# WRONG: Race condition
counter = 0

def increment():
    global counter
    counter += 1  # Not thread-safe!

# CORRECT: Use lock
counter = 0
lock = threading.Lock()

def increment():
    global counter
    with lock:
        counter += 1
```

### 2. Deadlocks

```python
# WRONG: Can cause deadlock
lock1 = threading.Lock()
lock2 = threading.Lock()

def thread1():
    with lock1:
        with lock2:  # Deadlock if thread2 has lock2
            pass

def thread2():
    with lock2:
        with lock1:  # Deadlock if thread1 has lock1
            pass

# CORRECT: Always acquire locks in same order
def thread1():
    with lock1:
        with lock2:
            pass

def thread2():
    with lock1:  # Same order
        with lock2:
            pass
```

### 3. Forgetting to Join Threads

```python
# WRONG: Main thread may exit before worker finishes
thread = threading.Thread(target=worker)
thread.start()
# Missing thread.join()

# CORRECT: Always join threads
thread = threading.Thread(target=worker)
thread.start()
thread.join()
```

### 4. Using Threading for CPU-Bound Tasks

```python
# WRONG: Threading doesn't help CPU-bound tasks
def cpu_task():
    result = sum(i * i for i in range(10000000))

threads = [threading.Thread(target=cpu_task) for _ in range(4)]
# This won't be faster due to GIL

# CORRECT: Use multiprocessing for CPU-bound tasks
from multiprocessing import Process
processes = [Process(target=cpu_task) for _ in range(4)]
```

---

## Best Practices

### 1. Use Locks for Shared Data

```python
lock = threading.Lock()

def worker():
    with lock:
        # Access shared data
        pass
```

### 2. Use Queue for Thread Communication

```python
import queue

q = queue.Queue()
# Use queue instead of shared variables
```

### 3. Always Join Threads

```python
thread = threading.Thread(target=worker)
thread.start()
thread.join()  # Always join
```

### 4. Use Threading for I/O-Bound Tasks

```python
# Good: I/O-bound task
def download_file(url):
    # Network I/O - threading helps
    pass

# Avoid: CPU-bound task
def compute():
    # CPU computation - threading doesn't help
    pass
```

### 5. Avoid Global Variables

```python
# Avoid: Global variables
counter = 0

# Prefer: Pass data as arguments
def worker(counter):
    counter += 1
```

---

## Practice Exercise

### Exercise: Threading

**Objective**: Create a Python program that demonstrates threading.

**Instructions**:

1. Create a file called `threading_practice.py`

2. Write a program that:
   - Creates and manages threads
   - Uses thread synchronization
   - Demonstrates thread communication
   - Shows practical applications
   - Handles thread safety

3. Your program should include:
   - Basic thread creation
   - Multiple threads
   - Thread synchronization with locks
   - Thread communication with queues
   - Producer-consumer pattern
   - Real-world examples

**Example Solution**:

```python
"""
Threading Practice
This program demonstrates threading in Python.
"""

import threading
import time
import queue
import random

print("=" * 60)
print("THREADING PRACTICE")
print("=" * 60)
print()

# 1. Basic thread
print("1. BASIC THREAD")
print("-" * 60)

def worker(name):
    print(f"Thread {name} starting")
    time.sleep(1)
    print(f"Thread {name} finished")

thread = threading.Thread(target=worker, args=("Worker1",))
thread.start()
thread.join()
print()

# 2. Multiple threads
print("2. MULTIPLE THREADS")
print("-" * 60)

def print_numbers(name, count):
    for i in range(count):
        print(f"{name}: {i}")
        time.sleep(0.2)

threads = []
for i in range(3):
    thread = threading.Thread(target=print_numbers, args=(f"Worker{i}", 3))
    threads.append(thread)
    thread.start()

for thread in threads:
    thread.join()
print()

# 3. Thread with class
print("3. THREAD WITH CLASS")
print("-" * 60)

class WorkerThread(threading.Thread):
    def __init__(self, name):
        super().__init__(name=name)
    
    def run(self):
        print(f"{self.name} starting")
        time.sleep(1)
        print(f"{self.name} finished")

thread = WorkerThread("Worker")
thread.start()
thread.join()
print()

# 4. Thread synchronization with lock
print("4. THREAD SYNCHRONIZATION WITH LOCK")
print("-" * 60)

counter = 0
lock = threading.Lock()

def increment():
    global counter
    for _ in range(1000):
        with lock:
            counter += 1

threads = []
for _ in range(5):
    thread = threading.Thread(target=increment)
    threads.append(thread)
    thread.start()

for thread in threads:
    thread.join()

print(f"Counter: {counter}")  # Should be 5000
print()

# 5. Semaphore
print("5. SEMAPHORE")
print("-" * 60)

semaphore = threading.Semaphore(2)

def worker(name):
    with semaphore:
        print(f"{name} acquired semaphore")
        time.sleep(1)
        print(f"{name} releasing semaphore")

threads = []
for i in range(5):
    thread = threading.Thread(target=worker, args=(f"Worker{i}",))
    threads.append(thread)
    thread.start()

for thread in threads:
    thread.join()
print()

# 6. Event
print("6. EVENT")
print("-" * 60)

event = threading.Event()

def waiter():
    print("Waiting for event...")
    event.wait()
    print("Event received!")

def setter():
    time.sleep(1)
    print("Setting event")
    event.set()

thread1 = threading.Thread(target=waiter)
thread2 = threading.Thread(target=setter)

thread1.start()
thread2.start()

thread1.join()
thread2.join()
print()

# 7. Condition
print("7. CONDITION")
print("-" * 60)

condition = threading.Condition()
items = []

def consumer():
    with condition:
        while len(items) == 0:
            condition.wait()
        item = items.pop(0)
        print(f"Consumed: {item}")

def producer():
    time.sleep(0.5)
    with condition:
        items.append("Item")
        print("Produced: Item")
        condition.notify()

thread1 = threading.Thread(target=consumer)
thread2 = threading.Thread(target=producer)

thread1.start()
thread2.start()

thread1.join()
thread2.join()
print()

# 8. Queue for thread communication
print("8. QUEUE FOR THREAD COMMUNICATION")
print("-" * 60)

q = queue.Queue()

def producer(name):
    for i in range(3):
        item = f"{name}-Item{i}"
        print(f"Producing {item}")
        q.put(item)
        time.sleep(0.3)

def consumer(name):
    while True:
        item = q.get()
        if item is None:
            break
        print(f"{name} consuming {item}")
        q.task_done()

thread1 = threading.Thread(target=producer, args=("Producer",))
thread2 = threading.Thread(target=consumer, args=("Consumer",))

thread1.start()
thread2.start()

thread1.join()
q.put(None)
thread2.join()
print()

# 9. Producer-consumer pattern
print("9. PRODUCER-CONSUMER PATTERN")
print("-" * 60)

q = queue.Queue()

def producer(name, count):
    for i in range(count):
        item = f"{name}-{i}"
        q.put(item)
        time.sleep(0.1)

def consumer(name):
    while True:
        item = q.get()
        if item is None:
            break
        print(f"{name} got {item}")
        q.task_done()

producers = []
for i in range(2):
    thread = threading.Thread(target=producer, args=(f"P{i}", 3))
    producers.append(thread)
    thread.start()

consumers = []
for i in range(2):
    thread = threading.Thread(target=consumer, args=(f"C{i}",))
    consumers.append(thread)
    thread.start()

for thread in producers:
    thread.join()

for _ in consumers:
    q.put(None)

for thread in consumers:
    thread.join()
print()

# 10. Thread pool pattern
print("10. THREAD POOL PATTERN")
print("-" * 60)

class ThreadPool:
    def __init__(self, num_threads):
        self.tasks = queue.Queue()
        self.threads = []
        for _ in range(num_threads):
            thread = threading.Thread(target=self._worker)
            thread.start()
            self.threads.append(thread)
    
    def _worker(self):
        while True:
            task = self.tasks.get()
            if task is None:
                break
            task()
            self.tasks.task_done()
    
    def submit(self, task):
        self.tasks.put(task)
    
    def shutdown(self):
        for _ in self.threads:
            self.tasks.put(None)
        for thread in self.threads:
            thread.join()

def task(name):
    print(f"Task {name} executing")
    time.sleep(0.5)

pool = ThreadPool(3)
for i in range(5):
    pool.submit(lambda i=i: task(i))

pool.shutdown()
print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
THREADING PRACTICE
============================================================

1. BASIC THREAD
------------------------------------------------------------
Thread Worker1 starting
Thread Worker1 finished

[... rest of output ...]
```

**Challenge** (Optional):
- Create a web scraper that downloads multiple pages concurrently
- Build a file processing system that processes multiple files in parallel
- Implement a chat server that handles multiple clients using threads
- Create a task scheduler that manages background tasks

---

## Key Takeaways

1. **Threading module** - provides thread functionality
2. **Thread creation** - using Thread class or inheritance
3. **Thread synchronization** - locks, semaphores, events, conditions
4. **GIL** - Global Interpreter Lock limits CPU-bound parallelism
5. **I/O-bound tasks** - threading works well for I/O operations
6. **CPU-bound tasks** - threading doesn't help due to GIL
7. **Locks** - prevent race conditions
8. **Queues** - thread-safe communication
9. **Join threads** - always wait for threads to complete
10. **Thread safety** - protect shared data
11. **Deadlocks** - avoid by acquiring locks in same order
12. **Best practices** - use locks, queues, join threads
13. **When to use** - I/O-bound tasks, concurrent I/O
14. **When not to use** - CPU-bound tasks (use multiprocessing)
15. **Communication** - use queues for thread communication

---

## Quiz: Threading

Test your understanding with these questions:

1. **What is the threading module used for?**
   - A) Creating processes
   - B) Creating threads
   - C) Creating coroutines
   - D) Creating generators

2. **What is the GIL?**
   - A) Global Interpreter Lock
   - B) Global Instance Lock
   - C) General Interpreter Lock
   - D) Global Input Lock

3. **When does threading help?**
   - A) CPU-bound tasks
   - B) I/O-bound tasks
   - C) Both
   - D) Neither

4. **What is a lock used for?**
   - A) Preventing race conditions
   - B) Locking files
   - C) Locking memory
   - D) Nothing

5. **What happens if you don't join a thread?**
   - A) Nothing
   - B) Thread continues running
   - C) Main program may exit before thread finishes
   - D) Error occurs

6. **What is a semaphore?**
   - A) A lock
   - B) Limits number of threads accessing resource
   - C) A queue
   - D) An event

7. **What is the best way to communicate between threads?**
   - A) Global variables
   - B) Queues
   - C) Locks
   - D) Events

8. **Can multiple threads execute Python code simultaneously?**
   - A) Yes, always
   - B) No, due to GIL
   - C) Sometimes
   - D) Only in Python 3.9+

9. **What is a daemon thread?**
   - A) A background thread
   - B) A thread that exits when main program exits
   - C) A thread that never exits
   - D) A special thread

10. **What should you use for CPU-bound tasks?**
    - A) Threading
    - B) Multiprocessing
    - C) Both
    - D) Neither

**Answers**:
1. B) Creating threads (threading module purpose)
2. A) Global Interpreter Lock (GIL definition)
3. B) I/O-bound tasks (when threading helps)
4. A) Preventing race conditions (lock purpose)
5. C) Main program may exit before thread finishes (not joining thread)
6. B) Limits number of threads accessing resource (semaphore definition)
7. B) Queues (best way to communicate)
8. B) No, due to GIL (GIL limitation)
9. B) A thread that exits when main program exits (daemon thread definition)
10. B) Multiprocessing (for CPU-bound tasks)

---

## Next Steps

Excellent work! You've mastered threading. You now understand:
- The threading module
- Creating threads
- Thread synchronization
- The GIL and its implications

**What's Next?**
- Lesson 16.2: Multiprocessing
- Learn about multiprocessing
- Understand process communication
- Explore process pools

---

## Additional Resources

- **threading**: [docs.python.org/3/library/threading.html](https://docs.python.org/3/library/threading.html)
- **queue**: [docs.python.org/3/library/queue.html](https://docs.python.org/3/library/queue.html)
- **GIL**: [wiki.python.org/moin/GlobalInterpreterLock](https://wiki.python.org/moin/GlobalInterpreterLock)

---

*Lesson completed! You're ready to move on to the next lesson.*

