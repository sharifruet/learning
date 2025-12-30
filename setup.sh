#!/bin/bash

echo "Setting up Python Learning Application..."

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo "Error: Docker is not running. Please start Docker and try again."
    exit 1
fi

# Build and start containers
echo "Building Docker containers..."
docker-compose build

echo "Starting Docker containers..."
docker-compose up -d

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
sleep 10

# Install Composer dependencies
echo "Installing Composer dependencies..."
docker-compose exec web composer install --no-interaction

# Run database migrations
echo "Running database migrations..."
docker-compose exec web php spark migrate

# Run database seeds
echo "Seeding database..."
docker-compose exec web php spark db:seed DatabaseSeeder

# Set permissions
echo "Setting file permissions..."
docker-compose exec web chmod -R 755 writable
docker-compose exec web chown -R www-data:www-data writable

echo ""
echo "Setup complete!"
echo ""
echo "Application is available at: http://localhost:8080"
echo ""
echo "Default admin credentials:"
echo "  Email: admin@pythonlearn.com"
echo "  Password: admin123"
echo ""
echo "Default student credentials:"
echo "  Email: student@pythonlearn.com"
echo "  Password: student123"
echo ""
echo "To view logs: docker-compose logs -f"
echo "To stop: docker-compose down"

