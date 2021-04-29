**There are multiple methods to run this project, it also incldues docker enviroment(nginx + php + mysql), but can also be runned using classic XAMP(LAMP).**  
**In order to install application using dockers you will have to have the following:**
- docker version (>=20.10.5) and docker-compose version (>=1.29.0, build 07737305)
- run `docker network create build_network && docker-compose up -d` in order to build and make the dockers up and running
- after the installation of dockers is done run `docker exec -i novita_diamonds_php sh -c "cd novita_diamonds && composer install"` in order to install the project requirements
- run `docker exec -i novita_diamonds_php sh -c "cd novita_diamonds && php bin/console doctrine:database:create && php bin/console doctrine:migrations:migrate"` to create the database and run the migrations
- this is all now you will have a fully running application on localhost, just go ahead and open your browser of choice and type http://localhost and a symfony page will appear meaning that everything is ok
  
**In order to install application using XAMP(LAMP) prerequisites are:**
- PHP: ">=7.1.3"**
- Composer version ">=2.0.13"
If you have php installed run `composer install`. After the installation is done go in application folder modify _.env_ file with your database credentials. After run `php bin/console doctrine:database:create` _(if you have not created your database already)_ and `php bin/console doctrine:migrations:migrate` in order to run the migrations.

**Technology stack**
- PHP 8.0.3
- Symfony 4.4
- jQuery 3.6.0
- mySql 8.0.24
- NelmioApiDocBundle 4.x (OpenAPI 3.0 specification, formerly Swagger) - API documentation can be found at http://localhost/api/doc

**Application flow**:  

**1. Database**:  
- To update and mentain the database we use database migrations which are a way to safely update your database schema both locally and on production. Instead of running the doctrine:schema:update command or applying the database changes manually with SQL statements, migrations allow to replicate the changes in your database schema in a safe manner.  
- Migrations are available in Symfony applications via the DoctrineMigrationsBundle, which uses the external Doctrine Database Migrations library.  

**2. Request flow**:  
A request passes several steps untill it is considered to be finished. Every conversation on the web starts with a request. The request is a text message created by a client (e.g. a browser, a smartphone app, etc) in a special format known as HTTP. The client sends that request to a server, and then waits for the response.  
The URI (e.g. /, /contact, etc) is the unique address or location that identifies the resource the client wants. The HTTP method (e.g. GET) defines what the client wants to do with the resource. The HTTP methods (also known as verbs) define the few common ways that the client can act upon the resource - the most common HTTP methods are:  
GET  
Retrieve the resource from the server (e.g. when visiting a page);  
POST  
Create a resource on the server (e.g. when submitting a form);  
PUT/PATCH  
Update the resource on the server (used by APIs);  
DELETE  
Delete the resource from the server (used by APIs).  
Once a server has received the request, it knows exactly which resource the client needs (via the URI) and what the client wants to do with that resource (via the method). For example, in the case of a GET request, the server prepares the resource and returns it in an HTTP response.  
 
**3. Application components**:  
**Controller** - responsible for delegating actions to the _Service_  
**Service** - responsible to make a connection between _Controller_ and _Repository_  
**Repository** - represents the part that interacts with database  
**Envity** - an entity is an object that represent the underlying data. In Symfony, the entire model (the data tier) is persisted (saved, updated) and managed through Doctrine.
