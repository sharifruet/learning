#!/bin/bash

# Database Backup Script
# Usage: ./backup_database.sh

# Configuration
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="./backups"
DB_NAME="python_learn"
DB_USER="python_user"
DB_PASS="python_pass"
DB_HOST="localhost"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Create backup directory if it doesn't exist
mkdir -p $BACKUP_DIR

echo -e "${YELLOW}Starting database backup...${NC}"

# Check if running in Docker
if command -v docker-compose &> /dev/null; then
    echo -e "${YELLOW}Using Docker Compose...${NC}"
    docker-compose exec -T db mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/db_backup_$DATE.sql.gz
else
    echo -e "${YELLOW}Using local MySQL...${NC}"
    mysqldump -h $DB_HOST -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/db_backup_$DATE.sql.gz
fi

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Backup completed successfully: db_backup_$DATE.sql.gz${NC}"
    
    # Get file size
    FILE_SIZE=$(du -h $BACKUP_DIR/db_backup_$DATE.sql.gz | cut -f1)
    echo -e "${GREEN}  File size: $FILE_SIZE${NC}"
    
    # Keep only last 7 days of backups
    echo -e "${YELLOW}Cleaning up old backups (keeping last 7 days)...${NC}"
    find $BACKUP_DIR -name "db_backup_*.sql.gz" -mtime +7 -delete
    echo -e "${GREEN}✓ Cleanup completed${NC}"
    
    # List current backups
    echo -e "\n${YELLOW}Current backups:${NC}"
    ls -lh $BACKUP_DIR/db_backup_*.sql.gz 2>/dev/null | awk '{print $9, "(" $5 ")"}'
else
    echo -e "${RED}✗ Backup failed!${NC}"
    exit 1
fi

echo -e "\n${GREEN}Backup process completed!${NC}"

