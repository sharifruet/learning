#!/bin/bash

# Fix File Permissions for FastComet Deployment
# Run this script on your FastComet server (via SSH or adapt for cPanel)

echo "Fixing file permissions for CodeIgniter 4..."

# Navigate to your application root (adjust path if needed)
# cd /home/bandhan1/learning.bandhanhara.com

# Set permissions for writable directory
chmod -R 755 writable/

# Ensure cache directory exists and is writable
mkdir -p writable/cache
chmod 755 writable/cache

# Ensure other writable subdirectories exist
mkdir -p writable/logs
mkdir -p writable/session
mkdir -p writable/uploads
mkdir -p writable/debugbar

# Set permissions
chmod 755 writable/logs
chmod 755 writable/session
chmod 755 writable/uploads
chmod 755 writable/debugbar

# Set .env permissions
chmod 644 .env

echo "Permissions fixed!"
echo ""
echo "If you're using cPanel File Manager:"
echo "1. Navigate to writable/ directory"
echo "2. Right-click → Change Permissions"
echo "3. Set to 755 (or 775 if 755 doesn't work)"
echo "4. Check 'Recurse into subdirectories'"
echo "5. Apply to all subdirectories: cache/, logs/, session/, uploads/"


