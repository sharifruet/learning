# Lesson 25.3: Behavioral Patterns

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand behavioral design patterns
- Implement the Observer pattern
- Implement the Strategy pattern
- Implement the Command pattern
- Recognize when to use each pattern
- Apply behavioral patterns in real-world scenarios
- Combine patterns effectively
- Choose appropriate patterns for problems
- Debug pattern-related issues

---

## Introduction to Behavioral Patterns

**Behavioral Patterns** focus on communication between objects and how they operate together. They deal with algorithms and the assignment of responsibilities between objects.

**Key Behavioral Patterns**:
- **Observer**: Notify multiple objects about state changes
- **Strategy**: Define a family of algorithms and make them interchangeable
- **Command**: Encapsulate requests as objects
- **Chain of Responsibility**: Pass requests along a chain of handlers
- **State**: Allow object to alter behavior when internal state changes
- **Template Method**: Define algorithm skeleton in base class
- **Iterator**: Provide a way to access elements sequentially
- **Mediator**: Define how objects interact
- **Memento**: Capture and restore object state
- **Visitor**: Separate algorithm from object structure

**Benefits**:
- **Flexibility**: Easier to modify behavior
- **Reusability**: Behaviors can be reused
- **Maintainability**: Easier to maintain
- **Decoupling**: Reduces dependencies between objects

---

## Observer Pattern

### Concept

The **Observer** pattern defines a one-to-many dependency between objects so that when one object changes state, all its dependents are notified and updated automatically.

**Use Cases**:
- Event handling systems
- Model-View-Controller (MVC) architecture
- Publish-Subscribe systems
- Real-time data updates
- Notification systems

### Basic Observer

```python
from abc import ABC, abstractmethod

# Subject (Observable)
class Subject(ABC):
    def __init__(self):
        self._observers = []
    
    def attach(self, observer):
        """Attach an observer."""
        if observer not in self._observers:
            self._observers.append(observer)
    
    def detach(self, observer):
        """Detach an observer."""
        self._observers.remove(observer)
    
    def notify(self, event=None):
        """Notify all observers."""
        for observer in self._observers:
            observer.update(event)

# Observer
class Observer(ABC):
    @abstractmethod
    def update(self, event):
        pass

# Concrete Subject
class NewsAgency(Subject):
    def __init__(self):
        super().__init__()
        self._news = None
    
    def set_news(self, news):
        self._news = news
        self.notify(self._news)
    
    def get_news(self):
        return self._news

# Concrete Observers
class NewsChannel(Observer):
    def __init__(self, name):
        self.name = name
        self.news = None
    
    def update(self, event):
        self.news = event
        print(f"{self.name} received news: {event}")

# Usage
agency = NewsAgency()
channel1 = NewsChannel("CNN")
channel2 = NewsChannel("BBC")

agency.attach(channel1)
agency.attach(channel2)

agency.set_news("Breaking: Python 4.0 released!")
# CNN received news: Breaking: Python 4.0 released!
# BBC received news: Breaking: Python 4.0 released!
```

### Observer with Event Data

```python
class Event:
    """Event data class."""
    def __init__(self, event_type, data):
        self.event_type = event_type
        self.data = data
        self.timestamp = None
        import datetime
        self.timestamp = datetime.datetime.now()
    
    def __str__(self):
        return f"{self.event_type}: {self.data} at {self.timestamp}"

class StockMarket(Subject):
    def __init__(self):
        super().__init__()
        self._price = 100.0
    
    def set_price(self, price):
        old_price = self._price
        self._price = price
        event = Event("price_change", {
            'old_price': old_price,
            'new_price': price,
            'change': price - old_price
        })
        self.notify(event)
    
    def get_price(self):
        return self._price

class StockDisplay(Observer):
    def __init__(self, name):
        self.name = name
    
    def update(self, event):
        if event.event_type == "price_change":
            data = event.data
            print(f"{self.name}: Stock price changed from "
                  f"${data['old_price']:.2f} to ${data['new_price']:.2f} "
                  f"(change: ${data['change']:.2f})")

class StockAlert(Observer):
    def __init__(self, threshold=5.0):
        self.threshold = threshold
    
    def update(self, event):
        if event.event_type == "price_change":
            change = abs(event.data['change'])
            if change >= self.threshold:
                print(f"ALERT: Significant price change of ${change:.2f}!")

# Usage
market = StockMarket()
display = StockDisplay("Ticker")
alert = StockAlert(threshold=5.0)

market.attach(display)
market.attach(alert)

market.set_price(105.0)  # Small change
market.set_price(112.0)  # Large change - triggers alert
```

### Practical Example: Weather Station

```python
class WeatherData(Subject):
    def __init__(self):
        super().__init__()
        self._temperature = None
        self._humidity = None
        self._pressure = None
    
    def set_measurements(self, temperature, humidity, pressure):
        self._temperature = temperature
        self._humidity = humidity
        self._pressure = pressure
        self.notify()
    
    def get_temperature(self):
        return self._temperature
    
    def get_humidity(self):
        return self._humidity
    
    def get_pressure(self):
        return self._pressure

class CurrentConditionsDisplay(Observer):
    def __init__(self, weather_data):
        self.weather_data = weather_data
        self.weather_data.attach(self)
        self.temperature = None
        self.humidity = None
    
    def update(self, event=None):
        self.temperature = self.weather_data.get_temperature()
        self.humidity = self.weather_data.get_humidity()
        self.display()
    
    def display(self):
        print(f"Current conditions: {self.temperature}°F "
              f"and {self.humidity}% humidity")

class StatisticsDisplay(Observer):
    def __init__(self, weather_data):
        self.weather_data = weather_data
        self.weather_data.attach(self)
        self.temps = []
    
    def update(self, event=None):
        temp = self.weather_data.get_temperature()
        self.temps.append(temp)
        self.display()
    
    def display(self):
        if self.temps:
            avg = sum(self.temps) / len(self.temps)
            max_temp = max(self.temps)
            min_temp = min(self.temps)
            print(f"Avg/Max/Min temperature: "
                  f"{avg:.1f}/{max_temp:.1f}/{min_temp:.1f}°F")

class ForecastDisplay(Observer):
    def __init__(self, weather_data):
        self.weather_data = weather_data
        self.weather_data.attach(self)
        self.current_pressure = None
        self.last_pressure = None
    
    def update(self, event=None):
        self.last_pressure = self.current_pressure
        self.current_pressure = self.weather_data.get_pressure()
        self.display()
    
    def display(self):
        if self.last_pressure is None:
            print("Forecast: More of the same")
        elif self.current_pressure > self.last_pressure:
            print("Forecast: Improving weather on the way!")
        elif self.current_pressure < self.last_pressure:
            print("Forecast: Watch out for cooler, rainy weather")
        else:
            print("Forecast: More of the same")

# Usage
weather_data = WeatherData()
current_display = CurrentConditionsDisplay(weather_data)
statistics_display = StatisticsDisplay(weather_data)
forecast_display = ForecastDisplay(weather_data)

weather_data.set_measurements(80, 65, 30.4)
weather_data.set_measurements(82, 70, 29.2)
weather_data.set_measurements(78, 90, 29.2)
```

---

## Strategy Pattern

### Concept

The **Strategy** pattern defines a family of algorithms, encapsulates each one, and makes them interchangeable. Strategy lets the algorithm vary independently from clients that use it.

**Use Cases**:
- Multiple ways to perform a task
- Algorithm selection at runtime
- Replacing conditionals with polymorphism
- Payment processing
- Sorting algorithms
- Compression algorithms

### Basic Strategy

```python
from abc import ABC, abstractmethod

# Strategy interface
class PaymentStrategy(ABC):
    @abstractmethod
    def pay(self, amount):
        pass

# Concrete strategies
class CreditCardPayment(PaymentStrategy):
    def __init__(self, card_number, cvv):
        self.card_number = card_number
        self.cvv = cvv
    
    def pay(self, amount):
        return f"Paid ${amount:.2f} using Credit Card ending in {self.card_number[-4:]}"

class PayPalPayment(PaymentStrategy):
    def __init__(self, email):
        self.email = email
    
    def pay(self, amount):
        return f"Paid ${amount:.2f} using PayPal account {self.email}"

class BankTransferPayment(PaymentStrategy):
    def __init__(self, account_number):
        self.account_number = account_number
    
    def pay(self, amount):
        return f"Paid ${amount:.2f} via Bank Transfer to account {self.account_number}"

# Context
class PaymentProcessor:
    def __init__(self, strategy: PaymentStrategy):
        self.strategy = strategy
    
    def set_strategy(self, strategy: PaymentStrategy):
        """Change strategy at runtime."""
        self.strategy = strategy
    
    def process_payment(self, amount):
        return self.strategy.pay(amount)

# Usage
processor = PaymentProcessor(CreditCardPayment("1234567890123456", "123"))
print(processor.process_payment(100.00))

processor.set_strategy(PayPalPayment("user@example.com"))
print(processor.process_payment(50.00))
```

### Strategy with Factory

```python
class PaymentStrategyFactory:
    """Factory for creating payment strategies."""
    
    @staticmethod
    def create_strategy(payment_type, **kwargs):
        strategies = {
            'credit_card': CreditCardPayment,
            'paypal': PayPalPayment,
            'bank_transfer': BankTransferPayment
        }
        
        strategy_class = strategies.get(payment_type.lower())
        if strategy_class:
            return strategy_class(**kwargs)
        else:
            raise ValueError(f"Unknown payment type: {payment_type}")

# Usage
strategy = PaymentStrategyFactory.create_strategy(
    'credit_card',
    card_number='1234567890123456',
    cvv='123'
)
processor = PaymentProcessor(strategy)
print(processor.process_payment(100.00))
```

### Practical Example: Sorting Strategies

```python
from abc import ABC, abstractmethod

class SortStrategy(ABC):
    @abstractmethod
    def sort(self, data):
        pass

class BubbleSortStrategy(SortStrategy):
    def sort(self, data):
        """Bubble sort algorithm."""
        arr = data.copy()
        n = len(arr)
        for i in range(n):
            for j in range(0, n - i - 1):
                if arr[j] > arr[j + 1]:
                    arr[j], arr[j + 1] = arr[j + 1], arr[j]
        return arr

class QuickSortStrategy(SortStrategy):
    def sort(self, data):
        """Quick sort algorithm."""
        if len(data) <= 1:
            return data
        pivot = data[len(data) // 2]
        left = [x for x in data if x < pivot]
        middle = [x for x in data if x == pivot]
        right = [x for x in data if x > pivot]
        return self.sort(left) + middle + self.sort(right)

class MergeSortStrategy(SortStrategy):
    def sort(self, data):
        """Merge sort algorithm."""
        if len(data) <= 1:
            return data
        
        mid = len(data) // 2
        left = self.sort(data[:mid])
        right = self.sort(data[mid:])
        
        return self._merge(left, right)
    
    def _merge(self, left, right):
        result = []
        i = j = 0
        
        while i < len(left) and j < len(right):
            if left[i] <= right[j]:
                result.append(left[i])
                i += 1
            else:
                result.append(right[j])
                j += 1
        
        result.extend(left[i:])
        result.extend(right[j:])
        return result

class Sorter:
    """Context that uses sorting strategies."""
    
    def __init__(self, strategy: SortStrategy = None):
        self.strategy = strategy or QuickSortStrategy()
    
    def set_strategy(self, strategy: SortStrategy):
        """Change sorting strategy."""
        self.strategy = strategy
    
    def sort(self, data):
        """Sort data using current strategy."""
        return self.strategy.sort(data)

# Usage
data = [64, 34, 25, 12, 22, 11, 90]

sorter = Sorter(BubbleSortStrategy())
print("Bubble Sort:", sorter.sort(data))

sorter.set_strategy(QuickSortStrategy())
print("Quick Sort:", sorter.sort(data))

sorter.set_strategy(MergeSortStrategy())
print("Merge Sort:", sorter.sort(data))
```

---

## Command Pattern

### Concept

The **Command** pattern encapsulates a request as an object, thereby allowing you to parameterize clients with different requests, queue requests, and support undo operations.

**Use Cases**:
- Undo/redo functionality
- Macro recording
- Queue operations
- Logging requests
- Transaction systems
- Remote procedure calls

### Basic Command

```python
from abc import ABC, abstractmethod

# Command interface
class Command(ABC):
    @abstractmethod
    def execute(self):
        pass
    
    @abstractmethod
    def undo(self):
        pass

# Receiver
class Light:
    def __init__(self, location):
        self.location = location
        self.is_on = False
    
    def turn_on(self):
        self.is_on = True
        print(f"{self.location} light is ON")
    
    def turn_off(self):
        self.is_on = False
        print(f"{self.location} light is OFF")

# Concrete commands
class LightOnCommand(Command):
    def __init__(self, light):
        self.light = light
    
    def execute(self):
        self.light.turn_on()
    
    def undo(self):
        self.light.turn_off()

class LightOffCommand(Command):
    def __init__(self, light):
        self.light = light
    
    def execute(self):
        self.light.turn_off()
    
    def undo(self):
        self.light.turn_on()

# Invoker
class RemoteControl:
    def __init__(self):
        self.command = None
        self.history = []
    
    def set_command(self, command: Command):
        self.command = command
    
    def press_button(self):
        if self.command:
            self.command.execute()
            self.history.append(self.command)
    
    def press_undo(self):
        if self.history:
            command = self.history.pop()
            command.undo()

# Usage
living_room_light = Light("Living Room")
kitchen_light = Light("Kitchen")

living_room_on = LightOnCommand(living_room_light)
living_room_off = LightOffCommand(living_room_light)

remote = RemoteControl()

remote.set_command(living_room_on)
remote.press_button()

remote.set_command(living_room_off)
remote.press_button()

remote.press_undo()  # Undo last command
```

### Command with Parameters

```python
class TextEditor:
    """Receiver for text editing commands."""
    
    def __init__(self):
        self.text = ""
        self.cursor_position = 0
    
    def insert_text(self, text, position=None):
        if position is None:
            position = self.cursor_position
        self.text = self.text[:position] + text + self.text[position:]
        self.cursor_position = position + len(text)
        return position, text
    
    def delete_text(self, start, length):
        deleted = self.text[start:start + length]
        self.text = self.text[:start] + self.text[start + length:]
        if self.cursor_position > start:
            self.cursor_position = max(start, self.cursor_position - length)
        return start, deleted
    
    def get_text(self):
        return self.text

class InsertCommand(Command):
    def __init__(self, editor, text, position=None):
        self.editor = editor
        self.text = text
        self.position = position
        self.executed_position = None
    
    def execute(self):
        self.executed_position, _ = self.editor.insert_text(self.text, self.position)
    
    def undo(self):
        if self.executed_position is not None:
            self.editor.delete_text(self.executed_position, len(self.text))

class DeleteCommand(Command):
    def __init__(self, editor, start, length):
        self.editor = editor
        self.start = start
        self.length = length
        self.deleted_text = None
    
    def execute(self):
        self.start, self.deleted_text = self.editor.delete_text(self.start, self.length)
    
    def undo(self):
        if self.deleted_text:
            self.editor.insert_text(self.deleted_text, self.start)

class CommandHistory:
    """Manages command history for undo/redo."""
    
    def __init__(self):
        self.undo_stack = []
        self.redo_stack = []
    
    def execute_command(self, command: Command):
        command.execute()
        self.undo_stack.append(command)
        self.redo_stack.clear()  # Clear redo stack when new command executed
    
    def undo(self):
        if self.undo_stack:
            command = self.undo_stack.pop()
            command.undo()
            self.redo_stack.append(command)
    
    def redo(self):
        if self.redo_stack:
            command = self.redo_stack.pop()
            command.execute()
            self.undo_stack.append(command)

# Usage
editor = TextEditor()
history = CommandHistory()

history.execute_command(InsertCommand(editor, "Hello"))
history.execute_command(InsertCommand(editor, " World"))
print(editor.get_text())  # "Hello World"

history.undo()
print(editor.get_text())  # "Hello"

history.redo()
print(editor.get_text())  # "Hello World"
```

### Practical Example: Calculator with Undo

```python
class Calculator:
    """Receiver for calculator operations."""
    
    def __init__(self):
        self.value = 0
    
    def add(self, value):
        self.value += value
        return self.value
    
    def subtract(self, value):
        self.value -= value
        return self.value
    
    def multiply(self, value):
        self.value *= value
        return self.value
    
    def divide(self, value):
        if value == 0:
            raise ValueError("Cannot divide by zero")
        self.value /= value
        return self.value
    
    def get_value(self):
        return self.value

class AddCommand(Command):
    def __init__(self, calculator, value):
        self.calculator = calculator
        self.value = value
    
    def execute(self):
        return self.calculator.add(self.value)
    
    def undo(self):
        return self.calculator.subtract(self.value)

class SubtractCommand(Command):
    def __init__(self, calculator, value):
        self.calculator = calculator
        self.value = value
    
    def execute(self):
        return self.calculator.subtract(self.value)
    
    def undo(self):
        return self.calculator.add(self.value)

class MultiplyCommand(Command):
    def __init__(self, calculator, value):
        self.calculator = calculator
        self.value = value
        self.previous_value = None
    
    def execute(self):
        self.previous_value = self.calculator.get_value()
        return self.calculator.multiply(self.value)
    
    def undo(self):
        if self.previous_value is not None:
            self.calculator.value = self.previous_value

class DivideCommand(Command):
    def __init__(self, calculator, value):
        self.calculator = calculator
        self.value = value
        self.previous_value = None
    
    def execute(self):
        self.previous_value = self.calculator.get_value()
        return self.calculator.divide(self.value)
    
    def undo(self):
        if self.previous_value is not None:
            self.calculator.value = self.previous_value

# Usage
calc = Calculator()
history = CommandHistory()

history.execute_command(AddCommand(calc, 10))
print(f"Value: {calc.get_value()}")  # 10

history.execute_command(MultiplyCommand(calc, 3))
print(f"Value: {calc.get_value()}")  # 30

history.execute_command(SubtractCommand(calc, 5))
print(f"Value: {calc.get_value()}")  # 25

history.undo()
print(f"Value: {calc.get_value()}")  # 30

history.undo()
print(f"Value: {calc.get_value()}")  # 10

history.redo()
print(f"Value: {calc.get_value()}")  # 30
```

---

## Pattern Comparison

### When to Use Observer

```python
# Use Observer when:
# - Changes to one object require changing others
# - You don't know how many objects need to be notified
# - You want to decouple objects

class EventSystem(Subject):
    # Many observers can subscribe
    # Changes automatically notify all
    pass
```

### When to Use Strategy

```python
# Use Strategy when:
# - You have multiple ways to do something
# - You want to switch algorithms at runtime
# - You want to avoid conditional statements

class PaymentProcessor:
    # Can switch between payment methods
    # Each method is a strategy
    pass
```

### When to Use Command

```python
# Use Command when:
# - You need undo/redo functionality
# - You want to queue operations
# - You want to log operations

class TextEditor:
    # Commands can be undone
    # Commands can be queued
    # Commands can be logged
    pass
```

---

## Practical Examples

### Example 1: Complete Observer Implementation

```python
class EventBus(Subject):
    """Event bus for publish-subscribe pattern."""
    
    def __init__(self):
        super().__init__()
        self._events = {}
    
    def publish(self, event_type, data):
        """Publish an event."""
        event = {
            'type': event_type,
            'data': data,
            'timestamp': None
        }
        import datetime
        event['timestamp'] = datetime.datetime.now()
        self.notify(event)
    
    def subscribe(self, event_type, observer):
        """Subscribe to specific event type."""
        if event_type not in self._events:
            self._events[event_type] = []
        self._events[event_type].append(observer)
        self.attach(observer)
    
    def unsubscribe(self, event_type, observer):
        """Unsubscribe from event type."""
        if event_type in self._events:
            self._events[event_type].remove(observer)
        self.detach(observer)

class EventHandler(Observer):
    def __init__(self, name, event_types=None):
        self.name = name
        self.event_types = event_types or []
        self.handled_events = []
    
    def update(self, event):
        if not self.event_types or event['type'] in self.event_types:
            self.handle(event)
    
    def handle(self, event):
        self.handled_events.append(event)
        print(f"{self.name} handled {event['type']}: {event['data']}")

# Usage
bus = EventBus()

handler1 = EventHandler("Handler1", ["user_created", "user_updated"])
handler2 = EventHandler("Handler2", ["order_placed"])

bus.subscribe("user_created", handler1)
bus.subscribe("user_updated", handler1)
bus.subscribe("order_placed", handler2)

bus.publish("user_created", {"user_id": 1, "name": "Alice"})
bus.publish("order_placed", {"order_id": 1, "amount": 100})
```

### Example 2: Complete Strategy Implementation

```python
class CompressionStrategy(ABC):
    @abstractmethod
    def compress(self, data):
        pass
    
    @abstractmethod
    def decompress(self, data):
        pass

class ZipCompression(CompressionStrategy):
    def compress(self, data):
        import zipfile
        import io
        buffer = io.BytesIO()
        with zipfile.ZipFile(buffer, 'w') as zip_file:
            zip_file.writestr('data', data)
        return buffer.getvalue()
    
    def decompress(self, data):
        import zipfile
        import io
        with zipfile.ZipFile(io.BytesIO(data), 'r') as zip_file:
            return zip_file.read('data').decode()

class GzipCompression(CompressionStrategy):
    def compress(self, data):
        import gzip
        return gzip.compress(data.encode())
    
    def decompress(self, data):
        import gzip
        return gzip.decompress(data).decode()

class FileCompressor:
    def __init__(self, strategy: CompressionStrategy):
        self.strategy = strategy
    
    def set_strategy(self, strategy: CompressionStrategy):
        self.strategy = strategy
    
    def compress_file(self, filename, output_filename):
        with open(filename, 'r') as f:
            data = f.read()
        compressed = self.strategy.compress(data)
        with open(output_filename, 'wb') as f:
            f.write(compressed)
    
    def decompress_file(self, filename, output_filename):
        with open(filename, 'rb') as f:
            data = f.read()
        decompressed = self.strategy.decompress(data)
        with open(output_filename, 'w') as f:
            f.write(decompressed)

# Usage
compressor = FileCompressor(ZipCompression())
# compressor.compress_file("data.txt", "data.zip")

compressor.set_strategy(GzipCompression())
# compressor.compress_file("data.txt", "data.gz")
```

### Example 3: Complete Command Implementation

```python
class FileOperation(ABC):
    @abstractmethod
    def execute(self):
        pass
    
    @abstractmethod
    def undo(self):
        pass

class CreateFileCommand(FileOperation):
    def __init__(self, filename, content=""):
        self.filename = filename
        self.content = content
        self.created = False
    
    def execute(self):
        import os
        if not os.path.exists(self.filename):
            with open(self.filename, 'w') as f:
                f.write(self.content)
            self.created = True
            print(f"Created file: {self.filename}")
        else:
            print(f"File already exists: {self.filename}")
    
    def undo(self):
        import os
        if self.created and os.path.exists(self.filename):
            os.remove(self.filename)
            print(f"Deleted file: {self.filename}")
            self.created = False

class WriteFileCommand(FileOperation):
    def __init__(self, filename, content):
        self.filename = filename
        self.content = content
        self.old_content = None
    
    def execute(self):
        import os
        if os.path.exists(self.filename):
            with open(self.filename, 'r') as f:
                self.old_content = f.read()
        with open(self.filename, 'w') as f:
            f.write(self.content)
        print(f"Wrote to file: {self.filename}")
    
    def undo(self):
        if self.old_content is not None:
            with open(self.filename, 'w') as f:
                f.write(self.old_content)
            print(f"Restored file: {self.filename}")

class FileManager:
    """Invoker for file operations."""
    
    def __init__(self):
        self.history = CommandHistory()
    
    def execute(self, command: FileOperation):
        self.history.execute_command(command)
    
    def undo(self):
        self.history.undo()
    
    def redo(self):
        self.history.redo()

# Usage
manager = FileManager()

manager.execute(CreateFileCommand("test.txt", "Hello"))
manager.execute(WriteFileCommand("test.txt", "Hello World"))
manager.undo()  # Restore "Hello"
manager.undo()  # Delete file
manager.redo()  # Create file again
```

---

## Common Mistakes and Pitfalls

### Observer Issues

```python
# WRONG: Observer holds reference to subject
class Observer:
    def __init__(self, subject):
        self.subject = subject  # Strong reference!
        # Subject can't be garbage collected

# CORRECT: Use weak references or detach properly
import weakref

class Observer:
    def __init__(self, subject):
        self.subject_ref = weakref.ref(subject)
```

### Strategy Issues

```python
# WRONG: Strategy with state
class Strategy:
    def __init__(self):
        self.state = {}  # State in strategy!
    
    def execute(self):
        # Uses self.state - not thread-safe!

# CORRECT: Stateless strategies or pass state
class Strategy:
    def execute(self, state):
        # Use passed state
        pass
```

---

## Best Practices

### 1. Use Weak References for Observers

```python
import weakref

class Subject:
    def __init__(self):
        self._observers = weakref.WeakSet()
```

### 2. Keep Strategies Stateless

```python
# Strategies should be stateless
# Pass any needed data as parameters
```

### 3. Implement Undo Carefully

```python
# Store enough state to undo
# Consider memory usage
# Handle edge cases
```

---

## Practice Exercise

### Exercise: Behavioral Patterns

**Objective**: Implement behavioral patterns in a practical scenario.

**Requirements**:

1. Create a system using behavioral patterns:
   - Observer for event notifications
   - Strategy for different algorithms
   - Command for operations with undo

2. Scenario: Task management system
   - Observer for task status changes
   - Strategy for different task prioritization algorithms
   - Command for task operations (add, update, delete) with undo

**Example Solution**:

```python
"""
Task Management System with Behavioral Patterns
"""

from abc import ABC, abstractmethod
from enum import Enum
from datetime import datetime

# Observer Pattern: Task Status Notifications
class TaskStatus(Enum):
    PENDING = "pending"
    IN_PROGRESS = "in_progress"
    COMPLETED = "completed"
    CANCELLED = "cancelled"

class Task(Subject):
    """Task subject that notifies observers of status changes."""
    
    def __init__(self, id, title, description=""):
        super().__init__()
        self.id = id
        self.title = title
        self.description = description
        self.status = TaskStatus.PENDING
        self.created_at = datetime.now()
        self.updated_at = datetime.now()
    
    def set_status(self, status):
        old_status = self.status
        self.status = status
        self.updated_at = datetime.now()
        self.notify({
            'task_id': self.id,
            'old_status': old_status,
            'new_status': status,
            'timestamp': self.updated_at
        })
    
    def __str__(self):
        return f"Task {self.id}: {self.title} [{self.status.value}]"

class TaskObserver(Observer):
    """Observer for task status changes."""
    
    def __init__(self, name):
        self.name = name
        self.notifications = []
    
    def update(self, event):
        self.notifications.append(event)
        print(f"{self.name} notified: Task {event['task_id']} changed from "
              f"{event['old_status'].value} to {event['new_status'].value}")

# Strategy Pattern: Task Prioritization
class PrioritizationStrategy(ABC):
    @abstractmethod
    def prioritize(self, tasks):
        """Sort tasks by priority."""
        pass

class PriorityByStatusStrategy(PrioritizationStrategy):
    """Prioritize by status (in_progress > pending > completed > cancelled)."""
    
    def prioritize(self, tasks):
        status_order = {
            TaskStatus.IN_PROGRESS: 1,
            TaskStatus.PENDING: 2,
            TaskStatus.COMPLETED: 3,
            TaskStatus.CANCELLED: 4
        }
        return sorted(tasks, key=lambda t: status_order.get(t.status, 5))

class PriorityByDateStrategy(PrioritizationStrategy):
    """Prioritize by creation date (oldest first)."""
    
    def prioritize(self, tasks):
        return sorted(tasks, key=lambda t: t.created_at)

class PriorityByUpdateStrategy(PrioritizationStrategy):
    """Prioritize by last update (most recently updated first)."""
    
    def prioritize(self, tasks):
        return sorted(tasks, key=lambda t: t.updated_at, reverse=True)

class TaskManager:
    """Context that uses prioritization strategies."""
    
    def __init__(self, strategy: PrioritizationStrategy = None):
        self.tasks = []
        self.strategy = strategy or PriorityByStatusStrategy()
    
    def set_strategy(self, strategy: PrioritizationStrategy):
        """Change prioritization strategy."""
        self.strategy = strategy
    
    def add_task(self, task: Task):
        """Add a task."""
        self.tasks.append(task)
    
    def get_prioritized_tasks(self):
        """Get tasks sorted by current strategy."""
        return self.strategy.prioritize(self.tasks)

# Command Pattern: Task Operations
class TaskCommand(Command):
    """Base command for task operations."""
    
    def __init__(self, task_manager: TaskManager):
        self.task_manager = task_manager

class AddTaskCommand(TaskCommand):
    """Command to add a task."""
    
    def __init__(self, task_manager, task_id, title, description=""):
        super().__init__(task_manager)
        self.task = Task(task_id, title, description)
        self.added = False
    
    def execute(self):
        self.task_manager.add_task(self.task)
        self.added = True
        print(f"Added: {self.task}")
        return self.task
    
    def undo(self):
        if self.added and self.task in self.task_manager.tasks:
            self.task_manager.tasks.remove(self.task)
            print(f"Removed: {self.task}")

class UpdateTaskStatusCommand(TaskCommand):
    """Command to update task status."""
    
    def __init__(self, task_manager, task_id, new_status):
        super().__init__(task_manager)
        self.task_id = task_id
        self.new_status = new_status
        self.old_status = None
        self.task = None
    
    def execute(self):
        self.task = next((t for t in self.task_manager.tasks if t.id == self.task_id), None)
        if self.task:
            self.old_status = self.task.status
            self.task.set_status(self.new_status)
            print(f"Updated task {self.task_id} status to {self.new_status.value}")
        return self.task
    
    def undo(self):
        if self.task and self.old_status:
            self.task.set_status(self.old_status)
            print(f"Reverted task {self.task_id} status to {self.old_status.value}")

class DeleteTaskCommand(TaskCommand):
    """Command to delete a task."""
    
    def __init__(self, task_manager, task_id):
        super().__init__(task_manager)
        self.task_id = task_id
        self.task = None
        self.deleted = False
    
    def execute(self):
        self.task = next((t for t in self.task_manager.tasks if t.id == self.task_id), None)
        if self.task:
            self.task_manager.tasks.remove(self.task)
            self.deleted = True
            print(f"Deleted: {self.task}")
        return self.task
    
    def undo(self):
        if self.deleted and self.task:
            self.task_manager.tasks.append(self.task)
            print(f"Restored: {self.task}")

class CommandHistory:
    """Manages command history."""
    
    def __init__(self):
        self.undo_stack = []
        self.redo_stack = []
    
    def execute(self, command: Command):
        command.execute()
        self.undo_stack.append(command)
        self.redo_stack.clear()
    
    def undo(self):
        if self.undo_stack:
            command = self.undo_stack.pop()
            command.undo()
            self.redo_stack.append(command)
    
    def redo(self):
        if self.redo_stack:
            command = self.redo_stack.pop()
            command.execute()
            self.undo_stack.append(command)

# Complete System
def main():
    # Create task manager with strategy
    task_manager = TaskManager(PriorityByStatusStrategy())
    history = CommandHistory()
    
    # Create observers
    logger = TaskObserver("Logger")
    notifier = TaskObserver("Notifier")
    
    # Add tasks using commands
    history.execute(AddTaskCommand(task_manager, 1, "Design database", "Design schema"))
    history.execute(AddTaskCommand(task_manager, 2, "Write tests", "Unit tests"))
    history.execute(AddTaskCommand(task_manager, 3, "Deploy application", "Production deploy"))
    
    # Attach observers to tasks
    for task in task_manager.tasks:
        task.attach(logger)
        task.attach(notifier)
    
    # Update task status (triggers observers)
    history.execute(UpdateTaskStatusCommand(task_manager, 1, TaskStatus.IN_PROGRESS))
    history.execute(UpdateTaskStatusCommand(task_manager, 2, TaskStatus.COMPLETED))
    
    # Show prioritized tasks
    print("\nTasks prioritized by status:")
    for task in task_manager.get_prioritized_tasks():
        print(f"  {task}")
    
    # Change strategy
    task_manager.set_strategy(PriorityByDateStrategy())
    print("\nTasks prioritized by date:")
    for task in task_manager.get_prioritized_tasks():
        print(f"  {task}")
    
    # Undo operations
    print("\nUndoing last operation:")
    history.undo()
    
    print("\nUndoing another operation:")
    history.undo()
    
    print("\nRedoing:")
    history.redo()

if __name__ == '__main__':
    main()
```

**Expected Output**: A complete task management system demonstrating all three behavioral patterns.

**Challenge** (Optional):
- Add more observers (email, SMS)
- Add more strategies (priority by title, by description length)
- Add more commands (update title, update description)
- Add command batching (macro commands)
- Add persistent command history

---

## Key Takeaways

1. **Behavioral Patterns** - Focus on communication between objects
2. **Observer** - Notify multiple objects about state changes
3. **Strategy** - Define interchangeable algorithms
4. **Command** - Encapsulate requests as objects
5. **Observer Benefits** - Decoupling, flexibility, one-to-many dependency
6. **Strategy Benefits** - Runtime algorithm selection, avoid conditionals
7. **Command Benefits** - Undo/redo, queuing, logging, macro recording
8. **When to Use** - Each pattern has specific use cases
9. **Pattern Combinations** - Patterns can work together
10. **Best Practices** - Weak references, stateless strategies, careful undo
11. **Common Mistakes** - Strong references, stateful strategies
12. **Real-World Applications** - Event systems, payment processing, text editors
13. **Flexibility** - Patterns provide flexibility and extensibility
14. **Maintainability** - Patterns improve code maintainability
15. **Learning** - Study existing pattern implementations

---

## Quiz: Behavioral Patterns

Test your understanding with these questions:

1. **What does Observer pattern do?**
   - A) Encapsulates requests
   - B) Notifies objects about changes
   - C) Defines algorithms
   - D) Creates objects

2. **What does Strategy pattern do?**
   - A) Notifies objects
   - B) Defines interchangeable algorithms
   - C) Encapsulates requests
   - D) Creates objects

3. **What does Command pattern do?**
   - A) Notifies objects
   - B) Defines algorithms
   - C) Encapsulates requests as objects
   - D) Creates objects

4. **Observer relationship is:**
   - A) One-to-one
   - B) One-to-many
   - C) Many-to-one
   - D) Many-to-many

5. **Strategy allows:**
   - A) Runtime algorithm selection
   - B) Compile-time selection
   - C) Static selection
   - D) No selection

6. **Command enables:**
   - A) Undo/redo
   - B) Queuing
   - C) Logging
   - D) All of the above

7. **When to use Observer?**
   - A) Event handling
   - B) MVC architecture
   - C) Publish-subscribe
   - D) All of the above

8. **When to use Strategy?**
   - A) Multiple algorithms
   - B) Runtime selection
   - C) Avoid conditionals
   - D) All of the above

9. **When to use Command?**
   - A) Undo/redo needed
   - B) Queue operations
   - C) Log operations
   - D) All of the above

10. **Patterns can be:**
    - A) Combined
    - B) Used separately
    - C) Nested
    - D) All of the above

**Answers**:
1. B) Notifies objects about changes (Observer)
2. B) Defines interchangeable algorithms (Strategy)
3. C) Encapsulates requests as objects (Command)
4. B) One-to-many (Observer relationship)
5. A) Runtime algorithm selection (Strategy)
6. D) All of the above (Command features)
7. D) All of the above (Observer use cases)
8. D) All of the above (Strategy use cases)
9. D) All of the above (Command use cases)
10. D) All of the above (pattern usage)

---

## Next Steps

Excellent work! You've mastered behavioral patterns. You now understand:
- Observer pattern
- Strategy pattern
- Command pattern
- How to apply patterns in real scenarios

**What's Next?**
- Module 26: Software Architecture
- Learn project structure and organization
- Understand software architecture principles
- Apply architecture patterns

---

## Additional Resources

- **Design Patterns**: [refactoring.guru/design-patterns](https://refactoring.guru/design-patterns)
- **Python Design Patterns**: [python-patterns.guide/](https://python-patterns.guide/)
- **Observer Pattern**: Event-driven programming
- **Strategy Pattern**: Algorithm selection
- **Command Pattern**: Undo/redo systems

---

*Lesson completed! You're ready to move on to the next module.*

