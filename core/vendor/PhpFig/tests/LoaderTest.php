<?php

class MockLoader extends \PhpFig\Loader
{

    protected $files = array();

    public function setFiles(array $files)
    {
        $this->files = $files;
    }

    protected function requireFile($file)
    {
        return in_array($file, $this->files);
    }

    public function getLoadMappedFile($class)
    {

        // the current namespace prefix
        $prefix = $class;

        $pos = strrpos($prefix, '\\');
        // retain the trailing namespace separator in the prefix
        $prefix = substr($class, 0, $pos + 1);

        // the rest is the relative class name
        $relativeClass = substr($class, $pos + 1);

        return $this->loadMappedFile($prefix, $relativeClass);
    }

    public function getRequireFile($file)
    {
        return $this->requireFile($file);
    }

}

class MockLoader1 extends \PhpFig\Loader
{

    public function getRequireFile($file)
    {
        return $this->requireFile($file);
    }

}

class LoaderTest extends \PHPUnit_Framework_TestCase
{

    protected $loader;

    protected function setUp()
    {

        $this->loader = new MockLoader;

        $this->loader->register();

        $this->loader->setFiles(array(
            '/vendor/foo.bar/src/ClassName.php',
            '/vendor/foo.bar/src/DoomClassName.php',
            '/vendor/foo.bar/tests/ClassNameTest.php',
            '/vendor/foo.bardoom/src/ClassName.php',
            '/vendor/foo.bar.baz.dib/src/ClassName.php',
            '/vendor/foo.bar.baz.dib.zim.gir/src/ClassName.php',
        ));

        $this->loader->addNamespace(
            'Foo\Bar', '/vendor/foo.bar/src'
        );

        $this->loader->addNamespace(
            'Foo\Bar', '/vendor/foo.bar/tests'
        );

        $this->loader->addNamespace(
            'Foo\BarDoom', '/vendor/foo.bardoom/src'
        );

        $this->loader->addNamespace(
            'Foo\Bar\Baz\Dib', '/vendor/foo.bar.baz.dib/src'
        );

        $this->loader->addNamespace(
            'Foo\Bar\Baz\Dib\Zim\Gir', '/vendor/foo.bar.baz.dib.zim.gir/src'
        );
    }

    public function testAddNamespace()
    {

        $this->loader->addNamespace('Test', '/vendor/Test/src');

        $this->loader->addNamespace('AnotherTest', '/vendor/Test/src', true);

        $prefixes = $this->loader->getPrefixes();

        $this->assertSame($prefixes['Test\\'][0], '/vendor/Test/src/');
        $this->assertSame($prefixes['AnotherTest\\'][0], '/vendor/Test/src/');
    }

    public function testLoadMissingMappedFile()
    {
        //Test a class against an exisiting namesapce
        $noClass = 'Foo\Bar\NoClassName';
        $this->assertFalse($this->loader->getLoadMappedFile($noClass));

        //Test missing namespace
        $noNamespace = 'No_Vendor\No_Package\NoClass';
        $this->assertFalse($this->loader->getLoadMappedFile($noNamespace));

        //Test the inverse to make sure the mock logis is working
        $hasClass = 'Foo\Bar\ClassName';
        $this->assertSame(
            '/vendor/foo.bar/src/ClassName.php', $this->loader->getLoadMappedFile($hasClass)
        );
    }

    public function testRequireFile()
    {

        $ml = new MockLoader1();
        $this->assertTrue($ml->getRequireFile(ROOT . DS . 'core' . DS . 'vendor' . DS . 'PhpFig' . DS . 'requireFileTest'));
        $this->assertFalse($ml->getRequireFile('not_a_file'));
    }

    public function testExistingFile()
    {
        $actual = $this->loader->loadClass('Foo\Bar\ClassName');
        $expect = '/vendor/foo.bar/src/ClassName.php';
        $this->assertSame($expect, $actual);

        $actual = $this->loader->loadClass('Foo\Bar\ClassNameTest');
        $expect = '/vendor/foo.bar/tests/ClassNameTest.php';
        $this->assertSame($expect, $actual);
    }

    public function testMissingFile()
    {
        $actual = $this->loader->loadClass('No_Vendor\No_Package\NoClass');
        $this->assertFalse($actual);
    }

    public function testDeepFile()
    {
        $actual = $this->loader->loadClass('Foo\Bar\Baz\Dib\Zim\Gir\ClassName');
        $expect = '/vendor/foo.bar.baz.dib.zim.gir/src/ClassName.php';
        $this->assertSame($expect, $actual);
    }

    public function testConfusion()
    {
        $actual = $this->loader->loadClass('Foo\Bar\DoomClassName');
        $expect = '/vendor/foo.bar/src/DoomClassName.php';
        $this->assertSame($expect, $actual);

        $actual = $this->loader->loadClass('Foo\BarDoom\ClassName');
        $expect = '/vendor/foo.bardoom/src/ClassName.php';
        $this->assertSame($expect, $actual);
    }

}
