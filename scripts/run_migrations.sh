#!/bin/bash

# Database Migration Script
# Usage: ./run_migrations.sh

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}Running database migrations...${NC}"

# Check if running in Docker
if command -v docker-compose &> /dev/null; then
    echo -e "${YELLOW}Using Docker Compose...${NC}"
    docker-compose exec web php spark migrate
else
    echo -e "${YELLOW}Using local PHP...${NC}"
    php spark migrate
fi

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Migrations completed successfully!${NC}"
else
    echo -e "${RED}✗ Migration failed!${NC}"
    exit 1
fi

