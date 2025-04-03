# Filament Input Number Bug Inside Repeater

## Context

If you create a resource with a Repeater component for a HasMany relationship with a model that have a decimal property and you add a number input inside this Repeater, the value of decimal property is not showed (as seen below).

![](./record.gif)

### Requirements

- PHP >= 8.2
- Composer
- Laravel >= 11.0
- MySQL or SQLite (configurable in `.env` file)

### Install

1. **Clone this repository:**

   ```bash
   git clone https://github.com/jlucfarias/filament-input-number-repeater-bug.git
   cd filament-input-number-repeater-bug
   ```

2. **Install project dependencies:**

   ```bash
   composer install
   ```

3. **Configure environment:**

   Copy the `.env.example` file to configure your environment:

   ```bash
   cp .env.example .env
   ```

   Edit the `.env` file to configure database credentials and other environment variables.

4. **Generate app key:**

   ```bash
   php artisan key:generate
   ```

5. **execute the migrations and seed tables:**

   ```bash
   php artisan migrate --seed
   ```

6. **Start the development server:**

   ```bash
   php artisan serve
   ```

   The application will be available at `http://localhost:8000`.

### Tests

To execute the tests use the command below:

   ```bash
   php artisan test
   ```
