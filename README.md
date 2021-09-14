## What is Zexacore?
Zexacore is a content management system developed for building corporate websites.

## Demo
Although it is still under development, you can see the admin panel using the following details.

- https://zexacore.com/admin
- john@doe.com
- password

<img src="https://user-images.githubusercontent.com/8471647/120819300-55f0de00-c54b-11eb-80ae-dfe49c000eb6.png" width="500" alt="zexacore admin panel">


## Tech Stack
- Laravel 8
- Vue & Vuex
- TailwindCSS
- Jest
- ESLint
- JWT Auth
- REST API

## Installation
- Change document root from public_html to public_html/public
- Create a database and an user
- Rename the .env.example file as .env and edit
- Run the commands in order
    - ```git clone https://github.com/sinan4yildiz/zexacore.git .```
    - ```chgrp 99 public (as root user)```
    - ```chmod 750 public```
    - ```php artisan key:generate```
    - ```php artisan jwt:secret```
    - ```php artisan migration:fresh --seed```
    - ```composer install --optimize-autoloader --no-dev```
    - ```npm install```
    - ```npm run dev```

## Notes
- Frontend has not yet been developed.
- Feel free to have it and develop for any purpose.
- There might still be some bugs. If you notice anything please open an issue.
- If you have a suggestion please let me know.

## License
[MIT](https://choosealicense.com/licenses/mit/)

❤️ Code with passion!
