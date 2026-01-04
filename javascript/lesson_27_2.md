# Lesson 27.2: Vue Components

## Learning Objectives

By the end of this lesson, you will be able to:
- Register Vue components
- Work with props
- Handle events
- Use slots
- Build reusable components
- Compose components
- Structure Vue applications

---

## Introduction to Components

Components are reusable Vue instances with a name. They let you split the UI into independent, reusable pieces.

### What are Components?

- **Reusable**: Use components multiple times
- **Independent**: Each component manages its own state
- **Composable**: Combine components to build UIs
- **Isolated**: Changes in one don't affect others

---

## Component Registration

### Global Registration

```javascript
// Global component registration
const app = createApp({});

app.component('my-component', {
    template: '<div>My Component</div>'
});

app.mount('#app');
```

### Local Registration

```javascript
// Local component registration
const MyComponent = {
    template: '<div>My Component</div>'
};

const app = createApp({
    components: {
        'my-component': MyComponent
    }
});

app.mount('#app');
```

### Single File Components

```vue
<!-- MyComponent.vue -->
<template>
    <div>
        <h2>{{ title }}</h2>
        <p>{{ content }}</p>
    </div>
</template>

<script>
export default {
    name: 'MyComponent',
    data() {
        return {
            title: 'My Component',
            content: 'Component content'
        };
    }
};
</script>

<style scoped>
h2 {
    color: blue;
}
</style>
```

### Using Components

```html
<!-- In template -->
<my-component></my-component>

<!-- Self-closing -->
<my-component />
```

---

## Props

### What are Props?

Props are custom attributes you can register on a component. When a value is passed to a prop attribute, it becomes a property on that component instance.

### Basic Props

```javascript
// Component with props
const MyComponent = {
    props: ['title', 'content'],
    template: `
        <div>
            <h2>{{ title }}</h2>
            <p>{{ content }}</p>
        </div>
    `
};

// Usage
<my-component title="Hello" content="World"></my-component>
```

### Props with Types

```javascript
// Props with types
const MyComponent = {
    props: {
        title: String,
        count: Number,
        isActive: Boolean,
        items: Array,
        user: Object
    },
    template: '<div>{{ title }}</div>'
};
```

### Props with Validation

```javascript
// Props with validation
const MyComponent = {
    props: {
        title: {
            type: String,
            required: true
        },
        count: {
            type: Number,
            default: 0,
            validator(value) {
                return value >= 0;
            }
        },
        items: {
            type: Array,
            default: () => []
        }
    },
    template: '<div>{{ title }}</div>'
};
```

### Props are Read-Only

```javascript
// ❌ Bad: Don't mutate props
const MyComponent = {
    props: ['count'],
    methods: {
        increment() {
            this.count++;  // Error: Props are read-only
        }
    }
};

// ✅ Good: Use data or emit event
const MyComponent = {
    props: ['initialCount'],
    data() {
        return {
            count: this.initialCount
        };
    },
    methods: {
        increment() {
            this.count++;
        }
    }
};
```

---

## Events

### Emitting Events

```javascript
// Component emitting event
const MyComponent = {
    methods: {
        handleClick() {
            this.$emit('custom-event', 'data');
        }
    },
    template: '<button @click="handleClick">Click</button>'
};

// Usage
<my-component @custom-event="handleEvent"></my-component>
```

### Event with Data

```javascript
// Emit event with data
const MyComponent = {
    data() {
        return {
            message: 'Hello'
        };
    },
    methods: {
        sendMessage() {
            this.$emit('message-sent', this.message);
        }
    },
    template: '<button @click="sendMessage">Send</button>'
};

// Parent component
const App = {
    methods: {
        handleMessage(message) {
            console.log('Received:', message);
        }
    },
    template: `
        <my-component @message-sent="handleMessage"></my-component>
    `
};
```

### Event Modifiers

```javascript
// Native event modifiers
<my-component @click.native="handleClick"></my-component>

// Custom event modifiers (Vue 3)
// Use with v-model
```

### v-model with Components

```javascript
// Component with v-model
const CustomInput = {
    props: ['modelValue'],
    emits: ['update:modelValue'],
    template: `
        <input
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        />
    `
};

// Usage
<custom-input v-model="message"></custom-input>
```

---

## Slots

### What are Slots?

Slots are placeholders in components that can be filled with content from the parent.

### Basic Slot

```javascript
// Component with slot
const MyComponent = {
    template: `
        <div>
            <h2>Header</h2>
            <slot></slot>
            <p>Footer</p>
        </div>
    `
};

// Usage
<my-component>
    <p>This content goes in the slot</p>
</my-component>
```

### Named Slots

```javascript
// Component with named slots
const MyComponent = {
    template: `
        <div>
            <header>
                <slot name="header"></slot>
            </header>
            <main>
                <slot></slot>
            </main>
            <footer>
                <slot name="footer"></slot>
            </footer>
        </div>
    `
};

// Usage
<my-component>
    <template #header>
        <h1>Header Content</h1>
    </template>
    <p>Main content</p>
    <template #footer>
        <p>Footer Content</p>
    </template>
</my-component>
```

### Scoped Slots

```javascript
// Component with scoped slot
const MyComponent = {
    data() {
        return {
            items: ['Item 1', 'Item 2', 'Item 3']
        };
    },
    template: `
        <ul>
            <li v-for="item in items" :key="item">
                <slot :item="item"></slot>
            </li>
        </ul>
    `
};

// Usage
<my-component>
    <template #default="{ item }">
        <strong>{{ item }}</strong>
    </template>
</my-component>
```

---

## Practical Examples

### Example 1: Button Component

```javascript
// Button component
const Button = {
    props: {
        text: {
            type: String,
            required: true
        },
        variant: {
            type: String,
            default: 'primary'
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },
    emits: ['click'],
    template: `
        <button
            :class="['btn', 'btn-' + variant]"
            :disabled="disabled"
            @click="$emit('click', $event)"
        >
            {{ text }}
        </button>
    `
};

// Usage
<button text="Click me" variant="primary" @click="handleClick"></button>
```

### Example 2: Card Component

```javascript
// Card component
const Card = {
    props: {
        title: String,
        image: String
    },
    template: `
        <div class="card">
            <img v-if="image" :src="image" :alt="title" />
            <div class="card-content">
                <h3 v-if="title">{{ title }}</h3>
                <slot></slot>
            </div>
        </div>
    `
};

// Usage
<card title="My Card" image="/image.jpg">
    <p>Card content</p>
</card>
```

### Example 3: List Component

```javascript
// List component
const List = {
    props: {
        items: {
            type: Array,
            required: true
        }
    },
    template: `
        <ul>
            <li v-for="(item, index) in items" :key="index">
                <slot :item="item" :index="index"></slot>
            </li>
        </ul>
    `
};

// Usage
<list :items="users">
    <template #default="{ item, index }">
        <strong>{{ item.name }}</strong> - {{ item.email }}
    </template>
</list>
```

---

## Practice Exercise

### Exercise: Vue Components

**Objective**: Practice creating components, working with props, events, and slots.

**Instructions**:

1. Create a Vue project
2. Create multiple components
3. Practice:
   - Component registration
   - Props
   - Events
   - Slots

**Example Solution**:

```vue
<!-- src/components/Button.vue -->
<template>
    <button
        :class="['btn', 'btn-' + variant]"
        :disabled="disabled"
        @click="handleClick"
    >
        <slot>{{ text }}</slot>
    </button>
</template>

<script>
export default {
    name: 'Button',
    props: {
        text: String,
        variant: {
            type: String,
            default: 'primary'
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },
    emits: ['click'],
    methods: {
        handleClick(event) {
            this.$emit('click', event);
        }
    }
};
</script>

<style scoped>
.btn {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
}

.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>
```

```vue
<!-- src/components/Card.vue -->
<template>
    <div class="card">
        <img v-if="image" :src="image" :alt="title" class="card-image" />
        <div class="card-content">
            <h3 v-if="title" class="card-title">{{ title }}</h3>
            <p v-if="description" class="card-description">{{ description }}</p>
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Card',
    props: {
        title: String,
        description: String,
        image: String
    }
};
</script>

<style scoped>
.card {
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.card-content {
    padding: 15px;
}

.card-title {
    margin: 0 0 10px 0;
}

.card-description {
    margin: 0 0 15px 0;
    color: #666;
}
</style>
```

```vue
<!-- src/components/UserCard.vue -->
<template>
    <card :title="user.name" :description="`Age: ${user.age} | Email: ${user.email}`">
        <div class="card-actions">
            <button text="Edit" variant="secondary" @click="handleEdit"></button>
            <button text="Delete" variant="danger" @click="handleDelete"></button>
        </div>
    </card>
</template>

<script>
import Card from './Card.vue';
import Button from './Button.vue';

export default {
    name: 'UserCard',
    components: {
        Card,
        Button
    },
    props: {
        user: {
            type: Object,
            required: true
        }
    },
    emits: ['edit', 'delete'],
    methods: {
        handleEdit() {
            this.$emit('edit', this.user.id);
        },
        handleDelete() {
            this.$emit('delete', this.user.id);
        }
    }
};
</script>

<style scoped>
.card-actions {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}
</style>
```

```vue
<!-- src/components/UserList.vue -->
<template>
    <div class="user-list">
        <h2 v-if="title">{{ title }}</h2>
        <div v-if="users.length === 0" class="empty">
            <slot name="empty">No users found</slot>
        </div>
        <div v-else class="users">
            <user-card
                v-for="user in users"
                :key="user.id"
                :user="user"
                @edit="handleEdit"
                @delete="handleDelete"
            />
        </div>
    </div>
</template>

<script>
import UserCard from './UserCard.vue';

export default {
    name: 'UserList',
    components: {
        UserCard
    },
    props: {
        users: {
            type: Array,
            default: () => []
        },
        title: String
    },
    emits: ['edit', 'delete'],
    methods: {
        handleEdit(userId) {
            this.$emit('edit', userId);
        },
        handleDelete(userId) {
            this.$emit('delete', userId);
        }
    }
};
</script>

<style scoped>
.user-list {
    padding: 20px;
}

.users {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.empty {
    padding: 20px;
    text-align: center;
    color: #666;
}
</style>
```

```vue
<!-- src/components/Layout.vue -->
<template>
    <div class="layout">
        <header v-if="$slots.header">
            <slot name="header"></slot>
        </header>
        <main>
            <slot></slot>
        </main>
        <footer v-if="$slots.footer">
            <slot name="footer"></slot>
        </footer>
    </div>
</template>

<script>
export default {
    name: 'Layout'
};
</script>

<style scoped>
.layout {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

header {
    background-color: #282c34;
    color: white;
    padding: 20px;
}

main {
    flex: 1;
    padding: 20px;
}

footer {
    background-color: #282c34;
    color: white;
    padding: 10px;
    text-align: center;
}
</style>
```

```vue
<!-- src/App.vue -->
<template>
    <layout>
        <template #header>
            <h1>Vue Components Practice</h1>
        </template>
        
        <div class="app-content">
            <user-list
                :users="users"
                title="Users"
                @edit="handleEdit"
                @delete="handleDelete"
            >
                <template #empty>
                    <p>No users available</p>
                </template>
            </user-list>
            
            <div class="actions">
                <button text="Add User" @click="handleAdd"></button>
            </div>
        </div>
        
        <template #footer>
            <p>&copy; 2024 My App</p>
        </template>
    </layout>
</template>

<script>
import Layout from './components/Layout.vue';
import UserList from './components/UserList.vue';
import Button from './components/Button.vue';

export default {
    name: 'App',
    components: {
        Layout,
        UserList,
        Button
    },
    data() {
        return {
            users: [
                { id: 1, name: 'Alice', age: 30, email: 'alice@example.com' },
                { id: 2, name: 'Bob', age: 25, email: 'bob@example.com' },
                { id: 3, name: 'Charlie', age: 35, email: 'charlie@example.com' }
            ]
        };
    },
    methods: {
        handleEdit(userId) {
            console.log('Edit user:', userId);
            alert(`Editing user ${userId}`);
        },
        handleDelete(userId) {
            if (confirm('Are you sure?')) {
                this.users = this.users.filter(user => user.id !== userId);
            }
        },
        handleAdd() {
            alert('Add user');
        }
    }
};
</script>

<style>
.app-content {
    max-width: 1200px;
    margin: 0 auto;
}

.actions {
    margin: 20px 0;
}
</style>
```

**Expected Output** (in browser):
- Layout with header and footer
- User list with cards
- Interactive buttons
- Components working together

**Challenge (Optional)**:
- Build a complete component library
- Create complex component compositions
- Add more features
- Build a real application

---

## Common Mistakes

### 1. Mutating Props

```javascript
// ❌ Bad: Mutate prop
props: ['count'],
methods: {
    increment() {
        this.count++;  // Error
    }
}

// ✅ Good: Use data or emit
props: ['initialCount'],
data() {
    return {
        count: this.initialCount
    };
}
```

### 2. Not Declaring Emits

```javascript
// ❌ Bad: Not declaring emits (Vue 3)
this.$emit('custom-event');

// ✅ Good: Declare emits
emits: ['custom-event'],
this.$emit('custom-event');
```

### 3. Missing Keys in v-for

```javascript
// ❌ Bad: No key
<li v-for="item in items">{{ item }}</li>

// ✅ Good: With key
<li v-for="item in items" :key="item.id">{{ item }}</li>
```

---

## Key Takeaways

1. **Components**: Reusable Vue instances
2. **Registration**: Global or local
3. **Props**: Pass data from parent to child
4. **Events**: Emit events from child to parent
5. **Slots**: Content projection
6. **Best Practice**: Don't mutate props, declare emits, use keys
7. **Composition**: Combine components to build UIs

---

## Quiz: Vue Components

Test your understanding with these questions:

1. **Components are:**
   - A) Reusable
   - B) Independent
   - C) Both
   - D) Neither

2. **Props:**
   - A) Read-only
   - B) Mutable
   - C) Both
   - D) Neither

3. **Events:**
   - A) Child to parent
   - B) Parent to child
   - C) Both
   - D) Neither

4. **Slots:**
   - A) Content projection
   - B) Data passing
   - C) Both
   - D) Neither

5. **v-model with components:**
   - A) Uses modelValue prop
   - B) Uses value prop
   - C) Both
   - D) Neither

6. **Named slots:**
   - A) Use #name
   - B) Use v-slot:name
   - C) Both
   - D) Neither

7. **Scoped slots:**
   - A) Pass data to parent
   - B) Receive data from parent
   - C) Both
   - D) Neither

**Answers**:
1. C) Both
2. A) Read-only
3. A) Child to parent
4. A) Content projection
5. A) Uses modelValue prop (Vue 3)
6. C) Both (#name is shorthand)
7. A) Pass data to parent

---

## Next Steps

Congratulations! You've learned Vue components. You now know:
- How to register components
- How to work with props
- How to handle events
- How to use slots

**What's Next?**
- Lesson 27.3: Vue Composition API
- Learn setup function
- Understand reactive references
- Work with computed properties

---

## Additional Resources

- **Vue Components**: [vuejs.org/guide/essentials/component-basics.html](https://vuejs.org/guide/essentials/component-basics.html)
- **Props**: [vuejs.org/guide/components/props.html](https://vuejs.org/guide/components/props.html)
- **Events**: [vuejs.org/guide/components/events.html](https://vuejs.org/guide/components/events.html)
- **Slots**: [vuejs.org/guide/components/slots.html](https://vuejs.org/guide/components/slots.html)

---

*Lesson completed! You're ready to move on to the next lesson.*

