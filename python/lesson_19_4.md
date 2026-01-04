# Lesson 19.4: Django Framework (Introduction)

## Learning Objectives

By the end of this lesson, you will be able to:
- Install and set up Django
- Understand Django project structure
- Create Django projects and apps
- Work with Django models
- Create views and templates
- Understand the MVT pattern
- Use Django admin interface
- Handle URLs and routing
- Work with Django settings
- Build basic Django applications
- Apply Django best practices
- Debug Django applications

---

## Introduction to Django

Django is a high-level Python web framework that encourages rapid development and clean, pragmatic design. It follows the Model-View-Template (MVT) architectural pattern.

**Key Features**:
- Batteries included (many built-in features)
- ORM (Object-Relational Mapping)
- Admin interface
- Security features
- Scalable architecture
- Large community

---

## Django Installation

### Installing Django

```bash
# Install Django using pip
pip install django

# Install specific version
pip install django==4.2.0

# Verify installation
python -m django --version
```

### Creating a Virtual Environment

```bash
# Create virtual environment
python -m venv venv

# Activate (Windows)
venv\Scripts\activate

# Activate (macOS/Linux)
source venv/bin/activate

# Install Django in virtual environment
pip install django
```

### Creating a Django Project

```bash
# Create a new Django project
django-admin startproject myproject

# This creates:
# myproject/
#   manage.py
#   myproject/
#     __init__.py
#     settings.py
#     urls.py
#     wsgi.py
#     asgi.py
```

### Running the Development Server

```bash
# Navigate to project directory
cd myproject

# Run development server
python manage.py runserver

# Run on specific port
python manage.py runserver 8080

# Run on specific IP and port
python manage.py runserver 0.0.0.0:8000
```

### Creating a Django App

```bash
# Create a new app
python manage.py startapp myapp

# This creates:
# myapp/
#   __init__.py
#   admin.py
#   models.py
#   views.py
#   apps.py
#   tests.py
#   migrations/
#   __init__.py
```

---

## Project Structure

### Project Files

```
myproject/
├── manage.py              # Django management script
├── myproject/             # Project package
│   ├── __init__.py
│   ├── settings.py        # Project settings
│   ├── urls.py            # Root URL configuration
│   ├── wsgi.py            # WSGI configuration
│   └── asgi.py            # ASGI configuration
└── myapp/                 # App package
    ├── __init__.py
    ├── admin.py           # Admin configuration
    ├── models.py          # Database models
    ├── views.py           # View functions
    ├── urls.py            # App URL configuration
    ├── apps.py            # App configuration
    ├── tests.py           # Tests
    └── migrations/        # Database migrations
```

### Key Files Explained

**manage.py**: Django management script
```python
#!/usr/bin/env python
"""Django's command-line utility for administrative tasks."""
import os
import sys

if __name__ == '__main__':
    os.environ.setdefault('DJANGO_SETTINGS_MODULE', 'myproject.settings')
    try:
        from django.core.management import execute_from_command_line
    except ImportError as exc:
        raise ImportError(
            "Couldn't import Django."
        ) from exc
    execute_from_command_line(sys.argv)
```

**settings.py**: Project configuration
```python
"""
Django settings for myproject project.
"""

from pathlib import Path

# Build paths inside the project
BASE_DIR = Path(__file__).resolve().parent.parent

# SECURITY WARNING: keep the secret key used in production secret!
SECRET_KEY = 'django-insecure-your-secret-key-here'

# SECURITY WARNING: don't run with debug turned on in production!
DEBUG = True

ALLOWED_HOSTS = []

# Application definition
INSTALLED_APPS = [
    'django.contrib.admin',
    'django.contrib.auth',
    'django.contrib.contenttypes',
    'django.contrib.sessions',
    'django.contrib.messages',
    'django.contrib.staticfiles',
    'myapp',  # Your app
]

MIDDLEWARE = [
    'django.middleware.security.SecurityMiddleware',
    'django.contrib.sessions.middleware.SessionMiddleware',
    'django.middleware.common.CommonMiddleware',
    'django.middleware.csrf.CsrfViewMiddleware',
    'django.contrib.auth.middleware.AuthenticationMiddleware',
    'django.contrib.messages.middleware.MessageMiddleware',
    'django.middleware.clickjacking.XFrameOptionsMiddleware',
]

ROOT_URLCONF = 'myproject.urls'

TEMPLATES = [
    {
        'BACKEND': 'django.template.backends.django.DjangoTemplates',
        'DIRS': [],
        'APP_DIRS': True,
        'OPTIONS': {
            'context_processors': [
                'django.template.context_processors.debug',
                'django.template.context_processors.request',
                'django.contrib.auth.context_processors.auth',
                'django.contrib.messages.context_processors.messages',
            ],
        },
    },
]

WSGI_APPLICATION = 'myproject.wsgi.application'

# Database
DATABASES = {
    'default': {
        'ENGINE': 'django.db.backends.sqlite3',
        'NAME': BASE_DIR / 'db.sqlite3',
    }
}

# Password validation
AUTH_PASSWORD_VALIDATORS = [
    {
        'NAME': 'django.contrib.auth.password_validation.UserAttributeSimilarityValidator',
    },
    {
        'NAME': 'django.contrib.auth.password_validation.MinimumLengthValidator',
    },
    {
        'NAME': 'django.contrib.auth.password_validation.CommonPasswordValidator',
    },
    {
        'NAME': 'django.contrib.auth.password_validation.NumericPasswordValidator',
    },
]

# Internationalization
LANGUAGE_CODE = 'en-us'
TIME_ZONE = 'UTC'
USE_I18N = True
USE_TZ = True

# Static files (CSS, JavaScript, Images)
STATIC_URL = 'static/'

# Default primary key field type
DEFAULT_AUTO_FIELD = 'django.db.models.BigAutoField'
```

**urls.py**: URL routing
```python
from django.contrib import admin
from django.urls import path, include

urlpatterns = [
    path('admin/', admin.site.urls),
    path('', include('myapp.urls')),
]
```

---

## Models

### Defining Models

Models define the database structure:

```python
from django.db import models
from django.utils import timezone

class Post(models.Model):
    title = models.CharField(max_length=200)
    content = models.TextField()
    author = models.CharField(max_length=100)
    created_at = models.DateTimeField(default=timezone.now)
    published = models.BooleanField(default=False)
    
    def __str__(self):
        return self.title
    
    class Meta:
        ordering = ['-created_at']
```

### Field Types

```python
from django.db import models

class Example(models.Model):
    # Text fields
    char_field = models.CharField(max_length=100)
    text_field = models.TextField()
    slug_field = models.SlugField()
    email_field = models.EmailField()
    url_field = models.URLField()
    
    # Numeric fields
    integer_field = models.IntegerField()
    float_field = models.FloatField()
    decimal_field = models.DecimalField(max_digits=5, decimal_places=2)
    positive_integer = models.PositiveIntegerField()
    
    # Date/time fields
    date_field = models.DateField()
    time_field = models.TimeField()
    datetime_field = models.DateTimeField()
    auto_now = models.DateTimeField(auto_now=True)
    auto_now_add = models.DateTimeField(auto_now_add=True)
    
    # Boolean fields
    boolean_field = models.BooleanField()
    null_boolean = models.BooleanField(null=True)
    
    # File fields
    file_field = models.FileField(upload_to='uploads/')
    image_field = models.ImageField(upload_to='images/')
    
    # Foreign key
    foreign_key = models.ForeignKey('OtherModel', on_delete=models.CASCADE)
    
    # Many-to-many
    many_to_many = models.ManyToManyField('OtherModel')
    
    # One-to-one
    one_to_one = models.OneToOneField('OtherModel', on_delete=models.CASCADE)
```

### Model Relationships

```python
from django.db import models

class Author(models.Model):
    name = models.CharField(max_length=100)
    email = models.EmailField()
    
    def __str__(self):
        return self.name

class Book(models.Model):
    title = models.CharField(max_length=200)
    author = models.ForeignKey(Author, on_delete=models.CASCADE)
    published_date = models.DateField()
    
    def __str__(self):
        return self.title

class Category(models.Model):
    name = models.CharField(max_length=100)
    books = models.ManyToManyField(Book)
    
    def __str__(self):
        return self.name
```

### Migrations

```bash
# Create migrations
python manage.py makemigrations

# Apply migrations
python manage.py migrate

# Show migration status
python manage.py showmigrations

# Rollback migration
python manage.py migrate app_name migration_number
```

### Model Methods

```python
from django.db import models
from django.urls import reverse

class Post(models.Model):
    title = models.CharField(max_length=200)
    content = models.TextField()
    created_at = models.DateTimeField(auto_now_add=True)
    
    def __str__(self):
        return self.title
    
    def get_absolute_url(self):
        return reverse('post_detail', kwargs={'pk': self.pk})
    
    def get_excerpt(self, length=100):
        return self.content[:length] + '...' if len(self.content) > length else self.content
    
    class Meta:
        verbose_name = 'Post'
        verbose_name_plural = 'Posts'
        ordering = ['-created_at']
```

---

## Views

### Function-Based Views

```python
from django.shortcuts import render, get_object_or_404, redirect
from django.http import HttpResponse, Http404
from .models import Post

def index(request):
    posts = Post.objects.all()
    return render(request, 'myapp/index.html', {'posts': posts})

def post_detail(request, post_id):
    post = get_object_or_404(Post, pk=post_id)
    return render(request, 'myapp/post_detail.html', {'post': post})

def create_post(request):
    if request.method == 'POST':
        title = request.POST.get('title')
        content = request.POST.get('content')
        Post.objects.create(title=title, content=content)
        return redirect('index')
    return render(request, 'myapp/create_post.html')
```

### Class-Based Views

```python
from django.views.generic import ListView, DetailView, CreateView, UpdateView, DeleteView
from django.urls import reverse_lazy
from .models import Post

class PostListView(ListView):
    model = Post
    template_name = 'myapp/post_list.html'
    context_object_name = 'posts'
    paginate_by = 10

class PostDetailView(DetailView):
    model = Post
    template_name = 'myapp/post_detail.html'

class PostCreateView(CreateView):
    model = Post
    fields = ['title', 'content']
    template_name = 'myapp/post_form.html'
    success_url = reverse_lazy('post_list')

class PostUpdateView(UpdateView):
    model = Post
    fields = ['title', 'content']
    template_name = 'myapp/post_form.html'
    success_url = reverse_lazy('post_list')

class PostDeleteView(DeleteView):
    model = Post
    template_name = 'myapp/post_confirm_delete.html'
    success_url = reverse_lazy('post_list')
```

### Request and Response

```python
from django.http import HttpResponse, JsonResponse, HttpResponseRedirect
from django.shortcuts import render

def example_view(request):
    # Access request data
    method = request.method
    path = request.path
    user = request.user
    get_param = request.GET.get('param')
    post_data = request.POST.get('data')
    
    # Return responses
    return HttpResponse('Hello World')
    return JsonResponse({'key': 'value'})
    return HttpResponseRedirect('/redirect-url/')
    return render(request, 'template.html', {'context': 'data'})
```

---

## Templates

### Template Basics

Django uses its own template language:

```html
<!-- myapp/templates/myapp/index.html -->
<!DOCTYPE html>
<html>
<head>
    <title>{% block title %}My Site{% endblock %}</title>
</head>
<body>
    <h1>{% block heading %}Welcome{% endblock %}</h1>
    {% block content %}{% endblock %}
</body>
</html>
```

### Template Variables

```html
<h1>{{ post.title }}</h1>
<p>{{ post.content }}</p>
<p>Author: {{ post.author }}</p>
<p>Created: {{ post.created_at|date:"F d, Y" }}</p>
```

### Template Tags

```html
<!-- If statement -->
{% if user.is_authenticated %}
    <p>Welcome, {{ user.username }}!</p>
{% else %}
    <p>Please log in.</p>
{% endif %}

<!-- For loop -->
{% for post in posts %}
    <h2>{{ post.title }}</h2>
    <p>{{ post.content }}</p>
{% empty %}
    <p>No posts available.</p>
{% endfor %}

<!-- Include -->
{% include 'myapp/header.html' %}

<!-- Extends -->
{% extends 'myapp/base.html' %}
{% block content %}
    <h1>Content here</h1>
{% endblock %}
```

### Template Filters

```html
<!-- String filters -->
{{ name|upper }}
{{ name|lower }}
{{ name|title }}
{{ text|truncatewords:20 }}

<!-- Date filters -->
{{ date|date:"Y-m-d" }}
{{ date|time:"H:i" }}

<!-- Number filters -->
{{ number|floatformat:2 }}

<!-- Default value -->
{{ value|default:"N/A" }}

<!-- Length -->
{{ list|length }}
```

### Template Inheritance

```html
<!-- base.html -->
<!DOCTYPE html>
<html>
<head>
    <title>{% block title %}My Site{% endblock %}</title>
    {% block extra_css %}{% endblock %}
</head>
<body>
    <nav>
        <a href="/">Home</a>
        <a href="/about/">About</a>
    </nav>
    
    <main>
        {% block content %}{% endblock %}
    </main>
    
    {% block extra_js %}{% endblock %}
</body>
</html>
```

```html
<!-- post_detail.html -->
{% extends 'base.html' %}

{% block title %}{{ post.title }} - My Site{% endblock %}

{% block content %}
    <article>
        <h1>{{ post.title }}</h1>
        <p>{{ post.content }}</p>
        <p>Published: {{ post.created_at|date:"F d, Y" }}</p>
    </article>
{% endblock %}
```

---

## URLs and Routing

### URL Configuration

```python
# myapp/urls.py
from django.urls import path
from . import views

urlpatterns = [
    path('', views.index, name='index'),
    path('post/<int:post_id>/', views.post_detail, name='post_detail'),
    path('create/', views.create_post, name='create_post'),
]
```

### URL Patterns

```python
from django.urls import path, re_path
from . import views

urlpatterns = [
    # Simple path
    path('about/', views.about, name='about'),
    
    # Path with parameter
    path('post/<int:post_id>/', views.post_detail, name='post_detail'),
    
    # Path with string parameter
    path('user/<str:username>/', views.user_profile, name='user_profile'),
    
    # Path with slug
    path('post/<slug:slug>/', views.post_by_slug, name='post_by_slug'),
    
    # Regex path
    re_path(r'^articles/(?P<year>[0-9]{4})/$', views.articles_by_year),
]
```

### URL Namespacing

```python
# myapp/urls.py
from django.urls import path
from . import views

app_name = 'myapp'
urlpatterns = [
    path('', views.index, name='index'),
    path('post/<int:pk>/', views.post_detail, name='post_detail'),
]

# Usage in templates
{% url 'myapp:index' %}
{% url 'myapp:post_detail' pk=post.id %}
```

### Including URLs

```python
# myproject/urls.py
from django.contrib import admin
from django.urls import path, include

urlpatterns = [
    path('admin/', admin.site.urls),
    path('blog/', include('blog.urls')),
    path('shop/', include('shop.urls')),
]
```

---

## Django Admin

### Registering Models

```python
# myapp/admin.py
from django.contrib import admin
from .models import Post, Author

@admin.register(Post)
class PostAdmin(admin.ModelAdmin):
    list_display = ['title', 'author', 'created_at', 'published']
    list_filter = ['published', 'created_at']
    search_fields = ['title', 'content']
    date_hierarchy = 'created_at'
    ordering = ['-created_at']

admin.site.register(Author)
```

### Creating Admin User

```bash
# Create superuser
python manage.py createsuperuser

# Follow prompts:
# Username: admin
# Email: admin@example.com
# Password: (enter password)
```

### Customizing Admin

```python
from django.contrib import admin
from .models import Post

class PostAdmin(admin.ModelAdmin):
    list_display = ['title', 'author', 'created_at']
    list_editable = ['author']
    list_filter = ['created_at', 'author']
    search_fields = ['title', 'content']
    readonly_fields = ['created_at']
    fieldsets = (
        ('Basic Information', {
            'fields': ('title', 'author')
        }),
        ('Content', {
            'fields': ('content',)
        }),
        ('Metadata', {
            'fields': ('created_at', 'published')
        }),
    )
```

---

## Practical Examples

### Example 1: Simple Blog

```python
# myapp/models.py
from django.db import models
from django.utils import timezone

class Post(models.Model):
    title = models.CharField(max_length=200)
    content = models.TextField()
    author = models.CharField(max_length=100)
    created_at = models.DateTimeField(default=timezone.now)
    published = models.BooleanField(default=False)
    
    def __str__(self):
        return self.title
    
    class Meta:
        ordering = ['-created_at']
```

```python
# myapp/views.py
from django.shortcuts import render, get_object_or_404
from .models import Post

def index(request):
    posts = Post.objects.filter(published=True)
    return render(request, 'myapp/index.html', {'posts': posts})

def post_detail(request, post_id):
    post = get_object_or_404(Post, pk=post_id)
    return render(request, 'myapp/post_detail.html', {'post': post})
```

```python
# myapp/urls.py
from django.urls import path
from . import views

urlpatterns = [
    path('', views.index, name='index'),
    path('post/<int:post_id>/', views.post_detail, name='post_detail'),
]
```

```html
<!-- myapp/templates/myapp/index.html -->
<!DOCTYPE html>
<html>
<head>
    <title>My Blog</title>
</head>
<body>
    <h1>Blog Posts</h1>
    {% for post in posts %}
        <article>
            <h2><a href="{% url 'post_detail' post.id %}">{{ post.title }}</a></h2>
            <p>{{ post.content|truncatewords:30 }}</p>
            <p>By {{ post.author }} on {{ post.created_at|date:"F d, Y" }}</p>
        </article>
    {% empty %}
        <p>No posts available.</p>
    {% endfor %}
</body>
</html>
```

```html
<!-- myapp/templates/myapp/post_detail.html -->
<!DOCTYPE html>
<html>
<head>
    <title>{{ post.title }}</title>
</head>
<body>
    <h1>{{ post.title }}</h1>
    <p>{{ post.content }}</p>
    <p>By {{ post.author }} on {{ post.created_at|date:"F d, Y" }}</p>
    <a href="{% url 'index' %}">Back to list</a>
</body>
</html>
```

### Example 2: Contact Form

```python
# myapp/models.py
from django.db import models

class Contact(models.Model):
    name = models.CharField(max_length=100)
    email = models.EmailField()
    message = models.TextField()
    created_at = models.DateTimeField(auto_now_add=True)
    
    def __str__(self):
        return f"{self.name} - {self.email}"
```

```python
# myapp/views.py
from django.shortcuts import render, redirect
from django.contrib import messages
from .models import Contact

def contact(request):
    if request.method == 'POST':
        name = request.POST.get('name')
        email = request.POST.get('email')
        message = request.POST.get('message')
        
        Contact.objects.create(
            name=name,
            email=email,
            message=message
        )
        messages.success(request, 'Your message has been sent!')
        return redirect('contact')
    
    return render(request, 'myapp/contact.html')
```

```html
<!-- myapp/templates/myapp/contact.html -->
<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
</head>
<body>
    <h1>Contact Us</h1>
    
    {% if messages %}
        {% for message in messages %}
            <div class="alert">{{ message }}</div>
        {% endfor %}
    {% endif %}
    
    <form method="post">
        {% csrf_token %}
        <div>
            <label>Name:</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Message:</label>
            <textarea name="message" required></textarea>
        </div>
        <button type="submit">Send</button>
    </form>
</body>
</html>
```

---

## Common Mistakes and Pitfalls

### 1. Not Running Migrations

```python
# WRONG: Creating model but not running migrations
class Post(models.Model):
    title = models.CharField(max_length=200)

# CORRECT: Run migrations after creating/changing models
# python manage.py makemigrations
# python manage.py migrate
```

### 2. Forgetting CSRF Token

```html
<!-- WRONG: Missing CSRF token -->
<form method="post">
    <input type="text" name="data">
</form>

<!-- CORRECT: Include CSRF token -->
<form method="post">
    {% csrf_token %}
    <input type="text" name="data">
</form>
```

### 3. Not Registering App

```python
# WRONG: App not in INSTALLED_APPS
INSTALLED_APPS = [
    'django.contrib.admin',
    # 'myapp',  # Missing!
]

# CORRECT: Add app to INSTALLED_APPS
INSTALLED_APPS = [
    'django.contrib.admin',
    'myapp',  # Added
]
```

### 4. Incorrect Template Paths

```python
# WRONG: Template not found
return render(request, 'index.html', {})

# CORRECT: Use app-specific template path
return render(request, 'myapp/index.html', {})
```

---

## Best Practices

### 1. Project Structure

```
project/
├── manage.py
├── project/
│   ├── settings/
│   │   ├── __init__.py
│   │   ├── base.py
│   │   ├── development.py
│   │   └── production.py
│   └── urls.py
└── apps/
    ├── app1/
    └── app2/
```

### 2. Settings Management

```python
# settings/base.py
from pathlib import Path

BASE_DIR = Path(__file__).resolve().parent.parent.parent

SECRET_KEY = 'your-secret-key'
DEBUG = False
ALLOWED_HOSTS = []

# settings/development.py
from .base import *

DEBUG = True
ALLOWED_HOSTS = ['localhost', '127.0.0.1']

# settings/production.py
from .base import *

DEBUG = False
ALLOWED_HOSTS = ['yourdomain.com']
```

### 3. Use Environment Variables

```python
import os
from pathlib import Path

BASE_DIR = Path(__file__).resolve().parent.parent

SECRET_KEY = os.environ.get('SECRET_KEY', 'dev-secret-key')
DEBUG = os.environ.get('DEBUG', 'False') == 'True'
DATABASES = {
    'default': {
        'ENGINE': 'django.db.backends.postgresql',
        'NAME': os.environ.get('DB_NAME'),
        'USER': os.environ.get('DB_USER'),
        'PASSWORD': os.environ.get('DB_PASSWORD'),
        'HOST': os.environ.get('DB_HOST', 'localhost'),
        'PORT': os.environ.get('DB_PORT', '5432'),
    }
}
```

### 4. Model Best Practices

```python
from django.db import models
from django.urls import reverse

class Post(models.Model):
    title = models.CharField(max_length=200)
    slug = models.SlugField(unique=True)
    content = models.TextField()
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    
    def __str__(self):
        return self.title
    
    def get_absolute_url(self):
        return reverse('post_detail', kwargs={'slug': self.slug})
    
    class Meta:
        ordering = ['-created_at']
        verbose_name = 'Post'
        verbose_name_plural = 'Posts'
```

### 5. View Best Practices

```python
from django.shortcuts import render, get_object_or_404
from django.views.decorators.http import require_http_methods
from .models import Post

@require_http_methods(["GET"])
def post_list(request):
    posts = Post.objects.filter(published=True)
    return render(request, 'blog/post_list.html', {'posts': posts})

def post_detail(request, slug):
    post = get_object_or_404(Post, slug=slug, published=True)
    return render(request, 'blog/post_detail.html', {'post': post})
```

---

## Practice Exercise

### Exercise: Django App

**Objective**: Create a Django application with models, views, and templates.

**Instructions**:

1. Create a Django project and app
2. Create a model for a simple task/todo application
3. Create views to list, create, and view tasks
4. Create templates for the views
5. Set up URL routing
6. Register the model in admin

**Example Solution**:

```python
# todo/models.py
from django.db import models
from django.utils import timezone

class Task(models.Model):
    title = models.CharField(max_length=200)
    description = models.TextField(blank=True)
    completed = models.BooleanField(default=False)
    created_at = models.DateTimeField(default=timezone.now)
    
    def __str__(self):
        return self.title
    
    class Meta:
        ordering = ['-created_at']
```

```python
# todo/views.py
from django.shortcuts import render, redirect, get_object_or_404
from django.contrib import messages
from .models import Task

def task_list(request):
    tasks = Task.objects.all()
    return render(request, 'todo/task_list.html', {'tasks': tasks})

def task_detail(request, task_id):
    task = get_object_or_404(Task, pk=task_id)
    return render(request, 'todo/task_detail.html', {'task': task})

def task_create(request):
    if request.method == 'POST':
        title = request.POST.get('title')
        description = request.POST.get('description', '')
        Task.objects.create(title=title, description=description)
        messages.success(request, 'Task created successfully!')
        return redirect('task_list')
    return render(request, 'todo/task_form.html')

def task_toggle(request, task_id):
    task = get_object_or_404(Task, pk=task_id)
    task.completed = not task.completed
    task.save()
    return redirect('task_list')
```

```python
# todo/urls.py
from django.urls import path
from . import views

app_name = 'todo'
urlpatterns = [
    path('', views.task_list, name='task_list'),
    path('task/<int:task_id>/', views.task_detail, name='task_detail'),
    path('create/', views.task_create, name='task_create'),
    path('task/<int:task_id>/toggle/', views.task_toggle, name='task_toggle'),
]
```

```python
# todo/admin.py
from django.contrib import admin
from .models import Task

@admin.register(Task)
class TaskAdmin(admin.ModelAdmin):
    list_display = ['title', 'completed', 'created_at']
    list_filter = ['completed', 'created_at']
    search_fields = ['title', 'description']
    list_editable = ['completed']
```

```html
<!-- todo/templates/todo/task_list.html -->
<!DOCTYPE html>
<html>
<head>
    <title>Task List</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .task { border: 1px solid #ddd; padding: 10px; margin: 10px 0; }
        .completed { opacity: 0.6; text-decoration: line-through; }
        .btn { padding: 5px 10px; text-decoration: none; background: #007bff; color: white; border-radius: 3px; }
    </style>
</head>
<body>
    <h1>Task List</h1>
    <a href="{% url 'todo:task_create' %}" class="btn">Create New Task</a>
    
    {% if messages %}
        {% for message in messages %}
            <div>{{ message }}</div>
        {% endfor %}
    {% endif %}
    
    {% for task in tasks %}
        <div class="task {% if task.completed %}completed{% endif %}">
            <h3><a href="{% url 'todo:task_detail' task.id %}">{{ task.title }}</a></h3>
            <p>{{ task.description|truncatewords:20 }}</p>
            <p>Status: {% if task.completed %}Completed{% else %}Pending{% endif %}</p>
            <a href="{% url 'todo:task_toggle' task.id %}" class="btn">
                {% if task.completed %}Mark as Pending{% else %}Mark as Completed{% endif %}
            </a>
        </div>
    {% empty %}
        <p>No tasks available.</p>
    {% endfor %}
</body>
</html>
```

```html
<!-- todo/templates/todo/task_detail.html -->
<!DOCTYPE html>
<html>
<head>
    <title>{{ task.title }}</title>
</head>
<body>
    <h1>{{ task.title }}</h1>
    <p>{{ task.description }}</p>
    <p>Status: {% if task.completed %}Completed{% else %}Pending{% endif %}</p>
    <p>Created: {{ task.created_at|date:"F d, Y" }}</p>
    <a href="{% url 'todo:task_list' %}">Back to list</a>
</body>
</html>
```

```html
<!-- todo/templates/todo/task_form.html -->
<!DOCTYPE html>
<html>
<head>
    <title>Create Task</title>
</head>
<body>
    <h1>Create New Task</h1>
    <form method="post">
        {% csrf_token %}
        <div>
            <label>Title:</label>
            <input type="text" name="title" required>
        </div>
        <div>
            <label>Description:</label>
            <textarea name="description"></textarea>
        </div>
        <button type="submit">Create Task</button>
    </form>
    <a href="{% url 'todo:task_list' %}">Cancel</a>
</body>
</html>
```

**Expected Output**: A complete Django application with task management functionality.

**Challenge** (Optional):
- Add task editing functionality
- Add task deletion
- Add filtering (completed/pending)
- Add search functionality
- Add pagination

---

## Key Takeaways

1. **Django installation** - Use pip to install Django
2. **Project structure** - Understand Django project and app structure
3. **Models** - Define database structure with models
4. **Migrations** - Use migrations to manage database changes
5. **Views** - Function-based and class-based views
6. **Templates** - Django template language
7. **URLs** - URL routing and patterns
8. **Admin interface** - Django admin for model management
9. **MVT pattern** - Model-View-Template architecture
10. **Settings** - Configure Django settings
11. **Best practices** - Follow Django conventions
12. **Security** - CSRF protection, input validation
13. **Database** - ORM for database operations
14. **Template inheritance** - Reusable templates
15. **URL namespacing** - Organize URLs

---

## Quiz: Django Basics

Test your understanding with these questions:

1. **What command creates a Django project?**
   - A) django startproject
   - B) django-admin startproject
   - C) python startproject
   - D) flask startproject

2. **What is the Django ORM?**
   - A) Object-Relational Mapping
   - B) Object-Record Mapping
   - C) Object-Request Mapping
   - D) Object-Route Mapping

3. **What pattern does Django follow?**
   - A) MVC
   - B) MVT
   - C) MVP
   - D) MVVM

4. **What command runs migrations?**
   - A) python manage.py migrate
   - B) python manage.py makemigrations
   - C) python manage.py runmigrations
   - D) django migrate

5. **What is used in templates for CSRF protection?**
   - A) {% csrf %}
   - B) {% csrf_token %}
   - C) {{ csrf }}
   - D) {% protect %}

6. **What creates a superuser?**
   - A) python manage.py createsuperuser
   - B) python manage.py createuser
   - C) django createsuperuser
   - D) python createsuperuser

7. **What file defines URL patterns?**
   - A) views.py
   - B) models.py
   - C) urls.py
   - D) routes.py

8. **What is the default database for Django?**
   - A) PostgreSQL
   - B) MySQL
   - C) SQLite
   - D) MongoDB

9. **What decorator requires HTTP methods?**
   - A) @require_methods
   - B) @require_http_methods
   - C) @http_methods
   - D) @methods

10. **What is used to get an object or 404?**
    - A) get_object()
    - B) get_or_404()
    - C) get_object_or_404()
    - D) fetch_or_404()

**Answers**:
1. B) django-admin startproject (creates Django project)
2. A) Object-Relational Mapping (Django ORM)
3. B) MVT (Model-View-Template pattern)
4. A) python manage.py migrate (runs migrations)
5. B) {% csrf_token %} (CSRF protection in templates)
6. A) python manage.py createsuperuser (creates admin user)
7. C) urls.py (URL configuration)
8. C) SQLite (default database)
9. B) @require_http_methods (HTTP method decorator)
10. C) get_object_or_404() (get object or 404)

---

## Next Steps

Excellent work! You've mastered Django basics. You now understand:
- Django installation and setup
- Project structure
- Models, Views, Templates
- How to build Django applications

**What's Next?**
- Module 20: Working with APIs
- Lesson 20.1: Consuming APIs
- Learn about REST APIs
- Work with requests library

---

## Additional Resources

- **Django Documentation**: [docs.djangoproject.com/](https://docs.djangoproject.com/)
- **Django Tutorial**: [docs.djangoproject.com/en/stable/intro/tutorial01/](https://docs.djangoproject.com/en/stable/intro/tutorial01/)
- **Django Girls Tutorial**: [tutorial.djangogirls.org/](https://tutorial.djangogirls.org/)
- **Real Python Django**: [realpython.com/tutorials/django/](https://realpython.com/tutorials/django/)

---

*Lesson completed! You're ready to move on to the next lesson.*

