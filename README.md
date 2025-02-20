# NoteWise-Laravel

NoteWise-Laravel is a simple note-taking web application built with the [Laravel](https://laravel.com/) framework. Users can register/login, create/edit notes, add remarks, filter notes, and manage their own personal note list. This project demonstrates core Laravel features such as MVC structure, Eloquent relationships, authentication, Blade templating, and more.

---

## Features

- **User Authentication**  
  Register and log in with Laravel’s built-in authentication system.

- **CRUD for Notes**  
  Create, read, update, and delete notes. Each note is owned by the user who created it.

- **Remarks**  
  A note can have many remarks (comments). Any logged-in user can leave a remark.

- **Filtering & Search**  
  Filter notes by:
  - Name/Description (keyword search)  
  - Date range (`startDate`, `endDate`)  
  - Has remarks or not

- **My Notes Page**  
  View a dedicated page showing only the notes owned by the logged-in user.

- **Responsive UI**  
  Basic responsive design using [Bootstrap](https://getbootstrap.com/). 

---

## Requirements

- PHP >= 8.0
- Composer
- XAMPP Version 3.3
- Laravel Version 11.X
- MySQL (or any database supported by Laravel)
- Node.js & npm (for Vite asset compilation)

---

## Installation

1. **Clone the repository**
2. **Put the ```NoteWise-Laravel``` project into ```xampp\htdocs```**
3. **Open XAMPP Control Panel and start the** ```Apache``` **and** ```MySQL``` **services.**
4. **Install Composer dependencies**:
   ```bash
   composer install
   ```
5. **Create a copy of ```.env.example``` and paste it inside the ```NoteWise-Laravel``` folder. Then renamed it as ```.env```**
6. **Make changes in the ```.env``` file**
   - **Update the database credentials in the ```bash .env``` file:**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=notewise
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   
   - **Dont forget to set the ```APP_URL``` if needed. For example:```APP_URL=http://127.0.0.1:8000```** at the ```.env```.

7. **Generate application key:**
   ```
   php artisan key:generate
   ```
8. **Run migrations (and optionally seed):**
   ```
   php artisan migrate --seed
   ```
9. **Install Node dependencies and compile assets:**
   ```
   npm install
   ```
10. **To serve the application you need to run 2 console**
   - **First console:**
   ```
   php artisan serve
   ```
   - **Second console:**
   ```
   npm run dev
   ```
11. **Visit**
    Your ```APP_URL``` in this case the default should be ```http://127.0.0.1:8000```

## Login Credentials (For Testing)

Use the following credentials to log in to the application:

- **Danish:**  
  - Email: `danish@gmail.com`  
  - Password: `12345678`

- **Afiq:**  
  - Email: `afiq@gmail.com`  
  - Password: `12345678`

## Usage

1. **Register or Log In** To access the web application.
2. **View Notes**: At the top navbar click **View Notes** to view all user notes.
3. **My Notes**: At the top navbar click **My Notes** to view user owned notes.
4. **Create a Note**: To add a note click **Add New Note** button.
5. **Add Remarks**: Under each note, type a remark and submit. Any logged-in user can add remarks to notes.
6. **Edit and Delete**:  Under each user owned notes click the delete or modify button.
7. **Filter Notes**: Use the search form at the page to filter by search term, date range, or whether notes have remarks.
    
