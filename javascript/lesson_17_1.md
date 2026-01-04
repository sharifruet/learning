# Lesson 17.1: Geolocation API

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand the Geolocation API
- Get user's current position
- Watch position changes
- Handle geolocation errors
- Calculate distances between coordinates
- Build location-based applications
- Respect user privacy

---

## Introduction to Geolocation API

The Geolocation API allows web applications to access the user's geographical location.

### Why Geolocation?

- **Location Services**: Find nearby places
- **Maps Integration**: Show user on map
- **Navigation**: Provide directions
- **Location Tracking**: Track movement
- **Personalization**: Location-based content
- **Modern Web**: Essential for many apps

### Privacy Considerations

- **User Permission**: Always requires user consent
- **HTTPS Required**: Must use secure connection (except localhost)
- **Privacy Policy**: Inform users about location usage
- **Opt-in**: Users can deny permission

---

## Getting Current Position

### Basic getCurrentPosition()

```javascript
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
        function(position) {
            console.log('Latitude:', position.coords.latitude);
            console.log('Longitude:', position.coords.longitude);
        },
        function(error) {
            console.error('Error:', error.message);
        }
    );
} else {
    console.error('Geolocation not supported');
}
```

### Position Object

```javascript
navigator.geolocation.getCurrentPosition(function(position) {
    // Coordinates
    console.log('Latitude:', position.coords.latitude);
    console.log('Longitude:', position.coords.longitude);
    console.log('Altitude:', position.coords.altitude);
    console.log('Accuracy:', position.coords.accuracy);  // meters
    console.log('Altitude Accuracy:', position.coords.altitudeAccuracy);
    console.log('Heading:', position.coords.heading);  // degrees
    console.log('Speed:', position.coords.speed);  // m/s
    
    // Timestamp
    console.log('Timestamp:', new Date(position.timestamp));
});
```

### Position Options

```javascript
let options = {
    enableHighAccuracy: true,  // Use GPS if available
    timeout: 5000,              // Max time to wait (ms)
    maximumAge: 0               // Max age of cached position (ms)
};

navigator.geolocation.getCurrentPosition(
    successCallback,
    errorCallback,
    options
);
```

### Options Explained

```javascript
// enableHighAccuracy
// true: Use GPS (more accurate, slower, more battery)
// false: Use network (faster, less accurate)
enableHighAccuracy: true

// timeout
// Maximum time to wait for position (milliseconds)
timeout: 10000  // 10 seconds

// maximumAge
// Accept cached position if less than this age (milliseconds)
maximumAge: 60000  // 1 minute
```

---

## Watching Position

### watchPosition()

Continuously watch position changes:

```javascript
let watchId = navigator.geolocation.watchPosition(
    function(position) {
        console.log('Position updated:', position.coords);
    },
    function(error) {
        console.error('Error:', error.message);
    },
    {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
    }
);

// Stop watching
navigator.geolocation.clearWatch(watchId);
```

### watchPosition() vs getCurrentPosition()

```javascript
// getCurrentPosition: Get position once
navigator.geolocation.getCurrentPosition(callback);

// watchPosition: Get position continuously
let watchId = navigator.geolocation.watchPosition(callback);
// Returns watch ID to stop later
```

---

## Error Handling

### Error Types

```javascript
navigator.geolocation.getCurrentPosition(
    function(position) {
        // Success
    },
    function(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                console.error('User denied geolocation');
                break;
            case error.POSITION_UNAVAILABLE:
                console.error('Position unavailable');
                break;
            case error.TIMEOUT:
                console.error('Request timeout');
                break;
            default:
                console.error('Unknown error');
        }
    }
);
```

### Error Codes

```javascript
// PERMISSION_DENIED (1)
// User denied permission

// POSITION_UNAVAILABLE (2)
// Position could not be determined

// TIMEOUT (3)
// Request timed out
```

### Error Messages

```javascript
function handleGeolocationError(error) {
    let message = '';
    
    switch(error.code) {
        case error.PERMISSION_DENIED:
            message = 'User denied the request for geolocation.';
            break;
        case error.POSITION_UNAVAILABLE:
            message = 'Location information is unavailable.';
            break;
        case error.TIMEOUT:
            message = 'The request to get user location timed out.';
            break;
        default:
            message = 'An unknown error occurred.';
    }
    
    console.error('Geolocation error:', message);
    return message;
}
```

---

## Practical Examples

### Example 1: Get Current Location

```javascript
function getCurrentLocation() {
    return new Promise((resolve, reject) => {
        if (!navigator.geolocation) {
            reject(new Error('Geolocation not supported'));
            return;
        }
        
        navigator.geolocation.getCurrentPosition(
            (position) => {
                resolve({
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude,
                    accuracy: position.coords.accuracy
                });
            },
            (error) => {
                reject(error);
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    });
}

// Usage
getCurrentLocation()
    .then(location => {
        console.log('Location:', location);
    })
    .catch(error => {
        console.error('Error:', error);
    });
```

### Example 2: Location Tracker

```javascript
class LocationTracker {
    constructor() {
        this.watchId = null;
        this.callbacks = [];
    }
    
    start(callback) {
        if (this.watchId !== null) {
            console.warn('Already tracking');
            return;
        }
        
        if (!navigator.geolocation) {
            throw new Error('Geolocation not supported');
        }
        
        this.watchId = navigator.geolocation.watchPosition(
            (position) => {
                let location = {
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude,
                    accuracy: position.coords.accuracy,
                    timestamp: position.timestamp
                };
                
                this.callbacks.forEach(cb => cb(location));
            },
            (error) => {
                console.error('Geolocation error:', error);
            },
            {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            }
        );
    }
    
    stop() {
        if (this.watchId !== null) {
            navigator.geolocation.clearWatch(this.watchId);
            this.watchId = null;
        }
    }
    
    onUpdate(callback) {
        this.callbacks.push(callback);
    }
}

// Usage
let tracker = new LocationTracker();
tracker.onUpdate((location) => {
    console.log('Location updated:', location);
});
tracker.start();
```

### Example 3: Distance Calculator

```javascript
function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371; // Earth's radius in km
    const dLat = toRad(lat2 - lat1);
    const dLon = toRad(lon2 - lon1);
    
    const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
              Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
              Math.sin(dLon / 2) * Math.sin(dLon / 2);
    
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    const distance = R * c;
    
    return distance;
}

function toRad(degrees) {
    return degrees * (Math.PI / 180);
}

// Usage
let distance = calculateDistance(40.7128, -74.0060, 34.0522, -118.2437);
console.log('Distance:', distance, 'km');
```

### Example 4: Location-based App

```javascript
class LocationApp {
    constructor() {
        this.currentLocation = null;
        this.nearbyPlaces = [];
    }
    
    async initialize() {
        try {
            this.currentLocation = await this.getLocation();
            this.nearbyPlaces = await this.findNearbyPlaces(this.currentLocation);
            this.displayLocation();
            this.displayNearbyPlaces();
        } catch (error) {
            this.handleError(error);
        }
    }
    
    getLocation() {
        return new Promise((resolve, reject) => {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    resolve({
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    });
                },
                reject,
                { enableHighAccuracy: true, timeout: 10000 }
            );
        });
    }
    
    async findNearbyPlaces(location) {
        // Simulate API call
        return [
            { name: 'Place 1', distance: 0.5 },
            { name: 'Place 2', distance: 1.2 }
        ];
    }
    
    displayLocation() {
        console.log('Current location:', this.currentLocation);
    }
    
    displayNearbyPlaces() {
        console.log('Nearby places:', this.nearbyPlaces);
    }
    
    handleError(error) {
        console.error('Location error:', error.message);
    }
}
```

---

## Practice Exercise

### Exercise: Geolocation App

**Objective**: Practice using the Geolocation API to get and track user location.

**Instructions**:

1. Create an HTML file with location display
2. Create a JavaScript file for geolocation
3. Practice:
   - Getting current position
   - Watching position changes
   - Handling errors
   - Calculating distances
   - Displaying location on map

**Example Solution**:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geolocation Practice</title>
    <style>
        .container {
            max-width: 600px;
            margin: 20px;
        }
        button {
            padding: 10px 20px;
            margin: 5px;
        }
        .location-info {
            margin-top: 20px;
            padding: 15px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Geolocation Practice</h1>
        
        <button onclick="getCurrentLocation()">Get Current Location</button>
        <button onclick="startTracking()">Start Tracking</button>
        <button onclick="stopTracking()">Stop Tracking</button>
        
        <div id="locationInfo" class="location-info"></div>
        <div id="trackingInfo" class="location-info"></div>
    </div>
    
    <script src="geolocation-practice.js"></script>
</body>
</html>
```

```javascript
// geolocation-practice.js
console.log("=== Geolocation Practice ===");

let locationInfo = document.getElementById('locationInfo');
let trackingInfo = document.getElementById('trackingInfo');
let watchId = null;

function displayLocation(position, element) {
    let html = `
        <h3>Location Information</h3>
        <p><strong>Latitude:</strong> ${position.coords.latitude.toFixed(6)}</p>
        <p><strong>Longitude:</strong> ${position.coords.longitude.toFixed(6)}</p>
        <p><strong>Accuracy:</strong> ${position.coords.accuracy.toFixed(2)} meters</p>
        <p><strong>Altitude:</strong> ${position.coords.altitude ? position.coords.altitude.toFixed(2) + ' meters' : 'Not available'}</p>
        <p><strong>Heading:</strong> ${position.coords.heading ? position.coords.heading.toFixed(2) + ' degrees' : 'Not available'}</p>
        <p><strong>Speed:</strong> ${position.coords.speed ? position.coords.speed.toFixed(2) + ' m/s' : 'Not available'}</p>
        <p><strong>Timestamp:</strong> ${new Date(position.timestamp).toLocaleString()}</p>
    `;
    element.innerHTML = html;
    element.className = 'location-info success';
}

function displayError(error, element) {
    let message = '';
    switch(error.code) {
        case error.PERMISSION_DENIED:
            message = 'User denied geolocation permission';
            break;
        case error.POSITION_UNAVAILABLE:
            message = 'Position information unavailable';
            break;
        case error.TIMEOUT:
            message = 'Request timeout';
            break;
        default:
            message = 'Unknown error occurred';
    }
    
    element.innerHTML = `<p class="error">Error: ${message}</p>`;
    element.className = 'location-info error';
}

console.log("\n=== Check Geolocation Support ===");

if (navigator.geolocation) {
    console.log('Geolocation is supported');
} else {
    console.error('Geolocation is not supported');
    locationInfo.innerHTML = '<p class="error">Geolocation is not supported in this browser</p>';
}
console.log();

console.log("=== Get Current Location ===");

function getCurrentLocation() {
    if (!navigator.geolocation) {
        displayError({ code: -1 }, locationInfo);
        return;
    }
    
    locationInfo.innerHTML = '<p>Getting location...</p>';
    
    navigator.geolocation.getCurrentPosition(
        function(position) {
            console.log('Position obtained:', position);
            displayLocation(position, locationInfo);
            
            // Log coordinates
            console.log('Latitude:', position.coords.latitude);
            console.log('Longitude:', position.coords.longitude);
            console.log('Accuracy:', position.coords.accuracy, 'meters');
        },
        function(error) {
            console.error('Error getting position:', error);
            displayError(error, locationInfo);
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        }
    );
}
console.log();

console.log("=== Watch Position ===");

function startTracking() {
    if (!navigator.geolocation) {
        displayError({ code: -1 }, trackingInfo);
        return;
    }
    
    if (watchId !== null) {
        console.warn('Already tracking');
        return;
    }
    
    trackingInfo.innerHTML = '<p>Starting to track location...</p>';
    
    watchId = navigator.geolocation.watchPosition(
        function(position) {
            console.log('Position updated:', position);
            displayLocation(position, trackingInfo);
            
            // Calculate distance if previous position exists
            if (window.lastPosition) {
                let distance = calculateDistance(
                    window.lastPosition.coords.latitude,
                    window.lastPosition.coords.longitude,
                    position.coords.latitude,
                    position.coords.longitude
                );
                console.log('Distance moved:', distance.toFixed(2), 'km');
            }
            window.lastPosition = position;
        },
        function(error) {
            console.error('Error watching position:', error);
            displayError(error, trackingInfo);
        },
        {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0
        }
    );
    
    console.log('Tracking started, watch ID:', watchId);
}

function stopTracking() {
    if (watchId !== null) {
        navigator.geolocation.clearWatch(watchId);
        watchId = null;
        trackingInfo.innerHTML = '<p>Tracking stopped</p>';
        console.log('Tracking stopped');
    } else {
        console.warn('Not currently tracking');
    }
}
console.log();

console.log("=== Distance Calculation ===");

function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371; // Earth's radius in km
    const dLat = toRad(lat2 - lat1);
    const dLon = toRad(lon2 - lon1);
    
    const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
              Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
              Math.sin(dLon / 2) * Math.sin(dLon / 2);
    
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    const distance = R * c;
    
    return distance;
}

function toRad(degrees) {
    return degrees * (Math.PI / 180);
}

// Test distance calculation
let distance = calculateDistance(40.7128, -74.0060, 34.0522, -118.2437);
console.log('Distance between NYC and LA:', distance.toFixed(2), 'km');
console.log();

console.log("=== Position Options ===");

function getLocationWithOptions() {
    let options = {
        enableHighAccuracy: true,  // Use GPS
        timeout: 10000,            // 10 seconds
        maximumAge: 0              // No cache
    };
    
    navigator.geolocation.getCurrentPosition(
        function(position) {
            console.log('High accuracy position:', position);
        },
        function(error) {
            console.error('Error:', error);
        },
        options
    );
}
console.log();

console.log("=== Error Handling ===");

function handleGeolocationError(error) {
    let message = '';
    let code = '';
    
    switch(error.code) {
        case error.PERMISSION_DENIED:
            message = 'User denied the request for geolocation';
            code = 'PERMISSION_DENIED (1)';
            break;
        case error.POSITION_UNAVAILABLE:
            message = 'Location information is unavailable';
            code = 'POSITION_UNAVAILABLE (2)';
            break;
        case error.TIMEOUT:
            message = 'The request to get user location timed out';
            code = 'TIMEOUT (3)';
            break;
        default:
            message = 'An unknown error occurred';
            code = 'UNKNOWN';
    }
    
    console.error('Error code:', code);
    console.error('Error message:', message);
    return { code, message };
}
console.log();

console.log("=== Promise-based Wrapper ===");

function getCurrentLocationPromise() {
    return new Promise((resolve, reject) => {
        if (!navigator.geolocation) {
            reject(new Error('Geolocation not supported'));
            return;
        }
        
        navigator.geolocation.getCurrentPosition(
            (position) => {
                resolve({
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude,
                    accuracy: position.coords.accuracy,
                    timestamp: position.timestamp
                });
            },
            (error) => {
                reject(error);
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    });
}

// Usage example
getCurrentLocationPromise()
    .then(location => {
        console.log('Location (promise):', location);
    })
    .catch(error => {
        console.error('Error (promise):', error);
    });
console.log();

console.log("=== Location Tracker Class ===");

class LocationTracker {
    constructor() {
        this.watchId = null;
        this.callbacks = [];
        this.positions = [];
    }
    
    start(callback) {
        if (this.watchId !== null) {
            console.warn('Already tracking');
            return;
        }
        
        if (!navigator.geolocation) {
            throw new Error('Geolocation not supported');
        }
        
        this.watchId = navigator.geolocation.watchPosition(
            (position) => {
                let location = {
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude,
                    accuracy: position.coords.accuracy,
                    timestamp: position.timestamp
                };
                
                this.positions.push(location);
                this.callbacks.forEach(cb => cb(location));
            },
            (error) => {
                console.error('Geolocation error:', error);
            },
            {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            }
        );
    }
    
    stop() {
        if (this.watchId !== null) {
            navigator.geolocation.clearWatch(this.watchId);
            this.watchId = null;
        }
    }
    
    onUpdate(callback) {
        this.callbacks.push(callback);
    }
    
    getPositions() {
        return this.positions;
    }
    
    clearPositions() {
        this.positions = [];
    }
}

// Demonstrate tracker
let tracker = new LocationTracker();
tracker.onUpdate((location) => {
    console.log('Tracker update:', location);
});
console.log();
```

**Expected Output** (in browser console):
```
=== Geolocation Practice ===

=== Check Geolocation Support ===
Geolocation is supported

=== Get Current Location ===
[On button click]
Position obtained: [Position object]
Latitude: [value]
Longitude: [value]
Accuracy: [value] meters

=== Watch Position ===
[On start tracking]
Tracking started, watch ID: [id]
Position updated: [Position object]
[On movement]
Distance moved: [value] km

=== Distance Calculation ===
Distance between NYC and LA: [value] km

=== Promise-based Wrapper ===
Location (promise): { latitude: [value], longitude: [value], ... }

=== Location Tracker Class ===
Tracker update: { latitude: [value], longitude: [value], ... }
```

**Challenge (Optional)**:
- Build a complete location tracking app
- Create a distance calculator
- Build a location history system
- Integrate with mapping services

---

## Common Mistakes

### 1. Not Checking Support

```javascript
// ⚠️ Problem: Might not be supported
navigator.geolocation.getCurrentPosition(callback);

// ✅ Solution: Check first
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(callback);
} else {
    console.error('Geolocation not supported');
}
```

### 2. Not Handling Errors

```javascript
// ⚠️ Problem: No error handling
navigator.geolocation.getCurrentPosition(success);

// ✅ Solution: Handle errors
navigator.geolocation.getCurrentPosition(success, error);
```

### 3. Not Clearing Watch

```javascript
// ⚠️ Problem: Watch continues after component unmounts
let watchId = navigator.geolocation.watchPosition(callback);
// Never cleared!

// ✅ Solution: Clear when done
navigator.geolocation.clearWatch(watchId);
```

### 4. Using HTTP Instead of HTTPS

```javascript
// ⚠️ Problem: Geolocation requires HTTPS (except localhost)
// Won't work on HTTP sites

// ✅ Solution: Use HTTPS or localhost
```

---

## Key Takeaways

1. **Geolocation API**: Access user location
2. **getCurrentPosition()**: Get position once
3. **watchPosition()**: Track position continuously
4. **Error Handling**: Always handle errors
5. **Privacy**: Requires user permission, HTTPS required
6. **Options**: enableHighAccuracy, timeout, maximumAge
7. **Best Practice**: Check support, handle errors, clear watches
8. **Use Cases**: Maps, navigation, location-based services

---

## Quiz: Geolocation

Test your understanding with these questions:

1. **Geolocation requires:**
   - A) HTTP
   - B) HTTPS (or localhost)
   - C) No connection
   - D) Nothing

2. **getCurrentPosition() gets:**
   - A) Position once
   - B) Position continuously
   - C) Both
   - D) Nothing

3. **watchPosition() returns:**
   - A) Position
   - B) Watch ID
   - C) Error
   - D) Nothing

4. **PERMISSION_DENIED means:**
   - A) Position unavailable
   - B) User denied permission
   - C) Timeout
   - D) Unknown error

5. **enableHighAccuracy:**
   - A) Uses GPS
   - B) Uses network
   - C) Both
   - D) Neither

6. **clearWatch() stops:**
   - A) getCurrentPosition
   - B) watchPosition
   - C) Both
   - D) Nothing

7. **Geolocation is:**
   - A) Synchronous
   - B) Asynchronous
   - C) Both
   - D) Neither

**Answers**:
1. B) HTTPS (or localhost)
2. A) Position once
3. B) Watch ID
4. B) User denied permission
5. A) Uses GPS
6. B) watchPosition
7. B) Asynchronous

---

## Next Steps

Congratulations! You've learned the Geolocation API. You now know:
- How to get user location
- How to track position changes
- How to handle errors
- How to calculate distances

**What's Next?**
- Lesson 17.2: Web Storage and File APIs
- Learn FileReader API
- Work with file uploads
- Implement drag and drop

---

## Additional Resources

- **MDN: Geolocation API**: [developer.mozilla.org/en-US/docs/Web/API/Geolocation_API](https://developer.mozilla.org/en-US/docs/Web/API/Geolocation_API)
- **MDN: Using Geolocation**: [developer.mozilla.org/en-US/docs/Web/API/Geolocation_API/Using_the_Geolocation_API](https://developer.mozilla.org/en-US/docs/Web/API/Geolocation_API/Using_the_Geolocation_API)

---

*Lesson completed! You're ready to move on to the next lesson.*

