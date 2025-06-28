## Getting Started

### 1. Unpack the Project

Unzip the folder containing the CodeIgniter 4 (CI4) project files.

### 2. Run the Development Server

From the root of the project directory, run:

```bash
php spark serve
This will start the server at:
http://localhost:8080

📮 API Endpoints
Use Postman or any API client to test the following endpoints.

🔐 Authentication
Register

POST http://localhost:8080/register
Body (JSON):

{
  "name": "your_username",
  "email": "your_email@example.com",
  "password": "your_password"
}
Login

POST http://localhost:8080/login
Body (JSON):

{
  "email": "your_email@example.com",
  "password": "your_password"
}
📝 Todo
Get All Todos

GET http://localhost:8080/api/todo
Create a Todo

POST http://localhost:8080/api/todo
{
  "title": "Buy milk",
  "description": "From nearby store"
}
Update a Todo

POST http://localhost:8080/api/todo/{id}
Body (JSON):

json
{
  "title": "Buy bread",
  "description": "Whole grain"
}
Delete a Todo
DELETE http://localhost:8080/api/todo/{id}

Get a Single Todo
GET http://localhost:8080/api/todo/{id}


