## Local Setup

Follow these steps to set up the project locally:

1. Copy the environment file:
    * Ensure you have a `.env` file. If not, copy the example file:
   ```bash
   cp .env.example .env
   ```
2. Make sure that you added correct DB details for connect to your databases (main and testing)
3. Example: create 2 databases **user_skills** and **user_skills_testing**
```mysql
CREATE DATABASE user_skills CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE user_skills_testing CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
4. Install Composer Dependencies:
   * Run the following command to install all necessary PHP dependencies:
    ```bash
    composer install
    ```

5. Run Migrations and Seed the Database:
    * To set up the database schema and seed it with initial data, run:
   ```bash
   php artisan migrate && php artisan db:seed
   ```
   * Alternatively, you can refresh the database and seed it in one step:**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. Install NPM Dependencies:
   * Run the following command to install all necessary JavaScript dependencies:
   ```bash
   npm install
   ```
7. Compile Assets:
   * During development, compile assets with:
   ```bash
   npm run dev
   ```
   * For production, build the assets with:
   ```bash
   npm run build
   ```
8. Start the Development Server:
   * Launch the application using Laravel's built-in server:
   ```bash
   php artisan serve
   ```
   Open http://localhost:8000 in your browser to view the application.


### Code Analysis and Testing
To run all tests and ensure the code is working as expected, use the following command:
```bash
./run-all-tests.sh
```


