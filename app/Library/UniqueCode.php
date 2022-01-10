<?php

    namespace App\Library;

    class UniqueCode {

        private $model, $field, $prefix, $long, $codeDiff;

        public function __construct($model, $field, $prefix, $long, $codeDiff = null)
        {
            $this->model = $model;
            $this->field = $field;
            $this->prefix = $prefix;
            $this->long = $long;
            $this->codeDiff = $codeDiff;
        }

        public function get()
        {
            if($this->codeDiff == null) {
                $maxCode = $this->model::max($this->field);
            } else {
                $maxCode = $this->model::where($this->field, 'like', $this->prefix . '%')->max($this->field);
            }

            if($maxCode) {
                preg_match('!\d+!', $maxCode, $matches);
                $val = intval($matches[0]);
                $code = $this->prefix . str_pad($val + 1, $this->long, "0", STR_PAD_LEFT);
            } else {
                $code = $this->prefix . str_pad(1, $this->long, "0", STR_PAD_LEFT);
            }
            return $code;
        }

        public function dummy()
        {
            $maxCode = $this->model::max($this->field);

            if($maxCode) {
                preg_match('!\d+!', $maxCode, $matches);
                $val = intval($matches[0]);
                $code = $this->prefix . str_pad('X'  , $this->long, "0", STR_PAD_LEFT);
            } else {
                $code = $this->prefix . str_pad('X', $this->long, "0", STR_PAD_LEFT);
            }
            return $code;
        }

    }
