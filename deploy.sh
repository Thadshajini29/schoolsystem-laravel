#!/usr/bin/env bash
# ==============================================================================
# School Management System - Automated Production Deployment Script
# ==============================================================================

set -e

echo "========================================================="
echo "   Deploying School Management System (Production)       "
echo "========================================================="

# 1. Pull latest changes if git exists
if [ -d ".git" ]; then
    echo "==> Pulling latest repository code..."
    git pull origin main || true
fi

# 2. Build and launch Docker containers
echo "==> Building and starting Docker containers..."
docker compose build --pull
docker compose down --remove-orphans
docker compose up -d

echo "==> Waiting for database and services to report healthy..."
sleep 10

# 3. Verify status
echo "==> Checking running container status..."
docker compose ps

echo "========================================================="
echo " Deployment Complete! School System is live on port 80."
echo "========================================================="
