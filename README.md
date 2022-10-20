# Assert-Mangement
# Set-Up
  After installing the source adding to localhost hosted folder open path via CLI and run composer to install Dependencies.
  ```cli 
  composer update
  ```
### App
  - Rename the env to .env and save in Root Sourcecode.
  - Edit .env file with following configs 
    - app.baseURL = [ Your folder path example : http://localhost/Assert-Mangement ]
    - database.default.hostname = localhost
    - database.default.database = inventory
    - database.default.username = root
    - database.default.password = [Your password]
### Database
  To set database open phpmyadmin create a database `inventory`.
  
  After creating the database import `inventory.sql` file from root sourcecode.
### Chat Server
  `Enable php as global env`
  
  To Run Chat server open command line
  
  ```cli
  php index.php chatserver
  ```
    
