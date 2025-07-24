# TeknoPhix Jobs API Documentation

## Overview

Clean, efficient RESTful API for managing jobs with comprehensive relationships to admin_users (technicians), users (customers), and service_centers. Built with CodeIgniter 4 following best practices.

## Base URL
```
Production: https://tfc.gaighat.com/api/v1
Development: http://tfc.local/api/v1
```

## Authentication
All API endpoints require authentication. Include the authentication token in the header:
```
Authorization: Bearer {your-token}
```

## Response Format
All responses follow a consistent JSON structure:

### Success Response
```json
{
    "status": "success",
    "message": "Operation completed successfully",
    "data": {
        // Response data here
    }
}
```

### Error Response
```json
{
    "status": "error",
    "message": "Error description",
    "errors": {
        // Validation errors (if applicable)
    }
}
```

## Jobs API Endpoints

### 1. List Jobs
**GET** `/api/v1/jobs`

Retrieve paginated list of jobs with related data and analytics.

**Query Parameters:**
- `per_page` (int, default: 15) - Items per page
- `page` (int, default: 1) - Page number
- `status` (string) - Filter by job status
- `technician_id` (int) - Filter by technician
- `service_center_id` (int) - Filter by service center
- `date_from` (date) - Filter from date (YYYY-MM-DD)
- `date_to` (date) - Filter to date (YYYY-MM-DD)
- `overdue_only` (boolean) - Show only overdue jobs

**Example Request:**
```bash
GET /api/v1/jobs?status=Pending&technician_id=5&per_page=10&page=1
```

**Example Response:**
```json
{
    "status": "success",
    "message": "Jobs retrieved successfully",
    "data": {
        "jobs": [
            {
                "id": 1,
                "device_name": "iPhone 12",
                "problem": "Screen broken",
                "status": "In Progress",
                "customer_name": "John Doe",
                "customer_mobile": "9841234567",
                "technician_name": "Ram Sharma",
                "service_center_name": null,
                "photo_count": 3,
                "parts_used_count": 2,
                "total_parts_used": 5,
                "delivery_status": "ON_TIME",
                "created_at": "2025-01-24 10:30:00"
            }
        ],
        "pagination": {
            "current_page": 1,
            "per_page": 10,
            "total": 45,
            "total_pages": 5,
            "has_next": true,
            "has_previous": false
        },
        "statistics": {
            "total_jobs": 45,
            "completed_jobs": 30,
            "pending_jobs": 15,
            "overdue_jobs": 3,
            "completion_rate": 66.67,
            "total_revenue": 125000.00,
            "avg_completion_days": 3.2
        }
    }
}
```

### 2. Get Single Job
**GET** `/api/v1/jobs/{id}`

Retrieve a single job with all related data.

**Example Response:**
```json
{
    "status": "success",
    "message": "Job retrieved successfully",
    "data": {
        "id": 1,
        "user_id": 5,
        "walk_in_customer_name": null,
        "walk_in_customer_mobile": null,
        "device_name": "iPhone 12",
        "serial_number": "ABC123456",
        "problem": "Screen broken, touch not working",
        "technician_id": 3,
        "status": "In Progress",
        "charge": 15000.00,
        "service_center_id": null,
        "expected_return_date": "2025-01-26",
        "created_at": "2025-01-24 10:30:00",
        "updated_at": "2025-01-24 14:20:00",
        "customer": {
            "id": 5,
            "name": "John Doe",
            "mobile_number": "9841234567",
            "user_type": "Registered"
        },
        "technician": {
            "id": 3,
            "full_name": "Ram Sharma",
            "email": "ram@teknophix.com",
            "phone": "9851234567"
        },
        "service_center": null,
        "photos": [
            {
                "id": 1,
                "file_name": "job_1_photo_1.jpg",
                "description": "Before repair",
                "uploaded_at": "2025-01-24 10:35:00"
            }
        ],
        "inventory_movements": [
            {
                "id": 1,
                "item_name": "iPhone 12 Screen",
                "movement_type": "OUT",
                "quantity": 1,
                "moved_at": "2025-01-24 11:00:00"
            }
        ],
        "can_edit": true,
        "can_delete": false,
        "status_history": []
    }
}
```

### 3. Create Job
**POST** `/api/v1/jobs`

Create a new job with proper validation.

**Request Body:**
```json
{
    "device_name": "iPhone 12",
    "problem": "Screen broken, touch not working",
    "status": "Pending",
    "expected_return_date": "2025-01-26",
    "user_id": 5,
    "technician_id": 3,
    "charge": 15000.00,
    "serial_number": "ABC123456"
}
```

**For Walk-in Customer:**
```json
{
    "device_name": "Samsung Galaxy S21",
    "problem": "Battery not charging",
    "status": "Pending",
    "expected_return_date": "2025-01-25",
    "walk_in_customer_name": "Jane Smith",
    "walk_in_customer_mobile": "9841234568",
    "charge": 8000.00
}
```

### 4. Update Job
**PUT** `/api/v1/jobs/{id}`

Update an existing job.

**Request Body:** (Same as create, but all fields optional)
```json
{
    "status": "In Progress",
    "technician_id": 4,
    "charge": 18000.00
}
```

### 5. Delete Job
**DELETE** `/api/v1/jobs/{id}`

Delete a job (subject to business rules).

### 6. Jobs Requiring Attention
**GET** `/api/v1/jobs/attention`

Get jobs that require immediate attention.

**Response:**
```json
{
    "status": "success",
    "message": "Jobs requiring attention retrieved successfully",
    "data": {
        "overdue": [
            // Overdue jobs
        ],
        "no_technician": [
            // Jobs without assigned technician
        ],
        "parts_pending": [
            // Jobs waiting for parts
        ],
        "ready_for_dispatch": [
            // Jobs ready for customer pickup
        ]
    }
}
```

### 7. Job Performance Metrics
**GET** `/api/v1/jobs/metrics`

Get comprehensive job performance metrics.

**Query Parameters:**
- `date_from` (date) - Start date for metrics
- `date_to` (date) - End date for metrics

### 8. Assign Technician
**POST** `/api/v1/jobs/{id}/assign-technician`

Assign a technician to a job.

**Request Body:**
```json
{
    "technician_id": 3
}
```

### 9. Refer to Service Center
**POST** `/api/v1/jobs/{id}/refer-service-center`

Refer a job to a service center.

**Request Body:**
```json
{
    "service_center_id": 2
}
```

## Error Codes

| HTTP Code | Description |
|-----------|-------------|
| 200 | Success |
| 201 | Created |
| 400 | Bad Request / Validation Error |
| 401 | Unauthorized |
| 403 | Forbidden |
| 404 | Not Found |
| 422 | Unprocessable Entity |
| 500 | Internal Server Error |

## Validation Rules

### Job Creation/Update
- `device_name`: Required, max 255 characters
- `problem`: Required, text
- `status`: Required, valid enum value
- `expected_return_date`: Required, valid date
- `user_id`: Optional, must exist in users table
- `technician_id`: Optional, must be active technician
- `service_center_id`: Optional, must be active service center
- `charge`: Optional, decimal with 2 decimal places

### Business Rules
- If `status` is "Referred to Service Center", `service_center_id` is required
- Cannot have both `user_id` and walk-in customer fields
- Completed jobs cannot be edited
- Jobs with photos or inventory movements cannot be deleted

## SMS Notifications

The API automatically sends SMS notifications:

1. **Job Creation**: Admin receives SMS (except when created by anish@anish.com.np)
2. **Status Change**: Customer receives SMS when status changes to "Ready to Dispatch to Customer"

## Rate Limiting

API requests are limited to:
- 1000 requests per hour per authenticated user
- 100 requests per minute per IP address

## Changelog

### v1.0.0 (2025-01-24)
- Initial API release
- Full CRUD operations for jobs
- Comprehensive relationship support
- Analytics and reporting endpoints
- SMS notification integration
