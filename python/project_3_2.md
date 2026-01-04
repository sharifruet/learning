# Project 3.2: SQLAlchemy ORM

## Learning Objectives

By the end of this project, you will be able to:
- Understand ORM (Object-Relational Mapping) concepts
- Install and configure SQLAlchemy
- Define database models
- Create relationships between models
- Perform CRUD operations using ORM
- Write complex queries
- Use sessions for database operations
- Handle database migrations
- Work with relationships (one-to-many, many-to-many)
- Apply ORM best practices
- Build practical ORM applications
- Debug ORM-related issues

---

## Introduction to ORM

**ORM (Object-Relational Mapping)** is a programming technique that allows you to interact with databases using object-oriented code instead of writing SQL queries directly.

**Key Benefits**:
- **Abstraction**: Work with Python objects instead of SQL
- **Type Safety**: Python type checking
- **Relationships**: Easy handling of relationships
- **Database Agnostic**: Switch databases easily
- **Less SQL**: Write less raw SQL code

**SQLAlchemy** is the most popular ORM for Python, providing both a high-level ORM and a low-level SQL toolkit.

---

## Installation and Setup

### Installation

```bash
# Install SQLAlchemy
pip install sqlalchemy

# For SQLite (built-in, no additional driver needed)
# For PostgreSQL
pip install psycopg2-binary

# For MySQL
pip install pymysql

# Verify installation
python -c "import sqlalchemy; print(sqlalchemy.__version__)"
```

### Basic Setup

```python
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
from sqlalchemy.ext.declarative import declarative_base

# Create engine
engine = create_engine('sqlite:///example.db', echo=True)

# Create base class for models
Base = declarative_base()

# Create session factory
Session = sessionmaker(bind=engine)
session = Session()
```

---

## ORM Concepts

### What is an ORM?

**ORM** maps database tables to Python classes:
- **Table** → **Class**
- **Column** → **Attribute**
- **Row** → **Instance**
- **Relationship** → **Object reference**

### Benefits of ORM

1. **Productivity**: Write less code
2. **Maintainability**: Easier to maintain
3. **Type Safety**: IDE support and type checking
4. **Relationships**: Easy relationship handling
5. **Database Independence**: Switch databases easily

---

## Models and Relationships

### Defining Models

```python
from sqlalchemy import Column, Integer, String, ForeignKey, DateTime
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy.orm import relationship
from datetime import datetime

Base = declarative_base()

class User(Base):
    __tablename__ = 'users'
    
    id = Column(Integer, primary_key=True)
    name = Column(String(100), nullable=False)
    email = Column(String(100), unique=True, nullable=False)
    created_at = Column(DateTime, default=datetime.utcnow)
    
    # Relationship
    posts = relationship('Post', back_populates='author')
    
    def __repr__(self):
        return f'<User(id={self.id}, name={self.name})>'

class Post(Base):
    __tablename__ = 'posts'
    
    id = Column(Integer, primary_key=True)
    title = Column(String(200), nullable=False)
    content = Column(String, nullable=False)
    author_id = Column(Integer, ForeignKey('users.id'), nullable=False)
    created_at = Column(DateTime, default=datetime.utcnow)
    
    # Relationship
    author = relationship('User', back_populates='posts')
    
    def __repr__(self):
        return f'<Post(id={self.id}, title={self.title})>'
```

### Creating Tables

```python
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker

# Create engine
engine = create_engine('sqlite:///example.db', echo=True)

# Create all tables
Base.metadata.create_all(engine)

# Create session
Session = sessionmaker(bind=engine)
session = Session()
```

### Column Types

```python
from sqlalchemy import Column, Integer, String, Text, Boolean, DateTime, Float, Date

class Example(Base):
    __tablename__ = 'examples'
    
    id = Column(Integer, primary_key=True)
    name = Column(String(100))           # VARCHAR(100)
    description = Column(Text)          # TEXT
    active = Column(Boolean, default=True)  # BOOLEAN
    price = Column(Float)                # FLOAT
    created_at = Column(DateTime)        # DATETIME
    birth_date = Column(Date)           # DATE
```

### One-to-Many Relationship

```python
from sqlalchemy import Column, Integer, String, ForeignKey
from sqlalchemy.orm import relationship

class Author(Base):
    __tablename__ = 'authors'
    
    id = Column(Integer, primary_key=True)
    name = Column(String(100))
    
    # One-to-many: one author has many books
    books = relationship('Book', back_populates='author')

class Book(Base):
    __tablename__ = 'books'
    
    id = Column(Integer, primary_key=True)
    title = Column(String(200))
    author_id = Column(Integer, ForeignKey('authors.id'))
    
    # Many-to-one: many books belong to one author
    author = relationship('Author', back_populates='books')
```

### Many-to-Many Relationship

```python
from sqlalchemy import Column, Integer, String, Table, ForeignKey
from sqlalchemy.orm import relationship

# Association table
book_authors = Table('book_authors', Base.metadata,
    Column('book_id', Integer, ForeignKey('books.id')),
    Column('author_id', Integer, ForeignKey('authors.id'))
)

class Book(Base):
    __tablename__ = 'books'
    
    id = Column(Integer, primary_key=True)
    title = Column(String(200))
    
    # Many-to-many: books can have many authors
    authors = relationship('Author', secondary=book_authors, back_populates='books')

class Author(Base):
    __tablename__ = 'authors'
    
    id = Column(Integer, primary_key=True)
    name = Column(String(100))
    
    # Many-to-many: authors can have many books
    books = relationship('Book', secondary=book_authors, back_populates='authors')
```

---

## Queries

### Creating Records

```python
from sqlalchemy.orm import sessionmaker

Session = sessionmaker(bind=engine)
session = Session()

# Create a user
user = User(name='Alice', email='alice@example.com')
session.add(user)
session.commit()

# Create multiple users
users = [
    User(name='Bob', email='bob@example.com'),
    User(name='Charlie', email='charlie@example.com')
]
session.add_all(users)
session.commit()
```

### Reading Records

```python
# Get all users
all_users = session.query(User).all()

# Get user by ID
user = session.query(User).get(1)

# Get first user
first_user = session.query(User).first()

# Filter users
alice = session.query(User).filter(User.name == 'Alice').first()
users_by_email = session.query(User).filter(User.email.like('%@example.com')).all()

# Filter with multiple conditions
active_users = session.query(User).filter(
    User.name == 'Alice',
    User.email.isnot(None)
).all()
```

### Updating Records

```python
# Update a user
user = session.query(User).get(1)
user.name = 'Alice Updated'
user.email = 'alice.updated@example.com'
session.commit()

# Update multiple records
session.query(User).filter(User.name == 'Bob').update({'name': 'Robert'})
session.commit()
```

### Deleting Records

```python
# Delete a user
user = session.query(User).get(1)
session.delete(user)
session.commit()

# Delete multiple records
session.query(User).filter(User.name.like('Bob%')).delete()
session.commit()
```

### Advanced Queries

```python
# Order by
users = session.query(User).order_by(User.name).all()
users_desc = session.query(User).order_by(User.name.desc()).all()

# Limit
first_5 = session.query(User).limit(5).all()

# Offset
next_5 = session.query(User).offset(5).limit(5).all()

# Count
user_count = session.query(User).count()

# Aggregate functions
from sqlalchemy import func

avg_age = session.query(func.avg(User.age)).scalar()
max_age = session.query(func.max(User.age)).scalar()
min_age = session.query(func.min(User.age)).scalar()

# Group by
from sqlalchemy import func
user_counts = session.query(User.department, func.count(User.id)).group_by(User.department).all()

# Join
posts_with_authors = session.query(Post, User).join(User).all()

# Subquery
subquery = session.query(User.id).filter(User.age > 25).subquery()
users = session.query(User).filter(User.id.in_(subquery)).all()
```

### Querying Relationships

```python
# Get user's posts
user = session.query(User).get(1)
posts = user.posts  # Access relationship

# Get post's author
post = session.query(Post).get(1)
author = post.author  # Access relationship

# Query with joins
posts = session.query(Post).join(User).filter(User.name == 'Alice').all()

# Eager loading (reduce queries)
from sqlalchemy.orm import joinedload

users = session.query(User).options(joinedload(User.posts)).all()
```

---

## Complete Example: Blog Application

```python
#!/usr/bin/env python3
"""
Blog Application with SQLAlchemy ORM
"""

from sqlalchemy import create_engine, Column, Integer, String, Text, ForeignKey, DateTime
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy.orm import sessionmaker, relationship
from datetime import datetime

Base = declarative_base()

class User(Base):
    __tablename__ = 'users'
    
    id = Column(Integer, primary_key=True)
    username = Column(String(50), unique=True, nullable=False)
    email = Column(String(100), unique=True, nullable=False)
    created_at = Column(DateTime, default=datetime.utcnow)
    
    posts = relationship('Post', back_populates='author', cascade='all, delete-orphan')
    comments = relationship('Comment', back_populates='author')
    
    def __repr__(self):
        return f'<User(username={self.username})>'

class Post(Base):
    __tablename__ = 'posts'
    
    id = Column(Integer, primary_key=True)
    title = Column(String(200), nullable=False)
    content = Column(Text, nullable=False)
    author_id = Column(Integer, ForeignKey('users.id'), nullable=False)
    created_at = Column(DateTime, default=datetime.utcnow)
    updated_at = Column(DateTime, default=datetime.utcnow, onupdate=datetime.utcnow)
    
    author = relationship('User', back_populates='posts')
    comments = relationship('Comment', back_populates='post', cascade='all, delete-orphan')
    
    def __repr__(self):
        return f'<Post(title={self.title})>'

class Comment(Base):
    __tablename__ = 'comments'
    
    id = Column(Integer, primary_key=True)
    content = Column(Text, nullable=False)
    author_id = Column(Integer, ForeignKey('users.id'), nullable=False)
    post_id = Column(Integer, ForeignKey('posts.id'), nullable=False)
    created_at = Column(DateTime, default=datetime.utcnow)
    
    author = relationship('User', back_populates='comments')
    post = relationship('Post', back_populates='comments')
    
    def __repr__(self):
        return f'<Comment(id={self.id})>'

# Setup
engine = create_engine('sqlite:///blog.db', echo=True)
Base.metadata.create_all(engine)
Session = sessionmaker(bind=engine)

def main():
    session = Session()
    
    # Create users
    alice = User(username='alice', email='alice@example.com')
    bob = User(username='bob', email='bob@example.com')
    session.add_all([alice, bob])
    session.commit()
    
    # Create posts
    post1 = Post(title='First Post', content='Content of first post', author=alice)
    post2 = Post(title='Second Post', content='Content of second post', author=alice)
    post3 = Post(title='Third Post', content='Content of third post', author=bob)
    session.add_all([post1, post2, post3])
    session.commit()
    
    # Create comments
    comment1 = Comment(content='Great post!', author=bob, post=post1)
    comment2 = Comment(content='Thanks!', author=alice, post=post1)
    session.add_all([comment1, comment2])
    session.commit()
    
    # Query examples
    print("\nAll users:")
    users = session.query(User).all()
    for user in users:
        print(f"  {user.username} - {user.email}")
    
    print("\nAll posts:")
    posts = session.query(Post).all()
    for post in posts:
        print(f"  {post.title} by {post.author.username}")
    
    print("\nAlice's posts:")
    alice = session.query(User).filter(User.username == 'alice').first()
    for post in alice.posts:
        print(f"  {post.title}")
    
    print("\nComments on first post:")
    post1 = session.query(Post).first()
    for comment in post1.comments:
        print(f"  {comment.content} by {comment.author.username}")
    
    session.close()

if __name__ == '__main__':
    main()
```

---

## Advanced Features

### Query Filters

```python
# Comparison operators
users = session.query(User).filter(User.age > 25).all()
users = session.query(User).filter(User.age >= 25).all()
users = session.query(User).filter(User.age < 30).all()
users = session.query(User).filter(User.age <= 30).all()
users = session.query(User).filter(User.age != 25).all()

# Like and ILike
users = session.query(User).filter(User.name.like('A%')).all()
users = session.query(User).filter(User.name.ilike('a%')).all()  # Case-insensitive

# In
users = session.query(User).filter(User.id.in_([1, 2, 3])).all()

# Is None / Is Not None
users = session.query(User).filter(User.email.is_(None)).all()
users = session.query(User).filter(User.email.isnot(None)).all()

# And / Or
from sqlalchemy import and_, or_

users = session.query(User).filter(
    and_(User.age > 25, User.email.isnot(None))
).all()

users = session.query(User).filter(
    or_(User.name == 'Alice', User.name == 'Bob')
).all()
```

### Eager Loading

```python
from sqlalchemy.orm import joinedload, subqueryload

# Eager load relationships to avoid N+1 queries
users = session.query(User).options(joinedload(User.posts)).all()

# For one-to-many, use subqueryload
users = session.query(User).options(subqueryload(User.posts)).all()

# Load multiple relationships
users = session.query(User).options(
    joinedload(User.posts),
    joinedload(User.comments)
).all()
```

### Transactions

```python
# Manual transaction
session.begin()
try:
    user = User(name='Alice', email='alice@example.com')
    session.add(user)
    session.commit()
except:
    session.rollback()
    raise

# Context manager
with session.begin():
    user = User(name='Bob', email='bob@example.com')
    session.add(user)
```

---

## Best Practices

### 1. Use Sessions Properly

```python
# Good: Use context manager
with Session() as session:
    user = session.query(User).get(1)
    # Session automatically closed

# Good: Always close session
session = Session()
try:
    # Operations
    pass
finally:
    session.close()
```

### 2. Use Relationships

```python
# Good: Use relationships
user.posts.append(post)

# Avoid: Manual foreign key management
post.author_id = user.id
```

### 3. Use Eager Loading

```python
# Good: Eager load to avoid N+1 queries
users = session.query(User).options(joinedload(User.posts)).all()

# Bad: Causes N+1 queries
users = session.query(User).all()
for user in users:
    posts = user.posts  # Separate query for each user
```

### 4. Use Transactions

```python
# Group related operations in transactions
with session.begin():
    user = User(name='Alice')
    session.add(user)
    post = Post(title='Post', author=user)
    session.add(post)
```

---

## Practice Exercise

### Exercise: ORM Application

**Objective**: Create a complete ORM application.

**Requirements**:

1. Create an ORM application (e.g., e-commerce, social media, task management)
2. Define models with relationships
3. Implement CRUD operations
4. Add complex queries
5. Use relationships effectively

**Example Solution**:

```python
#!/usr/bin/env python3
"""
E-commerce Application with SQLAlchemy ORM
"""

from sqlalchemy import create_engine, Column, Integer, String, Float, ForeignKey, Table, DateTime
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy.orm import sessionmaker, relationship
from datetime import datetime

Base = declarative_base()

# Association table for many-to-many
order_items = Table('order_items', Base.metadata,
    Column('order_id', Integer, ForeignKey('orders.id')),
    Column('product_id', Integer, ForeignKey('products.id')),
    Column('quantity', Integer, default=1)
)

class Customer(Base):
    __tablename__ = 'customers'
    
    id = Column(Integer, primary_key=True)
    name = Column(String(100), nullable=False)
    email = Column(String(100), unique=True, nullable=False)
    phone = Column(String(20))
    created_at = Column(DateTime, default=datetime.utcnow)
    
    orders = relationship('Order', back_populates='customer', cascade='all, delete-orphan')
    
    def __repr__(self):
        return f'<Customer(name={self.name})>'

class Product(Base):
    __tablename__ = 'products'
    
    id = Column(Integer, primary_key=True)
    name = Column(String(200), nullable=False)
    description = Column(Text)
    price = Column(Float, nullable=False)
    stock = Column(Integer, default=0)
    created_at = Column(DateTime, default=datetime.utcnow)
    
    orders = relationship('Order', secondary=order_items, back_populates='products')
    
    def __repr__(self):
        return f'<Product(name={self.name}, price={self.price})>'

class Order(Base):
    __tablename__ = 'orders'
    
    id = Column(Integer, primary_key=True)
    customer_id = Column(Integer, ForeignKey('customers.id'), nullable=False)
    total = Column(Float, default=0.0)
    status = Column(String(20), default='pending')
    created_at = Column(DateTime, default=datetime.utcnow)
    
    customer = relationship('Customer', back_populates='orders')
    products = relationship('Product', secondary=order_items, back_populates='orders')
    
    def __repr__(self):
        return f'<Order(id={self.id}, total={self.total})>'

# Setup
engine = create_engine('sqlite:///ecommerce.db', echo=True)
Base.metadata.create_all(engine)
Session = sessionmaker(bind=engine)

class ECommerceManager:
    def __init__(self):
        self.session = Session()
    
    def add_customer(self, name, email, phone=None):
        """Add a new customer."""
        customer = Customer(name=name, email=email, phone=phone)
        self.session.add(customer)
        self.session.commit()
        return customer
    
    def add_product(self, name, description, price, stock=0):
        """Add a new product."""
        product = Product(name=name, description=description, price=price, stock=stock)
        self.session.add(product)
        self.session.commit()
        return product
    
    def create_order(self, customer_id, product_ids, quantities):
        """Create an order."""
        customer = self.session.query(Customer).get(customer_id)
        if not customer:
            return None
        
        order = Order(customer=customer)
        total = 0.0
        
        for product_id, quantity in zip(product_ids, quantities):
            product = self.session.query(Product).get(product_id)
            if product and product.stock >= quantity:
                order.products.append(product)
                total += product.price * quantity
                product.stock -= quantity
            else:
                self.session.rollback()
                return None
        
        order.total = total
        self.session.add(order)
        self.session.commit()
        return order
    
    def get_customer_orders(self, customer_id):
        """Get all orders for a customer."""
        customer = self.session.query(Customer).get(customer_id)
        return customer.orders if customer else []
    
    def get_order_details(self, order_id):
        """Get order details."""
        order = self.session.query(Order).get(order_id)
        return order
    
    def get_products_by_price_range(self, min_price, max_price):
        """Get products in price range."""
        return self.session.query(Product).filter(
            Product.price >= min_price,
            Product.price <= max_price
        ).all()
    
    def get_top_customers(self, limit=5):
        """Get top customers by order total."""
        from sqlalchemy import func
        
        return self.session.query(
            Customer,
            func.sum(Order.total).label('total_spent')
        ).join(Order).group_by(Customer.id).order_by(
            func.sum(Order.total).desc()
        ).limit(limit).all()
    
    def close(self):
        """Close session."""
        self.session.close()

def main():
    manager = ECommerceManager()
    
    # Add customers
    print("Adding customers...")
    customer1 = manager.add_customer('Alice', 'alice@example.com', '555-0101')
    customer2 = manager.add_customer('Bob', 'bob@example.com', '555-0102')
    
    # Add products
    print("\nAdding products...")
    product1 = manager.add_product('Laptop', 'High-performance laptop', 999.99, 10)
    product2 = manager.add_product('Mouse', 'Wireless mouse', 29.99, 50)
    product3 = manager.add_product('Keyboard', 'Mechanical keyboard', 79.99, 30)
    
    # Create orders
    print("\nCreating orders...")
    order1 = manager.create_order(customer1.id, [product1.id, product2.id], [1, 2])
    order2 = manager.create_order(customer2.id, [product3.id], [1])
    
    # Get customer orders
    print("\nAlice's orders:")
    orders = manager.get_customer_orders(customer1.id)
    for order in orders:
        print(f"  Order #{order.id}: ${order.total:.2f}")
        for product in order.products:
            print(f"    - {product.name}")
    
    # Get products by price
    print("\nProducts under $100:")
    products = manager.get_products_by_price_range(0, 100)
    for product in products:
        print(f"  {product.name}: ${product.price:.2f}")
    
    # Get top customers
    print("\nTop customers:")
    top_customers = manager.get_top_customers()
    for customer, total_spent in top_customers:
        print(f"  {customer.name}: ${total_spent:.2f}")
    
    manager.close()

if __name__ == '__main__':
    main()
```

**Expected Output**: A complete e-commerce application with customers, products, and orders.

**Challenge** (Optional):
- Add product categories
- Add order status tracking
- Add payment processing
- Add inventory management
- Create a REST API

---

## Key Takeaways

1. **ORM** - Object-Relational Mapping
2. **SQLAlchemy** - Popular Python ORM
3. **Models** - Python classes representing database tables
4. **Relationships** - One-to-many, many-to-many
5. **Sessions** - Database connection and transaction management
6. **Queries** - Query API instead of raw SQL
7. **CRUD operations** - Create, Read, Update, Delete
8. **Eager loading** - Optimize relationship queries
9. **Transactions** - Group related operations
10. **Best practices** - Proper session management, use relationships
11. **Migrations** - Database schema changes (use Alembic)
12. **Type safety** - Python type checking
13. **Database independence** - Switch databases easily
14. **Performance** - Optimize queries with eager loading
15. **Maintainability** - Easier to maintain than raw SQL

---

## Quiz: SQLAlchemy

Test your understanding with these questions:

1. **What does ORM stand for?**
   - A) Object-Relational Mapping
   - B) Object-Relational Model
   - C) Object-Reference Mapping
   - D) Object-Resource Mapping

2. **What is SQLAlchemy?**
   - A) Database server
   - B) Python ORM
   - C) SQL parser
   - D) Database driver

3. **What creates a database engine?**
   - A) create_engine()
   - B) engine()
   - C) connect()
   - D) database()

4. **What is a Base class?**
   - A) Base model class
   - B) Database connection
   - C) Query builder
   - D) Session manager

5. **What defines a model?**
   - A) Class inheriting from Base
   - B) Function
   - C) Dictionary
   - D) List

6. **What creates a relationship?**
   - A) relationship()
   - B) relate()
   - C) link()
   - D) connect()

7. **What executes a query?**
   - A) session.query()
   - B) session.execute()
   - C) session.get()
   - D) session.find()

8. **What commits changes?**
   - A) session.save()
   - B) session.commit()
   - C) session.write()
   - D) session.apply()

9. **What is eager loading?**
   - A) Load relationships in one query
   - B) Load all data
   - C) Fast loading
   - D) Lazy loading

10. **What is a session?**
    - A) Database connection
    - B) Transaction manager
    - C) Query builder
    - D) All of the above

**Answers**:
1. A) Object-Relational Mapping (ORM definition)
2. B) Python ORM (SQLAlchemy)
3. A) create_engine() (create engine)
4. A) Base model class (Base class)
5. A) Class inheriting from Base (model definition)
6. A) relationship() (create relationship)
7. A) session.query() (execute query)
8. B) session.commit() (commit changes)
9. A) Load relationships in one query (eager loading)
10. D) All of the above (session purpose)

---

## Next Steps

Excellent work! You've mastered SQLAlchemy ORM. You now understand:
- ORM concepts
- Models and relationships
- Queries
- How to build ORM applications

**What's Next?**
- Project 4.1: File Automation
- Learn batch file processing
- Work with file automation
- Build automation scripts

---

## Additional Resources

- **SQLAlchemy Documentation**: [docs.sqlalchemy.org/](https://docs.sqlalchemy.org/)
- **SQLAlchemy Tutorial**: [docs.sqlalchemy.org/en/14/tutorial/](https://docs.sqlalchemy.org/en/14/tutorial/)
- **Alembic (Migrations)**: [alembic.sqlalchemy.org/](https://alembic.sqlalchemy.org/)
- **SQLAlchemy ORM Tutorial**: Learn ORM patterns

---

*Project completed! You're ready to move on to the next project.*

