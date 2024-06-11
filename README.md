# Sensuy

Welcome to **Sensuy**, a vibrant platform inspired by the best of Instagram, Reddit, and Mega. Sensuy is a fan-created space where you can upload and share your favorite images, videos, and music from your beloved celebrities and artists. The name "Sensuy" is derived from the Japanese word for "fans," reflecting the community-driven spirit of this site.

## Getting Started

Follow these steps to set up and run Sensuy on your local machine.

### Prerequisites

- **XAMPP Control Panel**: Ensure you have XAMPP installed for an easy-to-use local web server.
- **Code Editor**: You can use any code editor, but we recommend PhpStorm for the best development experience.
- **Node.js**: Required to run the frontend development server.

### Installation

1. **Clone the Repository**
    ```sh
    git clone https://github.com/M7PAX/sensuy.git
    cd sensuy
    ```

2. **Install Dependencies**
    ```sh
    npm install
    composer install
    npm i @vueuse/core
    ```

3. **Configure Environment**
   Copy `.env.example` to `.env` and update the necessary configuration settings.

    ```sh
    cp .env.example .env
    php artisan key:generate
    ```

### Running the Application

1. **Start the Development Server**
    ```sh
    npm run dev
    ```

2. **Start the PHP Server**
    ```sh
    php artisan serve
    ```

3. **Run Database Migrations**
    ```sh
    php artisan migrate
    ```

4. **Seed the Database with Default Data**
    ```sh
    php artisan db:seed
    ```

### Technologies Used

- **Backend**: PHP, Laravel
- **Frontend**: JavaScript, Vue.js
- **Database**: MySQL
- **Development Tools**: XAMPP, PhpStorm
