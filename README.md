# printful
printful test

#database:
for database tables: you can find the queries in: src/sql/tables.sql
and for test data: you can find testing data inside : src/sql/data.sql

you can change your database configuration inside src/db/DBClass.php

#brief description:

first time when you open the website: you have to enter your name and select a test from a dropdown select list. 
These two information are required and you cant go on to the next step without filling them.

when you submit your information in the first step, an ajax request will handle your information and saving them in two places,
your name will be saved inside users table and assign a unique id to it. and the system will link your unique id with the quiz id 
which you had selected before. and save the linkage in user_quiz table in database.

if everything went right, you will be redirect to quiz page. each question in the quiz is required, and you can't go on to the next step if you hadn't answer it.
The quiz questions will be handle dynamically without refresh the page using javascript and ajax request. after each answer of question, your answer will be saved inside table answers.
and when you answer the last question in the form, your result will be saved inside results table. and the system will redirect you the result page.

#styling: 
I used materialize css to add style to the website by using its cdn.