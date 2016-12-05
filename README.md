# duedate.io
**Web Systems Development**
Rensselaer Polytechnic Institute
Fall 2016

## How to install
Install duedate.io by:
* Creating a MySQL user and adding the user's credentials to `/resources/library/config.php.example` and renaming that file to `/resources/library/config.php`; or
* Add an existing user's credentials to the same file and then renaming it as before.

Then, cURL or point your browser to `http://<your_server_url>/install.php`. A successful message will appear; if it doesn't, check your web server logs. **After installing, disable access to `install.php`.**
