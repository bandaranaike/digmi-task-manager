# Laravel-Firebase Task Management API

## Overview
This API provides task management functionality with Firebase Firestore as the database. The API supports CRUD operations for tasks and requires Firebase authentication.

## Assumptions
- Any logged-in user has full access to all tasks.


## Firebase Configuration

To get the Firebase configuration, follow these steps:

1. Go to the Firebase Console: [https://console.firebase.google.com/](https://console.firebase.google.com/)
2. Select your project.
3. Navigate to **Project Settings**.
4. In the **Service accounts** tab, click on **Generate new private key**.
5. This will download a JSON file containing your Firebase credentials.

Save this file as `firebase-credentials.json` in the `storage/app` folder of your project.

You can refer to `firebase-credentials-example.json` for the format of the credentials file.

## Base URL
```
https://your-api-domain.com/api/tasks
```

## Authentication

The API uses Firebase authentication via a middleware (`FirebaseAuth`). All routes require a valid Firebase-authenticated user.


## Endpoints

Please add the `Authorization` header with the `firebase_id_token` you got from logging in.

### 1. Authentication
**Request:**
```
POST /api/auth/login
```

**Body:**
```json
{
    "email": "user@example.com",
    "password": "user_password"
}
```
**Response:**
```json
{
    "message": "Sign-in successful",
    "idToken": "firebase_id_token"
}
``` 

### 2. List All Tasks
**Request:**
```
GET /api/tasks
```
**Query Parameters:**
- `due_date` (optional): Filter tasks by a specific due date. If `due_date` is present, `due_start_date` and `due_end_date` will be overridden and not used.
- `due_start_date` (optional): Filter tasks with a due date on or after this date.
- `due_end_date` (optional): Filter tasks with a due date on or before this date.
- `status` (optional): Filter tasks by their status (`pending`, `in-progress`, `completed`).

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

### 3. Get a Specific Task
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

### 4. Create a New Task
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

### 5. Update a Task
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

### 6. Delete a Task
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
- Implement pagination for listing tasks.
- Improve error handling and logging.

## Dependencies
- Laravel
- kreait/laravel-firebase package
- Firebase Firestore
- Firebase Authentication

