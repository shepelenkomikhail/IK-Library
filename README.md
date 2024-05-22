# IK_Library

## Web Programming PHP Assignment

### Project Overview
Daniel Jackson meticulously documented his interplanetary adventures, collecting a vast array of written memories. General Hammond and the General Staff have commissioned a website to catalog these books. This project, IK_Library, is designed to serve this purpose.

### Main Features
- **User Interaction**: Users can provide feedback on books and mark them as read.
- **Admin Capabilities**: Admin users can add new books to the system.
- **Detailed Book Information**: Each book has a detailed page with comprehensive information.

### Key Functionalities
#### Main Page / List Page
- Displays a title and short description with static text.
- Lists all books in the system.
- Each book links to its detailed page.
- Logged-in users can access their profile page from the main page.

#### Book Details Page
- Displays the book's title, author, description, cover image, publication year, source planet, average rating, and user ratings.
- Logged-in users can rate and review books, and mark them as read.

#### User Details Page
- Lists user’s information, written reviews, and read books.

#### Authentication Pages
- **Registration**: Username, email, and password (entered twice) are required.
    - Validates unique username, correct email format, and matching passwords.
    - Displays error messages for registration issues.
    - Successful registration logs the user in and redirects to the main page.
- **Login**: Identifies users via username and password.
    - Displays error messages for login issues.
    - Successful login redirects to the main page.

### Admin Functions
- **Admin User**: Default admin credentials (username: admin, password: admin).
- **Book Management**: Admin can add new books to the system.

### Extra Features
- **Sophisticated Design**: Ensures a visually appealing layout suitable for 1024x768 resolution.
- **Server-Side Validation**: Ensures data validation during final request processing.
- **Custom CSS**: Allows use of CSS frameworks for enhanced design.

### Minimum Requirements (6 points)
- **README.md**: Completed and uploaded.
- **Main Page**:
    - Appears and lists all books.
    - Clicking on a book name leads to its details page.
- **Book Details**:
    - Displays book details and cover image.
- **Admin**: Ability to create a new book with error handling and successful save.

### Basic Tasks (14 points)
- **Book Details**:
    - Displays average rating and evaluations.
- **Registration**:
    - Contains appropriate elements, handles errors, maintains state, and allows successful registration.
- **Login/Logout**:
    - Handles faulty cases, allows successful login and logout.
- **User Profile**:
    - Displays user's name on the main page and links to user's details page.
    - Displays user's data, reviews, and books read.
- **Admin**:
    - Only admin can create new books and log in with admin credentials.
- **Evaluation**:
    - Form appears with correct elements, handles errors, maintains state.
- **Demanding Design**: Ensures an appealing and user-friendly interface.

### Extra Tasks (5 points)
- **Book Sorting**: Main page sorts books by average rating.
- **Admin Book Modification**: Allows book data modification with error handling and status maintenance.
- **Mark as Read**: Logged-in users can mark books as read.
- **Read Books Display**: Displays users who read a book with the time of reading.
- **User Read Books**: Displays books read by the user in descending order by reading time.