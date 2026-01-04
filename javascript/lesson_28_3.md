# Lesson 28.3: File System Operations

## Learning Objectives

By the end of this lesson, you will be able to:
- Read files synchronously and asynchronously
- Write files synchronously and asynchronously
- Work with directories
- Understand streams
- Handle file operations
- Process file data
- Build file-based applications

---

## Introduction to File System

The `fs` module provides an API for interacting with the file system. It supports both synchronous and asynchronous operations.

### File System Operations

- **Reading Files**: Read file contents
- **Writing Files**: Write data to files
- **Directory Operations**: Create, read, delete directories
- **File Metadata**: Get file information
- **Watching Files**: Monitor file changes
- **Streams**: Handle large files efficiently

---

## Reading Files

### Synchronous Reading

```javascript
const fs = require('fs');

// Read file synchronously
try {
    const data = fs.readFileSync('file.txt', 'utf8');
    console.log(data);
} catch (error) {
    console.error('Error reading file:', error);
}

// Read binary file
const buffer = fs.readFileSync('image.jpg');
console.log(buffer);
```

### Asynchronous Reading

```javascript
const fs = require('fs');

// Read file asynchronously (callback)
fs.readFile('file.txt', 'utf8', (err, data) => {
    if (err) {
        console.error('Error reading file:', err);
        return;
    }
    console.log(data);
});

// Read file with promises
const fs = require('fs').promises;

async function readFile() {
    try {
        const data = await fs.readFile('file.txt', 'utf8');
        console.log(data);
    } catch (error) {
        console.error('Error reading file:', error);
    }
}

readFile();
```

### Reading Options

```javascript
const fs = require('fs');

// Read with options
fs.readFile('file.txt', {
    encoding: 'utf8',
    flag: 'r'  // read mode
}, (err, data) => {
    if (err) throw err;
    console.log(data);
});

// Flags:
// 'r' - Open file for reading
// 'r+' - Open file for reading and writing
// 'w' - Open file for writing (truncate)
// 'w+' - Open file for reading and writing (truncate)
// 'a' - Open file for appending
// 'a+' - Open file for reading and appending
```

---

## Writing Files

### Synchronous Writing

```javascript
const fs = require('fs');

// Write file synchronously
try {
    fs.writeFileSync('output.txt', 'Hello, World!', 'utf8');
    console.log('File written successfully');
} catch (error) {
    console.error('Error writing file:', error);
}

// Append to file
fs.appendFileSync('output.txt', '\nNew line', 'utf8');
```

### Asynchronous Writing

```javascript
const fs = require('fs');

// Write file asynchronously (callback)
fs.writeFile('output.txt', 'Hello, World!', 'utf8', (err) => {
    if (err) {
        console.error('Error writing file:', err);
        return;
    }
    console.log('File written successfully');
});

// Write with promises
const fs = require('fs').promises;

async function writeFile() {
    try {
        await fs.writeFile('output.txt', 'Hello, World!', 'utf8');
        console.log('File written successfully');
    } catch (error) {
        console.error('Error writing file:', error);
    }
}

writeFile();
```

### Writing Options

```javascript
const fs = require('fs');

// Write with options
fs.writeFile('output.txt', 'Hello, World!', {
    encoding: 'utf8',
    mode: 0o666,  // File permissions
    flag: 'w'     // Write mode
}, (err) => {
    if (err) throw err;
    console.log('File written');
});
```

---

## Working with Directories

### Creating Directories

```javascript
const fs = require('fs');
const path = require('path');

// Create directory synchronously
try {
    fs.mkdirSync('new-directory');
    console.log('Directory created');
} catch (error) {
    console.error('Error creating directory:', error);
}

// Create directory asynchronously
fs.mkdir('new-directory', (err) => {
    if (err) {
        console.error('Error creating directory:', err);
        return;
    }
    console.log('Directory created');
});

// Create nested directories
fs.mkdirSync('parent/child/grandchild', { recursive: true });
```

### Reading Directories

```javascript
const fs = require('fs');

// Read directory synchronously
try {
    const files = fs.readdirSync('.');
    console.log('Files:', files);
} catch (error) {
    console.error('Error reading directory:', error);
}

// Read directory asynchronously
fs.readdir('.', (err, files) => {
    if (err) {
        console.error('Error reading directory:', err);
        return;
    }
    console.log('Files:', files);
});

// Read with file types
fs.readdir('.', { withFileTypes: true }, (err, files) => {
    if (err) throw err;
    files.forEach(file => {
        console.log(file.name, file.isFile() ? 'file' : 'directory');
    });
});
```

### Removing Directories

```javascript
const fs = require('fs');

// Remove directory synchronously
try {
    fs.rmdirSync('directory');
    console.log('Directory removed');
} catch (error) {
    console.error('Error removing directory:', error);
}

// Remove directory asynchronously
fs.rmdir('directory', (err) => {
    if (err) {
        console.error('Error removing directory:', err);
        return;
    }
    console.log('Directory removed');
});

// Remove directory recursively (Node.js 14.14.0+)
fs.rmSync('directory', { recursive: true, force: true });
```

### File and Directory Information

```javascript
const fs = require('fs');

// Get file stats synchronously
try {
    const stats = fs.statSync('file.txt');
    console.log('Is file:', stats.isFile());
    console.log('Is directory:', stats.isDirectory());
    console.log('Size:', stats.size);
    console.log('Created:', stats.birthtime);
    console.log('Modified:', stats.mtime);
} catch (error) {
    console.error('Error getting stats:', error);
}

// Get file stats asynchronously
fs.stat('file.txt', (err, stats) => {
    if (err) {
        console.error('Error getting stats:', err);
        return;
    }
    console.log('Stats:', stats);
});
```

---

## Streams

### What are Streams?

Streams are objects that let you read data from a source or write data to a destination in a continuous fashion. They're useful for handling large files.

### Reading Streams

```javascript
const fs = require('fs');

// Create read stream
const readStream = fs.createReadStream('large-file.txt', 'utf8');

// Read data in chunks
readStream.on('data', (chunk) => {
    console.log('Chunk received:', chunk.length);
    // Process chunk
});

// Handle end
readStream.on('end', () => {
    console.log('File read complete');
});

// Handle errors
readStream.on('error', (err) => {
    console.error('Error reading stream:', err);
});
```

### Writing Streams

```javascript
const fs = require('fs');

// Create write stream
const writeStream = fs.createWriteStream('output.txt', 'utf8');

// Write data
writeStream.write('Hello, ');
writeStream.write('World!');
writeStream.end();

// Handle finish
writeStream.on('finish', () => {
    console.log('File write complete');
});

// Handle errors
writeStream.on('error', (err) => {
    console.error('Error writing stream:', err);
});
```

### Piping Streams

```javascript
const fs = require('fs');

// Pipe read stream to write stream
const readStream = fs.createReadStream('input.txt');
const writeStream = fs.createWriteStream('output.txt');

readStream.pipe(writeStream);

// Handle completion
writeStream.on('finish', () => {
    console.log('File copied');
});

// Handle errors
readStream.on('error', (err) => {
    console.error('Read error:', err);
});

writeStream.on('error', (err) => {
    console.error('Write error:', err);
});
```

### Transform Streams

```javascript
const fs = require('fs');
const { Transform } = require('stream');

// Create transform stream
const upperCaseTransform = new Transform({
    transform(chunk, encoding, callback) {
        this.push(chunk.toString().toUpperCase());
        callback();
    }
});

// Use transform stream
const readStream = fs.createReadStream('input.txt');
const writeStream = fs.createWriteStream('output.txt');

readStream
    .pipe(upperCaseTransform)
    .pipe(writeStream);
```

---

## Practical Examples

### Example 1: File Copy

```javascript
const fs = require('fs');
const path = require('path');

function copyFile(source, destination) {
    return new Promise((resolve, reject) => {
        const readStream = fs.createReadStream(source);
        const writeStream = fs.createWriteStream(destination);
        
        readStream.pipe(writeStream);
        
        writeStream.on('finish', () => {
            resolve();
        });
        
        readStream.on('error', reject);
        writeStream.on('error', reject);
    });
}

// Usage
copyFile('source.txt', 'destination.txt')
    .then(() => console.log('File copied'))
    .catch(err => console.error('Error:', err));
```

### Example 2: Directory Walker

```javascript
const fs = require('fs');
const path = require('path');

function walkDirectory(dir, callback) {
    const files = fs.readdirSync(dir);
    
    files.forEach(file => {
        const filePath = path.join(dir, file);
        const stats = fs.statSync(filePath);
        
        if (stats.isDirectory()) {
            walkDirectory(filePath, callback);
        } else {
            callback(filePath);
        }
    });
}

// Usage
walkDirectory('.', (filePath) => {
    console.log('File:', filePath);
});
```

### Example 3: File Watcher

```javascript
const fs = require('fs');

// Watch file
fs.watchFile('file.txt', (curr, prev) => {
    console.log('File changed');
    console.log('Current mtime:', curr.mtime);
    console.log('Previous mtime:', prev.mtime);
});

// Watch directory
fs.watch('.', (eventType, filename) => {
    console.log('Event type:', eventType);
    console.log('Filename:', filename);
});
```

---

## Practice Exercise

### Exercise: File Operations

**Objective**: Practice reading files, writing files, working with directories, and using streams.

**Instructions**:

1. Create file operations
2. Work with directories
3. Use streams
4. Practice:
   - Reading and writing files
   - Creating and reading directories
   - Using streams
   - Processing file data

**Example Solution**:

```javascript
// src/fileOperations.js
const fs = require('fs');
const path = require('path');

// File operations class
class FileOperations {
    // Read file
    static readFile(filePath) {
        try {
            return fs.readFileSync(filePath, 'utf8');
        } catch (error) {
            throw new Error(`Error reading file: ${error.message}`);
        }
    }
    
    // Write file
    static writeFile(filePath, data) {
        try {
            fs.writeFileSync(filePath, data, 'utf8');
            return true;
        } catch (error) {
            throw new Error(`Error writing file: ${error.message}`);
        }
    }
    
    // Append to file
    static appendFile(filePath, data) {
        try {
            fs.appendFileSync(filePath, data, 'utf8');
            return true;
        } catch (error) {
            throw new Error(`Error appending to file: ${error.message}`);
        }
    }
    
    // Check if file exists
    static fileExists(filePath) {
        return fs.existsSync(filePath);
    }
    
    // Get file stats
    static getFileStats(filePath) {
        try {
            const stats = fs.statSync(filePath);
            return {
                size: stats.size,
                created: stats.birthtime,
                modified: stats.mtime,
                isFile: stats.isFile(),
                isDirectory: stats.isDirectory()
            };
        } catch (error) {
            throw new Error(`Error getting file stats: ${error.message}`);
        }
    }
    
    // Create directory
    static createDirectory(dirPath) {
        try {
            if (!fs.existsSync(dirPath)) {
                fs.mkdirSync(dirPath, { recursive: true });
                return true;
            }
            return false;
        } catch (error) {
            throw new Error(`Error creating directory: ${error.message}`);
        }
    }
    
    // Read directory
    static readDirectory(dirPath) {
        try {
            return fs.readdirSync(dirPath);
        } catch (error) {
            throw new Error(`Error reading directory: ${error.message}`);
        }
    }
    
    // Copy file using streams
    static copyFile(source, destination) {
        return new Promise((resolve, reject) => {
            const readStream = fs.createReadStream(source);
            const writeStream = fs.createWriteStream(destination);
            
            readStream.pipe(writeStream);
            
            writeStream.on('finish', () => {
                resolve();
            });
            
            readStream.on('error', reject);
            writeStream.on('error', reject);
        });
    }
    
    // Read file line by line
    static readFileLines(filePath) {
        const content = this.readFile(filePath);
        return content.split('\n').filter(line => line.trim() !== '');
    }
    
    // Write JSON file
    static writeJSON(filePath, data) {
        try {
            const json = JSON.stringify(data, null, 2);
            this.writeFile(filePath, json);
            return true;
        } catch (error) {
            throw new Error(`Error writing JSON: ${error.message}`);
        }
    }
    
    // Read JSON file
    static readJSON(filePath) {
        try {
            const content = this.readFile(filePath);
            return JSON.parse(content);
        } catch (error) {
            throw new Error(`Error reading JSON: ${error.message}`);
        }
    }
}

module.exports = FileOperations;
```

```javascript
// src/directoryWalker.js
const fs = require('fs');
const path = require('path');

class DirectoryWalker {
    static walk(dir, callback, fileList = []) {
        const files = fs.readdirSync(dir);
        
        files.forEach(file => {
            const filePath = path.join(dir, file);
            const stats = fs.statSync(filePath);
            
            if (stats.isDirectory()) {
                fileList = this.walk(filePath, callback, fileList);
            } else {
                fileList.push(filePath);
                if (callback) {
                    callback(filePath, stats);
                }
            }
        });
        
        return fileList;
    }
    
    static findFiles(dir, extension) {
        const files = [];
        this.walk(dir, (filePath, stats) => {
            if (path.extname(filePath) === extension) {
                files.push(filePath);
            }
        });
        return files;
    }
    
    static getDirectorySize(dir) {
        let totalSize = 0;
        this.walk(dir, (filePath, stats) => {
            totalSize += stats.size;
        });
        return totalSize;
    }
}

module.exports = DirectoryWalker;
```

```javascript
// src/streamProcessor.js
const fs = require('fs');
const { Transform } = require('stream');

class StreamProcessor {
    // Process file with transform
    static processFile(inputPath, outputPath, transformFn) {
        return new Promise((resolve, reject) => {
            const readStream = fs.createReadStream(inputPath, 'utf8');
            const writeStream = fs.createWriteStream(outputPath, 'utf8');
            
            const transform = new Transform({
                transform(chunk, encoding, callback) {
                    const result = transformFn(chunk.toString());
                    this.push(result);
                    callback();
                }
            });
            
            readStream
                .pipe(transform)
                .pipe(writeStream);
            
            writeStream.on('finish', resolve);
            readStream.on('error', reject);
            writeStream.on('error', reject);
        });
    }
    
    // Count lines in file
    static countLines(filePath) {
        return new Promise((resolve, reject) => {
            let lineCount = 0;
            const readStream = fs.createReadStream(filePath, 'utf8');
            
            readStream.on('data', (chunk) => {
                lineCount += (chunk.match(/\n/g) || []).length;
            });
            
            readStream.on('end', () => {
                resolve(lineCount);
            });
            
            readStream.on('error', reject);
        });
    }
}

module.exports = StreamProcessor;
```

```javascript
// src/app.js
// Main application
const FileOperations = require('./fileOperations');
const DirectoryWalker = require('./directoryWalker');
const StreamProcessor = require('./streamProcessor');

async function main() {
    console.log('=== File Operations ===\n');
    
    // Create test directory
    const testDir = './test-data';
    FileOperations.createDirectory(testDir);
    console.log('Created directory:', testDir);
    
    // Write test file
    const testFile = path.join(testDir, 'test.txt');
    FileOperations.writeFile(testFile, 'Hello, World!\nLine 2\nLine 3');
    console.log('Written file:', testFile);
    
    // Read file
    const content = FileOperations.readFile(testFile);
    console.log('File content:', content);
    
    // Append to file
    FileOperations.appendFile(testFile, '\nLine 4');
    console.log('Appended to file');
    
    // Read lines
    const lines = FileOperations.readFileLines(testFile);
    console.log('Lines:', lines);
    
    // File stats
    const stats = FileOperations.getFileStats(testFile);
    console.log('File stats:', stats);
    
    // Write JSON
    const jsonFile = path.join(testDir, 'data.json');
    const data = { name: 'Alice', age: 30, city: 'New York' };
    FileOperations.writeJSON(jsonFile, data);
    console.log('Written JSON file');
    
    // Read JSON
    const jsonData = FileOperations.readJSON(jsonFile);
    console.log('JSON data:', jsonData);
    
    // Copy file
    const copiedFile = path.join(testDir, 'test-copy.txt');
    await FileOperations.copyFile(testFile, copiedFile);
    console.log('File copied');
    
    // Count lines using stream
    const lineCount = await StreamProcessor.countLines(testFile);
    console.log('Line count:', lineCount);
    
    // Process file with transform
    const processedFile = path.join(testDir, 'processed.txt');
    await StreamProcessor.processFile(
        testFile,
        processedFile,
        (content) => content.toUpperCase()
    );
    console.log('File processed');
    
    // Walk directory
    console.log('\n=== Directory Walker ===');
    const allFiles = DirectoryWalker.walk(testDir);
    console.log('All files:', allFiles);
    
    // Find specific files
    const txtFiles = DirectoryWalker.findFiles(testDir, '.txt');
    console.log('TXT files:', txtFiles);
    
    // Get directory size
    const dirSize = DirectoryWalker.getDirectorySize(testDir);
    console.log('Directory size:', dirSize, 'bytes');
}

// Run application
const path = require('path');
main().catch(console.error);
```

```json
// package.json
{
  "name": "file-operations-practice",
  "version": "1.0.0",
  "description": "File system operations practice",
  "main": "src/app.js",
  "scripts": {
    "start": "node src/app.js"
  },
  "keywords": ["nodejs", "filesystem"],
  "author": "",
  "license": "ISC"
}
```

**Expected Output**:

```bash
node src/app.js

=== File Operations ===

Created directory: ./test-data
Written file: ./test-data/test.txt
File content: Hello, World!
Line 2
Line 3
Appended to file
Lines: [ 'Hello, World!', 'Line 2', 'Line 3', 'Line 4' ]
File stats: { size: 35, created: ..., modified: ..., isFile: true, isDirectory: false }
Written JSON file
JSON data: { name: 'Alice', age: 30, city: 'New York' }
File copied
Line count: 4
File processed

=== Directory Walker ===
All files: [ './test-data/test.txt', ... ]
TXT files: [ './test-data/test.txt', ... ]
Directory size: 1234 bytes
```

**Challenge (Optional)**:
- Build a file manager
- Create a log file processor
- Build a backup utility
- Create a file search tool

---

## Common Mistakes

### 1. Blocking Operations

```javascript
// ❌ Bad: Blocking operation in async context
const data = fs.readFileSync('large-file.txt');

// ✅ Good: Use async or streams
fs.readFile('large-file.txt', (err, data) => {
    // Handle data
});
```

### 2. Not Handling Errors

```javascript
// ❌ Bad: No error handling
const data = fs.readFileSync('file.txt');

// ✅ Good: Handle errors
try {
    const data = fs.readFileSync('file.txt');
} catch (error) {
    console.error('Error:', error);
}
```

### 3. Memory Issues with Large Files

```javascript
// ❌ Bad: Loading entire file into memory
const data = fs.readFileSync('huge-file.txt');

// ✅ Good: Use streams
const readStream = fs.createReadStream('huge-file.txt');
readStream.on('data', (chunk) => {
    // Process chunk
});
```

---

## Key Takeaways

1. **fs Module**: File system operations
2. **Synchronous vs Asynchronous**: Choose based on use case
3. **Streams**: Efficient for large files
4. **Directories**: Create, read, remove directories
5. **Error Handling**: Always handle errors
6. **Best Practice**: Use async for I/O, streams for large files
7. **File Operations**: Read, write, append, copy, stats

---

## Quiz: File System

Test your understanding with these questions:

1. **fs.readFileSync:**
   - A) Synchronous
   - B) Asynchronous
   - C) Both
   - D) Neither

2. **Streams are:**
   - A) For large files
   - B) For small files
   - C) Both
   - D) Neither

3. **fs.writeFileSync:**
   - A) Overwrites file
   - B) Appends to file
   - C) Both
   - D) Neither

4. **fs.appendFileSync:**
   - A) Overwrites file
   - B) Appends to file
   - C) Both
   - D) Neither

5. **Streams use:**
   - A) Less memory
   - B) More memory
   - C) Both
   - D) Neither

6. **fs.mkdirSync:**
   - A) Creates directory
   - B) Removes directory
   - C) Both
   - D) Neither

7. **Pipe:**
   - A) Connects streams
   - B) Separates streams
   - C) Both
   - D) Neither

**Answers**:
1. A) Synchronous
2. A) For large files
3. A) Overwrites file
4. B) Appends to file
5. A) Less memory
6. A) Creates directory
7. A) Connects streams

---

## Next Steps

Congratulations! You've completed Module 28: Node.js Basics. You now know:
- Node.js introduction
- Node.js modules
- File system operations
- How to work with Node.js

**What's Next?**
- Module 29: Building Web Servers
- Lesson 29.1: HTTP Server with Node.js
- Learn to create HTTP servers
- Build web applications

---

## Additional Resources

- **fs Module**: [nodejs.org/api/fs.html](https://nodejs.org/api/fs.html)
- **Streams**: [nodejs.org/api/stream.html](https://nodejs.org/api/stream.html)
- **Path Module**: [nodejs.org/api/path.html](https://nodejs.org/api/path.html)

---

*Lesson completed! You've finished Module 28: Node.js Basics. Ready for Module 29: Building Web Servers!*

