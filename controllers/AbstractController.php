<?php
    abstract class AbstractController
    {
        protected string $template;
        protected array $data;
        protected string $pageTitle;
        protected string $folder;

        public function render(string $view, array $values, string $title, string $file = 'public') : void
        {
            $this->template = $view;
            $this->data = $values;
            $this->pageTitle = $title;
            $this->folder = $file;

            require "views/$file/layout.phtml";
        }
    }
?>