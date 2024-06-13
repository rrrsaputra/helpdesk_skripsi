## Installation

1. Clone the project repository:

   ```sh
   git clone https://github.com/bambangsy/ticketing_hd
   ```


2. Get inside the folder:

   ```sh
   cd ticketing_hd
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
6. Run Database Migrations and Seed the Databse:
   
   ```sh
   php artisan migrate:fresh --seed
   ```
7. Link Storage:

   ```sh
   php artisan storage:link
   ```

## Configuration

Before running the application, you need to configure the `.env` file.

### Database Configuration

```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ticketing_hd
DB_USERNAME=root
DB_PASSWORD=
```

Replace everything with your actual database credentials.

### Mapbox Login Configuration

```sh
MAPBOX_ACCESS_TOKEN=your_mapbox_key
```

Replace `your_mapbox_key` with the corresponding values from your [Mapbox](https://www.mapbox.com/). Also, update `APP_URL` with the actual URL where your Laravel application is hosted.
 
## Usage

To run the application, use the following commands:

Run the laravel app:
```javascript
php artisan serve
```
Run the npm:
```javascript
npm run dev
```
```javascript
npm install
```
