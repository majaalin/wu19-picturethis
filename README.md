# Picture This

<p align="center">
  <img  src="https://media.giphy.com/media/BFPW5ugXi6ltm/giphy.gif" width="80%">
</p>

This is an image-based social media platform called **Picture This**. It's a mobile-first responsive project that combines HTML, CSS, (vanilla) JavaScript, PHP and a SQLite database. Bootstrap was also used as a graphical user interface.

## About This Project
* Create an account to start sharing captioned images with whoever else logs into the database. 
* Leave comments & likes on posts and follow other users' profiles. 
* A few of the characters from Stanley Kubrick's films have already created accounts. 

## Clone the Project Files
* Clone the repository using `git clone https://github.com/AltDom/wu19-picturethis.git` in your chosen bash terminal.
* Enter the project folder using the command `cd wu19-picturethis/`.
* Create a local server using the command `php -S localhost:8000`.
* Open your browser of choice and go to the url `localhost:8000`.

## Testers
* Camilla Kylmänen Sjörén
* Alexander Gustafsson Flink

## Code Review
Code review made by [Andreas Pandzic](https://github.com/APandzic)
* Search.php 8-14, feed.php 8-14 and home.php 8-11. Repeats variables at the top of search.php, feed.php and home.php files. Place them in the header or a function. 
* Edit.php 21-67. Break out this code rows from the front end and move it to a file in the back end. This makes it more readable and easier to find files in your folder structure.
* Edit.php 68 and 94. It is good practice to try to be as consistent in your code as possible. In these two classes you use apostrophes instead of the quotation marks as in all other classes.
* Main.js 71-118. On these lines, it would be good if you could break out as much code as possible to make it easier to read. 
* Main.js Difficult to understand what all functions do in this document at first sight. 1 comment before all functions of this file would have done the trick. 
* Main.js 13 and 16. Repeats the code when setting the value of the variable "img". It's good practice to don't repeat code. 
* Main.js 21 and42. The followUser and unfollowUser functions repeat a lot of code and could have been merged.
* App/posts/delete.php 7. It's good practice to always sanitise incoming values to the backend. ( You can never be too sure, and so you don't miss sanitising it the times you really need too).
*  App/posts/delete.php 10, 20, 16 and 32. Try to merge as many queries as possible, this will make your code much faster. 
* App/users/delete.php 9, 15, 26, 32, 38 and 44. Try to merge as many queries as possible, this will make your code much faster. It was a pleasure to read your code mate! Keep up your awesome work.

## License
This assignment is licensed under the MIT License. You can get all the details [here](https://github.com/AltDom/wu19-picturethis/blob/master/LICENSE). 
