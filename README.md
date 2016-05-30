# camagru
Repository for project Camagru, web project for school 42.

## About the project
It's a basic php website with some javascript on the front-end where the user can take a picture from the webcam and merge it with another pic from a list (mostly faces of different celebrities). Once the merged picture is saved, other users can see and comment the picture.

## Technical details

The website connect mysql database (hosted on phpmyadmin here) that contains 2 tables (for now) -> users and pictures. Passwords are encrypted in GOST 28147-89 [(межгосударственный стандарт симметричного шифрования)](https://en.wikipedia.org/wiki/GOST_(block_cipher)) and then stored as hash values in the database.
Pictures saved by the user are stored in the database as BLOB.
All the requests to the db are carried out through the PDO interface.
On the front-side, I implemented a serie of Ajax requests in order to have a dynamic view and prevent the views from reloading constantly.

## Current status of project

Currently under development 
