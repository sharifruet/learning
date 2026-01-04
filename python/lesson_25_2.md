# Lesson 25.2: Structural Patterns

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand structural design patterns
- Implement the Adapter pattern
- Understand and use the Decorator pattern (revisited)
- Implement the Facade pattern
- Recognize when to use each pattern
- Apply structural patterns in real-world scenarios
- Combine patterns effectively
- Choose appropriate patterns for problems
- Debug pattern-related issues

---

## Introduction to Structural Patterns

**Structural Patterns** deal with object composition and relationships between objects. They help ensure that if one part of a system changes, the entire system doesn't need to change.

**Key Structural Patterns**:
- **Adapter**: Allows incompatible interfaces to work together
- **Decorator**: Adds behavior to objects dynamically
- **Facade**: Provides a simplified interface to a complex subsystem
- **Proxy**: Provides a placeholder for another object
- **Bridge**: Separates abstraction from implementation
- **Composite**: Composes objects into tree structures
- **Flyweight**: Shares objects to reduce memory usage

**Benefits**:
- **Flexibility**: Easier to modify and extend
- **Reusability**: Components can be reused
- **Maintainability**: Easier to maintain
- **Decoupling**: Reduces dependencies

---

## Adapter Pattern

### Concept

The **Adapter** pattern allows objects with incompatible interfaces to work together by wrapping an object with an adapter that translates between interfaces.

**Use Cases**:
- Integrating third-party libraries
- Working with legacy code
- Adapting incompatible interfaces
- Making old code work with new code

### Class Adapter

```python
# Target interface
class Target:
    def request(self):
        return "Target: Default behavior"

# Adaptee (incompatible interface)
class Adaptee:
    def specific_request(self):
        return "Adaptee: Specific behavior"

# Adapter
class Adapter(Target, Adaptee):
    def request(self):
        return f"Adapter: {self.specific_request()}"

# Usage
target = Target()
print(target.request())  # Target: Default behavior

adapter = Adapter()
print(adapter.request())  # Adapter: Adaptee: Specific behavior
```

### Object Adapter

```python
# Target interface
class PaymentProcessor:
    def process_payment(self, amount):
        pass

# Adaptee (third-party library with different interface)
class LegacyPaymentSystem:
    def pay(self, dollars, cents):
        return f"Paid ${dollars}.{cents:02d}"

# Adapter
class PaymentAdapter(PaymentProcessor):
    def __init__(self, legacy_system):
        self.legacy_system = legacy_system
    
    def process_payment(self, amount):
        dollars = int(amount)
        cents = int((amount - dollars) * 100)
        return self.legacy_system.pay(dollars, cents)

# Usage
legacy = LegacyPaymentSystem()
adapter = PaymentAdapter(legacy)
result = adapter.process_payment(99.99)
print(result)  # Paid $99.99
```

### Practical Example: Database Adapter

```python
from abc import ABC, abstractmethod

# Target interface
class Database(ABC):
    @abstractmethod
    def execute_query(self, query):
        pass

# Adaptee 1: MySQL interface
class MySQLDatabase:
    def mysql_query(self, sql):
        return f"MySQL result for: {sql}"

# Adaptee 2: PostgreSQL interface
class PostgreSQLDatabase:
    def postgres_query(self, sql):
        return f"PostgreSQL result for: {sql}"

# Adapter for MySQL
class MySQLAdapter(Database):
    def __init__(self, mysql_db):
        self.mysql_db = mysql_db
    
    def execute_query(self, query):
        return self.mysql_db.mysql_query(query)

# Adapter for PostgreSQL
class PostgreSQLAdapter(Database):
    def __init__(self, postgres_db):
        self.postgres_db = postgres_db
    
    def execute_query(self, query):
        return self.postgres_db.postgres_query(query)

# Usage
mysql_db = MySQLDatabase()
mysql_adapter = MySQLAdapter(mysql_db)
print(mysql_adapter.execute_query("SELECT * FROM users"))

postgres_db = PostgreSQLDatabase()
postgres_adapter = PostgreSQLAdapter(postgres_db)
print(postgres_adapter.execute_query("SELECT * FROM users"))
```

---

## Decorator Pattern (Revisited)

### Concept

The **Decorator** pattern allows behavior to be added to individual objects dynamically, without affecting the behavior of other objects from the same class.

**Use Cases**:
- Adding features to objects
- Extending functionality without inheritance
- Composing behaviors
- Adding responsibilities dynamically

### Basic Decorator

```python
from abc import ABC, abstractmethod

# Component interface
class Coffee(ABC):
    @abstractmethod
    def cost(self):
        pass
    
    @abstractmethod
    def description(self):
        pass

# Concrete component
class SimpleCoffee(Coffee):
    def cost(self):
        return 2.0
    
    def description(self):
        return "Simple coffee"

# Base decorator
class CoffeeDecorator(Coffee):
    def __init__(self, coffee):
        self._coffee = coffee
    
    def cost(self):
        return self._coffee.cost()
    
    def description(self):
        return self._coffee.description()

# Concrete decorators
class MilkDecorator(CoffeeDecorator):
    def cost(self):
        return self._coffee.cost() + 0.5
    
    def description(self):
        return self._coffee.description() + ", milk"

class SugarDecorator(CoffeeDecorator):
    def cost(self):
        return self._coffee.cost() + 0.2
    
    def description(self):
        return self._coffee.description() + ", sugar"

class WhipDecorator(CoffeeDecorator):
    def cost(self):
        return self._coffee.cost() + 0.7
    
    def description(self):
        return self._coffee.description() + ", whip"

# Usage
coffee = SimpleCoffee()
print(f"{coffee.description()}: ${coffee.cost()}")

coffee_with_milk = MilkDecorator(coffee)
print(f"{coffee_with_milk.description()}: ${coffee_with_milk.cost()}")

coffee_full = WhipDecorator(SugarDecorator(MilkDecorator(SimpleCoffee())))
print(f"{coffee_full.description()}: ${coffee_full.cost()}")
```

### Function Decorator

```python
def timing_decorator(func):
    """Decorator that measures function execution time."""
    import time
    from functools import wraps
    
    @wraps(func)
    def wrapper(*args, **kwargs):
        start = time.time()
        result = func(*args, **kwargs)
        end = time.time()
        print(f"{func.__name__} took {end - start:.4f} seconds")
        return result
    
    return wrapper

def logging_decorator(func):
    """Decorator that logs function calls."""
    from functools import wraps
    
    @wraps(func)
    def wrapper(*args, **kwargs):
        print(f"Calling {func.__name__} with args={args}, kwargs={kwargs}")
        result = func(*args, **kwargs)
        print(f"{func.__name__} returned {result}")
        return result
    
    return wrapper

@timing_decorator
@logging_decorator
def calculate_sum(numbers):
    """Calculate sum of numbers."""
    return sum(numbers)

# Usage
result = calculate_sum([1, 2, 3, 4, 5])
```

### Class Decorator

```python
def singleton_decorator(cls):
    """Make a class a singleton."""
    instances = {}
    
    def get_instance(*args, **kwargs):
        if cls not in instances:
            instances[cls] = cls(*args, **kwargs)
        return instances[cls]
    
    return get_instance

@singleton_decorator
class Database:
    def __init__(self):
        self.connection = "Connected"
    
    def query(self, sql):
        return f"Result: {sql}"

# Usage
db1 = Database()
db2 = Database()
print(db1 is db2)  # True
```

### Practical Example: HTTP Request Decorator

```python
import time
from functools import wraps

def retry_decorator(max_attempts=3, delay=1):
    """Retry decorator for functions that may fail."""
    def decorator(func):
        @wraps(func)
        def wrapper(*args, **kwargs):
            for attempt in range(max_attempts):
                try:
                    return func(*args, **kwargs)
                except Exception as e:
                    if attempt == max_attempts - 1:
                        raise
                    print(f"Attempt {attempt + 1} failed: {e}. Retrying...")
                    time.sleep(delay)
        return wrapper
    return decorator

def cache_decorator(func):
    """Cache decorator for function results."""
    cache = {}
    
    @wraps(func)
    def wrapper(*args, **kwargs):
        key = str(args) + str(kwargs)
        if key not in cache:
            cache[key] = func(*args, **kwargs)
        return cache[key]
    
    return wrapper

@retry_decorator(max_attempts=3)
@cache_decorator
def fetch_data(url):
    """Fetch data from URL (simulated)."""
    import random
    if random.random() < 0.5:  # 50% chance of failure
        raise ConnectionError("Connection failed")
    return f"Data from {url}"

# Usage
data = fetch_data("https://api.example.com/data")
print(data)
```

---

## Facade Pattern

### Concept

The **Facade** pattern provides a simplified interface to a complex subsystem, making it easier to use.

**Use Cases**:
- Simplifying complex APIs
- Providing a simple interface to a complex system
- Hiding implementation details
- Reducing dependencies

### Basic Facade

```python
# Complex subsystem
class CPU:
    def freeze(self):
        print("CPU: Freezing...")
    
    def jump(self, position):
        print(f"CPU: Jumping to {position}")
    
    def execute(self):
        print("CPU: Executing...")

class Memory:
    def load(self, position, data):
        print(f"Memory: Loading data at {position}")

class HardDrive:
    def read(self, lba, size):
        print(f"HardDrive: Reading {size} bytes from {lba}")
        return "Boot data"

# Facade
class ComputerFacade:
    def __init__(self):
        self.cpu = CPU()
        self.memory = Memory()
        self.hard_drive = HardDrive()
    
    def start_computer(self):
        """Simple interface to start computer."""
        self.cpu.freeze()
        self.memory.load(0, self.hard_drive.read(0, 1024))
        self.cpu.jump(0)
        self.cpu.execute()
        print("Computer started!")

# Usage
computer = ComputerFacade()
computer.start_computer()
# Instead of:
# cpu.freeze()
# memory.load(0, hard_drive.read(0, 1024))
# cpu.jump(0)
# cpu.execute()
```

### Practical Example: API Facade

```python
# Complex subsystem
class UserService:
    def get_user(self, user_id):
        return f"User {user_id}"

class OrderService:
    def get_orders(self, user_id):
        return [f"Order 1 for user {user_id}", f"Order 2 for user {user_id}"]

class PaymentService:
    def get_payments(self, user_id):
        return [f"Payment 1 for user {user_id}"]

class NotificationService:
    def send_notification(self, user_id, message):
        return f"Notification sent to user {user_id}: {message}"

# Facade
class UserDashboardFacade:
    """Simplified interface for user dashboard."""
    
    def __init__(self):
        self.user_service = UserService()
        self.order_service = OrderService()
        self.payment_service = PaymentService()
        self.notification_service = NotificationService()
    
    def get_user_dashboard(self, user_id):
        """Get complete user dashboard data."""
        user = self.user_service.get_user(user_id)
        orders = self.order_service.get_orders(user_id)
        payments = self.payment_service.get_payments(user_id)
        
        return {
            'user': user,
            'orders': orders,
            'payments': payments
        }
    
    def send_welcome_message(self, user_id):
        """Send welcome message to new user."""
        user = self.user_service.get_user(user_id)
        message = f"Welcome, {user}!"
        return self.notification_service.send_notification(user_id, message)

# Usage
facade = UserDashboardFacade()
dashboard = facade.get_user_dashboard(1)
print(dashboard)

facade.send_welcome_message(1)
```

### Practical Example: File System Facade

```python
import os
from pathlib import Path

# Complex subsystem (file operations)
class FileOperations:
    """Facade for file operations."""
    
    @staticmethod
    def create_file(path, content):
        """Create a file with content."""
        with open(path, 'w') as f:
            f.write(content)
        print(f"Created file: {path}")
    
    @staticmethod
    def read_file(path):
        """Read file content."""
        with open(path, 'r') as f:
            return f.read()
    
    @staticmethod
    def delete_file(path):
        """Delete a file."""
        if os.path.exists(path):
            os.remove(path)
            print(f"Deleted file: {path}")
        else:
            print(f"File not found: {path}")
    
    @staticmethod
    def copy_file(source, destination):
        """Copy file from source to destination."""
        import shutil
        shutil.copy2(source, destination)
        print(f"Copied {source} to {destination}")
    
    @staticmethod
    def move_file(source, destination):
        """Move file from source to destination."""
        import shutil
        shutil.move(source, destination)
        print(f"Moved {source} to {destination}")
    
    @staticmethod
    def get_file_info(path):
        """Get file information."""
        if not os.path.exists(path):
            return None
        
        stat = os.stat(path)
        return {
            'path': path,
            'size': stat.st_size,
            'modified': stat.st_mtime,
            'is_file': os.path.isfile(path),
            'is_dir': os.path.isdir(path)
        }

# Usage
file_ops = FileOperations()

# Create file
file_ops.create_file('test.txt', 'Hello, World!')

# Get file info
info = file_ops.get_file_info('test.txt')
print(info)

# Read file
content = file_ops.read_file('test.txt')
print(content)

# Copy file
file_ops.copy_file('test.txt', 'test_copy.txt')

# Delete file
file_ops.delete_file('test.txt')
```

---

## Pattern Comparison

### When to Use Adapter

```python
# Use Adapter when:
# - You need to use a class with an incompatible interface
# - You want to use a third-party library
# - You need to integrate legacy code

class LegacyAPI:
    def old_method(self, param1, param2):
        pass

class NewAPI:
    def new_method(self, params):
        pass

class APIAdapter(NewAPI):
    def __init__(self, legacy_api):
        self.legacy_api = legacy_api
    
    def new_method(self, params):
        return self.legacy_api.old_method(params['param1'], params['param2'])
```

### When to Use Decorator

```python
# Use Decorator when:
# - You need to add behavior dynamically
# - You want to avoid subclass explosion
# - You need to compose behaviors

# Instead of: SimpleCoffee, CoffeeWithMilk, CoffeeWithSugar, 
# CoffeeWithMilkAndSugar, etc. (exponential growth)
# Use decorators to compose behaviors
```

### When to Use Facade

```python
# Use Facade when:
# - You have a complex subsystem
# - You want to provide a simple interface
# - You want to hide complexity

# Instead of calling multiple services:
# user = user_service.get_user(id)
# orders = order_service.get_orders(id)
# payments = payment_service.get_payments(id)

# Use facade:
# dashboard = facade.get_user_dashboard(id)
```

---

## Practical Examples

### Example 1: Complete Adapter Implementation

```python
from abc import ABC, abstractmethod

# Target interface
class MediaPlayer(ABC):
    @abstractmethod
    def play(self, audio_type, filename):
        pass

# Adaptee 1
class AdvancedMediaPlayer(ABC):
    @abstractmethod
    def play_vlc(self, filename):
        pass
    
    @abstractmethod
    def play_mp4(self, filename):
        pass

class VlcPlayer(AdvancedMediaPlayer):
    def play_vlc(self, filename):
        return f"Playing VLC file: {filename}"
    
    def play_mp4(self, filename):
        pass

class Mp4Player(AdvancedMediaPlayer):
    def play_vlc(self, filename):
        pass
    
    def play_mp4(self, filename):
        return f"Playing MP4 file: {filename}"

# Adapter
class MediaAdapter(MediaPlayer):
    def __init__(self, audio_type):
        if audio_type == "vlc":
            self.advanced_player = VlcPlayer()
        elif audio_type == "mp4":
            self.advanced_player = Mp4Player()
    
    def play(self, audio_type, filename):
        if audio_type == "vlc":
            return self.advanced_player.play_vlc(filename)
        elif audio_type == "mp4":
            return self.advanced_player.play_mp4(filename)

# Client
class AudioPlayer(MediaPlayer):
    def play(self, audio_type, filename):
        if audio_type == "mp3":
            return f"Playing MP3 file: {filename}"
        elif audio_type in ["vlc", "mp4"]:
            adapter = MediaAdapter(audio_type)
            return adapter.play(audio_type, filename)
        else:
            return f"Invalid media type: {audio_type}"

# Usage
player = AudioPlayer()
print(player.play("mp3", "song.mp3"))
print(player.play("vlc", "movie.vlc"))
print(player.play("mp4", "video.mp4"))
```

### Example 2: Complete Decorator Implementation

```python
from abc import ABC, abstractmethod
from functools import wraps

# Component
class TextProcessor(ABC):
    @abstractmethod
    def process(self, text):
        pass

# Concrete component
class PlainTextProcessor(TextProcessor):
    def process(self, text):
        return text

# Base decorator
class TextDecorator(TextProcessor):
    def __init__(self, processor):
        self._processor = processor
    
    def process(self, text):
        return self._processor.process(text)

# Concrete decorators
class BoldDecorator(TextDecorator):
    def process(self, text):
        return f"<b>{self._processor.process(text)}</b>"

class ItalicDecorator(TextDecorator):
    def process(self, text):
        return f"<i>{self._processor.process(text)}</i>"

class UnderlineDecorator(TextDecorator):
    def process(self, text):
        return f"<u>{self._processor.process(text)}</u>"

class ColorDecorator(TextDecorator):
    def __init__(self, processor, color):
        super().__init__(processor)
        self.color = color
    
    def process(self, text):
        return f'<span style="color:{self.color}">{self._processor.process(text)}</span>'

# Usage
processor = PlainTextProcessor()
text = "Hello, World!"

# Add formatting
bold_text = BoldDecorator(processor)
print(bold_text.process(text))  # <b>Hello, World!</b>

# Combine decorators
formatted = ColorDecorator(
    BoldDecorator(
        ItalicDecorator(processor)
    ),
    "red"
)
print(formatted.process(text))
# <span style="color:red"><b><i>Hello, World!</i></b></span>
```

### Example 3: Complete Facade Implementation

```python
# Complex subsystem
class AuthenticationService:
    def login(self, username, password):
        return f"User {username} logged in"
    
    def logout(self, username):
        return f"User {username} logged out"

class AuthorizationService:
    def check_permission(self, user, resource):
        return f"User {user} has access to {resource}"

class SessionService:
    def create_session(self, user):
        return f"Session created for {user}"
    
    def destroy_session(self, user):
        return f"Session destroyed for {user}"

class CacheService:
    def cache_data(self, key, value):
        return f"Cached {key}: {value}"
    
    def get_cached_data(self, key):
        return f"Retrieved cached data for {key}"

# Facade
class SecurityFacade:
    """Simplified interface for security operations."""
    
    def __init__(self):
        self.auth_service = AuthenticationService()
        self.authz_service = AuthorizationService()
        self.session_service = SessionService()
        self.cache_service = CacheService()
    
    def authenticate_user(self, username, password):
        """Complete authentication flow."""
        # Login
        login_result = self.auth_service.login(username, password)
        
        # Create session
        session_result = self.session_service.create_session(username)
        
        # Cache user data
        cache_result = self.cache_service.cache_data(f"user_{username}", username)
        
        return {
            'login': login_result,
            'session': session_result,
            'cache': cache_result
        }
    
    def authorize_access(self, username, resource):
        """Check if user has access to resource."""
        return self.authz_service.check_permission(username, resource)
    
    def logout_user(self, username):
        """Complete logout flow."""
        logout_result = self.auth_service.logout(username)
        session_result = self.session_service.destroy_session(username)
        return {
            'logout': logout_result,
            'session': session_result
        }

# Usage
security = SecurityFacade()

# Simple authentication
result = security.authenticate_user("alice", "password123")
print(result)

# Simple authorization check
has_access = security.authorize_access("alice", "admin_panel")
print(has_access)

# Simple logout
logout_result = security.logout_user("alice")
print(logout_result)
```

---

## Common Mistakes and Pitfalls

### Adapter Issues

```python
# WRONG: Adapter changes behavior
class Adapter:
    def request(self):
        return "Different behavior"  # Changed behavior!

# CORRECT: Adapter only translates interface
class Adapter:
    def __init__(self, adaptee):
        self.adaptee = adaptee
    
    def request(self):
        return self.adaptee.specific_request()  # Translates only
```

### Decorator Issues

```python
# WRONG: Forgetting to call wrapped function
class Decorator:
    def method(self):
        return "Decorated"  # Didn't call original!

# CORRECT: Call wrapped function
class Decorator:
    def __init__(self, component):
        self.component = component
    
    def method(self):
        result = self.component.method()  # Call original
        return f"Decorated {result}"  # Then enhance
```

---

## Best Practices

### 1. Keep Adapters Simple

```python
# Adapters should only translate interfaces
# Don't add business logic
```

### 2. Use Decorators for Cross-Cutting Concerns

```python
# Logging, timing, caching, retry
# These are perfect for decorators
```

### 3. Facades Should Simplify, Not Hide

```python
# Facades should make things easier
# But still allow access to underlying system if needed
```

---

## Practice Exercise

### Exercise: Structural Patterns

**Objective**: Implement structural patterns in a practical scenario.

**Requirements**:

1. Create a system using structural patterns:
   - Adapter for integrating different services
   - Decorator for adding features
   - Facade for simplifying complex operations

2. Scenario: Notification system
   - Adapter for different notification services
   - Decorator for adding features (logging, retry)
   - Facade for sending notifications

**Example Solution**:

```python
"""
Notification System with Structural Patterns
"""

from abc import ABC, abstractmethod
from functools import wraps
import time

# Adapter Pattern: Different notification services
class EmailService:
    """Third-party email service with different interface."""
    def send_email(self, to, subject, body):
        return f"Email sent to {to}: {subject}"

class SMSService:
    """Third-party SMS service with different interface."""
    def send_sms(self, phone, message):
        return f"SMS sent to {phone}: {message}"

class PushService:
    """Third-party push service with different interface."""
    def send_push(self, user_id, notification):
        return f"Push sent to user {user_id}: {notification}"

# Target interface
class NotificationSender(ABC):
    @abstractmethod
    def send(self, recipient, message):
        pass

# Adapters
class EmailAdapter(NotificationSender):
    def __init__(self, email_service):
        self.email_service = email_service
    
    def send(self, recipient, message):
        return self.email_service.send_email(recipient, message['subject'], message['body'])

class SMSAdapter(NotificationSender):
    def __init__(self, sms_service):
        self.sms_service = sms_service
    
    def send(self, recipient, message):
        return self.sms_service.send_sms(recipient, message['text'])

class PushAdapter(NotificationSender):
    def __init__(self, push_service):
        self.push_service = push_service
    
    def send(self, recipient, message):
        return self.push_service.send_push(recipient, message['notification'])

# Decorator Pattern: Add features
class NotificationDecorator(NotificationSender):
    def __init__(self, sender):
        self._sender = sender
    
    def send(self, recipient, message):
        return self._sender.send(recipient, message)

class LoggingDecorator(NotificationDecorator):
    """Add logging to notifications."""
    def send(self, recipient, message):
        print(f"[LOG] Sending notification to {recipient}")
        result = self._sender.send(recipient, message)
        print(f"[LOG] Result: {result}")
        return result

class RetryDecorator(NotificationDecorator):
    """Add retry logic to notifications."""
    def __init__(self, sender, max_retries=3):
        super().__init__(sender)
        self.max_retries = max_retries
    
    def send(self, recipient, message):
        for attempt in range(self.max_retries):
            try:
                return self._sender.send(recipient, message)
            except Exception as e:
                if attempt == self.max_retries - 1:
                    raise
                print(f"Attempt {attempt + 1} failed, retrying...")
                time.sleep(1)

class TimestampDecorator(NotificationDecorator):
    """Add timestamp to messages."""
    def send(self, recipient, message):
        import datetime
        timestamped_message = message.copy()
        timestamped_message['timestamp'] = datetime.datetime.now().isoformat()
        return self._sender.send(recipient, timestamped_message)

# Facade Pattern: Simplify notification sending
class NotificationFacade:
    """Simplified interface for sending notifications."""
    
    def __init__(self):
        # Initialize services
        email_service = EmailService()
        sms_service = SMSService()
        push_service = PushService()
        
        # Create adapters
        self.email_adapter = EmailAdapter(email_service)
        self.sms_adapter = SMSAdapter(sms_service)
        self.push_adapter = PushAdapter(push_service)
    
    def send_email(self, recipient, subject, body):
        """Send email notification."""
        sender = LoggingDecorator(TimestampDecorator(self.email_adapter))
        return sender.send(recipient, {'subject': subject, 'body': body})
    
    def send_sms(self, recipient, message):
        """Send SMS notification."""
        sender = RetryDecorator(LoggingDecorator(self.sms_adapter))
        return sender.send(recipient, {'text': message})
    
    def send_push(self, user_id, notification):
        """Send push notification."""
        sender = LoggingDecorator(self.push_adapter)
        return sender.send(user_id, {'notification': notification})
    
    def send_all(self, recipient, email_subject, email_body, sms_text, push_notification):
        """Send all notification types."""
        results = {
            'email': self.send_email(recipient, email_subject, email_body),
            'sms': self.send_sms(recipient, sms_text),
            'push': self.send_push(recipient, push_notification)
        }
        return results

# Usage
facade = NotificationFacade()

# Send individual notifications
facade.send_email("user@example.com", "Welcome", "Welcome to our service!")
facade.send_sms("+1234567890", "Your code is 1234")
facade.send_push("user123", "You have a new message")

# Send all at once
results = facade.send_all(
    recipient="user@example.com",
    email_subject="Update",
    email_body="Your account has been updated",
    sms_text="Account updated",
    push_notification="Check your account"
)
print(results)
```

**Expected Output**: A complete notification system demonstrating all three structural patterns.

**Challenge** (Optional):
- Add more notification types
- Add more decorators (rate limiting, encryption)
- Add notification preferences
- Add notification history
- Create notification templates

---

## Key Takeaways

1. **Structural Patterns** - Deal with object composition
2. **Adapter** - Makes incompatible interfaces work together
3. **Decorator** - Adds behavior dynamically
4. **Facade** - Simplifies complex subsystems
5. **Object Adapter** - Uses composition (preferred)
6. **Class Adapter** - Uses inheritance
7. **Decorator Composition** - Stack decorators for multiple behaviors
8. **Facade Simplification** - Hide complexity, provide simple interface
9. **When to Use** - Each pattern has specific use cases
10. **Pattern Combinations** - Patterns can work together
11. **Best Practices** - Keep adapters simple, use decorators for cross-cutting
12. **Common Mistakes** - Changing behavior in adapters, forgetting to call wrapped functions
13. **Real-World Applications** - Patterns solve real problems
14. **Flexibility** - Patterns provide flexibility and extensibility
15. **Maintainability** - Patterns improve code maintainability

---

## Quiz: Structural Patterns

Test your understanding with these questions:

1. **What does Adapter pattern do?**
   - A) Adds behavior
   - B) Makes incompatible interfaces work together
   - C) Simplifies interface
   - D) Creates objects

2. **What does Decorator pattern do?**
   - A) Adapts interfaces
   - B) Adds behavior dynamically
   - C) Simplifies systems
   - D) Creates objects

3. **What does Facade pattern do?**
   - A) Adapts interfaces
   - B) Adds behavior
   - C) Simplifies complex subsystems
   - D) Creates objects

4. **What is Object Adapter?**
   - A) Uses inheritance
   - B) Uses composition
   - C) Uses delegation
   - D) All of the above

5. **What can Decorators do?**
   - A) Add logging
   - B) Add caching
   - C) Add timing
   - D) All of the above

6. **What does Facade hide?**
   - A) Complexity
   - B) Implementation
   - C) Subsystem details
   - D) All of the above

7. **When to use Adapter?**
   - A) Integrating third-party libraries
   - B) Working with legacy code
   - C) Making incompatible interfaces work
   - D) All of the above

8. **When to use Decorator?**
   - A) Adding features dynamically
   - B) Avoiding subclass explosion
   - C) Composing behaviors
   - D) All of the above

9. **When to use Facade?**
   - A) Complex subsystems
   - B) Need simple interface
   - C) Hide complexity
   - D) All of the above

10. **What can patterns be combined?**
    - A) Yes
    - B) No
    - C) Sometimes
    - D) Never

**Answers**:
1. B) Makes incompatible interfaces work together (Adapter)
2. B) Adds behavior dynamically (Decorator)
3. C) Simplifies complex subsystems (Facade)
4. B) Uses composition (Object Adapter)
5. D) All of the above (Decorator uses)
6. D) All of the above (Facade hides)
7. D) All of the above (Adapter use cases)
8. D) All of the above (Decorator use cases)
9. D) All of the above (Facade use cases)
10. A) Yes (pattern combination)

---

## Next Steps

Excellent work! You've mastered structural patterns. You now understand:
- Adapter pattern
- Decorator pattern (revisited)
- Facade pattern
- How to apply patterns in real scenarios

**What's Next?**
- Lesson 25.3: Behavioral Patterns
- Learn Observer, Strategy patterns
- Understand behavioral design patterns
- Apply patterns to object behavior

---

## Additional Resources

- **Design Patterns**: [refactoring.guru/design-patterns](https://refactoring.guru/design-patterns)
- **Python Design Patterns**: [python-patterns.guide/](https://python-patterns.guide/)
- **Adapter Pattern**: Detailed explanation and examples
- **Decorator Pattern**: Python decorators guide
- **Facade Pattern**: When and how to use facades

---

*Lesson completed! You're ready to move on to the next lesson.*

