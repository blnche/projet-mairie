<?php
    class CafeteriaDateManager extends AbstractManager
    {
        private ChildManager $childManager;

        public function __construct()
        {
            parent::__construct();
            $this->childManager = new ChildManager();
        }


    }
?>