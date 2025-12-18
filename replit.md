# Shoobu Theme

## Overview

Shoobu is a modern, plugin-free e-commerce WordPress theme with built-in product system, customizer panels, and responsive design. This project is configured to preview the theme in a standalone PHP environment that simulates WordPress core functionality.

## Project Structure

```
/
├── assets/
│   ├── css/           # Stylesheets
│   ├── images/        # Theme images
│   └── js/            # JavaScript files
├── inc/
│   ├── add-product-handler.php  # Product form handling
│   ├── customizer.php           # WordPress customizer settings
│   └── helpers.php              # Helper functions
├── sections/          # Homepage sections
│   ├── categories.php
│   ├── featured-products.php
│   ├── features.php
│   ├── hero.php
│   └── premium-tech.php
├── functions.php      # Theme functions
├── header.php         # Site header
├── footer.php         # Site footer
├── index.php          # Main template
├── server.php         # PHP development server entry point
├── style.css          # Main stylesheet
└── wp-bootstrap.php   # WordPress function simulator
```

## Running the Project

The project runs on a PHP development server. The workflow is configured to start automatically:

```bash
php -S 0.0.0.0:5000 server.php
```

## Key Features

- **E-commerce Ready**: Built-in product system with categories, pricing, and cart functionality
- **Responsive Design**: Mobile-first approach with desktop enhancements
- **Hero Slider**: Customizable hero section with multiple slides
- **Product Grid**: Featured products displayed in a responsive grid
- **Navigation**: Both desktop and mobile navigation support
- **Category System**: Product categories with icons

## Technical Notes

- This is a WordPress theme designed to work within WordPress
- For development/preview purposes, a WordPress bootstrap simulator (`wp-bootstrap.php`) provides mock WordPress functions
- Sample products and categories are generated for preview purposes
- The theme uses the Naira (₦) currency symbol

## Deployment

This project is configured for static deployment since it uses PHP's built-in server for development. For production WordPress hosting, the theme files should be placed in the WordPress `wp-content/themes/shoobu` directory.
