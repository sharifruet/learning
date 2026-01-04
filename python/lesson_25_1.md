# Lesson 25.1: Creational Patterns

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand design patterns and their purpose
- Implement the Singleton pattern
- Implement the Factory pattern
- Implement the Builder pattern
- Understand when to use each pattern
- Apply creational patterns in real-world scenarios
- Recognize pattern implementations in code
- Choose appropriate patterns for problems
- Combine patterns effectively
- Debug pattern-related issues

---

## Introduction to Design Patterns

**Design Patterns** are reusable solutions to common problems in software design. They provide templates for solving problems in a way that has been proven to work.

**Creational Patterns** focus on object creation mechanisms, trying to create objects in a manner suitable to the situation.

**Benefits**:
- **Reusability**: Proven solutions
- **Best Practices**: Industry-tested approaches
- **Communication**: Common vocabulary
- **Maintainability**: Easier to maintain
- **Flexibility**: Easier to modify

**Types of Creational Patterns**:
- **Singleton**: Ensure only one instance exists
- **Factory**: Create objects without specifying exact class
- **Builder**: Construct complex objects step by step
- **Prototype**: Clone objects
- **Abstract Factory**: Create families of related objects

---

## Singleton Pattern

### Concept

The **Singleton** pattern ensures a class has only one instance and provides a global point of access to it.

**Use Cases**:
- Database connections
- Logging
- Configuration management
- Caching
- Thread pools

### Basic Implementation

```python
class Singleton:
    _instance = None
    
    def __new__(cls):
        if cls._instance is None:
            cls._instance = super().__new__(cls)
        return cls._instance

# Usage
s1 = Singleton()
s2 = Singleton()
print(s1 is s2)  # True - same instance
```

### Thread-Safe Singleton

```python
import threading

class ThreadSafeSingleton:
    _instance = None
    _lock = threading.Lock()
    
    def __new__(cls):
        if cls._instance is None:
            with cls._lock:
                # Double-check locking pattern
                if cls._instance is None:
                    cls._instance = super().__new__(cls)
        return cls._instance
```

### Singleton with Decorator

```python
def singleton(cls):
    instances = {}
    
    def get_instance(*args, **kwargs):
        if cls not in instances:
            instances[cls] = cls(*args, **kwargs)
        return instances[cls]
    
    return get_instance

@singleton
class DatabaseConnection:
    def __init__(self):
        self.connection = "Connected"
    
    def query(self, sql):
        return f"Executing: {sql}"

# Usage
db1 = DatabaseConnection()
db2 = DatabaseConnection()
print(db1 is db2)  # True
```

### Singleton with Metaclass

```python
class SingletonMeta(type):
    _instances = {}
    
    def __call__(cls, *args, **kwargs):
        if cls not in cls._instances:
            cls._instances[cls] = super().__call__(*args, **kwargs)
        return cls._instances[cls]

class Logger(metaclass=SingletonMeta):
    def __init__(self):
        self.logs = []
    
    def log(self, message):
        self.logs.append(message)
        print(f"Log: {message}")

# Usage
logger1 = Logger()
logger2 = Logger()
print(logger1 is logger2)  # True
```

### Practical Example: Configuration Manager

```python
class ConfigManager(metaclass=SingletonMeta):
    """Singleton configuration manager."""
    
    def __init__(self):
        self.config = {}
        self.load_config()
    
    def load_config(self):
        """Load configuration from file or environment."""
        import os
        self.config = {
            'database_url': os.getenv('DATABASE_URL', 'sqlite:///app.db'),
            'debug': os.getenv('DEBUG', 'False') == 'True',
            'secret_key': os.getenv('SECRET_KEY', 'default-secret')
        }
    
    def get(self, key, default=None):
        """Get configuration value."""
        return self.config.get(key, default)
    
    def set(self, key, value):
        """Set configuration value."""
        self.config[key] = value

# Usage
config1 = ConfigManager()
config2 = ConfigManager()
print(config1 is config2)  # True
print(config1.get('database_url'))
```

---

## Factory Pattern

### Concept

The **Factory** pattern provides an interface for creating objects without specifying their exact classes.

**Use Cases**:
- Object creation logic is complex
- Need to create objects based on conditions
- Want to decouple object creation from usage
- Need to support multiple object types

### Simple Factory

```python
class Animal:
    def speak(self):
        pass

class Dog(Animal):
    def speak(self):
        return "Woof!"

class Cat(Animal):
    def speak(self):
        return "Meow!"

class AnimalFactory:
    @staticmethod
    def create_animal(animal_type):
        if animal_type == "dog":
            return Dog()
        elif animal_type == "cat":
            return Cat()
        else:
            raise ValueError(f"Unknown animal type: {animal_type}")

# Usage
dog = AnimalFactory.create_animal("dog")
print(dog.speak())  # Woof!

cat = AnimalFactory.create_animal("cat")
print(cat.speak())  # Meow!
```

### Factory Method Pattern

```python
from abc import ABC, abstractmethod

class Document(ABC):
    @abstractmethod
    def create(self):
        pass

class PDFDocument(Document):
    def create(self):
        return "PDF document created"

class WordDocument(Document):
    def create(self):
        return "Word document created"

class DocumentCreator(ABC):
    @abstractmethod
    def create_document(self):
        pass
    
    def process_document(self):
        doc = self.create_document()
        return doc.create()

class PDFCreator(DocumentCreator):
    def create_document(self):
        return PDFDocument()

class WordCreator(DocumentCreator):
    def create_document(self):
        return WordDocument()

# Usage
pdf_creator = PDFCreator()
result = pdf_creator.process_document()
print(result)  # PDF document created
```

### Abstract Factory Pattern

```python
from abc import ABC, abstractmethod

# Abstract products
class Button(ABC):
    @abstractmethod
    def render(self):
        pass

class Dialog(ABC):
    @abstractmethod
    def render(self):
        pass

# Concrete products - Windows
class WindowsButton(Button):
    def render(self):
        return "Windows button rendered"

class WindowsDialog(Dialog):
    def render(self):
        return "Windows dialog rendered"

# Concrete products - Mac
class MacButton(Button):
    def render(self):
        return "Mac button rendered"

class MacDialog(Dialog):
    def render(self):
        return "Mac dialog rendered"

# Abstract factory
class UIFactory(ABC):
    @abstractmethod
    def create_button(self):
        pass
    
    @abstractmethod
    def create_dialog(self):
        pass

# Concrete factories
class WindowsFactory(UIFactory):
    def create_button(self):
        return WindowsButton()
    
    def create_dialog(self):
        return WindowsDialog()

class MacFactory(UIFactory):
    def create_button(self):
        return MacButton()
    
    def create_dialog(self):
        return MacDialog()

# Usage
def create_ui(factory: UIFactory):
    button = factory.create_button()
    dialog = factory.create_dialog()
    return button.render(), dialog.render()

windows_ui = create_ui(WindowsFactory())
mac_ui = create_ui(MacFactory())
```

### Practical Example: Database Factory

```python
from abc import ABC, abstractmethod

class Database(ABC):
    @abstractmethod
    def connect(self):
        pass
    
    @abstractmethod
    def query(self, sql):
        pass

class MySQLDatabase(Database):
    def connect(self):
        return "Connected to MySQL"
    
    def query(self, sql):
        return f"MySQL: {sql}"

class PostgreSQLDatabase(Database):
    def connect(self):
        return "Connected to PostgreSQL"
    
    def query(self, sql):
        return f"PostgreSQL: {sql}"

class SQLiteDatabase(Database):
    def connect(self):
        return "Connected to SQLite"
    
    def query(self, sql):
        return f"SQLite: {sql}"

class DatabaseFactory:
    @staticmethod
    def create_database(db_type):
        databases = {
            'mysql': MySQLDatabase,
            'postgresql': PostgreSQLDatabase,
            'sqlite': SQLiteDatabase
        }
        
        db_class = databases.get(db_type.lower())
        if db_class:
            return db_class()
        else:
            raise ValueError(f"Unknown database type: {db_type}")

# Usage
db = DatabaseFactory.create_database('mysql')
print(db.connect())
print(db.query("SELECT * FROM users"))
```

---

## Builder Pattern

### Concept

The **Builder** pattern constructs complex objects step by step. It allows you to produce different types and representations of an object using the same construction code.

**Use Cases**:
- Complex object construction
- Objects with many optional parameters
- Need to construct objects in steps
- Want to reuse construction code

### Basic Builder

```python
class Pizza:
    def __init__(self):
        self.size = None
        self.crust = None
        self.toppings = []
        self.cheese = False
        self.sauce = None
    
    def __str__(self):
        return (f"Pizza: {self.size} size, {self.crust} crust, "
                f"toppings: {', '.join(self.toppings)}, "
                f"cheese: {self.cheese}, sauce: {self.sauce}")

class PizzaBuilder:
    def __init__(self):
        self.pizza = Pizza()
    
    def set_size(self, size):
        self.pizza.size = size
        return self
    
    def set_crust(self, crust):
        self.pizza.crust = crust
        return self
    
    def add_topping(self, topping):
        self.pizza.toppings.append(topping)
        return self
    
    def set_cheese(self, cheese=True):
        self.pizza.cheese = cheese
        return self
    
    def set_sauce(self, sauce):
        self.pizza.sauce = sauce
        return self
    
    def build(self):
        return self.pizza

# Usage
pizza = (PizzaBuilder()
         .set_size("Large")
         .set_crust("Thin")
         .add_topping("Pepperoni")
         .add_topping("Mushrooms")
         .set_cheese(True)
         .set_sauce("Tomato")
         .build())

print(pizza)
```

### Builder with Director

```python
class PizzaBuilder:
    def __init__(self):
        self.pizza = Pizza()
    
    def set_size(self, size):
        self.pizza.size = size
        return self
    
    def set_crust(self, crust):
        self.pizza.crust = crust
        return self
    
    def add_topping(self, topping):
        self.pizza.toppings.append(topping)
        return self
    
    def set_cheese(self, cheese=True):
        self.pizza.cheese = cheese
        return self
    
    def set_sauce(self, sauce):
        self.pizza.sauce = sauce
        return self
    
    def build(self):
        return self.pizza

class PizzaDirector:
    """Director that knows how to build specific pizza types."""
    
    @staticmethod
    def build_margherita(builder):
        return (builder
                .set_size("Medium")
                .set_crust("Thin")
                .add_topping("Tomato")
                .add_topping("Basil")
                .set_cheese(True)
                .set_sauce("Tomato")
                .build())
    
    @staticmethod
    def build_pepperoni(builder):
        return (builder
                .set_size("Large")
                .set_crust("Thick")
                .add_topping("Pepperoni")
                .set_cheese(True)
                .set_sauce("Tomato")
                .build())

# Usage
builder = PizzaBuilder()
director = PizzaDirector()

margherita = director.build_margherita(builder)
print(margherita)
```

### Practical Example: Query Builder

```python
class SQLQuery:
    def __init__(self):
        self.select = []
        self.from_table = None
        self.where = []
        self.order_by = []
        self.limit = None
    
    def __str__(self):
        query = "SELECT "
        query += ", ".join(self.select) if self.select else "*"
        query += f" FROM {self.from_table}"
        if self.where:
            query += " WHERE " + " AND ".join(self.where)
        if self.order_by:
            query += " ORDER BY " + ", ".join(self.order_by)
        if self.limit:
            query += f" LIMIT {self.limit}"
        return query

class QueryBuilder:
    def __init__(self):
        self.query = SQLQuery()
    
    def select(self, *columns):
        self.query.select.extend(columns)
        return self
    
    def from_table(self, table):
        self.query.from_table = table
        return self
    
    def where(self, condition):
        self.query.where.append(condition)
        return self
    
    def order_by(self, *columns):
        self.query.order_by.extend(columns)
        return self
    
    def limit(self, count):
        self.query.limit = count
        return self
    
    def build(self):
        return self.query

# Usage
query = (QueryBuilder()
         .select("id", "name", "email")
         .from_table("users")
         .where("age > 18")
         .where("active = 1")
         .order_by("name")
         .limit(10)
         .build())

print(query)
# SELECT id, name, email FROM users WHERE age > 18 AND active = 1 ORDER BY name LIMIT 10
```

---

## Pattern Comparison

### When to Use Singleton

```python
# Use Singleton when:
# - You need exactly one instance
# - Global access point needed
# - Expensive resource (database, logger)

class DatabaseConnection(metaclass=SingletonMeta):
    def __init__(self):
        # Expensive connection setup
        self.connection = "Connected"
```

### When to Use Factory

```python
# Use Factory when:
# - Object creation is complex
# - Need to create objects based on conditions
# - Want to decouple creation from usage

class PaymentProcessorFactory:
    @staticmethod
    def create_processor(payment_type):
        if payment_type == "credit_card":
            return CreditCardProcessor()
        elif payment_type == "paypal":
            return PayPalProcessor()
        # ...
```

### When to Use Builder

```python
# Use Builder when:
# - Object has many optional parameters
# - Construction is complex
# - Need to construct in steps

class HTTPRequestBuilder:
    def __init__(self):
        self.request = HTTPRequest()
    
    def set_method(self, method):
        # ...
    def set_url(self, url):
        # ...
    def add_header(self, key, value):
        # ...
    # Many more optional parameters
```

---

## Practical Examples

### Example 1: Complete Singleton Implementation

```python
import threading
from typing import Optional

class Logger(metaclass=SingletonMeta):
    """Thread-safe singleton logger."""
    
    def __init__(self):
        self._lock = threading.Lock()
        self.logs = []
    
    def log(self, level: str, message: str):
        """Log a message.
        
        Args:
            level: Log level (INFO, WARNING, ERROR)
            message: Log message
        """
        with self._lock:
            log_entry = f"[{level}] {message}"
            self.logs.append(log_entry)
            print(log_entry)
    
    def get_logs(self):
        """Get all logs."""
        with self._lock:
            return self.logs.copy()
    
    def clear_logs(self):
        """Clear all logs."""
        with self._lock:
            self.logs.clear()

# Usage
logger1 = Logger()
logger2 = Logger()
print(logger1 is logger2)  # True

logger1.log("INFO", "Application started")
logger2.log("ERROR", "Something went wrong")
```

### Example 2: Complete Factory Implementation

```python
from abc import ABC, abstractmethod

class Notification(ABC):
    @abstractmethod
    def send(self, message: str):
        pass

class EmailNotification(Notification):
    def send(self, message: str):
        return f"Email sent: {message}"

class SMSNotification(Notification):
    def send(self, message: str):
        return f"SMS sent: {message}"

class PushNotification(Notification):
    def send(self, message: str):
        return f"Push notification sent: {message}"

class NotificationFactory:
    """Factory for creating notification objects."""
    
    @staticmethod
    def create_notification(notification_type: str) -> Notification:
        """Create a notification instance.
        
        Args:
            notification_type: Type of notification (email, sms, push)
        
        Returns:
            Notification instance
        
        Raises:
            ValueError: If notification type is unknown
        """
        notifications = {
            'email': EmailNotification,
            'sms': SMSNotification,
            'push': PushNotification
        }
        
        notification_class = notifications.get(notification_type.lower())
        if notification_class:
            return notification_class()
        else:
            raise ValueError(f"Unknown notification type: {notification_type}")

# Usage
email = NotificationFactory.create_notification('email')
print(email.send("Hello"))

sms = NotificationFactory.create_notification('sms')
print(sms.send("Hello"))
```

### Example 3: Complete Builder Implementation

```python
class Computer:
    def __init__(self):
        self.cpu = None
        self.memory = None
        self.storage = None
        self.gpu = None
        self.motherboard = None
    
    def __str__(self):
        parts = []
        if self.cpu:
            parts.append(f"CPU: {self.cpu}")
        if self.memory:
            parts.append(f"Memory: {self.memory}")
        if self.storage:
            parts.append(f"Storage: {self.storage}")
        if self.gpu:
            parts.append(f"GPU: {self.gpu}")
        if self.motherboard:
            parts.append(f"Motherboard: {self.motherboard}")
        return ", ".join(parts)

class ComputerBuilder:
    def __init__(self):
        self.computer = Computer()
    
    def set_cpu(self, cpu: str):
        self.computer.cpu = cpu
        return self
    
    def set_memory(self, memory: str):
        self.computer.memory = memory
        return self
    
    def set_storage(self, storage: str):
        self.computer.storage = storage
        return self
    
    def set_gpu(self, gpu: str):
        self.computer.gpu = gpu
        return self
    
    def set_motherboard(self, motherboard: str):
        self.computer.motherboard = motherboard
        return self
    
    def build(self):
        return self.computer

class GamingComputerBuilder(ComputerBuilder):
    """Builder for gaming computers."""
    
    def build_gaming_pc(self):
        return (self
                .set_cpu("Intel i9")
                .set_memory("32GB DDR4")
                .set_storage("1TB SSD")
                .set_gpu("RTX 4090")
                .set_motherboard("Z690")
                .build())

class OfficeComputerBuilder(ComputerBuilder):
    """Builder for office computers."""
    
    def build_office_pc(self):
        return (self
                .set_cpu("Intel i5")
                .set_memory("16GB DDR4")
                .set_storage("512GB SSD")
                .set_motherboard("B660")
                .build())

# Usage
gaming_builder = GamingComputerBuilder()
gaming_pc = gaming_builder.build_gaming_pc()
print(f"Gaming PC: {gaming_pc}")

office_builder = OfficeComputerBuilder()
office_pc = office_builder.build_office_pc()
print(f"Office PC: {office_pc}")
```

---

## Common Mistakes and Pitfalls

### Singleton Issues

```python
# WRONG: Not thread-safe
class Singleton:
    _instance = None
    
    def __new__(cls):
        if cls._instance is None:
            cls._instance = super().__new__(cls)  # Race condition!
        return cls._instance

# CORRECT: Thread-safe
class Singleton:
    _instance = None
    _lock = threading.Lock()
    
    def __new__(cls):
        if cls._instance is None:
            with cls._lock:
                if cls._instance is None:
                    cls._instance = super().__new__(cls)
        return cls._instance
```

### Factory Issues

```python
# WRONG: Hard to extend
class Factory:
    @staticmethod
    def create(type):
        if type == "A":
            return A()
        elif type == "B":
            return B()
        # Adding new type requires modifying this method

# CORRECT: Registry pattern
class Factory:
    _creators = {}
    
    @classmethod
    def register(cls, type_name, creator):
        cls._creators[type_name] = creator
    
    @classmethod
    def create(cls, type_name):
        creator = cls._creators.get(type_name)
        if creator:
            return creator()
        raise ValueError(f"Unknown type: {type_name}")

# Register types
Factory.register("A", A)
Factory.register("B", B)
```

---

## Best Practices

### 1. Use Patterns Appropriately

```python
# Don't overuse patterns
# Simple code is better than pattern-heavy code
# Use patterns when they solve real problems
```

### 2. Document Pattern Usage

```python
class DatabaseConnection(metaclass=SingletonMeta):
    """Database connection singleton.
    
    This class uses the Singleton pattern to ensure only one
    database connection exists throughout the application.
    """
    pass
```

### 3. Consider Alternatives

```python
# Sometimes simpler solutions are better
# Singleton: Consider dependency injection
# Factory: Consider simple if-else
# Builder: Consider dataclasses with defaults
```

---

## Practice Exercise

### Exercise: Creational Patterns

**Objective**: Implement creational patterns in a practical scenario.

**Requirements**:

1. Create a system using creational patterns:
   - Singleton for configuration
   - Factory for creating different types of objects
   - Builder for constructing complex objects

2. Scenario: E-commerce system
   - Configuration manager (Singleton)
   - Payment processor factory
   - Order builder

**Example Solution**:

```python
"""
E-commerce System with Creational Patterns
"""

import threading
from abc import ABC, abstractmethod
from typing import List, Dict, Optional
from datetime import datetime

# Singleton: Configuration Manager
class ConfigManager(metaclass=type('SingletonMeta', (type,), {
    '_instances': {},
    '__call__': lambda cls, *args, **kwargs: (
        cls._instances.setdefault(cls, super(type('SingletonMeta', (type,), {}), cls).__call__(*args, **kwargs))
    )
})):
    """Singleton configuration manager."""
    
    def __init__(self):
        self.config = {
            'tax_rate': 0.10,
            'shipping_cost': 5.00,
            'currency': 'USD',
            'max_order_items': 100
        }
    
    def get(self, key, default=None):
        return self.config.get(key, default)

# Factory: Payment Processor
class PaymentProcessor(ABC):
    @abstractmethod
    def process_payment(self, amount: float) -> bool:
        pass

class CreditCardProcessor(PaymentProcessor):
    def process_payment(self, amount: float) -> bool:
        print(f"Processing ${amount:.2f} via Credit Card")
        return True

class PayPalProcessor(PaymentProcessor):
    def process_payment(self, amount: float) -> bool:
        print(f"Processing ${amount:.2f} via PayPal")
        return True

class BankTransferProcessor(PaymentProcessor):
    def process_payment(self, amount: float) -> bool:
        print(f"Processing ${amount:.2f} via Bank Transfer")
        return True

class PaymentProcessorFactory:
    """Factory for creating payment processors."""
    
    @staticmethod
    def create_processor(payment_type: str) -> PaymentProcessor:
        processors = {
            'credit_card': CreditCardProcessor,
            'paypal': PayPalProcessor,
            'bank_transfer': BankTransferProcessor
        }
        
        processor_class = processors.get(payment_type.lower())
        if processor_class:
            return processor_class()
        else:
            raise ValueError(f"Unknown payment type: {payment_type}")

# Builder: Order
class Order:
    def __init__(self):
        self.items: List[Dict] = []
        self.shipping_address: Optional[str] = None
        self.billing_address: Optional[str] = None
        self.payment_method: Optional[str] = None
        self.discount_code: Optional[str] = None
        self.created_at: Optional[datetime] = None
        self.total: float = 0.0
    
    def calculate_total(self, config: ConfigManager):
        """Calculate order total with tax and shipping."""
        subtotal = sum(item['price'] * item['quantity'] for item in self.items)
        
        # Apply discount
        if self.discount_code:
            subtotal *= 0.9  # 10% discount
        
        # Add shipping
        shipping = config.get('shipping_cost', 0)
        
        # Add tax
        tax = subtotal * config.get('tax_rate', 0)
        
        self.total = subtotal + shipping + tax
        return self.total
    
    def __str__(self):
        return (f"Order: {len(self.items)} items, "
                f"Total: ${self.total:.2f}, "
                f"Payment: {self.payment_method}")

class OrderBuilder:
    """Builder for constructing orders."""
    
    def __init__(self):
        self.order = Order()
    
    def add_item(self, product_id: int, name: str, price: float, quantity: int = 1):
        """Add item to order."""
        self.order.items.append({
            'product_id': product_id,
            'name': name,
            'price': price,
            'quantity': quantity
        })
        return self
    
    def set_shipping_address(self, address: str):
        """Set shipping address."""
        self.order.shipping_address = address
        return self
    
    def set_billing_address(self, address: str):
        """Set billing address."""
        self.order.billing_address = address
        return self
    
    def set_payment_method(self, method: str):
        """Set payment method."""
        self.order.payment_method = method
        return self
    
    def set_discount_code(self, code: str):
        """Set discount code."""
        self.order.discount_code = code
        return self
    
    def build(self, config: Optional[ConfigManager] = None):
        """Build and finalize order."""
        if config is None:
            config = ConfigManager()
        
        self.order.created_at = datetime.utcnow()
        self.order.calculate_total(config)
        return self.order

# Usage Example
def main():
    # Get configuration (Singleton)
    config = ConfigManager()
    config2 = ConfigManager()
    print(f"Same instance: {config is config2}")  # True
    
    # Build order (Builder)
    order = (OrderBuilder()
             .add_item(1, "Laptop", 999.99, 1)
             .add_item(2, "Mouse", 29.99, 2)
             .set_shipping_address("123 Main St")
             .set_billing_address("123 Main St")
             .set_payment_method("credit_card")
             .set_discount_code("SAVE10")
             .build(config))
    
    print(order)
    
    # Process payment (Factory)
    processor = PaymentProcessorFactory.create_processor(order.payment_method)
    processor.process_payment(order.total)

if __name__ == '__main__':
    main()
```

**Expected Output**: A complete e-commerce system demonstrating all three creational patterns.

**Challenge** (Optional):
- Add more payment processors
- Add order validation
- Add order history (using Singleton)
- Create order templates (using Factory)
- Add more builder methods

---

## Key Takeaways

1. **Design Patterns** - Reusable solutions to common problems
2. **Creational Patterns** - Focus on object creation
3. **Singleton** - Ensure only one instance exists
4. **Factory** - Create objects without specifying exact class
5. **Builder** - Construct complex objects step by step
6. **Thread Safety** - Important for Singleton in multi-threaded environments
7. **Flexibility** - Patterns provide flexibility and extensibility
8. **When to Use** - Use patterns when they solve real problems
9. **Don't Overuse** - Simple code is often better
10. **Documentation** - Document pattern usage
11. **Best Practices** - Use patterns appropriately
12. **Common Mistakes** - Thread safety, extensibility
13. **Pattern Combinations** - Patterns can be combined
14. **Real-World Applications** - Patterns solve real problems
15. **Learning** - Study existing pattern implementations

---

## Quiz: Creational Patterns

Test your understanding with these questions:

1. **What is the Singleton pattern?**
   - A) Multiple instances
   - B) One instance only
   - C) No instances
   - D) Shared instances

2. **What ensures thread-safe Singleton?**
   - A) Locks
   - B) Double-check locking
   - C) Threading
   - D) All of the above

3. **What does Factory pattern do?**
   - A) Creates objects
   - B) Manages objects
   - C) Destroys objects
   - D) Clones objects

4. **What is Factory Method?**
   - A) Static method
   - B) Abstract method for creation
   - C) Instance method
   - D) Class method

5. **What is Abstract Factory?**
   - A) Creates families of objects
   - B) Creates single objects
   - C) Creates clones
   - D) Creates copies

6. **What does Builder pattern do?**
   - A) Destroys objects
   - B) Constructs complex objects
   - C) Clones objects
   - D) Manages objects

7. **What is Builder's advantage?**
   - A) Simple construction
   - B) Step-by-step construction
   - C) Fast construction
   - D) Automatic construction

8. **When to use Singleton?**
   - A) Multiple instances needed
   - B) One instance needed
   - C) No instances needed
   - D) Shared instances

9. **When to use Factory?**
   - A) Simple object creation
   - B) Complex object creation
   - C) Object destruction
   - D) Object cloning

10. **When to use Builder?**
    - A) Simple objects
    - B) Complex objects with many parameters
    - C) Small objects
    - D) Temporary objects

**Answers**:
1. B) One instance only (Singleton definition)
2. D) All of the above (thread safety methods)
3. A) Creates objects (Factory purpose)
4. B) Abstract method for creation (Factory Method)
5. A) Creates families of objects (Abstract Factory)
6. B) Constructs complex objects (Builder purpose)
7. B) Step-by-step construction (Builder advantage)
8. B) One instance needed (Singleton use case)
9. B) Complex object creation (Factory use case)
10. B) Complex objects with many parameters (Builder use case)

---

## Next Steps

Excellent work! You've mastered creational patterns. You now understand:
- Singleton pattern
- Factory pattern
- Builder pattern
- How to apply patterns in real scenarios

**What's Next?**
- Lesson 25.2: Structural Patterns
- Learn Adapter, Decorator, Facade patterns
- Understand structural design patterns
- Apply patterns to code structure

---

## Additional Resources

- **Design Patterns**: [refactoring.guru/design-patterns](https://refactoring.guru/design-patterns)
- **Python Design Patterns**: [python-patterns.guide/](https://python-patterns.guide/)
- **Gang of Four**: Original design patterns book
- **Pattern Examples**: Study real-world implementations

---

*Lesson completed! You're ready to move on to the next lesson.*

