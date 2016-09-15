<?php
/**
 * Created by PhpStorm.
 * User: lihan
 * Date: 16/9/15
 * Time: 20:40
 */
namespace FSth\XHProf\Tests;

use FSth\XHProf\XHProf;

class XHProfTest extends \PHPUnit_Framework_TestCase
{
    private $xhprof;
    private $name;

    public function setUp()
    {
        $config = include __DIR__ . "/../app/config.php";
        $this->name = "test";
        $this->xhprof = new XHProf($this->name, true);
//        $this->xhprof->setLibPath($config['lib'])
//            ->setUrl($config['url'])->init();
        $this->xhprof = new XHProf($this->name, true, array(
            'libPath' => $config['lib'],
            'url' => $config['url'],
        ));
        $this->xhprof->init();
    }

    public function testStart()
    {
        $this->xhprof->start();
        $this->somethingToRun();
        $this->xhprof->stop();
    }

    private function somethingToRun()
    {
        $a = [];
        $b = [];
        for ($i = 0; $i < 10000; $i++) {
            $a[] = $i;
            $b[] = $i % 100;
        }
        array_diff($a, $b);
    }
}