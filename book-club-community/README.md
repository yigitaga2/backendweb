# 📚 Book Club Community

A comprehensive Laravel-based web application for book lovers to discover, review, and manage their reading journey together.

## ✨ Features

### 🔐 User Management
- **User Registration & Authentication** - Secure user accounts with email verification
- **User Profiles** - Customizable profiles with avatars, bio, birthday, and reading statistics
- **Admin Dashboard** - Comprehensive admin panel for user and content management

### 📖 Book Management
- **Book Library** - Browse and search through community book collection
- **Add Books** - Users can contribute new books with cover images and detailed information
- **Personal Library** - Track reading status (Want to Read, Currently Reading, Read)
- **Advanced Search** - Filter books by title, author, genre, and ISBN

### ⭐ Review System
- **Star Ratings** - Interactive 5-star rating system with hover effects
- **Written Reviews** - Detailed text reviews to share thoughts and recommendations
- **Community Reviews** - Browse all community reviews with search and filtering
- **Review Management** - Edit and delete your own reviews

### 📰 News & Information
- **News System** - Admin-managed news articles with categories and publishing controls
- **FAQ Section** - Frequently asked questions with easy management
- **Contact Form** - Contact system with admin notification and management

### 👑 Admin Features
- **User Management** - View, search, and manage user accounts
- **Content Moderation** - Manage books, reviews, news, and FAQ content
- **Contact Management** - Handle user inquiries and messages
- **Statistics Dashboard** - Overview of platform activity and user engagement

## 🚀 Technology Stack

- **Backend**: Laravel 11.x
- **Frontend**: Blade Templates with Tailwind CSS
- **Database**: MySQL/SQLite
- **Authentication**: Laravel Breeze
- **File Storage**: Laravel Storage (local/cloud)
- **Testing**: PHPUnit with Feature and Unit tests

## 📋 Requirements

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL 8.0+ or SQLite
- Web server (Apache/Nginx)

## 🛠️ Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd book-club-community
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   - Update `.env` file with your database credentials
   - For MySQL:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=book_club_community
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     ```

6. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Build frontend assets**
   ```bash
   npm run build
   ```

8. **Create storage link**
   ```bash
   php artisan storage:link
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```

## 👤 Default Admin Account

After running the seeders, you can log in with:
- **Email**: admin@ehb.be
- **Password**: Password!321

## 🧪 Testing

Run the test suite:
```bash
php artisan test
```

Run specific test categories:
```bash
php artisan test --filter="BookTest"
php artisan test --filter="ReviewTest"
php artisan test --filter="UserLibraryTest"
```

## 📁 Project Structure

```
book-club-community/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/           # Admin panel controllers
│   │   ├── BookController.php
│   │   ├── ReviewController.php
│   │   └── UserLibraryController.php
│   ├── Models/              # Eloquent models
│   └── Http/Requests/       # Form request validation
├── database/
│   ├── migrations/          # Database schema
│   ├── seeders/            # Database seeders
│   └── factories/          # Model factories for testing
├── resources/
│   ├── views/
│   │   ├── books/          # Book-related views
│   │   ├── reviews/        # Review system views
│   │   ├── library/        # Personal library views
│   │   ├── admin/          # Admin panel views
│   │   └── components/     # Reusable components
│   └── css/                # Styling
├── routes/
│   └── web.php             # Application routes
└── tests/
    ├── Feature/            # Feature tests
    └── Unit/               # Unit tests
```

## 🎯 Key Features Explained

### Personal Library Management
Users can add books to their personal library and track their reading progress:
- **Want to Read**: Books on the user's wishlist
- **Currently Reading**: Books being actively read
- **Read**: Completed books

### Review System
Interactive review system with:
- 5-star rating system with visual feedback
- Optional written reviews
- Edit/delete functionality for own reviews
- Community review browsing with filters

### Admin Dashboard
Comprehensive admin panel featuring:
- User management with search and filtering
- Contact message handling
- Platform statistics and insights
- Content moderation tools

## 🔧 Configuration

### File Uploads
Configure file storage in `.env`:
```env
FILESYSTEM_DISK=local
# or for cloud storage:
FILESYSTEM_DISK=s3
```

### Email Configuration
Set up email for contact forms and notifications:
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 🙏 Acknowledgments

- Laravel Framework
- Tailwind CSS
- The amazing open-source community

---

**Happy Reading! 📚✨**
