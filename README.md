# ERP

ERP for user and product management with REST API

## Description

The application allows to authorize, manage users and products via REST API.

Only two entities are used:

1. User:
- id;
- login;
- password;
- role;
- superior_id.

2. Product:
- id;
- title;
- description;
- price;
- owner_id.

There are 4 subordinate user roles:
1. root - the first autocreated user in system on setup. It allows to start create other users. Can manage all users and see all products.
2. admin - can manage subordinate role users and see their products.
3. teamlead - can manage subordinate role users and see their products.
4. buyer - can manage his own products.

## Tech stack

The application is developed with [Laravel 11](https://laravel.com/) framework and comes with [Docker](https://www.docker.com/) environment (compose v2).

## Install

1. Clone this repository to your project directory:
```
git clone git@github.com:mustakrakishe/erp erp
```

2. Go to created directory:
```
cd erp
```

3. Create an .env file:
```
cp .env.example .env
```

4. The .env already contains all requires preset values to start the application with Docker. However, you are free to change them.

5. Up the docker environment:
```
docker compose up -d
```

6. Enter to the php container:
```
docker compose exec php /bin/bash
```

7. install composer dependencies:
```
composer install
```

8. Run migrations with a ```--seed``` option:
```
php artisan migrate --seed
```
This default seeder creates the first user, that will allow you to start create other users:
```
login:       root
password:    password
role:        root
superior_id: null
```

> It is required to run default seeder as it is the only way to have possibility to start to create users, except manually creating in db.

If you already run migrations without ```--seed``` option, you can do it futher:
```
php artisan db:seed
```
Also, you may add test data with:
```
php artisan db:seed TestDataSeeder
```
It will create the following data structure:

- admin_1
  - teamlead_1_1
    - buyer_1_1_1
      - random_product_name
      - random_product_name
    - buyer_1_1_2
      - random_product_name
      - random_product_name
  - teamlead_1_2
    - buyer_1_2_1
      - random_product_name
      - random_product_name
    - buyer_1_2_2
      - random_product_name
      - random_product_name
- admin_2
  - teamlead_2_1
    - buyer_2_1_1
      - random_product_name
      - random_product_name
    - buyer_2_1_2
      - random_product_name
      - random_product_name
  - teamlead_2_2
    - buyer_2_2_1
      - random_product_name
      - random_product_name
    - buyer_2_2_2
      - random_product_name
      - random_product_name

All users have a "password" as a password.

9. Create an app secret key:
```
php artisan key:generate
```

10. Change ```storage``` directory owner to ```www-data```:
```
chown -R www-data:www-data storage
```
Done.

## Usage

Service REST API is available now at http://localhost/api.

Swagger OpenAPI documentation at http://localhost/api/documentation.

## API usage examples

### Auth - Sign in
```
// Request

[POST] /api/auth/sign-in
{
  "login": "root",
  "password": "password"
}

// Response

200: OK
{
  "data": {
    "user": {
      "id": 1,
      "login": "root",
      "role": "root",
      "superior_id": null,
      "created_at": "2024-01-01 00:00:00",
      "updated_at": "2024-01-01 00:00:00"
    },
    "token": "1|YNvY0AOVay35lpOWvoDUl97m74uQnx4RvOMv4uUh8bea40ff"
  }
}
```

### Auth - Sign out

```
// Reuqest

[POST] /api/auth/sign-out

// Response

204: No Content
```

### Users - Index Users

```
// Request

[GET] /api/users?superior_id=2&per_page=2&page=1


// Response

200: OK
{
  "data": [
    {
      "id": 3,
      "login": "teamlead_1_1",
      "role": "teamlead",
      "superior_id": 2,
      "created_at": "2024-01-01 00:00:00",
      "updated_at": "2024-01-01 00:00:00"
    },
    {
      "id": 6,
      "login": "teamlead_1_2",
      "role": "teamlead",
      "superior_id": 2,
      "created_at": "2024-01-01 00:00:00",
      "updated_at": "2024-01-01 00:00:00"
    }
  ],
  "meta": {
    "total": 2,
    "from": 1,
    "to": 2,
    "per_page": 2,
    "current_page": 1,
    "last_page": 1
  }
}
```

### Users - Create User

```
// Request

[POST] /api/users
{
  "login": "user",
  "password": "password",
  "superior_id": 2
}

// Response

201: Created
{
  "data": {
    "id": 16,
    "login": "user",
    "role": "teamlead",
    "superior_id": 2,
    "created_at": "2024-01-01 00:00:00",
    "updated_at": "2024-01-01 00:00:00"
  }
}
```

### Users - Show User

```
// Request

[GET] /api/users/16

// Response

200: OK
{
  "data": {
    "id": 16,
    "login": "user",
    "role": "teamlead",
    "superior_id": 2,
    "created_at": "2024-01-01 00:00:00",
    "updated_at": "2024-01-01 00:00:00"
  }
}
```

### Users - Update User

```
// Request

[PATCH] /api/users/16
{
  "login": "updated_user",
  "password": "updated_password",
  "superior_id": 1
}

// Response

200: OK
{
  "data": {
    "id": 16,
    "login": "updated_user",
    "role": "admin",
    "superior_id": 1,
    "created_at": "2024-01-01 00:00:00",
    "updated_at": "2024-01-01 00:00:00"
  }
}
```

### Users - Delete User

```
// Request

[POST] /api/users/16

// Response

204: No Content
```

### Products - Index Products

```
// Request

[GET] api/products?owner_id=4&per_page=2&page=1

// Response

200: OK
{
  "data": [
    {
      "id": 1,
      "title": "vitae",
      "description": "Provident dolores exercitationem quasi ipsa quia rerum.",
      "price": 24.3,
      "owner_id": 4,
      "created_at": "2024-01-01 00:00:00",
      "updated_at": "2024-01-01 00:00:00"
    },
    {
      "id": 2,
      "title": "culpa",
      "description": "Ullam aut ab id ut.",
      "price": 45.85,
      "owner_id": 4,
      "created_at": "2024-01-01 00:00:00",
      "updated_at": "2024-01-01 00:00:00"
    }
  ],
  "meta": {
    "total": 2,
    "from": 1,
    "to": 2,
    "per_page": 2,
    "current_page": 1,
    "last_page": 1
  }
}
```

### Products - Create Product

```
// Request

[POST] /api/products
{
  "title": "New Product",
  "description": "New Product Description",
  "price": 99.99
}

// Response

201: Created
{
  "data": {
    "id": 17,
    "title": "New Product",
    "description": "New Product Description",
    "price": 99.99,
    "owner_id": 4,
    "created_at": "2024-01-01 00:00:00",
    "updated_at": "2024-01-01 00:00:00"
  }
}
```

### Products - Show Product

```
// Request

[GET] /api/products/17

// Response

200: OK
{
  "data": {
    "id": 17,
    "title": "New Product",
    "description": "New Product Description",
    "price": 99.99,
    "owner_id": 4,
    "created_at": "2024-01-01 00:00:00",
    "updated_at": "2024-01-01 00:00:00"
  }
}
```

### Products - Update Product

```
// Request

[PATCH] /api/products/17
{
  "title": "Updated Product",
  "description": "Updated Product Description",
  "price": 88.88
}

// Response

200: OK
{
  "data": {
    "id": 17,
    "title": "Updated Product",
    "description": "Updated Product Description",
    "price": 88.88,
    "owner_id": 4,
    "created_at": "2024-01-01 00:00:00",
    "updated_at": "2024-01-01 00:00:00"
  }
}
```

### Products - Delete Product

```
// Request

[DELETE] /api/products/17

// Response

204: No Content
```