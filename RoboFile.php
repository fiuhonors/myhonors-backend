<?php

/**
 * This is project's console commands configuration for Robo task runner.
 * @see http://robo.li/
 */

class RoboFile extends \Robo\Tasks
{
    
    private $filesToWatch;
    
    public function __construct() {
        $this->filesToWatch = ['MyHonors', 'tests', 'index.php'];
    }
    
    public function runUnitTest() 
    {
        $this->taskCodecept()
            ->suite('unit')
            ->run();
    }
    
    public function watchUnitTest() 
    {
        $this->taskWatch()
            ->monitor($this->filesToWatch, function () {
               $this->runUnitTest(); 
            })
            ->run();
    }
    
    public function runServer()
    {
        $this->taskServer(8000)
            ->run();
    }
    
    public function watchLint() 
    {
        $this->taskWatch()
            ->monitor($this->filesToWatch, function () {
                $this->_exec('./vendor/bin/parallel-lint' . 
                             ' --exclude vendor .');
            })
            ->run();
    }
    
}