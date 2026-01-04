# Project 1.2: Weather App

## Project Overview

Build a Weather Application that fetches real-time weather data from an API and displays it in a beautiful, user-friendly interface. This project will help you practice API integration, Fetch API, error handling, and UI design.

## Learning Objectives

By the end of this project, you will be able to:
- Integrate with external APIs
- Use Fetch API for HTTP requests
- Handle API errors gracefully
- Design responsive user interfaces
- Parse and display JSON data
- Handle async operations

---

## Project Requirements

### Core Features

1. **Search by City**: Enter city name to get weather
2. **Current Weather**: Display current temperature, conditions
3. **Weather Details**: Show humidity, wind speed, pressure
4. **Weather Icons**: Visual representation of weather
5. **Error Handling**: Handle API errors and invalid inputs
6. **Loading States**: Show loading indicators
7. **Recent Searches**: Remember recent city searches
8. **Responsive Design**: Works on all devices

### Technical Requirements

- Use Fetch API for HTTP requests
- Use a weather API (OpenWeatherMap recommended)
- Handle errors gracefully
- Responsive CSS design
- Clean, organized code
- API key management

---

## Project Structure

```
weather-app/
├── index.html
├── css/
│   └── style.css
├── js/
│   ├── app.js
│   ├── api.js
│   └── ui.js
└── README.md
```

---

## Step-by-Step Implementation

### Step 1: Get API Key

1. Sign up at [OpenWeatherMap](https://openweathermap.org/api)
2. Get your free API key
3. Store it securely (use environment variables in production)

### Step 2: HTML Structure

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-cloud-sun"></i> Weather App</h1>
        </header>
        
        <main>
            <!-- Search Section -->
            <div class="search-section">
                <form id="search-form">
                    <input 
                        type="text" 
                        id="city-input" 
                        placeholder="Enter city name..."
                        autocomplete="off"
                    >
                    <button type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <div id="error-message" class="error-message hidden"></div>
            </div>
            
            <!-- Loading Indicator -->
            <div id="loading" class="loading hidden">
                <i class="fas fa-spinner fa-spin"></i>
                <p>Loading weather data...</p>
            </div>
            
            <!-- Weather Display -->
            <div id="weather-container" class="weather-container hidden">
                <!-- Current Weather -->
                <div class="current-weather">
                    <div class="location">
                        <h2 id="city-name"></h2>
                        <p id="date"></p>
                    </div>
                    <div class="temperature">
                        <img id="weather-icon" src="" alt="Weather icon">
                        <div>
                            <span id="temperature"></span>
                            <span class="unit">°C</span>
                        </div>
                    </div>
                    <div class="description">
                        <p id="weather-description"></p>
                    </div>
                </div>
                
                <!-- Weather Details -->
                <div class="weather-details">
                    <div class="detail-item">
                        <i class="fas fa-tint"></i>
                        <div>
                            <p class="label">Humidity</p>
                            <p id="humidity" class="value"></p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-wind"></i>
                        <div>
                            <p class="label">Wind Speed</p>
                            <p id="wind-speed" class="value"></p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-compress-arrows-alt"></i>
                        <div>
                            <p class="label">Pressure</p>
                            <p id="pressure" class="value"></p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-eye"></i>
                        <div>
                            <p class="label">Visibility</p>
                            <p id="visibility" class="value"></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Searches -->
            <div class="recent-searches">
                <h3>Recent Searches</h3>
                <div id="recent-list" class="recent-list"></div>
            </div>
        </main>
    </div>
    
    <script src="js/api.js"></script>
    <script src="js/ui.js"></script>
    <script src="js/app.js"></script>
</body>
</html>
```

### Step 3: CSS Styling

```css
/* css/style.css */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
    min-height: 100vh;
    padding: 20px;
}

.container {
    max-width: 600px;
    margin: 0 auto;
}

header {
    text-align: center;
    color: white;
    margin-bottom: 30px;
}

header h1 {
    font-size: 2.5em;
    font-weight: 300;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}

.search-section {
    margin-bottom: 30px;
}

#search-form {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
}

#city-input {
    flex: 1;
    padding: 15px;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

#city-input:focus {
    outline: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

#search-form button {
    padding: 15px 20px;
    background: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 18px;
    color: #0984e3;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
}

#search-form button:hover {
    background: #f0f0f0;
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.error-message {
    background: #ff6b6b;
    color: white;
    padding: 12px;
    border-radius: 5px;
    text-align: center;
    margin-top: 10px;
}

.error-message.hidden {
    display: none;
}

.loading {
    text-align: center;
    color: white;
    padding: 40px;
}

.loading i {
    font-size: 3em;
    margin-bottom: 20px;
}

.loading.hidden {
    display: none;
}

.weather-container {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    margin-bottom: 30px;
}

.weather-container.hidden {
    display: none;
}

.current-weather {
    text-align: center;
    margin-bottom: 30px;
    padding-bottom: 30px;
    border-bottom: 1px solid #e0e0e0;
}

.location h2 {
    font-size: 2em;
    color: #333;
    margin-bottom: 5px;
}

.location p {
    color: #666;
    font-size: 14px;
}

.temperature {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    margin: 20px 0;
}

.temperature img {
    width: 80px;
    height: 80px;
}

.temperature span {
    font-size: 4em;
    font-weight: 300;
    color: #333;
}

.temperature .unit {
    font-size: 2em;
    vertical-align: super;
}

.description p {
    font-size: 1.2em;
    color: #666;
    text-transform: capitalize;
}

.weather-details {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 10px;
}

.detail-item i {
    font-size: 2em;
    color: #0984e3;
}

.detail-item .label {
    font-size: 12px;
    color: #666;
    margin-bottom: 5px;
}

.detail-item .value {
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.recent-searches {
    background: white;
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.recent-searches h3 {
    color: #333;
    margin-bottom: 15px;
}

.recent-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.recent-item {
    padding: 8px 16px;
    background: #f8f9fa;
    border-radius: 20px;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 14px;
}

.recent-item:hover {
    background: #e9ecef;
    transform: translateY(-2px);
}

@media (max-width: 600px) {
    .weather-details {
        grid-template-columns: 1fr;
    }
    
    .temperature {
        flex-direction: column;
    }
    
    header h1 {
        font-size: 2em;
    }
}
```

### Step 4: API Module

```javascript
// js/api.js
class WeatherAPI {
    constructor() {
        // Replace with your API key
        this.apiKey = 'YOUR_API_KEY_HERE';
        this.baseURL = 'https://api.openweathermap.org/data/2.5';
    }
    
    async getWeather(city) {
        try {
            const url = `${this.baseURL}/weather?q=${city}&appid=${this.apiKey}&units=metric`;
            const response = await fetch(url);
            
            if (!response.ok) {
                if (response.status === 404) {
                    throw new Error('City not found');
                }
                throw new Error('Failed to fetch weather data');
            }
            
            const data = await response.json();
            return this.formatWeatherData(data);
        } catch (error) {
            throw error;
        }
    }
    
    formatWeatherData(data) {
        return {
            city: data.name,
            country: data.sys.country,
            temperature: Math.round(data.main.temp),
            feelsLike: Math.round(data.main.feels_like),
            description: data.weather[0].description,
            icon: data.weather[0].icon,
            humidity: data.main.humidity,
            windSpeed: data.wind.speed,
            pressure: data.main.pressure,
            visibility: data.visibility ? (data.visibility / 1000).toFixed(1) : 'N/A',
            date: new Date().toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            })
        };
    }
    
    getIconURL(iconCode) {
        return `https://openweathermap.org/img/wn/${iconCode}@2x.png`;
    }
}
```

### Step 5: UI Module

```javascript
// js/ui.js
class WeatherUI {
    constructor() {
        this.initializeElements();
    }
    
    initializeElements() {
        this.weatherContainer = document.getElementById('weather-container');
        this.loading = document.getElementById('loading');
        this.errorMessage = document.getElementById('error-message');
        this.cityName = document.getElementById('city-name');
        this.date = document.getElementById('date');
        this.temperature = document.getElementById('temperature');
        this.weatherIcon = document.getElementById('weather-icon');
        this.weatherDescription = document.getElementById('weather-description');
        this.humidity = document.getElementById('humidity');
        this.windSpeed = document.getElementById('wind-speed');
        this.pressure = document.getElementById('pressure');
        this.visibility = document.getElementById('visibility');
        this.recentList = document.getElementById('recent-list');
    }
    
    showLoading() {
        this.loading.classList.remove('hidden');
        this.weatherContainer.classList.add('hidden');
        this.hideError();
    }
    
    hideLoading() {
        this.loading.classList.add('hidden');
    }
    
    showWeather(weatherData, api) {
        this.hideLoading();
        this.hideError();
        
        this.cityName.textContent = `${weatherData.city}, ${weatherData.country}`;
        this.date.textContent = weatherData.date;
        this.temperature.textContent = weatherData.temperature;
        this.weatherIcon.src = api.getIconURL(weatherData.icon);
        this.weatherIcon.alt = weatherData.description;
        this.weatherDescription.textContent = weatherData.description;
        this.humidity.textContent = `${weatherData.humidity}%`;
        this.windSpeed.textContent = `${weatherData.windSpeed} m/s`;
        this.pressure.textContent = `${weatherData.pressure} hPa`;
        this.visibility.textContent = `${weatherData.visibility} km`;
        
        this.weatherContainer.classList.remove('hidden');
    }
    
    showError(message) {
        this.hideLoading();
        this.weatherContainer.classList.add('hidden');
        this.errorMessage.textContent = message;
        this.errorMessage.classList.remove('hidden');
    }
    
    hideError() {
        this.errorMessage.classList.add('hidden');
    }
    
    addRecentSearch(city) {
        const recentSearches = this.getRecentSearches();
        if (!recentSearches.includes(city)) {
            recentSearches.unshift(city);
            if (recentSearches.length > 5) {
                recentSearches.pop();
            }
            localStorage.setItem('recentSearches', JSON.stringify(recentSearches));
            this.renderRecentSearches();
        }
    }
    
    getRecentSearches() {
        const stored = localStorage.getItem('recentSearches');
        return stored ? JSON.parse(stored) : [];
    }
    
    renderRecentSearches() {
        const recentSearches = this.getRecentSearches();
        if (recentSearches.length === 0) {
            this.recentList.innerHTML = '<p style="color: #666;">No recent searches</p>';
            return;
        }
        
        this.recentList.innerHTML = recentSearches.map(city => 
            `<span class="recent-item" data-city="${city}">${city}</span>`
        ).join('');
    }
}
```

### Step 6: Main Application

```javascript
// js/app.js
class WeatherApp {
    constructor() {
        this.api = new WeatherAPI();
        this.ui = new WeatherUI();
        this.initializeApp();
    }
    
    initializeApp() {
        this.attachEventListeners();
        this.ui.renderRecentSearches();
        
        // Load weather for default city (optional)
        // this.loadWeather('London');
    }
    
    attachEventListeners() {
        const form = document.getElementById('search-form');
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleSearch();
        });
        
        // Recent searches click
        this.ui.recentList.addEventListener('click', (e) => {
            if (e.target.classList.contains('recent-item')) {
                const city = e.target.dataset.city;
                document.getElementById('city-input').value = city;
                this.loadWeather(city);
            }
        });
    }
    
    async handleSearch() {
        const input = document.getElementById('city-input');
        const city = input.value.trim();
        
        if (!city) {
            this.ui.showError('Please enter a city name');
            return;
        }
        
        await this.loadWeather(city);
    }
    
    async loadWeather(city) {
        try {
            this.ui.showLoading();
            const weatherData = await this.api.getWeather(city);
            this.ui.showWeather(weatherData, this.api);
            this.ui.addRecentSearch(city);
        } catch (error) {
            this.ui.showError(error.message);
        }
    }
}

// Initialize app
const app = new WeatherApp();
```

---

## API Integration

### Fetch API Usage

- **GET Requests**: Fetch weather data
- **Error Handling**: Handle network and API errors
- **Async/Await**: Modern async handling
- **Response Parsing**: Convert JSON to usable data

### Error Handling

- **Network Errors**: Connection issues
- **API Errors**: Invalid city, API key issues
- **User Feedback**: Clear error messages
- **Graceful Degradation**: App continues to work

---

## Testing Your Application

### Manual Testing Checklist

- [ ] Search for a valid city
- [ ] Search for invalid city (error handling)
- [ ] Check all weather data displays correctly
- [ ] Test recent searches functionality
- [ ] Test with empty input
- [ ] Test loading states
- [ ] Test on mobile devices
- [ ] Test with slow network (loading indicator)

---

## Exercise: Build Weather App

**Instructions**:

1. Sign up for OpenWeatherMap API
2. Get your API key
3. Create all files as shown
4. Replace 'YOUR_API_KEY_HERE' with your actual key
5. Test all features
6. Customize the design

**Enhancement Ideas**:

- Add 5-day forecast
- Add hourly forecast
- Add weather maps
- Add location-based weather (geolocation)
- Add unit conversion (Celsius/Fahrenheit)
- Add weather alerts
- Add favorite cities
- Add weather history

---

## Common Issues and Solutions

### Issue: API key not working

**Solution**: Check that you've replaced the placeholder and that your API key is valid.

### Issue: CORS errors

**Solution**: OpenWeatherMap API supports CORS. If you see CORS errors, check your API key.

### Issue: City not found

**Solution**: Ensure city name is spelled correctly. Try using city, country format.

---

## Quiz: API Integration

1. **Fetch API:**
   - A) Modern way to make HTTP requests
   - B) Old way to make requests
   - C) Both
   - D) Neither

2. **async/await:**
   - A) Handles asynchronous operations
   - B) Handles synchronous operations
   - C) Both
   - D) Neither

3. **Error handling:**
   - A) Important for API calls
   - B) Not important
   - C) Both
   - D) Neither

4. **API key:**
   - A) Should be kept secret
   - B) Can be public
   - C) Both
   - D) Neither

5. **Loading states:**
   - A) Improve user experience
   - B) Don't improve UX
   - C) Both
   - D) Neither

**Answers**:
1. A) Modern way to make HTTP requests
2. A) Handles asynchronous operations
3. A) Important for API calls
4. A) Should be kept secret
5. A) Improve user experience

---

## Key Takeaways

1. **API Integration**: Connect to external services
2. **Fetch API**: Modern HTTP client
3. **Error Handling**: Essential for robust apps
4. **Async Operations**: Handle asynchronous data
5. **UI Design**: Create beautiful interfaces
6. **Best Practice**: Handle all error cases

---

## Next Steps

Congratulations! You've built a Weather Application. You now know:
- How to integrate with APIs
- How to use Fetch API
- How to handle errors
- How to design user interfaces

**What's Next?**
- Project 1.3: Calculator
- Learn state management
- Build a calculator application
- Practice event handling

---

*Project completed! You're ready to move on to the next project.*

