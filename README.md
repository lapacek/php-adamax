# php-adamax

More than 10 years ago, inspired by my more experienced colleague, I build a web application MVC framework from scratch. I call it the Adamax framework.

## warning

This is just a naive implementation built for a learning purpose. This software should not be used in a production environment.

## motivation

I was learning MVC architectural patterns by that time. So just for fun, I decided to build my own `model-view-controller` style PHP framework from scratch.

## challenge

If I remember, the most challenging part was the design and implementation of the view. 
This should be a design exercise at first therefore building a templating engine was out of the scope of this project. 
For that reason, I recognized that the best solution would be a make an adapter that will allow a user of the framework to use some established templating engine.
I was testing that with the Twig templating engine which was a part of the Symphony PHP framework, one of the most popular PHP MVC frameworks at that time.

## model/data layer

The framework provides an adapter for the Doctrine 2 ORM framework, but it was also tested with the table gateway pattern implementation.

## prerequesities

* sqlite database for testing of Doctrine 2 wrapper
* Doctrine 2

## testing

Testing probably doesn`t work because there is dependency on Doctrine 2 ORM framework. This dependency is not currently solved before testing automaticaly.

```bash
$ make test
```
