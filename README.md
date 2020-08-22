# fictional-user-posts

TASK 
-------------------

1. Register a short-lived token on the fictional Supermetrics Social Network REST API
 
2. Fetch the posts of a fictional user on a fictional social platform and process their posts. You will have 1000 (100 posts per page * 10 pages) posts over a six month period.

Show stats on the following:
- Average character length / post / month
- Longest post by character length / month
- Total posts split by week
- Average number of posts per user / month


API DOCS
-----------------
1. Use the following endpoint to register a token:
 
POST: https://api.supermetrics.com/assignment/register

PARAMS:

 
<<<<<<< HEAD
client_id : xxx
=======
client_id : 
>>>>>>> 346730df26fb1fedd9dbf9e4808d1756e1a4e075
email : your@email.address
name : Your Name

RETURNS
 
- sl_token : This token string should be used in the subsequent query. Please note that this token will only last 1 hour from when the REGISTER call happens. You will need to register and fetch a new token as you need it.
- client_id : returned for informational purposes only
- email : returned for informational purposes only
 
 
2. Use the following endpoint to fetch posts:
 
GET: https://api.supermetrics.com/assignment/posts

PARAMS:
 
- sl_token : Token from the register call
- page : integer page number of posts (1-10)

RETURNS:
 
- page : What page was requested or retrieved
- posts : 100 posts per page


## Project Setup
Open a terminal window and run these commands
- `composer install` (installs dependencies) 
- php -S localhost:8000 (development web server)

## Unit tests
- Simply run `phpunit` in terminal window to run all unit tests

