# Capstone Project 2: Single Page Application (SPA)

## Project Overview

Build a production-ready Single Page Application (SPA) using a modern framework (React or Vue). This capstone project will demonstrate mastery of frontend development, state management, routing, API integration, and responsive design.

## Learning Objectives

By the end of this project, you will be able to:
- Build complex single-page applications
- Implement advanced state management
- Create seamless routing and navigation
- Integrate with external APIs
- Design responsive, modern UIs
- Optimize application performance
- Handle complex user interactions
- Deploy SPAs to production

---

## Project Requirements

### Core Features

1. **Multiple Routes & Navigation**
   - At least 5-7 different pages/routes
   - Protected routes
   - Dynamic routes with parameters
   - Nested routes (optional)

2. **State Management**
   - Global state management (Context API or Redux)
   - Local component state
   - State persistence
   - Complex state interactions

3. **API Integration**
   - Connect to external APIs or mock backend
   - Handle loading states
   - Error handling
   - Data caching (optional)

4. **User Interface**
   - Modern, polished design
   - Responsive (mobile, tablet, desktop)
   - Smooth animations and transitions
   - Accessible components

5. **Advanced Features**
   - Search and filtering
   - Pagination or infinite scroll
   - Form validation
   - Image handling
   - Real-time updates (optional)

### Technical Requirements

- **Framework**: React or Vue.js
- **State Management**: Context API, Redux, or Vuex
- **Routing**: React Router or Vue Router
- **Styling**: CSS Modules, Styled Components, or Tailwind CSS
- **API**: Axios or Fetch API
- **Build Tool**: Vite, Create React App, or Vue CLI
- **Performance**: Code splitting, lazy loading
- **Responsive**: Mobile-first design

---

## Project Ideas

Choose one of these or create your own:

### Option 1: Movie Database App
- Browse movies and TV shows
- Search functionality
- Movie details with cast and reviews
- Watchlist/favorites
- User ratings

### Option 2: Recipe Finder App
- Search recipes by ingredients
- Recipe details with instructions
- Save favorite recipes
- Meal planning
- Shopping list generation

### Option 3: News Aggregator
- Multiple news sources
- Category filtering
- Article reading view
- Bookmark articles
- Search functionality

### Option 4: Music Discovery App
- Browse artists and albums
- Playlist creation
- Search songs
- Recently played
- Favorite tracks

### Option 5: Job Board Application
- Browse job listings
- Filter by location, type, salary
- Save jobs
- Application tracking
- Company profiles

---

## Recommended Project: Movie Database App

We'll use a Movie Database App as our example. You can adapt this to any of the options above.

---

## Project Structure

```
movie-database-app/
├── public/
│   └── index.html
├── src/
│   ├── components/
│   │   ├── Layout/
│   │   │   ├── Header.jsx
│   │   │   ├── Navigation.jsx
│   │   │   └── Footer.jsx
│   │   ├── Movie/
│   │   │   ├── MovieCard.jsx
│   │   │   ├── MovieList.jsx
│   │   │   ├── MovieDetail.jsx
│   │   │   └── MovieSearch.jsx
│   │   ├── Common/
│   │   │   ├── Loading.jsx
│   │   │   ├── Error.jsx
│   │   │   ├── Pagination.jsx
│   │   │   └── FilterBar.jsx
│   │   └── Watchlist/
│   │       └── WatchlistButton.jsx
│   ├── pages/
│   │   ├── Home.jsx
│   │   ├── Movies.jsx
│   │   ├── MovieDetail.jsx
│   │   ├── Watchlist.jsx
│   │   ├── Search.jsx
│   │   └── About.jsx
│   ├── context/
│   │   ├── MovieContext.jsx
│   │   └── WatchlistContext.jsx
│   ├── hooks/
│   │   ├── useMovies.js
│   │   ├── useLocalStorage.js
│   │   └── useDebounce.js
│   ├── services/
│   │   └── api.js
│   ├── utils/
│   │   └── helpers.js
│   ├── styles/
│   │   ├── App.css
│   │   └── components.css
│   ├── App.jsx
│   └── index.js
└── package.json
```

---

## Step-by-Step Implementation

### Phase 1: Project Setup

```bash
# Create React app with Vite
npm create vite@latest movie-database-app -- --template react
cd movie-database-app
npm install

# Install dependencies
npm install react-router-dom axios date-fns
npm install --save-dev @vitejs/plugin-react

# Start development server
npm run dev
```

### Phase 2: API Service

```javascript
// src/services/api.js
import axios from 'axios';

// Using The Movie Database (TMDB) API
// Sign up at https://www.themoviedb.org/ to get API key
const API_KEY = process.env.REACT_APP_TMDB_API_KEY || 'your-api-key';
const BASE_URL = 'https://api.themoviedb.org/3';
const IMAGE_BASE_URL = 'https://image.tmdb.org/t/p/w500';

const api = axios.create({
    baseURL: BASE_URL,
    params: {
        api_key: API_KEY
    }
});

export const moviesAPI = {
    // Get popular movies
    getPopularMovies: (page = 1) => 
        api.get('/movie/popular', { params: { page } }),
    
    // Get top rated movies
    getTopRatedMovies: (page = 1) => 
        api.get('/movie/top_rated', { params: { page } }),
    
    // Get now playing movies
    getNowPlayingMovies: (page = 1) => 
        api.get('/movie/now_playing', { params: { page } }),
    
    // Get upcoming movies
    getUpcomingMovies: (page = 1) => 
        api.get('/movie/upcoming', { params: { page } }),
    
    // Get movie by ID
    getMovieById: (id) => 
        api.get(`/movie/${id}`),
    
    // Search movies
    searchMovies: (query, page = 1) => 
        api.get('/search/movie', { params: { query, page } }),
    
    // Get movie credits
    getMovieCredits: (id) => 
        api.get(`/movie/${id}/credits`),
    
    // Get movie reviews
    getMovieReviews: (id, page = 1) => 
        api.get(`/movie/${id}/reviews`, { params: { page } }),
    
    // Get similar movies
    getSimilarMovies: (id, page = 1) => 
        api.get(`/movie/${id}/similar`, { params: { page } })
};

export const getImageUrl = (path) => {
    return path ? `${IMAGE_BASE_URL}${path}` : 'https://via.placeholder.com/500';
};

export default api;
```

### Phase 3: Custom Hooks

```javascript
// src/hooks/useMovies.js
import { useState, useEffect } from 'react';
import { moviesAPI } from '../services/api';

export function useMovies(endpoint, page = 1) {
    const [movies, setMovies] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [totalPages, setTotalPages] = useState(1);
    
    useEffect(() => {
        loadMovies();
    }, [endpoint, page]);
    
    const loadMovies = async () => {
        try {
            setLoading(true);
            setError(null);
            const response = await moviesAPI[endpoint](page);
            setMovies(response.data.results);
            setTotalPages(response.data.total_pages);
        } catch (err) {
            setError(err.message);
        } finally {
            setLoading(false);
        }
    };
    
    return { movies, loading, error, totalPages, refetch: loadMovies };
}

export function useMovie(id) {
    const [movie, setMovie] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [credits, setCredits] = useState(null);
    const [reviews, setReviews] = useState([]);
    
    useEffect(() => {
        if (id) {
            loadMovie();
        }
    }, [id]);
    
    const loadMovie = async () => {
        try {
            setLoading(true);
            setError(null);
            
            const [movieRes, creditsRes, reviewsRes] = await Promise.all([
                moviesAPI.getMovieById(id),
                moviesAPI.getMovieCredits(id),
                moviesAPI.getMovieReviews(id)
            ]);
            
            setMovie(movieRes.data);
            setCredits(creditsRes.data);
            setReviews(reviewsRes.data.results);
        } catch (err) {
            setError(err.message);
        } finally {
            setLoading(false);
        }
    };
    
    return { movie, credits, reviews, loading, error };
}

export function useSearchMovies(query, page = 1) {
    const [movies, setMovies] = useState([]);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);
    const [totalPages, setTotalPages] = useState(1);
    
    useEffect(() => {
        if (query.trim()) {
            searchMovies();
        } else {
            setMovies([]);
        }
    }, [query, page]);
    
    const searchMovies = async () => {
        try {
            setLoading(true);
            setError(null);
            const response = await moviesAPI.searchMovies(query, page);
            setMovies(response.data.results);
            setTotalPages(response.data.total_pages);
        } catch (err) {
            setError(err.message);
        } finally {
            setLoading(false);
        }
    };
    
    return { movies, loading, error, totalPages };
}
```

```javascript
// src/hooks/useDebounce.js
import { useState, useEffect } from 'react';

export function useDebounce(value, delay = 500) {
    const [debouncedValue, setDebouncedValue] = useState(value);
    
    useEffect(() => {
        const handler = setTimeout(() => {
            setDebouncedValue(value);
        }, delay);
        
        return () => {
            clearTimeout(handler);
        };
    }, [value, delay]);
    
    return debouncedValue;
}
```

```javascript
// src/hooks/useLocalStorage.js
import { useState, useEffect } from 'react';

export function useLocalStorage(key, initialValue) {
    const [storedValue, setStoredValue] = useState(() => {
        try {
            const item = window.localStorage.getItem(key);
            return item ? JSON.parse(item) : initialValue;
        } catch (error) {
            return initialValue;
        }
    });
    
    const setValue = (value) => {
        try {
            const valueToStore = value instanceof Function ? value(storedValue) : value;
            setStoredValue(valueToStore);
            window.localStorage.setItem(key, JSON.stringify(valueToStore));
        } catch (error) {
            console.error(error);
        }
    };
    
    return [storedValue, setValue];
}
```

### Phase 4: Context Providers

```javascript
// src/context/WatchlistContext.jsx
import { createContext, useContext } from 'react';
import { useLocalStorage } from '../hooks/useLocalStorage';

const WatchlistContext = createContext();

export function WatchlistProvider({ children }) {
    const [watchlist, setWatchlist] = useLocalStorage('watchlist', []);
    
    const addToWatchlist = (movie) => {
        if (!watchlist.find(m => m.id === movie.id)) {
            setWatchlist([...watchlist, movie]);
        }
    };
    
    const removeFromWatchlist = (movieId) => {
        setWatchlist(watchlist.filter(m => m.id !== movieId));
    };
    
    const isInWatchlist = (movieId) => {
        return watchlist.some(m => m.id === movieId);
    };
    
    return (
        <WatchlistContext.Provider
            value={{
                watchlist,
                addToWatchlist,
                removeFromWatchlist,
                isInWatchlist
            }}
        >
            {children}
        </WatchlistContext.Provider>
    );
}

export function useWatchlist() {
    const context = useContext(WatchlistContext);
    if (!context) {
        throw new Error('useWatchlist must be used within WatchlistProvider');
    }
    return context;
}
```

### Phase 5: Components

```javascript
// src/components/Movie/MovieCard.jsx
import { Link } from 'react-router-dom';
import { getImageUrl } from '../../services/api';
import { useWatchlist } from '../../context/WatchlistContext';
import './MovieCard.css';

function MovieCard({ movie }) {
    const { addToWatchlist, removeFromWatchlist, isInWatchlist } = useWatchlist();
    const inWatchlist = isInWatchlist(movie.id);
    
    const handleWatchlistToggle = (e) => {
        e.preventDefault();
        if (inWatchlist) {
            removeFromWatchlist(movie.id);
        } else {
            addToWatchlist(movie);
        }
    };
    
    return (
        <div className="movie-card">
            <Link to={`/movie/${movie.id}`} className="movie-link">
                <div className="movie-image-container">
                    <img
                        src={getImageUrl(movie.poster_path)}
                        alt={movie.title}
                        className="movie-image"
                    />
                    <div className="movie-overlay">
                        <div className="movie-rating">
                            ⭐ {movie.vote_average?.toFixed(1)}
                        </div>
                    </div>
                </div>
                <div className="movie-info">
                    <h3 className="movie-title">{movie.title}</h3>
                    <p className="movie-date">
                        {movie.release_date ? new Date(movie.release_date).getFullYear() : 'N/A'}
                    </p>
                </div>
            </Link>
            <button
                onClick={handleWatchlistToggle}
                className={`watchlist-btn ${inWatchlist ? 'active' : ''}`}
                title={inWatchlist ? 'Remove from watchlist' : 'Add to watchlist'}
            >
                {inWatchlist ? '✓' : '+'}
            </button>
        </div>
    );
}

export default MovieCard;
```

```javascript
// src/components/Movie/MovieList.jsx
import { lazy, Suspense } from 'react';
import MovieCard from './MovieCard';
import Loading from '../Common/Loading';
import './MovieList.css';

const MovieCardLazy = lazy(() => import('./MovieCard'));

function MovieList({ movies, loading }) {
    if (loading) {
        return <Loading />;
    }
    
    if (movies.length === 0) {
        return (
            <div className="no-movies">
                <p>No movies found</p>
            </div>
        );
    }
    
    return (
        <div className="movie-list">
            <Suspense fallback={<Loading />}>
                {movies.map(movie => (
                    <MovieCard key={movie.id} movie={movie} />
                ))}
            </Suspense>
        </div>
    );
}

export default MovieList;
```

```javascript
// src/components/Movie/MovieDetail.jsx
import { useMovie } from '../../hooks/useMovies';
import { getImageUrl } from '../../services/api';
import { format } from 'date-fns';
import Loading from '../Common/Loading';
import Error from '../Common/Error';
import './MovieDetail.css';

function MovieDetail({ movieId }) {
    const { movie, credits, reviews, loading, error } = useMovie(movieId);
    
    if (loading) {
        return <Loading />;
    }
    
    if (error) {
        return <Error message={error} />;
    }
    
    if (!movie) {
        return <Error message="Movie not found" />;
    }
    
    return (
        <div className="movie-detail">
            <div className="movie-detail-hero">
                <img
                    src={getImageUrl(movie.backdrop_path)}
                    alt={movie.title}
                    className="movie-backdrop"
                />
                <div className="movie-detail-content">
                    <div className="movie-detail-poster">
                        <img
                            src={getImageUrl(movie.poster_path)}
                            alt={movie.title}
                        />
                    </div>
                    <div className="movie-detail-info">
                        <h1>{movie.title}</h1>
                        <div className="movie-meta">
                            <span>⭐ {movie.vote_average?.toFixed(1)}</span>
                            <span>•</span>
                            <span>{movie.runtime} min</span>
                            <span>•</span>
                            <span>{format(new Date(movie.release_date), 'yyyy')}</span>
                        </div>
                        <div className="movie-genres">
                            {movie.genres?.map(genre => (
                                <span key={genre.id} className="genre-tag">
                                    {genre.name}
                                </span>
                            ))}
                        </div>
                        <p className="movie-overview">{movie.overview}</p>
                    </div>
                </div>
            </div>
            
            {credits && credits.cast && (
                <section className="movie-cast">
                    <h2>Cast</h2>
                    <div className="cast-list">
                        {credits.cast.slice(0, 10).map(actor => (
                            <div key={actor.id} className="cast-item">
                                <img
                                    src={getImageUrl(actor.profile_path)}
                                    alt={actor.name}
                                />
                                <p className="actor-name">{actor.name}</p>
                                <p className="character-name">{actor.character}</p>
                            </div>
                        ))}
                    </div>
                </section>
            )}
            
            {reviews.length > 0 && (
                <section className="movie-reviews">
                    <h2>Reviews</h2>
                    <div className="reviews-list">
                        {reviews.map(review => (
                            <div key={review.id} className="review-item">
                                <div className="review-header">
                                    <strong>{review.author}</strong>
                                    <span>{format(new Date(review.created_at), 'MMM dd, yyyy')}</span>
                                </div>
                                <p>{review.content}</p>
                            </div>
                        ))}
                    </div>
                </section>
            )}
        </div>
    );
}

export default MovieDetail;
```

```javascript
// src/components/Movie/MovieSearch.jsx
import { useState, useEffect } from 'react';
import { useSearchMovies } from '../../hooks/useMovies';
import { useDebounce } from '../../hooks/useDebounce';
import MovieList from './MovieList';
import Pagination from '../Common/Pagination';
import './MovieSearch.css';

function MovieSearch() {
    const [searchQuery, setSearchQuery] = useState('');
    const [page, setPage] = useState(1);
    const debouncedQuery = useDebounce(searchQuery, 500);
    const { movies, loading, error, totalPages } = useSearchMovies(debouncedQuery, page);
    
    useEffect(() => {
        setPage(1);
    }, [debouncedQuery]);
    
    return (
        <div className="movie-search">
            <div className="search-container">
                <input
                    type="text"
                    value={searchQuery}
                    onChange={(e) => setSearchQuery(e.target.value)}
                    placeholder="Search movies..."
                    className="search-input"
                />
            </div>
            
            {debouncedQuery && (
                <>
                    <h2>Search Results for "{debouncedQuery}"</h2>
                    <MovieList movies={movies} loading={loading} />
                    {totalPages > 1 && (
                        <Pagination
                            currentPage={page}
                            totalPages={totalPages}
                            onPageChange={setPage}
                        />
                    )}
                </>
            )}
        </div>
    );
}

export default MovieSearch;
```

```javascript
// src/components/Common/Pagination.jsx
import './Pagination.css';

function Pagination({ currentPage, totalPages, onPageChange }) {
    const getPageNumbers = () => {
        const pages = [];
        const maxVisible = 5;
        let start = Math.max(1, currentPage - Math.floor(maxVisible / 2));
        let end = Math.min(totalPages, start + maxVisible - 1);
        
        if (end - start < maxVisible - 1) {
            start = Math.max(1, end - maxVisible + 1);
        }
        
        for (let i = start; i <= end; i++) {
            pages.push(i);
        }
        
        return pages;
    };
    
    return (
        <div className="pagination">
            <button
                onClick={() => onPageChange(currentPage - 1)}
                disabled={currentPage === 1}
                className="pagination-btn"
            >
                Previous
            </button>
            
            <div className="pagination-numbers">
                {getPageNumbers().map(page => (
                    <button
                        key={page}
                        onClick={() => onPageChange(page)}
                        className={`pagination-btn ${currentPage === page ? 'active' : ''}`}
                    >
                        {page}
                    </button>
                ))}
            </div>
            
            <button
                onClick={() => onPageChange(currentPage + 1)}
                disabled={currentPage === totalPages}
                className="pagination-btn"
            >
                Next
            </button>
        </div>
    );
}

export default Pagination;
```

### Phase 6: Pages

```javascript
// src/pages/Home.jsx
import { Link } from 'react-router-dom';
import { useMovies } from '../hooks/useMovies';
import MovieList from '../components/Movie/MovieList';
import './Home.css';

function Home() {
    const { movies, loading } = useMovies('getPopularMovies', 1);
    
    return (
        <div className="home">
            <section className="hero">
                <h1>Discover Amazing Movies</h1>
                <p>Explore the latest and greatest films</p>
                <Link to="/movies" className="btn btn-primary">
                    Browse Movies
                </Link>
            </section>
            
            <section className="featured-section">
                <h2>Popular Movies</h2>
                <MovieList movies={movies} loading={loading} />
                <div className="section-footer">
                    <Link to="/movies" className="btn btn-link">
                        View All Movies →
                    </Link>
                </div>
            </section>
        </div>
    );
}

export default Home;
```

```javascript
// src/pages/Movies.jsx
import { useState } from 'react';
import { useMovies } from '../hooks/useMovies';
import MovieList from '../components/Movie/MovieList';
import FilterBar from '../components/Common/FilterBar';
import Pagination from '../components/Common/Pagination';
import './Movies.css';

const FILTERS = {
    popular: 'getPopularMovies',
    topRated: 'getTopRatedMovies',
    nowPlaying: 'getNowPlayingMovies',
    upcoming: 'getUpcomingMovies'
};

function Movies() {
    const [filter, setFilter] = useState('popular');
    const [page, setPage] = useState(1);
    const { movies, loading, totalPages } = useMovies(FILTERS[filter], page);
    
    return (
        <div className="movies-page">
            <h1>Movies</h1>
            
            <FilterBar
                filters={[
                    { key: 'popular', label: 'Popular' },
                    { key: 'topRated', label: 'Top Rated' },
                    { key: 'nowPlaying', label: 'Now Playing' },
                    { key: 'upcoming', label: 'Upcoming' }
                ]}
                activeFilter={filter}
                onFilterChange={setFilter}
            />
            
            <MovieList movies={movies} loading={loading} />
            
            {totalPages > 1 && (
                <Pagination
                    currentPage={page}
                    totalPages={totalPages}
                    onPageChange={setPage}
                />
            )}
        </div>
    );
}

export default Movies;
```

```javascript
// src/pages/MovieDetail.jsx
import { useParams } from 'react-router-dom';
import MovieDetail from '../components/Movie/MovieDetail';
import './MovieDetailPage.css';

function MovieDetailPage() {
    const { id } = useParams();
    
    return (
        <div className="movie-detail-page">
            <MovieDetail movieId={id} />
        </div>
    );
}

export default MovieDetailPage;
```

```javascript
// src/pages/Watchlist.jsx
import { useWatchlist } from '../context/WatchlistContext';
import MovieList from '../components/Movie/MovieList';
import './Watchlist.css';

function Watchlist() {
    const { watchlist } = useWatchlist();
    
    return (
        <div className="watchlist-page">
            <h1>My Watchlist</h1>
            {watchlist.length === 0 ? (
                <div className="empty-watchlist">
                    <p>Your watchlist is empty</p>
                    <p>Start adding movies to your watchlist!</p>
                </div>
            ) : (
                <MovieList movies={watchlist} loading={false} />
            )}
        </div>
    );
}

export default Watchlist;
```

```javascript
// src/pages/Search.jsx
import MovieSearch from '../components/Movie/MovieSearch';
import './Search.css';

function Search() {
    return (
        <div className="search-page">
            <h1>Search Movies</h1>
            <MovieSearch />
        </div>
    );
}

export default Search;
```

### Phase 7: App Component with Routing

```javascript
// src/App.jsx
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import { lazy, Suspense } from 'react';
import { WatchlistProvider } from './context/WatchlistContext';
import Layout from './components/Layout/Layout';
import Loading from './components/Common/Loading';
import './App.css';

// Lazy load pages for code splitting
const Home = lazy(() => import('./pages/Home'));
const Movies = lazy(() => import('./pages/Movies'));
const MovieDetail = lazy(() => import('./pages/MovieDetail'));
const Watchlist = lazy(() => import('./pages/Watchlist'));
const Search = lazy(() => import('./pages/Search'));
const About = lazy(() => import('./pages/About'));

function App() {
    return (
        <WatchlistProvider>
            <BrowserRouter>
                <Layout>
                    <Suspense fallback={<Loading />}>
                        <Routes>
                            <Route path="/" element={<Home />} />
                            <Route path="/movies" element={<Movies />} />
                            <Route path="/movie/:id" element={<MovieDetail />} />
                            <Route path="/watchlist" element={<Watchlist />} />
                            <Route path="/search" element={<Search />} />
                            <Route path="/about" element={<About />} />
                        </Routes>
                    </Suspense>
                </Layout>
            </BrowserRouter>
        </WatchlistProvider>
    );
}

export default App;
```

### Phase 8: Layout Component

```javascript
// src/components/Layout/Layout.jsx
import Header from './Header';
import Footer from './Footer';
import './Layout.css';

function Layout({ children }) {
    return (
        <div className="layout">
            <Header />
            <main className="main-content">
                {children}
            </main>
            <Footer />
        </div>
    );
}

export default Layout;
```

```javascript
// src/components/Layout/Header.jsx
import { Link, useLocation } from 'react-router-dom';
import { useWatchlist } from '../../context/WatchlistContext';
import './Header.css';

function Header() {
    const location = useLocation();
    const { watchlist } = useWatchlist();
    
    const isActive = (path) => location.pathname === path;
    
    return (
        <header className="header">
            <div className="header-container">
                <Link to="/" className="logo">
                    🎬 MovieDB
                </Link>
                <nav className="nav">
                    <Link
                        to="/"
                        className={`nav-link ${isActive('/') ? 'active' : ''}`}
                    >
                        Home
                    </Link>
                    <Link
                        to="/movies"
                        className={`nav-link ${isActive('/movies') ? 'active' : ''}`}
                    >
                        Movies
                    </Link>
                    <Link
                        to="/search"
                        className={`nav-link ${isActive('/search') ? 'active' : ''}`}
                    >
                        Search
                    </Link>
                    <Link
                        to="/watchlist"
                        className={`nav-link ${isActive('/watchlist') ? 'active' : ''}`}
                    >
                        Watchlist
                        {watchlist.length > 0 && (
                            <span className="badge">{watchlist.length}</span>
                        )}
                    </Link>
                    <Link
                        to="/about"
                        className={`nav-link ${isActive('/about') ? 'active' : ''}`}
                    >
                        About
                    </Link>
                </nav>
            </div>
        </header>
    );
}

export default Header;
```

---

## Features Implementation

### State Management

- **Watchlist Context**: Global watchlist state
- **Custom Hooks**: Reusable data fetching hooks
- **Local Storage**: Persist watchlist
- **Optimistic Updates**: Immediate UI feedback

### Routing

- **React Router**: Client-side routing
- **Lazy Loading**: Code splitting for performance
- **Dynamic Routes**: Movie detail pages
- **Navigation**: Smooth page transitions

### API Integration

- **TMDB API**: External movie database
- **Error Handling**: Graceful error handling
- **Loading States**: User feedback
- **Caching**: Reduce API calls

### Responsive Design

- **Mobile-First**: Start with mobile
- **Flexible Layouts**: Grid and flexbox
- **Breakpoints**: Multiple screen sizes
- **Touch-Friendly**: Large tap targets

---

## Performance Optimization

### Code Splitting

```javascript
// Lazy load components
const MovieDetail = lazy(() => import('./pages/MovieDetail'));
```

### Image Optimization

```javascript
// Use different image sizes
const getImageUrl = (path, size = 'w500') => {
    return path ? `https://image.tmdb.org/t/p/${size}${path}` : placeholder;
};
```

### Memoization

```javascript
import { useMemo } from 'react';

const filteredMovies = useMemo(() => {
    return movies.filter(movie => /* filter logic */);
}, [movies, filter]);
```

---

## Testing Your Application

### Manual Testing Checklist

- [ ] Navigate between all routes
- [ ] Search functionality works
- [ ] Add/remove from watchlist
- [ ] Pagination works
- [ ] Filter movies
- [ ] View movie details
- [ ] Responsive on mobile
- [ ] Loading states display
- [ ] Error handling works
- [ ] Performance is good

---

## Deployment

### Build for Production

```bash
npm run build
```

### Deploy to Vercel

```bash
# Install Vercel CLI
npm install -g vercel

# Deploy
vercel

# Set environment variables
vercel env add REACT_APP_TMDB_API_KEY
```

### Deploy to Netlify

```bash
# Install Netlify CLI
npm install -g netlify-cli

# Deploy
netlify deploy --prod

# Set environment variables in Netlify dashboard
```

---

## Exercise: Single Page Application

**Instructions**:

1. Choose your project idea
2. Set up React/Vue project
3. Plan your routes and state
4. Implement all features
5. Optimize performance
6. Test thoroughly
7. Deploy to production

**Timeline**: 2-3 weeks recommended

---

## Evaluation Criteria

Your project will be evaluated on:

1. **Functionality** (30%)
   - All features work correctly
   - Smooth navigation
   - No critical bugs

2. **State Management** (20%)
   - Proper state organization
   - Efficient updates
   - State persistence

3. **Routing** (15%)
   - All routes work
   - Navigation is smooth
   - Protected routes (if applicable)

4. **API Integration** (15%)
   - Proper API usage
   - Error handling
   - Loading states

5. **Design & UX** (15%)
   - Modern, polished design
   - Responsive layout
   - Good user experience

6. **Performance** (5%)
   - Fast load times
   - Smooth interactions
   - Optimized code

---

## Common Issues and Solutions

### Issue: Slow performance

**Solution**: Implement code splitting, lazy loading, and memoization.

### Issue: API rate limiting

**Solution**: Implement caching and debouncing for search.

### Issue: Routing not working

**Solution**: Ensure BrowserRouter wraps the app and routes are correct.

---

## Quiz: SPA Concepts

1. **SPA:**
   - A) Single Page Application
   - B) Multiple pages
   - C) Both
   - D) Neither

2. **State management:**
   - A) Important for SPAs
   - B) Not important
   - C) Both
   - D) Neither

3. **Routing:**
   - A) Client-side navigation
   - B) Server-side navigation
   - C) Both
   - D) Neither

4. **Code splitting:**
   - A) Improves performance
   - B) Doesn't improve performance
   - C) Both
   - D) Neither

5. **Responsive design:**
   - A) Works on all devices
   - B) Desktop only
   - C) Both
   - D) Neither

**Answers**:
1. A) Single Page Application
2. A) Important for SPAs
3. A) Client-side navigation
4. A) Improves performance
5. A) Works on all devices

---

## Key Takeaways

1. **SPA Architecture**: Single page with client-side routing
2. **State Management**: Critical for complex apps
3. **Routing**: Smooth navigation without page reloads
4. **API Integration**: Connect to external services
5. **Performance**: Optimize with code splitting and lazy loading
6. **Best Practice**: Clean code, good UX, responsive design

---

## Next Steps

Congratulations! You've built a Single Page Application. You now know:
- How to build complex SPAs
- How to manage state effectively
- How to implement routing
- How to integrate with APIs
- How to optimize performance

**What's Next?**
- Capstone Project 3: Real-Time Application
- Learn WebSocket integration
- Build real-time features
- Create advanced applications

---

*Capstone Project completed! You've demonstrated mastery of modern frontend development!*

