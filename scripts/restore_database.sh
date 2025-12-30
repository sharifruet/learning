#!/bin/bash

# Database Restore Script
# Usage: ./restore_database.sh <backup_file>

# Configuration
DB_NAME="python_learn"
DB_USER="python_user"
DB_PASS="python_pass"
DB_HOST="localhost"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if backup file is provided
if [ -z "$1" ]; then
    echo -e "${RED}Error: Backup file not specified${NC}"
    echo "Usage: ./restore_database.sh <backup_file>"
    echo "Example: ./restore_database.sh backups/db_backup_20240101_120000.sql.gz"
    exit 1
fi

BACKUP_FILE=$1

# Check if backup file exists
if [ ! -f "$BACKUP_FILE" ]; then
    echo -e "${RED}Error: Backup file not found: $BACKUP_FILE${NC}"
    exit 1
fi

echo -e "${YELLOW}WARNING: This will overwrite the current database!${NC}"
read -p "Are you sure you want to continue? (yes/no): " CONFIRM

if [ "$CONFIRM" != "yes" ]; then
    echo -e "${YELLOW}Restore cancelled.${NC}"
    exit 0
fi

echo -e "${YELLOW}Starting database restore from: $BACKUP_FILE${NC}"

# Check if running in Docker
if command -v docker-compose &> /dev/null; then
    echo -e "${YELLOW}Using Docker Compose...${NC}"
    if [[ $BACKUP_FILE == *.gz ]]; then
        gunzip < $BACKUP_FILE | docker-compose exec -T db mysql -u $DB_USER -p$DB_PASS $DB_NAME
    else
        docker-compose exec -T db mysql -u $DB_USER -p$DB_PASS $DB_NAME < $BACKUP_FILE
    fi
else
    echo -e "${YELLOW}Using local MySQL...${NC}"
    if [[ $BACKUP_FILE == *.gz ]]; then
        gunzip < $BACKUP_FILE | mysql -h $DB_HOST -u $DB_USER -p$DB_PASS $DB_NAME
    else
        mysql -h $DB_HOST -u $DB_USER -p$DB_PASS $DB_NAME < $BACKUP_FILE
    fi
fi

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Database restored successfully!${NC}"
else
    echo -e "${RED}✗ Restore failed!${NC}"
    exit 1
fi

