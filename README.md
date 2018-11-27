Preparation of a CSV file for bulk user creation
==================================

Requirements
------------
- Moodle 3.0 (build 2017050800) or later

Installation
------------
Copy the this folder into your Moodle /local directory and visit your Admin Notification page to complete the installation.

Once installed, you should see a new option in the Administration Block:
> Site administration -> Preparation CSV for bulk user creation

Usage
-----
This form will help you prepare a CSV file for bulk user creation of users.
1. Input in textarea names (by default: Lastname Firstname Middlename) and email (comma separated). For each user - new line!
>Ivanova Elena Perovna, ivanova@example.com

>Dougiamas Martin, dougiamas@example.com
2. Add name of the department.
3. Add city and select country.
4. Click download to get a csv file.
5. By uploading thiw CSV via 
>Users -> Accounts -> Upload users 
passwords will be generated automatically and sent to emails.

Author
------
Natalia Sekulich (sekulich.n@gmail.com)
