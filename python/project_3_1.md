# Project 3.1: SQLite with Python

## Learning Objectives

By the end of this project, you will be able to:
- Understand what SQLite is and its advantages
- Use the sqlite3 module effectively
- Create and manage SQLite databases
- Perform CRUD operations (Create, Read, Update, Delete)
- Execute SQL queries
- Handle database transactions
- Work with database connections and cursors
- Handle errors and exceptions
- Use prepared statements
- Create database schemas
- Build practical database applications
- Apply best practices for database operations
- Debug database-related issues

---

## Introduction to SQLite

**SQLite** is a lightweight, file-based database engine that doesn't require a separate server process. It's embedded directly into applications and stores data in a single file.

**Key Features**:
- **Zero configuration**: No server setup required
- **File-based**: Database stored in a single file
- **SQL compliant**: Supports standard SQL
- **Lightweight**: Small footprint, perfect for small to medium applications
- **Built-in**: Included with Python (sqlite3 module)

**Use Cases**:
- Desktop applications
- Mobile applications
- Small web applications
- Data analysis and processing
- Prototyping
- Testing

---

## sqlite3 Module

### Basic Connection

```python
import sqlite3

# Connect to database (creates if doesn't exist)
conn = sqlite3.connect('example.db')

# Create cursor
cursor = conn.cursor()

# Close connection
conn.close()
```

### Using Context Managers

```python
import sqlite3

# Automatic connection management
with sqlite3.connect('example.db') as conn:
    cursor = conn.cursor()
    # Database operations
    # Connection automatically closed
```

---

## Database Operations

### Creating Tables

```python
import sqlite3

conn = sqlite3.connect('example.db')
cursor = conn.cursor()

# Create table
cursor.execute('''
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT UNIQUE NOT NULL,
        age INTEGER,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
''')

# Commit changes
conn.commit()
conn.close()
```

### Inserting Data

```python
import sqlite3

conn = sqlite3.connect('example.db')
cursor = conn.cursor()

# Insert single record
cursor.execute('''
    INSERT INTO users (name, email, age)
    VALUES (?, ?, ?)
''', ('Alice', 'alice@example.com', 25))

# Insert multiple records
users = [
    ('Bob', 'bob@example.com', 30),
    ('Charlie', 'charlie@example.com', 35),
    ('David', 'david@example.com', 40)
]

cursor.executemany('''
    INSERT INTO users (name, email, age)
    VALUES (?, ?, ?)
''', users)

conn.commit()
conn.close()
```

### Querying Data

```python
import sqlite3

conn = sqlite3.connect('example.db')
cursor = conn.cursor()

# Fetch all records
cursor.execute('SELECT * FROM users')
all_users = cursor.fetchall()
print(all_users)

# Fetch one record
cursor.execute('SELECT * FROM users WHERE id = ?', (1,))
user = cursor.fetchone()
print(user)

# Fetch many records
cursor.execute('SELECT * FROM users LIMIT 2')
users = cursor.fetchmany(2)
print(users)

# Iterate over results
cursor.execute('SELECT * FROM users')
for row in cursor:
    print(row)

conn.close()
```

### Updating Data

```python
import sqlite3

conn = sqlite3.connect('example.db')
cursor = conn.cursor()

# Update single record
cursor.execute('''
    UPDATE users
    SET age = ?, email = ?
    WHERE id = ?
''', (26, 'alice.new@example.com', 1))

# Update multiple records
cursor.execute('''
    UPDATE users
    SET age = age + 1
    WHERE age < 30
''')

conn.commit()
conn.close()
```

### Deleting Data

```python
import sqlite3

conn = sqlite3.connect('example.db')
cursor = conn.cursor()

# Delete single record
cursor.execute('DELETE FROM users WHERE id = ?', (1,))

# Delete multiple records
cursor.execute('DELETE FROM users WHERE age < 25')

# Delete all records
cursor.execute('DELETE FROM users')

conn.commit()
conn.close()
```

---

## Advanced Operations

### Transactions

```python
import sqlite3

conn = sqlite3.connect('example.db')
cursor = conn.cursor()

try:
    # Begin transaction
    cursor.execute('INSERT INTO users (name, email) VALUES (?, ?)', 
                   ('User1', 'user1@example.com'))
    cursor.execute('INSERT INTO users (name, email) VALUES (?, ?)', 
                   ('User2', 'user2@example.com'))
    
    # Commit transaction
    conn.commit()
    print('Transaction committed')
except Exception as e:
    # Rollback on error
    conn.rollback()
    print(f'Transaction rolled back: {e}')
finally:
    conn.close()
```

### Error Handling

```python
import sqlite3

def safe_execute(conn, query, params=None):
    """Safely execute a query with error handling."""
    try:
        cursor = conn.cursor()
        if params:
            cursor.execute(query, params)
        else:
            cursor.execute(query)
        conn.commit()
        return cursor.fetchall() if query.strip().upper().startswith('SELECT') else None
    except sqlite3.IntegrityError as e:
        print(f'Integrity error: {e}')
        conn.rollback()
        return None
    except sqlite3.OperationalError as e:
        print(f'Operational error: {e}')
        conn.rollback()
        return None
    except Exception as e:
        print(f'Error: {e}')
        conn.rollback()
        return None

# Usage
conn = sqlite3.connect('example.db')
result = safe_execute(conn, 'SELECT * FROM users')
conn.close()
```

### Row Factories

```python
import sqlite3

conn = sqlite3.connect('example.db')

# Dictionary-like access
conn.row_factory = sqlite3.Row
cursor = conn.cursor()

cursor.execute('SELECT * FROM users WHERE id = ?', (1,))
row = cursor.fetchone()

# Access by column name
print(row['name'])
print(row['email'])
print(row['age'])

# Convert to dictionary
print(dict(row))

conn.close()
```

### Custom Row Factory

```python
import sqlite3

def dict_factory(cursor, row):
    """Convert row to dictionary."""
    return {col[0]: row[idx] for idx, col in enumerate(cursor.description)}

conn = sqlite3.connect('example.db')
conn.row_factory = dict_factory
cursor = conn.cursor()

cursor.execute('SELECT * FROM users')
for row in cursor:
    print(row)  # Now a dictionary

conn.close()
```

---

## Practical Examples

### Example 1: Contact Manager

```python
#!/usr/bin/env python3
"""
Contact Manager Database Application
"""

import sqlite3
from datetime import datetime
from typing import List, Dict, Optional

class ContactManager:
    def __init__(self, db_name='contacts.db'):
        self.db_name = db_name
        self.init_database()
    
    def init_database(self):
        """Initialize database and create tables."""
        with sqlite3.connect(self.db_name) as conn:
            cursor = conn.cursor()
            cursor.execute('''
                CREATE TABLE IF NOT EXISTS contacts (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL,
                    email TEXT UNIQUE,
                    phone TEXT,
                    address TEXT,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )
            ''')
            conn.commit()
    
    def add_contact(self, name: str, email: Optional[str] = None, 
                    phone: Optional[str] = None, address: Optional[str] = None) -> int:
        """Add a new contact."""
        with sqlite3.connect(self.db_name) as conn:
            cursor = conn.cursor()
            try:
                cursor.execute('''
                    INSERT INTO contacts (name, email, phone, address)
                    VALUES (?, ?, ?, ?)
                ''', (name, email, phone, address))
                conn.commit()
                return cursor.lastrowid
            except sqlite3.IntegrityError:
                print(f'Error: Email {email} already exists')
                return None
    
    def get_contact(self, contact_id: int) -> Optional[Dict]:
        """Get a contact by ID."""
        with sqlite3.connect(self.db_name) as conn:
            conn.row_factory = sqlite3.Row
            cursor = conn.cursor()
            cursor.execute('SELECT * FROM contacts WHERE id = ?', (contact_id,))
            row = cursor.fetchone()
            return dict(row) if row else None
    
    def get_all_contacts(self) -> List[Dict]:
        """Get all contacts."""
        with sqlite3.connect(self.db_name) as conn:
            conn.row_factory = sqlite3.Row
            cursor = conn.cursor()
            cursor.execute('SELECT * FROM contacts ORDER BY name')
            return [dict(row) for row in cursor.fetchall()]
    
    def search_contacts(self, query: str) -> List[Dict]:
        """Search contacts by name or email."""
        with sqlite3.connect(self.db_name) as conn:
            conn.row_factory = sqlite3.Row
            cursor = conn.cursor()
            cursor.execute('''
                SELECT * FROM contacts
                WHERE name LIKE ? OR email LIKE ?
                ORDER BY name
            ''', (f'%{query}%', f'%{query}%'))
            return [dict(row) for row in cursor.fetchall()]
    
    def update_contact(self, contact_id: int, name: Optional[str] = None,
                      email: Optional[str] = None, phone: Optional[str] = None,
                      address: Optional[str] = None) -> bool:
        """Update a contact."""
        with sqlite3.connect(self.db_name) as conn:
            cursor = conn.cursor()
            
            # Build update query dynamically
            updates = []
            params = []
            
            if name:
                updates.append('name = ?')
                params.append(name)
            if email:
                updates.append('email = ?')
                params.append(email)
            if phone:
                updates.append('phone = ?')
                params.append(phone)
            if address:
                updates.append('address = ?')
                params.append(address)
            
            if not updates:
                return False
            
            updates.append('updated_at = CURRENT_TIMESTAMP')
            params.append(contact_id)
            
            query = f'UPDATE contacts SET {", ".join(updates)} WHERE id = ?'
            cursor.execute(query, params)
            conn.commit()
            return cursor.rowcount > 0
    
    def delete_contact(self, contact_id: int) -> bool:
        """Delete a contact."""
        with sqlite3.connect(self.db_name) as conn:
            cursor = conn.cursor()
            cursor.execute('DELETE FROM contacts WHERE id = ?', (contact_id,))
            conn.commit()
            return cursor.rowcount > 0
    
    def get_statistics(self) -> Dict:
        """Get database statistics."""
        with sqlite3.connect(self.db_name) as conn:
            cursor = conn.cursor()
            cursor.execute('SELECT COUNT(*) FROM contacts')
            total = cursor.fetchone()[0]
            
            cursor.execute('SELECT COUNT(*) FROM contacts WHERE email IS NOT NULL')
            with_email = cursor.fetchone()[0]
            
            cursor.execute('SELECT COUNT(*) FROM contacts WHERE phone IS NOT NULL')
            with_phone = cursor.fetchone()[0]
            
            return {
                'total_contacts': total,
                'with_email': with_email,
                'with_phone': with_phone
            }

def main():
    # Create contact manager
    cm = ContactManager()
    
    # Add contacts
    print("Adding contacts...")
    cm.add_contact('Alice Smith', 'alice@example.com', '555-0101', '123 Main St')
    cm.add_contact('Bob Johnson', 'bob@example.com', '555-0102', '456 Oak Ave')
    cm.add_contact('Charlie Brown', 'charlie@example.com', '555-0103')
    
    # Get all contacts
    print("\nAll contacts:")
    contacts = cm.get_all_contacts()
    for contact in contacts:
        print(f"  {contact['name']} - {contact['email']}")
    
    # Search contacts
    print("\nSearching for 'Alice':")
    results = cm.search_contacts('Alice')
    for contact in results:
        print(f"  {contact['name']} - {contact['email']}")
    
    # Update contact
    print("\nUpdating contact...")
    cm.update_contact(1, phone='555-9999')
    
    # Get contact
    contact = cm.get_contact(1)
    print(f"\nContact details: {contact}")
    
    # Statistics
    stats = cm.get_statistics()
    print(f"\nStatistics: {stats}")

if __name__ == '__main__':
    main()
```

### Example 2: Task Manager

```python
#!/usr/bin/env python3
"""
Task Manager Database Application
"""

import sqlite3
from datetime import datetime
from typing import List, Dict, Optional

class TaskManager:
    def __init__(self, db_name='tasks.db'):
        self.db_name = db_name
        self.init_database()
    
    def init_database(self):
        """Initialize database."""
        with sqlite3.connect(self.db_name) as conn:
            cursor = conn.cursor()
            cursor.execute('''
                CREATE TABLE IF NOT EXISTS tasks (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    title TEXT NOT NULL,
                    description TEXT,
                    status TEXT DEFAULT 'pending',
                    priority TEXT DEFAULT 'medium',
                    due_date DATE,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    completed_at TIMESTAMP
                )
            ''')
            conn.commit()
    
    def add_task(self, title: str, description: Optional[str] = None,
                priority: str = 'medium', due_date: Optional[str] = None) -> int:
        """Add a new task."""
        with sqlite3.connect(self.db_name) as conn:
            cursor = conn.cursor()
            cursor.execute('''
                INSERT INTO tasks (title, description, priority, due_date)
                VALUES (?, ?, ?, ?)
            ''', (title, description, priority, due_date))
            conn.commit()
            return cursor.lastrowid
    
    def get_task(self, task_id: int) -> Optional[Dict]:
        """Get a task by ID."""
        with sqlite3.connect(self.db_name) as conn:
            conn.row_factory = sqlite3.Row
            cursor = conn.cursor()
            cursor.execute('SELECT * FROM tasks WHERE id = ?', (task_id,))
            row = cursor.fetchone()
            return dict(row) if row else None
    
    def get_tasks(self, status: Optional[str] = None, 
                  priority: Optional[str] = None) -> List[Dict]:
        """Get tasks with optional filters."""
        with sqlite3.connect(self.db_name) as conn:
            conn.row_factory = sqlite3.Row
            cursor = conn.cursor()
            
            query = 'SELECT * FROM tasks WHERE 1=1'
            params = []
            
            if status:
                query += ' AND status = ?'
                params.append(status)
            
            if priority:
                query += ' AND priority = ?'
                params.append(priority)
            
            query += ' ORDER BY created_at DESC'
            
            cursor.execute(query, params)
            return [dict(row) for row in cursor.fetchall()]
    
    def update_task_status(self, task_id: int, status: str) -> bool:
        """Update task status."""
        with sqlite3.connect(self.db_name) as conn:
            cursor = conn.cursor()
            
            if status == 'completed':
                cursor.execute('''
                    UPDATE tasks
                    SET status = ?, completed_at = CURRENT_TIMESTAMP
                    WHERE id = ?
                ''', (status, task_id))
            else:
                cursor.execute('''
                    UPDATE tasks
                    SET status = ?, completed_at = NULL
                    WHERE id = ?
                ''', (status, task_id))
            
            conn.commit()
            return cursor.rowcount > 0
    
    def delete_task(self, task_id: int) -> bool:
        """Delete a task."""
        with sqlite3.connect(self.db_name) as conn:
            cursor = conn.cursor()
            cursor.execute('DELETE FROM tasks WHERE id = ?', (task_id,))
            conn.commit()
            return cursor.rowcount > 0
    
    def get_statistics(self) -> Dict:
        """Get task statistics."""
        with sqlite3.connect(self.db_name) as conn:
            cursor = conn.cursor()
            
            cursor.execute('SELECT COUNT(*) FROM tasks')
            total = cursor.fetchone()[0]
            
            cursor.execute("SELECT COUNT(*) FROM tasks WHERE status = 'completed'")
            completed = cursor.fetchone()[0]
            
            cursor.execute("SELECT COUNT(*) FROM tasks WHERE status = 'pending'")
            pending = cursor.fetchone()[0]
            
            return {
                'total': total,
                'completed': completed,
                'pending': pending,
                'completion_rate': (completed / total * 100) if total > 0 else 0
            }

def main():
    tm = TaskManager()
    
    # Add tasks
    print("Adding tasks...")
    tm.add_task('Learn Python', 'Complete Python course', 'high')
    tm.add_task('Write documentation', 'Document the project', 'medium')
    tm.add_task('Review code', priority='low')
    
    # Get all tasks
    print("\nAll tasks:")
    tasks = tm.get_tasks()
    for task in tasks:
        print(f"  [{task['status']}] {task['title']} ({task['priority']})")
    
    # Get pending tasks
    print("\nPending tasks:")
    pending = tm.get_tasks(status='pending')
    for task in pending:
        print(f"  {task['title']}")
    
    # Complete a task
    print("\nCompleting task...")
    tm.update_task_status(1, 'completed')
    
    # Statistics
    stats = tm.get_statistics()
    print(f"\nStatistics: {stats}")

if __name__ == '__main__':
    main()
```

---

## Best Practices

### 1. Use Context Managers

```python
# Good: Automatic connection management
with sqlite3.connect('example.db') as conn:
    cursor = conn.cursor()
    cursor.execute('SELECT * FROM users')
    # Connection automatically closed
```

### 2. Use Prepared Statements

```python
# Good: Prevents SQL injection
cursor.execute('SELECT * FROM users WHERE id = ?', (user_id,))

# Bad: Vulnerable to SQL injection
cursor.execute(f'SELECT * FROM users WHERE id = {user_id}')
```

### 3. Handle Errors

```python
try:
    cursor.execute('INSERT INTO users (name) VALUES (?)', ('Alice',))
    conn.commit()
except sqlite3.IntegrityError:
    conn.rollback()
    print('Error: Duplicate entry')
```

### 4. Use Transactions

```python
# Group related operations
conn = sqlite3.connect('example.db')
try:
    cursor.execute('INSERT INTO users ...')
    cursor.execute('INSERT INTO profiles ...')
    conn.commit()
except:
    conn.rollback()
finally:
    conn.close()
```

---

## Practice Exercise

### Exercise: Database App

**Objective**: Create a complete database application.

**Requirements**:

1. Create a database application (e.g., library management, inventory system)
2. Implement CRUD operations
3. Add search functionality
4. Include error handling
5. Add statistics/reporting

**Example Solution**:

```python
#!/usr/bin/env python3
"""
Library Management System
A complete database application for managing a library
"""

import sqlite3
from datetime import datetime, timedelta
from typing import List, Dict, Optional

class LibraryManager:
    def __init__(self, db_name='library.db'):
        self.db_name = db_name
        self.init_database()
    
    def init_database(self):
        """Initialize database schema."""
        with sqlite3.connect(self.db_name) as conn:
            cursor = conn.cursor()
            
            # Books table
            cursor.execute('''
                CREATE TABLE IF NOT EXISTS books (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    title TEXT NOT NULL,
                    author TEXT NOT NULL,
                    isbn TEXT UNIQUE,
                    genre TEXT,
                    year INTEGER,
                    copies INTEGER DEFAULT 1,
                    available INTEGER DEFAULT 1,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )
            ''')
            
            # Members table
            cursor.execute('''
                CREATE TABLE IF NOT EXISTS members (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL,
                    email TEXT UNIQUE NOT NULL,
                    phone TEXT,
                    membership_date DATE DEFAULT CURRENT_DATE,
                    active INTEGER DEFAULT 1
                )
            ''')
            
            # Loans table
            cursor.execute('''
                CREATE TABLE IF NOT EXISTS loans (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    book_id INTEGER NOT NULL,
                    member_id INTEGER NOT NULL,
                    loan_date DATE DEFAULT CURRENT_DATE,
                    due_date DATE,
                    return_date DATE,
                    status TEXT DEFAULT 'active',
                    FOREIGN KEY (book_id) REFERENCES books(id),
                    FOREIGN KEY (member_id) REFERENCES members(id)
                )
            ''')
            
            conn.commit()
    
    # Book operations
    def add_book(self, title: str, author: str, isbn: Optional[str] = None,
                genre: Optional[str] = None, year: Optional[int] = None,
                copies: int = 1) -> int:
        """Add a new book."""
        with sqlite3.connect(self.db_name) as conn:
            cursor = conn.cursor()
            try:
                cursor.execute('''
                    INSERT INTO books (title, author, isbn, genre, year, copies, available)
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ''', (title, author, isbn, genre, year, copies, copies))
                conn.commit()
                return cursor.lastrowid
            except sqlite3.IntegrityError:
                print(f'Error: ISBN {isbn} already exists')
                return None
    
    def get_book(self, book_id: int) -> Optional[Dict]:
        """Get a book by ID."""
        with sqlite3.connect(self.db_name) as conn:
            conn.row_factory = sqlite3.Row
            cursor = conn.cursor()
            cursor.execute('SELECT * FROM books WHERE id = ?', (book_id,))
            row = cursor.fetchone()
            return dict(row) if row else None
    
    def search_books(self, query: str) -> List[Dict]:
        """Search books by title or author."""
        with sqlite3.connect(self.db_name) as conn:
            conn.row_factory = sqlite3.Row
            cursor = conn.cursor()
            cursor.execute('''
                SELECT * FROM books
                WHERE title LIKE ? OR author LIKE ? OR isbn LIKE ?
                ORDER BY title
            ''', (f'%{query}%', f'%{query}%', f'%{query}%'))
            return [dict(row) for row in cursor.fetchall()]
    
    # Member operations
    def add_member(self, name: str, email: str, phone: Optional[str] = None) -> int:
        """Add a new member."""
        with sqlite3.connect(self.db_name) as conn:
            cursor = conn.cursor()
            try:
                cursor.execute('''
                    INSERT INTO members (name, email, phone)
                    VALUES (?, ?, ?)
                ''', (name, email, phone))
                conn.commit()
                return cursor.lastrowid
            except sqlite3.IntegrityError:
                print(f'Error: Email {email} already exists')
                return None
    
    def get_member(self, member_id: int) -> Optional[Dict]:
        """Get a member by ID."""
        with sqlite3.connect(self.db_name) as conn:
            conn.row_factory = sqlite3.Row
            cursor = conn.cursor()
            cursor.execute('SELECT * FROM members WHERE id = ?', (member_id,))
            row = cursor.fetchone()
            return dict(row) if row else None
    
    # Loan operations
    def loan_book(self, book_id: int, member_id: int, days: int = 14) -> int:
        """Loan a book to a member."""
        with sqlite3.connect(self.db_name) as conn:
            cursor = conn.cursor()
            
            # Check if book is available
            cursor.execute('SELECT available FROM books WHERE id = ?', (book_id,))
            result = cursor.fetchone()
            if not result or result[0] <= 0:
                print('Error: Book is not available')
                return None
            
            # Calculate due date
            due_date = (datetime.now() + timedelta(days=days)).date()
            
            try:
                # Create loan
                cursor.execute('''
                    INSERT INTO loans (book_id, member_id, due_date)
                    VALUES (?, ?, ?)
                ''', (book_id, member_id, due_date))
                
                # Update book availability
                cursor.execute('''
                    UPDATE books SET available = available - 1
                    WHERE id = ?
                ''', (book_id,))
                
                conn.commit()
                return cursor.lastrowid
            except Exception as e:
                conn.rollback()
                print(f'Error creating loan: {e}')
                return None
    
    def return_book(self, loan_id: int) -> bool:
        """Return a book."""
        with sqlite3.connect(self.db_name) as conn:
            cursor = conn.cursor()
            
            # Get loan details
            cursor.execute('SELECT book_id FROM loans WHERE id = ?', (loan_id,))
            result = cursor.fetchone()
            if not result:
                print('Error: Loan not found')
                return False
            
            book_id = result[0]
            
            try:
                # Update loan
                cursor.execute('''
                    UPDATE loans
                    SET return_date = CURRENT_DATE, status = 'returned'
                    WHERE id = ?
                ''', (loan_id,))
                
                # Update book availability
                cursor.execute('''
                    UPDATE books SET available = available + 1
                    WHERE id = ?
                ''', (book_id,))
                
                conn.commit()
                return True
            except Exception as e:
                conn.rollback()
                print(f'Error returning book: {e}')
                return False
    
    def get_active_loans(self, member_id: Optional[int] = None) -> List[Dict]:
        """Get active loans."""
        with sqlite3.connect(self.db_name) as conn:
            conn.row_factory = sqlite3.Row
            cursor = conn.cursor()
            
            if member_id:
                cursor.execute('''
                    SELECT l.*, b.title, b.author, m.name as member_name
                    FROM loans l
                    JOIN books b ON l.book_id = b.id
                    JOIN members m ON l.member_id = m.id
                    WHERE l.status = 'active' AND l.member_id = ?
                    ORDER BY l.due_date
                ''', (member_id,))
            else:
                cursor.execute('''
                    SELECT l.*, b.title, b.author, m.name as member_name
                    FROM loans l
                    JOIN books b ON l.book_id = b.id
                    JOIN members m ON l.member_id = m.id
                    WHERE l.status = 'active'
                    ORDER BY l.due_date
                ''')
            
            return [dict(row) for row in cursor.fetchall()]
    
    def get_overdue_loans(self) -> List[Dict]:
        """Get overdue loans."""
        with sqlite3.connect(self.db_name) as conn:
            conn.row_factory = sqlite3.Row
            cursor = conn.cursor()
            cursor.execute('''
                SELECT l.*, b.title, b.author, m.name as member_name
                FROM loans l
                JOIN books b ON l.book_id = b.id
                JOIN members m ON l.member_id = m.id
                WHERE l.status = 'active' AND l.due_date < DATE('now')
                ORDER BY l.due_date
            ''')
            return [dict(row) for row in cursor.fetchall()]
    
    # Statistics
    def get_statistics(self) -> Dict:
        """Get library statistics."""
        with sqlite3.connect(self.db_name) as conn:
            cursor = conn.cursor()
            
            # Book statistics
            cursor.execute('SELECT COUNT(*) FROM books')
            total_books = cursor.fetchone()[0]
            
            cursor.execute('SELECT SUM(available) FROM books')
            available_books = cursor.fetchone()[0] or 0
            
            # Member statistics
            cursor.execute('SELECT COUNT(*) FROM members WHERE active = 1')
            active_members = cursor.fetchone()[0]
            
            # Loan statistics
            cursor.execute("SELECT COUNT(*) FROM loans WHERE status = 'active'")
            active_loans = cursor.fetchone()[0]
            
            cursor.execute("SELECT COUNT(*) FROM loans WHERE status = 'returned'")
            returned_loans = cursor.fetchone()[0]
            
            return {
                'total_books': total_books,
                'available_books': available_books,
                'loaned_books': total_books - available_books,
                'active_members': active_members,
                'active_loans': active_loans,
                'returned_loans': returned_loans
            }

def main():
    lm = LibraryManager()
    
    # Add books
    print("Adding books...")
    lm.add_book('Python Programming', 'John Doe', '1234567890', 'Programming', 2023, 3)
    lm.add_book('Database Design', 'Jane Smith', '0987654321', 'Computer Science', 2022, 2)
    
    # Add members
    print("\nAdding members...")
    lm.add_member('Alice Johnson', 'alice@example.com', '555-0101')
    lm.add_member('Bob Williams', 'bob@example.com', '555-0102')
    
    # Loan books
    print("\nLoaning books...")
    lm.loan_book(1, 1, days=14)
    lm.loan_book(2, 2, days=21)
    
    # Get active loans
    print("\nActive loans:")
    loans = lm.get_active_loans()
    for loan in loans:
        print(f"  {loan['member_name']} - {loan['title']} (Due: {loan['due_date']})")
    
    # Statistics
    stats = lm.get_statistics()
    print(f"\nLibrary Statistics:")
    print(f"  Total books: {stats['total_books']}")
    print(f"  Available: {stats['available_books']}")
    print(f"  Loaned: {stats['loaned_books']}")
    print(f"  Active members: {stats['active_members']}")
    print(f"  Active loans: {stats['active_loans']}")

if __name__ == '__main__':
    main()
```

**Expected Output**: A complete library management system with books, members, and loans.

**Challenge** (Optional):
- Add fine calculation for overdue books
- Add book reservations
- Add member history
- Create a CLI interface
- Add data export functionality

---

## Key Takeaways

1. **SQLite** - Lightweight, file-based database
2. **sqlite3 module** - Built-in Python module
3. **Connections** - Use context managers for automatic cleanup
4. **CRUD operations** - Create, Read, Update, Delete
5. **Transactions** - Group related operations
6. **Error handling** - Handle database errors gracefully
7. **Prepared statements** - Prevent SQL injection
8. **Row factories** - Customize row access
9. **Foreign keys** - Relate tables
10. **Best practices** - Context managers, prepared statements, error handling
11. **Database design** - Plan schema carefully
12. **Indexes** - Improve query performance
13. **Backup** - Regular database backups
14. **Testing** - Test database operations
15. **Documentation** - Document schema and operations

---

## Quiz: SQLite

Test your understanding with these questions:

1. **What is SQLite?**
   - A) Server-based database
   - B) File-based database
   - C) Cloud database
   - D) NoSQL database

2. **What module is used for SQLite?**
   - A) sqlite
   - B) sqlite3
   - C) database
   - D) db

3. **What connects to a database?**
   - A) sqlite3.connect()
   - B) sqlite3.open()
   - C) sqlite3.database()
   - D) sqlite3.create()

4. **What executes a query?**
   - A) cursor.query()
   - B) cursor.execute()
   - C) cursor.run()
   - D) cursor.sql()

5. **What commits changes?**
   - A) conn.save()
   - B) conn.commit()
   - C) conn.write()
   - D) conn.apply()

6. **What fetches all results?**
   - A) cursor.fetch()
   - B) cursor.fetchall()
   - C) cursor.get_all()
   - D) cursor.all()

7. **What prevents SQL injection?**
   - A) String formatting
   - B) Prepared statements
   - C) Validation
   - D) All of the above

8. **What is a transaction?**
   - A) Single operation
   - B) Group of operations
   - C) Database connection
   - D) Query result

9. **What rolls back changes?**
   - A) conn.undo()
   - B) conn.rollback()
   - C) conn.revert()
   - D) conn.cancel()

10. **What is a row factory?**
    - A) Creates rows
    - B) Formats row access
    - C) Validates rows
    - D) Deletes rows

**Answers**:
1. B) File-based database (SQLite type)
2. B) sqlite3 (Python module)
3. A) sqlite3.connect() (connect function)
4. B) cursor.execute() (execute query)
5. B) conn.commit() (commit changes)
6. B) cursor.fetchall() (fetch all results)
7. B) Prepared statements (prevent injection)
8. B) Group of operations (transaction)
9. B) conn.rollback() (rollback changes)
10. B) Formats row access (row factory)

---

## Next Steps

Excellent work! You've mastered SQLite with Python. You now understand:
- sqlite3 module
- Database operations
- How to build database applications

**What's Next?**
- Project 3.2: SQLAlchemy ORM
- Learn ORM concepts
- Work with SQLAlchemy
- Build ORM applications

---

## Additional Resources

- **SQLite Documentation**: [www.sqlite.org/docs.html](https://www.sqlite.org/docs.html)
- **Python sqlite3 Documentation**: [docs.python.org/3/library/sqlite3.html](https://docs.python.org/3/library/sqlite3.html)
- **SQL Tutorial**: Learn SQL basics
- **Database Design**: Best practices for database design

---

*Project completed! You're ready to move on to the next project.*

