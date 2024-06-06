# Sensuy

## About

**Sensuy** is a platform created by fans, for fans. It is designed to allow users to easily share their favorite media related to celebrities and artists. Whether it's a captivating image, an engaging video, or a melodious track, Sensuy provides a space for fans to come together and celebrate their passions.

## Getting Started

### Prerequisites

To get started with Sensuy, ensure you have the following installed on your system:

- **XAMPP Control Panel**
- **Node.js**
- **PHP**
- **Composer**
- **A Code Editor** (PHPStorm recommended)

### Installation

1. **Clone the Repository**
   ```sh
   git clone https://github.com/your-username/sensuy.git
   cd sensuy
   ```

2. **Install Node.js Dependencies**
   ```sh
   npm install
   ```

3. **Install PHP Dependencies**
   ```sh
   composer install
   ```

4. **Set Up Environment Variables**
   Copy the `.env.example` file to `.env` and fill in the necessary details.
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```

## Usage

### Running the Website

To start the development server, run the following commands:

```sh
npm run dev
php artisan serve
```

Open your web browser and navigate to `http://localhost:8000` to see the website in action.

### Seeding the Database

To populate the database with randomly generated default information, run the following command:

```sh
php artisan db:seed
```

## Technologies Used

- **XAMPP Control Panel:** For managing Apache and MySQL.
- **Node.js:** For the development server and building the frontend.
- **PHP:** For backend development.
- **Laravel:** As the PHP framework.
- **Composer:** For managing PHP dependencies.
- **NPM:** For managing Node.js dependencies.
- **PHPStorm:** As the code editor.
