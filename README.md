# laravel-multitenant-app-boilerplate
This is a boilerplate to create a multitenant app in laravel with docker setup also.

## Feature
### Admin 
- multitenant (each tenant has it's on DB schema)
- Admin user login (/login)
- Admin user registration (/register)
- Admin Dashboard (/home)
- Admin welcome Page
- Create Tenant and Domain through Laravel Tinker

### Tenant
- Each Tenant has it own Schema for data
- Each Tenant has a welcome page (Ex. http://foo.localhost:82/)
- Each Tenant has it's own Login Page
- Each Tenant has it own Register page
- Each Tenant has it own Dashboard page
- Each Tenant has it own Api routes (Ex. http://foo.localhost:82/api/users)

## Other Features 
- Run App with just one command (make dev-start)
- Hot reloading

## Usage
- RUN: git Clone git@github.com:williams9438/laravel-multitenant-app-boilerplate.git
- RUN: make dev-start
- create tenant and domain using the below code
    - RUN: make dev-artisan-tinker
    - RUN: $tenant1 = App\Models\Tenant::create(['id' => 'foo']);
    - RUN: $tenant1->domains()->create(['domain' => 'foo.localhost']);
    - Note: Afer creation the goto E.g http://foo.localhost:82/

![image description]tinker.png)

## Prerequisite
- Install Docker
- Install Docker compose

## Services
`This app contain Six (6) services to operate Namely:`
- nginx (webserver)
- php (the laravel service)
- postgres (Database)
- node (To run and compile Vue files)
- artisan (To run migrate and exit)
- redis (For caching)

`Note: All the above services is run with one command `



