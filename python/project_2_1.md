# Project 2.1: Web Scraping Basics

## Learning Objectives

By the end of this project, you will be able to:
- Understand what web scraping is and its applications
- Install and use BeautifulSoup for HTML parsing
- Extract data from HTML documents
- Navigate HTML structure (tags, attributes, text)
- Handle different HTML elements and structures
- Use requests library to fetch web pages
- Understand Scrapy framework basics
- Practice ethical web scraping
- Respect robots.txt and rate limiting
- Handle dynamic content
- Clean and process scraped data
- Build practical web scrapers
- Debug scraping issues
- Apply best practices for web scraping

---

## Introduction to Web Scraping

**Web Scraping** is the process of extracting data from websites. It involves fetching web pages and parsing their HTML/XML content to extract specific information.

**Common Use Cases**:
- Data collection for research
- Price monitoring
- News aggregation
- Social media analysis
- Job listings collection
- Product information extraction

**Important Considerations**:
- **Legal**: Always check website's Terms of Service
- **Ethical**: Respect robots.txt and rate limits
- **Technical**: Handle dynamic content, errors, and edge cases

---

## BeautifulSoup

### Installation

```bash
# Install BeautifulSoup4
pip install beautifulsoup4

# Install lxml parser (faster)
pip install lxml

# Install requests for fetching pages
pip install requests

# Verify installation
python -c "from bs4 import BeautifulSoup; print('OK')"
```

### Basic Usage

```python
from bs4 import BeautifulSoup
import requests

# Fetch a web page
url = 'https://example.com'
response = requests.get(url)
html = response.text

# Parse HTML
soup = BeautifulSoup(html, 'html.parser')

# Find elements
title = soup.find('title')
print(title.text)
```

### Parsing HTML

```python
from bs4 import BeautifulSoup

# Parse from string
html = '<html><body><h1>Hello World</h1></body></html>'
soup = BeautifulSoup(html, 'html.parser')

# Parse from file
with open('page.html', 'r') as f:
    soup = BeautifulSoup(f, 'html.parser')

# Different parsers
soup = BeautifulSoup(html, 'html.parser')  # Built-in (slower)
soup = BeautifulSoup(html, 'lxml')         # Fast, requires lxml
soup = BeautifulSoup(html, 'html5lib')      # Most lenient
```

### Finding Elements

```python
from bs4 import BeautifulSoup

html = '''
<html>
<body>
    <h1>Title</h1>
    <p class="intro">Introduction</p>
    <p class="content">Content here</p>
    <a href="https://example.com">Link</a>
</body>
</html>
'''

soup = BeautifulSoup(html, 'html.parser')

# Find first element
first_p = soup.find('p')
print(first_p.text)  # Introduction

# Find all elements
all_p = soup.find_all('p')
for p in all_p:
    print(p.text)

# Find by class
intro = soup.find('p', class_='intro')
print(intro.text)

# Find by id
# element = soup.find(id='myid')

# Find by attribute
link = soup.find('a', href='https://example.com')
print(link['href'])
```

### Navigating HTML Structure

```python
from bs4 import BeautifulSoup

html = '''
<div class="container">
    <h1>Title</h1>
    <div class="content">
        <p>Paragraph 1</p>
        <p>Paragraph 2</p>
    </div>
</div>
'''

soup = BeautifulSoup(html, 'html.parser')
container = soup.find('div', class_='container')

# Parent
parent = container.parent

# Children
for child in container.children:
    print(child)

# Descendants
for descendant in container.descendants:
    print(descendant)

# Siblings
next_sibling = container.next_sibling
prev_sibling = container.previous_sibling

# Find parent
content = soup.find('div', class_='content')
parent = content.find_parent('div', class_='container')
```

### Extracting Data

```python
from bs4 import BeautifulSoup

html = '''
<div class="product">
    <h2>Product Name</h2>
    <span class="price">$29.99</span>
    <p class="description">Product description</p>
    <a href="/product/123">View</a>
</div>
'''

soup = BeautifulSoup(html, 'html.parser')
product = soup.find('div', class_='product')

# Extract text
name = product.find('h2').text.strip()
price = product.find('span', class_='price').text.strip()
description = product.find('p', class_='description').text.strip()

# Extract attribute
link = product.find('a')['href']

# Extract all text
all_text = product.get_text(separator=' ', strip=True)

print(f'Name: {name}')
print(f'Price: {price}')
print(f'Description: {description}')
print(f'Link: {link}')
```

### Working with Attributes

```python
from bs4 import BeautifulSoup

html = '<a href="https://example.com" class="link" data-id="123">Link</a>'
soup = BeautifulSoup(html, 'html.parser')
link = soup.find('a')

# Get attribute
href = link['href']
link_class = link.get('class')
data_id = link.get('data-id', 'default')

# Get all attributes
attrs = link.attrs
print(attrs)  # {'href': 'https://example.com', 'class': ['link'], 'data-id': '123'}

# Check if attribute exists
if 'href' in link.attrs:
    print('Has href attribute')
```

### CSS Selectors

```python
from bs4 import BeautifulSoup

html = '''
<div class="container">
    <p class="intro">Introduction</p>
    <p class="content">Content</p>
    <div id="sidebar">
        <ul>
            <li>Item 1</li>
            <li>Item 2</li>
        </ul>
    </div>
</div>
'''

soup = BeautifulSoup(html, 'html.parser')

# Select by CSS selector
intro = soup.select_one('p.intro')
all_p = soup.select('p')
sidebar = soup.select('#sidebar')
items = soup.select('ul li')

# Complex selectors
first_item = soup.select_one('div#sidebar ul li:first-child')
```

---

## Using requests Library

### Fetching Web Pages

```python
import requests

# Basic GET request
url = 'https://example.com'
response = requests.get(url)

# Check status
print(response.status_code)  # 200
print(response.ok)  # True

# Get content
html = response.text
content = response.content

# Headers
print(response.headers)

# URL
print(response.url)
```

### Handling Errors

```python
import requests
from requests.exceptions import RequestException

url = 'https://example.com'

try:
    response = requests.get(url, timeout=10)
    response.raise_for_status()  # Raises exception for bad status codes
    html = response.text
except requests.exceptions.Timeout:
    print('Request timed out')
except requests.exceptions.ConnectionError:
    print('Connection error')
except requests.exceptions.HTTPError as e:
    print(f'HTTP error: {e}')
except RequestException as e:
    print(f'Request error: {e}')
```

### Adding Headers

```python
import requests

url = 'https://example.com'

headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
    'Accept': 'text/html,application/xhtml+xml',
    'Accept-Language': 'en-US,en;q=0.9'
}

response = requests.get(url, headers=headers)
```

### Session Management

```python
import requests

# Create session (maintains cookies)
session = requests.Session()

# Set headers for all requests
session.headers.update({
    'User-Agent': 'MyBot/1.0'
})

# Make requests
response1 = session.get('https://example.com/login')
response2 = session.get('https://example.com/dashboard')  # Cookies maintained
```

---

## Complete Scraping Example

### Simple Web Scraper

```python
#!/usr/bin/env python3
"""
Simple Web Scraper
Scrapes title and links from a webpage
"""

import requests
from bs4 import BeautifulSoup
import time

def scrape_page(url):
    """Scrape a single page."""
    try:
        # Fetch page
        headers = {
            'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        }
        response = requests.get(url, headers=headers, timeout=10)
        response.raise_for_status()
        
        # Parse HTML
        soup = BeautifulSoup(response.text, 'html.parser')
        
        # Extract data
        title = soup.find('title')
        title_text = title.text.strip() if title else 'No title'
        
        links = []
        for link in soup.find_all('a', href=True):
            links.append({
                'text': link.text.strip(),
                'url': link['href']
            })
        
        return {
            'title': title_text,
            'links': links,
            'url': url
        }
    
    except Exception as e:
        print(f'Error scraping {url}: {e}')
        return None

def main():
    url = 'https://example.com'
    data = scrape_page(url)
    
    if data:
        print(f"Title: {data['title']}")
        print(f"\nFound {len(data['links'])} links:")
        for link in data['links'][:10]:  # Show first 10
            print(f"  {link['text']} -> {link['url']}")

if __name__ == '__main__':
    main()
```

### Advanced Scraper with Data Extraction

```python
#!/usr/bin/env python3
"""
Advanced Web Scraper
Extracts structured data from a webpage
"""

import requests
from bs4 import BeautifulSoup
import json
import csv
from typing import List, Dict

class WebScraper:
    def __init__(self, base_url: str):
        self.base_url = base_url
        self.session = requests.Session()
        self.session.headers.update({
            'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        })
    
    def fetch_page(self, url: str) -> BeautifulSoup:
        """Fetch and parse a webpage."""
        try:
            response = self.session.get(url, timeout=10)
            response.raise_for_status()
            return BeautifulSoup(response.text, 'html.parser')
        except Exception as e:
            print(f'Error fetching {url}: {e}')
            return None
    
    def extract_products(self, soup: BeautifulSoup) -> List[Dict]:
        """Extract product information from page."""
        products = []
        
        # Find all product containers (adjust selector as needed)
        product_divs = soup.find_all('div', class_='product')
        
        for div in product_divs:
            try:
                product = {
                    'name': div.find('h2').text.strip() if div.find('h2') else '',
                    'price': div.find('span', class_='price').text.strip() if div.find('span', class_='price') else '',
                    'description': div.find('p', class_='description').text.strip() if div.find('p', class_='description') else '',
                    'link': div.find('a')['href'] if div.find('a') else ''
                }
                products.append(product)
            except Exception as e:
                print(f'Error extracting product: {e}')
                continue
        
        return products
    
    def save_to_json(self, data: List[Dict], filename: str):
        """Save data to JSON file."""
        with open(filename, 'w', encoding='utf-8') as f:
            json.dump(data, f, indent=2, ensure_ascii=False)
        print(f'Data saved to {filename}')
    
    def save_to_csv(self, data: List[Dict], filename: str):
        """Save data to CSV file."""
        if not data:
            return
        
        fieldnames = data[0].keys()
        with open(filename, 'w', newline='', encoding='utf-8') as f:
            writer = csv.DictWriter(f, fieldnames=fieldnames)
            writer.writeheader()
            writer.writerows(data)
        print(f'Data saved to {filename}')

def main():
    scraper = WebScraper('https://example.com')
    
    # Fetch page
    soup = scraper.fetch_page('https://example.com/products')
    
    if soup:
        # Extract data
        products = scraper.extract_products(soup)
        
        # Save data
        scraper.save_to_json(products, 'products.json')
        scraper.save_to_csv(products, 'products.csv')
        
        print(f'\nExtracted {len(products)} products')

if __name__ == '__main__':
    main()
```

---

## Scrapy Introduction

### What is Scrapy?

**Scrapy** is a powerful Python framework for web scraping. It's more advanced than BeautifulSoup and better suited for large-scale scraping projects.

**Key Features**:
- Built-in support for crawling multiple pages
- Automatic request scheduling
- Built-in data export (JSON, CSV, XML)
- Middleware support
- Extensible architecture

### Installation

```bash
# Install Scrapy
pip install scrapy

# Verify installation
scrapy --version
```

### Basic Scrapy Project

```bash
# Create a new Scrapy project
scrapy startproject myproject

# This creates:
# myproject/
#   scrapy.cfg
#   myproject/
#     __init__.py
#     items.py
#     middlewares.py
#     pipelines.py
#     settings.py
#     spiders/
#       __init__.py
```

### Creating a Spider

```python
# myproject/spiders/example_spider.py
import scrapy

class ExampleSpider(scrapy.Spider):
    name = 'example'
    allowed_domains = ['example.com']
    start_urls = ['https://example.com']
    
    def parse(self, response):
        # Extract data
        title = response.css('title::text').get()
        links = response.css('a::attr(href)').getall()
        
        yield {
            'title': title,
            'links': links,
            'url': response.url
        }
        
        # Follow links
        for link in response.css('a::attr(href)').getall():
            yield response.follow(link, self.parse)
```

### Running Scrapy

```bash
# Run spider
scrapy crawl example

# Save to JSON
scrapy crawl example -o output.json

# Save to CSV
scrapy crawl example -o output.csv

# Follow specific settings
scrapy crawl example -s DOWNLOAD_DELAY=1
```

### Scrapy Items

```python
# myproject/items.py
import scrapy

class ProductItem(scrapy.Item):
    name = scrapy.Field()
    price = scrapy.Field()
    description = scrapy.Field()
    url = scrapy.Field()
```

### Using Items in Spider

```python
from myproject.items import ProductItem

class ProductSpider(scrapy.Spider):
    name = 'products'
    start_urls = ['https://example.com/products']
    
    def parse(self, response):
        for product_div in response.css('div.product'):
            item = ProductItem()
            item['name'] = product_div.css('h2::text').get()
            item['price'] = product_div.css('span.price::text').get()
            item['description'] = product_div.css('p.description::text').get()
            item['url'] = response.url
            yield item
```

---

## Ethical Web Scraping

### robots.txt

```python
import urllib.robotparser

def check_robots_txt(url):
    """Check if URL is allowed by robots.txt."""
    rp = urllib.robotparser.RobotFileParser()
    rp.set_url(f'{url}/robots.txt')
    rp.read()
    
    user_agent = 'MyBot'
    if rp.can_fetch(user_agent, url):
        print(f'Allowed to scrape {url}')
        return True
    else:
        print(f'Not allowed to scrape {url}')
        return False

# Usage
check_robots_txt('https://example.com')
```

### Rate Limiting

```python
import time
import requests

class RateLimitedScraper:
    def __init__(self, delay=1.0):
        self.delay = delay
        self.last_request_time = 0
    
    def fetch(self, url):
        """Fetch URL with rate limiting."""
        # Wait if needed
        elapsed = time.time() - self.last_request_time
        if elapsed < self.delay:
            time.sleep(self.delay - elapsed)
        
        response = requests.get(url)
        self.last_request_time = time.time()
        return response

# Usage
scraper = RateLimitedScraper(delay=2.0)  # 2 seconds between requests
response = scraper.fetch('https://example.com')
```

### Best Practices

```python
#!/usr/bin/env python3
"""
Ethical Web Scraper
Follows best practices for web scraping
"""

import requests
from bs4 import BeautifulSoup
import time
import urllib.robotparser
from urllib.parse import urljoin, urlparse

class EthicalScraper:
    def __init__(self, base_url, delay=1.0, user_agent='MyBot/1.0'):
        self.base_url = base_url
        self.delay = delay
        self.user_agent = user_agent
        self.session = requests.Session()
        self.session.headers.update({'User-Agent': user_agent})
        self.last_request_time = 0
        self.robots_parser = None
        self._check_robots_txt()
    
    def _check_robots_txt(self):
        """Check robots.txt."""
        try:
            robots_url = urljoin(self.base_url, '/robots.txt')
            self.robots_parser = urllib.robotparser.RobotFileParser()
            self.robots_parser.set_url(robots_url)
            self.robots_parser.read()
            print(f'Loaded robots.txt from {robots_url}')
        except Exception as e:
            print(f'Could not load robots.txt: {e}')
            self.robots_parser = None
    
    def can_fetch(self, url):
        """Check if URL can be fetched according to robots.txt."""
        if self.robots_parser:
            return self.robots_parser.can_fetch(self.user_agent, url)
        return True
    
    def fetch(self, url):
        """Fetch URL with rate limiting and robots.txt check."""
        # Check robots.txt
        if not self.can_fetch(url):
            print(f'Skipping {url} (disallowed by robots.txt)')
            return None
        
        # Rate limiting
        elapsed = time.time() - self.last_request_time
        if elapsed < self.delay:
            time.sleep(self.delay - elapsed)
        
        try:
            response = self.session.get(url, timeout=10)
            response.raise_for_status()
            self.last_request_time = time.time()
            return response
        except Exception as e:
            print(f'Error fetching {url}: {e}')
            return None
    
    def scrape(self, url):
        """Scrape a single page."""
        response = self.fetch(url)
        if not response:
            return None
        
        soup = BeautifulSoup(response.text, 'html.parser')
        
        # Extract data (customize as needed)
        data = {
            'url': url,
            'title': soup.find('title').text.strip() if soup.find('title') else '',
            'content': soup.get_text(separator=' ', strip=True)[:500]  # First 500 chars
        }
        
        return data

def main():
    scraper = EthicalScraper('https://example.com', delay=2.0)
    
    urls = [
        'https://example.com/page1',
        'https://example.com/page2',
        'https://example.com/page3'
    ]
    
    for url in urls:
        data = scraper.scrape(url)
        if data:
            print(f"Scraped: {data['title']}")
        time.sleep(1)  # Additional delay between pages

if __name__ == '__main__':
    main()
```

### Legal and Ethical Guidelines

1. **Check Terms of Service**: Always read and respect website's ToS
2. **Respect robots.txt**: Follow robots.txt directives
3. **Rate Limiting**: Don't overload servers with requests
4. **Identify Yourself**: Use proper User-Agent headers
5. **Don't Scrape Personal Data**: Be careful with personal information
6. **Respect Copyright**: Don't republish copyrighted content
7. **Use APIs When Available**: Prefer official APIs over scraping
8. **Be Transparent**: If scraping for research, be transparent about it

---

## Practice Exercise

### Exercise: Web Scraper

**Objective**: Create a web scraper that extracts information from a website.

**Requirements**:

1. Create a scraper that:
   - Fetches web pages using requests
   - Parses HTML using BeautifulSoup
   - Extracts specific data (e.g., news headlines, product info)
   - Saves data to JSON or CSV
   - Implements rate limiting
   - Checks robots.txt

2. Features:
   - Error handling
   - Rate limiting
   - Data cleaning
   - Export functionality

**Example Solution**:

```python
#!/usr/bin/env python3
"""
News Headlines Scraper
Scrapes news headlines from a news website
"""

import requests
from bs4 import BeautifulSoup
import json
import csv
import time
import urllib.robotparser
from urllib.parse import urljoin
from typing import List, Dict

class NewsScraper:
    def __init__(self, base_url, delay=2.0):
        self.base_url = base_url
        self.delay = delay
        self.session = requests.Session()
        self.session.headers.update({
            'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        })
        self.last_request_time = 0
        self._check_robots_txt()
    
    def _check_robots_txt(self):
        """Check robots.txt."""
        try:
            robots_url = urljoin(self.base_url, '/robots.txt')
            self.robots_parser = urllib.robotparser.RobotFileParser()
            self.robots_parser.set_url(robots_url)
            self.robots_parser.read()
            print(f'✓ Loaded robots.txt')
        except Exception as e:
            print(f'⚠ Could not load robots.txt: {e}')
            self.robots_parser = None
    
    def can_fetch(self, url):
        """Check if URL is allowed."""
        if self.robots_parser:
            return self.robots_parser.can_fetch('*', url)
        return True
    
    def _rate_limit(self):
        """Implement rate limiting."""
        elapsed = time.time() - self.last_request_time
        if elapsed < self.delay:
            time.sleep(self.delay - elapsed)
        self.last_request_time = time.time()
    
    def fetch_page(self, url):
        """Fetch a webpage."""
        if not self.can_fetch(url):
            print(f'⚠ Skipping {url} (disallowed by robots.txt)')
            return None
        
        self._rate_limit()
        
        try:
            response = self.session.get(url, timeout=10)
            response.raise_for_status()
            return response
        except Exception as e:
            print(f'✗ Error fetching {url}: {e}')
            return None
    
    def extract_headlines(self, soup):
        """Extract headlines from page."""
        headlines = []
        
        # Adjust selectors based on actual website structure
        # This is a generic example
        article_elements = soup.find_all('article') or soup.find_all('div', class_='article')
        
        for element in article_elements:
            try:
                headline = {
                    'title': '',
                    'link': '',
                    'summary': '',
                    'date': ''
                }
                
                # Extract title
                title_elem = element.find('h2') or element.find('h3') or element.find('a')
                if title_elem:
                    headline['title'] = title_elem.get_text(strip=True)
                    if title_elem.name == 'a' and title_elem.get('href'):
                        headline['link'] = urljoin(self.base_url, title_elem['href'])
                
                # Extract summary
                summary_elem = element.find('p') or element.find('div', class_='summary')
                if summary_elem:
                    headline['summary'] = summary_elem.get_text(strip=True)[:200]
                
                # Extract date
                date_elem = element.find('time') or element.find('span', class_='date')
                if date_elem:
                    headline['date'] = date_elem.get_text(strip=True)
                
                if headline['title']:
                    headlines.append(headline)
            
            except Exception as e:
                print(f'Error extracting headline: {e}')
                continue
        
        return headlines
    
    def scrape(self, url):
        """Scrape headlines from a page."""
        response = self.fetch_page(url)
        if not response:
            return []
        
        soup = BeautifulSoup(response.text, 'html.parser')
        headlines = self.extract_headlines(soup)
        
        return headlines
    
    def save_json(self, data, filename):
        """Save data to JSON."""
        with open(filename, 'w', encoding='utf-8') as f:
            json.dump(data, f, indent=2, ensure_ascii=False)
        print(f'✓ Saved {len(data)} items to {filename}')
    
    def save_csv(self, data, filename):
        """Save data to CSV."""
        if not data:
            return
        
        fieldnames = data[0].keys()
        with open(filename, 'w', newline='', encoding='utf-8') as f:
            writer = csv.DictWriter(f, fieldnames=fieldnames)
            writer.writeheader()
            writer.writerows(data)
        print(f'✓ Saved {len(data)} items to {filename}')

def main():
    # Example: Scrape from a news website
    # Replace with actual URL
    base_url = 'https://example-news.com'
    
    scraper = NewsScraper(base_url, delay=2.0)
    
    # Scrape main page
    print(f'Scraping {base_url}...')
    headlines = scraper.scrape(base_url)
    
    if headlines:
        print(f'\n✓ Extracted {len(headlines)} headlines')
        
        # Display first few
        print('\nFirst 5 headlines:')
        for i, headline in enumerate(headlines[:5], 1):
            print(f'\n{i}. {headline["title"]}')
            if headline.get('summary'):
                print(f'   {headline["summary"]}')
        
        # Save data
        scraper.save_json(headlines, 'headlines.json')
        scraper.save_csv(headlines, 'headlines.csv')
    else:
        print('No headlines found')

if __name__ == '__main__':
    main()
```

**Expected Output**: A complete web scraper that extracts headlines and saves them to JSON and CSV files.

**Challenge** (Optional):
- Scrape multiple pages
- Handle pagination
- Extract images
- Handle dynamic content with Selenium
- Add data validation
- Create a CLI interface

---

## Key Takeaways

1. **Web Scraping** - Extracting data from websites
2. **BeautifulSoup** - HTML parsing library
3. **requests** - HTTP library for fetching pages
4. **HTML Navigation** - Finding and extracting elements
5. **CSS Selectors** - Powerful element selection
6. **Scrapy** - Advanced scraping framework
7. **Ethical Scraping** - Respect robots.txt and rate limits
8. **Rate Limiting** - Don't overload servers
9. **Error Handling** - Handle network and parsing errors
10. **Data Export** - Save to JSON, CSV, etc.
11. **Best Practices** - Legal, ethical, technical considerations
12. **Session Management** - Maintain cookies and headers
13. **Data Cleaning** - Process and clean scraped data
14. **Robots.txt** - Check before scraping
15. **User-Agent** - Identify your scraper properly

---

## Quiz: Web Scraping

Test your understanding with these questions:

1. **What library is commonly used for HTML parsing?**
   - A) requests
   - B) BeautifulSoup
   - C) urllib
   - D) scrapy

2. **What fetches web pages?**
   - A) requests.get()
   - B) BeautifulSoup()
   - C) urllib.fetch()
   - D) scrapy.get()

3. **What finds the first element?**
   - A) soup.find()
   - B) soup.find_all()
   - C) soup.select()
   - D) soup.get()

4. **What finds all elements?**
   - A) soup.find()
   - B) soup.find_all()
   - C) soup.select_all()
   - D) soup.get_all()

5. **What extracts text from element?**
   - A) element.text
   - B) element.get_text()
   - C) element.string
   - D) All of the above

6. **What is robots.txt?**
   - A) File that allows/disallows scraping
   - B) File with robot instructions
   - C) Scraping rules file
   - D) All of the above

7. **What is rate limiting?**
   - A) Limiting request speed
   - B) Delaying between requests
   - C) Respecting server resources
   - D) All of the above

8. **What is Scrapy?**
   - A) HTML parser
   - B) Web scraping framework
   - C) HTTP library
   - D) Browser automation

9. **What should you check before scraping?**
   - A) robots.txt
   - B) Terms of Service
   - C) Rate limits
   - D) All of the above

10. **What is ethical scraping?**
    - A) Following robots.txt
    - B) Rate limiting
    - C) Respecting ToS
    - D) All of the above

**Answers**:
1. B) BeautifulSoup (HTML parsing library)
2. A) requests.get() (fetch web pages)
3. A) soup.find() (find first element)
4. B) soup.find_all() (find all elements)
5. D) All of the above (text extraction methods)
6. D) All of the above (robots.txt purpose)
7. D) All of the above (rate limiting)
8. B) Web scraping framework (Scrapy)
9. D) All of the above (pre-scraping checks)
10. D) All of the above (ethical scraping)

---

## Next Steps

Excellent work! You've mastered web scraping basics. You now understand:
- BeautifulSoup for HTML parsing
- Scrapy introduction
- Ethical scraping practices
- How to build web scrapers

**What's Next?**
- Project 3.1: SQLite with Python
- Learn database operations
- Work with SQLite
- Build database applications

---

## Additional Resources

- **BeautifulSoup Documentation**: [www.crummy.com/software/BeautifulSoup/bs4/doc/](https://www.crummy.com/software/BeautifulSoup/bs4/doc/)
- **Scrapy Documentation**: [docs.scrapy.org/](https://docs.scrapy.org/)
- **requests Documentation**: [docs.python-requests.org/](https://docs.python-requests.org/)
- **Web Scraping Ethics**: Always respect website terms and robots.txt

---

*Project completed! You're ready to move on to the next project.*

