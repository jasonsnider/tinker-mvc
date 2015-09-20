# Welcome to the App directory.

This is your applications entry point. By using mod rewrite and pretty URLs all
requests to you application will be resolved through the webroot directory. Any
files that exist in the webroot directory will be accessed as normal, anything
that does not exist will be treated as an MVC request and routed through 
index.php.

App
    config
        bootstrap.php
        configure.php
        containers.php
    plugin
        Application
    vendor
    webroot

App/config

    This contains startup and configuration files. Any part of the start up 
process that is intended to be available for change will be defined in on of 
these files.

App/plugin

    TinkerMVC assumes a plugin driven application, all new plugins go here. If
you do not want to create plugins you could use the default Application plugin
as a starting point and build everything there, though I do not suggest doing
so.

App/src/Controller/AppController.php

    The intent is for this to provide site wide functionality. For instance, you
might use this to implement an authentication scheme. Telling your controllers
to extend from this would allow them to inherit that scheme.

App/vendor

    Provides a location for any Vendor libraries you may want to use.

webroot
   
    Your applications entry point. Any requests that match a file in this 
directory will be given direct access. Any request that do not match a file in
this directory will be routed through index.php.
