Tinker MVC
==========

An experimental framework to help me better understand various design concepts.

Goals
------
* Fast, Lightweight, Minimalist
* PSR Compliance 
* DI/IoC
* MVC
* Pluggable
* Themable
* Pretty URLs
* Test Driven Design

Set Up
------

Set a vhost so that it will point do the webroot directory.


### Dispatching and Routing. 

For example the URL http://example.com/something/main/view/5606/user:1/

1. Plugin: Something
1. Controller: Main
1. Action: view
1. 5506 would be the same as $_GET['5506'] = true
1. user:1 would would be the same as $_GET['user'] = 1