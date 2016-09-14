# Tinker MVC

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.txt)
[![Contributors](https://img.shields.io/badge/contributors-1-blue.svg?style=flat-square)](https://github.com/jasonsnider/tinker-mvc/graphs/contributors)
[![Build Status](https://travis-ci.org/jasonsnider/tinker-mvc.svg?branch=master)](https://travis-ci.org/jasonsnider/tinker-mvc)
[![Code Climate](https://codeclimate.com/github/jasonsnider/tinker-mvc/badges/gpa.svg)](https://codeclimate.com/github/jasonsnider/tinker-mvc)

An experimental framework to help me better understand various design concepts.

##Goals

* Fast, Lightweight, Minimalist
* PSR Compliance
* DI/IoC
* MVC
* Pluggable
* Themable
* Pretty URLs
* Test Driven Design

## Set Up

Configure apache so that it will point to the webroot directory.

### Dispatching and Routing.

For example the URL http://example.com/something/main/view/5606/user:1/

1. Plugin: Something
1. Controller: Main
1. Action: view
1. 5506 would be the same as $_GET['5506'] = true
1. user:1 would would be the same as $_GET['user'] = 1


## Versioning

I follow [The Semantic Versioning guidelines](http://semver.org/) but like
everything else, it is all in how you interpret the thing.

IMO git provides the version in the form of a commit hash so if your looking to
checkout version 0.5.1 look for that commit message on the master branch and
grab that commit. I only increment version numbers when I'm ready to push to
master so my last commit to dev prior to merging into master branch will always
have a commit message of 'Version x.x.x'.

* Major: breaking changes.
* Minor: new features; no breaking changes.
* Patch: bug fixes, formatting, comments, documentation, etc; no breaking changes.

At version 0.x.x all changes should be considered breaking.

My intent is to try to determine how risky an upgrade would be. Patch and minor
versions should be considered low risk upgrades while major version should be
considered high risk (so pay closer attention). If you change something that
is not considered __public__ then all bets are off.
