# Chat Application

This is a **private chat application** built using **PHP** and **MySQL**, designed for seamless communication in **private rooms**. Users can join a chat room by providing a unique room name and password. Once they enter the correct credentials, they can start chatting with other users in real-time. The app uses sessions to maintain user login for **48 hours (2 days)**.

---

### Features:

- **Private Chat Rooms**: Only users who know the **correct room name and password** can join the chat room, ensuring privacy.
- **Message History**: All messages sent within the room are stored in the database and displayed in real-time for every user in the room.
- **User-Friendly UI**: The app features a simple and attractive interface with messages aligned on the left for the sender and on the right for received messages, along with **timestamps** to track when messages were sent.
- **Session Persistence for 2 Days**: User sessions are maintained for **2 days** so that users don’t have to log in again within that time frame.
- **Modern Design**: Stylish UI with custom chat bubble designs and timestamps for a more **engaging** experience.

```sql
CREATE DATABASE chat_app;

CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT NOT NULL,
    sender_name VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (room_id) REFERENCES rooms(id)
);
```
### 1. Clone the Repository, in /var/www/html folder in linux or your /xampp/htdocs folder in windows

```bash
git clone https://github.com/yash128/phpChat.git
cd phpChat
```
and enjoy using the app at localhost/phpChat/.
