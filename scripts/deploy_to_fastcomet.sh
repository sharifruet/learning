#!/bin/bash

# FastComet Deployment Script
# This script helps prepare files for deployment to FastComet shared hosting

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}FastComet Deployment Preparation${NC}"
echo "========================================"
echo ""

# Check if we're in the project root
if [ ! -f "composer.json" ]; then
    echo -e "${RED}Error: composer.json not found. Please run this script from the project root.${NC}"
    exit 1
fi

# Create deployment directory
DEPLOY_DIR="fastcomet_deployment"
echo -e "${YELLOW}Creating deployment directory...${NC}"
rm -rf "$DEPLOY_DIR"
mkdir -p "$DEPLOY_DIR"

# Copy files (excluding unnecessary ones)
echo -e "${YELLOW}Copying files...${NC}"
rsync -av \
  --exclude='.git' \
  --exclude='.gitignore' \
  --exclude='node_modules' \
  --exclude='.env' \
  --exclude='.env.*' \
  --exclude='writable/logs/*' \
  --exclude='writable/session/*' \
  --exclude='writable/uploads/*' \
  --exclude='writable/debugbar/*' \
  --exclude='.DS_Store' \
  --exclude='docker-compose.yml' \
  --exclude='Dockerfile' \
  --exclude='apache-config.conf' \
  --exclude='fastcomet_deployment' \
  --exclude='.vscode' \
  --exclude='.idea' \
  --exclude='*.swp' \
  --exclude='*.swo' \
  ./ "$DEPLOY_DIR/"

# Create necessary directories
echo -e "${YELLOW}Creating necessary directories...${NC}"
mkdir -p "$DEPLOY_DIR/writable/logs"
mkdir -p "$DEPLOY_DIR/writable/session"
mkdir -p "$DEPLOY_DIR/writable/uploads"
mkdir -p "$DEPLOY_DIR/writable/debugbar"
touch "$DEPLOY_DIR/writable/logs/index.html"
touch "$DEPLOY_DIR/writable/session/index.html"
touch "$DEPLOY_DIR/writable/uploads/index.html"
touch "$DEPLOY_DIR/writable/debugbar/index.html"

# Create .env.example for reference
echo -e "${YELLOW}Creating .env.example file...${NC}"
cat > "$DEPLOY_DIR/.env.example" << 'EOF'
#--------------------------------------------------------------------
# ENVIRONMENT
#--------------------------------------------------------------------
CI_ENVIRONMENT = production

#--------------------------------------------------------------------
# APP
#--------------------------------------------------------------------
app.baseURL = 'https://yourdomain.com/'

#--------------------------------------------------------------------
# DATABASE
#--------------------------------------------------------------------
database.default.hostname = localhost
database.default.database = your_database_name
database.default.username = your_database_user
database.default.password = your_database_password
database.default.DBDriver = MySQLi
database.default.port = 3306

#--------------------------------------------------------------------
# SECURITY
#--------------------------------------------------------------------
# Generate encryption key: php spark key:generate
encryption.key = 

#--------------------------------------------------------------------
# OAUTH (Optional)
#--------------------------------------------------------------------
# GOOGLE_CLIENT_ID=your_google_client_id
# GOOGLE_CLIENT_SECRET=your_google_client_secret
# GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback

# FACEBOOK_APP_ID=your_facebook_app_id
# FACEBOOK_APP_SECRET=your_facebook_app_secret
# FACEBOOK_REDIRECT_URI=https://yourdomain.com/auth/facebook/callback
EOF

# Create deployment instructions
echo -e "${YELLOW}Creating deployment instructions...${NC}"
cat > "$DEPLOY_DIR/DEPLOYMENT_INSTRUCTIONS.txt" << 'EOF'
FASTCOMET DEPLOYMENT INSTRUCTIONS
==================================

1. UPLOAD FILES
   - Upload all files in this directory to your FastComet public_html/
   - Use cPanel File Manager, FTP, or SFTP

2. SET DOCUMENT ROOT
   - In cPanel → Domains → Manage Domains
   - Set document root to: public_html/public
   - OR move public/* contents to public_html/ root

3. CREATE .ENV FILE
   - Copy .env.example to .env
   - Update with your FastComet database credentials
   - Update app.baseURL with your domain

4. SET PHP VERSION
   - cPanel → Select PHP Version
   - Choose PHP 8.1 or higher
   - Enable extensions: pdo_mysql, mysqli, mbstring, exif, pcntl, bcmath, gd, intl

5. INSTALL DEPENDENCIES
   - If Composer available: composer install --no-dev --optimize-autoloader
   - If not: Upload vendor/ folder from your local installation

6. SET PERMISSIONS
   - chmod -R 755 writable/
   - chmod 644 .env

7. GENERATE ENCRYPTION KEY
   - php spark key:generate

8. IMPORT DATABASE
   - Export from local: docker-compose exec db mysqldump -uroot -prootpassword python_learn > db_backup.sql
   - Import via cPanel phpMyAdmin

9. CONFIGURE SSL
   - cPanel → SSL/TLS → Install Let's Encrypt
   - Enable Force HTTPS Redirect

10. TEST APPLICATION
    - Visit your domain
    - Test course catalog, login, and admin panel

For detailed instructions, see FASTCOMET_DEPLOYMENT.md
EOF

# Create database export script
echo -e "${YELLOW}Creating database export helper...${NC}"
cat > "export_database.sh" << 'EOF'
#!/bin/bash
# Export database for FastComet deployment

echo "Exporting database..."
docker-compose exec -T db mysqldump -uroot -prootpassword python_learn > fastcomet_deployment/database_backup.sql

echo "Database exported to: fastcomet_deployment/database_backup.sql"
echo ""
echo "Next steps:"
echo "1. Upload database_backup.sql to FastComet"
echo "2. Import via cPanel phpMyAdmin"
EOF
chmod +x export_database.sh

# Create archive
echo -e "${YELLOW}Creating deployment archive...${NC}"
tar -czf "${DEPLOY_DIR}.tar.gz" "$DEPLOY_DIR"

# Calculate size
SIZE=$(du -sh "$DEPLOY_DIR" | cut -f1)
ARCHIVE_SIZE=$(du -sh "${DEPLOY_DIR}.tar.gz" | cut -f1)

echo ""
echo -e "${GREEN}✓ Deployment package created!${NC}"
echo ""
echo "Package details:"
echo "  Directory: $DEPLOY_DIR/"
echo "  Archive: ${DEPLOY_DIR}.tar.gz"
echo "  Size: $SIZE (directory), $ARCHIVE_SIZE (archive)"
echo ""
echo "Next steps:"
echo "  1. Export database: ./export_database.sh"
echo "  2. Upload ${DEPLOY_DIR}.tar.gz to FastComet"
echo "  3. Extract in public_html/"
echo "  4. Follow DEPLOYMENT_INSTRUCTIONS.txt"
echo ""
echo -e "${YELLOW}Note: Don't forget to create .env file on the server!${NC}"

