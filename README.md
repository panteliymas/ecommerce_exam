# Ecommerce module (example app, test)

Example of ecommerce module (catalog, crud) for interview


## Installation

```bash
  git clone https://github.com/panteliymas/ecommerce_exam.git
  cd ecommerce_exam

  composer install
  npm i
  chmod +x -R node_modules/

  # if on linux
  find . -type d -exec chmod 775 {} \;
  find . -type f -exec chmod 664 {} \;
  # endif

  # set up .env file appropriately and after:
  php artisan config:cache
  php artisan key:generate
  php artisan config:cache

  npm run build

```
    
## Deployment

To deploy this project run

```bash
  npm run dev
```

Or you can set up a server to point directly to ecommerce_exam/public folder


## Demo

![App Screenshot](https://i.postimg.cc/zv49dF6h/image.png)
