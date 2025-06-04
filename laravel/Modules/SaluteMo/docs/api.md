# SaluteMo API Documentation

## Base URL
All API endpoints are prefixed with `/api/mobile/v1/`

## Authentication
```
Authorization: Bearer {token}
```

## Endpoints

### Authentication

#### Login
```
POST /auth/login
```

**Request Body**
```json
{
    "email": "user@example.com",
    "password": "password",
    "device_name": "iPhone 13"
}
```

**Success Response**
```json
{
    "token": "{api_token}",
    "user": {
        "id": 1,
        "name": "User Name",
        "email": "user@example.com"
    }
}
```

### Appointments

#### Get User Appointments
```
GET /appointments
```

**Query Parameters**
- `status` - Filter by status (optional)
- `start_date` - Start date (YYYY-MM-DD)
- `end_date` - End date (YYYY-MM-DD)

**Success Response**
```json
{
    "data": [
        {
            "id": 1,
            "title": "Dental Checkup",
            "start": "2023-06-15T10:00:00Z",
            "end": "2023-06-15T11:00:00Z",
            "status": "confirmed"
        }
    ]
}
```

### Notifications

#### Get User Notifications
```
GET /notifications
```

**Query Parameters**
- `unread_only` - Boolean (optional)
- `limit` - Number of records to return (default: 20)

**Success Response**
```json
{
    "data": [
        {
            "id": 1,
            "title": "Appointment Reminder",
            "message": "Your appointment is scheduled for tomorrow at 10:00 AM",
            "read_at": null,
            "created_at": "2023-06-14T15:30:00Z"
        }
    ]
}
```

## Error Responses

### 401 Unauthorized
```json
{
    "message": "Unauthenticated."
}
```

### 422 Unprocessable Entity
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The email field is required."],
        "password": ["The password field is required."]
    }
}
```

### 500 Internal Server Error
```json
{
    "message": "Server Error"
}
```
