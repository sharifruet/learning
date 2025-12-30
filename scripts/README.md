# Database Scripts

This directory contains utility scripts for database management.

## Scripts

### backup_database.sh

Creates a compressed backup of the database.

**Usage:**
```bash
./backup_database.sh
```

**Features:**
- Automatic date/time stamping
- Gzip compression
- Automatic cleanup (keeps last 7 days)
- Supports Docker and local MySQL
- Colored output for easy reading

**Output:**
- Backups stored in `./backups/` directory
- Format: `db_backup_YYYYMMDD_HHMMSS.sql.gz`

### restore_database.sh

Restores database from a backup file.

**Usage:**
```bash
./restore_database.sh <backup_file>
```

**Example:**
```bash
./restore_database.sh backups/db_backup_20240101_120000.sql.gz
```

**Features:**
- Safety confirmation prompt
- Supports .sql and .sql.gz files
- Supports Docker and local MySQL
- Error handling

**Warning:** This will overwrite the current database!

### run_migrations.sh

Runs database migrations.

**Usage:**
```bash
./run_migrations.sh
```

**Features:**
- Supports Docker and local PHP
- Error handling
- Status reporting

## Setup

### Linux/Unix/Mac

Make scripts executable:
```bash
chmod +x scripts/*.sh
```

### Windows

Scripts can be run using Git Bash or WSL (Windows Subsystem for Linux).

## Configuration

Edit the scripts to match your database configuration:

- `DB_NAME`: Database name
- `DB_USER`: Database username
- `DB_PASS`: Database password
- `DB_HOST`: Database host (usually localhost)

## Automated Backups

### Using Cron (Linux/Unix)

Add to crontab for daily backups at 2 AM:
```bash
0 2 * * * /path/to/scripts/backup_database.sh
```

### Using Task Scheduler (Windows)

Create a scheduled task to run the backup script daily.

## Notes

- Scripts use colored output for better readability
- All scripts include error handling
- Backup directory is created automatically
- Old backups are automatically cleaned up (7 days retention)

