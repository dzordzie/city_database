# Slovak Cities - Nitra District

This project is a simple Laravel web application that lists cities and municipalities located in the Nitra region (Slovakia). The data is parsed from the website [e-obce.sk](https://www.e-obce.sk/kraj/NR.html), including details like the mayor's name, city hall address, and coat of arms, ... . The project also includes a frontend and simple autocomplete search functionality.

## Technologies Used

* Laravel 12
* PHP 8.4
* Simple HTML DOM
* Google Geocoding API (requires an API key)
* SCSS (compiled via Vite)
* Bootstrap 5
* PostgreSQL
* Blade templates

## Installation

1. **Clone the repository:**

```bash
git clone https://github.com/dzordzie/city_database.git
```

2. **Install dependencies:**

```bash
composer install
npm install
npm run build
```

3. **Create the `.env` file:**

```bash
cp .env.example .env
```

Fill in the database connection and Google API key:

```
GOOGLE_GEOCODING_API_KEY=...
```

4. **Generate app key and run migrations:**

```bash
php artisan key:generate
php artisan migrate
```

5. **Import city data:**

```bash
php artisan data:import
```

6. **Import latitude and longitude for cities:**

```bash
php artisan data:geocode
```

---

## Features

* Parses all subdistricts of the Nitra region (Komárno, Levice, Nitra, etc.)
* Parses city details from their respective pages
* Downloads and stores coats of arms in `public/images/`
* Geolocation using the Google Geocoding API
* Autocomplete search for cities
