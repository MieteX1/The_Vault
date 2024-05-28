# The_Vault

## Overview
The Vault is a comprehensive web application designed to simulate a bank account management system. It allows users to create a bank account, verify their identity through an activation process, and log in to manage their account. Depending on the role assigned to their account (User, Employee, or Administrator), users have access to different functionalities within the application.

## Features
**User Registration**
- **Account Creation**: Users can create a bank account by providing their first name, last name, email address, password, and confirming their password.
- **Terms and Conditions**: Users must accept the terms and conditions to proceed.
- **ReCaptcha**: A ReCaptcha is used to verify that the user is not a robot.
- **Error Handling**: Appropriate error messages are displayed for incorrect or incomplete form submissions.
## Account Activation
- **Verification Process**: After registration, users receive an activation code via email.
- **Activation Code**: Users must enter the received activation code to activate their account.
- **Account Number**: Once activated, users receive their account number via email, which they use to log in along with their password.
## Login
- **Role-Based** Access: Upon logging in, users are redirected to a panel based on their account role:
  - User
  - Employee
  - Administrator
## User Panel
- **Dashboard**: Displays the user's first name, last name, session expiry time, account balance, and a card pattern.
- **Transaction History**: Shows incoming and outgoing transaction history with dates and amounts.
- **Fund Transfer**: Allows users to make transfers to other accounts.
## Employee Panel
- **User Management**: Employees can manually add users to the database and edit user balances.
- **User List**: Displays a list of all users.
- **Transaction History**: Shows the transaction history of all users.
## Administrator Panel
- **Permissions Management**: In addition to employee privileges, administrators can change user roles.
## Technologies
- **Frontend**: HTML, CSS
- **Backend**: PHP
- **Database**: MySQL
## My Contributions
My primary responsibilities included:

- **Database Management**: Designing, creating, and maintaining the database structure.
- **Backend Development**: Implementing the backend logic to handle user registration, login, role-based access control, and transaction processing.
- **Frontend Assistance**: Occasionally assisted in writing frontend code.
## Demo
You can access the application using the following link:

[The Vault Demo](https://juliuszdrojecki.pl/projekt_php_studia/The_Vault/logowanie.php)

## Test Accounts
For testing purposes, we have created sample accounts with the following details:

- User Accounts:
  - Account Number: 10
  - Password: 12345678
- Employee Accounts:
  - Account Number: 11
  - Password: 12345678
- Administrator Accounts:
  - Account Number: 12
  - Password: 12345678


Feel free to log in using these accounts to explore the different functionalities available based on the account roles.

Thank you for your interest in The Vault. For any further inquiries or issues, please feel free to contact us.
