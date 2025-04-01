# Laravel-Firebase Task Management API

## Overview
This API provides task management functionality with Firebase Firestore as the database. The API supports CRUD operations for tasks and requires Firebase authentication.

## Assumptions
- Any logged-in user has full access to all tasks.
- Filtering options were not implemented due to time constraints.
- The application can be improved to allow users to manage only their own tasks.

## Base URL
```
https://your-api-domain.com/api/tasks
```

## Authentication
The API uses Firebase authentication via a middleware (`FirebaseAuth`). All routes require a valid Firebase-authenticated user.

## Endpoints

### 1. List All Tasks
**Request:**
```
GET /api/tasks
```
**Response:**
```json
[
    {
        "id": "task_id",
        "title": "Task Title",
        "description": "Task Description",
        "due_date": "YYYY-MM-DD",
        "status": "pending | in-progress | completed",
        "created_at": "timestamp",
        "updated_at": "timestamp"
    }
]
```
**Status Codes:**
- 200 OK – Successfully retrieved tasks

---

### 2. Get a Specific Task
**Request:**
```
GET /api/tasks/{id}
```
**Response:**
```json
{
    "id": "task_id",
    "title": "Task Title",
    "description": "Task Description",
    "due_date": "YYYY-MM-DD",
    "status": "pending | in-progress | completed",
    "created_at": "timestamp",
    "updated_at": "timestamp"
}
```
**Status Codes:**
- 200 OK – Task retrieved successfully
- 404 Not Found – Task does not exist

---

### 3. Create a New Task
**Request:**
```
POST /api/tasks
```
**Body:**
```json
{
    "title": "New Task",
    "description": "Task details",
    "due_date": "YYYY-MM-DD",
    "status": "pending"
}
```
**Response:**
```json
{
    "message": "Task created successfully",
    "task": {
        "id": "task_id",
        "title": "New Task",
        "description": "Task details",
        "due_date": "YYYY-MM-DD",
        "status": "pending",
        "created_at": "timestamp",
        "updated_at": "timestamp"
    }
}
```
**Status Codes:**
- 201 Created – Task created successfully
- 400 Bad Request – Validation error

---

### 4. Update a Task
**Request:**
```
PUT /api/tasks/{id}
```
**Body:**
```json
{
    "title": "Updated Task Title",
    "description": "Updated details",
    "due_date": "YYYY-MM-DD",
    "status": "completed"
}
```
**Response:**
```json
{
    "message": "Task updated successfully",
    "task": {
        "id": "task_id",
        "title": "Updated Task Title",
        "description": "Updated details",
        "due_date": "YYYY-MM-DD",
        "status": "completed",
        "created_at": "timestamp",
        "updated_at": "timestamp"
    }
}
```
**Status Codes:**
- 200 OK – Task updated successfully
- 404 Not Found – Task does not exist

---

### 5. Delete a Task
**Request:**
```
DELETE /api/tasks/{id}
```
**Response:**
```json
{
    "message": "Task deleted successfully"
}
```
**Status Codes:**
- 200 OK – Task deleted successfully
- 404 Not Found – Task does not exist

## Future Improvements
- Implement user-specific task management so that users can only access their own tasks.
- Add filtering options for tasks by status and due date.
- Implement pagination for listing tasks.
- Improve error handling and logging.

## Dependencies
- Laravel
- kreait/laravel-firebase package
- Firebase Firestore
- Firebase Authentication

