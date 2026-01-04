# Lesson 27.1: Vue.js Basics

## Learning Objectives

By the end of this lesson, you will be able to:
- Understand what Vue.js is
- Create Vue instances
- Work with templates and directives
- Use data binding
- Build your first Vue app
- Understand Vue.js fundamentals
- Create reactive applications

---

## Introduction to Vue.js

Vue.js is a progressive JavaScript framework for building user interfaces.

### What is Vue.js?

- **Progressive Framework**: Can be adopted incrementally
- **Reactive**: Automatic reactivity system
- **Component-Based**: Build with reusable components
- **Template Syntax**: HTML-based templates
- **Easy to Learn**: Gentle learning curve
- **Versatile**: Can be used for small or large applications

### Why Vue.js?

- **Simple**: Easy to understand
- **Flexible**: Can be used in many ways
- **Performant**: Fast and efficient
- **Developer Experience**: Great tooling
- **Growing**: Popular and well-maintained
- **Documentation**: Excellent documentation

---

## Vue.js Introduction

### Installation

```bash
# Using CDN
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

# Using npm
npm create vue@latest my-app
cd my-app
npm install
npm run dev

# Using Vite
npm create vite@latest my-vue-app -- --template vue
cd my-vue-app
npm install
npm run dev
```

### Vue Versions

```javascript
// Vue 2 (Legacy)
Vue 2.x

// Vue 3 (Current)
Vue 3.x
// - Composition API
// - Better performance
// - Better TypeScript support
```

---

## Vue Instance

### Creating a Vue Instance

```javascript
// Vue 3 - Using createApp
import { createApp } from 'vue';

const app = createApp({
    data() {
        return {
            message: 'Hello Vue!'
        };
    }
});

app.mount('#app');
```

### Basic Vue App

```html
<!-- index.html -->
<!DOCTYPE html>
<html>
<head>
    <title>Vue App</title>
</head>
<body>
    <div id="app">
        <h1>{{ message }}</h1>
    </div>
    
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script>
        const { createApp } = Vue;
        
        createApp({
            data() {
                return {
                    message: 'Hello Vue!'
                };
            }
        }).mount('#app');
    </script>
</body>
</html>
```

### Vue Instance Options

```javascript
const app = createApp({
    // Data
    data() {
        return {
            message: 'Hello',
            count: 0
        };
    },
    
    // Methods
    methods: {
        increment() {
            this.count++;
        }
    },
    
    // Computed properties
    computed: {
        doubleCount() {
            return this.count * 2;
        }
    },
    
    // Lifecycle hooks
    mounted() {
        console.log('Component mounted');
    }
});
```

---

## Templates and Directives

### Template Syntax

```html
<!-- Interpolation -->
<div>{{ message }}</div>

<!-- Text interpolation -->
<span>Message: {{ message }}</span>

<!-- HTML interpolation (v-html) -->
<div v-html="htmlContent"></div>
```

### Directives

Directives are special attributes with the `v-` prefix.

### v-bind (Binding Attributes)

```html
<!-- v-bind -->
<div v-bind:id="dynamicId"></div>

<!-- Shorthand -->
<div :id="dynamicId"></div>

<!-- Binding classes -->
<div :class="{ active: isActive }"></div>
<div :class="[classA, classB]"></div>

<!-- Binding styles -->
<div :style="{ color: activeColor }"></div>
<div :style="[styleObject, styleObject2]"></div>
```

### v-if, v-else-if, v-else (Conditional Rendering)

```html
<!-- Conditional rendering -->
<div v-if="isVisible">Visible</div>
<div v-else-if="isHidden">Hidden</div>
<div v-else>Default</div>

<!-- v-show (toggles display) -->
<div v-show="isVisible">Toggle visibility</div>
```

### v-for (Lists)

```html
<!-- List rendering -->
<ul>
    <li v-for="item in items" :key="item.id">
        {{ item.name }}
    </li>
</ul>

<!-- With index -->
<ul>
    <li v-for="(item, index) in items" :key="item.id">
        {{ index }}: {{ item.name }}
    </li>
</ul>

<!-- Object iteration -->
<ul>
    <li v-for="(value, key) in object" :key="key">
        {{ key }}: {{ value }}
    </li>
</ul>
```

### v-on (Event Handling)

```html
<!-- Event handling -->
<button v-on:click="handleClick">Click me</button>

<!-- Shorthand -->
<button @click="handleClick">Click me</button>

<!-- With parameters -->
<button @click="handleClick('param')">Click</button>

<!-- Event modifiers -->
<button @click.stop="handleClick">Stop propagation</button>
<button @click.prevent="handleSubmit">Prevent default</button>
<button @click.once="handleClick">Once only</button>
```

### v-model (Two-Way Binding)

```html
<!-- Two-way binding -->
<input v-model="message" />

<!-- With modifiers -->
<input v-model.trim="message" />
<input v-model.number="age" />
<input v-model.lazy="message" />
```

### Other Directives

```html
<!-- v-text -->
<div v-text="message"></div>

<!-- v-once (render once) -->
<div v-once>{{ message }}</div>

<!-- v-pre (skip compilation) -->
<div v-pre>{{ message }}</div>
```

---

## Data Binding

### One-Way Binding

```html
<!-- Interpolation -->
<div>{{ message }}</div>

<!-- v-bind -->
<div :id="dynamicId"></div>
```

### Two-Way Binding

```html
<!-- v-model -->
<input v-model="message" />

<!-- Equivalent to -->
<input 
    :value="message"
    @input="message = $event.target.value"
/>
```

### Class Binding

```html
<!-- Object syntax -->
<div :class="{ active: isActive, 'text-danger': hasError }"></div>

<!-- Array syntax -->
<div :class="[activeClass, errorClass]"></div>

<!-- Conditional -->
<div :class="[isActive ? activeClass : '', errorClass]"></div>
```

### Style Binding

```html
<!-- Object syntax -->
<div :style="{ color: activeColor, fontSize: fontSize + 'px' }"></div>

<!-- Array syntax -->
<div :style="[baseStyles, overridingStyles]"></div>

<!-- With computed -->
<div :style="styleObject"></div>
```

### Example: Complete Binding

```html
<div id="app">
    <!-- Text binding -->
    <p>{{ message }}</p>
    
    <!-- Attribute binding -->
    <div :id="dynamicId">Dynamic ID</div>
    
    <!-- Class binding -->
    <div :class="{ active: isActive }">Class binding</div>
    
    <!-- Style binding -->
    <div :style="{ color: textColor }">Style binding</div>
    
    <!-- Two-way binding -->
    <input v-model="message" />
    
    <!-- Event binding -->
    <button @click="toggleActive">Toggle</button>
</div>

<script>
const { createApp } = Vue;

createApp({
    data() {
        return {
            message: 'Hello Vue!',
            dynamicId: 'my-id',
            isActive: false,
            textColor: 'blue'
        };
    },
    methods: {
        toggleActive() {
            this.isActive = !this.isActive;
        }
    }
}).mount('#app');
</script>
```

---

## Practice Exercise

### Exercise: First Vue App

**Objective**: Practice creating Vue instances, using templates and directives, and data binding.

**Instructions**:

1. Set up a Vue project
2. Create Vue instances
3. Practice:
   - Templates and directives
   - Data binding
   - Event handling
   - Conditional rendering
   - List rendering

**Example Solution**:

```html
<!-- index.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vue Basics Practice</title>
    <style>
        .active {
            background-color: #4CAF50;
            color: white;
        }
        .inactive {
            background-color: #f44336;
            color: white;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
        }
        button {
            padding: 8px 16px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input {
            padding: 8px;
            margin: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div id="app">
        <header>
            <h1>{{ title }}</h1>
            <p>Vue.js Basics Practice</p>
        </header>
        
        <section class="card">
            <h2>Text Interpolation</h2>
            <p>Message: {{ message }}</p>
            <p>Count: {{ count }}</p>
            <p>Math: 2 + 2 = {{ 2 + 2 }}</p>
        </section>
        
        <section class="card">
            <h2>Two-Way Binding</h2>
            <input v-model="message" placeholder="Type a message" />
            <p>You typed: {{ message }}</p>
        </section>
        
        <section class="card">
            <h2>Event Handling</h2>
            <p>Count: {{ count }}</p>
            <button @click="increment">Increment</button>
            <button @click="decrement">Decrement</button>
            <button @click="reset">Reset</button>
        </section>
        
        <section class="card">
            <h2>Conditional Rendering</h2>
            <button @click="toggleVisibility">Toggle Visibility</button>
            <div v-if="isVisible" class="active">
                This is visible (v-if)
            </div>
            <div v-else class="inactive">
                This is hidden (v-else)
            </div>
            <div v-show="isVisible" class="active">
                This toggles display (v-show)
            </div>
        </section>
        
        <section class="card">
            <h2>List Rendering</h2>
            <input v-model="newItem" @keyup.enter="addItem" placeholder="Add item" />
            <button @click="addItem">Add</button>
            <ul>
                <li v-for="(item, index) in items" :key="index">
                    {{ item }}
                    <button @click="removeItem(index)">Remove</button>
                </li>
            </ul>
        </section>
        
        <section class="card">
            <h2>Class Binding</h2>
            <div :class="{ active: isActive, inactive: !isActive }">
                Dynamic class binding
            </div>
            <button @click="isActive = !isActive">Toggle Class</button>
        </section>
        
        <section class="card">
            <h2>Style Binding</h2>
            <div :style="{ color: textColor, fontSize: fontSize + 'px' }">
                Dynamic style binding
            </div>
            <input v-model="textColor" placeholder="Color (e.g., blue)" />
            <input v-model.number="fontSize" type="number" placeholder="Font size" />
        </section>
        
        <section class="card">
            <h2>Computed Properties</h2>
            <p>Count: {{ count }}</p>
            <p>Double Count: {{ doubleCount }}</p>
            <p>Items Count: {{ items.length }}</p>
        </section>
    </div>
    
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script>
        const { createApp } = Vue;
        
        createApp({
            data() {
                return {
                    title: 'Vue.js Basics',
                    message: 'Hello Vue!',
                    count: 0,
                    isVisible: true,
                    isActive: false,
                    items: ['Item 1', 'Item 2', 'Item 3'],
                    newItem: '',
                    textColor: 'blue',
                    fontSize: 16
                };
            },
            computed: {
                doubleCount() {
                    return this.count * 2;
                }
            },
            methods: {
                increment() {
                    this.count++;
                },
                decrement() {
                    this.count--;
                },
                reset() {
                    this.count = 0;
                },
                toggleVisibility() {
                    this.isVisible = !this.isVisible;
                },
                addItem() {
                    if (this.newItem.trim()) {
                        this.items.push(this.newItem);
                        this.newItem = '';
                    }
                },
                removeItem(index) {
                    this.items.splice(index, 1);
                }
            },
            mounted() {
                console.log('Vue app mounted!');
            }
        }).mount('#app');
    </script>
</body>
</html>
```

**Expected Output** (in browser):
- Vue app with multiple sections
- Interactive elements
- Data binding working
- Event handling working
- Conditional and list rendering

**Challenge (Optional)**:
- Build a complete Vue app
- Add more features
- Style your app
- Practice all directives

---

## Common Mistakes

### 1. Forgetting v-bind for Attributes

```html
<!-- ❌ Bad: String literal -->
<div id="dynamicId">Content</div>

<!-- ✅ Good: v-bind -->
<div :id="dynamicId">Content</div>
```

### 2. Mutating Props

```html
<!-- ❌ Bad: Mutate prop -->
<child-component :prop="value" />
<!-- Inside child: this.prop = newValue -->

<!-- ✅ Good: Use data or emit event -->
```

### 3. Missing Keys in v-for

```html
<!-- ❌ Bad: No key -->
<li v-for="item in items">{{ item }}</li>

<!-- ✅ Good: With key -->
<li v-for="item in items" :key="item.id">{{ item }}</li>
```

---

## Key Takeaways

1. **Vue.js**: Progressive JavaScript framework
2. **Vue Instance**: Created with createApp
3. **Templates**: HTML-based template syntax
4. **Directives**: Special attributes with v- prefix
5. **Data Binding**: One-way and two-way binding
6. **Reactivity**: Automatic reactivity system
7. **Best Practice**: Use keys in v-for, don't mutate props

---

## Quiz: Vue Basics

Test your understanding with these questions:

1. **Vue.js is:**
   - A) Framework
   - B) Library
   - C) Both
   - D) Neither

2. **Vue instance created with:**
   - A) createApp
   - B) new Vue
   - C) Both
   - D) Neither

3. **v-bind shorthand:**
   - A) :
   - B) @
   - C) Both
   - D) Neither

4. **v-on shorthand:**
   - A) :
   - B) @
   - C) Both
   - D) Neither

5. **v-model:**
   - A) Two-way binding
   - B) One-way binding
   - C) Both
   - D) Neither

6. **v-if vs v-show:**
   - A) v-if removes from DOM
   - B) v-show toggles display
   - C) Both
   - D) Neither

7. **v-for requires:**
   - A) key
   - B) index
   - C) Both
   - D) Neither

**Answers**:
1. A) Framework
2. A) createApp (Vue 3)
3. A) :
4. B) @
5. A) Two-way binding
6. C) Both (v-if removes, v-show toggles)
7. A) key (recommended)

---

## Next Steps

Congratulations! You've learned Vue.js basics. You now know:
- What Vue.js is
- How to create Vue instances
- Templates and directives
- Data binding

**What's Next?**
- Lesson 27.2: Vue Components
- Learn component registration
- Understand props and events
- Work with slots

---

## Additional Resources

- **Vue.js Documentation**: [vuejs.org](https://vuejs.org)
- **Getting Started**: [vuejs.org/guide/quick-start.html](https://vuejs.org/guide/quick-start.html)
- **Template Syntax**: [vuejs.org/guide/essentials/template-syntax.html](https://vuejs.org/guide/essentials/template-syntax.html)

---

*Lesson completed! You're ready to move on to the next lesson.*

