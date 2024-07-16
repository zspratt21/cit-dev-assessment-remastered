# Zero Crud Template
This project aims to implement a minimal starting point for a simple crud cli application using Laravel Zero.

## Features:
- A mysql container that can be used to store data
- A php-cli container that can be used to run the application
- A custom model base class that checks the connection and table and closes gracefully if either is not available

## Requirements
- PHP 8.2 or higher
- Composer
- MySQL 8 or higher
- Docker, if intending to use the containers provided in the docker-compose.yml file.

## Installation
- Create a new project from this template
- Run `composer install` to install dependencies
- Copy the example.env file to .env and adjust to your setup as needed
- Run php zero migrate to create the colors table

## Usage
- Run `php zero` to see the available commands and options
