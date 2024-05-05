The game "Bulls and cows".

Technologies used: Docker, docker-compose (pgsql, php, nginx, golang services), Golang, PHP, Laravel, PostgreSQL

The first experience of writing applications on Golang. The user makes a combination of 4 non-repeating digits, the value from the Laravel service is transmitted to the Golang service, which determines the winning combination, counts the number of "bulls" and "cows" and returns the result. At the same time, Laravel does not know anything about the winning combination.
