# Spotlio tech-test

This application based on laravel is a tech test for spotlio company.


## Installation
Download the repository and run composer 

    $ composer install

Once all the dependencies have been downloaded, run **sail** to raise the docker containers with the application.

    ./vendor/bin/sail up


## Application endpoints

### GET /api/tracks?page=page_number (get all tracks)
**Header Request**: Bearer Token `api_token`
**Response**: 200 -> OK, 4xx -> KO

### GET /api/user (get detailed info about the current user that make the request)
**Header Request**: Bearer Token `api_token`
**Response**: 200 -> OK, 4xx -> KO

### POST /api/register (registers a new user and returns its api_token)
**Body Request**: 

    {
    	"username" : "user_sample",
    	"avatar" : "https://via.placeholder.com/640x480.png/00cc11?text=consequatur",
    	"token" : "blablabla"
    }
    
**Response**: 200 ->

    {
        "access_token": "1|K0cXw7gMJaW51C64lKZ5pFIV6yKoA0nN8XpJX1Je",
        "token_type": "Bearer"
    }


### GET /api/blocks (obtains the list of blocked users given a specific user)
**Header Request**: Bearer Token `api_token`
**Response**: 200 -> OK, 4xx -> KO

### POST /api/blocks/`user_id_to_block`(blocks a specific user given his identifier)
**Header Request**: Bearer Token `api_token`
**Response**: 200 -> OK, 4xx -> KO

