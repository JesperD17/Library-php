# Library-php
A library website where you can create, delete and manage books using php

## Migrations
### Creating a new table
1. Create a new file at `database/migrations`.
2. Fill it with a sql query.
   ```sql
   CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    session_token TEXT,
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
   );
   ```
3. Run `php console/migrate.php`.