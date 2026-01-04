# Lesson 23.2: Webpack

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand webpack basics
- Configure webpack
- Use loaders for different file types
- Use plugins for additional functionality
- Implement code splitting
- Optimize builds
- Bundle JavaScript applications

---

## Introduction to Webpack

Webpack is a module bundler that processes and bundles JavaScript modules and assets.

### Why Webpack?

- **Bundling**: Combines multiple files into bundles
- **Transformation**: Transpiles and transforms code
- **Optimization**: Optimizes for production
- **Code Splitting**: Splits code into chunks
- **Asset Management**: Handles images, CSS, etc.
- **Industry Standard**: Widely used in production

---

## Webpack Basics

### Installation

```bash
# Install webpack
npm install --save-dev webpack webpack-cli

# Or with yarn
yarn add --dev webpack webpack-cli
```

### Basic Setup

```javascript
// webpack.config.js
const path = require('path');

module.exports = {
    entry: './src/index.js',
    output: {
        filename: 'bundle.js',
        path: path.resolve(__dirname, 'dist')
    }
};
```

### Entry and Output

```javascript
// Single entry
module.exports = {
    entry: './src/index.js',
    output: {
        filename: 'bundle.js',
        path: path.resolve(__dirname, 'dist')
    }
};

// Multiple entry points
module.exports = {
    entry: {
        app: './src/app.js',
        admin: './src/admin.js'
    },
    output: {
        filename: '[name].bundle.js',
        path: path.resolve(__dirname, 'dist')
    }
};
```

---

## Configuration

### Basic Configuration

```javascript
// webpack.config.js
const path = require('path');

module.exports = {
    mode: 'development',  // or 'production'
    entry: './src/index.js',
    output: {
        filename: 'bundle.js',
        path: path.resolve(__dirname, 'dist'),
        clean: true  // Clean output directory
    },
    devtool: 'source-map',  // Source maps
    target: 'web'  // or 'node'
};
```

### Development vs Production

```javascript
// Development
module.exports = {
    mode: 'development',
    devtool: 'eval-source-map',
    optimization: {
        minimize: false
    }
};

// Production
module.exports = {
    mode: 'production',
    devtool: 'source-map',
    optimization: {
        minimize: true
    }
};
```

---

## Loaders

### What are Loaders?

Loaders transform files before bundling.

### Common Loaders

```javascript
// babel-loader: Transpile ES6+
module.exports = {
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            }
        ]
    }
};
```

### CSS Loaders

```javascript
// css-loader and style-loader
module.exports = {
    module: {
        rules: [
            {
                test: /\.css$/,
                use: ['style-loader', 'css-loader']
            }
        ]
    }
};
```

### File Loaders

```javascript
// file-loader: Handle images, fonts, etc.
module.exports = {
    module: {
        rules: [
            {
                test: /\.(png|svg|jpg|jpeg|gif)$/i,
                type: 'asset/resource'
            },
            {
                test: /\.(woff|woff2|eot|ttf|otf)$/i,
                type: 'asset/resource'
            }
        ]
    }
};
```

### Multiple Loaders

```javascript
module.exports = {
    module: {
        rules: [
            {
                test: /\.scss$/,
                use: [
                    'style-loader',    // Injects CSS into DOM
                    'css-loader',      // Resolves CSS imports
                    'sass-loader'      // Compiles Sass to CSS
                ]
            }
        ]
    }
};
```

---

## Plugins

### What are Plugins?

Plugins extend webpack functionality.

### Common Plugins

```javascript
const HtmlWebpackPlugin = require('html-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

module.exports = {
    plugins: [
        new CleanWebpackPlugin(),
        new HtmlWebpackPlugin({
            template: './src/index.html',
            filename: 'index.html'
        })
    ]
};
```

### HTML Webpack Plugin

```javascript
const HtmlWebpackPlugin = require('html-webpack-plugin');

module.exports = {
    plugins: [
        new HtmlWebpackPlugin({
            template: './src/index.html',
            filename: 'index.html',
            inject: 'body',
            minify: {
                removeComments: true,
                collapseWhitespace: true
            }
        })
    ]
};
```

### Mini CSS Extract Plugin

```javascript
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
    module: {
        rules: [
            {
                test: /\.css$/,
                use: [MiniCssExtractPlugin.loader, 'css-loader']
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: 'styles.css'
        })
    ]
};
```

---

## Code Splitting

### Entry Points

```javascript
// Split by entry points
module.exports = {
    entry: {
        app: './src/app.js',
        vendor: './src/vendor.js'
    },
    output: {
        filename: '[name].bundle.js',
        path: path.resolve(__dirname, 'dist')
    }
};
```

### SplitChunks

```javascript
module.exports = {
    optimization: {
        splitChunks: {
            chunks: 'all',
            cacheGroups: {
                vendor: {
                    test: /[\\/]node_modules[\\/]/,
                    name: 'vendors',
                    chunks: 'all'
                }
            }
        }
    }
};
```

### Dynamic Imports

```javascript
// In your code
async function loadModule() {
    let module = await import('./module.js');
    module.doSomething();
}

// Webpack automatically splits this
```

---

## Development Server

### Webpack Dev Server

```bash
# Install
npm install --save-dev webpack-dev-server
```

```javascript
// webpack.config.js
module.exports = {
    devServer: {
        static: './dist',
        port: 3000,
        hot: true,
        open: true
    }
};
```

```json
// package.json
{
  "scripts": {
    "dev": "webpack serve --mode development",
    "build": "webpack --mode production"
  }
}
```

---

## Practice Exercise

### Exercise: Webpack Setup

**Objective**: Practice setting up webpack, configuring loaders and plugins, and implementing code splitting.

**Instructions**:

1. Install webpack
2. Create webpack configuration
3. Set up loaders and plugins
4. Practice:
   - Basic webpack setup
   - Using loaders
   - Using plugins
   - Code splitting

**Example Solution**:

```bash
# 1. Initialize project
npm init -y

# 2. Install webpack
npm install --save-dev webpack webpack-cli

# 3. Install loaders
npm install --save-dev babel-loader @babel/core @babel/preset-env
npm install --save-dev css-loader style-loader
npm install --save-dev file-loader

# 4. Install plugins
npm install --save-dev html-webpack-plugin clean-webpack-plugin
npm install --save-dev webpack-dev-server
```

```javascript
// webpack.config.js
const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

module.exports = {
    mode: 'development',
    entry: './src/index.js',
    output: {
        filename: 'bundle.js',
        path: path.resolve(__dirname, 'dist'),
        clean: true
    },
    devtool: 'source-map',
    devServer: {
        static: './dist',
        port: 3000,
        hot: true,
        open: true
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            },
            {
                test: /\.css$/,
                use: ['style-loader', 'css-loader']
            },
            {
                test: /\.(png|svg|jpg|jpeg|gif)$/i,
                type: 'asset/resource'
            }
        ]
    },
    plugins: [
        new CleanWebpackPlugin(),
        new HtmlWebpackPlugin({
            template: './src/index.html',
            filename: 'index.html'
        })
    ],
    optimization: {
        splitChunks: {
            chunks: 'all',
            cacheGroups: {
                vendor: {
                    test: /[\\/]node_modules[\\/]/,
                    name: 'vendors',
                    chunks: 'all'
                }
            }
        }
    }
};
```

```javascript
// src/index.js
import './styles.css';
import { add, multiply } from './math';

console.log('Webpack is working!');
console.log('add(2, 3) =', add(2, 3));
console.log('multiply(4, 5) =', multiply(4, 5));

// Dynamic import example
async function loadModule() {
    let module = await import('./lazy-module.js');
    module.default();
}

// Load on button click
document.getElementById('load-btn').addEventListener('click', loadModule);
```

```javascript
// src/math.js
export function add(a, b) {
    return a + b;
}

export function multiply(a, b) {
    return a * b;
}
```

```javascript
// src/lazy-module.js
export default function() {
    console.log('Lazy module loaded!');
}
```

```css
/* src/styles.css */
body {
    font-family: Arial, sans-serif;
    margin: 20px;
}

button {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}
```

```html
<!-- src/index.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webpack Practice</title>
</head>
<body>
    <h1>Webpack Practice</h1>
    <button id="load-btn">Load Lazy Module</button>
    <div id="output"></div>
</body>
</html>
```

```json
// package.json
{
  "name": "webpack-practice",
  "version": "1.0.0",
  "scripts": {
    "dev": "webpack serve --mode development",
    "build": "webpack --mode production",
    "build:dev": "webpack --mode development"
  },
  "devDependencies": {
    "@babel/core": "^7.22.0",
    "@babel/preset-env": "^7.22.0",
    "babel-loader": "^9.1.0",
    "clean-webpack-plugin": "^4.0.0",
    "css-loader": "^6.8.0",
    "html-webpack-plugin": "^5.5.0",
    "style-loader": "^3.3.0",
    "webpack": "^5.88.0",
    "webpack-cli": "^5.1.0",
    "webpack-dev-server": "^4.15.0"
  }
}
```

**Expected Output** (when running `npm run dev`):
```
webpack compiled successfully
Server running on http://localhost:3000
```

**Challenge (Optional)**:
- Set up a complete webpack project
- Add more loaders (Sass, TypeScript)
- Optimize for production
- Implement advanced code splitting

---

## Common Mistakes

### 1. Wrong Loader Order

```javascript
// ❌ Bad: Wrong order
{
    test: /\.scss$/,
    use: ['sass-loader', 'css-loader', 'style-loader']
}

// ✅ Good: Right order (processes right to left)
{
    test: /\.scss$/,
    use: ['style-loader', 'css-loader', 'sass-loader']
}
```

### 2. Not Excluding node_modules

```javascript
// ❌ Bad: Process node_modules
{
    test: /\.js$/,
    use: 'babel-loader'
}

// ✅ Good: Exclude node_modules
{
    test: /\.js$/,
    exclude: /node_modules/,
    use: 'babel-loader'
}
```

### 3. Missing Output Path

```javascript
// ❌ Bad: Relative path might not work
output: {
    filename: 'bundle.js',
    path: 'dist'
}

// ✅ Good: Absolute path
output: {
    filename: 'bundle.js',
    path: path.resolve(__dirname, 'dist')
}
```

---

## Key Takeaways

1. **Webpack**: Module bundler for JavaScript
2. **Entry**: Entry point(s) for bundling
3. **Output**: Where bundles are written
4. **Loaders**: Transform files before bundling
5. **Plugins**: Extend webpack functionality
6. **Code Splitting**: Split code into chunks
7. **Best Practice**: Use appropriate loaders, optimize for production

---

## Quiz: Webpack

Test your understanding with these questions:

1. **Webpack is:**
   - A) Module bundler
   - B) Package manager
   - C) Both
   - D) Neither

2. **Loaders:**
   - A) Transform files
   - B) Extend functionality
   - C) Both
   - D) Neither

3. **Plugins:**
   - A) Transform files
   - B) Extend functionality
   - C) Both
   - D) Neither

4. **entry specifies:**
   - A) Output location
   - B) Entry point
   - C) Both
   - D) Neither

5. **Loaders process:**
   - A) Left to right
   - B) Right to left
   - C) Random
   - D) Never

6. **Code splitting:**
   - A) Splits code into chunks
   - B) Combines code
   - C) Both
   - D) Neither

7. **webpack-dev-server:**
   - A) Development server
   - B) Production server
   - C) Both
   - D) Neither

**Answers**:
1. A) Module bundler
2. A) Transform files
3. B) Extend functionality
4. B) Entry point
5. B) Right to left
6. A) Splits code into chunks
7. A) Development server

---

## Next Steps

Congratulations! You've learned webpack. You now know:
- How to configure webpack
- How to use loaders
- How to use plugins
- How to implement code splitting

**What's Next?**
- Lesson 23.3: Modern Build Tools
- Learn Vite
- Understand Parcel
- Work with esbuild

---

## Additional Resources

- **Webpack Documentation**: [webpack.js.org](https://webpack.js.org)
- **Webpack Concepts**: [webpack.js.org/concepts](https://webpack.js.org/concepts)
- **Webpack Loaders**: [webpack.js.org/loaders](https://webpack.js.org/loaders)

---

*Lesson completed! You're ready to move on to the next lesson.*

