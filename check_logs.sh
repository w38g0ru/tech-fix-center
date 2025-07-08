#!/bin/bash

# TFC Production Error Log Checker
# Run this script on your production server to check for errors

echo "🔍 TFC Production Error Log Analysis"
echo "====================================="

# Function to check if file exists and show last lines
check_log() {
    local logfile=$1
    local description=$2
    
    if [ -f "$logfile" ]; then
        echo ""
        echo "📄 $description ($logfile)"
        echo "----------------------------------------"
        echo "Last 20 lines:"
        tail -20 "$logfile" | grep -E "(error|Error|ERROR|fatal|Fatal|FATAL|exception|Exception|EXCEPTION)" --color=always || echo "No recent errors found"
        echo ""
    else
        echo "❌ $description not found at $logfile"
    fi
}

# Check various log locations
echo "Checking common error log locations..."

# Apache logs
check_log "/var/log/apache2/error.log" "Apache Error Log"
check_log "/var/log/httpd/error_log" "Apache Error Log (Alternative)"
check_log "/var/log/apache2/access.log" "Apache Access Log"

# Nginx logs
check_log "/var/log/nginx/error.log" "Nginx Error Log"
check_log "/var/log/nginx/access.log" "Nginx Access Log"

# PHP logs
check_log "/var/log/php_errors.log" "PHP Error Log"
check_log "/var/log/php/error.log" "PHP Error Log (Alternative)"

# CodeIgniter logs
if [ -d "writable/logs" ]; then
    echo ""
    echo "📄 CodeIgniter Application Logs"
    echo "----------------------------------------"
    for logfile in writable/logs/*.log; do
        if [ -f "$logfile" ]; then
            echo "Checking $logfile:"
            tail -10 "$logfile" | grep -E "(ERROR|CRITICAL|EMERGENCY)" --color=always || echo "No critical errors"
            echo ""
        fi
    done
else
    echo "❌ CodeIgniter logs directory not found (writable/logs)"
fi

# Check system logs for PHP/Apache
echo ""
echo "📄 System Logs (Recent PHP/Apache entries)"
echo "----------------------------------------"
journalctl -u apache2 --since "1 hour ago" --no-pager | tail -10 2>/dev/null || echo "No systemd logs available"

# Check for specific TFC-related errors
echo ""
echo "🔍 Searching for TFC-specific errors..."
echo "----------------------------------------"

# Search in Apache logs for TFC domain
if [ -f "/var/log/apache2/error.log" ]; then
    grep -i "tfc.gaighat.com" /var/log/apache2/error.log | tail -5 || echo "No TFC-specific errors in Apache log"
fi

# Search for PHP fatal errors
if [ -f "/var/log/apache2/error.log" ]; then
    grep -i "fatal error" /var/log/apache2/error.log | tail -5 || echo "No PHP fatal errors found"
fi

# Check disk space
echo ""
echo "💾 Disk Space Check"
echo "----------------------------------------"
df -h | grep -E "(Filesystem|/dev/)"

# Check file permissions
echo ""
echo "🔐 File Permissions Check"
echo "----------------------------------------"
if [ -d "writable" ]; then
    echo "writable/ directory permissions:"
    ls -la writable/ | head -5
else
    echo "❌ writable/ directory not found"
fi

if [ -f ".env" ]; then
    echo ".env file permissions:"
    ls -la .env
else
    echo "❌ .env file not found"
fi

echo ""
echo "✅ Log analysis complete!"
echo ""
echo "🎯 Next steps:"
echo "1. Review any errors shown above"
echo "2. Check database connectivity"
echo "3. Verify .env configuration"
echo "4. Ensure proper file permissions"
echo ""
echo "For detailed diagnostics, upload and run production_debug.php"
