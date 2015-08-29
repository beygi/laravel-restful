## Laravel RESTful skeleton

**it's a simple skeleton for my laravel projects based on RESTful api and [backbonejs](http://backbonejs.org/)**

it contains swagger integration [swaggervel](https://github.com/slampenny/Swaggervel) plus RESTful auth [jwt-auth](https://github.com/tymondesigns/jwt-auth) and a nice looking admin area  [sleeping-owl admin](https://github.com/sleeping-owl/admin)



**installation**

clone this repository and run ```./init.sh```

this script generate new keys and create a new ```.env``` file from sample and open it with your favorite editor. you should change the configurations and put your database credentials in it and close your editor . then migrations will be applied and
you will be confirmed for creating new administrator user and done :)

**usage**

you can see swagger interface at ```http://localhost:8000/api-docs```
and admin area at ```http://localhost:8000/admin/login```
