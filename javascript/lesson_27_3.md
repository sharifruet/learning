# Lesson 27.3: Vue Composition API

## Learning Objectives

By the end of this lesson, you will be able to:
- Use the setup function
- Work with reactive references
- Use computed properties
- Understand Composition API benefits
- Build components with Composition API
- Organize component logic
- Create reusable composables

---

## Introduction to Composition API

The Composition API is a new way to write Vue components introduced in Vue 3. It provides better organization and reusability of component logic.

### Why Composition API?

- **Better Organization**: Group related logic together
- **Reusability**: Share logic between components
- **TypeScript Support**: Better TypeScript inference
- **Flexibility**: More flexible code organization
- **Performance**: Better tree-shaking

### Options API vs Composition API

```javascript
// Options API (Traditional)
export default {
    data() {
        return { count: 0 };
    },
    methods: {
        increment() {
            this.count++;
        }
    }
};

// Composition API (New)
import { ref } from 'vue';

export default {
    setup() {
        const count = ref(0);
        const increment = () => {
            count.value++;
        };
        return { count, increment };
    }
};
```

---

## Setup Function

### Basic Setup

```javascript
// Component with setup function
import { ref } from 'vue';

export default {
    setup() {
        const count = ref(0);
        
        const increment = () => {
            count.value++;
        };
        
        return {
            count,
            increment
        };
    }
};
```

### Setup with Template

```vue
<template>
    <div>
        <p>Count: {{ count }}</p>
        <button @click="increment">Increment</button>
    </div>
</template>

<script>
import { ref } from 'vue';

export default {
    setup() {
        const count = ref(0);
        
        const increment = () => {
            count.value++;
        };
        
        return {
            count,
            increment
        };
    }
};
</script>
```

### Script Setup (Syntactic Sugar)

```vue
<template>
    <div>
        <p>Count: {{ count }}</p>
        <button @click="increment">Increment</button>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const count = ref(0);

const increment = () => {
    count.value++;
};
</script>
```

---

## Reactive References

### ref

`ref` creates a reactive reference to a value.

```javascript
import { ref } from 'vue';

// Basic ref
const count = ref(0);

// Access value
console.log(count.value);  // 0

// Update value
count.value = 1;

// In template, .value is not needed
// {{ count }} not {{ count.value }}
```

### ref with Objects

```javascript
import { ref } from 'vue';

const user = ref({
    name: 'Alice',
    age: 30
});

// Access
console.log(user.value.name);  // Alice

// Update
user.value.name = 'Bob';
```

### reactive

`reactive` creates a reactive object (no .value needed).

```javascript
import { reactive } from 'vue';

const state = reactive({
    count: 0,
    name: 'Alice'
});

// Access (no .value)
console.log(state.count);  // 0

// Update
state.count = 1;
```

### ref vs reactive

```javascript
// ref: Use for primitives or when you need to replace entire object
const count = ref(0);
const user = ref({ name: 'Alice' });

// reactive: Use for objects that won't be replaced
const state = reactive({
    count: 0,
    name: 'Alice'
});

// ref is more flexible, reactive is simpler for objects
```

---

## Computed Properties

### Basic Computed

```javascript
import { ref, computed } from 'vue';

const count = ref(0);

// Computed property
const doubleCount = computed(() => {
    return count.value * 2;
});

// Usage
console.log(doubleCount.value);  // 0 (count is 0)
count.value = 5;
console.log(doubleCount.value);  // 10
```

### Computed with Getter and Setter

```javascript
import { ref, computed } from 'vue';

const firstName = ref('John');
const lastName = ref('Doe');

// Computed with getter and setter
const fullName = computed({
    get() {
        return `${firstName.value} ${lastName.value}`;
    },
    set(value) {
        const parts = value.split(' ');
        firstName.value = parts[0];
        lastName.value = parts[1] || '';
    }
});

// Usage
console.log(fullName.value);  // John Doe
fullName.value = 'Jane Smith';
console.log(firstName.value);  // Jane
console.log(lastName.value);    // Smith
```

### Computed in Template

```vue
<template>
    <div>
        <p>Count: {{ count }}</p>
        <p>Double: {{ doubleCount }}</p>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const count = ref(0);
const doubleCount = computed(() => count.value * 2);
</script>
```

---

## Watch and WatchEffect

### watch

```javascript
import { ref, watch } from 'vue';

const count = ref(0);
const message = ref('');

// Watch single source
watch(count, (newValue, oldValue) => {
    console.log(`Count changed from ${oldValue} to ${newValue}`);
});

// Watch multiple sources
watch([count, message], ([newCount, newMessage], [oldCount, oldMessage]) => {
    console.log('Count or message changed');
});

// Watch with options
watch(count, (newValue) => {
    console.log('Count changed:', newValue);
}, {
    immediate: true,  // Run immediately
    deep: true        // Deep watch for objects
});
```

### watchEffect

```javascript
import { ref, watchEffect } from 'vue';

const count = ref(0);
const doubleCount = ref(0);

// watchEffect runs immediately and tracks dependencies
watchEffect(() => {
    doubleCount.value = count.value * 2;
});

// Automatically tracks count as dependency
count.value = 5;  // doubleCount becomes 10
```

---

## Lifecycle Hooks

### Composition API Lifecycle

```javascript
import { onMounted, onUpdated, onUnmounted } from 'vue';

export default {
    setup() {
        onMounted(() => {
            console.log('Component mounted');
        });
        
        onUpdated(() => {
            console.log('Component updated');
        });
        
        onUnmounted(() => {
            console.log('Component unmounted');
        });
    }
};
```

### All Lifecycle Hooks

```javascript
import {
    onBeforeMount,
    onMounted,
    onBeforeUpdate,
    onUpdated,
    onBeforeUnmount,
    onUnmounted
} from 'vue';

export default {
    setup() {
        onBeforeMount(() => {
            // Before mount
        });
        
        onMounted(() => {
            // After mount
        });
        
        onBeforeUpdate(() => {
            // Before update
        });
        
        onUpdated(() => {
            // After update
        });
        
        onBeforeUnmount(() => {
            // Before unmount
        });
        
        onUnmounted(() => {
            // After unmount
        });
    }
};
```

---

## Props and Emits

### Props

```javascript
import { defineProps } from 'vue';

// Define props
const props = defineProps({
    title: String,
    count: {
        type: Number,
        default: 0
    }
});

// Use props
console.log(props.title);
console.log(props.count);
```

### Emits

```javascript
import { defineEmits } from 'vue';

// Define emits
const emit = defineEmits(['update', 'delete']);

// Emit events
const handleUpdate = () => {
    emit('update', data);
};

const handleDelete = () => {
    emit('delete', id);
};
```

### Props and Emits with TypeScript

```typescript
// With TypeScript
interface Props {
    title: string;
    count?: number;
}

const props = defineProps<Props>();

const emit = defineEmits<{
    update: [value: string];
    delete: [id: number];
}>();
```

---

## Composables (Custom Hooks)

### What are Composables?

Composables are functions that use Composition API features to encapsulate and reuse stateful logic.

### Basic Composable

```javascript
// useCounter.js
import { ref } from 'vue';

export function useCounter(initialValue = 0) {
    const count = ref(initialValue);
    
    const increment = () => {
        count.value++;
    };
    
    const decrement = () => {
        count.value--;
    };
    
    const reset = () => {
        count.value = initialValue;
    };
    
    return {
        count,
        increment,
        decrement,
        reset
    };
}
```

### Using Composable

```vue
<template>
    <div>
        <p>Count: {{ count }}</p>
        <button @click="increment">+</button>
        <button @click="decrement">-</button>
        <button @click="reset">Reset</button>
    </div>
</template>

<script setup>
import { useCounter } from './composables/useCounter';

const { count, increment, decrement, reset } = useCounter(0);
</script>
```

### Composable: useFetch

```javascript
// useFetch.js
import { ref, onMounted } from 'vue';

export function useFetch(url) {
    const data = ref(null);
    const loading = ref(true);
    const error = ref(null);
    
    const fetchData = async () => {
        try {
            loading.value = true;
            error.value = null;
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            data.value = await response.json();
        } catch (err) {
            error.value = err.message;
        } finally {
            loading.value = false;
        }
    };
    
    onMounted(() => {
        fetchData();
    });
    
    return {
        data,
        loading,
        error,
        refetch: fetchData
    };
}
```

### Composable: useLocalStorage

```javascript
// useLocalStorage.js
import { ref, watch } from 'vue';

export function useLocalStorage(key, initialValue) {
    const storedValue = ref(() => {
        try {
            const item = window.localStorage.getItem(key);
            return item ? JSON.parse(item) : initialValue;
        } catch (error) {
            console.error(error);
            return initialValue;
        }
    });
    
    watch(storedValue, (newValue) => {
        try {
            window.localStorage.setItem(key, JSON.stringify(newValue));
        } catch (error) {
            console.error(error);
        }
    }, { deep: true });
    
    return storedValue;
}
```

---

## Practice Exercise

### Exercise: Composition API

**Objective**: Practice using setup function, reactive references, computed properties, and creating composables.

**Instructions**:

1. Create a Vue 3 project
2. Practice Composition API
3. Practice:
   - Setup function
   - Reactive references
   - Computed properties
   - Creating composables

**Example Solution**:

```javascript
// src/composables/useCounter.js
import { ref } from 'vue';

export function useCounter(initialValue = 0, step = 1) {
    const count = ref(initialValue);
    
    const increment = () => {
        count.value += step;
    };
    
    const decrement = () => {
        count.value -= step;
    };
    
    const reset = () => {
        count.value = initialValue;
    };
    
    return {
        count,
        increment,
        decrement,
        reset
    };
}
```

```javascript
// src/composables/useTodos.js
import { ref, computed } from 'vue';

export function useTodos() {
    const todos = ref([]);
    const filter = ref('all');
    
    const addTodo = (text) => {
        if (text.trim()) {
            todos.value.push({
                id: Date.now(),
                text,
                completed: false
            });
        }
    };
    
    const toggleTodo = (id) => {
        const todo = todos.value.find(t => t.id === id);
        if (todo) {
            todo.completed = !todo.completed;
        }
    };
    
    const removeTodo = (id) => {
        todos.value = todos.value.filter(t => t.id !== id);
    };
    
    const setFilter = (newFilter) => {
        filter.value = newFilter;
    };
    
    const filteredTodos = computed(() => {
        if (filter.value === 'active') {
            return todos.value.filter(t => !t.completed);
        }
        if (filter.value === 'completed') {
            return todos.value.filter(t => t.completed);
        }
        return todos.value;
    });
    
    return {
        todos,
        filter,
        filteredTodos,
        addTodo,
        toggleTodo,
        removeTodo,
        setFilter
    };
}
```

```javascript
// src/composables/useFetch.js
import { ref, onMounted } from 'vue';

export function useFetch(url) {
    const data = ref(null);
    const loading = ref(true);
    const error = ref(null);
    
    const fetchData = async () => {
        try {
            loading.value = true;
            error.value = null;
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            data.value = await response.json();
        } catch (err) {
            error.value = err.message;
        } finally {
            loading.value = false;
        }
    };
    
    onMounted(() => {
        fetchData();
    });
    
    return {
        data,
        loading,
        error,
        refetch: fetchData
    };
}
```

```vue
<!-- src/components/Counter.vue -->
<template>
    <div class="counter">
        <h2>Counter</h2>
        <p>Count: {{ count }}</p>
        <p>Double: {{ doubleCount }}</p>
        <div class="buttons">
            <button @click="decrement">-</button>
            <button @click="reset">Reset</button>
            <button @click="increment">+</button>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useCounter } from '../composables/useCounter';

const { count, increment, decrement, reset } = useCounter(0);
const doubleCount = computed(() => count.value * 2);
</script>

<style scoped>
.counter {
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.buttons {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

button {
    padding: 8px 16px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
</style>
```

```vue
<!-- src/components/TodoApp.vue -->
<template>
    <div class="todo-app">
        <h2>Todo App</h2>
        <div class="todo-input">
            <input
                v-model="newTodo"
                @keyup.enter="handleAdd"
                placeholder="Add todo..."
            />
            <button @click="handleAdd">Add</button>
        </div>
        <div class="filters">
            <button
                :class="{ active: filter === 'all' }"
                @click="setFilter('all')"
            >
                All
            </button>
            <button
                :class="{ active: filter === 'active' }"
                @click="setFilter('active')"
            >
                Active
            </button>
            <button
                :class="{ active: filter === 'completed' }"
                @click="setFilter('completed')"
            >
                Completed
            </button>
        </div>
        <ul>
            <li
                v-for="todo in filteredTodos"
                :key="todo.id"
                :class="{ completed: todo.completed }"
            >
                <input
                    type="checkbox"
                    :checked="todo.completed"
                    @change="toggleTodo(todo.id)"
                />
                <span>{{ todo.text }}</span>
                <button @click="removeTodo(todo.id)">Delete</button>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useTodos } from '../composables/useTodos';

const { todos, filter, filteredTodos, addTodo, toggleTodo, removeTodo, setFilter } = useTodos();
const newTodo = ref('');

const handleAdd = () => {
    addTodo(newTodo.value);
    newTodo.value = '';
};
</script>

<style scoped>
.todo-app {
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.todo-input {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.todo-input input {
    flex: 1;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.filters {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.filters button.active {
    background-color: #28a745;
}

ul {
    list-style: none;
    padding: 0;
}

li {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    margin: 5px 0;
    background-color: #f5f5f5;
    border-radius: 4px;
}

li.completed span {
    text-decoration: line-through;
    opacity: 0.6;
}

button {
    padding: 8px 16px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
</style>
```

```vue
<!-- src/components/UserProfile.vue -->
<template>
    <div class="user-profile">
        <h2>User Profile</h2>
        <div v-if="loading">Loading...</div>
        <div v-else-if="error">Error: {{ error }}</div>
        <div v-else-if="data">
            <p><strong>Name:</strong> {{ data.name }}</p>
            <p><strong>Email:</strong> {{ data.email }}</p>
        </div>
        <button @click="refetch">Refetch</button>
    </div>
</template>

<script setup>
import { useFetch } from '../composables/useFetch';

const { data, loading, error, refetch } = useFetch('https://jsonplaceholder.typicode.com/users/1');
</script>

<style scoped>
.user-profile {
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
}
</style>
```

```vue
<!-- src/App.vue -->
<template>
    <div class="app">
        <header>
            <h1>Vue Composition API Practice</h1>
        </header>
        <main>
            <section>
                <counter />
            </section>
            <section>
                <todo-app />
            </section>
            <section>
                <user-profile />
            </section>
        </main>
    </div>
</template>

<script setup>
import Counter from './components/Counter.vue';
import TodoApp from './components/TodoApp.vue';
import UserProfile from './components/UserProfile.vue';
</script>

<style>
.app {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

header {
    text-align: center;
    margin-bottom: 30px;
}

section {
    margin-bottom: 40px;
}
</style>
```

**Expected Output** (in browser):
- Counter with composable
- Todo app with composable
- User profile with useFetch
- All working with Composition API

**Challenge (Optional)**:
- Create more composables
- Build complex components
- Practice all Composition API features
- Build a complete application

---

## Common Mistakes

### 1. Forgetting .value with ref

```javascript
// ❌ Bad: Missing .value
const count = ref(0);
count++;  // Error

// ✅ Good: Use .value
const count = ref(0);
count.value++;
```

### 2. Not Returning from Setup

```javascript
// ❌ Bad: Not returning
setup() {
    const count = ref(0);
    // Missing return
}

// ✅ Good: Return what you need
setup() {
    const count = ref(0);
    return { count };
}
```

### 3. Mutating Props

```javascript
// ❌ Bad: Mutate prop
const props = defineProps(['count']);
props.count++;  // Error

// ✅ Good: Use emit or local state
const props = defineProps(['initialCount']);
const count = ref(props.initialCount);
```

---

## Key Takeaways

1. **Composition API**: New way to write Vue components
2. **Setup Function**: Entry point for Composition API
3. **ref**: Reactive reference (use .value)
4. **reactive**: Reactive object (no .value)
5. **computed**: Computed properties
6. **Composables**: Reusable logic functions
7. **Best Practice**: Use script setup, create composables, organize logic

---

## Quiz: Vue Composition API

Test your understanding with these questions:

1. **Composition API:**
   - A) Vue 3 feature
   - B) Vue 2 feature
   - C) Both
   - D) Neither

2. **ref requires:**
   - A) .value
   - B) No .value
   - C) Both
   - D) Neither

3. **reactive:**
   - A) No .value needed
   - B) .value needed
   - C) Both
   - D) Neither

4. **computed:**
   - A) Cached
   - B) Not cached
   - C) Both
   - D) Neither

5. **Composables:**
   - A) Reusable logic
   - B) Component logic
   - C) Both
   - D) Neither

6. **script setup:**
   - A) Syntactic sugar
   - B) Required
   - C) Both
   - D) Neither

7. **setup function:**
   - A) Must return
   - B) Optional return
   - C) Both
   - D) Neither

**Answers**:
1. A) Vue 3 feature
2. A) .value
3. A) No .value needed
4. A) Cached
5. A) Reusable logic
6. A) Syntactic sugar
7. A) Must return (unless using script setup)

---

## Next Steps

Congratulations! You've completed Module 27: Vue.js (Alternative Framework). You now know:
- Vue.js basics
- Vue components
- Vue Composition API
- How to build Vue applications

**What's Next?**
- Module 28: Node.js Basics
- Learn Node.js introduction
- Understand Node.js fundamentals
- Build server-side applications

---

## Additional Resources

- **Composition API**: [vuejs.org/guide/extras/composition-api-faq.html](https://vuejs.org/guide/extras/composition-api-faq.html)
- **Script Setup**: [vuejs.org/api/sfc-script-setup.html](https://vuejs.org/api/sfc-script-setup.html)
- **Composables**: [vuejs.org/guide/reusability/composables.html](https://vuejs.org/guide/reusability/composables.html)

---

*Lesson completed! You've finished Module 27: Vue.js. Ready for Module 28: Node.js Basics!*

