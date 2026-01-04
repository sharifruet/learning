# Lesson 16.2: Multiprocessing

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand the multiprocessing module
- Create and manage processes
- Understand Process vs Thread
- Use process communication mechanisms
- Work with process pools
- Share data between processes
- Apply multiprocessing in practical scenarios
- Debug multiprocessing issues
- Understand when to use multiprocessing
- Know the limitations and considerations

---

## Introduction to Multiprocessing

**Multiprocessing** allows you to run multiple processes in parallel, each with its own Python interpreter. This bypasses the Global Interpreter Lock (GIL) and enables true parallelism for CPU-bound tasks.

### Why Multiprocessing?

- **True parallelism**: Multiple CPU cores can execute code simultaneously
- **CPU-bound tasks**: Ideal for CPU-intensive operations
- **GIL bypass**: Each process has its own GIL
- **Isolation**: Processes don't share memory (by default)
- **Crash isolation**: One process crash doesn't affect others

### What is Multiprocessing?

Multiprocessing creates separate Python processes, each with its own memory space and Python interpreter, allowing true parallel execution.

---

## multiprocessing Module

### Basic Process Creation

The `multiprocessing` module provides the `Process` class:

```python
import multiprocessing
import time

def worker(name):
    print(f"Process {name} starting")
    time.sleep(2)
    print(f"Process {name} finished")

if __name__ == '__main__':
    process = multiprocessing.Process(target=worker, args=("Worker1",))
    process.start()
    process.join()  # Wait for process to complete
    print("Main process continuing")
```

### Process with Arguments

```python
import multiprocessing

def worker(name, count, delay):
    for i in range(count):
        print(f"{name}: {i}")
        time.sleep(delay)

if __name__ == '__main__':
    process = multiprocessing.Process(
        target=worker,
        args=("Worker", 5, 0.5)
    )
    process.start()
    process.join()
```

### Multiple Processes

```python
import multiprocessing
import time

def worker(name, delay):
    print(f"Process {name} starting")
    time.sleep(delay)
    print(f"Process {name} finished")

if __name__ == '__main__':
    processes = []
    for i in range(3):
        process = multiprocessing.Process(
            target=worker,
            args=(f"Worker{i}", 2)
        )
        processes.append(process)
        process.start()
    
    # Wait for all processes
    for process in processes:
        process.join()
    
    print("All processes finished")
```

### Process Class Inheritance

```python
import multiprocessing
import time

class WorkerProcess(multiprocessing.Process):
    def __init__(self, name):
        super().__init__(name=name)
    
    def run(self):
        print(f"{self.name} starting")
        time.sleep(2)
        print(f"{self.name} finished")

if __name__ == '__main__':
    process = WorkerProcess("Worker1")
    process.start()
    process.join()
```

### Process Information

```python
import multiprocessing
import os

def worker():
    process = multiprocessing.current_process()
    print(f"Name: {process.name}")
    print(f"PID: {process.pid}")
    print(f"Parent PID: {os.getppid()}")
    print(f"Alive: {process.is_alive()}")

if __name__ == '__main__':
    process = multiprocessing.Process(target=worker, name="Worker")
    process.start()
    process.join()
```

---

## Process vs Thread

### Key Differences

| Feature | Thread | Process |
|---------|--------|---------|
| Memory | Shared | Separate |
| GIL | Shared GIL | Separate GIL per process |
| Creation | Faster | Slower |
| Communication | Shared memory | IPC mechanisms |
| CPU-bound | Limited by GIL | True parallelism |
| I/O-bound | Works well | Works well |
| Crash isolation | No | Yes |

### When to Use Threading

- **I/O-bound tasks**: Network I/O, file I/O, database operations
- **Shared data**: Need to share data easily
- **Lightweight**: Need many concurrent tasks
- **Simple communication**: Direct memory access

### When to Use Multiprocessing

- **CPU-bound tasks**: Mathematical computations, image processing
- **True parallelism**: Need to use multiple CPU cores
- **Isolation**: Need process isolation
- **GIL limitation**: Need to bypass GIL

### Example: CPU-Bound Task Comparison

```python
import threading
import multiprocessing
import time

def cpu_task(n):
    """CPU-bound task"""
    result = 0
    for i in range(n):
        result += i * i
    return result

# Threading (limited by GIL)
def threading_approach():
    start = time.time()
    threads = []
    for _ in range(4):
        thread = threading.Thread(target=cpu_task, args=(10000000,))
        threads.append(thread)
        thread.start()
    
    for thread in threads:
        thread.join()
    return time.time() - start

# Multiprocessing (true parallelism)
def multiprocessing_approach():
    start = time.time()
    processes = []
    for _ in range(4):
        process = multiprocessing.Process(target=cpu_task, args=(10000000,))
        processes.append(process)
        process.start()
    
    for process in processes:
        process.join()
    return time.time() - start

if __name__ == '__main__':
    # Note: Multiprocessing will be faster for CPU-bound tasks
    print("Threading time:", threading_approach())
    print("Multiprocessing time:", multiprocessing_approach())
```

---

## Process Communication

### Queue

Queues provide thread-safe communication:

```python
import multiprocessing
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
        time.sleep(0.3)

if __name__ == '__main__':
    q = multiprocessing.Queue()
    
    p1 = multiprocessing.Process(target=producer, args=(q,))
    p2 = multiprocessing.Process(target=consumer, args=(q,))
    
    p1.start()
    p2.start()
    
    p1.join()
    p2.join()
```

### Pipe

Pipes provide bidirectional communication:

```python
import multiprocessing

def sender(conn):
    conn.send("Hello from sender")
    conn.close()

def receiver(conn):
    message = conn.recv()
    print(f"Received: {message}")
    conn.close()

if __name__ == '__main__':
    parent_conn, child_conn = multiprocessing.Pipe()
    
    p1 = multiprocessing.Process(target=sender, args=(child_conn,))
    p2 = multiprocessing.Process(target=receiver, args=(parent_conn,))
    
    p1.start()
    p2.start()
    
    p1.join()
    p2.join()
```

### Shared Memory

Shared memory allows processes to share data:

```python
import multiprocessing

def worker(shared_value, lock):
    with lock:
        shared_value.value += 1
        print(f"Value: {shared_value.value}")

if __name__ == '__main__':
    shared_value = multiprocessing.Value('i', 0)  # Integer
    lock = multiprocessing.Lock()
    
    processes = []
    for _ in range(5):
        process = multiprocessing.Process(
            target=worker,
            args=(shared_value, lock)
        )
        processes.append(process)
        process.start()
    
    for process in processes:
        process.join()
    
    print(f"Final value: {shared_value.value}")
```

### Shared Array

```python
import multiprocessing

def worker(shared_array, index, value):
    shared_array[index] = value
    print(f"Set index {index} to {value}")

if __name__ == '__main__':
    shared_array = multiprocessing.Array('i', 5)  # Integer array of size 5
    
    processes = []
    for i in range(5):
        process = multiprocessing.Process(
            target=worker,
            args=(shared_array, i, i * 10)
        )
        processes.append(process)
        process.start()
    
    for process in processes:
        process.join()
    
    print(f"Final array: {list(shared_array)}")
```

### Manager

Manager provides shared objects:

```python
import multiprocessing

def worker(shared_dict, shared_list):
    shared_dict['count'] = shared_dict.get('count', 0) + 1
    shared_list.append(multiprocessing.current_process().name)

if __name__ == '__main__':
    with multiprocessing.Manager() as manager:
        shared_dict = manager.dict()
        shared_list = manager.list()
        
        processes = []
        for i in range(3):
            process = multiprocessing.Process(
                target=worker,
                args=(shared_dict, shared_list)
            )
            processes.append(process)
            process.start()
        
        for process in processes:
            process.join()
        
        print(f"Dict: {dict(shared_dict)}")
        print(f"List: {list(shared_list)}")
```

---

## Process Pools

### Using Pool

Process pools manage a pool of worker processes:

```python
import multiprocessing
import time

def worker(x):
    print(f"Processing {x}")
    time.sleep(1)
    return x * x

if __name__ == '__main__':
    with multiprocessing.Pool(processes=4) as pool:
        results = pool.map(worker, range(10))
        print(f"Results: {results}")
```

### Pool.map()

```python
import multiprocessing

def square(x):
    return x * x

if __name__ == '__main__':
    with multiprocessing.Pool() as pool:
        results = pool.map(square, range(10))
        print(results)  # [0, 1, 4, 9, 16, 25, 36, 49, 64, 81]
```

### Pool.apply_async()

```python
import multiprocessing
import time

def worker(name, delay):
    print(f"{name} starting")
    time.sleep(delay)
    return f"{name} finished"

if __name__ == '__main__':
    with multiprocessing.Pool() as pool:
        results = []
        for i in range(5):
            result = pool.apply_async(worker, (f"Worker{i}", 1))
            results.append(result)
        
        # Get results
        for result in results:
            print(result.get())
```

### Pool.imap()

```python
import multiprocessing

def square(x):
    return x * x

if __name__ == '__main__':
    with multiprocessing.Pool() as pool:
        results = pool.imap(square, range(10))
        for result in results:
            print(result)
```

---

## Practical Examples

### Example 1: Parallel Computation

```python
import multiprocessing
import time

def compute_square(n):
    """CPU-bound computation"""
    result = 0
    for i in range(n):
        result += i * i
    return result

if __name__ == '__main__':
    numbers = [1000000, 2000000, 3000000, 4000000]
    
    start = time.time()
    with multiprocessing.Pool() as pool:
        results = pool.map(compute_square, numbers)
    elapsed = time.time() - start
    
    print(f"Results: {results}")
    print(f"Time: {elapsed:.2f}s")
```

### Example 2: File Processing

```python
import multiprocessing
import os

def process_file(filename):
    """Process a single file"""
    print(f"Processing {filename}")
    # Simulate file processing
    time.sleep(1)
    return f"Processed {filename}"

if __name__ == '__main__':
    files = ['file1.txt', 'file2.txt', 'file3.txt', 'file4.txt']
    
    with multiprocessing.Pool() as pool:
        results = pool.map(process_file, files)
    
    for result in results:
        print(result)
```

### Example 3: Data Processing Pipeline

```python
import multiprocessing

def stage1(data):
    return [x * 2 for x in data]

def stage2(data):
    return [x ** 2 for x in data]

def stage3(data):
    return sum(data)

if __name__ == '__main__':
    input_data = list(range(10))
    
    with multiprocessing.Pool() as pool:
        # Stage 1
        stage1_result = pool.map(stage1, [input_data])[0]
        
        # Stage 2
        stage2_result = pool.map(stage2, [stage1_result])[0]
        
        # Stage 3
        final_result = pool.map(stage3, [stage2_result])[0]
    
    print(f"Final result: {final_result}")
```

---

## Common Mistakes and Pitfalls

### 1. Not Using `if __name__ == '__main__'`

```python
# WRONG: Can cause issues on Windows
import multiprocessing

def worker():
    print("Working")

process = multiprocessing.Process(target=worker)
process.start()
process.join()

# CORRECT: Use if __name__ == '__main__'
if __name__ == '__main__':
    process = multiprocessing.Process(target=worker)
    process.start()
    process.join()
```

### 2. Sharing Mutable Objects Incorrectly

```python
# WRONG: Regular list won't work
shared_list = []

def worker():
    shared_list.append(1)  # Won't be shared!

# CORRECT: Use Manager
if __name__ == '__main__':
    with multiprocessing.Manager() as manager:
        shared_list = manager.list()
        process = multiprocessing.Process(target=worker, args=(shared_list,))
        process.start()
        process.join()
```

### 3. Not Joining Processes

```python
# WRONG: Main process may exit before workers finish
process = multiprocessing.Process(target=worker)
process.start()
# Missing process.join()

# CORRECT: Always join
process = multiprocessing.Process(target=worker)
process.start()
process.join()
```

### 4. Using Too Many Processes

```python
# WRONG: Too many processes can hurt performance
processes = []
for _ in range(1000):  # Too many!
    process = multiprocessing.Process(target=worker)
    processes.append(process)
    process.start()

# CORRECT: Use Pool with reasonable number
with multiprocessing.Pool(processes=multiprocessing.cpu_count()) as pool:
    pool.map(worker, tasks)
```

---

## Best Practices

### 1. Always Use `if __name__ == '__main__'`

```python
if __name__ == '__main__':
    # Multiprocessing code here
    pass
```

### 2. Use Process Pools for Similar Tasks

```python
with multiprocessing.Pool() as pool:
    results = pool.map(worker, tasks)
```

### 3. Use Appropriate Communication Method

```python
# For simple data: Queue
q = multiprocessing.Queue()

# For bidirectional: Pipe
parent_conn, child_conn = multiprocessing.Pipe()

# For shared state: Manager
with multiprocessing.Manager() as manager:
    shared_dict = manager.dict()
```

### 4. Limit Number of Processes

```python
# Use CPU count as limit
num_processes = multiprocessing.cpu_count()
with multiprocessing.Pool(processes=num_processes) as pool:
    pool.map(worker, tasks)
```

### 5. Handle Exceptions

```python
def worker():
    try:
        # Work
        pass
    except Exception as e:
        print(f"Error: {e}")
```

---

## Practice Exercise

### Exercise: Multiprocessing

**Objective**: Create a Python program that demonstrates multiprocessing.

**Instructions**:

1. Create a file called `multiprocessing_practice.py`

2. Write a program that:
   - Creates and manages processes
   - Uses process communication
   - Demonstrates process pools
   - Shows practical applications
   - Compares with threading

3. Your program should include:
   - Basic process creation
   - Multiple processes
   - Process communication (Queue, Pipe, Manager)
   - Process pools
   - Real-world examples

**Example Solution**:

```python
"""
Multiprocessing Practice
This program demonstrates multiprocessing in Python.
"""

import multiprocessing
import time
import os

print("=" * 60)
print("MULTIPROCESSING PRACTICE")
print("=" * 60)
print()

# 1. Basic process
print("1. BASIC PROCESS")
print("-" * 60)

def worker(name):
    print(f"Process {name} (PID: {os.getpid()}) starting")
    time.sleep(1)
    print(f"Process {name} finished")

if __name__ == '__main__':
    process = multiprocessing.Process(target=worker, args=("Worker1",))
    process.start()
    process.join()
    print()

# 2. Multiple processes
print("2. MULTIPLE PROCESSES")
print("-" * 60)

def worker(name, delay):
    print(f"Process {name} starting")
    time.sleep(delay)
    print(f"Process {name} finished")

if __name__ == '__main__':
    processes = []
    for i in range(3):
        process = multiprocessing.Process(
            target=worker,
            args=(f"Worker{i}", 1)
        )
        processes.append(process)
        process.start()
    
    for process in processes:
        process.join()
    print()

# 3. Process with class
print("3. PROCESS WITH CLASS")
print("-" * 60)

class WorkerProcess(multiprocessing.Process):
    def __init__(self, name):
        super().__init__(name=name)
    
    def run(self):
        print(f"{self.name} starting")
        time.sleep(1)
        print(f"{self.name} finished")

if __name__ == '__main__':
    process = WorkerProcess("Worker")
    process.start()
    process.join()
    print()

# 4. Queue for communication
print("4. QUEUE FOR COMMUNICATION")
print("-" * 60)

def producer(q):
    for i in range(5):
        print(f"Producing {i}")
        q.put(i)
        time.sleep(0.3)
    q.put(None)

def consumer(q):
    while True:
        item = q.get()
        if item is None:
            break
        print(f"Consuming {item}")

if __name__ == '__main__':
    q = multiprocessing.Queue()
    
    p1 = multiprocessing.Process(target=producer, args=(q,))
    p2 = multiprocessing.Process(target=consumer, args=(q,))
    
    p1.start()
    p2.start()
    
    p1.join()
    p2.join()
    print()

# 5. Pipe for communication
print("5. PIPE FOR COMMUNICATION")
print("-" * 60)

def sender(conn):
    conn.send("Hello from sender")
    conn.close()

def receiver(conn):
    message = conn.recv()
    print(f"Received: {message}")
    conn.close()

if __name__ == '__main__':
    parent_conn, child_conn = multiprocessing.Pipe()
    
    p1 = multiprocessing.Process(target=sender, args=(child_conn,))
    p2 = multiprocessing.Process(target=receiver, args=(parent_conn,))
    
    p1.start()
    p2.start()
    
    p1.join()
    p2.join()
    print()

# 6. Shared memory
print("6. SHARED MEMORY")
print("-" * 60)

def worker(shared_value, lock):
    with lock:
        shared_value.value += 1
        print(f"Value: {shared_value.value}")

if __name__ == '__main__':
    shared_value = multiprocessing.Value('i', 0)
    lock = multiprocessing.Lock()
    
    processes = []
    for _ in range(5):
        process = multiprocessing.Process(
            target=worker,
            args=(shared_value, lock)
        )
        processes.append(process)
        process.start()
    
    for process in processes:
        process.join()
    
    print(f"Final value: {shared_value.value}")
    print()

# 7. Shared array
print("7. SHARED ARRAY")
print("-" * 60)

def worker(shared_array, index, value):
    shared_array[index] = value
    print(f"Set index {index} to {value}")

if __name__ == '__main__':
    shared_array = multiprocessing.Array('i', 5)
    
    processes = []
    for i in range(5):
        process = multiprocessing.Process(
            target=worker,
            args=(shared_array, i, i * 10)
        )
        processes.append(process)
        process.start()
    
    for process in processes:
        process.join()
    
    print(f"Final array: {list(shared_array)}")
    print()

# 8. Manager
print("8. MANAGER")
print("-" * 60)

def worker(shared_dict, shared_list):
    shared_dict['count'] = shared_dict.get('count', 0) + 1
    shared_list.append(multiprocessing.current_process().name)

if __name__ == '__main__':
    with multiprocessing.Manager() as manager:
        shared_dict = manager.dict()
        shared_list = manager.list()
        
        processes = []
        for i in range(3):
            process = multiprocessing.Process(
                target=worker,
                args=(shared_dict, shared_list)
            )
            processes.append(process)
            process.start()
        
        for process in processes:
            process.join()
        
        print(f"Dict: {dict(shared_dict)}")
        print(f"List: {list(shared_list)}")
    print()

# 9. Process pool
print("9. PROCESS POOL")
print("-" * 60)

def square(x):
    return x * x

if __name__ == '__main__':
    with multiprocessing.Pool() as pool:
        results = pool.map(square, range(10))
        print(f"Results: {results}")
    print()

# 10. Real-world: Parallel computation
print("10. REAL-WORLD: PARALLEL COMPUTATION")
print("-" * 60)

def compute_square(n):
    result = 0
    for i in range(n):
        result += i * i
    return result

if __name__ == '__main__':
    numbers = [100000, 200000, 300000, 400000]
    
    start = time.time()
    with multiprocessing.Pool() as pool:
        results = pool.map(compute_square, numbers)
    elapsed = time.time() - start
    
    print(f"Results: {results}")
    print(f"Time: {elapsed:.2f}s")
    print()

print("=" * 60)
print("PRACTICE COMPLETE!")
print("=" * 60)
```

**Expected Output** (truncated):
```
============================================================
MULTIPROCESSING PRACTICE
============================================================

1. BASIC PROCESS
------------------------------------------------------------
Process Worker1 (PID: ...) starting
Process Worker1 finished

[... rest of output ...]
```

**Challenge** (Optional):
- Create a parallel image processing system
- Build a distributed computation system using multiprocessing
- Implement a parallel file search utility
- Create a multiprocessing-based web scraper

---

## Key Takeaways

1. **multiprocessing module** - provides process functionality
2. **Process creation** - using Process class or inheritance
3. **Process vs Thread** - processes for CPU-bound, threads for I/O-bound
4. **Process communication** - Queue, Pipe, Manager, shared memory
5. **Process pools** - manage worker processes efficiently
6. **True parallelism** - bypasses GIL, use multiple CPU cores
7. **Isolation** - processes don't share memory by default
8. **if __name__ == '__main__'** - required for multiprocessing
9. **CPU-bound tasks** - multiprocessing is ideal
10. **I/O-bound tasks** - threading or asyncio may be better
11. **Communication overhead** - processes have more overhead than threads
12. **Best practices** - use pools, limit processes, handle exceptions
13. **When to use** - CPU-bound tasks, need true parallelism
14. **When not to use** - I/O-bound tasks, need shared memory easily
15. **GIL bypass** - each process has its own GIL

---

## Quiz: Multiprocessing

Test your understanding with these questions:

1. **What is multiprocessing used for?**
   - A) Creating threads
   - B) Creating processes
   - C) Creating coroutines
   - D) Creating generators

2. **What is the main advantage of multiprocessing over threading?**
   - A) Shared memory
   - B) True parallelism
   - C) Faster creation
   - D) Less overhead

3. **When should you use multiprocessing?**
   - A) I/O-bound tasks
   - B) CPU-bound tasks
   - C) Both
   - D) Neither

4. **What is required for multiprocessing on Windows?**
   - A) if __name__ == '__main__'
   - B) if __main__
   - C) if main()
   - D) Nothing

5. **What is a Process Pool?**
   - A) A pool of threads
   - B) A pool of worker processes
   - C) A pool of coroutines
   - D) A pool of generators

6. **How do processes communicate?**
   - A) Shared memory
   - B) Queue, Pipe, Manager
   - C) Direct access
   - D) Both A and B

7. **Do processes share memory by default?**
   - A) Yes
   - B) No
   - C) Sometimes
   - D) Only on Linux

8. **What is the GIL in multiprocessing?**
   - A) Shared across processes
   - B) Each process has its own GIL
   - C) No GIL
   - D) Only in main process

9. **What is faster to create?**
   - A) Process
   - B) Thread
   - C) Same
   - D) Depends

10. **What has more overhead?**
    - A) Process
    - B) Thread
    - C) Same
    - D) Depends

**Answers**:
1. B) Creating processes (multiprocessing purpose)
2. B) True parallelism (main advantage)
3. B) CPU-bound tasks (when to use multiprocessing)
4. A) if __name__ == '__main__' (required on Windows)
5. B) A pool of worker processes (Process Pool definition)
6. D) Both A and B (process communication methods)
7. B) No (processes don't share memory by default)
8. B) Each process has its own GIL (GIL in multiprocessing)
9. B) Thread (threads are faster to create)
10. A) Process (processes have more overhead)

---

## Next Steps

Excellent work! You've mastered multiprocessing. You now understand:
- The multiprocessing module
- Process vs Thread
- Process communication
- Process pools

**What's Next?**
- Lesson 16.3: Asynchronous Programming
- Learn async/await syntax
- Understand asyncio module
- Explore coroutines and event loops

---

## Additional Resources

- **multiprocessing**: [docs.python.org/3/library/multiprocessing.html](https://docs.python.org/3/library/multiprocessing.html)
- **Process vs Thread**: [docs.python.org/3/library/threading.html](https://docs.python.org/3/library/threading.html)
- **GIL**: [wiki.python.org/moin/GlobalInterpreterLock](https://wiki.python.org/moin/GlobalInterpreterLock)

---

*Lesson completed! You're ready to move on to the next lesson.*

