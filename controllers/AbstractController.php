<?php
    abstract class AbstractController
    {
        protected string $template;
        protected array $data;

        public function render(string $view, array $values) : void
        {
            $this->template = $view;
            $this->data = $values;

            require 'views/layout.phtml';
        }

        public function renderAdmin(string $view, array $values) : void
        {
            $this->template = $view;
            $this->data = $values;

            require 'views/admin/dashboard.phtml';
        }
        public function renderUser(string $view, array $values) : void
        {
            $this->template = $view;
            $this->data = $values;

            require 'views/user/dashboard.phtml';
        }
    }
?>