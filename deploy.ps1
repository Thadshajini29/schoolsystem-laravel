# ==============================================================================
# School Management System - Windows PowerShell Deployment Script
# ==============================================================================

Write-Host "=========================================================" -ForegroundColor Cyan
Write-Host "   Deploying School Management System with Docker        " -ForegroundColor Green
Write-Host "=========================================================" -ForegroundColor Cyan

# Check if Docker is running
try {
    docker info | Out-Null
} catch {
    Write-Error "Docker Desktop does not appear to be running. Please start Docker Desktop and re-run."
    exit 1
}

# Build and start services
Write-Host "==> Building and launching containers..." -ForegroundColor Yellow
docker compose build
docker compose down --remove-orphans
docker compose up -d

Write-Host "==> Checking container status..." -ForegroundColor Yellow
docker compose ps

Write-Host "=========================================================" -ForegroundColor Cyan
Write-Host " Deployment Complete! School System is live at http://localhost" -ForegroundColor Green
Write-Host "=========================================================" -ForegroundColor Cyan
