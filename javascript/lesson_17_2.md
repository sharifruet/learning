# Lesson 17.2: Web Storage and File APIs

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand the FileReader API
- Read files from user input
- Handle different file types
- Implement drag and drop
- Work with file objects
- Validate file types and sizes
- Build file upload interfaces

---

## Introduction to File APIs

File APIs allow web applications to read files from the user's device.

### Why File APIs?

- **File Uploads**: Upload files to server
- **File Processing**: Process files client-side
- **Image Preview**: Show image before upload
- **File Validation**: Validate before upload
- **Drag and Drop**: Better UX for file selection
- **Modern Web**: Essential for web applications

---

## FileReader API

### Basic File Reading

```javascript
let fileInput = document.getElementById('fileInput');

fileInput.addEventListener('change', function(event) {
    let file = event.target.files[0];
    
    if (file) {
        let reader = new FileReader();
        
        reader.onload = function(e) {
            console.log('File content:', e.target.result);
        };
        
        reader.readAsText(file);
    }
});
```

### FileReader Methods

```javascript
let reader = new FileReader();

// Read as text
reader.readAsText(file);

// Read as data URL (base64)
reader.readAsDataURL(file);

// Read as array buffer
reader.readAsArrayBuffer(file);

// Read as binary string
reader.readAsBinaryString(file);
```

### FileReader Events

```javascript
let reader = new FileReader();

reader.onload = function(event) {
    console.log('File loaded:', event.target.result);
};

reader.onerror = function(event) {
    console.error('Error reading file:', event.target.error);
};

reader.onprogress = function(event) {
    if (event.lengthComputable) {
        let percentLoaded = (event.loaded / event.total) * 100;
        console.log('Progress:', percentLoaded + '%');
    }
};

reader.onloadstart = function() {
    console.log('Reading started');
};

reader.onloadend = function() {
    console.log('Reading finished');
};

reader.onabort = function() {
    console.log('Reading aborted');
};
```

---

## Reading Different File Types

### Reading Text Files

```javascript
function readTextFile(file) {
    return new Promise((resolve, reject) => {
        let reader = new FileReader();
        
        reader.onload = function(event) {
            resolve(event.target.result);
        };
        
        reader.onerror = function(event) {
            reject(event.target.error);
        };
        
        reader.readAsText(file);
    });
}

// Usage
let fileInput = document.getElementById('fileInput');
fileInput.addEventListener('change', async function(event) {
    let file = event.target.files[0];
    if (file) {
        try {
            let content = await readTextFile(file);
            console.log('File content:', content);
        } catch (error) {
            console.error('Error:', error);
        }
    }
});
```

### Reading Images

```javascript
function readImageFile(file) {
    return new Promise((resolve, reject) => {
        let reader = new FileReader();
        
        reader.onload = function(event) {
            let img = new Image();
            img.src = event.target.result;
            img.onload = function() {
                resolve({
                    dataURL: event.target.result,
                    width: img.width,
                    height: img.height
                });
            };
        };
        
        reader.onerror = function(event) {
            reject(event.target.error);
        };
        
        reader.readAsDataURL(file);
    });
}

// Usage
let fileInput = document.getElementById('imageInput');
fileInput.addEventListener('change', async function(event) {
    let file = event.target.files[0];
    if (file) {
        try {
            let imageData = await readImageFile(file);
            document.getElementById('preview').src = imageData.dataURL;
            console.log('Image size:', imageData.width, 'x', imageData.height);
        } catch (error) {
            console.error('Error:', error);
        }
    }
});
```

### Reading JSON Files

```javascript
function readJSONFile(file) {
    return new Promise((resolve, reject) => {
        let reader = new FileReader();
        
        reader.onload = function(event) {
            try {
                let json = JSON.parse(event.target.result);
                resolve(json);
            } catch (error) {
                reject(new Error('Invalid JSON'));
            }
        };
        
        reader.onerror = function(event) {
            reject(event.target.error);
        };
        
        reader.readAsText(file);
    });
}
```

### Reading Binary Files

```javascript
function readBinaryFile(file) {
    return new Promise((resolve, reject) => {
        let reader = new FileReader();
        
        reader.onload = function(event) {
            resolve(event.target.result);  // ArrayBuffer
        };
        
        reader.onerror = function(event) {
            reject(event.target.error);
        };
        
        reader.readAsArrayBuffer(file);
    });
}
```

---

## File Object Properties

### Accessing File Information

```javascript
let fileInput = document.getElementById('fileInput');

fileInput.addEventListener('change', function(event) {
    let file = event.target.files[0];
    
    if (file) {
        console.log('File name:', file.name);
        console.log('File size:', file.size, 'bytes');
        console.log('File type:', file.type);
        console.log('Last modified:', new Date(file.lastModified));
    }
});
```

### File Validation

```javascript
function validateFile(file, options = {}) {
    let errors = [];
    
    // Check file type
    if (options.allowedTypes && !options.allowedTypes.includes(file.type)) {
        errors.push('File type not allowed');
    }
    
    // Check file size
    if (options.maxSize && file.size > options.maxSize) {
        errors.push('File too large');
    }
    
    // Check file name
    if (options.allowedExtensions) {
        let extension = file.name.split('.').pop().toLowerCase();
        if (!options.allowedExtensions.includes(extension)) {
            errors.push('File extension not allowed');
        }
    }
    
    return {
        valid: errors.length === 0,
        errors: errors
    };
}

// Usage
let fileInput = document.getElementById('fileInput');
fileInput.addEventListener('change', function(event) {
    let file = event.target.files[0];
    if (file) {
        let validation = validateFile(file, {
            allowedTypes: ['image/jpeg', 'image/png'],
            maxSize: 5 * 1024 * 1024,  // 5MB
            allowedExtensions: ['jpg', 'jpeg', 'png']
        });
        
        if (!validation.valid) {
            console.error('Validation errors:', validation.errors);
        }
    }
});
```

---

## Drag and Drop API

### Basic Drag and Drop

```javascript
let dropZone = document.getElementById('dropZone');

// Prevent default drag behaviors
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

// Highlight drop zone
['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    dropZone.classList.add('drag-over');
}

function unhighlight(e) {
    dropZone.classList.remove('drag-over');
}

// Handle drop
dropZone.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    let dt = e.dataTransfer;
    let files = dt.files;
    
    handleFiles(files);
}
```

### Handling Dropped Files

```javascript
function handleFiles(files) {
    [...files].forEach(file => {
        processFile(file);
    });
}

function processFile(file) {
    if (file.type.startsWith('image/')) {
        readImageFile(file).then(imageData => {
            displayImage(imageData.dataURL);
        });
    } else if (file.type === 'text/plain') {
        readTextFile(file).then(content => {
            displayText(content);
        });
    }
}
```

### Drag Events

```javascript
let dropZone = document.getElementById('dropZone');

// dragenter: Item enters drop zone
dropZone.addEventListener('dragenter', function(e) {
    console.log('Drag enter');
});

// dragover: Item over drop zone
dropZone.addEventListener('dragover', function(e) {
    console.log('Drag over');
    e.preventDefault();  // Allow drop
});

// dragleave: Item leaves drop zone
dropZone.addEventListener('dragleave', function(e) {
    console.log('Drag leave');
});

// drop: Item dropped
dropZone.addEventListener('drop', function(e) {
    console.log('Drop');
    let files = e.dataTransfer.files;
    handleFiles(files);
});
```

---

## Practical Examples

### Example 1: Image Preview

```javascript
let fileInput = document.getElementById('imageInput');
let preview = document.getElementById('preview');

fileInput.addEventListener('change', function(event) {
    let file = event.target.files[0];
    
    if (file && file.type.startsWith('image/')) {
        let reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        
        reader.readAsDataURL(file);
    }
});
```

### Example 2: File Upload with Progress

```javascript
function uploadFile(file) {
    return new Promise((resolve, reject) => {
        let formData = new FormData();
        formData.append('file', file);
        
        let xhr = new XMLHttpRequest();
        
        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                let percentComplete = (e.loaded / e.total) * 100;
                updateProgress(percentComplete);
            }
        };
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                resolve(xhr.response);
            } else {
                reject(new Error('Upload failed'));
            }
        };
        
        xhr.onerror = function() {
            reject(new Error('Upload error'));
        };
        
        xhr.open('POST', '/upload');
        xhr.send(formData);
    });
}

function updateProgress(percent) {
    document.getElementById('progress').style.width = percent + '%';
}
```

### Example 3: Multiple File Upload

```javascript
let fileInput = document.getElementById('fileInput');
fileInput.multiple = true;  // Allow multiple files

fileInput.addEventListener('change', function(event) {
    let files = Array.from(event.target.files);
    
    files.forEach((file, index) => {
        uploadFile(file).then(response => {
            console.log(`File ${index + 1} uploaded:`, response);
        }).catch(error => {
            console.error(`File ${index + 1} error:`, error);
        });
    });
});
```

### Example 4: Complete File Handler

```javascript
class FileHandler {
    constructor(options = {}) {
        this.options = {
            maxSize: options.maxSize || 10 * 1024 * 1024,  // 10MB
            allowedTypes: options.allowedTypes || [],
            onProgress: options.onProgress || null,
            onComplete: options.onComplete || null,
            onError: options.onError || null
        };
    }
    
    validate(file) {
        if (this.options.allowedTypes.length > 0) {
            if (!this.options.allowedTypes.includes(file.type)) {
                throw new Error('File type not allowed');
            }
        }
        
        if (file.size > this.options.maxSize) {
            throw new Error('File too large');
        }
        
        return true;
    }
    
    readAsText(file) {
        return new Promise((resolve, reject) => {
            this.validate(file);
            
            let reader = new FileReader();
            
            reader.onprogress = (e) => {
                if (this.options.onProgress) {
                    this.options.onProgress(e.loaded / e.total);
                }
            };
            
            reader.onload = (e) => {
                if (this.options.onComplete) {
                    this.options.onComplete(e.target.result);
                }
                resolve(e.target.result);
            };
            
            reader.onerror = (e) => {
                if (this.options.onError) {
                    this.options.onError(e.target.error);
                }
                reject(e.target.error);
            };
            
            reader.readAsText(file);
        });
    }
    
    readAsDataURL(file) {
        return new Promise((resolve, reject) => {
            this.validate(file);
            
            let reader = new FileReader();
            
            reader.onload = (e) => {
                resolve(e.target.result);
            };
            
            reader.onerror = (e) => {
                reject(e.target.error);
            };
            
            reader.readAsDataURL(file);
        });
    }
}

// Usage
let handler = new FileHandler({
    maxSize: 5 * 1024 * 1024,
    allowedTypes: ['image/jpeg', 'image/png'],
    onProgress: (percent) => console.log('Progress:', percent),
    onComplete: (result) => console.log('Complete:', result)
});
```

---

## Practice Exercise

### Exercise: File Handling

**Objective**: Practice using FileReader API and drag and drop to handle files.

**Instructions**:

1. Create an HTML file with file input and drop zone
2. Create a JavaScript file for file handling
3. Practice:
   - Reading different file types
   - Image preview
   - File validation
   - Drag and drop
   - Progress tracking

**Example Solution**:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File APIs Practice</title>
    <style>
        .container {
            max-width: 800px;
            margin: 20px;
        }
        .drop-zone {
            border: 2px dashed #ccc;
            border-radius: 5px;
            padding: 40px;
            text-align: center;
            margin: 20px 0;
            transition: border-color 0.3s;
        }
        .drop-zone.drag-over {
            border-color: #007bff;
            background-color: #f0f8ff;
        }
        .preview {
            max-width: 100%;
            margin-top: 20px;
        }
        .file-info {
            margin-top: 20px;
            padding: 15px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }
        .progress {
            width: 100%;
            height: 20px;
            background-color: #f0f0f0;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 10px;
        }
        .progress-bar {
            height: 100%;
            background-color: #007bff;
            transition: width 0.3s;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>File APIs Practice</h1>
        
        <h2>File Input</h2>
        <input type="file" id="fileInput" accept="image/*,text/*">
        
        <h2>Drag and Drop Zone</h2>
        <div id="dropZone" class="drop-zone">
            <p>Drag and drop files here or click to select</p>
        </div>
        
        <div id="fileInfo" class="file-info"></div>
        <div id="preview"></div>
        <div id="progress" class="progress" style="display: none;">
            <div id="progressBar" class="progress-bar" style="width: 0%"></div>
        </div>
        
        <div id="output"></div>
    </div>
    
    <script src="file-apis-practice.js"></script>
</body>
</html>
```

```javascript
// file-apis-practice.js
console.log("=== File APIs Practice ===");

let fileInput = document.getElementById('fileInput');
let dropZone = document.getElementById('dropZone');
let fileInfo = document.getElementById('fileInfo');
let preview = document.getElementById('preview');
let progress = document.getElementById('progress');
let progressBar = document.getElementById('progressBar');
let output = document.getElementById('output');

function log(message) {
    console.log(message);
    output.innerHTML += '<p>' + message + '</p>';
}

console.log("\n=== FileReader Basics ===");

fileInput.addEventListener('change', function(event) {
    let file = event.target.files[0];
    if (file) {
        handleFile(file);
    }
});

function handleFile(file) {
    console.log('File selected:', file.name);
    displayFileInfo(file);
    
    if (file.type.startsWith('image/')) {
        readImageFile(file);
    } else if (file.type === 'text/plain' || file.type === 'text/csv') {
        readTextFile(file);
    } else {
        log('File type not supported for preview');
    }
}

function displayFileInfo(file) {
    let info = `
        <h3>File Information</h3>
        <p><strong>Name:</strong> ${file.name}</p>
        <p><strong>Size:</strong> ${(file.size / 1024).toFixed(2)} KB</p>
        <p><strong>Type:</strong> ${file.type || 'Unknown'}</p>
        <p><strong>Last Modified:</strong> ${new Date(file.lastModified).toLocaleString()}</p>
    `;
    fileInfo.innerHTML = info;
}
console.log();

console.log("=== Reading Text Files ===");

function readTextFile(file) {
    let reader = new FileReader();
    
    reader.onloadstart = function() {
        log('Reading text file...');
        progress.style.display = 'block';
    };
    
    reader.onprogress = function(event) {
        if (event.lengthComputable) {
            let percent = (event.loaded / event.total) * 100;
            progressBar.style.width = percent + '%';
            console.log('Progress:', percent.toFixed(2) + '%');
        }
    };
    
    reader.onload = function(event) {
        log('Text file loaded');
        progress.style.display = 'none';
        progressBar.style.width = '0%';
        
        let content = event.target.result;
        preview.innerHTML = '<pre>' + content.substring(0, 1000) + (content.length > 1000 ? '...' : '') + '</pre>';
        console.log('File content (first 100 chars):', content.substring(0, 100));
    };
    
    reader.onerror = function(event) {
        log('Error reading file: ' + event.target.error);
        progress.style.display = 'none';
    };
    
    reader.readAsText(file);
}
console.log();

console.log("=== Reading Image Files ===");

function readImageFile(file) {
    let reader = new FileReader();
    
    reader.onload = function(event) {
        log('Image file loaded');
        let img = document.createElement('img');
        img.src = event.target.result;
        img.className = 'preview';
        preview.innerHTML = '';
        preview.appendChild(img);
        
        // Get image dimensions
        let image = new Image();
        image.src = event.target.result;
        image.onload = function() {
            console.log('Image dimensions:', image.width, 'x', image.height);
            log('Image dimensions: ' + image.width + ' x ' + image.height);
        };
    };
    
    reader.onerror = function(event) {
        log('Error reading image: ' + event.target.error);
    };
    
    reader.readAsDataURL(file);
}
console.log();

console.log("=== Drag and Drop ===");

// Prevent default drag behaviors
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, preventDefaults, false);
    document.body.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

// Highlight drop zone
['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, function() {
        dropZone.classList.add('drag-over');
    }, false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, function() {
        dropZone.classList.remove('drag-over');
    }, false);
});

// Handle drop
dropZone.addEventListener('drop', function(e) {
    let dt = e.dataTransfer;
    let files = dt.files;
    
    log('Files dropped: ' + files.length);
    
    handleFiles(files);
}, false);

// Click to select
dropZone.addEventListener('click', function() {
    fileInput.click();
});

function handleFiles(files) {
    [...files].forEach((file, index) => {
        log(`Processing file ${index + 1}: ${file.name}`);
        handleFile(file);
    });
}
console.log();

console.log("=== File Validation ===");

function validateFile(file) {
    let errors = [];
    
    // Check file size (max 10MB)
    const maxSize = 10 * 1024 * 1024;
    if (file.size > maxSize) {
        errors.push('File too large (max 10MB)');
    }
    
    // Check file type
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'text/plain', 'text/csv'];
    if (allowedTypes.length > 0 && !allowedTypes.includes(file.type)) {
        errors.push('File type not allowed');
    }
    
    return {
        valid: errors.length === 0,
        errors: errors
    };
}

fileInput.addEventListener('change', function(event) {
    let file = event.target.files[0];
    if (file) {
        let validation = validateFile(file);
        if (!validation.valid) {
            log('Validation errors: ' + validation.errors.join(', '));
            fileInput.value = '';  // Clear input
        }
    }
});
console.log();

console.log("=== Reading JSON Files ===");

function readJSONFile(file) {
    return new Promise((resolve, reject) => {
        let reader = new FileReader();
        
        reader.onload = function(event) {
            try {
                let json = JSON.parse(event.target.result);
                resolve(json);
            } catch (error) {
                reject(new Error('Invalid JSON: ' + error.message));
            }
        };
        
        reader.onerror = function(event) {
            reject(event.target.error);
        };
        
        reader.readAsText(file);
    });
}

// Test with JSON file
fileInput.accept = 'application/json,text/json';
console.log();

console.log("=== Multiple File Reading ===");

function readMultipleFiles(files) {
    let promises = Array.from(files).map(file => {
        return new Promise((resolve, reject) => {
            let reader = new FileReader();
            
            reader.onload = function(event) {
                resolve({
                    name: file.name,
                    content: event.target.result,
                    type: file.type
                });
            };
            
            reader.onerror = function(event) {
                reject(event.target.error);
            };
            
            if (file.type.startsWith('image/')) {
                reader.readAsDataURL(file);
            } else {
                reader.readAsText(file);
            }
        });
    });
    
    return Promise.all(promises);
}

// Allow multiple files
fileInput.multiple = true;
console.log();

console.log("=== File Handler Class ===");

class FileHandler {
    constructor(options = {}) {
        this.options = {
            maxSize: options.maxSize || 10 * 1024 * 1024,
            allowedTypes: options.allowedTypes || [],
            onProgress: options.onProgress || null
        };
    }
    
    validate(file) {
        if (this.options.maxSize && file.size > this.options.maxSize) {
            throw new Error('File too large');
        }
        
        if (this.options.allowedTypes.length > 0) {
            if (!this.options.allowedTypes.includes(file.type)) {
                throw new Error('File type not allowed');
            }
        }
        
        return true;
    }
    
    readAsText(file) {
        return new Promise((resolve, reject) => {
            try {
                this.validate(file);
            } catch (error) {
                reject(error);
                return;
            }
            
            let reader = new FileReader();
            
            reader.onprogress = (e) => {
                if (this.options.onProgress && e.lengthComputable) {
                    this.options.onProgress(e.loaded / e.total);
                }
            };
            
            reader.onload = (e) => resolve(e.target.result);
            reader.onerror = (e) => reject(e.target.error);
            
            reader.readAsText(file);
        });
    }
    
    readAsDataURL(file) {
        return new Promise((resolve, reject) => {
            try {
                this.validate(file);
            } catch (error) {
                reject(error);
                return;
            }
            
            let reader = new FileReader();
            
            reader.onload = (e) => resolve(e.target.result);
            reader.onerror = (e) => reject(e.target.error);
            
            reader.readAsDataURL(file);
        });
    }
}

// Demonstrate handler
let handler = new FileHandler({
    maxSize: 5 * 1024 * 1024,
    allowedTypes: ['image/jpeg', 'image/png'],
    onProgress: (percent) => {
        console.log('Progress:', (percent * 100).toFixed(2) + '%');
    }
});
console.log();
```

**Expected Output** (in browser console):
```
=== File APIs Practice ===

=== FileReader Basics ===
[On file select]
File selected: [filename]
File Information displayed

=== Reading Text Files ===
Reading text file...
Progress: [percent]%
Text file loaded
File content (first 100 chars): [content]

=== Reading Image Files ===
[On image select]
Image file loaded
Image dimensions: [width] x [height]

=== Drag and Drop ===
[On drag]
[On drop]
Files dropped: [count]
Processing file 1: [filename]

=== File Validation ===
[On invalid file]
Validation errors: [errors]

=== File Handler Class ===
[On use]
Progress: [percent]%
```

**Challenge (Optional)**:
- Build a complete file upload system
- Create an image editor
- Build a file manager
- Create a drag-and-drop interface

---

## Common Mistakes

### 1. Not Checking File Exists

```javascript
// ⚠️ Problem: File might not exist
let file = fileInput.files[0];
let reader = new FileReader();
reader.readAsText(file);  // Error if no file

// ✅ Solution: Check first
if (fileInput.files.length > 0) {
    let file = fileInput.files[0];
    reader.readAsText(file);
}
```

### 2. Not Handling Errors

```javascript
// ⚠️ Problem: No error handling
reader.readAsText(file);

// ✅ Solution: Handle errors
reader.onerror = function(event) {
    console.error('Error:', event.target.error);
};
```

### 3. Not Preventing Default Drag Behavior

```javascript
// ⚠️ Problem: Default behavior prevents drop
dropZone.addEventListener('drop', handleDrop);

// ✅ Solution: Prevent default
dropZone.addEventListener('dragover', function(e) {
    e.preventDefault();
});
```

### 4. Not Validating File Type

```javascript
// ⚠️ Problem: Accepts any file
reader.readAsDataURL(file);

// ✅ Solution: Validate first
if (file.type.startsWith('image/')) {
    reader.readAsDataURL(file);
}
```

---

## Key Takeaways

1. **FileReader API**: Read files from user input
2. **Reading Methods**: readAsText, readAsDataURL, readAsArrayBuffer
3. **File Events**: onload, onerror, onprogress
4. **Drag and Drop**: Handle drag events, prevent defaults
5. **File Validation**: Check type, size, extension
6. **Best Practice**: Always validate, handle errors, show progress
7. **Use Cases**: File uploads, image preview, file processing

---

## Quiz: File APIs

Test your understanding with these questions:

1. **FileReader is:**
   - A) Synchronous
   - B) Asynchronous
   - C) Both
   - D) Neither

2. **readAsDataURL returns:**
   - A) Text
   - B) Base64 string
   - C) ArrayBuffer
   - D) Binary

3. **Drag and drop requires:**
   - A) preventDefault on dragover
   - B) preventDefault on drop
   - C) Both
   - D) Neither

4. **file.type returns:**
   - A) File name
   - B) MIME type
   - C) File size
   - D) Nothing

5. **onprogress fires:**
   - A) Once
   - B) Multiple times
   - C) Never
   - D) On error

6. **Multiple files:**
   - A) Not supported
   - B) Use multiple attribute
   - C) Use array
   - D) Not possible

7. **File validation should check:**
   - A) Type only
   - B) Size only
   - C) Both
   - D) Neither

**Answers**:
1. B) Asynchronous
2. B) Base64 string
3. C) Both
4. B) MIME type
5. B) Multiple times
6. B) Use multiple attribute
7. C) Both

---

## Next Steps

Congratulations! You've learned File APIs. You now know:
- How to read files
- How to implement drag and drop
- How to validate files
- How to handle different file types

**What's Next?**
- Lesson 17.3: Canvas and WebGL
- Learn Canvas API
- Draw on canvas
- Create animations

---

## Additional Resources

- **MDN: FileReader API**: [developer.mozilla.org/en-US/docs/Web/API/FileReader](https://developer.mozilla.org/en-US/docs/Web/API/FileReader)
- **MDN: Drag and Drop API**: [developer.mozilla.org/en-US/docs/Web/API/HTML_Drag_and_Drop_API](https://developer.mozilla.org/en-US/docs/Web/API/HTML_Drag_and_Drop_API)
- **MDN: File API**: [developer.mozilla.org/en-US/docs/Web/API/File](https://developer.mozilla.org/en-US/docs/Web/API/File)

---

*Lesson completed! You're ready to move on to the next lesson.*

