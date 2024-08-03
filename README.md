# Open Chat

Open Chat is a real-time chat application built with PHP and PHP Ratchet. It provides seamless and responsive messaging capabilities, featuring various functionalities that enhance user interaction and communication.

## Key Features

- **Real-time Messaging**: Instant communication with live updates.
- **User Authentication**: Secure user registration and login.
- **Responsive Design**: Optimized for both desktop and mobile devices.
- **File Sharing**: Share images, documents, and other files directly in the chat.

## Technologies Used

- **Backend**: PHP
- **WebSockets**: PHP Ratchet
- **Frontend**: HTML5, CSS3, JavaScript
- **Database**: MySQL

## Setup Instructions

### Prerequisites

- PHP 7.4 or higher
- Composer
- MySQL

### Installation

1. **Clone the repository:**
    ```bash
    git clone https://github.com/GoldenThrust/open_chat.git
    cd open_chat
    ```

2. **Install dependencies using Composer:**
    ```bash
    composer install
    ```

3. **Set up the database:**
    - Import the provided SQL file to your MySQL database.
    - Update database credentials in the configuration file (e.g., `config.php`).

4. **Start the Ratchet server:**
    ```bash
    php bin/chat-server.php
    ```

5. **Access the application:**
    Open your browser and navigate to the application URL (e.g., `http://localhost/open_chat`).

## Usage

1. **Register a new user:**
    - Open the registration page and fill in the required details.

2. **Log in with your credentials:**
    - Access the login page and enter your username and password.

3. **Start chatting:**
    - Send and receive messages in real-time.

## Contributing

We welcome contributions from the community. To contribute:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes.
4. Commit your changes (`git commit -m 'Add some feature'`).
5. Push to the branch (`git push origin feature-branch`).
6. Open a pull request.
