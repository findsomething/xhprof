<?php
/**
 * Created by PhpStorm.
 * User: lihan
 * Date: 16/9/15
 * Time: 20:17
 */
namespace FSth\XHProf;

class XHProf
{
    protected $name;
    protected $debug;
    protected $libPath;
    protected $url;
    protected $logger;

    public function __construct($name, $debug = false, array $config = array())
    {
        $this->name = $name;
        $this->debug = $debug;
        $this->setByConfig($config);
    }

    public function setLibPath($libPath)
    {
        $this->libPath = $libPath;
        return $this;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function setLogger($logger)
    {
        $this->logger = $logger;
        return $this;
    }

    public function start()
    {
        if ($this->debug) {
            xhprof_enable();
        }
    }

    public function stop()
    {
        if ($this->debug) {
            $data = xhprof_disable();
            $xhprofRuns = new \XHProfRuns_Default();
            $runId = $xhprofRuns->save_run($data, $this->name);
            $this->show($runId);
        }
    }

    public function init()
    {
        if ($this->debug && $this->libPath && $this->url && file_exists("{$this->libPath}xhprof_lib.php") &&
            file_exists("{$this->libPath}xhprof_runs.php")
        ) {
            include_once "{$this->libPath}xhprof_lib.php";
            include_once "{$this->libPath}xhprof_runs.php";

            xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
        } else {
            $this->debug = false;
        }
        return $this;
    }

    private function show($runId)
    {
        $showUrl = "{$this->url}index.php?run={$runId}&source={$this->name}";
        if ($this->logger) {
            $this->logger->info($showUrl);
        } else {
            echo "{$showUrl}\n";
        }
    }

    private function setByConfig(array $config)
    {
        if (!empty($config['libPath'])) {
            $this->libPath = $config['libPath'];
        }
        if (!empty($config['url'])) {
            $this->url = $config['url'];
        }
    }
}