<?php
/**
 * Runtime variables 
 */
namespace Tinker;

/**
 * Names the plugin that holds the default theme.
 * 
 * @var string
 */
Configure::write('theme', 'Application');

/**
 * The default layout, this MUST in the theme being used.
 * 
 * @var string
 */
Configure::write('layout', 'default');

/**
 * The default plugin, if a request does not specify a plugin, this is the one
 * that will be used
 * 
 * @var string
 */
Configure::write('plugin', 'application');

/**
 * The default controller, if a request does not specify a controller, this is 
 * the one that will be used
 * 
 * @var string
 */
Configure::write('controller', 'application');
