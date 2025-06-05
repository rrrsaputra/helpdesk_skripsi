## Installation

1. Clone the project repository:

   ```sh
   git clone https://github.com/rrrsaputra/helpdesk_skripsi.git
   ```


2. Get inside the folder:

   ```sh
   cd helpdesk_skripsi
   ```

3. Install Composer Dependencies:

   ```sh
   composer install   
   ```

4. Copy the Environment File:
   
   ```sh
   cp .env.example .env
   ````
5. Generate Application Key:

   ```sh
   php artisan key:generate
   ```

   ### Database Configuration di `.env` file.

```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ticketing_hd
DB_USERNAME=root
DB_PASSWORD=
```

7. Run Database Migrations and Seed the Databse:
   
   ```sh
   php artisan migrate:fresh --seed
   ```
8. Link Storage:

   ```sh
   php artisan storage:link
   ```
9. NPM Install:
    ```sh
    npm install
    ```



