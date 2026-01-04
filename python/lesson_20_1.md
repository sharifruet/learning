# Lesson 20.1: Consuming APIs

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what APIs are and how they work
- Install and use the `requests` library
- Make various HTTP requests (GET, POST, PUT, DELETE)
- Handle JSON responses
- Work with API authentication
- Handle errors and exceptions
- Parse and process API responses
- Work with query parameters and headers
- Handle rate limiting and pagination
- Use API documentation
- Build practical API-consuming applications
- Debug API-related issues
- Apply best practices for API consumption

---

## Introduction to APIs

**API (Application Programming Interface)** is a set of protocols and tools for building software applications. Web APIs allow different applications to communicate with each other over the internet.

**Key Concepts**:
- **REST API**: Representational State Transfer - a common API architecture
- **HTTP Methods**: GET, POST, PUT, DELETE, PATCH
- **Endpoints**: URLs that provide access to resources
- **JSON**: JavaScript Object Notation - common data format
- **Authentication**: Methods to secure API access

---

## requests Library

### Installation

```bash
# Install requests library
pip install requests

# Verify installation
python -c "import requests; print(requests.__version__)"
```

### Basic Usage

```python
import requests

# Make a GET request
response = requests.get('https://api.github.com')

# Check status code
print(response.status_code)

# Get response content
print(response.text)
print(response.json())
```

### Response Object

```python
import requests

response = requests.get('https://api.github.com')

# Status code
print(response.status_code)  # 200

# Headers
print(response.headers)

# Content
print(response.text)  # Raw text
print(response.content)  # Bytes
print(response.json())  # Parsed JSON

# URL
print(response.url)

# Encoding
print(response.encoding)

# Cookies
print(response.cookies)
```

---

## Making HTTP Requests

### GET Requests

```python
import requests

# Simple GET request
response = requests.get('https://api.github.com/users/octocat')

# With query parameters
params = {'q': 'python', 'sort': 'stars'}
response = requests.get('https://api.github.com/search/repositories', params=params)

# With headers
headers = {'User-Agent': 'MyApp/1.0'}
response = requests.get('https://api.github.com', headers=headers)

# Access response
data = response.json()
print(data)
```

### POST Requests

```python
import requests

# POST with JSON data
data = {'name': 'John', 'email': 'john@example.com'}
response = requests.post('https://httpbin.org/post', json=data)

# POST with form data
form_data = {'username': 'john', 'password': 'secret'}
response = requests.post('https://httpbin.org/post', data=form_data)

# POST with files
files = {'file': open('document.pdf', 'rb')}
response = requests.post('https://httpbin.org/post', files=files)
files['file'].close()
```

### PUT and DELETE Requests

```python
import requests

# PUT request (update)
data = {'name': 'Jane', 'email': 'jane@example.com'}
response = requests.put('https://httpbin.org/put', json=data)

# DELETE request
response = requests.delete('https://httpbin.org/delete')

# PATCH request (partial update)
data = {'email': 'newemail@example.com'}
response = requests.patch('https://httpbin.org/patch', json=data)
```

### Request with Headers

```python
import requests

headers = {
    'User-Agent': 'MyApp/1.0',
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    'Authorization': 'Bearer your-token-here'
}

response = requests.get('https://api.example.com/data', headers=headers)
```

---

## Handling JSON Responses

### Parsing JSON

```python
import requests
import json

response = requests.get('https://api.github.com/users/octocat')

# Parse JSON
data = response.json()

# Access data
print(data['login'])
print(data['name'])
print(data['public_repos'])

# Pretty print
print(json.dumps(data, indent=2))
```

### Working with Nested JSON

```python
import requests

response = requests.get('https://api.github.com/users/octocat')

data = response.json()

# Access nested data
print(data['company'])  # String
print(data['location'])  # String

# Handle missing keys
bio = data.get('bio', 'No bio available')
print(bio)
```

### JSON Arrays

```python
import requests

response = requests.get('https://api.github.com/users/octocat/repos')

repos = response.json()

# Iterate through array
for repo in repos:
    print(f"{repo['name']}: {repo['description']}")
    print(f"Stars: {repo['stargazers_count']}")
    print()
```

---

## Error Handling

### Status Codes

```python
import requests

response = requests.get('https://api.github.com/users/nonexistent')

# Check status code
if response.status_code == 200:
    data = response.json()
elif response.status_code == 404:
    print('User not found')
elif response.status_code == 403:
    print('Access forbidden')
else:
    print(f'Error: {response.status_code}')
```

### Raise for Status

```python
import requests

response = requests.get('https://api.github.com/users/octocat')

# Raise exception for bad status codes
try:
    response.raise_for_status()
    data = response.json()
except requests.exceptions.HTTPError as err:
    print(f'HTTP Error: {err}')
except requests.exceptions.RequestException as err:
    print(f'Request Error: {err}')
```

### Exception Handling

```python
import requests

try:
    response = requests.get('https://api.github.com/users/octocat', timeout=5)
    response.raise_for_status()
    data = response.json()
except requests.exceptions.Timeout:
    print('Request timed out')
except requests.exceptions.ConnectionError:
    print('Connection error')
except requests.exceptions.HTTPError as err:
    print(f'HTTP error: {err}')
except requests.exceptions.RequestException as err:
    print(f'Request error: {err}')
```

---

## Authentication

### API Keys

```python
import requests

# API key in query parameter
api_key = 'your-api-key'
response = requests.get(
    'https://api.example.com/data',
    params={'api_key': api_key}
)

# API key in header
headers = {'X-API-Key': api_key}
response = requests.get('https://api.example.com/data', headers=headers)
```

### Bearer Token

```python
import requests

token = 'your-bearer-token'
headers = {'Authorization': f'Bearer {token}'}
response = requests.get('https://api.example.com/data', headers=headers)
```

### Basic Authentication

```python
import requests
from requests.auth import HTTPBasicAuth

# Method 1: Using auth parameter
response = requests.get(
    'https://api.example.com/data',
    auth=HTTPBasicAuth('username', 'password')
)

# Method 2: Using tuple
response = requests.get(
    'https://api.example.com/data',
    auth=('username', 'password')
)
```

### OAuth

```python
import requests

# OAuth token in header
headers = {
    'Authorization': 'OAuth your-oauth-token',
    'Content-Type': 'application/json'
}
response = requests.get('https://api.example.com/data', headers=headers)
```

---

## Query Parameters

### Simple Parameters

```python
import requests

# Single parameter
response = requests.get('https://api.github.com/search/repositories', 
                       params={'q': 'python'})

# Multiple parameters
params = {
    'q': 'python',
    'sort': 'stars',
    'order': 'desc',
    'per_page': 10
}
response = requests.get('https://api.github.com/search/repositories', 
                       params=params)
```

### Complex Parameters

```python
import requests

# List parameters
params = {
    'tags': ['python', 'web', 'api'],
    'page': 1,
    'limit': 20
}
response = requests.get('https://api.example.com/posts', params=params)

# URL will be: https://api.example.com/posts?tags=python&tags=web&tags=api&page=1&limit=20
```

---

## Headers

### Custom Headers

```python
import requests

headers = {
    'User-Agent': 'MyApp/1.0 (https://myapp.com)',
    'Accept': 'application/json',
    'Accept-Language': 'en-US,en;q=0.9',
    'Content-Type': 'application/json',
    'X-Custom-Header': 'custom-value'
}

response = requests.get('https://api.example.com/data', headers=headers)
```

### Default Headers

```python
import requests

# Create session with default headers
session = requests.Session()
session.headers.update({
    'User-Agent': 'MyApp/1.0',
    'Accept': 'application/json'
})

# All requests from this session will use these headers
response = session.get('https://api.example.com/data')
```

---

## Timeouts and Retries

### Timeouts

```python
import requests

# Timeout in seconds
try:
    response = requests.get('https://api.example.com/data', timeout=5)
except requests.exceptions.Timeout:
    print('Request timed out')

# Separate connect and read timeouts
response = requests.get('https://api.example.com/data', 
                       timeout=(3, 10))  # (connect, read)
```

### Retries

```python
import requests
from requests.adapters import HTTPAdapter
from requests.packages.urllib3.util.retry import Retry

# Create session with retry strategy
session = requests.Session()

retry_strategy = Retry(
    total=3,
    backoff_factor=1,
    status_forcelist=[429, 500, 502, 503, 504],
)

adapter = HTTPAdapter(max_retries=retry_strategy)
session.mount("http://", adapter)
session.mount("https://", adapter)

response = session.get('https://api.example.com/data')
```

---

## Pagination

### Simple Pagination

```python
import requests

def get_all_pages(base_url, params=None):
    all_data = []
    page = 1
    
    while True:
        if params:
            params['page'] = page
        else:
            params = {'page': page}
        
        response = requests.get(base_url, params=params)
        response.raise_for_status()
        data = response.json()
        
        if not data:  # No more data
            break
        
        all_data.extend(data)
        page += 1
    
    return all_data
```

### Cursor-Based Pagination

```python
import requests

def get_all_cursor_pages(base_url, cursor_key='cursor'):
    all_data = []
    cursor = None
    
    while True:
        params = {}
        if cursor:
            params[cursor_key] = cursor
        
        response = requests.get(base_url, params=params)
        response.raise_for_status()
        data = response.json()
        
        all_data.extend(data.get('items', []))
        
        cursor = data.get('next_cursor')
        if not cursor:
            break
    
    return all_data
```

---

## Rate Limiting

### Handling Rate Limits

```python
import requests
import time

def make_request_with_rate_limit(url, max_requests=60, time_window=60):
    requests_made = 0
    start_time = time.time()
    
    while True:
        if requests_made >= max_requests:
            elapsed = time.time() - start_time
            if elapsed < time_window:
                sleep_time = time_window - elapsed
                print(f'Rate limit reached. Sleeping for {sleep_time} seconds...')
                time.sleep(sleep_time)
            requests_made = 0
            start_time = time.time()
        
        response = requests.get(url)
        requests_made += 1
        
        if response.status_code == 429:  # Too Many Requests
            retry_after = int(response.headers.get('Retry-After', 60))
            print(f'Rate limited. Waiting {retry_after} seconds...')
            time.sleep(retry_after)
            continue
        
        return response
```

---

## Practical Examples

### Example 1: GitHub API

```python
import requests
import json

def get_github_user(username):
    """Get GitHub user information."""
    url = f'https://api.github.com/users/{username}'
    response = requests.get(url)
    response.raise_for_status()
    return response.json()

def get_user_repos(username, sort='updated'):
    """Get user's repositories."""
    url = f'https://api.github.com/users/{username}/repos'
    params = {'sort': sort, 'per_page': 10}
    response = requests.get(url, params=params)
    response.raise_for_status()
    return response.json()

# Usage
user = get_github_user('octocat')
print(f"User: {user['login']}")
print(f"Name: {user.get('name', 'N/A')}")
print(f"Bio: {user.get('bio', 'N/A')}")
print(f"Public Repos: {user['public_repos']}")

repos = get_user_repos('octocat')
for repo in repos:
    print(f"{repo['name']}: {repo['stargazers_count']} stars")
```

### Example 2: Weather API

```python
import requests

def get_weather(city, api_key):
    """Get weather data for a city."""
    url = 'https://api.openweathermap.org/data/2.5/weather'
    params = {
        'q': city,
        'appid': api_key,
        'units': 'metric'
    }
    
    try:
        response = requests.get(url, params=params, timeout=10)
        response.raise_for_status()
        data = response.json()
        
        return {
            'city': data['name'],
            'temperature': data['main']['temp'],
            'description': data['weather'][0]['description'],
            'humidity': data['main']['humidity'],
            'wind_speed': data['wind']['speed']
        }
    except requests.exceptions.RequestException as e:
        print(f'Error fetching weather: {e}')
        return None

# Usage (requires API key)
# weather = get_weather('London', 'your-api-key')
# if weather:
#     print(f"Temperature in {weather['city']}: {weather['temperature']}°C")
```

### Example 3: REST Countries API

```python
import requests

def get_country_info(country_name):
    """Get information about a country."""
    url = f'https://restcountries.com/v3.1/name/{country_name}'
    response = requests.get(url)
    response.raise_for_status()
    data = response.json()
    
    if data:
        country = data[0]
        return {
            'name': country['name']['common'],
            'capital': country.get('capital', ['N/A'])[0],
            'population': country['population'],
            'region': country['region'],
            'languages': list(country.get('languages', {}).values()),
            'currencies': list(country.get('currencies', {}).keys())
        }
    return None

# Usage
country = get_country_info('france')
if country:
    print(f"Country: {country['name']}")
    print(f"Capital: {country['capital']}")
    print(f"Population: {country['population']:,}")
    print(f"Languages: {', '.join(country['languages'])}")
```

### Example 4: JSONPlaceholder API

```python
import requests

class JSONPlaceholderAPI:
    """Client for JSONPlaceholder API."""
    
    BASE_URL = 'https://jsonplaceholder.typicode.com'
    
    def __init__(self):
        self.session = requests.Session()
        self.session.headers.update({
            'Content-Type': 'application/json'
        })
    
    def get_posts(self):
        """Get all posts."""
        response = self.session.get(f'{self.BASE_URL}/posts')
        response.raise_for_status()
        return response.json()
    
    def get_post(self, post_id):
        """Get a specific post."""
        response = self.session.get(f'{self.BASE_URL}/posts/{post_id}')
        response.raise_for_status()
        return response.json()
    
    def create_post(self, title, body, user_id):
        """Create a new post."""
        data = {
            'title': title,
            'body': body,
            'userId': user_id
        }
        response = self.session.post(f'{self.BASE_URL}/posts', json=data)
        response.raise_for_status()
        return response.json()
    
    def update_post(self, post_id, title=None, body=None):
        """Update a post."""
        data = {}
        if title:
            data['title'] = title
        if body:
            data['body'] = body
        
        response = self.session.patch(
            f'{self.BASE_URL}/posts/{post_id}',
            json=data
        )
        response.raise_for_status()
        return response.json()
    
    def delete_post(self, post_id):
        """Delete a post."""
        response = self.session.delete(f'{self.BASE_URL}/posts/{post_id}')
        return response.status_code == 200

# Usage
api = JSONPlaceholderAPI()

# Get all posts
posts = api.get_posts()
print(f"Total posts: {len(posts)}")

# Get specific post
post = api.get_post(1)
print(f"Post title: {post['title']}")

# Create post
new_post = api.create_post('New Post', 'This is a new post', 1)
print(f"Created post ID: {new_post['id']}")

# Update post
updated = api.update_post(1, title='Updated Title')
print(f"Updated post: {updated['title']}")

# Delete post
deleted = api.delete_post(1)
print(f"Post deleted: {deleted}")
```

---

## Common Mistakes and Pitfalls

### 1. Not Handling Errors

```python
# WRONG: No error handling
response = requests.get('https://api.example.com/data')
data = response.json()  # May fail if status code is not 200

# CORRECT: Handle errors
response = requests.get('https://api.example.com/data')
response.raise_for_status()
data = response.json()
```

### 2. Not Using Timeouts

```python
# WRONG: No timeout
response = requests.get('https://api.example.com/data')  # May hang forever

# CORRECT: Use timeout
response = requests.get('https://api.example.com/data', timeout=10)
```

### 3. Hardcoding URLs

```python
# WRONG: Hardcoded URL
response = requests.get('https://api.example.com/v1/users/123')

# CORRECT: Use variables
BASE_URL = 'https://api.example.com/v1'
user_id = 123
response = requests.get(f'{BASE_URL}/users/{user_id}')
```

### 4. Not Checking Response Type

```python
# WRONG: Assume JSON
data = response.json()  # May fail if response is not JSON

# CORRECT: Check content type
if 'application/json' in response.headers.get('Content-Type', ''):
    data = response.json()
else:
    data = response.text
```

### 5. Exposing API Keys

```python
# WRONG: Hardcoded API key
api_key = 'sk-1234567890abcdef'

# CORRECT: Use environment variables
import os
api_key = os.environ.get('API_KEY')
```

---

## Best Practices

### 1. Use Sessions

```python
import requests

# Create session for multiple requests
session = requests.Session()
session.headers.update({
    'User-Agent': 'MyApp/1.0',
    'Authorization': 'Bearer token'
})

# Reuse session
response1 = session.get('https://api.example.com/users')
response2 = session.get('https://api.example.com/posts')
```

### 2. Environment Variables for Secrets

```python
import os
import requests

api_key = os.environ.get('API_KEY')
if not api_key:
    raise ValueError('API_KEY environment variable not set')

headers = {'Authorization': f'Bearer {api_key}'}
response = requests.get('https://api.example.com/data', headers=headers)
```

### 3. Create API Client Classes

```python
import requests

class APIClient:
    def __init__(self, base_url, api_key=None):
        self.base_url = base_url
        self.session = requests.Session()
        if api_key:
            self.session.headers.update({
                'Authorization': f'Bearer {api_key}'
            })
    
    def get(self, endpoint, **kwargs):
        url = f'{self.base_url}/{endpoint}'
        response = self.session.get(url, **kwargs)
        response.raise_for_status()
        return response.json()
    
    def post(self, endpoint, data=None, **kwargs):
        url = f'{self.base_url}/{endpoint}'
        response = self.session.post(url, json=data, **kwargs)
        response.raise_for_status()
        return response.json()
```

### 4. Logging

```python
import requests
import logging

logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

def make_request(url, **kwargs):
    logger.info(f'Making request to {url}')
    try:
        response = requests.get(url, **kwargs)
        response.raise_for_status()
        logger.info(f'Request successful: {response.status_code}')
        return response.json()
    except requests.exceptions.RequestException as e:
        logger.error(f'Request failed: {e}')
        raise
```

### 5. Caching

```python
import requests
from functools import lru_cache
import time

@lru_cache(maxsize=100)
def get_cached_data(url, cache_duration=3600):
    """Cache API responses."""
    # In production, use Redis or similar
    response = requests.get(url)
    response.raise_for_status()
    return response.json()
```

---

## Practice Exercise

### Exercise: API Consumption

**Objective**: Create a Python script that consumes a public API and displays the data.

**Instructions**:

1. Choose a public API (e.g., JSONPlaceholder, REST Countries, GitHub)
2. Create functions to:
   - Fetch data from the API
   - Parse and process the response
   - Display the data in a readable format
   - Handle errors gracefully

3. Your script should include:
   - Error handling
   - Timeouts
   - Proper JSON parsing
   - User-friendly output

**Example Solution**:

```python
"""
API Consumption Exercise
This program demonstrates consuming REST APIs using the requests library.
"""

import requests
import json
from typing import Dict, List, Optional

class CountryAPIClient:
    """Client for REST Countries API."""
    
    BASE_URL = 'https://restcountries.com/v3.1'
    
    def __init__(self):
        self.session = requests.Session()
        self.session.headers.update({
            'User-Agent': 'CountryAPI/1.0',
            'Accept': 'application/json'
        })
    
    def get_country_by_name(self, name: str) -> Optional[Dict]:
        """Get country information by name."""
        try:
            url = f'{self.BASE_URL}/name/{name}'
            response = self.session.get(url, timeout=10)
            response.raise_for_status()
            data = response.json()
            return data[0] if data else None
        except requests.exceptions.Timeout:
            print(f'Request timed out for country: {name}')
            return None
        except requests.exceptions.HTTPError as e:
            print(f'HTTP error for {name}: {e}')
            return None
        except requests.exceptions.RequestException as e:
            print(f'Request error for {name}: {e}')
            return None
    
    def get_all_countries(self) -> List[Dict]:
        """Get all countries."""
        try:
            url = f'{self.BASE_URL}/all'
            response = self.session.get(url, timeout=30)
            response.raise_for_status()
            return response.json()
        except requests.exceptions.RequestException as e:
            print(f'Error fetching all countries: {e}')
            return []
    
    def search_countries_by_region(self, region: str) -> List[Dict]:
        """Search countries by region."""
        try:
            url = f'{self.BASE_URL}/region/{region}'
            response = self.session.get(url, timeout=10)
            response.raise_for_status()
            return response.json()
        except requests.exceptions.RequestException as e:
            print(f'Error searching region {region}: {e}')
            return []
    
    def format_country_info(self, country: Dict) -> str:
        """Format country information for display."""
        name = country.get('name', {}).get('common', 'N/A')
        capital = country.get('capital', ['N/A'])[0] if country.get('capital') else 'N/A'
        population = country.get('population', 0)
        region = country.get('region', 'N/A')
        languages = list(country.get('languages', {}).values())
        currencies = list(country.get('currencies', {}).keys())
        
        info = f"""
Country: {name}
Capital: {capital}
Population: {population:,}
Region: {region}
Languages: {', '.join(languages) if languages else 'N/A'}
Currencies: {', '.join(currencies) if currencies else 'N/A'}
"""
        return info.strip()

def main():
    """Main function to demonstrate API consumption."""
    client = CountryAPIClient()
    
    print("=" * 50)
    print("Country Information API Client")
    print("=" * 50)
    
    # Get specific country
    print("\n1. Getting information for 'France':")
    print("-" * 50)
    france = client.get_country_by_name('france')
    if france:
        print(client.format_country_info(france))
    
    # Get another country
    print("\n2. Getting information for 'Japan':")
    print("-" * 50)
    japan = client.get_country_by_name('japan')
    if japan:
        print(client.format_country_info(japan))
    
    # Search by region
    print("\n3. Countries in Europe (first 5):")
    print("-" * 50)
    european_countries = client.search_countries_by_region('europe')
    for country in european_countries[:5]:
        name = country.get('name', {}).get('common', 'N/A')
        capital = country.get('capital', ['N/A'])[0] if country.get('capital') else 'N/A'
        print(f"  - {name} (Capital: {capital})")
    
    # Error handling example
    print("\n4. Testing error handling with invalid country:")
    print("-" * 50)
    invalid = client.get_country_by_name('nonexistentcountry12345')
    if not invalid:
        print("  ✓ Error handled gracefully")

if __name__ == '__main__':
    main()
```

**Expected Output**:
```
==================================================
Country Information API Client
==================================================

1. Getting information for 'France':
--------------------------------------------------
Country: France
Capital: Paris
Population: 67,391,582
Region: Europe
Languages: French
Currencies: EUR

2. Getting information for 'Japan':
--------------------------------------------------
Country: Japan
Capital: Tokyo
Population: 125,836,021
Region: Asia
Languages: Japanese
Currencies: JPY

3. Countries in Europe (first 5):
--------------------------------------------------
  - Åland Islands (Capital: Mariehamn)
  - Albania (Capital: Tirana)
  - Andorra (Capital: Andorra la Vella)
  - Austria (Capital: Vienna)
  - Belarus (Capital: Minsk)

4. Testing error handling with invalid country:
--------------------------------------------------
  ✓ Error handled gracefully
```

**Challenge** (Optional):
- Add caching to avoid repeated API calls
- Implement pagination for large result sets
- Add command-line argument parsing
- Create a GUI to display country information
- Add functionality to compare two countries
- Implement rate limiting

---

## Key Takeaways

1. **APIs** - Application Programming Interfaces for data exchange
2. **requests library** - Python library for HTTP requests
3. **HTTP methods** - GET, POST, PUT, DELETE, PATCH
4. **JSON handling** - Parse and work with JSON responses
5. **Error handling** - Handle timeouts, connection errors, HTTP errors
6. **Authentication** - API keys, Bearer tokens, Basic auth
7. **Query parameters** - Pass data in URLs
8. **Headers** - Custom headers for requests
9. **Sessions** - Reuse connections for multiple requests
10. **Timeouts** - Prevent hanging requests
11. **Rate limiting** - Respect API rate limits
12. **Pagination** - Handle paginated responses
13. **Best practices** - Use sessions, environment variables, logging
14. **API clients** - Create reusable client classes
15. **Security** - Never expose API keys in code

---

## Quiz: API Consumption

Test your understanding with these questions:

1. **What library is commonly used for HTTP requests in Python?**
   - A) urllib
   - B) requests
   - C) httplib
   - D) http

2. **What method makes a GET request?**
   - A) requests.post()
   - B) requests.get()
   - C) requests.fetch()
   - D) requests.request()

3. **What parses JSON response?**
   - A) response.text
   - B) response.json()
   - C) response.parse()
   - D) json.loads(response)

4. **What raises exception for bad status codes?**
   - A) response.check()
   - B) response.raise_for_status()
   - C) response.validate()
   - D) response.verify()

5. **What is used for API authentication?**
   - A) API keys
   - B) Bearer tokens
   - C) Basic auth
   - D) All of the above

6. **What prevents hanging requests?**
   - A) timeout parameter
   - B) limit parameter
   - C) max_time parameter
   - D) wait parameter

7. **What is used to reuse connections?**
   - A) requests.Connection()
   - B) requests.Session()
   - C) requests.Pool()
   - D) requests.Reuse()

8. **What status code means "Too Many Requests"?**
   - A) 400
   - B) 401
   - C) 403
   - D) 429

9. **What should you use for API keys?**
   - A) Hardcode in script
   - B) Environment variables
   - C) Config file in repo
   - D) Comments

10. **What handles paginated responses?**
    - A) Loops
    - B) Recursion
    - C) Iterators
    - D) All of the above

**Answers**:
1. B) requests (common HTTP library)
2. B) requests.get() (GET request method)
3. B) response.json() (parse JSON)
4. B) response.raise_for_status() (raise for bad status)
5. D) All of the above (authentication methods)
6. A) timeout parameter (prevent hanging)
7. B) requests.Session() (reuse connections)
8. D) 429 (Too Many Requests)
9. B) Environment variables (secure API keys)
10. D) All of the above (pagination methods)

---

## Next Steps

Excellent work! You've mastered API consumption. You now understand:
- Making HTTP requests
- Handling JSON responses
- Authentication and error handling
- How to build API clients

**What's Next?**
- Lesson 20.2: Building REST APIs
- Learn Flask-RESTful
- Create your own APIs
- Understand API design

---

## Additional Resources

- **requests Documentation**: [docs.python-requests.org/](https://docs.python-requests.org/)
- **HTTP Status Codes**: [httpstatuses.com/](https://httpstatuses.com/)
- **JSONPlaceholder**: [jsonplaceholder.typicode.com/](https://jsonplaceholder.typicode.com/)
- **REST Countries API**: [restcountries.com/](https://restcountries.com/)
- **Public APIs List**: [github.com/public-apis/public-apis](https://github.com/public-apis/public-apis)

---

*Lesson completed! You're ready to move on to the next lesson.*

